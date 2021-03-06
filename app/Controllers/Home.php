<?php namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\SettingsModel;

class Home extends BaseController
{
	/**
	 * Opened hello page.
	 *
	 * @return void
	 */
	public function index()
	{
		$session = session();

		if ($session->has('isAuth')) {
			$this->response->redirect(base_url().'/news');
		}

		echo view('hello');
	}

	/**
	 * Trying of registration user, prepare validate getted the data.
	 * If data of user have in data base, then return json response to caller of method.
	 * If registration is success, then return json response to caller of method.
	 * 'nickname', 'email', 'phone' as duplicate flags.
	 * And registration data with postfix 'Incorrect' as validate flags.
	 *
	 * @return void
	 */
	public function registration() 
	{
		$data_user = $this->request->getJSON();
		$model = new UsersModel();
		$password = $data_user->password;

		$data_user->phone_number = preg_replace("/[\-\(\)\+]/", "",
												$data_user->phone_number);
												
		$check = $model->checkUser($data_user->nickname,
								   $data_user->email,
								   $data_user->phone_number);

		$check = $check + $model->checkDataUser($data_user);

		$this->response->setJSON(false);

		foreach ($check as $key=>$value) {
			if ($value) {
				$check['success'] = false;
				$this->response->setStatusCode(422);
				return json_encode($check);
			}
		}
		
		$idUser = $model->createUser($data_user);

		if ($idUser) {
			$settingsModel = new SettingsModel();
			$settings = $settingsModel->createSettings($idUser);

			$email = \Config\Services::email();

			$email->setFrom('admin@critics.fun', 'critics.fun');
			$email->setTo($data_user->email);

			$email->setSubject('Registration on critics.fun');
			$email->setMessage(view('Templates/registrationMail', [
				'nick' => $data_user->nickname,
				'password' => $password
			]));
			$email->send();

			$check['success'] = true;
			$this->response->setStatusCode(201);
			return json_encode($check);
		}
		else {
			$check['success'] = false;
			$this->response->setStatusCode(400);
			return json_encode($check);
		}
	}

	/**
	 * Authorization user and open session of user.
	 * Return response with json form.
	 *
	 * @return void
	 */
	public function authorize()
	{
		$data_user = $this->request->getJSON();
		$model = new UsersModel();

		$verify = $model->verifyUser($data_user->nickname, $data_user->password);

		$this->response->setJSON(false);
		if ($verify['confirmed'] === false) {
			$this->response->setStatusCode(401);
			return json_encode($verify);
		}

		$model = new UsersModel();
		$user = $model->getUser($data_user->nickname);
		$this->response->setStatusCode(200);
		echo json_encode($verify);

		$session = session();
		$session->set(['isAuth' => true]);
		$session->set(['idUser' => $user['id']]);
	}

}
