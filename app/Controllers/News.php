<?php namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\SubscriptionsModel;

class News extends BaseController
{
    public function index()
    {
        $session = session();

        if (! $session->has('isAuth')) {
            $this->response->redirect(base_url());
        }

        $data = ['title' => 'News'];

        echo view('Share/header', $data);
        echo view('news');
        echo view('Share/footer');
    }
}