<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\SubscriptionsModel;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Me extends BaseController
{
    public function index(string $nick)
    {
        $session = session();
        $model = new UsersModel();
        
        $user = $model->getUser($nick);
        $isYou = false;
        if ($user) {
            if ($user['id'] === $session->get('idUser')) {
                $isYou = true;
            }
        }
        else {
            throw new PageNotFoundException($nick);
        }

        $isAvatar = ($user['path_avatar'])?true:false;
        $avatar = ($user['path_avatar'])
                  ? $user['path_avatar']
                  : base_url()."/images/employee.svg";
        
        $data = [
            'title' => 'Me '.$nick,
            'isYou' => $isYou,
            'user_nick' => $nick,
            'user_desc' => $user['description'],
            'user_image' => $avatar,
            'isAvatar' => $isAvatar
        ];
        echo view('Share/header.php', $data);
        echo view('me', $data);
        echo view('Share/footer.php');
    }

    public function subscribe(string $nickAuthor)
    {
        $session = session();
        if (! $session->has('isAuth')) {
            $this->response->setJSON(false);
            echo json_encode(['isAuth' => false]);
            return;
        }

        $usersModel = new UsersModel();
        $author = $usersModel->getUser($nickAuthor);
        $idUser = (int)$session->get('idUser');

        $subModel = new SubscriptionsModel();
        $isSub = $subModel->setSubscribe($idUser, $author['id']);

        if ($isSub) {
            $this->response->setStatusCode(201)
                           ->setJSON(false);
            echo json_encode(['isSubscribe' => true]);
        }
        else {
            $this->response->setStatusCode(500)
                           ->setJSON(false);
            echo json_encode(['isSubscribe' => false]);
        }
    }

    public function describe(string $nickAuthor)
    {
        $session = session();
        if (! $session->has('isAuth')) {
            $this->response->setJSON(false);
            echo json_encode(['isAuth' => false]);
            return;
        }

        $usersModel = new UsersModel();
        $author = $usersModel->getUser($nickAuthor);
        $idUser = (int)$session->get('idUser');

        $subModel = new SubscriptionsModel();
        $isDescribe = $subModel->unsetSubscribe($idUser, $author['id']);

        if ($isDescribe) {
            $this->response->setJSON(false);
            echo json_encode(['isDescribe' => true]);
        }
        else {
            $this->response->setJSON(false);
            echo json_encode(['isDescribe' => false]);
        }
    }

    public function checkSubscribe(string $nickAuthor)
    {
        $session = session();
        if (! $session->has('isAuth')) {
            $this->response->setJSON(false);
            echo json_encode(['isSub' => false]);
            return;
        }

        $usersModel = new UsersModel();
        $author = $usersModel->getUser($nickAuthor);
        $idSub = (int)$session->get('idUser');

        $subModel = new SubscriptionsModel();
        $isSub = $subModel->checkSubscribe($idSub, $author['id']);

        if ($isSub) {
            $this->response->setJSON(false);
            echo json_encode(['isSubscribe' => true]);
        }
        else {
            $this->response->setStatusCode(500)
                           ->setJSON(false);
            echo json_encode(['isSubscribe' => false]);
        }
    }

    public function countSubscribers(string $nickAuthor)
    {
        $usersModel = new UsersModel();
        $author = $usersModel->getUser($nickAuthor);

        $subModel = new SubscriptionsModel();
        $countSubs = $subModel->getCountSubscribers($author['id']);

        if ($countSubs) {
            $this->response->setJSON(false);
            echo json_encode(['countSubs' => $countSubs]);
        }
        else {
            $this->response->setJSON(false);
            echo json_encode(['countSubs' => 0]);
        }
    }

    public function changeDescription()
    {
        $request = $this->request->getJSON();

        $session = session();
        $model = new UsersModel();

        if (! $session->get('idUser')) {
            $this->response->setJSON(false);
            echo json_encode(['isAuth' => false]);
            return;
        }
        $id = (int)$session->get('idUser');
        $user = $model->getUserById($id);

        $desc = $request->newDesc;
        if ($user) {
            $model->changeDescription($desc, $id);
            $this->response->setJSON(false);
            echo json_encode(['success' => true]);
        }
    }

    public function changeImage()
    {
        helper('filesystem');
        $session = session();
        $request = $this->request->getBody();

        if (! $session->has('isAuth')) {
            $this->response->setJSON(false);
            return json_encode(['isAuth' => false]);
        }

        $usersModel = new UsersModel();
        $idUser = (int)$session->get('idUser');
        $user = $usersModel->getUserById($idUser);

        $imagePath = ROOTPATH.'public/write/images/users/'.$user['nickname'].'.png';
        write_file($imagePath, $request, 'wb');

        $sitePath = base_url()."/write/images/users/".$user['nickname'].'.png';
        $status = $usersModel->changeAvatar($idUser, $sitePath);

        if ($status) {
            $this->response->setJSON(false);
            return json_encode(['success' => true]);
        }
        else {
            $this->response->setJSON(false);
            return json_encode(['success' => false]);
        }
    }
}