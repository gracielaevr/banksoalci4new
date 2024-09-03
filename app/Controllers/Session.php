<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Session extends BaseController
{


    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }




    public function index()
    {

        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {


            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            $data['menu'] = $this->request->getUri()->getSegment(1);


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

            //Booking Remains
            $jml_booking = $this->model->getAllQR("SELECT count(*) as jml FROM history_session WHERE idusers = '" . session()->get("idusers") . "';")->jml;

            $data_booking = $this->model->getAllQ("SELECT * FROM history_session WHERE idusers = '" . session()->get("idusers") . "';")->getResult();
            $data['data_booking'] = $data_booking;


            $sesi = $this->model->getAllQ("SELECT sesi FROM history_subscribe WHERE idusers = '" . session()->get("idusers") . "';")->getRow()->sesi;
            $data['sesi'] = $sesi;

            $remaining_sessions = $sesi - $jml_booking;
            $data['remaining_sessions'] = $remaining_sessions;

            //Upcoming Session
            $upcoming = $this->model->getAllQ("SELECT idkonsultasi FROM history_session WHERE idusers = '" . session()->get("idusers") . "';")->getResult();

            $idkonsultasiArray = [];
            foreach ($upcoming as $item) {
                $idkonsultasiArray[] = $item->idkonsultasi;
            }

            if (!empty($idkonsultasiArray)) {
                $now = date('H:i:s');
                $today = date('Y-m-d');
                // Buat string dari array untuk digunakan di query
                $idkonsultasiList = implode("','", $idkonsultasiArray);

                $data_upcoming = $this->model->getAllQ("SELECT *, DATE_FORMAT(ADDTIME(waktu, SEC_TO_TIME(durasi * 3600)), '%H:%i') AS waktu_akhir FROM konsultasi WHERE idkonsultasi IN ('$idkonsultasiList') AND ((tanggal = '$today' AND waktu >= NOW())  -- Untuk sesi pada hari ini, hanya ambil yang lebih dari waktu sekarang
              OR (tanggal > '$today')  -- Untuk sesi di tanggal berikutnya, ambil apa pun waktunya
          )
        ORDER BY tanggal, waktu  -- Urutkan berdasarkan tanggal dan waktu
        LIMIT 1  -- Hanya ambil 1 sesi yang pertama ditemukan
    ")->getResult();


                // Session History
                $data_done = $this->model->getAllQ("SELECT *, DATE_FORMAT(ADDTIME(waktu, SEC_TO_TIME(durasi * 3600)), '%H:%i') AS waktu_akhir FROM konsultasi WHERE idkonsultasi IN ('$idkonsultasiList') 
            AND (
              (tanggal = '$today' AND waktu <= NOW())  -- Untuk sesi pada hari ini, hanya ambil yang lebih dari waktu sekarang
              OR (tanggal < '$today')  -- Untuk sesi di tanggal berikutnya, ambil apa pun waktunya
          )
            ORDER BY tanggal DESC  -- Urutkan berdasarkan tanggal
        ")->getResult();
            } else {
                $data_upcoming = [];
                $data_done = [];
            }

            $data['data_upcoming'] = $data_upcoming;
            $data['data_done'] = $data_done;


            echo view('back/dashboardsiswa/head', $data);
            echo view('back/dashboardsiswa/session', $data);
            echo view('back/dashboardsiswa/foot', $data);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }



    public function session_bokked()
    {
        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {


            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            $data['menu'] = $this->request->getUri()->getSegment(1);


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

            $today = date('Y-m-d');
            $status_booked = $this->model->getAllQ("SELECT idkonsultasi FROM history_session WHERE booked = '1' ");
            $booked_ids = [];
            foreach ($status_booked->getResult() as $row1) {
                $booked_ids[] = $row1->idkonsultasi;
            }
            $list = $this->model->getAllQ("SELECT * FROM konsultasi WHERE (
                (tanggal = '$today' AND waktu >= NOW())  -- Untuk sesi pada hari ini, hanya ambil yang lebih dari waktu sekarang
                OR (tanggal > '$today')  -- Untuk sesi di tanggal berikutnya, ambil apa pun waktunya
            )");

            $data['list'] = [];

            // Mendapatkan sesi pengguna
            $sesi = $this->model->getAllQ("SELECT sesi FROM history_subscribe WHERE idusers = '" . session()->get("idusers") . "';")->getRow()->sesi; // Mendapatkan sesi pengguna
            $jml_sesi = $this->model->getAllQR("SELECT count(*) as jml FROM history_session WHERE booked = '1';")->jml; // Jumlah sesi yang dibooking
            $data['sesi'] = $sesi;
            $data['jml_sesi'] = $jml_sesi;

            // Menampilkan semua sesi
            foreach ($list->getResult() as $row) {
                if (!in_array($row->idkonsultasi, $booked_ids)) {
                    $data['list'][] = $row;
                }
            }




            echo view('back/dashboardsiswa/session_bokked', $data);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }

    public function ajax_add()
    {
        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {

            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $pesan = $this->simpan_file();
                }
            } else {
                $pesan = $this->simpan();
            }
            echo json_encode(array("status" => $pesan));
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }

    private function simpan_file()
    {
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
            $status = "Gunakan nama file lain";
        } else {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                $data = array(
                    'idsession' => $this->model->autokode("S", "idsession", "history_session", 2, 7),
                    'idusers' => $this->request->getPost('idusers'),
                    'idkonsultasi' => $this->request->getPost('idkonsultasi'),
                    'guru' => $this->request->getPost('guru'),
                    'catatan' => $this->request->getPost('catatan'),
                    'tanggal' => $this->request->getPost('tanggal'),
                    'waktu' => $this->request->getPost('waktu'),
                    'pertanyaan' => $this->request->getPost('pertanyaan'),
                    // 'file' => $this->request->getPost('file'),
                    'file' => $fileName,
                    'booked' => 1
                );
                $this->model->add("history_session", $data);

                $status = "Data tersimpan";
            } else {
                $status = "File gagal terupload";
            }
        }
        return $status;
    }

    private function simpan()
    {
        $data = array(
            'idsession' => $this->model->autokode("S", "idsession", "history_session", 2, 7),
            'idusers' => $this->request->getPost('idusers'),
            'idkonsultasi' => $this->request->getPost('idkonsultasi'),
            'guru' => $this->request->getPost('guru'),
            'catatan' => $this->request->getPost('catatan'),
            'tanggal' => $this->request->getPost('tanggal'),
            'waktu' => $this->request->getPost('waktu'),
            'pertanyaan' => $this->request->getPost('pertanyaan'),
            // 'file' => $this->request->getPost('file'),
            'booked' => 1,
        );
        $simpan = $this->model->add("history_session", $data);
        if ($simpan == 1) {
            $status = "Data tersimpan";
        } else {
            $status = "Data gagal tersimpan";
        }
        return $status;
    }

    public function session_detail($idkonsultasi)
    {

        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            $data['menu'] = $this->request->getUri()->getSegment(1);


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

            $data['idkonsultasi'] = $idkonsultasi;
            $data_detail = $this->model->getAllQ("SELECT * FROM history_session WHERE idkonsultasi = '$idkonsultasi'")->getResult();
            $data['data_detail'] = $data_detail;

            foreach ($data_detail as $row) {
                $def_foto = base_url() . 'front/images/noimg.png';
                if (!is_null($row->file) && strlen($row->file)) {
                    if (file_exists($this->modul->getPathApp() . $row->file)) {
                        $def_foto = base_url() . '/uploads/' . $row->file;
                    }
                }

                // Buat variabel view untuk menampilkan file
                $row->file_display = ($row->file == '') ? '-' : '<img src="' . $def_foto . '" class="img-thumbnail" style="width: 120px; height: auto;">';
            }


            echo view('back/dashboardsiswa/session_detail', $data);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }
}