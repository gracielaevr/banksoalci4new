<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Homesiswa extends BaseController
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

            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
            $def_foto = base_url() . 'front/images/noimg.png';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;



            $siswa_luar = $this->model->getAllQR("SELECT siswa_luar FROM users WHERE idusers = '" . session()->get("idusers") . "';")->siswa_luar;
            $name_school = $this->model->getAllQR("SELECT school_name FROM users WHERE idusers = '" . session()->get("idusers") . "';")->school_name;

            $data['school_name'] = $name_school !== NULL && $siswa_luar === NULL;

            if (session()->get("idusers") && $name_school !== NULL && $siswa_luar === NULL) {

                $data['topik'] = $this->model->getAllQ('SELECT topik.*, COUNT(peserta.idtopik) as jumlah_peserta, 
                (SELECT COUNT(idsubtopik) FROM subtopik WHERE subtopik.idtopik = topik.idtopik) as jumlah_subtopik
                FROM topik
                LEFT JOIN peserta ON peserta.idtopik = topik.idtopik
                WHERE topik.school_name IS NULL AND topik.idinstansi IS NULL
                GROUP BY topik.idtopik ORDER BY RAND() LIMIT 1')->getResult();

                $school = session()->get("school_name");
                $instansi = session()->get("idinstansi");


                $data['topik_school'] = $this->model->getAllQ('SELECT topik.*, COUNT(peserta.idtopik) as jumlah_peserta, 
                (SELECT COUNT(idsubtopik) FROM subtopik WHERE subtopik.idtopik = topik.idtopik) as jumlah_subtopik
                FROM topik
                LEFT JOIN peserta ON peserta.idtopik = topik.idtopik
                WHERE topik.school_name = "' . $school . '" OR topik.idinstansi = "' . $instansi . '"
                GROUP BY topik.idtopik ')->getResult();

                // Query untuk mendapatkan subtopik berdasarkan idtopik
                $db = \Config\Database::connect();
                $subtopikBuilder = $db->table('subtopik');
                $subtopikQuery = $subtopikBuilder->get();
                $subtopikResult = $subtopikQuery->getResult();

                // Mengelompokkan subtopik berdasarkan idtopik
                $subtopikByTopik = [];
                foreach ($subtopikResult as $subtopik) {
                    $subtopikByTopik[$subtopik->idtopik][] = $subtopik;
                }

                $data['subtopikByTopik'] = $subtopikByTopik;
            } else {
                $data['topik'] = $this->model->getAllQ('SELECT topik.*, COUNT(peserta.idtopik) as jumlah_peserta, 
                (SELECT COUNT(idsubtopik) FROM subtopik WHERE subtopik.idtopik = topik.idtopik) as jumlah_subtopik
                FROM topik
                LEFT JOIN peserta ON peserta.idtopik = topik.idtopik
                WHERE topik.school_name IS NULL AND topik.idinstansi IS NULL
                GROUP BY topik.idtopik ORDER BY jumlah_peserta DESC')->getResult();


                // Query untuk mendapatkan subtopik berdasarkan idtopik
                $db = \Config\Database::connect();
                $subtopikBuilder = $db->table('subtopik');
                $subtopikQuery = $subtopikBuilder->get();
                $subtopikResult = $subtopikQuery->getResult();

                // Mengelompokkan subtopik berdasarkan idtopik
                $subtopikByTopik = [];
                foreach ($subtopikResult as $subtopik) {
                    $subtopikByTopik[$subtopik->idtopik][] = $subtopik;
                }

                $data['subtopikByTopik'] = $subtopikByTopik;
            }

            $idusers = session()->get("idusers");
            $history_subs = $this->model->getAllQR(" SELECT status, tgl_berakhir, checkout_link FROM history_subscribe WHERE idusers = '" . $idusers . "' ");
            $pakethabis = false;
            if ($history_subs) {
                try {
                    $today = date("Y-m-d");
                    $tglBerakhir = date("Y-m-d", strtotime($history_subs->tgl_berakhir));

                    $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik
                    if ($diff < 0) {
                        $pakethabis = true;
                    }
                } catch (\Exception $e) {
                    echo "Error: " . $e->getMessage();
                }
            }

            if ($history_subs !== NULL) {
                if ($history_subs->status === "Paid") {
                    $data['showSessionMenu'] = true;
                    session()->remove('notification_pending');
                } else {
                    $notificationMsg = "Please complete your payment to get all the feature acssess, <b><a href='{$history_subs->checkout_link}' style='color:#fff'>click here</a></b>";
                    session()->setFlashdata('notification_pending', $notificationMsg);
                    session()->remove('free');
                }
            }
            if ($history_subs === null || $history_subs->status === 'Pending') {
                $data['showSessionMenu'] = false;

            }
            $instansi = session()->get("idinstansi");
            $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL;
            $data['free'] = $instansi === NULL && $history_subs === NULL || $siswaluar_free;
            if ($data['free'] === true) {
                $notificationMsg = "You are currently using a free account. Please subscribe to access exclusive feature.";
                session()->setFlashdata('notification_free', $notificationMsg);
            }

            $data['pakethabis'] = $pakethabis;

            echo view('page/dashboardsiswa/layout/head', $data);
            echo view('page/dashboardsiswa/home', $data);
            echo view('page/dashboardsiswa/layout/foot', $data);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }

    public function subtopic(): void
    {
        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {

            $kode = $this->request->getUri()->getSegment(3);
            $judul = str_replace('-', ' ', $kode);

            $tot = str_word_count($judul);
            if ($tot > 1) {
                $pisah = explode(" ", $judul);
                $topik = $this->model->getAllQR("select nama, idtopik from topik where nama like '%" . $pisah[0] . "%' and nama like '%" . $pisah[1] . "%';");
            } else {
                $topik = $this->model->getAllQR("select nama, idtopik from topik where nama like '%" . $judul . "%';");
            }

            if (empty($topik->nama)) {
                $this->modul->halaman('404');
            } else {
                $data['topik'] = $topik->nama;
                $data['idtopik'] = $topik->idtopik;

                $data['idusers'] = session()->get("idusers");
                // $data['nama'] = session()->get("nama");
                $data['role'] = session()->get("role");
                $data['nm_role'] = session()->get("nama_role");
                $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
                $data['menu'] = $this->request->getUri()->getSegment(1);

                $def_foto = base_url() . 'front/images/noimg.png';
                $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
                if (strlen($foto) > 0) {
                    if (file_exists($this->modul->getPathApp() . $foto)) {
                        $def_foto = base_url() . '/uploads/' . $foto;
                    }
                }
                $data['foto_profile'] = $def_foto;
                $idusers = session()->get("idusers");
                $paketData = $this->model->getAllQR("SELECT paket, sesi, tgl_berakhir FROM history_subscribe WHERE idusers = '" . $idusers . "' AND tgl_berakhir >= CURDATE();");
                $pakethabis = false;
                if ($paketData) {
                    try {
                        $today = date("Y-m-d");
                        $tglBerakhir = date("Y-m-d", strtotime($paketData->tgl_berakhir));

                        $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik
                        $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik
                        if ($diff < 0) {
                            $pakethabis = true;
                        }
                    } catch (\Exception $e) {
                        // Tangani error jika terjadi masalah
                        echo "Error: " . $e->getMessage();
                    }
                }

                $history_subs = $this->model->getAllQR(" SELECT idusers, tgl_berakhir FROM history_subscribe WHERE idusers = '" . $idusers . "' ");
                if ($history_subs !== null) {
                    $data['showSessionMenu'] = true;
                }
                if ($history_subs === null) {
                    $data['showSessionMenu'] = false;
                }
                $instansi = session()->get("idinstansi");
                $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL;
                $data['free'] = $instansi === NULL && $history_subs === NULL || $siswaluar_free;
                if ($data['free'] === true) {
                    $notificationMsg = "You are currently using a free account. Please subscribe to gain access to all classes";
                    session()->setFlashdata('notification_free', $notificationMsg);
                }

                $data['pakethabis'] = $pakethabis;


                echo view('page/dashboardsiswa/layout/head', $data);
                echo view('page/dashboardsiswa/subtopic', $data);
                echo view('page/dashboardsiswa/layout/foot', $data);
            }
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }
}