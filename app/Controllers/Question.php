<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Question extends BaseController
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
        if (session()->get("logged_siswa")) {

            $data['nama'] = session()->get("nama");
            $data['wa'] = session()->get("wa");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");


            $jml_user = $this->model->getAllQR("SELECT count(*) as jml FROM users WHERE idusers = '" . session()->get("idusers") . "';")->jml;

            if ($jml_user > 0) {
                $user = $this->model->getAllQR("SELECT * FROM users WHERE idusers = '" . session()->get("idusers") . "';");

                $data['idusers'] = $user->idusers;
                $data['nama'] = $user->nama;
                $data['email'] = $user->email;
                $data['wa'] = $user->wa;
                $data['idrole'] = $user->idrole;

                $def_foto = base_url() . 'front/images/noimg.png';
                $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
                if (strlen($foto) > 0) {
                    if (file_exists($this->modul->getPathApp() . $foto)) {
                        $def_foto = base_url() . '/uploads/' . $foto;
                    }
                }
                $data['foto_profile'] = $def_foto;
            } else {
                $data['idusers'] = "";
                $data['nama'] = "";
                $data['email'] = "";
                $data['wa'] = "";
                $data['idrole'] = "";
                $data['foto_profile'] = base_url() . '/images/noimg.jpg';
            }

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

            $idusers = session()->get('idusers');
            $school = addslashes(session()->get('school_name') && session()->get("siswa_luar") === NULL);
            if ($school === NULL) {
                $jml_pengerjaan = $this->model->getAllQR("SELECT history_pengerjaan FROM users WHERE idusers = '" . $idusers . "' AND school_name = '" . $school . "';")->history_pengerjaan;
            } else {
                $jml_pengerjaan = $this->model->getAllQR("SELECT history_pengerjaan FROM users WHERE idusers = '" . $idusers . "';")->history_pengerjaan;
            }

            $history_subs = $this->model->getAllQR(" SELECT idusers, tgl_berakhir FROM history_subscribe WHERE idusers = '" . $idusers . "' ");

            if ($history_subs !== null) {
                $data['showSessionMenu'] = true;
            }
            if ($history_subs === null) {
                $data['showSessionMenu'] = false;
            }
            // $school = session()->get("school_name");
            $instansi = session()->get("idinstansi");
            $data['free'] = $instansi === NULL && $history_subs === NULL;

            $newHistoryPengerjaan = $jml_pengerjaan + 1;

            $updateData = array(
                'history_pengerjaan' => $newHistoryPengerjaan,
            );
            $update = $this->model->update("users", $updateData, ['idusers' => $idusers]);

            // Pastikan update berhasil
            if ($update) {
                echo view('page/dashboardsiswa/question/head');
                if ($subs->narasi == 1) {
                    $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' order by rand() limit 10");
                    echo view('page/dashboardsiswa/question/narasi', $data);
                } else if ($jenis == 'mg') {
                    $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' and jenis = '" . $jenis . "'order by rand() limit 10");
                    echo view('page/dashboardsiswa/question/mg', $data);
                } else if ($jenis == 'd') {
                    $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' and jenis = '" . $jenis . "' order by rand() limit 10");
                    echo view('page/dashboardsiswa/question/drop', $data);
                } else if ($jenis == 'mc') {
                    $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' and jenis = '" . $jenis . "' order by rand() limit 10");
                    echo view('page/dashboardsiswa/question/mc', $data);
                } else if ($jenis == 'tf') {
                    $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' and jenis = '" . $jenis . "' order by rand() limit 10");
                    echo view('page/dashboardsiswa/question/tf', $data);
                }

                echo view('page/dashboardsiswa/question/foot');
            }
        } else {
            $this->modul->halaman('loginsiswa');
        }
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

        echo view('page/dashboardsiswa/question/head');
        echo view('page/dashboardsiswa/question/narasi', $data);
        echo view('page/dashboardsiswa/question/foot');
    }
    public function finish()
    {
        $ids = '';
        $data = array(
            'idpeserta' => $this->model->autokode("C", "idpeserta", "peserta", 2, 7),
            'nama' => $this->request->getPost('nama'),
            'idusers' => $this->request->getPost('idusers'),
            'email' => $this->request->getPost('email'),
            'nohp' => $this->request->getPost('wa'),
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

    public function score()
    {
        $idusers = session()->get("idusers");
        $data['idusers'] = session()->get("idusers");
        $data['nama'] = session()->get("nama");
        $data['role'] = session()->get("role");
        $data['nm_role'] = session()->get("nama_role");

        $data["pro"] = $this->model->getAllQR("select * from users where idusers = '" . session()->get("idusers") . "'");

        $def_foto = base_url() . 'front/images/noimg.png';
        $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
        if (strlen($foto) > 0) {
            if (file_exists($this->modul->getPathApp() . $foto)) {
                $def_foto = base_url() . '/uploads/' . $foto;
            }
        }
        $data['foto_profile'] = $def_foto;

        $kode = $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $kode;

        $data['penutup'] = $this->model->getAllQR("select * from penutup limit 1")->deskripsi;
        $data['score'] = $this->model->getAllQR("select * from peserta where idpeserta = '" . $kode . "'")->poin;
        $data['idpeserta'] = $this->modul->enkrip_url($kode);
        $idsub = $this->model->getAllQR("select * from peserta where idpeserta = '" . $kode . "'")->idsubtopik;
        $data['idsub'] = $this->modul->enkrip_url($idsub);

        $history_subs = $this->model->getAllQR(" SELECT status, tgl_berakhir, checkout_link FROM history_subscribe WHERE idusers = '" . $idusers . "' ");
        if ($history_subs !== NULL) {
            if ($history_subs->status === "Paid") {
                $data['showSessionMenu'] = true;
                session()->remove('notification_pending');
            } else {
                $notificationMsg = "Complete your payment, <b><a href='{$history_subs->checkout_link}' style='color:#fff'>click here</a></b>";
                session()->setFlashdata('notification_pending', $notificationMsg);

                $instansi = session()->get("idinstansi");
                $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL || $history_subs->status === 'Pending';
                $data['free'] = $instansi === NULL && $history_subs === NULL || $history_subs->status === 'Pending' || $siswaluar_free;
                if ($data['free'] === true) {
                    $notificationMsg = "You are currently using a free account. Please subscribe to access exclusive feature.";
                    session()->setFlashdata('notification_free', $notificationMsg);
                }
            }
        }
        if ($history_subs === null || $history_subs->status === 'Pending') {
            $data['showSessionMenu'] = false;

        }
        $instansi = session()->get("idinstansi");
        $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL;
        $data['free'] = $instansi === NULL && $history_subs === NULL || $siswaluar_free;




        // echo view('front/head');
        echo view('page/dashboardsiswa/score/index', $data);
        // echo view('front/foot');
    }
}