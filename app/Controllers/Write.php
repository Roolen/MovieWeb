<?php namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\PostTagModel;

class Write extends BaseController
{
    public function index()
    {
        $session = session();

        if (! $session->has('isAuth')) {
            $this->response->redirect(base_url());
        }

        $data = ['title' => 'Write post'];

        echo view('Share/header', $data);
        echo view('write');
        echo view('Share/footer');
    }

    public function createPost()
    {
        $session = session();
        $request = $this->request->getJSON(true);

        $title = $request['title'];
        $text = $request['text'];
        $tagsLine = $request['tags'];

        $tagsLine = str_replace(" ", null, $tagsLine);
        $tags = explode(',', $tagsLine);

        $postsModel = new PostsModel();
        $dataPost = [
            'title' => $title,
            'id_author' => (int)$session->get('idUser'),
            'is_scetch' => false,
            'text_post' => $text
        ];

        $post = $postsModel->createPost($dataPost);

        if (! $post['success']) {
            $this->response->setJSON(false);
            echo json_encode($post);
            return;
        }

        $tagsModel = new PostTagModel();
        $status = $tagsModel->setTagsOfPost($post['idPost'], $tags);

        $this->response->setJSON(false);
        echo json_encode(['success' => true]);
    }
}