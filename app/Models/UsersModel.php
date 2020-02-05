<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';

    public function getUsers($nick = false)
    {
        if ($nick === false)
        {
            return $this->findAll();
        }

        return $this->asArray()
                    ->where(['nickname' => $nick])
                    ->first();
    }
}