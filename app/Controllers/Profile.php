<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Profile extends BaseController
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
        if (session()->get("logged_admin") || session()->get("logged_guru") || session()->get("logged_instansi") || session()->get("logged_siswa")) {

            $data['idusers'] = session()->get("idusers");
            $data['nama'] = session()->get("nama");
            $data['email'] = session()->get("email");
            $data['wa'] = session()->get("wa");
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

            $role = session()->get("role");
            if ($role === 'R00001') {

                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_admin');
                echo view('page/menu/profile/index');
                echo view('page/menu/layout/foot');
            } else if ($role === 'R00002') {
                echo view('page/menu/layout/head', $data);
                echo view('page/menu/menu_guru');
                echo view('page/menu/profile/index');
                echo view('page/menu/layout/foot');
            } else if ($role === 'R00003') {
                $idusers = session()->get("idusers");
                $history_subs = $this->model->getAllQR(" SELECT status, tgl_berakhir, checkout_link FROM history_subscribe WHERE idusers = '" . $idusers . "' ");
                $pakethabis = false;
                if ($history_subs) {
                    try {
                        $today = date("Y-m-d");
                        $tglBerakhir = date("Y-m-d", strtotime($history_subs->tgl_berakhir));
                        $diff = (strtotime($tglBerakhir) - strtotime($today)) / 86400; // 86400 = 1 hari dalam detik
                        if ($diff < 0) {
                            $pakethabis = true;
                        }
                    } catch (\Exception $e) {
                        // Tangani error jika terjadi masalah
                        echo "Error: " . $e->getMessage();
                    }
                }


                if ($history_subs !== NULL) {
                    if ($history_subs->status === "Paid") {
                        $data['showSessionMenu'] = true;
                        session()->remove('notification_pending');
                    } else {
                        session()->remove('free');
                    }
                }
                if ($history_subs === null || $history_subs->status === 'Pending') {
                    $data['showSessionMenu'] = false;

                }
                $instansi = session()->get("idinstansi");
                $siswaluar_free = session()->get("school_name") !== NULL && session()->get("siswa_luar") === 1 && $history_subs === NULL;
                $data['free'] = $instansi === NULL && $history_subs === NULL || $siswaluar_free;
                if ($data['free'] === true) {
                    $notificationMsg = "You are currently using a free account. Please subscribe to access exclusive feature.";
                    session()->setFlashdata('notification_free', $notificationMsg);
                }

                $data['pakethabis'] = $pakethabis;


                echo view('page/dashboardsiswa/layout/head', $data);
                echo view('page/dashboardsiswa/profile/index');
                echo view('page/dashboardsiswa/layout/foot');
            }
        } else {
            $this->modul->halaman('login');
        }
    }

    public function proses()
    {
        if (session()->get("logged_admin") || session()->get("logged_guru") || session()->get("logged_instansi") || session()->get("logged_siswa")) {
            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    $status = "Error during file upload " . $_FILES['file']['error'];
                } else {
                    $status = $this->update_file();
                }
            } else {
                $status = $this->update();
            }
            echo json_encode(array("status" => $status));
        } else {
            $this->modul->halaman('login');
        }
    }

    private function update_file()
    {
        $idusers = session()->get("idusers");
        $lawas = $this->model->getAllQR("SELECT foto FROM users where idusers = '" . $idusers . "';")->foto;
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
                $role = session()->get("role");
                if ($role === 'R00001') {
                    $data = array(
                        'email' => $this->request->getPost('email'),
                        'nama' => $this->request->getPost('nama'),
                        'wa' => $this->request->getPost('wa'),
                        'foto' => $fileName
                    );
                } else {
                    $data = array(
                        'nama' => $this->request->getPost('nama'),
                        'wa' => $this->request->getPost('wa'),
                        'foto' => $fileName
                    );
                }
                $kond['idusers'] = $idusers;
                $update = $this->model->update("users", $data, $kond);
                if ($update == 1) {
                    $status = "Data terupdate";
                } else {
                    $status = "Data gagal terupdate";
                }
            } else {
                $status = "File gagal terupload";
            }
        }
        return $status;
    }

    private function update()
    {
        $idusers = session()->get("idusers");
        $role = session()->get("role");
        if ($role === 'R00001') {
            $data = array(
                'email' => $this->request->getPost('email'),
                'nama' => $this->request->getPost('nama'),
                'wa' => $this->request->getPost('wa'),
            );
        } else {
            $data = array(
                'nama' => $this->request->getPost('nama'),
                'wa' => $this->request->getPost('wa'),
            );
        }

        $kond['idusers'] = $idusers;
        $update = $this->model->update("users", $data, $kond);
        if ($update == 1) {
            $status = "Data terupdate";
        } else {
            $status = "Data gagal terupdate";
        }
        return $status;
    }
}