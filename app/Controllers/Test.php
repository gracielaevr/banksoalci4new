<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Test extends BaseController
{

    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function start()
    {
        $kode = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;

        $data['model'] = $this->model;
        $data['modul'] = $this->modul;

        $subs = $this->model->getAllQR("select nama, narasi from subtopik where idsubtopik = '" . $kode . "'");
        $data['subtopik'] = $subs->nama;
        $topik = $this->model->getAllQR("select t.idtopik, t.nama as nm from subtopik s, topik t where t.idtopik = s.idtopik and s.idsubtopik = '" . $kode . "'");
        $data['topik'] = $topik->nm;
        $data['idtopik'] = $topik->idtopik;
        $jenis = $this->model->getAllQR("select * from soal where idsubtopik = '" . $kode . "' order by rand() limit 1")->jenis;
        $data['jenis'] = $jenis;

        // echo view('front/head');
        echo view('page/beranda/layout/head');
        if ($subs->narasi == 1) {
            $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' order by rand() limit 10");
            echo view('page/beranda/exam/narasi', $data);
        } else if ($jenis == 'mg') {
            $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' and jenis = '" . $jenis . "'order by rand() limit 10");
            echo view('page/beranda/exam/mg', $data);
        } else if ($jenis == 'd') {
            $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' and jenis = '" . $jenis . "' order by rand() limit 10");
            echo view('page/beranda/exam/drop', $data);
        } else if ($jenis == 'mc') {
            $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' and jenis = '" . $jenis . "' order by rand() limit 10");
            echo view('page/beranda/exam/mc', $data);
        } else if ($jenis == 'tf') {
            $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' and jenis = '" . $jenis . "' order by rand() limit 10");
            echo view('page/beranda/exam/tf', $data);
        }

        // echo view('front/foot');
        echo view('page/beranda/layout/foot');
    }

    public function narasi()
    {
        $kode = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;

        $idn = $this->model->getAllQR("select idnarasi from subtopik s, narasi n where s.idsubtopik = n.idsubtopik and n.idsubtopik = '" . $kode . "' order by rand() limit 1")->idnarasi;

        $data['model'] = $this->model;
        $data['modul'] = $this->modul;

        $n = $this->model->getAllQR("select * from narasi where idnarasi = '" . $idn . "'");
        $data['subtopik'] = $this->model->getAllQR("select nama from subtopik where idsubtopik = '" . $n->idsubtopik . "'")->nama;
        $topik = $this->model->getAllQR("select t.idtopik, t.nama as nm from subtopik s, topik t where t.idtopik = s.idtopik and s.idsubtopik = '" . $kode . "'");
        $data['topik'] = $topik->nm;
        $data['idtopik'] = $topik->idtopik;

        $data['narasi'] = $n->deskripsi;
        $data['soal'] = $this->model->getAllQ("select * from soal where idnarasi = '" . $idn . "' limit 5");

        echo view('front/head');
        echo view('front/exam/narasi', $data);
        echo view('front/foot');
    }

    public function finish()
    {
        $ids = '';
        $data = array(
            'idpeserta' => $this->model->autokode("C", "idpeserta", "peserta", 2, 7),
            'nama' => 'Anonymous',
            'idtopik' => $this->request->getPost('idtopik'),
            'idsubtopik' => $this->request->getPost('idsubtopik'),
            'status' => 1,
        );
        $simpan = $this->model->add("peserta", $data);
        if ($simpan == 1) {
            $jenis = $this->request->getPost('jenis');

            if ($jenis == 'tf') {
                $ids = $this->true();
                $status = "ok";
            } else if ($jenis == 'd') {
                $ids = $this->dropdown();
                $status = "ok";
            } else if ($jenis == 'mg') {
                $ids = $this->grid();
                $status = "ok";
            } else if ($jenis == 'mc') {
                $ids = $this->multiple();
                $status = "ok";
            }
        } else {
            $status = "Error!";
        }

        echo json_encode(array("status" => $status, 'id' => $ids));
    }

    public function cobaa()
    {
        $data_soal = explode(",", $this->request->getPost('idsoal'));
        $data_ja = explode(",", $this->request->getPost('jawaban'));
        // $data_ja = $this->request->getPost('jawaban');

        $no = 0;
        for ($i = 0; $i < count($data_soal); $i++) {

            if (strlen($data_soal[$i]) > 0) {
                $getid = $this->model->getAllQR("select * from peserta order by idpeserta desc limit 1;")->idpeserta;
                $cek = $this->model->getAllQ("select * from jawaban where idsoal = '" . $data_soal[$i] . "';");
                $t = $this->model->getAllQR("select count(*) as jml from jawaban where idsoal = '" . $data_soal[$i] . "';")->jml;

                foreach ($cek->getResult() as $rows) {
                    // for ($x = 0; $x < count($djaw); $x++) {
                    if ($rows->jawaban == $data_ja[$no]) {
                        $datap = array(
                            'idsp' => $this->model->autokode("A", "idsp", "jawaban_peserta", 2, 7),
                            'idpeserta' => $getid,
                            'idsoal' => $data_soal[$i],
                            'jawab' => $data_ja[$no],
                            'hasil' => 1,
                        );
                        $update = $this->model->add("jawaban_peserta", $datap);
                    } else {
                        $datap = array(
                            'idsp' => $this->model->autokode("A", "idsp", "jawaban_peserta", 2, 7),
                            'idpeserta' => $getid,
                            'idsoal' => $data_soal[$i],
                            'jawab' => $data_ja[$no],
                            'hasil' => 0,
                        );

                        $update = $this->model->add("jawaban_peserta", $datap);
                    }
                    // }
                    // if($benar == $t){
                    //     break;
                    // }
                    $no++;
                }
            }
        }

        echo json_encode(array("status" => $update));
    }

    private function grid()
    {
        $getid = $this->model->getAllQR("select * from peserta order by idpeserta desc limit 1;")->idpeserta;
        $data_soal = explode(",", $this->request->getPost('idsoal'));
        $data_ja = explode(",", $this->request->getPost('jawaban'));

        $no = 0;
        $hasil = 0;
        for ($i = 0; $i < count($data_soal); $i++) {

            if (strlen($data_soal[$i]) > 0) {
                $cek = $this->model->getAllQ("select * from jawaban where idsoal = '" . $data_soal[$i] . "';");
                $t = $this->model->getAllQR("select count(*) as jml from jawaban where idsoal = '" . $data_soal[$i] . "';")->jml;

                foreach ($cek->getResult() as $rows) {
                    if ($rows->jawaban == $data_ja[$no]) {
                        $datap = array(
                            'idsp' => $this->model->autokode("A", "idsp", "jawaban_peserta", 2, 7),
                            'idpeserta' => $getid,
                            'idsoal' => $data_soal[$i],
                            'jawab' => $data_ja[$no],
                            'hasil' => 1,
                        );
                        $update = $this->model->add("jawaban_peserta", $datap);

                        if ($t > 1) {
                            $hasil += 5;
                        } else {
                            $hasil += 10;
                        }
                    } else {
                        $datap = array(
                            'idsp' => $this->model->autokode("A", "idsp", "jawaban_peserta", 2, 7),
                            'idpeserta' => $getid,
                            'idsoal' => $data_soal[$i],
                            'jawab' => $data_ja[$no],
                            'hasil' => 0,
                        );

                        $update = $this->model->add("jawaban_peserta", $datap);
                    }
                    $no++;
                }
            }
        }

        $b = $this->model->getAllQR("select count(*) as jml from jawaban_peserta where hasil = 1 and idpeserta = '" . $getid . "'")->jml;
        $s = $this->model->getAllQR("select count(*) as jml from jawaban_peserta where hasil = 0 and idpeserta = '" . $getid . "'")->jml;

        $kond['idpeserta'] = $getid;
        $datapeserta = array(
            'benar' => $b,
            'salah' => $s,
            'poin' => $hasil
        );
        $this->model->update("peserta", $datapeserta, $kond);

        $ids = $this->modul->enkrip_url($getid);

        return $ids;
    }

    private function multiple()
    {
        $getid = $this->model->getAllQR("select * from peserta order by idpeserta desc limit 1;")->idpeserta;
        $data_soal = explode(",", $this->request->getPost('idsoal'));
        $data_ja = explode(",", $this->request->getPost('jawaban'));

        for ($i = 0; $i < count($data_soal); $i++) {

            if (strlen($data_soal[$i]) > 0) {
                $benar = 0;
                $j = $this->model->getAllQR("select * from pilihan where idpilihan = '" . $data_ja[$i] . "';")->pilihan;
                $cek = $this->model->getAllQ("select * from jawaban where idsoal = '" . $data_soal[$i] . "';");

                foreach ($cek->getResult() as $row) {
                    if ($row->jawaban == $j) {
                        $benar = 1;
                        break;
                    }
                }
                if ($benar == 1) {
                    $hasil = 1;
                } else {
                    $hasil = 0;
                }

                $narasi = $this->model->getAllQR("select * from soal where idsoal = '" . $data_soal[$i] . "' limit 1;")->idnarasi;
                if ($narasi != '') {
                    $scoree = 20;
                } else {
                    $scoree = 10;
                }

                $datap = array(
                    'idsp' => $this->model->autokode("A", "idsp", "jawaban_peserta", 2, 7),
                    'idpeserta' => $getid,
                    'idsoal' => $data_soal[$i],
                    'jawab' => $j,
                    'hasil' => $hasil,
                );
                $this->model->add("jawaban_peserta", $datap);
            }
        }

        $b = $this->model->getAllQR("select count(*) as jml from jawaban_peserta where hasil = 1 and idpeserta = '" . $getid . "'")->jml;
        $s = $this->model->getAllQR("select count(*) as jml from jawaban_peserta where hasil = 0 and idpeserta = '" . $getid . "'")->jml;

        $kond['idpeserta'] = $getid;
        $datape = array(
            'benar' => $b,
            'salah' => $s,
            'poin' => $b * $scoree
        );
        $this->model->update("peserta", $datape, $kond);

        $ids = $this->modul->enkrip_url($getid);

        return $ids;
    }

    private function true()
    {
        $getid = $this->model->getAllQR("select * from peserta order by idpeserta desc limit 1;")->idpeserta;
        $data_soal = explode(",", $this->request->getPost('idsoal'));
        $data_ja = explode(",", $this->request->getPost('jawaban'));

        for ($i = 0; $i < count($data_soal); $i++) {

            if (strlen($data_soal[$i]) > 0) {
                $benar = 0;
                $cek = $this->model->getAllQ("select * from jawaban where idsoal = '" . $data_soal[$i] . "';");

                foreach ($cek->getResult() as $row) {
                    if ($row->jawaban == $data_ja[$i]) {
                        $benar = 1;
                        break;
                    }
                }

                if ($benar == 1) {
                    $hasil = 1;
                } else {
                    $hasil = 0;
                }

                $datap = array(
                    'idsp' => $this->model->autokode("A", "idsp", "jawaban_peserta", 2, 7),
                    'idpeserta' => $getid,
                    'idsoal' => $data_soal[$i],
                    'jawab' => $data_ja[$i],
                    'hasil' => $hasil,
                );
                $this->model->add("jawaban_peserta", $datap);
            }
        }

        $b = $this->model->getAllQR("select count(*) as jml from jawaban_peserta where hasil = 1 and idpeserta = '" . $getid . "'")->jml;
        $s = $this->model->getAllQR("select count(*) as jml from jawaban_peserta where hasil = 0 and idpeserta = '" . $getid . "'")->jml;

        $kond['idpeserta'] = $getid;
        $datape = array(
            'benar' => $b,
            'salah' => $s,
            'poin' => $b * 10
        );
        $this->model->update("peserta", $datape, $kond);

        $ids = $this->modul->enkrip_url($getid);

        return $ids;
    }

    private function dropdown()
    {
        $getid = $this->model->getAllQR("select * from peserta order by idpeserta desc limit 1;")->idpeserta;
        $data_soal = explode(",", $this->request->getPost('idsoal'));
        $data_ja = explode(",", $this->request->getPost('jawaban'));

        for ($i = 0; $i < count($data_soal); $i++) {

            if (strlen($data_soal[$i]) > 0) {
                $benar = 0;
                $j = $this->model->getAllQR("select * from pilihan where idpilihan = '" . $data_ja[$i] . "';")->pilihan;
                $cek = $this->model->getAllQ("select * from jawaban where idsoal = '" . $data_soal[$i] . "';");

                foreach ($cek->getResult() as $rows) {
                    if ($rows->jawaban == $j) {
                        $benar = 1;
                        break;
                    }
                }
                if ($benar == 1) {
                    $hasil = 1;
                } else {
                    $hasil = 0;
                }

                $datap = array(
                    'idsp' => $this->model->autokode("A", "idsp", "jawaban_peserta", 2, 7),
                    'idpeserta' => $getid,
                    'idsoal' => $data_soal[$i],
                    'jawab' => $j,
                    'hasil' => $hasil,
                );
                $this->model->add("jawaban_peserta", $datap);
            }
        }

        $b = $this->model->getAllQR("select count(*) as jml from jawaban_peserta where hasil = 1 and idpeserta = '" . $getid . "'")->jml;
        $s = $this->model->getAllQR("select count(*) as jml from jawaban_peserta where hasil = 0 and idpeserta = '" . $getid . "'")->jml;

        $kond['idpeserta'] = $getid;
        $datapeserta = array(
            'benar' => $b,
            'salah' => $s,
            'poin' => $b * 10
        );
        $this->model->update("peserta", $datapeserta, $kond);

        $ids = $this->modul->enkrip_url($getid);

        return $ids;
    }


    public function process()
    {
        $id = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));

        $kond['idpeserta'] = $id;

        $datape = array(
            'nama' => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'nohp' => $this->request->getPost('tlp')
        );
        $update = $this->model->update("peserta", $datape, $kond);

        if ($update == 1) {
            $status = "ok";
        } else {
            $status = "Error";
        }

        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_url($id)));
    }

    public function score()
    {
        $kode = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;

        $data['penutup'] = $this->model->getAllQR("select * from penutup limit 1")->deskripsi;
        $data['score'] = $this->model->getAllQR("select * from peserta where idpeserta = '" . $kode . "'")->poin;
        $data['idpeserta'] = $this->modul->enkrip_url($kode);
        $idsub = $this->model->getAllQR("select * from peserta where idpeserta = '" . $kode . "'")->idsubtopik;
        $data['idsub'] = $this->modul->enkrip_url($idsub);

        $hubungi = $this->model->getAllQR("select * from hubungi limit 1");
        $data['text'] = urlencode($hubungi->text);
        $data['wa'] = $hubungi->wa;

        // echo view('front/head');
        echo view('page/beranda/layout/head');
        echo view('page/beranda/score/index', $data);
        echo view('page/beranda/layout/foot');
    }

    public function subscribe()
    {
        echo view('page/beranda/layout/head');
        echo view('page/beranda/subscribe/index');
        echo view('page/beranda/layout/foot');
    }
}
