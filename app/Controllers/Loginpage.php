<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Loginpage extends BaseController {
    
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
        
        echo view('front/head2', $data);
        echo view('back/loginpage', $data);
    }
    
    
}