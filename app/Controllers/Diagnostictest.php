<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Diagnostictest extends BaseController
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
        $data['kode'] = $this->modul->enkrip_url($kode);

        $nama = $this->model->getAllQR("select namabidang from bidang where idbidang = '" . $kode . "'")->namabidang;
        $data['bidang'] = $this->model->getAllQR("select namabidang from bidang where idbidang = '" . $kode . "'")->namabidang;
        $data['instruksi'] = $this->model->getAllQR("select instruksi from instruksi where idbidang = '" . $kode . "'")->instruksi;
        $data['jml'] = 10;

        echo view('page/beranda/layout/head');
        if ($nama == 'English') {
            echo view('page/beranda/diagnostik/index', $data);
        } else {
            echo view('page/beranda/diagnostik/indexexcel', $data);
        }
        echo view('page/beranda/layout/foot');
    }

    public function exam()
    {

        $kode = $this->request->getUri()->getSegment(3);
        $data['kode'] = $kode;

        $data['model'] = $this->model;
        $data['modul'] = $this->modul;

        // $r = array_rand(['d','mc','s','tf','mg']);
        $data['subtopik'] = $this->model->getAllQR("select nama from subtopik where idsubtopik = '" . $kode . "'")->nama;
        $data['topik'] = $this->model->getAllQR("select t.nama as nm from subtopik s, topik t where t.idtopik = s.idtopik and s.idsubtopik = '" . $kode . "'")->nm;
        $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' order by rand() limit 10");
        // jenis = '".$r."'
        echo view('page/beranda/layout/head');
        // if($r == 'mc'){


        // }
        echo view('page/beranda/exam/mc', $data);
        echo view('page/beranda/layout/foot');
    }

    public function narasi()
    {
        $kode = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $this->modul->enkrip_url($kode);

        $idn = $this->model->getAllQR("select idnarasi from subtopik s, narasi n where s.idsubtopik = n.idsubtopik and n.idsubtopik = '" . $kode . "' order by rand() limit 1")->idnarasi;

        $data['model'] = $this->model;
        $data['modul'] = $this->modul;

        $n = $this->model->getAllQR("select * from narasi where idnarasi = '" . $idn . "'");
        $data['subtopik'] = $this->model->getAllQR("select nama from subtopik where idsubtopik = '" . $n->idsubtopik . "'")->nama;
        $data['topik'] = $this->model->getAllQR("select t.nama as nm from subtopik s, topik t where t.idtopik = s.idtopik and s.idsubtopik = '" . $n->idsubtopik . "'")->nm;

        $data['narasi'] = $n->deskripsi;
        $data['soal'] = $this->model->getAllQ("select * from soal where idnarasi = '" . $idn . "' limit 5");

        echo view('page/beranda/layout/head');
        echo view('page/beranda/exam/narasi', $data);
        echo view('page/beranda/layout/foot');
    }

    public function done()
    {
        $kode = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;

        $data['score'] = $this->model->getAllQR("select * from pesertabtob where idpeserta = '" . $kode . "'")->poin;
        $data['idpeserta'] = $this->modul->enkrip_url($kode);
        $idsub = $this->model->getAllQR("select * from pesertabtob where idpeserta = '" . $kode . "'")->idbidang;
        $data['idsub'] = $this->modul->enkrip_url($idsub);

        $data['komentar'] = $this->model->getAllQ("select * from komentar where idbidang = '" . $idsub . "'");
        $bidang = $this->model->getAllQR("select namabidang from bidang where idbidang = '" . $idsub . "'")->namabidang;

        echo view('page/beranda/layout/head');
        if ($bidang == "English") {
            echo view('page/beranda/diagnostik/score', $data);
        } else {
            echo view('page/beranda/diagnostik/scoreexcel', $data);
        }
        echo view('page/beranda/layout/foot');
    }

    public function ajaxlist()
    {

        $kode = $this->request->getUri()->getSegment(3);

        $id = $this->request->getPost('query');
        $hasil = '';
        if ($id != '') {
            $list2 = $this->model->getAllQ("SELECT * FROM topik where nama like '%" . $id . "%';");
            $list = $this->model->getAllQ("SELECT t.nama as nt, s.nama as ns, idsubtopik FROM subtopik s, topik t where s.nama like '%" . $id . "%' and t.idtopik = s.idtopik;");
        } else {
            $list = $this->model->getAllQ("select * from subtopik where idtopik = '" . $kode . "'");
        }
        foreach ($list->getResult() as $row) {
            if ($id != '') {
                $hasil .= '<div class="col-sm-4">
                        <a href="' . base_url() . '/subtopic/start/' . $this->modul->enkrip_url($row->idsubtopik) . '" class="btn">' . $row->ns . '<br>Topic: ' . $row->nt . '</a>
                    </div>';
            } else {
                $hasil .= '<div class="col-sm-4">
                    <a href="' . base_url() . '/subtopic/start/' . $this->modul->enkrip_url($row->idsubtopik) . '" class="btn">' . $row->nama . '</a>
                </div>';
            }
        }
        if ($id != '') {
            foreach ($list2->getResult() as $row) {
                $hasil .= '<div class="col-sm-4">
                            <a href="' . base_url() . '/topic/subtopic/' . str_replace(' ', '-', $row->nama) . '" class="btn">' . $row->nama . '</a>
                        </div>';
            }
        }

        echo json_encode(array("status" => $hasil));
    }


    //TEST
    public function begin()
    {
        $kode = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));

        $data['kode'] = $kode;

        $data['model'] = $this->model;
        $data['modul'] = $this->modul;

        $idbidang = $this->model->getAllQR("select idbidang from pesertabtob where idpeserta = '" . $kode . "'")->idbidang;
        $data['bidang'] = $this->model->getAllQR("select idbidang, namabidang from bidang where idbidang = '" . $idbidang . "'");

        $data['soal'] = $this->model->getAllQ("select * from soaltest where idbidang = '" . $idbidang . "'");
        $data['jml'] = $this->model->getAllQR("select count(*) as jml from soaltest where idbidang = '" . $idbidang . "' and jenis = 'Soal'")->jml;

        $bidang = $this->model->getAllQR("select namabidang from bidang where idbidang = '" . $idbidang . "';")->namabidang;

        echo view('page/beranda/layout/head');
        if ($bidang == 'English') {
            echo view('page/beranda/diagnostik/mc', $data);
        } else {

            echo view('page/beranda/diagnostik/mcexcel', $data);
        }
        echo view('page/beranda/layout/foot');
    }

    public function process()
    {
        $id = $this->model->autokode("P", "idpeserta", "pesertabtob", 2, 7);

        $datape = array(
            'idpeserta' => $id,
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'instansi' => $this->request->getPost('instansi'),
            'email' => $this->request->getPost('email'),
            'nohp' => $this->request->getPost('tlp'),
            'idbidang' => $this->modul->dekrip_url($this->request->getUri()->getSegment(3))
        );

        $simpan = $this->model->add("pesertabtob", $datape);

        if ($simpan == 1) {
            $status = "ok";
        } else {

            $status = "Error";
        }

        echo json_encode(array("status" => $status, "id" => $this->modul->enkrip_url($id)));
    }

    public function finish()
    {

        $getid = $this->request->getPost('idpeserta');
        $data_soal = explode(",", $this->request->getPost('idsoal'));
        $data_ja = explode(",", $this->request->getPost('jawaban'));

        $listening = 0;
        $reading = 0;

        $bidang = $this->request->getPost('bidang');

        for ($i = 0; $i < count($data_soal); $i++) {

            if (strlen($data_soal[$i]) > 0) {
                $benar = 0;
                if ($data_ja[$i] == 'kosong') {
                    $j = $data_ja[$i];
                } else {
                    $j = $this->model->getAllQR("select * from pilihantest where idpilihan = '" . $data_ja[$i] . "';")->pilihan;
                }
                $cek = $this->model->getAllQ("select * from jawabantest where idsoal = '" . $data_soal[$i] . "';");

                foreach ($cek->getResult() as $row) {
                    if ($row->jawaban == $j) {
                        $benar = 1;
                        if ($bidang == 'English') {
                            $tipe = $this->model->getAllQR("select tipe from soaltest where idsoal = '" . $data_soal[$i] . "'")->tipe;
                            if ($tipe == 'Listening') {
                                $listening += 1;
                            } else {
                                $reading += 1;
                            }
                        }
                        break;
                    }
                }

                $tipe = null;
                if ($bidang == 'English') {
                    $tipe = $this->model->getAllQR("select tipe from soaltest where idsoal = '" . $data_soal[$i] . "'")->tipe;
                }

                if ($benar == 1) {
                    $hasil = 1;
                } else {

                    $hasil = 0;
                }

                $datap = array(
                    'idsp' => $this->model->autokode("A", "idsp", "jawaban_peserta_test", 2, 7),

                    'idpeserta' => $getid,
                    'idsoal' => $data_soal[$i],
                    'jawab' => $j,
                    'hasil' => $hasil,
                    'tipe' => $tipe
                );
                $this->model->add("jawaban_peserta_test", $datap);
            }
        }

        $nilai = 0;
        if ($bidang == "English") {

            $nlist = 0;
            $skor = $this->model->getAllQ("select * from scoring where tipe = 'Listening';");
            foreach ($skor->getResult() as $rows) {
                if ($rows->benar == $listening) {

                    $nlist = $rows->skor;
                }
            }

            $nread = 0;
            $skor2 = $this->model->getAllQ("select * from scoring where tipe = 'Reading';");
            foreach ($skor2->getResult() as $rowss) {
                if ($rowss->benar == $reading) {

                    $nread = $rowss->skor;
                }
            }

            $nilai = $nlist + $nread;
            $b = $listening + $reading;
        } else {
            $b = $this->model->getAllQR("select count(*) as jml from jawaban_peserta_test where hasil = 1 and idpeserta = '" . $getid . "'")->jml;
            $nilai = $b * 5;
        }
        $s = $this->model->getAllQR("select count(*) as jml from jawaban_peserta_test where hasil = 0 and idpeserta = '" . $getid . "'")->jml;


        $kond['idpeserta'] = $this->request->getPost('idpeserta');
        $datanilai = array(
            'benar' => $b,
            'salah' => $s,
            'poin' => $nilai,
            'status' => 1
        );

        $update = $this->model->update("pesertabtob", $datanilai, $kond);

        $ids = $this->modul->enkrip_url($getid);

        if ($update == 1) {
            $status = "ok";

            $status = "Error!";
        }

        echo json_encode(array("status" => $status, "ids" => $ids));
    }

    public function checkmail()
    {
        if (session()->get("logged_admin")) {
            $email = $this->model->getAllQR("select count(*) as jml from pesertabtob where email = '" . $this->request->getUri()->getSegment(3) . "'")->jml;
            if ($email > 1) {
                $status = "ada";
            } else {
                $status = "kosong";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }
}