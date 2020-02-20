<?php namespace App\Controllers;

use App\Models\UsersModel;

class Mail extends BaseController
{
    public function index()
    {
        $data = ['title' => 'Mail'];

        echo view('Share/header', $data);
        echo view('mail');
        echo view('Share/footer');
    }
}