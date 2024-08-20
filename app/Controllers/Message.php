<?php
namespace App\Controllers;

use App\Models\Mcustom;
use App\Libraries\Modul;

class Message extends BaseController{
    
    private $model;
    private $modul;
    
    public function __construct() {
        $this->model = new Mcustom();
        $this->modul= new Modul();
    }
    
    public function messages()
	{
		// Flash messages settings

		session()->setFlashdata("success", "This is success message");

		session()->setFlashdata("warning", "This is warning message");

		session()->setFlashdata("info", "This is information message");

		session()->setFlashdata("error", "This is error message");

		return view("sweetalert-notification");
	}

}
