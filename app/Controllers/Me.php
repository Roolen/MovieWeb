<?php namespace App\Controllers;

use App\Models\UsersModel;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Me extends BaseController
{
    public function index(string $nick)
    {
        $session = session();
        $model = new UsersModel();
        
        $user = $model->getUser($nick);
        if ($user) {
            if ($user['id'] === $session->get('idUser')) {
                $nick = $nick . " this you";
            }
        }
        else {
            throw new PageNotFoundException($nick);
        }

        $avatar = ($user['path_avatar'])
                  ? $user['path_avatar']
                  : base_url()."/images/employee.svg";
        
        $data = [
            'title' => 'Me '.$nick,
            'user_nick' => $nick,
            'user_desc' => $user['description'],
            'user_image' => $avatar
        ];
        echo view('Share/header.php', $data);
        echo view('me', $data);
        echo view('Share/footer.php');
    }
}