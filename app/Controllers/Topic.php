<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Topic extends BaseController
{

    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function subtopic()
    {
        $kode = $this->request->getUri()->getSegment(3);
        $judul = str_replace('-', ' ', $kode);

        $tot = str_word_count($judul);
        if ($tot > 1) {
            $pisah = explode(" ", $judul);
            $topik = $this->model->getAllQR("select nama, idtopik from topik where nama like '%" . $pisah[0] . "%' and nama like '%" . $pisah[1] . "%';");
        } else {
            $topik = $this->model->getAllQR("select nama, idtopik from topik where nama like '%" . $judul . "%';");
        }

        $data['topik'] = $topik->nama;
        $data['idtopik'] = $topik->idtopik;

        echo view('front/head');
        echo view('front/subtopik/index', $data);
        echo view('front/foot');
    }

    public function ajaxlist()
    {
        $id = $this->request->getPost('query');
        $limit = $this->request->getPost('limit');

        $maxdb = $this->model->getAllQR("SELECT count(*) as jml FROM topik")->jml;
        $max = 0;

        $hasil = '';
        if ($id != '') {
            $list = $this->model->getAllQ("SELECT * FROM topik where nama like '%" . $id . "%';");
            $list2 = $this->model->getAllQ("SELECT t.nama as nt, s.nama as ns, idsubtopik FROM subtopik s, topik t where s.nama like '%" . $id . "%' and t.idtopik = s.idtopik;");
        } else {
            $list = $this->model->getAllQ("SELECT * FROM topik order by best desc LIMIT " . $limit . ";");
        }
        foreach ($list->getResult() as $row) {
            $hasil .= '<div class="col-sm-6">
                        <a href="' . base_url() . '/topic/subtopic/' . str_replace(' ', '-', $row->nama) . '" class="btn">' . $row->nama . '</a>
                    </div>';
            $max++;
        }
        if ($id != '') {
            foreach ($list2->getResult() as $row) {
                $hasil .= '<div class="col-sm-6">
                            <a href="' . base_url() . '/subtopic/start/' . $this->modul->enkrip_url($row->idsubtopik) . '" class="btn">' . $row->ns . '<br>Topic: ' . $row->nt . '</a>
                        </div>';
            }
        }

        $status_bottom = "aktif";
        if ($max >= $maxdb) {
            $status_bottom = "non_aktif";
        }

        echo json_encode(array("status" => $hasil, "status_bottom" => $status_bottom));
    }
}