<?php namespace App\Models;

use CodeIgniter\Model;

class PostTagModel extends Model
{
    protected $table = "post_tag";
    protected $primaryKey = "id";
    protected $allowedFields = [
        'id_post',
        'id_tag'
    ];

    /**
     * Получить все id тэгов поста.
     *
     * @param integer $idPost id поста
     * @return array[int]|bool массив с id's тэгов или false если их нету
     */
    public function getTagsOfPost(int $idPost)
    {
        $post_tags = $this->asArray()
                          ->where(['id_post' => $idPost])
                          ->findAll();

        if (!$post_tags) {
            return false;
        }

        $tag_id_s = [];
        foreach ($post_tags as $post_tag) {
            $tag_id_s[] = $post_tag['id_tag'];
        }

        return $tag_id_s;
    }

    /**
     * Установить тэги для поста.
     *
     * @param integer $idPost id поста
     * @param array $tags массив id's тэгов
     * @return bool успешность установки тэгов
     */
    public function setTagsOfPost(int $idPost, array $tags)
    {
        if ($tags[0] === '') return false;

        $tagsModel = new TagsModel();
        $status = [];
        for ($i = 0; $i < count($tags); $i++) {
            $tag = $tags[$i];
            $status[] = $this->insert(['id_post' => $idPost,
                                       'id_tag' => $tagsModel->setTag($tag)]);
        }

        return ($status)
               ? true
               : false;
    }
}