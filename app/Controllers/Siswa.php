<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Siswa extends BaseController
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
                $deflogo = base_url() . 'front/images/noimg.png';
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
                $data['logo'] = base_url() . 'front/images/noimg.png';
            }


            $idrole = session()->get("role");
            if ($idrole == 'R00001') {

                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_admin');
                echo view('page/menu/siswa/index');
                echo view('page/menu/layout/foot');
            } else  if ($idrole == 'R00004') {
                $segment = $this->request->getUri()->getSegment(3);
                $id = isset($segment) ? $segment : '';
                $data['id'] = $id;

                echo view('back/head', $data);
                echo view('back/menu_instansi');
                echo view('back/peserta/index');
                echo view('back/foot');
            } else {
                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_admin');
                echo view('page/menu/siswa/index');
                echo view('page/menu/layout/foot');
            }
        } else {
            $this->modul->halaman('login');
        }
    }


    public function siswadetail()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {

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
                $deflogo = base_url() . 'front/images/noimg.png';
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
                $data['logo'] = base_url() . 'front/images/noimg.png';
            }


            $idrole = session()->get("role");
            if ($idrole == 'R00001') {
                $segment = $this->request->getUri()->getSegment(3);
                $id = isset($segment) ? $segment : '';
                $data['id'] = $id;
                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_admin');
                echo view('page/menu/siswa/detailsiswa');
                echo view('page/menu/layout/foot');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function siswalist()
    {
        if (session()->get("logged_admin")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT * FROM users WHERE idrole = 'R00003';");
            foreach ($list->getResult() as $row) {
                $def_foto = base_url() . 'front/images/noimg.png';
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
                if ($row->school_name === NULL) {
                    $instansi = $this->model->getAllQR("SELECT nama_instansi FROM instansi WHERE idinstansi = '" . $row->idinstansi . "';")->nama_instansi;
                    $val[] = $instansi->nama_instansi;
                } else if ($row->idinstansi === NULL) {
                    $val[] = $row->school_name;
                }
                if ($row->idusers === session()->get("idusers")) {
                    $val[] = '-';
                } else {
                    $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm m-0 btn-success btn-fw" onclick="siswa_list(' . "'" . $row->idusers . "'" . ')">Detail</button>&nbsp;'
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

    public function ajaxlist()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {
            $idrole = session()->get("role");
            if ($idrole == 'R00001') {
                $id = $this->request->getUri()->getSegment(3);
                $data = array();
                $no = 1;
                $list = $this->model->getAllQ("select * from peserta where status = 1 and idusers = '" . $id . "' order by created_at DESC;");
                foreach ($list->getResult() as $row) {
                    $val = array();
                    $val[] = $no;
                    $val[] = date('d M Y', strtotime($row->created_at));
                    $val[] = $row->nama;
                    $val[] = $row->email;
                    $val[] = $row->nohp;

                    $topik = $this->model->getAllQR("select nama from topik where idtopik = '" . $row->idtopik . "'")->nama;
                    $subtopik = $this->model->getAllQR("select nama from subtopik where idsubtopik = '" . $row->idsubtopik . "'")->nama;
                    $val[] = $topik . ' - ' . $subtopik;
                    $jenis = $this->model->getAllQR("select jenis from jawaban_peserta j, soal s where j.idsoal = s.idsoal and j.idpeserta = '" . $row->idpeserta . "' limit 1")->jenis;
                    $val[] = $row->poin;

                    $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="nilai(' . "'" . $row->idpeserta . "'" . ',' . "'" . $jenis . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                        // . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idpeserta . "'" . ',' . "'" . $row->nama . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
                        . '</div>';

                    $data[] = $val;

                    $no++;
                }
                $output = array("data" => $data);
                echo json_encode($output);
            } else if ($idrole == 'R00004') {

                $id = $this->request->getUri()->getSegment(3);
                $data = array();
                $no = 1;
                $list = $this->model->getAllQ("select * from peserta where status = 1 and idusers = '" . $id . "' order by created_at DESC;");
                foreach ($list->getResult() as $row) {
                    $val = array();
                    $val[] = $no;
                    $val[] = date('d M Y', strtotime($row->created_at));
                    $val[] = $row->nama;
                    $val[] = $row->email;
                    $val[] = $row->nohp;

                    $topik = $this->model->getAllQR("select nama from topik where idtopik = '" . $row->idtopik . "'")->nama;
                    $subtopik = $this->model->getAllQR("select nama from subtopik where idsubtopik = '" . $row->idsubtopik . "'")->nama;
                    $val[] = $topik . ' - ' . $subtopik;
                    $jenis = $this->model->getAllQR("select jenis from jawaban_peserta j, soal s where j.idsoal = s.idsoal and j.idpeserta = '" . $row->idpeserta . "' limit 1")->jenis;
                    $val[] = $row->poin;

                    $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="nilai(' . "'" . $row->idpeserta . "'" . ',' . "'" . $jenis . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                        // . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idpeserta . "'" . ',' . "'" . $row->nama . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
                        . '</div>';

                    $data[] = $val;

                    $no++;
                }
                $output = array("data" => $data);
                echo json_encode($output);
            } else {
                $data = array();
                $no = 1;
                $list = $this->model->getAllQ("select * from peserta where status = 1 order by created_at DESC;");
                foreach ($list->getResult() as $row) {
                    $val = array();
                    $val[] = $no;
                    $val[] = date('d M Y', strtotime($row->created_at));
                    $val[] = $row->nama;
                    $val[] = $row->email;
                    $val[] = $row->nohp;

                    $topik = $this->model->getAllQR("select nama from topik where idtopik = '" . $row->idtopik . "'")->nama;
                    $subtopik = $this->model->getAllQR("select nama from subtopik where idsubtopik = '" . $row->idsubtopik . "'")->nama;
                    $val[] = $topik . ' - ' . $subtopik;
                    $jenis = $this->model->getAllQR("select jenis from jawaban_peserta j, soal s where j.idsoal = s.idsoal and j.idpeserta = '" . $row->idpeserta . "' limit 1")->jenis;
                    $val[] = $row->poin;

                    $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="nilai(' . "'" . $row->idpeserta . "'" . ',' . "'" . $jenis . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                        // . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idpeserta . "'" . ',' . "'" . $row->nama . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
                        . '</div>';

                    $data[] = $val;

                    $no++;
                }
                $output = array("data" => $data);
                echo json_encode($output);
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
            $list = $this->model->getAllQ("select j.idsoal as ids, soal, jawab, hasil from jawaban_peserta j, soal s where j.idsoal = s.idsoal and idpeserta = '" . $kode . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->soal;
                $list_ja = $this->model->getAllQ("select jawaban from jawaban where idsoal = '" . $row->ids . "'");
                $str = '<ul>';
                foreach ($list_ja->getResult() as $row1) {
                    $str .= '<li>' . $row1->jawaban . '</li>';
                }
                $str .= '</ul>';
                $val[] = $str;

                foreach ($list_ja->getResult() as $row2) {
                    if ($row->jawab != $row2->jawaban) {
                        $val[] = '<p style="color:red;">' . $row->jawab . '</p>';
                        $val[] = '<h4><small class="label bg-red">Salah</small></h4>';
                    } else {
                        $val[] = '<p style="color:green;">' . $row->jawab . '</p>';
                        $val[] = '<h4><small class="label bg-green">Benar</small></h4>';
                    }
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

    public function ajaxdetil2()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {
            $kode = $this->request->getUri()->getSegment(3);
            $data = array();
            $no = 1;
            // select j.idsoal as ids, soal, GROUP_CONCAT(jawab SEPARATOR ', ') as jawab, GROUP_CONCAT(hasil SEPARATOR ', ') as hasil from jawaban_peserta j, soal s where j.idsoal = s.idsoal and idpeserta = 'C00001' group by j.idsoal;
            $list = $this->model->getAllQ("select j.idsoal as ids, soal, jawab, hasil from jawaban_peserta j, soal s where j.idsoal = s.idsoal and idpeserta = '" . $kode . "' group by j.idsoal;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->soal;
                $list_ja = $this->model->getAllQ("select jawaban from jawaban where idsoal = '" . $row->ids . "'");
                $str = '<ul>';
                foreach ($list_ja->getResult() as $row1) {
                    $str .= '<li>' . $row1->jawaban . '</li>';
                }
                $str .= '</ul>';
                $val[] = $str;

                $items = array();
                $list_js = $this->model->getAllQ("select jawab from jawaban_peserta where idsoal = '" . $row->ids . "'");
                foreach ($list_js->getResult() as $row2) {
                    $items[] = $row2->jawab;
                }

                $st = '';
                $st2 = '';
                $n = 0;
                $list_ja = $this->model->getAllQ("select jawaban from jawaban where idsoal = '" . $row->ids . "'");
                foreach ($list_ja->getResult() as $row1) {
                    if ($items[$n] != $row1->jawaban) {
                        $st .= '<p style="color:red;">' . $items[$n] . '</p>';
                        $st2 .= '<h4><small class="label bg-red">Salah</small></h4>';
                    } else {
                        $st .= '<p style="color:green;">' . $items[$n] . '</p>';
                        $st2 .= '<h4><small class="label bg-green">Benar</small></h4>';
                    }
                    $n++;
                }

                $val[] = $st;
                $val[] = $st2;

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

    public function detil()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {

            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
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
                $deflogo = base_url() . 'front/images/noimg.png';
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
                $data['logo'] = base_url() . 'front/images/noimg.png';
            }

            $idrole = session()->get("role");

            if ($idrole == 'R00001') {
                $kode = $this->request->getUri()->getSegment(3);
                $peserta = $this->model->getAllQR("SELECT * FROM peserta WHERE idpeserta = '" . $kode . "';");
                $data['head'] = $peserta;
                $data['topik'] = $this->model->getAllQR("SELECT nama FROM topik WHERE idtopik = '" . $peserta->idtopik . "';")->nama;
                $data['subtopik'] = $this->model->getAllQR("SELECT nama FROM subtopik WHERE idsubtopik = '" . $peserta->idsubtopik . "';")->nama;

                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_admin');
                echo view('page/menu/siswa/detail');
                echo view('page/menu/layout/foot');
            } else if ($idrole == 'R00004') {

                $kode = $this->request->getUri()->getSegment(3);
                $peserta = $this->model->getAllQR("SELECT * FROM peserta WHERE idpeserta = '" . $kode . "';");
                $data['head'] = $peserta;
                $data['topik'] = $this->model->getAllQR("SELECT nama FROM topik WHERE idtopik = '" . $peserta->idtopik . "';")->nama;
                $data['subtopik'] = $this->model->getAllQR("SELECT nama FROM subtopik WHERE idsubtopik = '" . $peserta->idsubtopik . "';")->nama;

                echo view('back/head', $data);
                echo view('back/menu_instansi');
                echo view('back/peserta/detail');
                echo view('back/foot');
            } else {

                $kode = $this->request->getUri()->getSegment(3);
                $peserta = $this->model->getAllQR("SELECT * FROM peserta WHERE idpeserta = '" . $kode . "';");
                $data['head'] = $peserta;
                $data['topik'] = $this->model->getAllQR("SELECT nama FROM topik WHERE idtopik = '" . $peserta->idtopik . "';")->nama;
                $data['subtopik'] = $this->model->getAllQR("SELECT nama FROM subtopik WHERE idsubtopik = '" . $peserta->idsubtopik . "';")->nama;

                echo view('back/head', $data);
                echo view('back/menu');
                echo view('back/peserta/detail');
                echo view('back/foot');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function detilmg()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {

            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
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
                $deflogo = base_url() . 'front/images/noimg.png';
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
                $data['logo'] = base_url() . 'front/images/noimg.png';
            }

            $idrole = session()->get("role");

            if ($idrole == 'R00001') {
                $kode = $this->request->getUri()->getSegment(3);
                $peserta = $this->model->getAllQR("SELECT * FROM peserta WHERE idpeserta = '" . $kode . "';");
                $data['head'] = $peserta;
                $data['topik'] = $this->model->getAllQR("SELECT nama FROM topik WHERE idtopik = '" . $peserta->idtopik . "';")->nama;
                $data['subtopik'] = $this->model->getAllQR("SELECT nama FROM subtopik WHERE idsubtopik = '" . $peserta->idsubtopik . "';")->nama;

                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_admin');
                echo view('page/menu/siswa/detailmg');
                echo view('page/menu/layout/foot');
            } else if ($idrole == 'R00004') {

                $kode = $this->request->getUri()->getSegment(3);
                $peserta = $this->model->getAllQR("SELECT * FROM peserta WHERE idpeserta = '" . $kode . "';");
                $data['head'] = $peserta;
                $data['topik'] = $this->model->getAllQR("SELECT nama FROM topik WHERE idtopik = '" . $peserta->idtopik . "';")->nama;
                $data['subtopik'] = $this->model->getAllQR("SELECT nama FROM subtopik WHERE idsubtopik = '" . $peserta->idsubtopik . "';")->nama;

                echo view('back/head', $data);
                echo view('back/menu_instansi');
                echo view('back/peserta/detailmg');
                echo view('back/foot');
            } else {

                $kode = $this->request->getUri()->getSegment(3);
                $peserta = $this->model->getAllQR("SELECT * FROM peserta WHERE idpeserta = '" . $kode . "';");
                $data['head'] = $peserta;
                $data['topik'] = $this->model->getAllQR("SELECT nama FROM topik WHERE idtopik = '" . $peserta->idtopik . "';")->nama;
                $data['subtopik'] = $this->model->getAllQR("SELECT nama FROM subtopik WHERE idsubtopik = '" . $peserta->idsubtopik . "';")->nama;

                echo view('back/head', $data);
                echo view('back/menu');
                echo view('back/peserta/detailmg');
                echo view('back/foot');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function exportexcel()
    {
        if (session()->get("logged_admin") || session()->get("logged_instansi")) {
            $hasil = explode(":", trim($this->request->getUri()->getSegment(3)));
            $no = 1;

            $spreadsheet = new Spreadsheet();
            // tulis header/nama kolom 
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'NO')
                ->setCellValue('B1', 'TANGGAL')
                ->setCellValue('C1', 'NAMA')
                ->setCellValue('D1', 'EMAIL')
                ->setCellValue('E1', 'NO TELP')
                ->setCellValue('F1', 'TOPIK - SUBTOPIK')
                ->setCellValue('G1', 'HASIL');

            $column = 2;

            $list = $this->model->getAllQ("select * from peserta where status = 1 and created_at between STR_TO_DATE('" . $hasil[0] . "','%m-%d-%Y') and STR_TO_DATE('" . $hasil[1] . "','%m-%d-%Y');");

            foreach ($list->getResult() as $row) {
                $topik = $this->model->getAllQR("select nama from topik where idtopik = '" . $row->idtopik . "'")->nama;
                $subtopik = $this->model->getAllQR("select nama from subtopik where idsubtopik = '" . $row->idsubtopik . "'")->nama;
                $jenis = $this->model->getAllQR("select jenis from jawaban_peserta j, soal s where j.idsoal = s.idsoal and j.idpeserta = '" . $row->idpeserta . "' limit 1")->jenis;

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $column, $no)
                    ->setCellValue('B' . $column, date('d M Y', strtotime($row->created_at)))
                    ->setCellValue('C' . $column, $row->nama)
                    ->setCellValue('D' . $column, $row->email)
                    ->setCellValue('E' . $column, $row->nohp)
                    ->setCellValue('F' . $column, $topik . ' - ' . $subtopik)
                    ->setCellValue('G' . $column, $row->poin);
                $column++;

                $no++;
            }

            foreach (range('B', 'G') as $columnID) {
                $spreadsheet->getActiveSheet()->getColumnDimension($columnID)
                    ->setAutoSize(true);
            }
            // tulis dalam format .xlsx
            $writer = new Xlsx($spreadsheet);
            $fileName = 'Data Pengguna Tanggal ' . $hasil[0] . ' hingga ' . $hasil[1];

            // Redirect hasil generate xlsx ke web client
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename=' . $fileName . '.xlsx');
            header('Cache-Control: max-age=0');

            $writer->save('php://output');
        } else {
            $this->modul->halaman('login');
        }
    }
}