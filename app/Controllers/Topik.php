<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Topik extends BaseController
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
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {

            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['idinstansi'] = session()->get("idinstansi");
            $data['school_name'] = session()->get("school_name");
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

            $jml_topik = $this->model->getAllQR("SELECT count(*) as jml FROM topik WHERE school_name = '" . addslashes(session()->get("school_name"))  . "';")->jml;
            $data['jml_topik'] = $jml_topik;


            $idrole = session()->get("role");

            if ($idrole === "R00001") {
                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_admin');
                echo view('page/menu/topik/index', $data);
                echo view('page/menu/layout/foot');
            } else if ($idrole === "R00004") {
                echo view('back/head', $data);
                echo view('back/menu_instansi');
                echo view('back/topik/index', $data);
                echo view('back/foot');
            } else {
                echo view('back/head', $data);
                echo view('back/menu_guru');
                echo view('back/topik/index', $data);
                echo view('back/foot');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from topik order by best desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                if ($row->best != 0) {
                    $val[] = '(' . $row->best . '<i class="fa fa-fw fa-star-o"></i>)  ' . $row->code . ' - ' . $row->nama;
                } else {
                    $val[] = $row->code . ' - ' . $row->nama;
                }
                // membaca jml subtopik
                $jml_subtopik = $this->model->getAllQR("SELECT count(*) as jml FROM subtopik where idtopik = '" . $row->idtopik . "';")->jml;
                if ($jml_subtopik > 0) {
                    $str = '<table  class="table-striped" >
                            <tbody>';
                    $list_subs = $this->model->getAllQ("select code, nama from subtopik where idtopik = '" . $row->idtopik . "';");
                    foreach ($list_subs->getResult() as $row1) {
                        $str .= '<tr>';
                        $str .= '<td >' . $row1->code . ' - ' . $row1->nama . '</td>';
                        $str .= '</tr>';
                    }
                    $str .= '</tbody></table>';
                    $val[] = $str;
                } else {
                    $val[] = '-';
                }
                $val[] = '<div style="text-align: center;" class="d-flex justify-content-center align-items-center ms-3 me-3">'
                    . '<button type="button" class="btn btn-success" onclick="subtopik(' . "'" . $row->idtopik . "'" . ')"><i class="fa fa-fw fa-plus-square"></i></button>&nbsp;'
                    . '</div>';

                if ($row->idinstansi == session()->get("idinstansi") && $row->school_name == session()->get("school_name")) {
                    $val[] = '<div style="text-align: center;" class="d-flex justify-content-center ms-3 me-3">'
                        . '<button type="button" class="btn btn-primary" onclick="ganti(' . "'" . $row->idtopik . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-danger" onclick="hapus(' . "'" . $row->idtopik . "'" . ',' . "'" . $row->nama . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
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
                    'idtopik' => $this->model->autokode("T", "idtopik", "topik", 2, 7),
                    'code' => $this->request->getPost('code'),
                    'best' => $this->request->getPost('best'),
                    'nama' => $this->request->getPost('nama'),
                    'school_name' => $this->request->getPost('school_name')
                );
                $simpan = $this->model->add("topik", $data);
            } else  if ($idrole === 'R00004' && $school_name === NULL) {
                $data = array(
                    'idtopik' => $this->model->autokode("T", "idtopik", "topik", 2, 7),
                    'code' => $this->request->getPost('code'),
                    'best' => $this->request->getPost('best'),
                    'nama' => $this->request->getPost('nama'),
                    'idinstansi' => $this->request->getPost('idinstansi')
                );
                $simpan = $this->model->add("topik", $data);
            } else {

                $data = array(
                    'idtopik' => $this->model->autokode("T", "idtopik", "topik", 2, 7),
                    'code' => $this->request->getPost('code'),
                    'best' => $this->request->getPost('best'),
                    'nama' => $this->request->getPost('nama'),
                );
                $simpan = $this->model->add("topik", $data);
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

            $kondisi['idtopik'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("topik", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {

            $data = array(
                'code' => $this->request->getPost('code'),
                'nama' => $this->request->getPost('nama'),
                'best' => $this->request->getPost('best')
            );
            $kond['idtopik'] = $this->request->getPost('kode');
            $update = $this->model->update("topik", $data, $kond);
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

            $kond['idtopik'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("topik", $kond);
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
