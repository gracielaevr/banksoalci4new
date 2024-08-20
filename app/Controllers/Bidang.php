<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Bidang extends BaseController {
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function ajaxlist() {
        if(session()->get("logged_admin")){
            $data = array();
            $no = 1;
            $list = $this->model->getAllQ("select * from topik order by best desc;");
            foreach ($list->getResult() as $row) {
                $val = array();
                $val[] = $no;
                if($row->best != 0){
                    $val[] = '('.$row->best.'<i class="fa fa-fw fa-star-o"></i>)  '.$row->code.' - '.$row->nama;
                }else{
                    $val[] = $row->code.' - '.$row->nama;
                }
                // membaca jml subtopik
                $jml_subtopik = $this->model->getAllQR("SELECT count(*) as jml FROM subtopik where idtopik = '".$row->idtopik."';")->jml;
                if($jml_subtopik > 0){
                $str = '<table class="table table-striped" style="width: 100%;">
                            <tbody>';
                $list_subs = $this->model->getAllQ("select code, nama from subtopik where idtopik = '".$row->idtopik."';");
                foreach ($list_subs->getResult() as $row1) {
                    $str .= '<tr>';
                    $str .= '<td>'.$row1->code.' - '.$row1->nama.'</td>';
                    $str .= '</tr>';
                }
                $str .= '</tbody></table>';
                $val[] = $str;
            }else{
                $val[]='-';
            }
                $val[] = '<div style="text-align: center;">'
                . '<button type="button" class="btn btn-sm btn-success btn-fw" onclick="subtopik('."'".$row->idtopik."'".')"><i class="fa fa-fw fa-plus-square"></i> Tambah</button>&nbsp;'
                . '</div>';
                $val[] = '<div style="text-align: center;">'
                        . '<button type="button" class="btn btn-sm btn-warning btn-fw" onclick="ganti('."'".$row->idtopik."'".')"><i class="fa fa-fw fa-pencil-square"></i></button>&nbsp;'
                        . '<button type="button" class="btn btn-sm btn-danger btn-fw" onclick="hapus('."'".$row->idtopik."'".','."'".$row->nama."'".')"><i class="fa fa-fw fa-trash"></i></button>'
                        . '</div>';
                $data[] = $val;
                
                $no++;
            }
            $output = array("data" => $data);
            echo json_encode($output);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_add() {
        if(session()->get("logged_admin")){
            $data = array(
                'idbidang' => $this->model->autokode("B","idbidang","bidang", 2, 7),
                'namabidang' => $this->request->getPost('namabidang'),
            );
            $simpan = $this->model->add("bidang",$data);
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
            $data = $this->model->get_by_id("bidang", $kondisi);
            echo json_encode($data);
        }else{
            $this->modul->halaman('login');
        }
    }
    
    public function ajax_edit() {
        if(session()->get("logged_admin")){
            $data = array(
                'namabidang' => $this->request->getPost('namabidang'),
                'status' => $this->request->getPost('status'),
            );
            $kond['idbidang'] = $this->request->getPost('kode');
            $update = $this->model->update("bidang",$data, $kond);
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
            $kond['idbidang'] = $this->request->uri->getSegment(3);
            $hapus = $this->model->delete("bidang",$kond);
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
