<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Rekap extends BaseController
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
        if (session()->get("logged_admin") || session()->get("logged_in")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $idrole = session()->get("role");
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
                $deflogo = base_url() . '/images/noimg.jpg';
                if (strlen($tersimpan->logo) > 0) {
                    if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                        $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            } else {
                $data['logo'] = base_url() . '/images/noimg.jpg';
            }

            echo view('back/head', $data);
            if ($idrole == "R00001") {
                echo view('back/menu');
            } else if ($idrole == "R00005") {
                echo view('back/menu_admins');
            } else {
                echo view('back/menu_guru');
            }
            echo view('back/rekap/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_admin") || session()->get("logged_in")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAll("topik");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->nama;
                $topik = $this->model->getAllQR("SELECT count(*) as jml, sum(benar) as bnr, sum(salah) as slh FROM peserta where idtopik = '" . $row->idtopik . "';");
                $val[] = '<h3><small class="label bg-gray">' . $topik->jml . '</small></h3>';
                $jml = $topik->bnr + $topik->slh;
                if ($jml > 0) {
                    $benar = ($topik->bnr / $jml) * 100;
                    $salah = ($topik->slh / $jml) * 100;
                } else {
                    $benar = '-';
                    $salah = '-';
                }
                $val[] = '<h3><small class="label bg-green">' . $benar . '</small></h3>';
                $val[] = '<h3><small class="label bg-red">' . $salah . '</small></h3>';

                $jml_subtopik = $this->model->getAllQR("SELECT count(*) as jml FROM subtopik where idtopik = '" . $row->idtopik . "';")->jml;
                if ($jml_subtopik > 0) {
                    $str = '<table class="table table-striped" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Subtopik</th>
                                <th>Total Diujikan</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>            
                    <tbody>';
                    $list_subs = $this->model->getAllQ("select * from subtopik where idtopik = '" . $row->idtopik . "';");
                    foreach ($list_subs->getResult() as $row1) {
                        $str .= '<tr>';
                        $str .= '<td>' . $row1->nama . '</td>';
                        $st = $this->model->getAllQR("SELECT count(*) as jml FROM peserta where idsubtopik = '" . $row1->idsubtopik . "';");
                        $str .= '<td>' . $st->jml . '</td>';
                        $str .= '<td style="text-align: center;"><button type="button" class="btn btn-warning btn-sm" onclick="soal(' . "'" . $row1->idsubtopik . "'" . ');"><i class="fa fa-fw fa-eye"></i></button></td>';
                        $str .= '</tr>';
                    }
                    $str .= '</tbody></table>';
                    $val[] = $str;
                } else {
                    $val[] = 'Tidak ada data';
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
        if (session()->get("logged_admin") || session()->get("logged_in")) {
            $data = array(
                'nama' => $this->request->getPost('nama')
            );
            $simpan = $this->model->add("topik", $data);
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
        if (session()->get("logged_admin") || session()->get("logged_in")) {
            $kondisi['idtopik'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("topik", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_admin") || session()->get("logged_in")) {
            $data = array(
                'nama' => $this->request->getPost('nama')
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
        if (session()->get("logged_admin") || session()->get("logged_in")) {
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
        if (session()->get("logged_admin") || session()->get("logged_in")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $idrole = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
            $data['menu'] = $this->request->getUri()->getSegment(1);

            $data['model'] = $this->model;

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
                $deflogo = base_url() . '/images/noimg.jpg';
                if (strlen($tersimpan->logo) > 0) {
                    if (file_exists($this->modul->getPathApp() . $tersimpan->logo)) {
                        $deflogo = base_url() . '/uploads/' . $tersimpan->logo;
                    }
                }
                $data['logo'] = $deflogo;
            } else {
                $data['logo'] = base_url() . '/images/noimg.jpg';
            }

            $kode = $this->request->getUri()->getSegment(3);
            $data['head'] = $this->model->getAllQR("select t.nama as namatopik,s.nama as namasub, idsubtopik from subtopik s, topik t where s.idtopik = t.idtopik AND s.idsubtopik = '" . $kode . "';");
            $data['soal'] = $this->model->getAllQR("SELECT count(*) as jml, sum(benar) as bnr, sum(salah) as slh FROM peserta where idsubtopik = '" . $kode . "' group by idsubtopik;");
            $data['quest'] = $this->model->getAllQ("SELECT soal, idsoal, FLOOR(RAND()*(255-100)+0) as random,FLOOR(RAND()*(255-100)+0) as random2,FLOOR(RAND()*(255-100)+0) as random3 FROM soal where idsubtopik = '" . $kode . "';");

            echo view('back/head', $data);
            if ($idrole == "R00001") {
                echo view('back/menu');
            } elseif ($idrole = "R00005") {
                echo view('back/menu_admins');
            } else {
                echo view('back/menu_guru');
            }
            echo view('back/rekap/detail');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxdetil()
    {
        if (session()->get("logged_admin") || session()->get("logged_in")) {
            $kode = $this->request->getUri()->getSegment(3);

            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->soal;
                $benar = $this->model->getAllQR("SELECT count(hasil) as benar FROM jawaban_peserta where idsoal = '" . $row->idsoal . "' and hasil = 1;")->benar;
                $val[] = '<h4><small class="label bg-green">' . $benar . '</small></h4>';
                $salah = $this->model->getAllQR("SELECT count(hasil) as salah FROM jawaban_peserta where idsoal = '" . $row->idsoal . "' and hasil = 0;")->salah;
                $val[] = '<h4><small class="label bg-red">' . $salah . '</small></h4>';
                $data[] = $val;

                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        } else {
            $this->modul->halaman('login');
        }
    }
}
