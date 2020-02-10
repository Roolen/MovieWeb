<?php namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'first_name',
        'nickname',
        'email',
        'password',
        'phone_number'
    ];

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

    public function createUser(object $data_user)
    {
        if (
            $data_user->first_name === '' ||
            $data_user->nickname === '' ||
            $data_user->email === '' ||
            $data_user->password === '' ||
            $data_user->phone_number === ''
           ) 
        {
                return false;
        }

        $password = $data_user->password;
        $data_user->password = password_hash($password, PASSWORD_ARGON2ID);

        $this->insert($data_user);
        return true;
    }

    public function checkUser(string $nickname, string $email, string $phone)
    {
        $user = $this->asArray()
                     ->where(['nickname' => $nickname])
                     ->orWhere(['email' => $email])
                     ->orWhere(['phone_number' => $phone])
                     ->first();

        if ($user == null) {
            return ['all' => false];
        }
        else {
            return [
                'nickname' => ($nickname == $user['nickname']),
                'email' => ($email == $user['email']),
                'phone' => ($phone == $user['phone_number'])
            ];
        }
    }

    public function checkDataUser(object $data_user)
    {
        $check = [];
        $name = $data_user->first_name;
        if (! preg_match("/^([А-Я]{1}[а-яё]{1,23}|[A-Z]{1}[a-z]{1,23})$/", $name)) {
            $check['nameIncorrect'] = true;
        }

        $nick = $data_user->nickname;
        if (! preg_match("/^[a-zA-Zа-яА-Я]{1}[a-zа-яA-ZА-Я0-9]{2,17}$/", $nick)) {
            $check['nickIncorrect'] = true;
        }

        $mail = $data_user->email;
        if (! preg_match("/^[a-z0-9\._-]{1,42}@[a-z0-9\._-]{1,24}[.]{1}[a-z\.]{2,8}$/", $mail)) {
            $check['emailIncorrect'] = true;
        }

        $password_size = mb_strlen($data_user->password, 'utf-8');
        if ($password_size < 6 || $password_size > 24) {
            $check['passwordIncorrect'] = true;
        }

        $phone = $data_user->phone_number;
        if (! preg_match("/^[\+]{0,1}[0-9]{1}[\-]{0,1}[0-9]{3}[\-]{0,1}[0-9]{3}[\-]{0,1}[0-9]{2}[\-]{0,1}[0-9]{2}$/", $phone)) {
            $check['phoneIncorrect'] = true;
        }

        return $check;
    }
}