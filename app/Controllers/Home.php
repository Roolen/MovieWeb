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
		$data_user = [
			'first_name' => ($this->request->getPost('first_name') ?? ''),
			'nickname' => ($this->request->getPost('nickname') ?? ''),
			'email' => ($this->request->getPost('email') ?? ''),
			'password' => ($this->request->getPost('password') ?? ''),
			'phone_number' => ($this->request->getPost('phone_number') ?? '')
		];

		$model = new UsersModel();
		$check = $model->checkUser($data_user['nickname'],
								   $data_user['email'],
								   $data_user['phone_number']);

		foreach ($check as $key=>$value) {
			if ($value) {
				$check['success'] = false;
				$this->response->setStatusCode(409)
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

}
