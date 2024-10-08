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

    public function index($idtopik): void
    {
        if (session()->get("logged_siswa") && session()->get("role") === 'R00003') {

            // Ambil subtopik berdasarkan $idtopik dari database
            $subtopics = $this->model->getAllW('subtopik', ['idtopik' => $idtopik])->getResult();

            $data['idtopik'] = $idtopik;

            // Kirim data subtopik ke view
            $data['subtopics'] = $subtopics;

            // Ambil nama topik berdasarkan $idtopik dari database
            $topik = $this->model->getAllW('topik', ['idtopik' => $idtopik])->getRow();
            $data['topik'] = $topik;

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

            $history_subs = $this->model->getAllQR("SELECT idsubs FROM users WHERE idusers = '" . session()->get("idusers") . "';")->idsubs;
            $data['showSessionMenu'] = $history_subs !== null;

            echo view('back/dashboardsiswa/head', $data);
            echo view('back/dashboardsiswa/subtopic', $data);
            echo view('back/dashboardsiswa/foot', $data);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }
}