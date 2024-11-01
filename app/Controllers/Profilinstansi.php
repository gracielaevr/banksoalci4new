<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Profilinstansi extends BaseController
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
        if (session()->get("logged_instansi")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca foto profile
            $def_foto = base_url() . 'front/images/noimg.png';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;



            echo view('back/head', $data);
            echo view('back/menu_instansi');
            echo view('back/profilinstansi/index', $data);
            echo view('back/foot');
        } else {
            $this->modul->halaman('logininstansi');
        }
    }

    public function proses()
    {
        if (session()->get("logged_instansi")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $status = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $status = $this->update_file();
                }
            } else {
                $status = $this->update();
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('logininstansi');
        }
    }

    private function update_file()
    {
        $idusers = session()->get("idusers");
        $lawas = $this->model->getAllQR("SELECT foto FROM users where idusers = '" . $idusers . "';")->foto;
        if (strlen($lawas) > 0) {
            if (file_exists($this->modul->getPathApp() . $lawas)) {
                unlink($this->modul->getPathApp() . $lawas);
            }
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
            $status = "Gunakan nama file lain";
        } else {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                $data = array(
                    'nama' => $this->request->getPost('nama'),
                    'wa' => $this->request->getPost('wa'),
                    'school_name' => $this->request->getPost('school_name'),
                    'foto' => $fileName
                );
                $kond['idusers'] = $idusers;
                $update = $this->model->update("users", $data, $kond);
                if ($update == 1) {
                    $status = "Data terupdate";
                } else {
                    $status = "Data gagal terupdate";
                }
            } else {
                $status = "File gagal terupload";
            }
        }
        return $status;
    }

    private function update()
    {
        $idusers = session()->get("idusers");
        $data = array(
            'nama' => $this->request->getPost('nama'),
            'wa' => $this->request->getPost('wa'),
            'school' => $this->request->getPost('school'),
        );
        $kond['idusers'] = $idusers;
        $update = $this->model->update("users", $data, $kond);
        if ($update == 1) {
            $status = "Data terupdate";
        } else {
            $status = "Data gagal terupdate";
        }
        return $status;
    }
}
