<?php namespace App\Controllers;

use App\Models\UsersModel;

class Home extends BaseController
{
	public function index()
	{
		$model = new UsersModel();
		$data['users'] = $model->getUsers();
		return view('hello', $data);
	}

	public function showme($page = 'hello')
	{
		if (! is_file(APPPATH.'/Views/'.$page.'.php'))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}

		$data['title'] = ucfirst($page);

		echo view('Share/header', $data);
		echo view($page, $data);
		echo view('Share/footer', $data);
	}

	public function registration() 
	{
		$data_user = $this->request->getJSON();

		$data_user->phone_number = preg_replace("/[\-\(\)]/", "", $data_user->phone_number);
		$model = new UsersModel();
		$check = $model->checkUser($data_user->nickname,
								   $data_user->email,
								   $data_user->phone_number);

		$check = $check + $model->checkDataUser($data_user);

		foreach ($check as $key=>$value) {
			if ($value) {
				$check['success'] = false;
				$this->response->setStatusCode(422)
				               ->setJSON(false);
				echo json_encode($check);
				return;
			}
		}

		if ($model->createUser($data_user)) {
			$check['success'] = true;
			$this->response->setStatusCode(201)
			               ->setJSON(false);
			echo json_encode($check);
		}
		else {
			$check['success'] = false;
			$this->response->setStatusCode(400)
			               ->setJSON(false);
			echo json_encode($check);
		}
	}

	public function authorize()
	{
		$data_user = $this->request->getJSON();

		$model = new UsersModel();
		$verify = $model->verifyUser($data_user->nickname, $data_user->password);

		if ($verify['confirmed'] === false) {
			$this->response->setStatusCode(401)
						   ->setJSON(false);
			echo json_encode($verify);
			return;
		}

		$model = new UsersModel();
		$user = $model->getUser($data_user->nickname);
		$this->response->setStatusCode(200)
					   ->setJSON(false);
		echo json_encode($verify);

		$session = session();
		$session->set(['isAuth' => true]);
		$session->set(['idUser' => $user['id']]);
	}

}
