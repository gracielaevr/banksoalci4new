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

            $idusers = session()->get("idusers");

            $history_subs = $this->model->getAllQR(" SELECT status, tgl_berakhir, checkout_link FROM history_subscribe WHERE idusers = '" . $idusers . "' ");

            if ($history_subs !== NULL) {
                if ($history_subs->status === "Paid") {

                    $data['showSessionMenu'] = true;
                    session()->remove('notification_pending');

                    $data['idusers'] = session()->get("idusers");
                    $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
                    $def_foto = base_url() . 'front/images/noimg.png';
                    $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
                    if (strlen($foto) > 0) {
                        if (file_exists($this->modul->getPathApp() . $foto)) {
                            $def_foto = base_url() . '/uploads/' . $foto;
                        }
                    }
                    $data['foto_profile'] = $def_foto;
                    // Booking sessions
                    $jml_booking = $this->model->getAllQR("SELECT count(*) as jml FROM history_session WHERE idusers = '" . session()->get("idusers") . "';")->jml;
                    $data['data_booking'] = $this->model->getAllQ("SELECT * FROM history_session WHERE idusers = '" . session()->get("idusers") . "';")->getResult();
                    $sesi = $this->model->getAllQ("SELECT sesi FROM history_subscribe WHERE idusers = '" . session()->get("idusers") . "';")->getRow()->sesi;
                    $data['sesi'] = $sesi;
                    $data['remaining_sessions'] = $sesi - $jml_booking;

                    // Upcoming sessions
                    $upcoming = $this->model->getAllQ("SELECT idkonsultasi FROM history_session WHERE idusers = '" . session()->get("idusers") . "';")->getResult();
                    $idkonsultasiArray = array_column($upcoming, 'idkonsultasi');
                    if (!empty($idkonsultasiArray)) {
                        $idkonsultasiList = implode("','", $idkonsultasiArray);
                        $today = date('Y-m-d');

                        // Upcoming session query
                        $data_upcoming = $this->model->getAllQ("SELECT k.*, u.nama AS guru, DATE_FORMAT(ADDTIME(k.waktu, '00:25:00'), '%H:%i') AS waktu_akhir FROM konsultasi k JOIN users u ON u.idusers = k.idusers WHERE idkonsultasi IN ('$idkonsultasiList') AND ((k.tanggal = '$today' AND k.waktu >= NOW()) OR (k.tanggal > '$today')) ORDER BY k.tanggal, k.waktu LIMIT 1")->getResult();

                        $current_time = date('H:i:s'); // Mengambil waktu saat ini dalam format jam:menit:detik

                        $data_done = $this->model->getAllQ("SELECT k.*, u.nama AS guru, DATE_FORMAT(ADDTIME(k.waktu, '00:25:00'), '%H:%i') AS waktu_akhir 
        FROM konsultasi k JOIN users u ON u.idusers = k.idusers WHERE idkonsultasi IN ('$idkonsultasiList') AND ((k.tanggal = '$today' AND NOW() > ADDTIME(k.waktu, '00:25:00')) OR (k.tanggal < '$today')) ORDER BY k.tanggal DESC")->getResult();


                    } else {
                        $data_upcoming = [];
                        $data_done = [];
                    }
                    $data['data_upcoming'] = $data_upcoming;
                    $data['data_done'] = $data_done;
                    // Paket dan sesi details
                    $paketSubs = $this->model->getAllQR("SELECT paket, sesi, tgl_langganan, tgl_berakhir FROM history_subscribe WHERE idusers = '" . $idusers . "'");
                    $data['subs'] = $paketSubs;

                    $paketSesi = $paketSubs->sesi;
                    $paket = $paketSubs->paket;
                    $pakethabis = false;

                    // Check jika paket sudah berakhir ?
                    try {
                        $today = date("Y-m-d");
                        $tglBerakhir = date("Y-m-d", strtotime($paketSubs->tgl_berakhir));

                        $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik

                        // Menampilkan notifikasi jika paket sudah kedaluarsa
                        if ($diff < 0) {
                            $notificationMsg = "Your package has expired. Please renew your subscription to continue accessing the classes.";
                            session()->setFlashdata('notification_expired', $notificationMsg);
                            $pakethabis = true;
                        }
                    } catch (\Exception $e) {
                        // Tangani error jika terjadi masalah
                        echo "Error: " . $e->getMessage();
                    }

                    // Tentukan detail masa aktif berdasarkan sesi
                    $detail = '';
                    switch ($paketSesi) {
                        case '0':
                            $detail = 'Active Period: 1 day';
                            break;
                        case '1':
                            $detail = 'Active Period: 1 Week';
                            break;
                        case '4':
                            $detail = 'Active Period: 1 Month';
                            break;
                        case '8':
                            $detail = 'Active Period: 2.5 Months';
                            break;
                        case '15':
                            $detail = 'Active Period: 4 Months';
                            break;
                        default:
                            $detail = 'Active Period has expired';
                    }

                    // Data untuk view
                    $data['paket'] = $paket;
                    $data['detail'] = $detail;
                    $data['pakethabis'] = $pakethabis;

                    $instansi = session()->get("idinstansi");
                    $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL || $history_subs->status === 'Pending';
                    $data['free'] = $instansi === NULL && $history_subs === NULL || $history_subs->status === 'Pending' || $siswaluar_free;
                    if ($data['free'] === true) {
                        $notificationMsg = "You are currently using a free account. Please subscribe to gain access to all classes.";
                        session()->setFlashdata('notification_free', $notificationMsg);
                    }

                    echo view('page/dashboardsiswa/layout/head', $data);
                    echo view('page/dashboardsiswa/session', $data);
                    echo view('page/dashboardsiswa/layout/foot', $data);
                } else {
                    $this->modul->halaman('loginsiswa');
                }
            } else {
                $this->modul->halaman('loginsiswa');
            }

            if ($history_subs === null || $history_subs->status === 'Pending') {

                $data['showSessionMenu'] = false;
            }

        } else {
            $this->modul->halaman('loginsiswa');
        }
    }

    public function session_bokked()
    {

        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {

            $data["pro"] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
            $idusers = session()->get("idusers");
            $history_subs = $this->model->getAllQR(" SELECT status, tgl_berakhir, checkout_link FROM history_subscribe WHERE idusers = '" . $idusers . "' ");


            if ($history_subs !== NULL) {
                if ($history_subs->status === "Paid") {

                    $data['showSessionMenu'] = true;
                    session()->remove('notification_pending');

                    $data['idusers'] = session()->get("idusers");
                    $data['nama'] = session()->get("nama");
                    $data['role'] = session()->get("role");
                    $data['nm_role'] = session()->get("nama_role");

                    $data['menu'] = $this->request->getUri()->getSegment(1);

                    $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
                    // membaca foto profile
                    $def_foto = base_url() . 'front/images/noimg.png';
                    $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
                    if (strlen($foto) > 0) {
                        if (file_exists($this->modul->getPathApp() . $foto)) {
                            $def_foto = base_url() . '/uploads/' . $foto;
                        }
                    }
                    $data['foto_profile'] = $def_foto;

                    $pakethabis = false;
                    try {
                        $today = date("Y-m-d");
                        $tglBerakhir = date("Y-m-d", strtotime($history_subs->tgl_berakhir));

                        $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik
                        if ($diff < 0) {
                            $pakethabis = true;
                        }
                    } catch (\Exception $e) {
                        // Tangani error jika terjadi masalah
                        echo "Error: " . $e->getMessage();
                    }



                    $instansi = session()->get("idinstansi");
                    $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL;
                    $data['free'] = $instansi === NULL && $history_subs === NULL || $history_subs->status === 'Pending' || $siswaluar_free;
                    if ($data['free'] === true) {
                        $notificationMsg = "You are currently using a free account. Please subscribe to gain access to all classes.";
                        session()->setFlashdata('notification_free', $notificationMsg);
                    }

                    $data['pakethabis'] = $pakethabis;


                    echo view('page/dashboardsiswa/layout/head', $data);
                    echo view('page/dashboardsiswa/session_bokked', $data);
                    echo view('page/dashboardsiswa/layout/foot');
                } else {
                    $this->modul->halaman('loginsiswa');
                }

            } else {
                $this->modul->halaman('loginsiswa');
            }


            if ($history_subs === null || $history_subs->status === 'Pending') {
                $data['showSessionMenu'] = false;
                $notificationMsg = "Complete your payment, <b><a href='{$history_subs->checkout_link}' style='color:#fff'>click here</a></b>";
                session()->setFlashdata('notification_pending', $notificationMsg);
            }

        } else {
            $this->modul->halaman('loginsiswa');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {
            $today = date('Y-m-d');
            $status_booked = $this->model->getAllQ("SELECT idkonsultasi FROM history_session WHERE booked = '1'");
            $booked_ids = [];
            foreach ($status_booked->getResult() as $row1) {
                $booked_ids[] = $row1->idkonsultasi;
            }

            $data = array();
            $no = 1;
            $subs = $this->model->getAllQ("SELECT * FROM history_subscribe WHERE idusers = '" . session()->get("idusers") . "';")->getRow();
            $sesi = $this->model->getAllQ("SELECT sesi FROM history_subscribe WHERE idusers = '" . session()->get("idusers") . "'")->getRow()->sesi;
            $jml_sesi = $this->model->getAllQR("SELECT count(*) as jml FROM history_session WHERE booked = '1'")->jml;


            if ($subs->paket === "Local Package") {
                $user = $this->model->getAllQ("SELECT * FROM users WHERE idguru = 'G00001';")->getRow();

                // Pastikan $user tidak null sebelum mengakses idusers
                if ($user) {
                    $konsultasi = $this->model->getAllQ("
            SELECT * FROM konsultasi 
            WHERE idusers = '{$user->idusers}' 
            AND (
                (tanggal = '$today' AND waktu >= NOW())  -- Untuk sesi pada hari ini, hanya ambil yang lebih dari waktu sekarang
                OR (tanggal > '$today')  -- Untuk sesi di tanggal berikutnya, ambil apa pun waktunya
            )
        ")->getResult();

                    // Lakukan sesuatu dengan $konsultasi
                } else {
                    // Penanganan jika $user tidak ditemukan
                    echo "User dengan idguru = 'G00001' tidak ditemukan.";
                }
                foreach ($konsultasi as $row1) {
                    if (!in_array($row1->idkonsultasi, $booked_ids)) {

                        $val = array();
                        $val[] = $no;
                        $val[] = date('l, d F Y', strtotime($row1->tanggal));
                        $val[] = date('H:i', strtotime($row1->waktu));

                        if ($jml_sesi == $sesi) {
                            $val[] = '-';
                        } else {
                            $val[] = '<button class="badge badge-success2 border-0" onclick="openModal(\'' . $row1->idkonsultasi . '\', \'' . $row1->tanggal . '\', this)">Booking Now</button>';
                        }

                        $data[] = $val;
                        $no++;
                    }
                }

            } else if ($subs->paket === "International Package") {
                $user = $this->model->getAllQ("SELECT * FROM users WHERE idguru = 'G00002';")->getRow();

                // Pastikan $user tidak null sebelum mengakses idusers
                if ($user) {
                    $konsultasi = $this->model->getAllQ("
            SELECT * FROM konsultasi 
            WHERE idusers = '{$user->idusers}' 
            AND (
                (tanggal = '$today' AND waktu >= NOW())  -- Untuk sesi pada hari ini, hanya ambil yang lebih dari waktu sekarang
                OR (tanggal > '$today')  -- Untuk sesi di tanggal berikutnya, ambil apa pun waktunya
            )
        ")->getResult();

                    // Lakukan sesuatu dengan $konsultasi
                } else {
                    // Penanganan jika $user tidak ditemukan
                    echo "User dengan idguru = 'G00002' tidak ditemukan.";
                }
                foreach ($konsultasi as $row1) {
                    if (!in_array($row1->idkonsultasi, $booked_ids)) {

                        $val = array();
                        $val[] = $no;
                        $val[] = date('l, d F Y', strtotime($row1->tanggal));
                        $val[] = date('H:i', strtotime($row1->waktu));

                        if ($jml_sesi == $sesi) {
                            $val[] = '-';
                        } else {
                            $val[] = '<button class="badge badge-success2 border-0" onclick="openModal(\'' . $row1->idkonsultasi . '\', \'' . $row1->tanggal . '\', this)">Booking Now</button>';
                        }

                        $data[] = $val;
                        $no++;
                    }
                }
            }


            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }



    public function ajaxlist2()
    {
        $idusers = session()->get("idusers");

        // Mendapatkan jumlah sesi yang sudah dibooking
        $jml_booking = $this->model->getAllQR("SELECT count(*) as jml FROM history_session WHERE idusers = '" . $idusers . "';")->jml;
        // Mendapatkan data booking
        $data_booking = $this->model->getAllQ("SELECT * FROM history_session WHERE idusers = '" . $idusers . "';")->getResult();
        // Mendapatkan sesi total pengguna
        $sesi = $this->model->getAllQ("SELECT sesi FROM history_subscribe WHERE idusers = '" . $idusers . "';")->getRow()->sesi;
        // Hitung sesi yang tersisa
        $remaining_sessions = $sesi - $jml_booking;

        $data = array();
        $no = 1;
        date_default_timezone_set('Asia/Jakarta'); // Set zona waktu
        $current_datetime = date('Y-m-d H:i');
        // Menyusun data booking
        foreach ($data_booking as $booking) {
            $val = array();
            $val[] = $no;
            $tgl = $this->model->getAllQ("SELECT * FROM konsultasi WHERE idkonsultasi = '" . $booking->idkonsultasi . "';")->getRow();
            $val[] = date('d F Y', strtotime($tgl->tanggal));
            $val[] = date('H:i', strtotime($tgl->waktu));

            // Menggabungkan tanggal dan waktu dari booking
            $booking_datetime = date('Y-m-d H:i', strtotime($tgl->tanggal . ' ' . $tgl->waktu));

            // Menambahkan 25 menit ke waktu jadwal
            $booking_plus_25min = date('Y-m-d H:i', strtotime($booking_datetime . ' +25 minutes'));

            if ($current_datetime >= $booking_datetime && $current_datetime <= $booking_plus_25min) {
                $val[] = '<div class="badge badge-warning">Live session</div>';
            } elseif ($current_datetime > $booking_plus_25min) {
                $val[] = '<div class="badge badge-success">Completed</div>';
            } else {
                $val[] = '<div class="badge badge-info">Upcoming</div>';
            }
            $data[] = $val;
            $no++;
        }

        // Menyusun data sesi yang tersisa
        for ($i = 0; $i < $remaining_sessions; $i++) {
            $val = array();
            $val[] = $no;
            $val[] = '-';
            $val[] = '-';
            $val[] = '<div class="badge badge-danger text-center">Not Scheduled</div>';

            $data[] = $val;
            $no++;
        }

        // Output JSON untuk DataTables
        $output = array("data" => $data);
        echo json_encode($output);
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
                    // 'catatan' => $this->request->getPost('catatan'),
                    // 'tanggal' => $this->request->getPost('tanggal'),
                    // 'waktu' => $this->request->getPost('waktu'),
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
            // 'catatan' => $this->request->getPost('catatan'),
            // 'tanggal' => $this->request->getPost('tanggal'),
            // 'waktu' => $this->request->getPost('waktssu'),
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

    public function session_detail()
    {

        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {
            $data["pro"] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
            $idusers = session()->get("idusers");
            $history_subs = $this->model->getAllQR(" SELECT status, tgl_berakhir, checkout_link FROM history_subscribe WHERE idusers = '" . $idusers . "' ");


            if ($history_subs->status === "Paid") {
                $data['showSessionMenu'] = true;
                session()->remove('notification_pending');

                $data['idusers'] = session()->get("idusers");
                $data['nama'] = session()->get("nama");
                $data['role'] = session()->get("role");
                $data['nm_role'] = session()->get("nama_role");

                $data['menu'] = $this->request->getUri()->getSegment(1);

                $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
                // membaca foto profile
                $def_foto = base_url() . 'front/images/noimg.png';
                $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
                if (strlen($foto) > 0) {
                    if (file_exists($this->modul->getPathApp() . $foto)) {
                        $def_foto = base_url() . '/uploads/' . $foto;
                    }
                }
                $data['foto_profile'] = $def_foto;

                $pakethabis = false;
                try {
                    $today = date("Y-m-d");
                    $tglBerakhir = date("Y-m-d", strtotime($history_subs->tgl_berakhir));

                    $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik
                    if ($diff < 0) {
                        $pakethabis = true;
                    }
                } catch (\Exception $e) {
                    // Tangani error jika terjadi masalah
                    echo "Error: " . $e->getMessage();
                }



                $instansi = session()->get("idinstansi");
                $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL;
                $data['free'] = $instansi === NULL && $history_subs === NULL || $history_subs->status === 'Pending' || $siswaluar_free;
                if ($data['free'] === true) {
                    $notificationMsg = "You are currently using a free account. Please subscribe to gain access to all classes.";
                    session()->setFlashdata('notification_free', $notificationMsg);
                }

                $data['pakethabis'] = $pakethabis;



                $segment = $this->request->getUri()->getSegment(3);
                $id = isset($segment) ? $segment : '';
                $data['id'] = $id;
                echo view('page/dashboardsiswa/layout/head', $data);
                echo view('page/dashboardsiswa/session_detail', $data);
                echo view('page/dashboardsiswa/layout/foot', );
            } else {
                $this->modul->halaman('loginsiswa');
            }


            if ($history_subs === null || $history_subs->status === 'Pending') {
                $data['showSessionMenu'] = false;
                $notificationMsg = "Complete your payment, <b><a href='{$history_subs->checkout_link}' style='color:#fff'>click here</a></b>";
                session()->setFlashdata('notification_pending', $notificationMsg);
            }

        } else {
            $this->modul->halaman('loginsiswa');
        }
    }

    public function ajaxdetail()
    {
        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {
            $id = $this->request->getUri()->getSegment(3);
            $list = $this->model->getAllQ("
            SELECT hs.*, u.nama AS guru 
            FROM history_session hs 
            JOIN konsultasi k ON k.idkonsultasi = hs.idkonsultasi 
            JOIN users u ON u.idusers = k.idusers 
            WHERE k.idkonsultasi = '$id'
        ");

            $data = array();
            $no = 1;

            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $tgl = $this->model->getAllQ("SELECT * FROM konsultasi WHERE idkonsultasi = '" . $row->idkonsultasi . "';")->getRow();
                $val[] = date('l, d F Y', strtotime($tgl->tanggal));

                $val[] = date('H:i', strtotime($tgl->waktu));
                $val[] = $row->guru;

                $catatan = preg_replace(
                    '/(https?:\/\/[^\s]+)/',
                    '<a href="$1" target="_blank">$1</a>',
                    $tgl->catatan
                );

                // Cek file gambar
                $def_foto = base_url() . '/uploads/default.png'; // Gambar default
                if (!is_null($row->file) && strlen($row->file)) {
                    if (file_exists($this->modul->getPathApp() . $row->file)) {
                        $def_foto = base_url() . '/uploads/' . $row->file;
                    }
                }

                // Buat link klik dari pertanyaan
                $pertanyaan = preg_replace(
                    '/(https?:\/\/[^\s]+)/',
                    '<a href="$1" target="_blank">$1</a>',
                    $row->pertanyaan
                );
                // Tambahkan tombol untuk catatan ke array catatan
                $val[] = '<button class="btn btn-primary m-0" data-toggle="modal" data-target="#modalCatatan" data-catatan="' . htmlspecialchars($catatan) . '">Lihat Catatan</button>';

                // Gabungkan gambar dengan pertanyaan
                $pertanyaanContent = $pertanyaan . '<br><br>' . '<img src="' . $def_foto . '" class="img-thumbnail" style="width: 2000px; height: auto;">';

                // Tambahkan tombol untuk pertanyaan ke array pertanyaan
                $val[] = '<button class="btn btn-secondary m-0" data-toggle="modal" data-target="#modalPertanyaan" data-pertanyaan="' . htmlspecialchars($pertanyaanContent) . '">Lihat Pertanyaan</button>';

                $data[] = $val;
                $no++;
            }

            $output = array("data" => $data);
            echo json_encode($output);

        } else {
            $this->modul->halaman('loginsiswa');
        }
    }
}