<?php namespace App\Models;

use CodeIgniter\Model;

class TagsModel extends Model
{
    protected $table = "tags";
    protected $primaryKey = "id";
    protected $allowedFields = [
        'name_tag'
    ];

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