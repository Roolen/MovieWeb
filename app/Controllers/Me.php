<?php namespace App\Controllers;

use App\Models\UsersModel;

class Me extends BaseController
{
    public function index(string $nick)
    {
        $session = session();
        $data = ['title' => 'Me'.$nick];
        $model = new UsersModel();

        $user = $model->getUser($nick);
        if ($user) {
            if ($user['id'] === $session->get('idUser')) {
                $nick = $nick . " this you";
            }
        }

        echo view('Share/header.php', $data);
        echo $nick;
        echo view('Share/footer.php');
    }
}