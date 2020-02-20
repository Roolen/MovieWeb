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
        'phone_number',
        'description',
        'path_avatar'
    ];

    /**
     * Возвращает данные пользователя по никнэйму.
     *
     * @param string $nick никнэйм
     * @return array Массив пользовательскийх данных.
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
     * Возвращает данные пользователя по id.
     *
     * @param integer $id id пользователя.
     * @return array пользовательские данные.
     */
    public function getUserById(int $id)
    {
        $user = $this->asArray()
                     ->where(['id' => $id])
                     ->first();

        if ($user) {
            return $user;
        }
    }

    /**
     * Возвращает данные множества пользователей по их id.
     *
     * @param array $idS массив содержащий id пользователей.
     * @return array массив пользовательских данных.
     */
    public function getUserSById(array $idS)
    {
        $users = $this->asArray()
                      ->whereIn('id', $idS)
                      ->findAll();

        if ($users) {
            return $users;
        }
    }

    /**
     * Пытаеться добавить нового пользователя, добавляя его в базу данных.
     *
     * @param object $data_user дынные пользователя
     * 'first_name' - имя
     * 'nickname' - логин
     * 'email' - электронная почта
     * 'password' - пароль
     * 'pone_number' - номер телефона
     * @return bool статус успешности
     */
    public function createUser(object $data_user)
    {
        if ($data_user->first_name   == "" ||
            $data_user->nickname     == "" ||
            $data_user->email        == "" ||
            $data_user->password     == "" ||
            $data_user->phone_number == "") 
        {
            return false;
        }

        $password = $data_user->password;
        $data_user->password = password_hash($password, PASSWORD_BCRYPT);

        $this->insert($data_user);
        return true;
    }

    /**
     * Изменяет описание пользователя.
     *
     * @param string $newDesc строка нового описания
     * @param integer $idUser id пользователя
     * @return bool статус изменения
     */
    public function changeDescription(string $newDesc, int $idUser)
    {
        $user = $this->asArray()
                     ->where(['id' => $idUser])
                     ->first();

        if ($user && mb_strlen($newDesc, 'utf8') <= 451) {
            $this->update($idUser, ['description' => $newDesc]);
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Изменяет путь к аватару пользователя.
     *
     * @param integer $idUser id пользователя
     * @param string $pathImage url адрес изображения
     * @return bool статус успешности
     */
    public function changeAvatar(int $idUser, string $pathImage)
    {
        $status = $this->update($idUser, ['path_avatar' => $pathImage]);

        return ($status)
               ? true
               : false;
    }

    /**
     * Проверяет правильность пары логин/пароль.
     *
     * @param string $nick никнэйм пользователя
     * @param string $password пароль пользователя
     * @return array массив, где элемент 'confirmed' содержит флаг проверки.
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
     * Проверяет данные пользователя на повторения с данными в базе данных.
     *
     * @param string $nickname логин пользователя
     * @param string $email электронная почта пользователя
     * @param string $phone номер телефона пользователя
     * @return array массив с флагами проверки на повторения, где:
     * 'nickname' - повторение логина
     * 'email' - повторение электронной почты
     * 'phone' - повторение номера телефона
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
     * Проверяет корректность объект с данными пользователя.
     *
     * @param object $data_user пользовательские данные
     * @return array массив с флагами проверок данных, где:
     * 'nameIncorrect' - некорректность имени
     * 'nickIncorrect' - некорректность логина
     * 'emailIncorrect' - некорректность электронной почты
     * 'passwordIncorrect' - некорректность пароля
     * 'phoneIncorrect' - некорректность номера телефона
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