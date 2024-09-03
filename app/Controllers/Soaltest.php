<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Soaltest extends BaseController
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

            $data['bidang'] = $this->model->getAllQ("SELECT * FROM bidang where status = 'Aktif';");

            echo view('back/head', $data);
            echo view('back/menu');
            echo view('back/test/index');
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
            $list = $this->model->getAll("bidang");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = '<a href="' . base_url() . '/diagnostictest/start/' . $this->modul->enkrip_url($row->idbidang) . '" target="_blank">' . $row->namabidang . '</a>';
                $val[] = $row->status;
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-success btn-fw" onclick="instruksi(' . "'" . $row->idbidang . "'" . ')">Tambah</button>&nbsp;'
                    . '</div>';
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="scoring(' . "'" . $row->idbidang . "'" . ')">Scoring</button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-primary btn-fw" onclick="nilai(' . "'" . $row->idbidang . "'" . ')">Komentar Nilai</button>&nbsp;'
                    . '</div>';
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti(' . "'" . $row->idbidang . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idbidang . "'" . ',' . "'" . $row->namabidang . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-success btn-fw" onclick="soal(' . "'" . $row->idbidang . "'" . ')"><i class="fa fa-fw fa-plus-square"></i> Buat Soal</button>&nbsp;'
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

    public function detil()
    {
        if (session()->get("logged_in")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $idrole = session()->get("role");
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
            $data['head'] = $this->model->getAllQR("SELECT * FROM bidang where idbidang = '" . $kode . "';");
            $data['bidang'] = $this->model->getAllQ("SELECT * FROM bidang where status = 'Aktif'");

            echo view('back/head', $data);
            if ($idrole == "R00001") {
                echo view('back/menu');
            }
            echo view('back/test/detail');
            echo view('back/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_add()
    {
        if (session()->get("logged_in")) {
            $getidsoal = $this->model->autokode("E", "idsoal", "soaltest", 2, 7);

            $data = array(
                'idsoal' => $getidsoal,
                'idbidang' => $this->request->getPost('idbidang'),
                'soal' => $this->request->getPost('soal'),
                'jenis' => $this->request->getPost('jenis'),
                'poin' => $this->request->getPost('poin'),
                'batas' => $this->request->getPost('batas'),
            );
            $this->model->add("soaltest", $data);

            $data_pil = explode(",", $this->request->getPost('pilihan'));
            for ($i = 0; $i < count($data_pil); $i++) {
                if ($data_pil[$i] != "") {
                    $datap = array(
                        'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihantest", 2, 7),
                        'idsoal' => $getidsoal,
                        'pilihan' => $data_pil[$i]
                    );
                    $this->model->add("pilihantest", $datap);
                }
            }

            $data_ja = explode(",", $this->request->getPost('jawaban'));
            for ($i = 0; $i < count($data_ja); $i++) {
                if ($data_ja[$i] != "") {
                    $datap = array(
                        'idjawaban' => $this->model->autokode("J", "idjawaban", "jawabantest", 2, 7),
                        'idsoal' => $getidsoal,
                        'jawaban' => $data_ja[$i]
                    );
                    $this->model->add("jawabantest", $datap);
                }
            }
            $status = "Data tersimpan";

            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ganti()
    {
        if (session()->get("logged_in")) {
            $kondisi['idsoal'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("soaltest", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function aksespilihan()
    {
        if (session()->get("logged_in")) {
            $idsoal = $this->request->getUri()->getSegment(3);
            $str = '';
            $counter = 1;
            $list = $this->model->getAllQ("select * from pilihantest where idsoal = '" . $idsoal . "';");
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
            $idsoal = $this->request->getUri()->getSegment(3);
            $str = '';
            $counter = 1;
            $list = $this->model->getAllQ("select * from jawabantest where idsoal = '" . $idsoal . "';");
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
            $kode = $this->request->getPost('kode');
            $kond['idsoal'] = $this->request->getPost('kode');
            $data = array(
                'idbidang' => $this->request->getPost('idbidang'),
                'soal' => $this->request->getPost('soal'),
                'jenis' => $this->request->getPost('jenis'),
                'poin' => $this->request->getPost('poin'),
                'batas' => $this->request->getPost('batas'),
            );
            $this->model->update("soaltest", $data, $kond);

            //pilihan
            $kode_data_pil = explode(",", $this->request->getPost('kode_pilihan'));
            $data_pil = explode(",", $this->request->getPost('pilihan'));
            for ($i = 0; $i < count($data_pil); $i++) {
                if (strlen($data_pil[$i]) > 0) {
                    $cek = $this->model->getAllQR("select count(*) as jml from pilihantest where idpilihan = '" . $kode_data_pil[$i] . "';")->jml;
                    if ($cek > 0) {
                        $datap = array(
                            'pilihan' => $data_pil[$i]
                        );
                        $kond['idpilihan'] = $kode_data_pil[$i];
                        $this->model->update("pilihantest", $datap, $kond);
                    } else {
                        $datap = array(
                            'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihantest", 2, 7),
                            'idsoal' => $this->request->getPost('kode'),
                            'pilihan' => $data_pil[$i]
                        );
                        $this->model->add("pilihantest", $datap);
                    }
                } else {
                    //hapus
                    $kondhapus['idpilihan'] = $kode_data_pil[$i];
                    $this->model->delete("pilihantest", $kondhapus);
                }
            }

            //jawaban
            $kode_data_ja = explode(",", $this->request->getPost('kode_jawaban'));
            $data_ja = explode(",", $this->request->getPost('jawaban'));
            for ($b = 0; $b < count($data_ja); $b++) {
                if (strlen($data_ja[$b]) > 0) {
                    $cek = $this->model->getAllQR("select count(*) as jml from jawabantest where idjawaban = '" . $kode_data_ja[$b] . "';")->jml;
                    if ($cek > 0) {
                        $dataj = array(
                            'jawaban' => $data_ja[$b]
                        );
                        $kon['idjawaban'] = $kode_data_ja[$b];
                        $this->model->update("jawabantest", $dataj, $kon);
                    } else {
                        $dataj = array(
                            'idjawaban' => $this->model->autokode("J", "idjawaban", "jawabantest", 2, 7),
                            'idsoal' => $this->request->getPost('kode'),
                            'jawaban' => $data_ja[$b]
                        );
                        $this->model->add("jawabantest", $dataj);
                    }
                } else {
                    //hapus
                    $kondh['idjawaban'] = $kode_data_ja[$b];
                    $this->model->delete("jawabantest", $kondh);
                }
            }

            $status = "Data tersimpan";

            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function hapus()
    {
        if (session()->get("logged_in")) {
            $id = $this->request->getUri()->getSegment(3);
            $lawas = $this->model->getAllQR("SELECT gambar FROM soaltest where idsoal = '" . $id . "';")->gambar;
            if (strlen($lawas) > 0) {
                if (file_exists($this->modul->getPathApp() . $lawas)) {
                    unlink($this->modul->getPathApp() . $lawas);
                }
            }
            $kond['idsoal'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("soaltest", $kond);
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

    public function ajaxdetil()
    {
        if (session()->get("logged_in")) {
            $kode = $this->request->getUri()->getSegment(3);
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from soaltest where idbidang = '" . $kode . "';");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = '<input type="checkbox" name="kodesoal" value="' . $row->idsoal . '"></input>';
                $def_foto = base_url() . 'front/images/noimg.png';
                if (strlen($row->gambar) > 0) {
                    if (file_exists($this->modul->getPathApp() . $row->gambar)) {
                        $def_foto = base_url() . '/uploads/' . $row->gambar;
                    }
                }

                $def_audio = '';
                if (strlen($row->audio) > 0) {
                    if (file_exists($this->modul->getPathApp() . $row->audio)) {
                        $def_audio = base_url() . '/uploads/' . $row->audio;
                    }
                }

                if ($row->gambar == '') {
                    $val[] = '-';
                } else {
                    $val[] = '<img src="' . $def_foto . '" class="img-thumbnail" style="width: 120px; height: auto;" onclick="showimg(' . "'" . $row->idsoal . "'" . ')">';
                }

                if ($row->audio == '') {
                    $val[] = '(Poin ' . $row->poin . ')<br>' . $row->soal;
                } else {
                    $val[] = 'Audio : <audio controls>
                    <source src="' . $def_audio . '" type="audio/ogg">
                  Your browser does not support the audio element.
                  </audio>(Poin ' . $row->poin . ')<br>' . $row->soal;
                }

                //Jenis
                $val[] = $row->jenis;

                //list pilihan 
                $list_pil = $this->model->getAllQ("select * from pilihantest where idsoal = '" . $row->idsoal . "';");
                $str = '';
                if ($row->tipe != null) {
                    $str .= 'Tipe Soal : ' . $row->tipe;
                }
                $str .= '<ol>';
                foreach ($list_pil->getResult() as $row1) {
                    $str .= '<li>' . htmlspecialchars($row1->pilihan) . '</li>';
                }
                $str .= '</ol>';
                $val[] = $str;

                //list jawaban
                $list_ja = $this->model->getAllQ("select * from jawabantest where idsoal = '" . $row->idsoal . "';");
                $str = '<ul>';
                foreach ($list_ja->getResult() as $row1) {
                    $str .= '<li>' . htmlspecialchars($row1->jawaban) . '</li>';
                }
                $str .= '</ul>';
                $val[] = $str;
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti(' . "'" . $row->idsoal . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idsoal . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
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

    public function load_gambar()
    {
        if (session()->get("logged_in")) {
            $kode = $this->request->getUri()->getSegment(3);

            $def_foto = base_url() . 'front/images/noimg.png';
            $foto = $this->model->getAllQR("select gambar from soaltest where idsoal = '" . $kode . "';")->gambar;
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

    //belum
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

                    $idbidang = $this->request->getPost('idbidang');
                    $idsoal = $this->model->autokode("E", "idsoal", "soaltest", 2, 7);
                    $data_soal = array(
                        'idsoal' => $idsoal,
                        'idbidang' => $idbidang,
                        'jenis' => $value[0],
                        'soal' => $value[1],
                        'tipe' => $value[2],
                        'link' => $value[3],
                        'poin' => $value[4],
                    );
                    $this->model->add("soaltest", $data_soal);

                    // masukkkan untuk pilihan
                    if (strlen($value[5]) > 0) {
                        $datap = array(
                            'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihantest", 2, 7),
                            'idsoal' => $idsoal,
                            'pilihan' => $value[5]
                        );
                        $this->model->add("pilihantest", $datap);
                    }

                    if (strlen($value[6]) > 0) {
                        $datap = array(
                            'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihantest", 2, 7),
                            'idsoal' => $idsoal,
                            'pilihan' => $value[6]
                        );
                        $this->model->add("pilihantest", $datap);
                    }

                    if (strlen($value[7]) > 0) {
                        $datap = array(
                            'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihantest", 2, 7),
                            'idsoal' => $idsoal,
                            'pilihan' => $value[7]
                        );
                        $this->model->add("pilihantest", $datap);
                    }

                    if (strlen($value[8]) > 0) {
                        $datap = array(
                            'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihantest", 2, 7),
                            'idsoal' => $idsoal,
                            'pilihan' => $value[8]
                        );
                        $this->model->add("pilihantest", $datap);
                    }

                    if (strlen($value[9]) > 0) {
                        $datap = array(
                            'idpilihan' => $this->model->autokode("P", "idpilihan", "pilihantest", 2, 7),
                            'idsoal' => $idsoal,
                            'pilihan' => $value[9]
                        );
                        $this->model->add("pilihantest", $datap);
                    }

                    // masukkan kolom jawaban
                    if (strlen($value[10]) > 0) {
                        // jawaban 1
                        $datap = array(
                            'idjawaban' => $this->model->autokode("J", "idjawaban", "jawabantest", 2, 7),
                            'idsoal' => $idsoal,
                            'jawaban' => $value[10]
                        );
                        $this->model->add("jawabantest", $datap);
                    }

                    if (strlen($value[11]) > 0) {
                        // jawaban 2
                        $datap = array(
                            'idjawaban' => $this->model->autokode("J", "idjawaban", "jawabantest", 2, 7),
                            'idsoal' => $idsoal,
                            'jawaban' => $value[11]
                        );
                        $this->model->add("jawabantest", $datap);
                    }

                    if (strlen($value[12]) > 0) {
                        // jawaban 3
                        $datap = array(
                            'idjawaban' => $this->model->autokode("J", "idjawaban", "jawabantest", 2, 7),
                            'idsoal' => $idsoal,
                            'jawaban' => $value[12]
                        );
                        $this->model->add("jawabantest", $datap);
                    }

                    if (strlen($value[13]) > 0) {
                        // jawaban 4
                        $datap = array(
                            'idjawaban' => $this->model->autokode("J", "idjawaban", "jawabantest", 2, 7),
                            'idsoal' => $idsoal,
                            'jawaban' => $value[13]
                        );
                        $this->model->add("jawabantest", $datap);
                    }

                    if (strlen($value[14]) > 0) {
                        // jawaban 5
                        $datap = array(
                            'idjawaban' => $this->model->autokode("J", "idjawaban", "jawabantest", 2, 7),
                            'idsoal' => $idsoal,
                            'jawaban' => $value[14]
                        );
                        $this->model->add("jawabantest", $datap);
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

                $lawas2 = $this->model->getAllQR("SELECT audio FROM soal where idsoal = '" . $id . "';")->audio;
                if (strlen($lawas2) > 0) {
                    if (file_exists($this->modul->getPathApp() . $lawas2)) {
                        unlink($this->modul->getPathApp() . $lawas2);
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
                    'idbidang' => $this->request->getPost('idbidang'),
                );
                $kond['idsoal'] = $hasil[$b];
                $this->model->update("soaltest", $data, $kond);
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

    public function unggah_audio()
    {
        if (session()->get("logged_in")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $file = $this->request->getFile('file');
                    $fileName = $file->getRandomName();
                    $info_file = $this->modul->info_file($file);

                    if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
                        $status = "Gunakan nama file lain";
                    } else {
                        $status_upload = $file->move($this->modul->getPathApp(), $fileName);
                        if ($status_upload) {
                            $getidsoal = $this->model->autokode("E", "idsoal", "soaltest", 2, 7);
                            $data = array(
                                'idsoal' => $getidsoal,
                                'idbidang' => $this->request->getPost('idbidang'),
                                'audio' => $fileName
                            );
                            $simpan = $this->model->add("soaltest", $data);

                            if ($simpan == 1) {
                                $pesan = "Audio tersimpan";
                            } else {
                                $pesan = "Audio gagal tersimpan";
                            }
                        } else {
                            $pesan = "File gagal diupload";
                        }
                    }
                }
            } else {
                $pesan = "File not found";
            }
            echo json_encode(array("status" => $pesan, "ids" => $getidsoal));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function edit_audio()
    {
        if (session()->get("logged_in")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $lawas = $this->model->getAllQR("SELECT audio FROM soaltest where idsoal = '" . $this->request->getPost('kode') . "';")->audio;
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
                            $getidsoal = $this->request->getPost('kode');
                            $kond['idsoal'] = $this->request->getPost('kode');
                            $data = array(
                                'audio' => $fileName
                            );
                            $update = $this->model->update("soaltest", $data, $kond);

                            if ($update == 1) {
                                $pesan = "Audio terupdate";
                            } else {
                                $pesan = "Audio gagal terupdate";
                            }
                        } else {
                            $pesan = "File gagal diupload";
                        }
                    }
                }
            } else {
                $pesan = "File not found";
            }
            echo json_encode(array("status" => $pesan, "ids" => $getidsoal));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function unggah_gambar()
    {
        if (session()->get("logged_in")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $file = $this->request->getFile('file');
                    $fileName = $file->getRandomName();
                    $info_file = $this->modul->info_file($file);

                    if (file_exists($this->modul->getPathApp() . '/' . $fileName)) {
                        $status = "Gunakan nama file lain";
                    } else {
                        $status_upload = $file->move($this->modul->getPathApp(), $fileName);
                        if ($status_upload) {
                            $getidsoal = $this->model->autokode("E", "idsoal", "soaltest", 2, 7);
                            $data = array(
                                'idsoal' => $getidsoal,
                                'idbidang' => $this->request->getPost('idbidang'),
                                'gambar' => $fileName
                            );
                            $simpan = $this->model->add("soaltest", $data);

                            if ($simpan == 1) {
                                $pesan = "Gambar tersimpan";
                            } else {
                                $pesan = "Gambar gagal tersimpan";
                            }
                        } else {
                            $pesan = "File gagal diupload";
                        }
                    }
                }
            } else {
                $pesan = "File not found";
            }
            echo json_encode(array("status" => $pesan, "ids" => $getidsoal));
        } else {
            $this->modul->halaman('login');
        }
    }

    public function edit_gambar()
    {
        if (session()->get("logged_in")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $pesan = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $lawas = $this->model->getAllQR("SELECT gambar FROM soaltest where idsoal = '" . $this->request->getPost('kode') . "';")->gambar;
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
                            $getidsoal = $this->request->getPost('kode');
                            $kond['idsoal'] = $this->request->getPost('kode');
                            $data = array(
                                'gambar' => $fileName
                            );
                            $update = $this->model->update("soaltest", $data, $kond);

                            if ($update == 1) {
                                $pesan = "Gambar terupdate";
                            } else {
                                $pesan = "Gambar gagal terupdate";
                            }
                        } else {
                            $pesan = "File gagal diupload";
                        }
                    }
                }
            } else {
                $pesan = "File not found";
            }
            echo json_encode(array("status" => $pesan, "ids" => $getidsoal));
        } else {
            $this->modul->halaman('login');
        }
    }
}
