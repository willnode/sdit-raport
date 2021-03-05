<?php

namespace App\Controllers;

use App\Entities\Siswa;
use App\Libraries\Recaptha;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\UserModel;
use CodeIgniter\Files\Exceptions\FileNotFoundException;

class Home extends BaseController
{
	public function index()
	{
		return $this->response->redirect('/login');
	}

	public function login()
	{
		if ($this->session->has('login')) {
			return $this->response->redirect('/user/');
		}
		if ($r = $this->request->getGet('r')) {
			return $this->response->setCookie('r', $r, 0)->redirect('/login/');
		}
		if ($this->request->getMethod() === 'post') {
			$post = $this->request->getPost();
			if (isset($post['email'], $post['password'])) {
				$login = (new UserModel())->atEmail($post['email']);
				if ($login && password_verify(
					$post['password'],
					$login->password
				)) {
					(new UserModel())->login($login);
					if ($r = $this->request->getCookie('r')) {
						$this->response->deleteCookie('r');
					}
					return $this->response->redirect(base_url($r ?: 'user'));
				}
				/** @var Siswa $siswa */
				if ($siswa = (new SiswaModel())->find($post['email'])) {
					if (!$siswa->password || password_verify(
						$post['password'],
						$siswa->password
					)) {
						$this->session->set('siswa', $siswa->nis);
						if ($r = $this->request->getCookie('r')) {
							$this->response->deleteCookie('r');
						}
						return $this->response->redirect(base_url($r ?: 'siswa'));
					}
				}
			}
			$m = lang('Interface.wrongLogin');
		}
		return view('page/login', [
			'message' => $m ?? (($_GET['msg'] ?? '') === 'emailsent' ? lang('Interface.emailSent') : null)
		]);
	}

	public function uploads($directory, $file)
	{
		$path = WRITEPATH . implode(DIRECTORY_SEPARATOR, ['uploads', $directory, $file]);
		if ($file && is_file($path)) {
			header('Content-Type: ' . mime_content_type($path));
			header('Content-Length: ' . filesize($path));
			readfile($path);
			exit;
		}
		throw new FileNotFoundException();
	}
}
