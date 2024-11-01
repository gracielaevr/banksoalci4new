<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Register extends BaseController
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

        echo view('page/register/layout/head', $data);
        echo view('page/register/register', $data);
    }

    public function proses()
    {
        $data = array(
            'idusers' => $this->model->autokode("U", "idusers", "users", 2, 7),
            'nama' => $this->request->getPost('nama'),
            'email' => strtolower(trim($this->request->getPost('email'))),
            'wa' => $this->request->getPost('wa'),
            'school_name' => $this->request->getPost('school_name'),
            'pass' => $this->modul->enkrip_pass(trim($this->request->getPost('pass'))),
            'idrole' => 'R00003',
            'siswa_luar' => 1
        );
        if ($this->model->add('users', $data)) {
            $pesan = "User has been registered successfully!";
            $status = 200;
        } else {
            $pesan = "Some error occurred! Please try again.";
            $status = 500;
        }
        return $this->response->setJSON(['status' => $status, 'message' => $pesan]);
    }
}
