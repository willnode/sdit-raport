<?php

namespace App\Controllers;

use App\Entities\Siswa as EntitiesSiswa;
use App\Libraries\MatkulProcessor;
use App\Libraries\NilaiProcessor;
use App\Models\NilaiModel;
use App\Models\SiswaModel;

class Siswa extends BaseController
{

	/** @var EntitiesSiswa  */
	public $siswa;

	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		parent::initController($request, $response, $logger);

		if (!($this->siswa = (new SiswaModel())->find($this->session->get('siswa')))) {
			$this->logout();
			$this->response->redirect('/login/')->send();
			exit;
		}
	}

	public function index()
	{
		$group = NilaiProcessor::aggregate((new NilaiModel())->withSiswa($this->siswa->nis)->findAll());
		return view('siswa/profile', [
			'siswa' => $this->siswa,
			'nilai' => $group,
		]);
	}

	public function transkrip()
	{
		$group = NilaiProcessor::aggregate((new NilaiModel())->withSiswa($this->siswa->nis)->findAll());
		$mpdf = new \Mpdf\Mpdf();
		$mpdf->WriteHTML(view('siswa/transkrip', [
			'siswa' => $this->siswa,
			'nilai' => $group,
			's' => $_GET['s'] ?? null,
		]));
		$mpdf->Output();
		exit;
	}

	public function logout()
	{
		$this->session->destroy();
		return $this->response->redirect('/');
	}
}
