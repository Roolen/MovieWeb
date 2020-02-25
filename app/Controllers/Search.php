<?php namespace App\Controllers;

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

    public function search()
    {
        $request = $this->request->getJSON(true);
        $this->response->setJSON(false);

        $searchLine = $request['searchLine'];

        $postsModel = new PostsModel();
        $findedPosts = $postsModel->searchPosts($searchLine);

        if (! $findedPosts) {
            return json_encode(['isEmpty' => true]);
        }

        $usersModel = new UsersModel();

        for ($i = 0; $i < count($findedPosts); $i++) {
            $post = &$findedPosts[$i];
            $author = $usersModel->getUserById($post['id_author']);
            unset($post['id']);
            unset($post['id_author']);
            $post['author'] = $author['nickname'];
            $post['authorAvatar'] = ($author['path_avatar'])
                                     ? base_url() . $author['path_avatar']
                                     : base_url() . "/images/employee.svg";
            $post['isImage'] = ($post['path_image'])?true:false;
            $post['path_image'] = ($post['path_image'])
                                  ? base_url() . $post['path_image']
                                  : base_url() . "/images/post.svg";
        }

        return json_encode($findedPosts);
    }
}