<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Soal extends BaseController
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
            $idrole = session()->get("role");
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
            } else {
                echo view('back/menu_guru');
            }
            echo view('back/soal/index');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajaxlist()
    {
        if (session()->get("logged_in")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAll("topik");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->code . ' - ' . $row->nama;
                // membaca jml subtopik
                $jml_subtopik = $this->model->getAllQR("SELECT count(*) as jml FROM subtopik where idtopik = '" . $row->idtopik . "';")->jml;
                if ($jml_subtopik > 0) {
                    $str = '<table class="table table-striped" style="width: 100%;">
                            <thead>                                 
                                <tr>
                                    <th style="text-align: center;">Subtopik</th>
                                    <th style="text-align: center;">Jumlah Soal</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>';
                    $list_subs = $this->model->getAllQ("select * from subtopik where idtopik = '" . $row->idtopik . "';");
                    foreach ($list_subs->getResult() as $row1) {
                        $str .= '<tr>';
                        $str .= '<td width="60%">' . $row1->code . ' - ' . $row1->nama . '</td>';
                        $jml = $this->model->getAllQR("SELECT count(*) as jml FROM soal where idsubtopik = '" . $row1->idsubtopik . "';")->jml;
                        $str .= '<td style="text-align: center;" width="20%">' . $jml . '</td>';
                        if ($row1->narasi == 0) {
                            $str .= '<td><div style="text-align: center;">'
                                . '<button type="button" class="btn btn-sm btn-success btn-fw" onclick="subtopik(' . "'" . $row1->idsubtopik . "'" . ')"><i class="fa fa-fw fa-plus-square"></i> Buat Soal</button>&nbsp;'
                                . '</div></td>';
                        } else {
                            $str .= '<td><div style="text-align: center;">'
                                . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="soal(' . "'" . $row1->idsubtopik . "'" . ')"><i class="fa fa-fw fa-plus-square"></i> Buat Soal Narasi</button>&nbsp;'
                                . '</div></td>';
                        }

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

    public function detil()
    {
        if (session()->get("logged_in")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $idrole = session()->get("role");  
            $data['nm_role'] = session()->get("nama_role");
            $data['pro'] = $this->model->getAllQR("SELECT * FROM users where idusers = '" . session()->get("idusers") . "';");
            $data['menu'] = $this->request->uri->getSegment(1);

            $data['subtopik'] = $this->model->getAllQ("SELECT idsubtopik, s.nama as sub, t.nama as top FROM subtopik s, topik t where s.idtopik = t.idtopik;");

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

            $kode = $this->request->uri->getSegment(3);
            $data['head'] = $this->model->getAllQR("select t.nama as namatopik,s.nama as namasub, idsubtopik from subtopik s, topik t where s.idtopik = t.idtopik AND s.idsubtopik = '" . $kode . "';");

            echo view('back/head', $data);
            if ($idrole == "R00001") {
                echo view('back/menu');
            } else {
                echo view('back/menu_guru');
            }
            echo view('back/soal/detail');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add()
    {
        if (session()->get("logged_in")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $pesan = $this->simpan_file();
                }
            } else {
                $pesan = $this->simpan();
            }
            echo json_encode(array("status" => $pesan));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function simpan_file()
    {
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
            $status = "Gunakan nama file lain";
        } else {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                $data = array(
                    'idsoal' => $this->model->autokode("E", "idsoal", "soal", 2, 7),
                    'idsubtopik' => $this->request->getPost('idsubtopik'),
                    'soal' => $this->request->getPost('soal'),
                    'jenis' => $this->request->getPost('jenis'),
                    'poin' => $this->request->getPost('poin'),
                    'link' => $this->request->getPost('link'),
                    'gambar' => $fileName
                );
                $this->model->add("soal", $data);

                $getidsoal = $this->model->getAllQR("select idsoal from soal order by idsoal desc limit 1;")->idsoal;
                $data_pil = explode(",", $this->request->getPost('pilihan'));
                for ($i = 0; $i < count($data_pil); $i++) {
                    if ($data_pil[$i] != "") {
                        $datap = array(
                            'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihan", 2, 7),
                            'idsoal' => $getidsoal,
                            'pilihan' => $data_pil[$i]
                        );
                        $this->model->add("pilihan", $datap);
                    }
                }

                $data_ja = explode(",", $this->request->getPost('jawaban'));
                for ($i = 0; $i < count($data_ja); $i++) {
                    if ($data_ja[$i] != "") {
                        $datap = array(
                            'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                            'idsoal' => $getidsoal,
                            'jawaban' => $data_ja[$i]
                        );
                        $this->model->add("jawaban", $datap);
                    }
                }
                $status = "Data tersimpan";
            } else {
                $status = "File gagal terupload";
            }
        }
        return $status;
    }

    private function simpan()
    {
        $data = array(
            'idsoal' => $this->model->autokode("E", "idsoal", "soal", 2, 7),
            'idsubtopik' => $this->request->getPost('idsubtopik'),
            'soal' => $this->request->getPost('soal'),
            'jenis' => $this->request->getPost('jenis'),
            'poin' => $this->request->getPost('poin'),
            'link' => $this->request->getPost('link'),
        );
        $this->model->add("soal", $data);

        $getidsoal = $this->model->getAllQR("select idsoal from soal order by idsoal desc limit 1;")->idsoal;
        $data_pil = explode(",", $this->request->getPost('pilihan'));
        for ($i = 0; $i < count($data_pil); $i++) {
            if ($data_pil[$i] != "") {
                $datap = array(
                    'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihan", 2, 7),
                    'idsoal' => $getidsoal,
                    'pilihan' => $data_pil[$i]
                );
                $this->model->add("pilihan", $datap);
            }
        }

        $data_ja = explode(",", $this->request->getPost('jawaban'));
        for ($i = 0; $i < count($data_ja); $i++) {
            if ($data_ja[$i] != "") {
                $datap = array(
                    'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                    'idsoal' => $getidsoal,
                    'jawaban' => $data_ja[$i]
                );
                $this->model->add("jawaban", $datap);
            }
        }
        $status = "Data tersimpan";

        return $status;
    }

    public function ganti()
    {
        if (session()->get("logged_in")) {
            $kondisi['idsoal'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("soal", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function aksespilihan()
    {
        if (session()->get("logged_in")) {
            $idsoal = $this->request->uri->getSegment(3);
            $str = '';
            $counter = 1;
            $list = $this->model->getAllQ("select * from pilihan where idsoal = '" . $idsoal . "';");
            foreach ($list->getResult() as $row) {
                $str .= '<label class="col-sm-2 control-label"></label>';
                $str .= '<div class="col-sm-10" style="margin-top: 5px;">';
                $str .= '<input type="hidden" class="form-control" id="pilihan_kode_' . $counter . '" name="kode_pilihan[]" value="' . $row->idpilihan . '">';
                $str .= '<input type="text" class="form-control" id="pilihan_' . $counter . '" name="pilihan[]" placeholder="Masukkan Pilihan" value="' . $row->pilihan . '">';
                $str .= '</div>';

                $counter++;
            }
            echo json_encode(array("status" => $str));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function aksesjawaban()
    {
        if (session()->get("logged_in")) {
            $idsoal = $this->request->uri->getSegment(3);
            $str = '';
            $counter = 1;
            $list = $this->model->getAllQ("select * from jawaban where idsoal = '" . $idsoal . "';");
            foreach ($list->getResult() as $row) {
                $str .= '<label class="col-sm-2 control-label"></label>';
                $str .= '<div class="col-sm-10" style="margin-top: 5px;">';
                $str .= '<input type="hidden" class="form-control" id="jawaban_kode_' . $counter . '" name="kode_jawaban[]" value="' . $row->idjawaban . '">';
                $str .= '<input type="text" class="form-control" id="jawaban_' . $counter . '" name="jawaban[]" placeholder="Masukkan Jawaban" value="' . $row->jawaban . '">';
                $str .= '</div>';

                $counter++;
            }
            echo json_encode(array("status" => $str));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_in")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $pesan = $this->update();
                }
            } else {
                $pesan = $this->update_tanpa();
            }
            echo json_encode(array("status" => $pesan));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function update_tanpa()
    {
        $kode = $this->request->getPost('kode');
        $kond['idsoal'] = $this->request->getPost('kode');
        $data = array(
            'idsubtopik' => $this->request->getPost('idsubtopik'),
            'soal' => $this->request->getPost('soal'),
            'jenis' => $this->request->getPost('jenis'),
            'poin' => $this->request->getPost('poin'),
            'link' => $this->request->getPost('link'),
        );
        $this->model->update("soal", $data, $kond);

        //pilihan
        $kode_data_pil = explode(",", $this->request->getPost('kode_pilihan'));
        $data_pil = explode(",", $this->request->getPost('pilihan'));
        for ($i = 0; $i < count($data_pil); $i++) {
            if (strlen($data_pil[$i]) > 0) {
                $cek = $this->model->getAllQR("select count(*) as jml from pilihan where idpilihan = '" . $kode_data_pil[$i] . "';")->jml;
                if ($cek > 0) {
                    $datap = array(
                        'pilihan' => $data_pil[$i]
                    );
                    $kond['idpilihan'] = $kode_data_pil[$i];
                    $this->model->update("pilihan", $datap, $kond);
                } else {
                    $datap = array(
                        'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihan", 2, 7),
                        'idsoal' => $this->request->getPost('kode'),
                        'pilihan' => $data_pil[$i]
                    );
                    $this->model->add("pilihan", $datap);
                }
            } else {
                //hapus
                $kondhapus['idpilihan'] = $kode_data_pil[$i];
                $this->model->delete("pilihan", $kondhapus);
            }
        }

        //jawaban
        $kode_data_ja = explode(",", $this->request->getPost('kode_jawaban'));
        $data_ja = explode(",", $this->request->getPost('jawaban'));
        for ($b = 0; $b < count($data_ja); $b++) {
            if (strlen($data_ja[$b]) > 0) {
                $cek = $this->model->getAllQR("select count(*) as jml from jawaban where idjawaban = '" . $kode_data_ja[$b] . "';")->jml;
                if ($cek > 0) {
                    $dataj = array(
                        'jawaban' => $data_ja[$b]
                    );
                    $kon['idjawaban'] = $kode_data_ja[$b];
                    $this->model->update("jawaban", $dataj, $kon);
                } else {
                    $dataj = array(
                        'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                        'idsoal' => $this->request->getPost('kode'),
                        'jawaban' => $data_ja[$b]
                    );
                    $this->model->add("jawaban", $dataj);
                }
            } else {
                //hapus
                $kondh['idjawaban'] = $kode_data_ja[$b];
                $this->model->delete("jawaban", $kondh);
            }
        }

        $status = "Data tersimpan";

        return $status;
    }

    private function update()
    {
        $lawas = $this->model->getAllQR("SELECT gambar FROM soal where idsoal = '" . $this->request->getPost('kode') . "';")->gambar;
        if (strlen($lawas) > 0) {
            if (file_exists($this->modul->getPathApp() . $lawas)) {
                unlink($this->modul->getPathApp() . $lawas);
            }
        }

        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);

        if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
            $status = "Gunakan nama file lain";
        } else {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                $kode = $this->request->getPost('kode');
                $kond['idsoal'] = $this->request->getPost('kode');
                $data = array(
                    'idsubtopik' => $this->request->getPost('idsubtopik'),
                    'soal' => $this->request->getPost('soal'),
                    'jenis' => $this->request->getPost('jenis'),
                    'poin' => $this->request->getPost('poin'),
                    'link' => $this->request->getPost('link'),
                    'gambar' => $fileName,
                );
                $this->model->update("soal", $data, $kond);

                //pilihan
                $kode_data_pil = explode(",", $this->request->getPost('kode_pilihan'));
                $data_pil = explode(",", $this->request->getPost('pilihan'));
                for ($i = 0; $i < count($data_pil); $i++) {
                    if (strlen($data_pil[$i]) > 0) {
                        $cek = $this->model->getAllQR("select count(*) as jml from pilihan where idpilihan = '" . $kode_data_pil[$i] . "';")->jml;
                        if ($cek > 0) {
                            $datap = array(
                                'pilihan' => $data_pil[$i]
                            );
                            $kond['idpilihan'] = $kode_data_pil[$i];
                            $this->model->update("pilihan", $datap, $kond);
                        } else {
                            $datap = array(
                                'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihan", 2, 7),
                                'idsoal' => $this->request->getPost('kode'),
                                'pilihan' => $data_pil[$i]
                            );
                            $this->model->add("pilihan", $datap);
                        }
                    } else {
                        //hapus
                        $kondhapus['idpilihan'] = $kode_data_pil[$i];
                        $this->model->delete("pilihan", $kondhapus);
                    }
                }

                //jawaban
                $kode_data_ja = explode(",", $this->request->getPost('kode_jawaban'));
                $data_ja = explode(",", $this->request->getPost('jawaban'));
                for ($b = 0; $b < count($data_ja); $b++) {
                    if (strlen($data_ja[$b]) > 0) {
                        $cek = $this->model->getAllQR("select count(*) as jml from jawaban where idjawaban = '" . $kode_data_ja[$b] . "';")->jml;
                        if ($cek > 0) {
                            $dataj = array(
                                'jawaban' => $data_ja[$b]
                            );
                            $kon['idjawaban'] = $kode_data_ja[$b];
                            $this->model->update("jawaban", $dataj, $kon);
                        } else {
                            $dataj = array(
                                'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                                'idsoal' => $this->request->getPost('kode'),
                                'jawaban' => $data_ja[$b]
                            );
                            $this->model->add("jawaban", $dataj);
                        }
                    } else {
                        //hapus
                        $kondh['idjawaban'] = $kode_data_ja[$b];
                        $this->model->delete("jawaban", $kondh);
                    }
                }

                $status = "Data tersimpan";
            } else {
                $status = "File gagal diupload";
            }
        }

        return $status;
    }

    public function hapus()
    {
        if (session()->get("logged_in")) {
            $id = $this->request->uri->getSegment(3);
            $lawas = $this->model->getAllQR("SELECT gambar FROM soal where idsoal = '" . $id . "';")->gambar;
            if (strlen($lawas) > 0) {
                if (file_exists($this->modul->getPathApp() . $lawas)) {
                    unlink($this->modul->getPathApp() . $lawas);
                }
            }
            $kond['idsoal'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("soal", $kond);
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

    public function pindah_instansi()
        {
            if (session()->get("logged_in")) {
                
                $data = array(
                    'pindahsoal' => 'ya',
                );
                $kond['idsoal'] = $this->request->uri->getSegment(3);
                $simpan = $this->model->update("soal", $data, $kond);
                if ($simpan == 1) {
                    $status = "Data dipindahkan";
                } else {
                    $status = "Data gagal dipindahkan";
                }
                echo json_encode(array("status" => $status));
            } else {
                $this->modul->halaman('login');
            }
        }
    public function ajaxdetil()
    {
        if (session()->get("logged_in")) {
            $kode = $this->request->uri->getSegment(3);
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = '<input type="checkbox" name="kodesoal" value="' . $row->idsoal . '"></input>';
                $def_foto = base_url() . '/images/noimg.jpg';
                if (!is_null($row->gambar) && strlen($row->gambar)) {
                    if (file_exists($this->modul->getPathApp() . $row->gambar)) {
                        $def_foto = base_url() . '/uploads/' . $row->gambar;
                    }
                }

                // if (strlen($row->gambar) > 0) {
                //     if (file_exists($this->modul->getPathApp() . $row->gambar)) {
                //         $def_foto = base_url() . '/uploads/' . $row->gambar;
                //     }
                // }

                if ($row->gambar == '') {
                    $val[] = '-';
                } else {
                    $val[] = '<img src="' . $def_foto . '" class="img-thumbnail" style="width: 120px; height: auto;" onclick="showimg(' . "'" . $row->idsoal . "'" . ')">';
                }

                if ($row->link == '') {
                    $val[] = '(Poin ' . $row->poin . ')<br>' . $row->soal;
                } else {
                    $val[] = 'Link : <a href="' . $row->link . '" target="_blank" style="cursor:pointer;">AUDIO / VIDEO (klik)</a><br>(Poin ' . $row->poin . ')<br>' . $row->soal;
                }

                //list pilihan 
                $list_pil = $this->model->getAllQ("select * from pilihan where idsoal = '" . $row->idsoal . "';");
                $str = 'Jenis Pilihan : ' . $row->jenis . '<ol>';
                foreach ($list_pil->getResult() as $row1) {
                    $str .= '<li>' . $row1->pilihan . '</li>';
                }
                $str .= '</ol>';
                $val[] = $str;

                //list jawaban
                $list_ja = $this->model->getAllQ("select * from jawaban where idsoal = '" . $row->idsoal . "';");
                $str = '<ul>';
                foreach ($list_ja->getResult() as $row1) {
                    $str .= '<li>' . $row1->jawaban . '</li>';
                }
                $str .= '</ul>';
                $val[] = $str;
                // $val[] = '<div style="text-align: center;">'
                //     . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti(' . "'" . $row->idsoal . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                //     . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idsoal . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
                //     . '</div>';
                // $data[] = $val;
                if($row->idinstansi == NULL){
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti(' . "'" . $row->idsoal . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idsoal . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
                    . '</div>';
                }else if($row->pindahsoal == !NULL){
                    $val[] = '<div style="text-align: center;">'
                    .$instansi = $this->model->getAllQR("select * from instansi where idinstansi = '" . $row->idinstansi . "';")->nama_instansi;
                $val[] = $instansi .
                    '</div>';
                }else{
                    $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-info btn-sm" onclick="pindah_instansi(' . "'" . $row->idsoal . "'" . ');" "><i class="fa fa-fw fa-sign-out"></i>Pindah
                Soal</button>'.$instansi = $this->model->getAllQR("select * from instansi where idinstansi = '" . $row->idinstansi . "';")->nama_instansi;
                $val[] = $instansi .
                    '</div>';
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


    public function load_gambar()
    {
        if (session()->get("logged_in")) {
            $kode = $this->request->uri->getSegment(3);

            $def_foto = base_url() . '/images/noimg.jpg';
            $foto = $this->model->getAllQR("select gambar from soal where idsoal = '" . $kode . "';")->gambar;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            echo json_encode(array("foto" => $def_foto));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_upload()
    {
        if (session()->get("logged_in")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $pesan = $this->upload_xls_file();
                }
            } else {
                $pesan = "File not found";
            }
            echo json_encode(array("status" => $pesan));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function upload_xls_file()
    {
        $file = $this->request->getFile('file');
        $fileName = $file->getRandomName();
        $info_file = $this->modul->info_file($file);
        if ($info_file['ext'] == "xls" || $info_file['ext'] == "xlsx") {
            $status_upload = $file->move($this->modul->getPathApp(), $fileName);
            if ($status_upload) {
                if ($info_file['ext'] == "xls") {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
                } else if ($info_file['ext'] == "xlsx") {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }
                $spreadSheet = $reader->load($this->modul->getPathApp() . $fileName);
                $soal = $spreadSheet->getActiveSheet()->toArray();
                $q = "";
                foreach ($soal as $key => $value) {
                    if ($key == 0) {
                        continue;
                    }
                    // mencari sub topik
                    $cek_subtopik = $this->model->getAllQR("SELECT count(*) as jml FROM subtopik where code = '" . $value[0] . "';")->jml;
                    if ($cek_subtopik > 0) {
                        $idsubtopik = $this->model->getAllQR("SELECT idsubtopik FROM subtopik where code = '" . $value[0] . "';")->idsubtopik;
                        $idsoal = $this->model->autokode("E", "idsoal", "soal", 2, 7);
                        $data_soal = array(
                            'idsoal' => $idsoal,
                            'idsubtopik' => $idsubtopik,
                            'soal' => $value[1],
                            'jenis' => $this->request->getPost('jenis'),
                            'poin' => $value[2],
                            'link' => '',
                            'gambar' => ''
                        );
                        $this->model->add("soal", $data_soal);

                        if ($this->request->getPost('jenis') == "tf") {
                            // masukkan kolom jawaban
                            if (strlen($value[3]) > 0) {
                                // jawaban 1
                                $datap = array(
                                    'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                                    'idsoal' => $idsoal,
                                    'jawaban' => $value[3]
                                );
                                $this->model->add("jawaban", $datap);
                            }

                            if (strlen($value[4]) > 0) {
                                // jawaban 2
                                $datap = array(
                                    'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                                    'idsoal' => $idsoal,
                                    'jawaban' => $value[4]
                                );
                                $this->model->add("jawaban", $datap);
                            }
                        } else {
                            // masukkkan untuk jawaban
                            if (strlen($value[3]) > 0) {
                                $datap = array(
                                    'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihan", 2, 7),
                                    'idsoal' => $idsoal,
                                    'pilihan' => $value[3]
                                );
                                $this->model->add("pilihan", $datap);
                            }

                            if (strlen($value[4]) > 0) {
                                $datap = array(
                                    'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihan", 2, 7),
                                    'idsoal' => $idsoal,
                                    'pilihan' => $value[4]
                                );
                                $this->model->add("pilihan", $datap);
                            }

                            if (strlen($value[5]) > 0) {
                                $datap = array(
                                    'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihan", 2, 7),
                                    'idsoal' => $idsoal,
                                    'pilihan' => $value[5]
                                );
                                $this->model->add("pilihan", $datap);
                            }

                            if (strlen($value[6]) > 0) {
                                $datap = array(
                                    'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihan", 2, 7),
                                    'idsoal' => $idsoal,
                                    'pilihan' => $value[6]
                                );
                                $this->model->add("pilihan", $datap);
                            }

                            if (strlen($value[7]) > 0) {
                                $datap = array(
                                    'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihan", 2, 7),
                                    'idsoal' => $idsoal,
                                    'pilihan' => $value[7]
                                );
                                $this->model->add("pilihan", $datap);
                            }

                            // masukkan kolom jawaban
                            if (strlen($value[8]) > 0) {
                                // jawaban 1
                                $datap = array(
                                    'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                                    'idsoal' => $idsoal,
                                    'jawaban' => $value[8]
                                );
                                $this->model->add("jawaban", $datap);
                            }

                            if (strlen($value[9]) > 0) {
                                // jawaban 2
                                $datap = array(
                                    'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                                    'idsoal' => $idsoal,
                                    'jawaban' => $value[9]
                                );
                                $this->model->add("jawaban", $datap);
                            }

                            if (strlen($value[10]) > 0) {
                                // jawaban 3
                                $datap = array(
                                    'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                                    'idsoal' => $idsoal,
                                    'jawaban' => $value[10]
                                );
                                $this->model->add("jawaban", $datap);
                            }

                            if (strlen($value[11]) > 0) {
                                // jawaban 4
                                $datap = array(
                                    'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                                    'idsoal' => $idsoal,
                                    'jawaban' => $value[11]
                                );
                                $this->model->add("jawaban", $datap);
                            }

                            if (strlen($value[12]) > 0) {
                                // jawaban 5
                                $datap = array(
                                    'idjawaban' => $this->model->autokode("J", "idjawaban", "jawaban", 2, 7),
                                    'idsoal' => $idsoal,
                                    'jawaban' => $value[12]
                                );
                                $this->model->add("jawaban", $datap);
                            }
                        }
                    }
                }

                // unlink link excel
                unlink($this->modul->getPathApp() . $fileName);

                $status = "Data tersimpan";
            } else {
                $status = "File excel gagal terupload";
            }
        } else {
            $status = "Bukan format file excel";
        }

        return $status;
    }

    public function hapussemua()
    {
        if (session()->get("logged_in")) {
            $hasil = explode(",", $this->request->getPost('hasil'));

            $hapus = "";
            for ($b = 0; $b < count($hasil); $b++) {
                $id = $hasil[$b];
                $lawas = $this->model->getAllQR("SELECT gambar FROM soal where idsoal = '" . $id . "';")->gambar;
                if (strlen($lawas) > 0) {
                    if (file_exists($this->modul->getPathApp() . $lawas)) {
                        unlink($this->modul->getPathApp() . $lawas);
                    }
                }
                $kond['idsoal'] = $id;
                $this->model->delete("soal", $kond);
                $hapus = 1;
            }

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

    public function pindah()
    {
        if (session()->get("logged_in")) {
            $hasil = explode(",", $this->request->getPost('hasil'));

            $hapus = "";
            for ($b = 0; $b < count($hasil); $b++) {
                $data = array(
                    'idsubtopik' => $this->request->getPost('idsubtopik'),
                );
                $kond['idsoal'] = $hasil[$b];
                $this->model->update("soal", $data, $kond);
                $update = 1;
            }
            if ($update == 1) {
                $status = "Soal berhasil dipindahkan";
            } else {
                $status = "Soal gagal dipindahkan";
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }
}