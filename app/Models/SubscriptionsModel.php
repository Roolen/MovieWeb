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

    public function setSubscribe(int $idSub, int $idAuthor)
    {
        $sub = $this->insert(['id_subscriber' => $idSub,
                        'id_user_author' => $idAuthor]);

        if ($sub) {
            return true;
        }
    }

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

    public function checkSubscribe(int $isSub, int $idAuthor)
    {
        $sub = $this->asArray()
                    ->where(['id_subscriber' => $isSub])
                    ->where(['id_user_author' => $idAuthor])
                    ->first();
        
        if ($sub) {
            return true;
        }
        else {
            return false;
        }
    }

    public function getCountSubscribers(string $idAuthor)
    {
        $subs = $this->asArray()
                     ->where(['id_user_author' => $idAuthor])
                     ->findAll();
        
        if ($subs) {
            return count($subs);
        }
        else {
            return false;
        }
    }
}