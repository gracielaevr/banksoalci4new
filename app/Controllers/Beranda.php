<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Beranda extends BaseController{
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function index(){
        $db      = \Config\Database::connect();
        $builder = $db->table('topik');
        $query   = $builder->get()->getResult();
        $data['topik'] = $query;
        
        echo view('front/head2');
        echo view('front/home', $data);
    }

}