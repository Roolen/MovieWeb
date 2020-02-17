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

        return ($commentS)
               ? $commentS
               : false;
    }

    public function setComment(int $idAuthor, int $idPost, string $text)
    {
        $comment = $this->insert(['id_author' => $idAuthor,
                                  'id_post' => $idPost,
                                  'text_comment' => $text]);

        return ($comment)
               ? true
               : false;
    }
}