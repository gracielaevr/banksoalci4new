<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class profilestudent extends BaseController
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
        if (session()->get("logged_in")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['email'] = session()->get("email");
            $data['wa'] = session()->get("wa");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            // Ambil jumlah pengguna dengan idusers tertentu dari database
            $jml_user = $this->model->getAllQR("SELECT count(*) as jml FROM users WHERE idusers = '" . session()->get("idusers") . "';")->jml;

            // Jika data user ditemukan
            if ($jml_user > 0) {
                // Ambil data user dari database
                $user = $this->model->getAllQR("SELECT * FROM users WHERE idusers = '" . session()->get("idusers") . "';");

                // Map data user ke variabel $data
                $data['idusers'] = $user->idusers;
                $data['nama'] = $user->nama;
                $data['email'] = $user->email;
                $data['wa'] = $user->wa;
                $data['idrole'] = $user->idrole;

                // membaca foto profile
                $def_foto = base_url() . 'front/images/noimg.png';
                $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
                if (strlen($foto) > 0) {
                    if (file_exists($this->modul->getPathApp() . $foto)) {
                        $def_foto = base_url() . '/uploads/' . $foto;
                    }
                }
                $data['foto_profile'] = $def_foto;
            } else {
                // Set nilai default jika user tidak ditemukan
                $data['idusers'] = "";
                $data['nama'] = "";
                $data['email'] = "";
                $data['wa'] = "";
                $data['idrole'] = "";
                $data['foto_profile'] = base_url() . '/images/noimg.jpg';
            }


            echo view('back/dashboardsiswa/profile/index', $data);
        } else {
            $this->modul->halaman('loginsiswa');
        }
    }

    public function proses()
    {
        if (session()->get("logged_in")) {
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
            $this->modul->halaman('login');
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
