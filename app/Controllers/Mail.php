<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\MessagesModel;

class Mail extends BaseController
{
    public function index()
    {
        $session = session();

        if (! $session->has('isAuth')) {
            $this->response->redirect(base_url());
        }

        $data = [
            'title' => 'Mail',
        ];

        echo view('Share/header', $data);
        echo view('mail');
        echo view('Share/footer');
    }

    public function senders()
    {
        $session = session();
        $request = $this->request->getJSON(true);

        $this->response->setJSON(false);
        if (! $session->has('isAuth')) {
            return json_encode(['isAuth' => false]);
        }

        $idUser = (int)$session->get('idUser');
        $messagesModel = new MessagesModel();
        $senders = $messagesModel->getSenders($idUser);

        if (! $senders) {
            return json_encode(['isEmpty' => true]);
        }

        $usersModel = new UsersModel();
        $users = $usersModel->getUserSById($senders);

        $usersData = [];
        foreach ($users as $user) {
            $usersData[] = [
                'nickname' => $user['nickname'],
                'avatar' => ($user['path_avatar'])
                            ? $user['path_avatar']
                            : base_url().'/images/employee.svg'
            ];
        }

        return json_encode($usersData);
    }

    public function messages()
    {
        $session = session();
        $request = $this->request->getJSON(true);

        $this->response->setJSON(false);
        if (! $session->has('isAuth')) {
            $this->response->redirect(base_url());
        }

        $idUser = (int)$session->get('idUser');
        $senderNick = $request['userNick'];

        $usersModel = new UsersModel();
        $senderUser = $usersModel->getUser($senderNick);

        if (! $senderUser) {
            return json_encode(['nickIncorrect' => true]);
        }

        $idSender = $senderUser['id'];

        $messagesModel = new messagesModel();
        $messages = $messagesModel->getMessages($idUser, $idSender);

        $messagesData = [];
        foreach ($messages as $message) {
            $messagesData[] = [
                'isUser' => ($message['id_sender'] == $idUser),
                'text' => $message['text_message'],
                'date' => $message['date_send']
            ];
        }

        return ($messages)
               ? json_encode($messagesData)
               : json_encode(['isEmpty' => true]);
    }

    public function sendMessage()
    {
        $session = session();
        $request = $this->request->getJSON(true);
        $this->response->setJSON(false);

        if (! $session->has('isAuth')) {
            return json_encode(['isAuth' => false]);
        }

        $text = $request['text'];
        $nickRecip = $request['nick'];
        $idUser = (int)$session->get('idUser');

        $usersModel = new UsersModel();
        $user = $usersModel->getUser($nickRecip);

        if (! $user) {
            return json_encode(['success' => false, 'nickIncorrect' => true]);
        }

        $idRecip = $user['id'];

        $messagesModel = new MessagesModel();
        $newMessage = $messagesModel->createMessage($idUser, $idRecip, $text);

        if ($newMessage) {
            return json_encode(['success' => true]);
        }
        else {
            return json_encode(['success' => false]);
        }
    }
}