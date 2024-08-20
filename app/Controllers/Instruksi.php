<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Instruksi extends BaseController {

    private $model;
    private $modul;

    public function __construct() {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function ajax_add() {
        if(session()->get("logged_admin")){
            $data = array(
                'idinstruksi' => $this->model->autokode("I","idinstruksi","instruksi", 2, 7),
                'idbidang' => $this->request->getPost('idbidang'),
                'instruksi' => $this->request->getPost('instruksi'),
            );
            $simpan = $this->model->add("instruksi",$data);
            if($simpan == 1){
                $status = "Data tersimpan";
            }else{
                $status = "Data gagal tersimpan";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ganti(){
        if(session()->get("logged_admin")){
            $kondisi['idbidang'] = $this->request->uri->getSegment(3);
            $data = $this->model->get_by_id("instruksi", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_admin")){
            $data = array(
                'instruksi' => $this->request->getPost('instruksi'),
            );
            $kond['idinstruksi'] = $this->request->getPost('kode');
            $update = $this->model->update("instruksi",$data, $kond);
            if($update == 1){
                $status = "Data terupdate";
            }else{
                $status = "Data gagal terupdate";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function hapus() {
        if(session()->get("logged_admin")){
            $kond['idinstruksi'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("instruksi",$kond);
            if($hapus == 1){
                $status = "Data terhapus";
            }else{
                $status = "Data gagal terhapus";
            }
            echo json_encode(array("status" => $status));
        }else{
            $this->modul->halaman('login');
        }
    }

}