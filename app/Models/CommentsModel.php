<?php namespace App\Models;

use CodeIgniter\Model;

class CommentsModel extends Model
{
    protected $table = "comments";
    protected $primaryKey = "id";
    protected $allowedFields = [
        'id_author',
        'id_post',
        'text_comment',
        'rating',
        'is_report'
    ];

    public function getComments(int $idPost)
    {
        $commentS = $this->asArray()
                         ->where(['id_post' => $idPost])
                         ->findAll();

        if ($commentS) {
            return $commentS;
        }
        else {
            return false;
        }
    }
}