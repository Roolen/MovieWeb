<?php namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\UsersModel;
use App\Models\TagsModel;
use App\Models\CommentsModel;
use App\Models\SubscriptionsModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Post extends BaseController
{
    public function index(string $titlePost)
    {
        $titlePost = str_replace("%20", " ", $titlePost);
        $model = new PostsModel();
        $post = $model->getPost($titlePost);

        if (! $post) throw new PageNotFoundException($post);

        $userModel = new UsersModel();
        $author = $userModel->getUserById($post['id_author']);

        $tagsModel = new TagsModel();
        $tags = $tagsModel->getTags($post['id']);

        $data = [
            'title' => $titlePost,
            'date' => $post['date_publish'],
            'rating' => $post['rating'],
            'text' => $post['text_post'],
            'tags' => $tags,
            'image' => ($post['path_image'])
                       ? $post['path_image']
                       : base_url() . "/images/post.svg",

            'nickAuthor' => $author['nickname'],
            'imageAuthor' => ($author['path_avatar'])
                             ? $author['path_avatar']
                             : base_url() . "/images/employee.svg"

        ];

        echo view('Share/header', $data);
        echo view('post', $data);
        echo view('Share/footer');
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

    public function comments(string $titlePost)
    {
        $titlePost = str_replace("%20", " ", $titlePost);

        $postsModel = new PostsModel();
        $post = $postsModel->getPost($titlePost);

        if (! $post) throw new PageNotFoundException($titlePost);

        $idPost = $post['id'];
        $commentsModel = new CommentsModel();
        $comments = $commentsModel->getComments($idPost);

        if (! $comments) {
            $this->response->setJSON(false);
            echo json_encode(['isComments' => false]);
        }

        $usersModel = new UsersModel();
        
        for ($i = 0; $i < count($comments); $i++) {
            $comment = &$comments[$i];
            $user = $usersModel->getUserById($comment['id_author']);
            unset($comment['id']);
            unset($comment['id_post']);
            unset($comment['id_author']);
            $comment['author'] = $user['nickname'];
            $comment['avatar'] = ($user['path_avatar'])
                                 ? $user['path_avatar']
                                 : base_url() . "/images/employee.svg";
        }

        $this->response->setJSON(false);
        echo json_encode($comments);
    }

    public function getNews()
    {
        $session = session();

        $subModel = new SubscriptionsModel();
        $idAuthors = $subModel->getAuthorsIds((int)$session->get('idUser'));

        if (! $idAuthors) {
            $this->response->setJSON(false);
            echo json_encode(['news' => false]);
            return;
        }

        $postsModel = new PostsModel();
        $posts = $postsModel->getPostsByAuthors($idAuthors);

        $usersModel = new UsersModel();

        for ($i = 0; $i < count($posts); $i++) {
            $post = &$posts[$i];
            $author = $usersModel->getUserById($post['id_author']);
            unset($post['id']);
            unset($post['id_author']);
            $post['author'] = $author['nickname'];
            $post['authorAvatar'] = ($author['path_avatar'])
                                     ? $author['path_avatar']
                                     : base_url() . "/images/employee.svg";

        }

        if ($posts) {
            $this->response->setJSON(false);
            echo json_encode($posts);
        }
        else {
            $this->response->setJSON(false);
            echo json_encode(['empty' => true]);
        }
    }
}