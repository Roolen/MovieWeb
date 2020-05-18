<?php namespace App\Controllers;

use App\Models\CommentsModel;
use App\Models\PostsModel;
use App\Models\UsersModel;

class Search extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Search'
        ];

        echo view('Share/header', $data);
        echo view('search');
        echo view('Share/footer');
    }

    public function search(bool $byText = false)
    {
        $request = $this->request->getJSON(true);
        $this->response->setJSON(false);

        $searchLine = $request['searchLine'];

        $postsModel = new PostsModel();
        $findedPosts = ($byText)
                       ? $postsModel->searchPosts($searchLine, true)
                       : $postsModel->searchPosts($searchLine);

        if (! $findedPosts) {
            return json_encode(['isEmpty' => true]);
        }

        $usersModel = new UsersModel();
        $commentsModel = new CommentsModel();

        for ($i = 0; $i < count($findedPosts); $i++) {
            $post = &$findedPosts[$i];
            $author = $usersModel->getUserById($post['id_author']);
            
            $post['author'] = $author['nickname'];
            $post['authorAvatar'] = ($author['path_avatar'])
                                     ? base_url() . $author['path_avatar']
                                     : base_url() . "/images/employee.svg";
            $post['isImage'] = ($post['path_image'])?true:false;
            $post['path_image'] = ($post['path_image'])
                                  ? base_url() . $post['path_image']
                                  : base_url() . "/images/post.svg";

            $comments = $commentsModel->getComments($post['id']);
            if (! $comments) {
                $post['comments'] = 0;
                continue;
            }
            else {
                $post['comments'] = count($comments);
            }

            unset($post['id']);
            unset($post['id_author']);
        }

        return json_encode($findedPosts);
    }

    public function searchUsers()
    {
        $request = $this->request->getJSON(true);
        $this->response->setJSON(false);

        $searchLine = $request['searchLine'];

        $usersModel = new UsersModel();
        $users = $usersModel->searchUsers($searchLine);

        if (!$users) {
            return json_encode(['isEmpty' => true]);
        }

        $dataUsers = [];
        for ($i = 0; $i < count($users); $i++) {
            $user = &$users[$i];
            $dataUsers[] = [
                'nickname' => $user['nickname'],
                'email' => $user['email'],
                'phoneNumber' => $user['phone_number'],
                'description' => $user['description'],
                'isAvatar' => ($user['path_avatar'])?true:false,
                'avatar' => ($user['path_avatar'])
                            ? base_url() . $user['path_avatar']
                            : base_url() . "/images/employee.svg"
            ];
        }

        return json_encode($dataUsers);
    }
}