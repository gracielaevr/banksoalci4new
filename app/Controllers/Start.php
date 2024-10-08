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

    public function index($idsubtopik): void
    {
        if (session()->get("logged_siswa")) {
            $kondisi = ['idsubtopik' => $idsubtopik];
            $subtopicData = $this->model->get_by_id("subtopik", $kondisi);

            $idtopik = $subtopicData->idtopik;
            $kondisi2 =  ['idtopik' => $idtopik];
            $topikData = $this->model->get_by_id("topik", $kondisi2);

            $data['subtopik'] = $subtopicData;
            $data['topik'] = $topikData;
            $data['idtopik'] = $idtopik;


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


            echo view('back/dashboardsiswa/start', $data);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }
}
