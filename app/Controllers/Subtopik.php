<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Subtopik extends BaseController
{

    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function detil()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['idinstansi'] = session()->get("idinstansi");
            $data['school_name'] = session()->get("school_name");
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

            $kode = $this->request->getUri()->getSegment(3);
            $data['head'] = $this->model->getAllQR("select * from topik where idtopik = '" . $kode . "';");

            $jml_subtopik = $this->model->getAllQR("SELECT count(*) as jml FROM subtopik WHERE school_name = '" . addslashes(session()->get("school_name")) . "';")->jml;
            $data['jml_subtopik'] = $jml_subtopik;


            $idrole = session()->get('role');
            if ($idrole === 'R00001') {
                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_admin');
                echo view('page/menu/subtopik/index');
                echo view('page/menu/layout/foot');
            } else if ($idrole === 'R00004') {
                echo view('back/head', $data);
                echo view('back/menu_instansi');
                echo view('back/subtopik/index', $data);
                echo view('back/foot');
            } else {
                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_guru');
                echo view('page/menu/subtopik/index');
                echo view('page/menu/layout/foot');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxdetil()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {
            $kode = $this->request->getUri()->getSegment(3);
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from subtopik where idtopik = '" . $kode . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->code;
                $val[] = $row->nama;
                $val[] = $row->deskripsi;
                if ($row->idinstansi == session()->get("idinstansi") && $row->school_name == session()->get("school_name")) {
                    $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="ganti(' . "'" . $row->idsubtopik . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idsubtopik . "'" . ',' . "'" . $row->nama . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
                        . '</div>';
                } else {
                    $val[] = '<div class="text-center" > -</div>';
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

    public function ajax_add()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {

            $idrole = session()->get("role");
            $idinstansi = session()->get("idinstansi");
            $school_name = session()->get("school_name");

            if ($idrole === 'R00004' && $idinstansi === NULL) {
                $data = array(
                    'idsubtopik' => $this->model->autokode("S", "idsubtopik", "subtopik", 2, 7),
                    'idtopik' => $this->request->getPost('idtopik'),
                    'nama' => $this->request->getPost('nama'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'code' => $this->request->getPost('code'),
                    'narasi' => $this->request->getPost('narasi'),
                    'school_name' => $this->request->getPost('school_name')
                );
                $simpan = $this->model->add("subtopik", $data);
            } else  if ($idrole === 'R00004' && $school_name === NULL) {
                $data = array(
                    'idsubtopik' => $this->model->autokode("S", "idsubtopik", "subtopik", 2, 7),
                    'idtopik' => $this->request->getPost('idtopik'),
                    'nama' => $this->request->getPost('nama'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'code' => $this->request->getPost('code'),
                    'narasi' => $this->request->getPost('narasi'),
                    'idinstansi' => $this->request->getPost('idinstansi')
                );
                $simpan = $this->model->add("subtopik", $data);
            } else {

                $data = array(
                    'idsubtopik' => $this->model->autokode("S", "idsubtopik", "subtopik", 2, 7),
                    'idtopik' => $this->request->getPost('idtopik'),
                    'nama' => $this->request->getPost('nama'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'code' => $this->request->getPost('code'),
                    'narasi' => $this->request->getPost('narasi'),
                );
                $simpan = $this->model->add("subtopik", $data);
            }
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
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {
            $kondisi['idsubtopik'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("subtopik", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {
            $data = array(
                'nama' => $this->request->getPost('subtopik'),
                'deskripsi' => $this->request->getPost('deskripsi'),
                'code' => $this->request->getPost('code'),
                'narasi' => $this->request->getPost('narasi'),
            );
            $kond['idsubtopik'] = $this->request->getPost('kode');
            $update = $this->model->update("subtopik", $data, $kond);
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
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {
            $kond['idsubtopik'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("subtopik", $kond);
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
