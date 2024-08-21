<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Subtopic extends BaseController
{

    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function start()
    {
        $kode =  $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $this->modul->enkrip_url($kode);

        $subs = $this->model->getAllQR("select nama, narasi from subtopik where idsubtopik = '" . $kode . "'");
        $data['subtopik'] = $subs->nama;
        $data['topik'] = $this->model->getAllQR("select t.nama as nm from subtopik s, topik t where t.idtopik = s.idtopik and s.idsubtopik = '" . $kode . "'")->nm;
        $data['tot'] = $this->model->getAllQR("select count(*) as jml from soal where idsubtopik = '" . $kode . "'")->jml;

        echo view('front/head');
        if ($subs->narasi == 1) {
            $data['jml'] = 5;
            echo view('front/start/narasi', $data);
        } else {
            $data['jml'] = 10;
            echo view('front/start/index', $data);
        }
        echo view('front/foot');
    }

    public function exam()
    {
        $kode = $this->request->getUri()->getSegment(3);
        $data['kode'] = $kode;

        $data['model'] = $this->model;
        $data['modul'] = $this->modul;

        // $r = array_rand(['d','mc','s','tf','mg']);
        $data['subtopik'] = $this->model->getAllQR("select nama from subtopik where idsubtopik = '" . $kode . "'")->nama;
        $data['topik'] = $this->model->getAllQR("select t.nama as nm from subtopik s, topik t where t.idtopik = s.idtopik and s.idsubtopik = '" . $kode . "'")->nm;
        $data['soal'] = $this->model->getAllQ("select * from soal where idsubtopik = '" . $kode . "' order by rand() limit 10");
        // jenis = '".$r."'
        echo view('front/head');
        // if($r == 'mc'){

        // }
        echo view('front/exam/mc', $data);
        echo view('front/foot');
    }

    public function narasi()
    {
        $kode =  $this->modul->dekrip_url($this->request->getUri()->getSegment(3));
        $data['kode'] = $this->modul->enkrip_url($kode);

        $idn = $this->model->getAllQR("select idnarasi from subtopik s, narasi n where s.idsubtopik = n.idsubtopik and n.idsubtopik = '" . $kode . "' order by rand() limit 1")->idnarasi;

        $data['model'] = $this->model;
        $data['modul'] = $this->modul;

        $n = $this->model->getAllQR("select * from narasi where idnarasi = '" . $idn . "'");
        $data['subtopik'] = $this->model->getAllQR("select nama from subtopik where idsubtopik = '" . $n->idsubtopik . "'")->nama;
        $data['topik'] = $this->model->getAllQR("select t.nama as nm from subtopik s, topik t where t.idtopik = s.idtopik and s.idsubtopik = '" . $n->idsubtopik . "'")->nm;

        $data['narasi'] = $n->deskripsi;
        $data['soal'] = $this->model->getAllQ("select * from soal where idnarasi = '" . $idn . "' limit 5");

        echo view('front/head');
        echo view('front/exam/narasi', $data);
        echo view('front/foot');
    }

    public function done()
    {
        $data['penutup'] = $this->model->getAllQR("select * from penutup limit 1")->deskripsi;

        echo view('front/head');
        echo view('front/exam/done', $data);
        echo view('front/foot');
    }

    public function submit()
    {
        $data['penutup'] = $this->model->getAllQR("select * from penutup limit 1")->deskripsi;

        echo view('front/head');
        echo view('front/exam/submit', $data);
        echo view('front/foot');
    }

    public function ajaxlist()
    {
        $kode = $this->request->getUri()->getSegment(3);

        $id = $this->request->getPost('query');
        $hasil = '';
        if ($id != '') {
            $list2 = $this->model->getAllQ("SELECT * FROM topik where nama like '%" . $id . "%';");
            $list = $this->model->getAllQ("SELECT t.nama as nt, s.nama as ns, idsubtopik FROM subtopik s, topik t where s.nama like '%" . $id . "%' and t.idtopik = s.idtopik;");
        } else {
            $list = $this->model->getAllQ("select * from subtopik where idtopik = '" . $kode . "'");
        }
        foreach ($list->getResult() as $row) {
            if ($id != '') {
                $hasil .= '<div class="col-sm-4">
                        <a href="' . base_url() . '/subtopic/start/' . $this->modul->enkrip_url($row->idsubtopik) . '" class="btn">' . $row->ns . '<br>Topic: ' . $row->nt . '</a>
                    </div>';
            } else {
                $hasil .= '<div class="col-sm-4">
                    <a href="' . base_url() . '/subtopic/start/' . $this->modul->enkrip_url($row->idsubtopik) . '" class="btn">' . $row->nama . '</a>
                </div>';
            }
        }
        if ($id != '') {
            foreach ($list2->getResult() as $row) {
                $hasil .= '<div class="col-sm-4">
                            <a href="' . base_url() . '/topic/subtopic/' . str_replace(' ', '-', $row->nama) . '" class="btn">' . $row->nama . '</a>
                        </div>';
            }
        }

        echo json_encode(array("status" => $hasil));
    }
}