<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Logininstansi extends BaseController
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
        $cek = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
        if ($cek > 0) {
            $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
            $deflogo = base_url() . '/images/noimg.jpg';
            if (strlen($tersimpan->logo) > 0) {
                if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                    $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                }
            }
            $data['logo'] = $deflogo;
        } else {
            $data['logo'] = base_url() . '/images/noimg.jpg';
        }

        echo view('page/login/layout/head', $data);
        echo view('page/login/logininstansi', $data);
    }

    public function proses()
    {
        clearstatcache();

        $user = strtolower(trim($this->request->getPost('email')));
        $pass = trim($this->request->getPost('pass'));
        $enkrip_pass = $this->modul->enkrip_pass($pass);
        $jml = $this->model->getAllQR("SELECT count(*) as jml FROM users where email = '" . $user . "';")->jml;
        if ($jml > 0) {
            $jml1 = $this->model->getAllQR("select count(*) as jml from users where email = '" . $user . "' and pass = '" . $enkrip_pass . "';")->jml;
            if ($jml1 > 0) {
                $data = $this->model->getAllQR("select a.idusers, a.nama, a.idrole, a.email, a.idinstansi, a.school_name, b.nama_role from users a, role b where a.idrole = b.idrole and a.email = '" . $user . "';");
                if ($data->idrole == "R00004") {
                    //INSTANSI ADMIN
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'idinstansi' => $data->idinstansi,
                        'school_name' => $data->school_name,
                        // 'logged_in' => TRUE,
                        'logged_instansi' => TRUE
                    ]);
                    $pesan = "ok_instansi";
                } else {
                    $pesan = "You are not authorized to access!";
                }
            } else {
                $pesan = "Sorry, wrong password!";
            }
        } else {
            $pesan = "Sorry, email not found!";
        }
        echo json_encode(['status' => $pesan]);
    }

    public function logout()
    {
        session()->destroy();
        clearstatcache();

        $this->modul->halaman('logininstansi');
    }
}
