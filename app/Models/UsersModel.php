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

    public function createUser(array $data_user)
    {
        if (
            $data_user['first_name'] === '' ||
            $data_user['nickname'] === '' ||
            $data_user['email'] === '' ||
            $data_user['password'] === '' ||
            $data_user['phone_number'] === ''
           ) 
        {
                return false;
        }

        $password = $data_user['password'];
        $data_user['password'] = password_hash($password, PASSWORD_ARGON2ID);

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
}