<?php namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
	public function index()
	{
		return view('hello');
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
