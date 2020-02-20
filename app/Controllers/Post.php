<?php namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\UsersModel;
use App\Models\TagsModel;
use App\Models\CommentsModel;
use App\Models\SubscriptionsModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use JsonException;

class Post extends BaseController
{
    public function index(string $titlePost)
    {
        $titlePost = rawurldecode($titlePost);

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
            'isImage' => ($post['path_image'])?true:false,
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

        $this->response->setJSON(false);
        if (! $post_s) {
            return json_encode(['empty' => true]);
        }

        for ($i = 0; $i < count($post_s); $i++) {
            $post = &$post_s[$i];
            $post['address'] = base_url().'/post/'.rawurlencode($post['title']);
        }

        $this->response->setStatusCode(200);
        return json_encode($post_s);
    }

    public function comments(string $titlePost)
    {
        $titlePost = rawurldecode($titlePost);

        $postsModel = new PostsModel();
        $post = $postsModel->getPost($titlePost);

        if (! $post) throw new PageNotFoundException($titlePost);

        $idPost = $post['id'];
        $commentsModel = new CommentsModel();
        $comments = $commentsModel->getComments($idPost);

        $this->response->setJSON(false);

        if (! $comments) {
            return json_encode(['isComments' => false]);
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

        return json_encode($comments);
    }

    public function createComment()
    {
        $request = $this->request->getJSON(true);
        $session = session();

        $this->response->setJSON(false);

        if (!$session->has('isAuth')) {
            return json_encode(['isAuth' => false]);
        }

        $idUser = (int)$session->get('idUser');
        $text = $request['text'];
        $titlePost = $request['titlePost'];

        $postsModel = new PostsModel();
        $post = $postsModel->getPost($titlePost);

        if (!$post) {
            return json_encode(['titleIncorrect' => true]);
        }

        $commentsModel = new CommentsModel();
        $status = $commentsModel->setComment($idUser, $post['id'], $text);

        if ($status) {
            return json_encode(['isCreate' => true]);
        }
        else {
            return json_encode(['isCreate' => false]);
        }
    }

    public function getNews()
    {
        $session = session();

        $subModel = new SubscriptionsModel();
        $idAuthors = $subModel->getAuthorsIds((int)$session->get('idUser'));

        $this->response->setJSON(false);

        if (! $idAuthors) {
            return json_encode(['news' => false]);
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
            return json_encode($posts);
        }
        else {
            return json_encode(['empty' => true]);
        }
    }
}