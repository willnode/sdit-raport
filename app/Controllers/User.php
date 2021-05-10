<?php

namespace App\Controllers;

use App\Entities\Config;
use App\Entities\User as EntitiesUser;
use App\Libraries\PelajaranProcessor;
use App\Libraries\NilaiProcessor;
use App\Libraries\SiswaProcessor;
use App\Models\PelajaranModel;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Database;
use Config\Services;

class User extends BaseController
{

	/** @var EntitiesUser  */
	public $login;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);

		if (!($this->login = Services::login())) {
			$this->logout();
			$this->response->redirect('/login/')->send();
			exit;
		}
	}

	public function index()
	{
		return view('page/dashboard', [
			'page' => 'dashboard'
		]);
	}

	public function logout()
	{
		$this->session->destroy();
		return $this->response->redirect('/');
	}

	public function siswa($page = 'list', $id = null)
	{
		$model = new SiswaModel();
		switch ($page) {
			case 'list':
				if ($k = $this->request->getGet('detail')) {
					return view('siswa/detail', [
						'data' => $model->withKelas($k)->findAll(),
						'page' => 'siswa',
						'kelas' => $k,
					]);
				}
				return view('siswa/list', [
					'data' => $model->allKelas(),
					'page' => 'siswa',
				]);
			case 'detail':
				return $this->response->redirect('/user/siswa/?detail=' . $id);
			case 'edit':
				if (!($item = $model->find($id))) {
					throw new PageNotFoundException();
				}
				return view('siswa/edit', [
					'item' => $item,
					'page' => 'siswa',
				]);
			case 'print':
				if (!($item = $model->find($id))) {
					throw new PageNotFoundException();
				}
				$group = NilaiProcessor::aggregate((new NilaiModel())->withSiswa($item->nis)->findAll());
				return view('siswa/print', [
					'siswa' => $item,
					'page' => 'siswa',
					'nilai' => $group,
				]);
			case 'transkrip':
				if (!($item = $model->find($id))) {
					throw new PageNotFoundException();
				}
				$group = NilaiProcessor::aggregate((new NilaiModel())->withSiswa($item->nis)->findAll());
				$mpdf = new \Mpdf\Mpdf();
				$mpdf->WriteHTML(view('siswa/transkrip', [
					'siswa' => $item,
					'nilai' => $group,
					's' => $_GET['s'] ?? null,
				]));
				$mpdf->Output();
				exit;
			case 'export':
				set_excel_header('Siswa-' . ($id ? get_kelas_nice_name($id) : 'All'));
				(new SiswaProcessor)->export($model->withKelas($id)->findAll())->save('php://output');
				exit;
			case 'import':
				if ($this->request->getMethod() == 'post') {
					$c = (new SiswaProcessor)->import($this->request->getFile('file'));
					return $this->response->redirect("../?success_rows=$c");
				} else {
					return view('page/upload', [
						'page' => 'siswa',
					]);
				}
		}
	}

	public function nilai($page = 'list', $id = null)
	{
		switch ($page) {
			case 'list':
				if ($k = $this->request->getGet('detail')) {
					return view('nilai/detail', [
						'data' => (new NilaiModel())->withKelasPelajaran($k)->findAll(),
						'page' => 'nilai',
						'kelas_pelajaran' => $k,
					]);
				}
				return view('nilai/list', [
					'data' => (new NilaiModel())->where([
						'periode' => Services::config()->periode,
					])->allKelasPelajaran(),
					'page' => 'nilai',
				]);
			case 'set':
				if ($this->request->getMethod() === 'post') {
					if ($p = $this->request->getPost('periode')) {
						Config::get()->periode = $p;
						Config::get()->save();
						(new NilaiProcessor)->synchronize($p);
					}
					return $this->response->redirect('/user/nilai/');
				} else {
					return view('nilai/set', [
						'item' => Services::config(),
						'page' => 'nilai',
					]);
				}
			case 'detail':
				return $this->response->redirect('/user/nilai/?detail=' . $id);
			case 'export':
				set_excel_header('Nilai-' . ($id ? get_kelas_pelajaran_nice_name($id) : 'All'));
				(new NilaiProcessor)->export((new NilaiModel())->withKelasPelajaran($id)->findAll())->save('php://output');
				exit;
			case 'import':
				if ($this->request->getMethod() == 'post') {
					$c = (new NilaiProcessor)->import($this->request->getFile('file'));
					return $this->response->redirect("../?success_rows=$c");
				} else {
					return view('page/upload', [
						'page' => 'nilai',
					]);
				}
		}
	}

	public function pelajaran($page = 'list')
	{
		switch ($page) {
			case 'list':
				return view('pelajaran/list', [
					'data' => (new PelajaranModel())->findAll(),
					'page' => 'pelajaran',
				]);
			case 'export':
				set_excel_header('pelajaran-all');
				(new PelajaranProcessor)->export((new PelajaranModel())->findAll())->save('php://output');
				exit;
			case 'import':
				if ($this->request->getMethod() == 'post') {
					$c = (new PelajaranProcessor)->import($this->request->getFile('file'));
					return $this->response->redirect("../?success_rows=$c");
				} else {
					return view('page/upload', [
						'page' => 'pelajaran',
					]);
				}
		}
	}

	public function leger($page = 'list')
	{
		if (isset($_GET['kelas'])) {
			$nilaim = (new NilaiModel);
			$siswam = (new SiswaModel);
			if ($_GET['kelas']) {
				$nilaim->withKelasPelajaran($_GET['kelas']);
				$siswam->withKelas($_GET['kelas']);
			}
			$pelajaran = (new PelajaranModel())->findAll();
			$nilai = $nilaim->asLeger();
			$siswa = $siswam->findAll();
		}
		switch ($page) {
			case 'list':
				return view('leger/view', [
					'page' => 'leger',
					'kelas' => (new SiswaModel)->allKelas(),
					'pelajaran' => $pelajaran ?? null,
					'siswa' => $siswa ?? null,
					'nilai' => $nilai ?? null,
				]);
			case 'export':
				set_excel_header('Leger-' . (isset($_GET['kelas']) ? get_kelas_nice_name($_GET['kelas']) : 'All'));
				(new NilaiProcessor)->exportLeger((new SiswaModel)->allKelas(), $pelajaran ?? null, $siswa ?? null, $nilai ?? null)->save('php://output');
				exit;
		}
	}

	public function manage($page = 'list', $id = null)
	{
		if ($this->login->role !== 'admin') {
			throw new PageNotFoundException();
		}
		$model = new UserModel();
		if ($this->request->getMethod() === 'post') {
			if ($page === 'delete' && $model->delete($id)) {
				return $this->response->redirect('/user/manage/');
			} else if ($id = $model->processWeb($id)) {
				return $this->response->redirect('/user/manage/');
			}
		}
		switch ($page) {
			case 'list':
				return view('users/manage', [
					'data' => find_with_filter($model),
					'page' => 'users',
				]);
			case 'add':
				return view('users/edit', [
					'item' => new EntitiesUser()
				]);
			case 'edit':
				if (!($item = $model->find($id))) {
					throw new PageNotFoundException();
				}
				return view('users/edit', [
					'item' => $item
				]);
		}
		throw new PageNotFoundException();
	}

	public function uploads($directory)
	{
		$path = WRITEPATH . implode(DIRECTORY_SEPARATOR, ['uploads', $directory, '']);
		$r = $this->request;
		if (!is_dir($path))
			mkdir($path, 0775, true);
		if ($r->getMethod() === 'post') {
			if (($f = $r->getFile('file')) && $f->isValid()) {
				if ($f->move($path)) {
					return $f->getName();
				}
			}
		}
		return null;
	}

	public function profile()
	{
		if ($this->request->getMethod() === 'post') {
			if ((new UserModel())->processWeb($this->login->id)) {
				return $this->response->redirect('/user/profile/');
			}
		}
		return view('page/profile', [
			'item' => $this->login,
		]);
	}
}
