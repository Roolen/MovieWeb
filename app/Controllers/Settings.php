<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\SettingsModel;

class Settings extends BaseController
{
    public function index()
    {
        $session = session();

        if (! $session->has('isAuth')) {
            return $this->response->redirect(base_url());
        }

        $idUser = (int)$session->get('idUser');
        $usersModel = new UsersModel();
        $user = $usersModel->getUserById($idUser);

        $data = [
            'title' => 'Settings '.$user['nickname'],
            'nick' => $user['nickname']
        ];

        echo view('Share/header', $data);
        echo view('settings');
        echo view('Share/footer');
    }

    public function getSettings()
    {
        $session = session();

        $this->response->setJSON(false);
        if (! $session->has('isAuth')) {
            return json_encode(['isAuth' => false]);
        }

        $idUser = (int)$session->get('idUser');

        $settingsModel = new SettingsModel();        
        $settings = $settingsModel->getSettings($idUser);

        if ($settings) {
            unset($settings['id']);
            foreach (array_keys($settings) as $option) {
                $settings[$option] = ($settings[$option])?true:false;
            }

            return json_encode($settings);
        }
        else {
            return json_encode(['isEmpty' => true]);
        }
    }

    public function acceptSettings()
    {
        $session = session();
        $request = $this->request->getJSON(true);

        $this->response->setJSON(false);
        if (! $session->has('isAuth')) {
            return json_encode(['isAuth' => false]);
        }

        $idUser = (int)$session->get('idUser');

        $settingsModel = new SettingsModel();
        $status = $settingsModel->acceptSettings($idUser, $request);

        if ($status) {
            return json_encode(['success' => true]);
        }
        else {
            return json_encode(['success' => false]);
        }
    }
}