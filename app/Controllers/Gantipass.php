<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Gantipass extends BaseController
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
            $data['role'] = session()->get("role");
            $idrole = session()->get("role");
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

            // membaca identitas
            $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            if ($jml_identitas > 0) {
                $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
                $data['alamat'] = $tersimpan->alamat;
                $data['tlp'] = $tersimpan->tlp;
                $data['fax'] = $tersimpan->fax;
                $data['website'] = $tersimpan->website;
                $deflogo = base_url() . '/images/noimg.jpg';
                if (strlen($tersimpan->logo) > 0) {
                    if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                        $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            } else {
                $data['alamat'] = "";
                $data['tlp'] = "";
                $data['fax'] = "";
                $data['website'] = "";
                $data['logo'] = base_url() . '/images/noimg.jpg';
            }

            echo view('back/head', $data);
            if ($idrole == "R00001") {
                echo view('back/menu');
            } elseif ($idrole == "R00002") {
                echo view('back/menu_guru');
            } else {
                $this->modul->halaman('login');
            }
            echo view('back/gantipass/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses()
    {
        if (session()->get("logged_in")) {
            $idusers = session()->get("idusers");
            // cek password lama
            $lama_db = $this->model->getAllQR("SELECT pass FROM users WHERE idusers = '" . $idusers . "';")->pass;
            $lama = $this->modul->enkrip_pass($this->request->getPost('lama'));
            if ($lama_db == $lama) {
                $data = array(
                    'pass' => $this->modul->enkrip_pass($this->request->getPost('baru'))
                );
                $kond['idusers'] = $idusers;
                $update = $this->model->update("users", $data, $kond);
                if ($update == 1) {
                    $status = "Password terupdate";
                } else {
                    $status = "Password gagal terupdate";
                }
            } else {
                $status = "Password tidak sesuai";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }
}
