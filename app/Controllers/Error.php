<?php

namespace App\Controllers;


class Error extends BaseController
{
    public function index()
    {
        return view('page/errors/html/error_404');
    }

}