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
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            $data['menu'] = $this->request->getUri()->getSegment(1);

            //ambil history peserta
            $history_peserta = $this->model->getAllW('peserta', ['idusers' => $idusers])->getResult();
            if (!empty($history_peserta)) {
                $idsubtopik = $history_peserta[0]->idsubtopik;
                $subtopik_nama = $this->model->getAllW('subtopik', ['idsubtopik' => $idsubtopik])->getResult();
            } else {
                $subtopik_nama = [];
                $data['message'] = "Data Is Empty.";
            }

            $data['history_peserta'] = $history_peserta;
            $data['subtopik_nama'] = $subtopik_nama;

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
                $data['foto_profile'] = base_url() . 'front/images/noimg.png';
            }

            $history_subs = $this->model->getAllQR("SELECT idsubs FROM users WHERE idusers = '" . session()->get("idusers") . "';")->idsubs;
            $data['showSessionMenu'] = $history_subs !== null;


            echo view('back/dashboardsiswa/head', $data);
            echo view('back/dashboardsiswa/history', $data);
            echo view('back/dashboardsiswa/foot', $data);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }
}