<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Homesiswa extends BaseController
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
        $currentPage = 'Dashboard';
        $data['current_page'] = $currentPage;

        if (session()->get("logged_siswa")) {
            // Query untuk mendapatkan topik dan jumlah subtopik
            $db      = \Config\Database::connect();
            $builder = $db->table('topik');
            $builder->select('topik.*, COUNT(subtopik.idsubtopik) as jumlah_subtopik');
            $builder->join('subtopik', 'subtopik.idtopik = topik.idtopik', 'left');
            $builder->groupBy('topik.idtopik');
            $query = $builder->get();
            $data['topik'] = $query->getResult();

            // Query untuk mendapatkan subtopik berdasarkan idtopik
            $subtopikBuilder = $db->table('subtopik');
            $subtopikQuery = $subtopikBuilder->get();
            $subtopikResult = $subtopikQuery->getResult();

            // Mengelompokkan subtopik berdasarkan idtopik
            $subtopikByTopik = [];
            foreach ($subtopikResult as $subtopik) {
                $subtopikByTopik[$subtopik->idtopik][] = $subtopik;
            }

            $data['subtopikByTopik'] = $subtopikByTopik;

            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            $data['menu'] = $this->request->getUri()->getSegment(1);


            // membaca foto profile
            // $def_foto = base_url().'/images/noimg.jpg';
            // $foto = $this->model->getAllQR("select foto from users where idusers = '".session()->get("idusers")."';")->foto;
            // if(strlen($foto) > 0){
            //     if(file_exists($this->modul->getPathApp().$foto)){
            //         $def_foto = base_url().'/uploads/'.$foto;
            //     }
            // }
            // $data['foto_profile'] = $def_foto;

            // membaca identitas
            // $jml_identitas = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
            // if ($jml_identitas > 0) {
            //     $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
            //     $data['alamat'] = $tersimpan->alamat;
            //     $data['tlp'] = $tersimpan->tlp;
            //     $data['fax'] = $tersimpan->fax;
            //     $data['website'] = $tersimpan->website;
            //     $deflogo = base_url() . '/images/noimg.jpg';
            //     if (strlen($tersimpan->logo) > 0) {
            //         if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
            //             $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
            //         }
            //     }
            //     $data['logo'] = $deflogo;
            // } else {
            //     $data['alamat'] = "";
            //     $data['tlp'] = "";
            //     $data['fax'] = "";
            //     $data['website'] = "";
            //     $data['logo'] = base_url() . '/images/noimg.jpg';
            // }

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
                $def_foto = base_url() . '/images/noimg.jpg';
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

            // echo view('back/head', $data);
            echo view('back/dashboardsiswa/home', $data);
            // echo view('back/content');
            // echo view('back/foot');

        } else {
            $this->modul->halaman('loginsiswa');
        }
    }
}