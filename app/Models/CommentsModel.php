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

    /**
     * Получить комментарии к посту.
     *
     * @param integer $idPost id поста
     * @return array|bool массив с данными коментариев к посту или false если их нет
     */
    public function getComments(int $idPost)
    {
        $commentS = $this->asArray()
                         ->where(['id_post' => $idPost])
                         ->findAll();

        return ($commentS)
               ? $commentS
               : false;
    }

    /**
     * Установить новый комментарий для поста.
     *
     * @param integer $idAuthor id автора
     * @param integer $idPost id поста
     * @param string $text текст сомментария
     * @return bool успешность создания комментария
     */
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