<?php namespace App\Controllers;

use App\Models\PostsModel;
use App\Models\PostTagModel;
use App\Models\TagsModel;

class Write extends BaseController
{
    public function index(string $titlePost = null)
    {
        $session = session();
        $titlePost = rawurldecode($titlePost);

        if (! $session->has('isAuth')) {
            $this->response->redirect(base_url());
        }

        $data = [];
        $isRewrite = false;
        if ($titlePost != null) {
            $postsModel = new PostsModel();
            $post = $postsModel->getPost($titlePost);
            $idUser = (int)$session->get('idUser');

            if (! $post) {
                return $this->response->redirect(base_url());
            }
            
            if (! $idUser = $post['id_author']) {
                return $this->response->redirect(base_url()."/write");
            }

            $tagsModel = new TagsModel();
            $tags = $tagsModel->getTags($post['id']);
            $tagsLine = implode(', ', $tags);

            $data = [
                'text' => esc($post['text_post'], 'js'),
                'tags' => $tagsLine
            ];

            $isRewrite = true;
        }

        $data += [
            'title' => 'Write post',
            'titlePost' => $titlePost,
            'isRewrite' => $isRewrite
        ];

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
        
        $this->response->setJSON(false);

        if (! $post['success']) {
            return json_encode($post);
        }
        
        $tagsModel = new PostTagModel();
        $status = $tagsModel->setTagsOfPost($post['idPost'], $tags);
        
        return json_encode(['success' => true]);
    }

    public function change()
    {
        $session = session();
        $request = $this->request->getJSON(true);
        $this->response->setJSON(false);

        $title = $request['title'];
        $text = $request['text'];
        $tagsLine = $request['tags'];

        $tagsLine = str_replace(' ', null, $tagsLine);
        $tags = explode(',', $tagsLine);

        $postsModel = new PostsModel();
        $post = $postsModel->getPost($title);

        if (! $post) {
            return json_encode(['success' => false]);
        }

        if ($post['id_author'] != (int)$session->get('idUser')) {
            return json_encode(['success' => false]);
        }

        $status = $postsModel->changePost($post['id'], ['text_post' => $text]);

        if (! $status) {
            return json_encode(['success' => false]);
        }

        $tagsModel = new PostTagModel();
        $tagsModel->setTagsOfPost($post['id'], $tags);

        return json_encode(['success' => true]);
    }

    public function delete(string $titlePost)
    {
        $session = session();
        $this->response->setJSON(false);

        $titlePost = rawurldecode($titlePost);

        $postsModel = new PostsModel();
        $post = $postsModel->getPost($titlePost);

        $idUser = (int)$session->get('idUser');

        if ($idUser != $post['id_author']) {
            return json_encode(['success' => false]);
        }

        $status = $postsModel->removePost($post['id']);

        if ($status) {
            return json_encode(['success' => true]);
        }
        else {
            return json_encode(['success' => false]);
        }
    }
    
    public function loadImage(string $titlePost)
    {
        helper('filesystem');
        $titlePost = rawurldecode($titlePost);
        
        $request = $this->request->getBody();
        
        $pathImage = ROOTPATH.'public_html/write/images/posts/'.$titlePost.'.png';
        write_file($pathImage, $request, 'wb');
        
        $postsModel = new PostsModel();
        $postsModel->setImage("/write/images/posts/".$titlePost.'.png', $titlePost);
        
        $this->response->setJSON(false);
        return json_encode(['success' => true]);
    }
}