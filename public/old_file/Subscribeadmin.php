<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Subscribeadmin extends BaseController
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
            echo view('back/menu');
            echo view('back/subscribeadmin/index');
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
            $list = $this->model->getAllQ("select * from subscribe;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->judul;
                $val[] = $row->harga;
                $val[] = $row->detail;
                $val[] = $row->durasi;
                $val[] = $row->status;
                $val[] = $row->sesi;
                $val[] = $row->bundling;

                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti(' . "'" . $row->idsubscribe . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idsubscribe . "'" . ',' . "'" . $row->judul . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
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
                'idsubscribe' => $this->model->autokode("S", "idsubscribe", "subscribe", 2, 7),
                'judul' => $this->request->getPost('judul'),
                'harga' => $this->request->getPost('harga'),
                'detail' => $this->request->getPost('detail'),
                'durasi' => $this->request->getPost('durasi'),
                'status' => $this->request->getPost('status'),
                'sesi' => $this->request->getPost('sesi'),
                'bundling' => $this->request->getPost('bundling'),

            );
            $simpan = $this->model->add("subscribe", $data);
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
            $kondisi['idsubscribe'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("subscribe", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_admin")) {
            $data = array(
                'idsubscribe' => $this->request->getPost('idsubscribe'),
                'judul' => $this->request->getPost('judul'),
                'harga' => $this->request->getPost('harga'),
                'detail' => $this->request->getPost('detail'),
                'durasi' => $this->request->getPost('durasi'),
                'status' => $this->request->getPost('status'),
                'sesi' => $this->request->getPost('sesi'),
                'bundling' => $this->request->getPost('bundling'),

            );
            $kond['idsubscribe'] = $this->request->getPost('idsubscribe');
            $update = $this->model->update("subscribe", $data, $kond);
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
            $kond['idsubscribe'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("subscribe", $kond);
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
