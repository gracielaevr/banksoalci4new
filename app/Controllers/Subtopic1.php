<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;


class Subtopic1 extends BaseController
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
        $kode =  $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $this->modul->enkrip_url($kode);

        $data['idusers'] = session()->get("idusers");
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


        $subs = $this->model->getAllQR("select nama, narasi from subtopik where idsubtopik = '" . $kode . "'");
        $data['subtopik'] = $subs->nama;
        $data['topik'] = $this->model->getAllQR("select t.nama as nm from subtopik s, topik t where t.idtopik = s.idtopik and s.idsubtopik = '" . $kode . "'")->nm;
        $data['tot'] = $this->model->getAllQR("select count(*) as jml from soal where idsubtopik = '" . $kode . "'")->jml;


        $idusers = session()->get("idusers");
        $paketData = $this->model->getAllQR("SELECT paket, sesi, tgl_berakhir FROM history_subscribe WHERE idusers = '" . $idusers . "' AND tgl_berakhir >= CURDATE();");
        $data['subs'] = $paketData;

        if ($paketData) {
            $paketSesi = $paketData->sesi;
            $paket = $paketData->paket;

            // Check jika paket sudah berakhir ?
            try {
                $today = date("Y-m-d");
                $tglBerakhir = date("Y-m-d", strtotime($paketData->tgl_berakhir));

                $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik

                // Menampilkan notifikasi jika kurang dari 7 hari
                if ($diff <= 7 && $diff >= 1) {
                    $notificationMsg = "Your package will expire in $diff days. please renew before " . $paketData->tgl_berakhir . ".";
                    // Menyimpan notifikasi ke sesi atau menampilkan di view
                    session()->setFlashdata('notification', $notificationMsg);
                }

                // Menampilkan notifikasi jika paket sudah kedaluarsa
                if ($diff < 0) {
                    $notificationMsg = "Your package has expired. Please renew your subscription to continue accessing the classes.";
                    session()->setFlashdata('notification', $notificationMsg);
                    $pakethabis = true;
                }
            } catch (\Exception $e) {
                // Tangani error jika terjadi masalah
                echo "Error: " . $e->getMessage();
            }
        } else {
            $paketSesi = null;
            $paket = null;
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
        $school = addslashes(session()->get('school_name')) && session()->get("siswa_luar") === NULL;


        if ($school) {
            $jml_pengerjaan = $this->model->getAllQR("SELECT history_pengerjaan FROM users WHERE idusers = '" . $idusers . "' AND school_name = '" . $school . "';")->history_pengerjaan;

            $history_subs = $this->model->getAllQR("SELECT idsubs FROM users WHERE idusers = '" . $idusers . "';")->idsubs;

            $only3 = false;
            if ($jml_pengerjaan >= 3 && $history_subs === NULL) {
                $only3 = true;
            }

            // Mengirim variabel ke view
            $data['school'] = $school;
            $data['hanya3'] = $only3;
        } else {
            $data['school'] = null;
            $data['hanya3'] = false;
        }

        if ($subs->narasi == 1) {
            $data['jml'] = 5;
            echo view('page/dashboardsiswa/narasi', $data);
        } else {
            $data['jml'] = 10;
            echo view('page/dashboardsiswa/start', $data);
        }
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
                $hasil .= '<div class="col-12 col-md-4 col-lg-4 ">
                            <a href="' . base_url() . 'subtopic1/start/' . $this->modul->enkrip_url($row->idsubtopik) . '">
                              <div class="card shadow-leap2 mb-2">
                                    <div class="card-header-centered search-sub">
                                       <h5>' . $row->ns . '<br>Topic: ' . $row->nt . '</h5>
                                    </div>
                              </div>
                            </a>
                        </div>';
            } else {
                $hasil .= '<div class="col-12 col-md-4 col-lg-4 ">
                        <a href="' . base_url() . 'subtopic1/start/' . $this->modul->enkrip_url($row->idsubtopik) . '">
                        <div class="card shadow-leap2 mb-2">
                                    <div class="card-header-centered search-sub">
                                       <h5>' . $row->nama . '</h5>
                                    </div>
                              </div>
                        </a>
                    </div>';
            }
        }

        if ($id != '') {
            foreach ($list2->getResult() as $row) {
                $hasil .= '<div class="col-12 col-md-4 col-lg-4 ">
                            <a href="' . base_url() . 'homesiswa/subtopic/' . str_replace(' ', '-', $row->nama) . '">
                           <div class="card shadow-leap2 mb-2">
                                <div class="card-header-centered search-sub">
                                   <h5>' . $row->nama . '</h5>
                                </div>
                          </div>
                            </a>
                        </div>';
            }
        }


        echo json_encode(array("status" => $hasil));
    }
}
