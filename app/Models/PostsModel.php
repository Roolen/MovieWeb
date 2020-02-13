<?php namespace App\Models;

use CodeIgniter\Model;

class PostsModel extends Model
{
    protected $table = 'posts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_author',
        'rating',
        'title',
        'path_image',
        'is_scetch',
        'text_post'
    ];

    public function getPosts(int $id)
    {
        $posts = $this->asArray()
                      ->where(['id_author' => $id])
                      ->findAll();

        if ($posts) {
            for ($i = 0; $i < count($posts); $i++) {
                unset($posts[$i]['id']);
                unset($posts[$i]['is_scetch']);
                if (! $posts[$i]['path_image']) {
                    $posts[$i]['path_image'] = base_url() . "/images/post.svg";
                }
            }

            return $posts;
        }
    }
}