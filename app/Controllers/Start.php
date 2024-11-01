<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Start extends BaseController
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
        $kode =  $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $this->modul->enkrip_url($kode);
        $subs = $this->model->getAllQR("select nama, narasi from subtopik where idsubtopik = '" . $kode . "'");
        $data['subtopik'] = $subs->nama;
        $data['topik'] = $this->model->getAllQR("select t.nama as nm from subtopik s, topik t where t.idtopik = s.idtopik and s.idsubtopik = '" . $kode . "'")->nm;
        $data['tot'] = $this->model->getAllQR("select count(*) as jml from soal where idsubtopik = '" . $kode . "'")->jml;

        $idusers = session()->get("idusers");
        $paketData = $this->model->getAllQR("SELECT paket, sesi, tgl_berakhir FROM history_subscribe WHERE idusers = '" . $idusers . "' AND tgl_berakhir >= CURDATE();");
        if ($paketData) {
            try {
                $today = date("Y-m-d");
                $tglBerakhir = date("Y-m-d", strtotime($paketData->tgl_berakhir));

                $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik

                // Menampilkan notifikasi jika kurang dari 7 hari
                if ($diff <= 7 && $diff >= 1) {
                    $notificationMsg = "Your package will expire in $diff days. please renew before " . $paketData->tgl_berakhir . ".";
                    session()->setFlashdata('notification', $notificationMsg);
                }
                if ($diff <= 3 && $diff >= 1) {
                    session()->setFlashdata('box-subscribe', true);
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
        // $school = session()->get("school_name");
        $instansi = session()->get("idinstansi");
        $data['free'] = $instansi === NULL && $history_subs === NULL;


        if ($subs->narasi == 1) {
            $data['jml'] = 5;
            echo view('page/dashboardsiswa/narasi', $data);
        } else {
            $data['jml'] = 10;
            echo view('page/dashboardsiswa/start', $data);
        }
    }
}
