<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Pengguna extends BaseController
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

            echo view('back/head', $data);
            echo view('back/menu');
            echo view('back/users/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses()
    {
        if (session()->get("logged_in")) {
            if (0 < $_FILES['file']['error']) {
                $status = "Error during file upload " . $_FILES['file']['error'];
            } else {
                // $status = $this->simpan();
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add()
    {
        if (session()->get("logged_in")) {
            $data = array(
                'idusers' => $this->model->autokode("U", "idusers", "users", 2, 7),
                'email' => $this->request->getPost('email'),
                'idrole' => $this->request->getPost('idrole'),
                'pass' => $this->modul->enkrip_pass('123'),
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

    public function ajax_edit()
    {
        if (session()->get("logged_in")) {
            $data = array(
                'email' => $this->request->getPost('email'),
                'idrole' => $this->request->getPost('idrole'),
            );
            $kond['idusers'] = $this->request->getPost('kode');
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

    public function ajaxlist()
    {
        if (session()->get("logged_in")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from users;");
            foreach ($list->getResult() as $row) {
                $def_foto = base_url() . '/images/noimg.jpg';
                if (!is_null($row->foto) && strlen($row->foto)) {
                    if (file_exists($this->modul->getPathApp() . $row->foto)) {
                        $def_foto = base_url() . '/uploads/' . $row->foto;
                    }
                }

                $val = array();
                $val[] = $no;
                $val[] = '<img src="' . $def_foto . '" class="img-thumbnail" style="width: 120px; height: auto;">';
                $val[] = $row->nama;
                $val[] = $row->email;
                $val[] = $row->wa;
                $val[] = $this->model->getAllQR("SELECT nama_role FROM role where idrole = '" . $row->idrole . "';")->nama_role;
                if ($row->idusers === session()->get("idusers")) {
                    $val[] = '-';
                } else {
                    $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-info btn-fw" onclick="lock(' . "'" . $row->idusers . "'" . ')"><i class="fa fa-fw fa-lock"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti(' . "'" . $row->idusers . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idusers . "'" . ',' . "'" . $row->nama . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
                        . '</div>';
                }
                $data[] = $val;
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapus()
    {
        if (session()->get("logged_in")) {
            $id = $this->request->uri->getSegment(3);
            $lawas = $this->model->getAllQR("SELECT foto FROM users where idusers = '" . $id . "';")->foto;
            if (strlen($lawas) > 0) {
                if (file_exists($this->modul->getPathApp() . $lawas)) {
                    unlink($this->modul->getPathApp() . $lawas);
                }
            }

            $kond['idusers'] = $id;
            $hapus = $this->model->delete("users", $kond);
            if ($hapus == 1) {
                $status = "Hapus Berhasil";
            } else {
                $status = "Hapus Gagal";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function reset()
    {
        if (session()->get("logged_in")) {
            $id = $this->request->uri->getSegment(3);
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

    public function ganti()
    {
        if (session()->get("logged_in")) {
            $kondisi['idusers'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("users", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }
}