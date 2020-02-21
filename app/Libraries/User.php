<?php namespace App\Libraries;

use App\Models\UsersModel;

class User
{
    public function getNickname()
    {
        $session = session();

        if (! $session->has('isAuth')) {
            return false;
        }

        $usersModel = new UsersModel();
        $idUser = (int)$session->get('idUser');
        $user = $usersModel->getUserById($idUser);
        
        return ($user)
               ? $user['nickname']
               : false;
    }

    public function has() {
        return (session()->has('isAuth'));
    }
}