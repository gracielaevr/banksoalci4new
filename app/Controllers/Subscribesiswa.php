<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Subscribesiswa extends BaseController
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


            echo view('page/menu/layout/head', $data);
            echo view('page/menu/menu_admin');
            echo view('page/menu/subscribesiswa/index');
            echo view('page/menu/layout/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function detailsiswa()
    {
        if (session()->get("logged_admin")) {

            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
            $data['menu'] = $this->request->getUri()->getSegment(1);
            $def_foto = base_url() . 'front/images/noimg.png';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;
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

            $idrole = session()->get("role");
            if ($idrole == 'R00001') {
                $segment = $this->request->getUri()->getSegment(3);
                $id = isset($segment) ? $segment : '';
                $data['id'] = $id;
                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_admin');
                echo view('page/menu/subscribesiswa/detail');
                echo view('page/menu/layout/foot');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function detaillist()
    {
        if (session()->get("logged_admin")) {
            $id = $this->request->getUri()->getSegment(3);
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT * FROM history_subscribe WHERE idusers = '" . $id . "' ORDER BY tgl_langganan DESC;;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->paket;
                $val[] = $row->sesi;
                $val[] = $row->tgl_langganan;
                $val[] = $row->tgl_berakhir;
                // Cek status berakhir
                $today = date('Y-m-d');
                if ($today > $row->tgl_berakhir) {
                    $val[] = '<button type="button" class="btn btn-sm btn-rounded btn-secondary">Non Active</button>';
                } else {
                    $val[] = '<button type="button" class="btn btn-sm btn-rounded btn-success">Active</button>';
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



    public function ajaxlist()
    {
        if (session()->get("logged_admin")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT * FROM history_subscribe;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $user = $this->model->getAllQR("SELECT * FROM users WHERE idusers = '" . $row->idusers . "';");
                $val[] = $user->nama;
                $val[] = $user->email;
                $val[] = $user->wa;
                $val[] = $user->school_name;
                $val[] = $row->paket;
                $val[] = $row->tgl_langganan;
                $val[] = $row->tgl_berakhir;
                // Cek status berakhir
                $today = date('Y-m-d');
                if ($today > $row->tgl_berakhir) {
                    $val[] = '<button type="button" class="btn btn-sm btn-rounded btn-secondary">Non Active</button>';
                } else {
                    $val[] = '<button type="button" class="btn btn-sm btn-rounded btn-success">Active</button>';
                }

                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-primary" onclick="detail(' . "'" . $row->idusers . "'" . ')">Detail</button>'
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