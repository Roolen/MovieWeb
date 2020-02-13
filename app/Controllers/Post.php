<?php namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\UsersModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Post extends BaseController
{
    public function index()
    {

    }

    public function posts($nick)
    {
        $usersModel = new UsersModel();
        $user = $usersModel->getUser($nick);
        
        if (! $user) throw new PageNotFoundException($nick);

        $userId = $user['id'];

        $postsModel = new PostsModel();
        $post_s = $postsModel->getPosts($userId);

        if ($post_s) {
            $this->response->setStatusCode(200)
                           ->setJSON(false);
            echo json_encode($post_s);
        }
        else {
            $this->response->setStatusCode(200)
                           ->setJSON(false);
            echo json_encode(['empty' => true]);
        }
    }
}