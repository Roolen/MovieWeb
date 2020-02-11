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

    /**
     * Return data of user with $nick of nickname.
     *
     * @param string $nick
     * @return void
     */
    public function getUser(string $nick)
    {
        $user = $this->asArray()
                     ->where(['nickname' => $nick])
                     ->first();

        if ($user) {
            return $user;
        }
    }

    /**
     * Trying new user, writing him in base date.
     *
     * @param object $data_user
     * @return void
     */
    public function createUser(object $data_user)
    {
        foreach ($data_user->array_values as $value) {
            if ($value === '') return false;
        }

        $password = $data_user->password;
        $data_user->password = password_hash($password, PASSWORD_ARGON2ID);

        $this->insert($data_user);
        return true;
    }

    /**
     * Checking confirmite by nick/password with currents of users.
     *
     * @param string $nick
     * @param string $password
     * @return array 'confirmed' flag.
     */
    public function verifyUser(string $nick, string $password)
    {
        $user = $this->asArray()
                     ->where(['nickname' => $nick])
                     ->first();

        if (! $user || ! password_verify($password, $user['password'])) {
            return ['confirmed' => false];
        }
        else {
            return ['confirmed' => true];
        }
    }

    /**
     * Checking data of user on duplicates.
     * Return response by array with flags.
     * 'nickname', 'email', 'phone' as flags.
     *
     * @param string $nickname
     * @param string $email
     * @param string $phone
     * @return void
     */
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

    /**
     * Checking correctness for the entering data of user.
     *
     * @param object $data_user
     * @return void
     */
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
        if (! preg_match("/^[0-9]{11}$/", $phone)) {
            $check['phoneIncorrect'] = true;
        }

        return $check;
    }
}