<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\RekankuHelper;
use App\Helpers\UserHelper;
use CodeIgniter\API\ResponseTrait;

class RekankuController extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		$this->userHelper = new UserHelper();
		$this->rekankuHelper = new RekankuHelper();

		$this->userRole = $this->userHelper->get_login_info()["role"];
		$this->userId = $this->userHelper->get_login_info()["id"];
	}

	public function index()
	{
		$arrRekan = $this->rekankuHelper->findAll();

		return $this->respond([
			"status" => true,
			"data" => $arrRekan
		]);
	}

	public function show($idKaryawan)
	{
		$arrData = $this->rekankuHelper->find($idKaryawan);

		return $this->respond([
			"status" => true,
			"data" => $arrData
		]);
	}
}
