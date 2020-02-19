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

    public function getPost(string $title)
    {
        $post = $this->asArray()
                     ->where(['title' => $title])
                     ->first();

        return ($post)
               ? $post
               : false;
    }

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

    public function getPostsByAuthors(array $ids)
    {
        $posts = $this->asArray()
                      ->whereIn('id_author', $ids)
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

    public function createPost(array $dataPost)
    {
        if ($dataPost['title'] == '' ||
            $dataPost['id_author'] == '' ||
            $dataPost['text_post'] == '')
        {
                return ['success' => false, 'isEmpty' => true];
        }

        $post = $this->asArray()
                     ->where(['title' => $dataPost['title']])
                     ->first();

        if ($post) {
            return ['success' => false, 'isDuplicate' => true];
        }

        $idPost = $this->insert($dataPost);
        return ['success' => true, 'idPost' => $idPost];
    }
}