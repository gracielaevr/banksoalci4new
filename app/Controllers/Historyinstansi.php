<?php

namespace App\Controllers;

class Historyinstansi extends BaseController
{
    public function index(): void
    {
        $currentPage = 'Historyinstansi';
        $data['current_page'] = $currentPage;
        echo view('back/dashboardinstansisiswa/historyinstansi', $data);
    }
}