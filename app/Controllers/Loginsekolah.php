<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Loginsekolah extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        $cek = $this->model->getAllQR("SELECT count(*) as jml FROM identitas;")->jml;
        if($cek > 0){
            $tersimpan = $this->model->getAllQR("SELECT * FROM identitas;");
            $deflogo = base_url().'/images/noimg.jpg';
            if(strlen($tersimpan->logo) > 0){
                if(file_exists($this->modul->getPathApp().$tersimpan->logo)){
                    $deflogo = base_url().'/uploads/'.$tersimpan->logo;
                }
            }
            $data['logo'] = $deflogo;

        }else{
            $data['logo'] = base_url().'/images/noimg.jpg';
        }
            
        echo view('back/loginsiswa', $data);
    }
    
    public function proses() {
        clearstatcache();
        
        $user = strtolower(trim($this->request->getPost('email')));
        $pass = trim($this->request->getPost('pass'));
        $enkrip_pass = $this->modul->enkrip_pass($pass);
        $jml = $this->model->getAllQR("SELECT count(*) as jml FROM users where email = '".$user."';")->jml;
        if($jml > 0){
            $jml1 = $this->model->getAllQR("select count(*) as jml from users where email = '".$user."' and pass = '".$enkrip_pass."';")->jml;
            if($jml1 > 0){
                $data = $this->model->getAllQR("select a.idusers, a.nama, a.idrole, a.email, b.nama_role from users a, role b where a.idrole = b.idrole and a.email = '".$user."';");
                if($data->idrole == "R00001"){
                    // ADMIN
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_in' => TRUE,
                        'logged_admin' => TRUE
                    ]);
                    $pesan = "ok";
                }else{
                    session()->set([
                        'idusers' => $data->idusers,
                        'nama' => $data->nama,
                        'role' => $data->idrole,
                        'nama_role' => $data->nama_role,
                        'email' => $data->email,
                        'logged_in' => TRUE
                    ]);
                    $pesan = "ok_guru";
                }
            }else{
                $pesan = "Anda tidak berhak mengakses !";
            }
        }else{
            $pesan = "Maaf, user tidak ditemukan !";
        }
        echo json_encode(array("status" => $pesan));
    }
    
    public function logout(){
        session()->destroy();
        clearstatcache();
        
        $this->modul->halaman('logininstansi');
    }
    
}