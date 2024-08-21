<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Identitas extends BaseController
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
        if (session()->get("logged_admin")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            $data['menu'] = $this->request->getUri()->getSegment(1);

            // membaca foto profile
            $def_foto = base_url() . '/images/noimg.jpg';
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
                $data['instansi'] = $tersimpan->instansi;
                $data['slogan'] = $tersimpan->slogan;
                $data['tahun'] = $tersimpan->tahun;
                $data['pimpinan'] = $tersimpan->pimpinan;
                $data['alamat'] = $tersimpan->alamat;
                $data['kdpos'] = $tersimpan->kdpos;
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
                $data['instansi'] = "";
                $data['slogan'] = "";
                $data['tahun'] = "";
                $data['pimpinan'] = "";
                $data['alamat'] = "";
                $data['kdpos'] = "";
                $data['tlp'] = "";
                $data['fax'] = "";
                $data['website'] = "";
                $data['logo'] = base_url() . '/images/noimg.jpg';
            }

            echo view('back/head', $data);
            echo view('back/menu');
            echo view('back/identitas/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses()
    {
        if (session()->get("logged_admin")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $pesan = $this->update_file();
                }
            } else {
                $pesan = $this->update();
            }
            echo json_encode(array("status" => $pesan));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function update_file()
    {
        // hapus file lama
        $lawas = $this->model->getAllQR("SELECT logo FROM identitas;")->logo;
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
                    'instansi' => $this->request->getPost('ins'),
                    'slogan' => $this->request->getPost('slogan'),
                    'tahun' => $this->request->getPost('tahun'),
                    'pimpinan' => $this->request->getPost('pimpinan'),
                    'alamat' => $this->request->getPost('alamat'),
                    'kdpos' => $this->request->getPost('kdpos'),
                    'tlp' => $this->request->getPost('tlp'),
                    'fax' => $this->request->getPost('fax'),
                    'website' => $this->request->getPost('website'),
                    'logo' => $fileName
                );
                $update = $this->model->updateNK("identitas", $data);
                if ($update == 1) {
                    $status = "Identitas terupdate";
                } else {
                    $status = "Identitas gagal terupdate";
                }
            } else {
                $status = "File gagal terupload";
            }
        }
        return $status;
    }

    private function update()
    {
        $data = array(
            'instansi' => $this->request->getPost('ins'),
            'slogan' => $this->request->getPost('slogan'),
            'tahun' => $this->request->getPost('tahun'),
            'pimpinan' => $this->request->getPost('pimpinan'),
            'alamat' => $this->request->getPost('alamat'),
            'kdpos' => $this->request->getPost('kdpos'),
            'tlp' => $this->request->getPost('tlp'),
            'fax' => $this->request->getPost('fax'),
            'website' => $this->request->getPost('website')
        );
        $update = $this->model->updateNK("identitas", $data);
        if ($update == 1) {
            $status = "Identitas terupdate";
        } else {
            $status = "Identitas gagal terupdate";
        }
        return $status;
    }
}