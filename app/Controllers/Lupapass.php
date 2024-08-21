<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Lupapass extends BaseController
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
        echo view('back/lupa_password', $data);
    }

    public function proses()
    {
        $email = trim($this->request->getPost('email'));
        $jml = $this->model->getAllQR("SELECT count(*) as jml FROM users where email = '" . $email . "';")->jml;
        if ($jml > 0) {
            $pass = $this->model->getAllQR("SELECT pass FROM users where email = '" . $email . "';")->pass;
            $pesan = $this->kirimemail($email, "Your bank soal password", "Your password is " . $this->modul->dekrip_pass($pass));
        } else {
            $pesan = "Maaf, email tidak terdaftar!";
        }
        echo json_encode(array("status" => $pesan));
    }

    public function coba()
    {
        echo $this->kirimemail("graciela.ronadi12@gmail.com", "Kucing", "Percobaan");
    }

    private function kirimemail($to, $subject, $message)
    {
        $email = \Config\Services::email();
        $email->setTo($to);
        $email->setFrom('info@leapsurabaya.sch.id', 'English Leapverse - Bank Soal');

        $email->setSubject($subject);
        $email->setMessage($message);
        if ($email->send()) {
            $status = "Kata sandi berhasil dikirim ke email Anda. Jika Anda tidak menemukan pesan tersebut, silakan periksa spam";
        } else {
            $status = "Kata sandi gagal dikirim";
        }
        return $status;
    }
}