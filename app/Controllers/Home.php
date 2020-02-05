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

	public function showme($page = 'hello') {
		if (! is_file(APPPATH.'/Views/'.$page.'.php'))
		{
			throw new \CodeIgniter\Exceptions\PageNotFoundException($page);
		}

		$data['title'] = ucfirst($page);

		echo view('Share/header', $data);
		echo view($page, $data);
		echo view('Share/footer', $data);
	}

}
