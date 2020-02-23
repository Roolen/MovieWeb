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
        helper('filesystem');
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
        
        $this->response->setJSON(false);

        if (! $post['success']) {
            return json_encode($post);
        }
        
        $tagsModel = new PostTagModel();
        $status = $tagsModel->setTagsOfPost($post['idPost'], $tags);
        
        return json_encode(['success' => true]);
    }
    
    public function loadImage(string $titlePost)
    {
        helper('filesystem');
        $titlePost = rawurldecode($titlePost);
        
        $request = $this->request->getBody();
        
        $pathImage = ROOTPATH.'public/write/images/posts/'.$titlePost.'.png';
        write_file($pathImage, $request, 'wb');
        
        $postsModel = new PostsModel();
        $postsModel->setImage("/write/images/posts/".$titlePost.'.png', $titlePost);
        
        $this->response->setJSON(false);
        return json_encode(['success' => true]);
    }
}