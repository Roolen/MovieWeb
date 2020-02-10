<?php namespace App\Controllers;

class News extends BaseController
{
    public function index()
    {
        $session = session();

        $data = ['title' => 'News'];

        echo view('Share/header', $data);
        echo $session->get('idUser');
        echo view('Share/footer');
    }
}