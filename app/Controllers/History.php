<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class History extends BaseController
{

    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function index(): void
    {
        if (session()->get("logged_siswa")) {

            $idusers = session()->get("idusers");
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

            $idusers = session()->get("idusers");
            $history_subs = $this->model->getAllQR(" SELECT status, tgl_berakhir, checkout_link FROM history_subscribe WHERE idusers = '" . $idusers . "' ");
            $pakethabis = false;
            if ($history_subs) {
                try {
                    $today = date("Y-m-d");
                    $tglBerakhir = date("Y-m-d", strtotime($history_subs->tgl_berakhir));

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

            if ($history_subs !== NULL) {
                if ($history_subs->status === "Paid") {
                    $data['showSessionMenu'] = true;
                    session()->remove('notification_pending');
                } else {

                    // $notificationMsg = "Complete your payment, <b><a href='{$history_subs->checkout_link}' style='color:#fff'>click here</a></b>";
                    // session()->setFlashdata('notification_pending', $notificationMsg);

                    // $instansi = session()->get("idinstansi");
                    // $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL || $history_subs->status === 'Pending';
                    // $data['free'] = $instansi === NULL && $history_subs === NULL || $history_subs->status === 'Pending' || $siswaluar_free;
                    // if ($data['free'] === true) {
                    //     $notificationMsg = "You are currently using a free account. Please subscribe to access exclusive feature.";
                    //     session()->setFlashdata('notification_free', $notificationMsg);
                    // }
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
            echo view('page/dashboardsiswa/history', $data);
            echo view('page/dashboardsiswa/layout/foot', $data);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }


    public function ajaxlist()
    {
        if (session()->get("logged_siswa")) {


            $idusers = session()->get("idusers");
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT * FROM peserta WHERE status = 1 AND idusers = '" . $idusers . "' ORDER BY created_at DESC;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->created_at;
                $subtopik = $this->model->getAllQR("SELECT nama FROM subtopik WHERE idsubtopik = '" . $row->idsubtopik . "'")->nama;
                $val[] = $subtopik;
                $val[] = $row->benar;
                $val[] = $row->salah;
                $val[] = '<div style="text-align: center;" class="d-flex justify-content-center align-items-center ms-3 me-3">'
                    . '<button type="button" class="badge badge-sm badge-success">' . $row->poin . '</button>&nbsp;'
                    . '</div>';


                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }
}