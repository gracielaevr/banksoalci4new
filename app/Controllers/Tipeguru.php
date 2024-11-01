<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Tipeguru extends BaseController
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


            $data['guru'] = $this->model->getAllQ("select * from tipe_guru");


            echo view('page/menu/layout/head', $data);
            echo view('page/menu/menu_admin');
            echo view('page/menu/guru/index');
            echo view('page/menu/layout/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_admin")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT * FROM users WHERE idrole='R00002'");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->email;
                $val[] = $row->nama;
                $guru = $this->model->getAllQR("SELECT * FROM tipe_guru where idguru = '" . $row->idguru . "';")->tipe;
                $val[] = $guru;
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-success btn-fw" onclick="ganti(' . "'" . $row->idusers . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idusers . "'" . ',' . "'" . $row->nama . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="lock(' . "'" . $row->idusers . "'" . ')"><i class="fa fa-fw fa-lock"></i></button>'
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
                'idusers' => $this->model->autokode("U", "idusers", "users", 2, 7),
                'email' => $this->request->getPost('email'),
                'idrole' => 'R00002',
                'pass' => $this->modul->enkrip_pass('123'),
                'nama' => $this->request->getPost('nama'),
                'idguru' => $this->request->getPost('idguru'),
            );
            $simpan = $this->model->add("users", $data);
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
            $kondisi['idusers'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("users", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_admin")) {
            $data = array(
                'idusers' => $this->request->getPost('idusers'),
                'email' => $this->request->getPost('email'),
                'nama' => $this->request->getPost('nama'),
                'idguru' => $this->request->getPost('idguru'),
            );
            $kond['idusers'] = $this->request->getPost('idusers');
            $update = $this->model->update("users", $data, $kond);
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
            $kond['idusers'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("users", $kond);
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

    public function reset()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {
            $id = $this->request->getUri()->getSegment(3);
            $data = array(
                'pass' => $this->modul->enkrip_pass('123'),
            );
            $kond['idusers'] = $id;
            $update = $this->model->update("users", $data, $kond);
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
}