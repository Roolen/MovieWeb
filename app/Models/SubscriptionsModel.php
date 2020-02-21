<?php namespace App\Models;

use CodeIgniter\Model;

class SubscriptionsModel extends Model
{
    protected $table = "subscriptions";
    protected $primaryKey = "id";
    protected $allowedFields = [
        'id_subscriber',
        'id_user_author'
    ];

    /**
     * Установить новую подписку.
     *
     * @param integer $idSub id подписчика
     * @param integer $idAuthor id автора
     * @return bool успешность создания подписки
     */
    public function setSubscribe(int $idSub, int $idAuthor)
    {
        $sub = $this->insert(['id_subscriber' => $idSub,
                              'id_user_author' => $idAuthor]);

        return ($sub)
               ? true
               : false;
    }

    /**
     * Отменяет подписку на автора.
     *
     * @param integer $idSub id подписчика
     * @param integer $idAuthor id автора
     * @return bool успешность отмены подписки
     */
    public function unsetSubscribe(int $idSub, int $idAuthor)
    {
        $subscrip = $this->asArray()
                    ->where(['id_subscriber' => $idSub])
                    ->where(['id_user_author' => $idAuthor])
                    ->first();

        $status = $this->delete($subscrip['id']);

        return ($status)
               ? true
               : false;
    }

    /**
     * Получить id всех авторов, на которых подписан пользователь
     *
     * @param integer $idUser id пользователя
     * @return array|bool массив с id авторов или false если их нет
     */
    public function getAuthorsIds(int $idUser)
    {
        $authors = $this->asArray()
                        ->where(['id_subscriber' => $idUser])
                        ->findAll();
                    
        if ($authors) {
            $ids = [];
            foreach ($authors as $author) {
                $ids[] = $author['id_user_author'];
            }
            return $ids;
        }
        else {
            return false;
        }
    }

    /**
     * Проверяет подписан ли пользователь на автора.
     *
     * @param integer $isSub id пользователя
     * @param integer $idAuthor id автора
     * @return bool флаг подписки пользователя
     */
    public function checkSubscribe(int $isSub, int $idAuthor)
    {
        $sub = $this->asArray()
                    ->where(['id_subscriber' => $isSub])
                    ->where(['id_user_author' => $idAuthor])
                    ->first();
        
        return ($sub)
               ? true
               : false;
    }

    /**
     * Получить количество подписчиков автора.
     *
     * @param string $idAuthor id автора
     * @return int|bool количество подписчиков или false если их нет
     */
    public function getCountSubscribers(string $idAuthor)
    {
        $subs = $this->asArray()
                     ->where(['id_user_author' => $idAuthor])
                     ->findAll();
        
        return ($subs)
               ? count($subs)
               : false;
    }
}