<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Jadwalkonsultasi extends BaseController
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

            // membaca profile orang tersebut
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");

            $data['menu'] = $this->request->uri->getSegment(1);

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
            $data['users'] = $this->model->getAllQ("select * from users WHERE idrole='R00002'");
            echo view('back/head', $data);
            echo view('back/menu');
            echo view('back/jadwalkonsultasi/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_admin")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from konsultasi;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tanggal;
                $val[] = date('H:i', strtotime($row->waktu));
                $val[] = $row->linkzoom;
                $val[] = $row->durasi;
                $val[] = $row->catatan;
                $users = $this->model->getAllQR("select * from users where idusers = 'U00002';")->nama;
                $val[] = $users;
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti(' . "'" . $row->idkonsultasi . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idkonsultasi . "'" . ',' . "'" . $row->tanggal . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
                    . '</div>';

                $data[] = $val;
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add()
    {
        if (session()->get("logged_admin")) {
            $data = array(
                'idkonsultasi' => $this->model->autokode("K", "idkonsultasi", "konsultasi", 2, 7),
                'tanggal' => $this->request->getPost('tanggal'),
                'waktu' => $this->request->getPost('waktu'),
                'linkzoom' => $this->request->getPost('linkzoom'),
                'durasi' => $this->request->getPost('durasi'),
                'catatan' => $this->request->getPost('catatan'),
                'idrole' => $this->request->getPost('idrole'),
            );
            $simpan = $this->model->add("konsultasi", $data);
            if ($simpan == 1) {
                $status = "Data tersimpan";
            } else {
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ganti()
    {
        if (session()->get("logged_admin")) {
            $kondisi['idkonsultasi'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("konsultasi", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_admin")) {
            $data = array(
                'idkonsultasi' => $this->request->getPost('idkonsultasi'),
                'tanggal' => $this->request->getPost('tanggal'),
                'waktu' => $this->request->getPost('waktu'),
                'linkzoom' => $this->request->getPost('linkzoom'),
                'durasi' => $this->request->getPost('durasi'),
                'catatan' => $this->request->getPost('catatan'),
                'idrole' => $this->request->getPost('idrole'),
            );
            $kond['idkonsultasi'] = $this->request->getPost('idkonsultasi');
            $update = $this->model->update("konsultasi", $data, $kond);
            if ($update == 1) {
                $status = "Data terupdate";
            } else {
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapus()
    {
        if (session()->get("logged_admin")) {
            $kond['idkonsultasi'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("konsultasi", $kond);
            if ($hapus == 1) {
                $status = "Data terhapus";
            } else {
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }
}