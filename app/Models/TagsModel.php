<?php namespace App\Models;

use CodeIgniter\Model;

class TagsModel extends Model
{
    protected $table = "tags";
    protected $primaryKey = "id";
    protected $allowedFields = [
        'name_tag'
    ];

    /**
     * Получить все теги поста.
     *
     * @param integer $idPost id поста
     * @return array|bool массив тэгов или false
     */
    public function getTags(int $idPost)
    {
        $postTagModel = new PostTagModel();
        $tagsId_s = $postTagModel->getTagsOfPost($idPost);
        
        if (!$tagsId_s) return [];
        
        $tags = $this->asArray()
                     ->whereIn('id', $tagsId_s)
                     ->findAll();

        if ($tags) {
            $tags_names = [];
            for ($i = 0; $i < count($tags); $i++) {
                $tags_names[$i] = $tags[$i]['name_tag'];
            }
            return $tags_names;
        }
        else {
            return false;
        }
    }

    /**
     * Создать новый тэг, если он ещё не существует.
     *
     * @param string $tagName строка тэга
     * @return int id нового тэга или имеющего такое же содержимое
     */
    public function setTag(string $tagName)
    {
        $tag = $this->asArray()
                    ->where(['name_tag' => $tagName])
                    ->first();

        return ($tag)
               ? $tag['id']
               : $this->insert(['name_tag' => $tagName]);
    }
}