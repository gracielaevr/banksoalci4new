<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Jadwalkonsultasi extends BaseController
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
            $data['users'] = $this->model->getAllQ("select * from users WHERE idrole='R00002'");
            echo view('page/menu/layout/head', $data);
            echo view('page/menu/menu_admin');
            echo view('page/menu/jadwalkonsultasi/index');
            echo view('page/menu/layout/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function jadwalguru()
    {
        if (session()->get("logged_guru")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            // membaca foto profile
            $def_foto = base_url() . 'front/images/noimg.png';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;


            // Fetch all consultations
            $consultations = $this->model->getAllQ("SELECT * FROM konsultasi WHERE idusers = '" . session()->get("idusers") . "' AND tanggal >= CURDATE() ORDER BY tanggal DESC;");
            $events = [];
            $currentDate = date('Y-m-d'); // Ambil tanggal hari ini

            foreach ($consultations->getResult() as $row) {
                // Get the idusers from history_session based on idkonsultasi
                $history = $this->model->getAllQ("SELECT idusers FROM history_session WHERE idkonsultasi = '" . $row->idkonsultasi . "';")->getRow();

                if ($history) {
                    // Get the user name based on idusers
                    $user = $this->model->getAllQ("SELECT nama FROM users WHERE idusers = '" . $history->idusers . "';")->getRow();
                    $nama_user = $user ? $user->nama : 'Not Yet';
                } else {
                    $nama_user = 'Not Yet'; // Default if no history found
                }

                // Tentukan warna berdasarkan tanggal
                $backgroundColor = ($row->tanggal == $currentDate) ? '#28a745' : '#6c757d'; // Hijau untuk hari ini, abu-abu untuk masa depan

                // Create event with user name
                $events[] = [
                    'id' => $row->idkonsultasi,
                    'title' => $nama_user, // Display name on top
                    'start' => $row->tanggal, // Date
                    'description' => $row->waktu . ' WIB', // Add time under the title
                    'backgroundColor' => $backgroundColor, // Warna sesuai kondisi
                ];
            }
            $data['events'] = json_encode($events); // Pass the events as JSON to the view

            echo view('page/menu/layout/head', $data);
            echo view('page/menu/menu_guru');
            echo view('page/menu/jadwalguru/index', $data);
            echo view('page/menu/layout/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function datasiswa()
    {
        if (session()->get("logged_guru")) {
            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['role'] = session()->get("role");
            $data['nm_role'] = session()->get("nama_role");

            $def_foto = base_url() . 'front/images/noimg.png';
            $foto = $this->model->getAllQR("select foto from users where idusers = '" . session()->get("idusers") . "';")->foto;
            if (strlen($foto) > 0) {
                if (file_exists($this->modul->getPathApp() . $foto)) {
                    $def_foto = base_url() . '/uploads/' . $foto;
                }
            }
            $data['foto_profile'] = $def_foto;

            echo view('page/menu/layout/head', $data);
            echo view('page/menu/menu_guru');
            echo view('page/menu/siswa/datasiswa', $data);
            echo view('page/menu/layout/foot');
        } else {
            $this->modul->halaman('login');
        }
    }

    public function siswalist()
    {
        if (session()->get("logged_guru")) {
            $data = array();
            $no = 1;

            $list = $this->model->getAllQ(" SELECT hs.*, k.*, hs.idusers FROM history_session hs JOIN konsultasi k ON k.idkonsultasi = hs.idkonsultasi WHERE k.idusers = '" . session()->get('idusers') . "' AND hs.booked = 1 ORDER BY hs.idkonsultasi DESC;");


            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $user = $this->model->getAllQR("SELECT * FROM users WHERE idusers = '" . $row->idusers . "';")->nama;
                $val[] = $user;
                $val[] = date('d-m-Y', strtotime($row->tanggal)) . ' - ' . date('H:i', strtotime($row->waktu));
                $val[] = '<a target="_blank" href="' . $row->linkzoom . '">' . $row->linkzoom . '</a>';
                $val[] = $row->durasi . ' (Menit)';
                // Cek file gambar
                $def_foto = base_url() . '/uploads/default.png'; // Gambar default
                if (!is_null($row->file) && strlen($row->file)) {
                    if (file_exists($this->modul->getPathApp() . $row->file)) {
                        $def_foto = base_url() . '/uploads/' . $row->file;
                    }
                }

                // Buat link klik dari pertanyaan
                $pertanyaan = preg_replace(
                    '/(https?:\/\/[^\s]+)/',
                    '<a href="$1" target="_blank">$1</a>',
                    $row->pertanyaan
                );
                // Tambahkan tombol untuk catatan ke array catatan

                // Gabungkan gambar dengan pertanyaan
                $pertanyaanContent = $pertanyaan . '<br><br>' .
                    '<div style="text-align: center;">' .
                    '<img src="' . $def_foto . '" class="img-thumbnail zoom-image" style="width: 200px; height: auto; cursor: pointer;" ' .
                    'onclick="zoomImage(\'' . $def_foto . '\')">' .
                    '</div>';

                // Tambahkan tombol untuk pertanyaan ke array pertanyaan
                $val[] = $pertanyaanContent;

                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw m-0" onclick="openModal(' . "'" . $row->idsession . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
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

    public function ajaxlist()
    {
        if (session()->get("logged_admin")) {
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("SELECT * FROM konsultasi ORDER BY tanggal DESC;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                $val[] = $row->tanggal;
                $val[] = date('H:i', strtotime($row->waktu));
                $val[] = '<a target="_blank" href="' . $row->linkzoom . '">' . $row->linkzoom . '</a>';
                $val[] = $row->durasi . ' (Menit)';
                // $val[] = $row->catatan;
                $users = $this->model->getAllQR("SELECT * FROM users WHERE idusers = '" . $row->idusers . "';")->nama;
                $val[] = $users;
                $val[] = '<div style="text-align: center;">'
                    . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti(' . "'" . $row->idkonsultasi . "'" . ')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                    . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus(' . "'" . $row->idkonsultasi . "'" . ',' . "'" . $row->tanggal . "'" . ')"><i class="fa fa-fw fa-trash"></i></button>'
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
                'idkonsultasi' => $this->model->autokode("K", "idkonsultasi", "konsultasi", 2, 7),
                'tanggal' => $this->request->getPost('tanggal'),
                'waktu' => $this->request->getPost('waktu'),
                'linkzoom' => $this->request->getPost('linkzoom'),
                'durasi' => $this->request->getPost('durasi'),
                // 'catatan' => $this->request->getPost('catatan'),
                'idusers' => $this->request->getPost('idusers'),
            );
            $simpan = $this->model->add("konsultasi", $data);

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
            $kondisi['idkonsultasi'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("konsultasi", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }

    public function ajax_edit()
    {
        if (session()->get("logged_admin")) {
            $data = array(
                'idkonsultasi' => $this->request->getPost('idkonsultasi'),
                'tanggal' => $this->request->getPost('tanggal'),
                'waktu' => $this->request->getPost('waktu'),
                'linkzoom' => $this->request->getPost('linkzoom'),
                'durasi' => $this->request->getPost('durasi'),
                // 'catatan' => $this->request->getPost('catatan'),
                'idusers' => $this->request->getPost('idusers'),
            );
            $kond['idkonsultasi'] = $this->request->getPost('idkonsultasi');
            $update = $this->model->update("konsultasi", $data, $kond);
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
            $kond['idkonsultasi'] = $this->request->getUri()->getSegment(3);
            $hapus = $this->model->delete("konsultasi", $kond);
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

    public function ajax_edit1()
    {
        if (session()->get("logged_guru")) {
            $data = array(
                'idsession' => $this->request->getPost('idsession'),
                'catatan' => $this->request->getPost('catatan'),
            );
            $kond['idsession'] = $this->request->getPost('idsession');
            $update = $this->model->update("history_session", $data, $kond);
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

    public function ganti1()
    {
        if (session()->get("logged_guru")) {
            $kondisi['idsession'] = $this->request->getUri()->getSegment(3);
            $data = $this->model->get_by_id("history_session", $kondisi);
            echo json_encode($data);
        } else {
            $this->modul->halaman('login');
        }
    }
}