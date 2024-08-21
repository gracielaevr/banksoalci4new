<?php

namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;
use Dompdf\Dompdf;
use Dompdf\Options;

class Laporan extends BaseController
{

    private $model;
    private $modul;

    public function __construct()
    {
        $this->model = new Mcustom();
        $this->modul = new Modul();
    }

    public function cetak()
    {
        if (session()->get("logged_in")) {
            $dompdf = new Dompdf();

            $kode = $this->request->getUri()->getSegment(3);

            $data['model'] = $this->model;

            $narasi = $this->model->getAllQR("select idnarasi from jawaban_peserta j, soal s where j.idsoal = s.idsoal and j.idpeserta = '" . $kode . "' limit 1")->idnarasi;
            if ($narasi != '') {
                $data['narasi'] = $this->model->getAllQR("select * from narasi where idnarasi = '" . $narasi . "'")->deskripsi;
            } else {
                $data['narasi'] = "";
            }

            $peserta = $this->model->getAllQR("select * from peserta where idpeserta = '" . $kode . "'");
            $data['benar'] = $peserta->benar;
            $data['nama'] = $peserta->nama;
            $data['poin'] = $peserta->poin;
            $data['salah'] = $peserta->salah;

            $data['topik'] = $this->model->getAllQR("select * from topik where idtopik = '" . $peserta->idtopik . "'")->nama;

            $subtopik = $this->model->getAllQR("select * from subtopik where idsubtopik = '" . $peserta->idsubtopik . "'");
            $data['subtopik'] = $subtopik->nama;
            $data['teori'] = $subtopik->deskripsi;

            $jenis = $this->model->getAllQR("select jenis from jawaban_peserta j, soal s where j.idsoal = s.idsoal and j.idpeserta = '" . $kode . "' limit 1")->jenis;

            $options = new Options();
            $options->setChroot(FCPATH);

            $dompdf->setOptions($options);
            if ($jenis == 'mg') {
                $data['soal'] = $this->model->getAllQ("select * from jawaban_peserta j, soal s where j.idsoal = s.idsoal and j.idpeserta = '" . $kode . "' group by j.idsoal");
                $dompdf->loadHtml(view('back/laporan/pdfmg_siswa', $data));
            } else {
                $data['soal'] = $this->model->getAllQ("select * from jawaban_peserta j, soal s where j.idsoal = s.idsoal and j.idpeserta = '" . $kode . "'");
                $dompdf->loadHtml(view('back/laporan/pdf_siswa', $data));
            }
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $filename = 'Student Report - ' . $peserta->nama . '.pdf';
            $dompdf->stream($filename); // download
            // $dompdf->stream($filename, array("Attachment" => 0));

        } else {
            $this->modul->halaman('login');
        }
    }
}