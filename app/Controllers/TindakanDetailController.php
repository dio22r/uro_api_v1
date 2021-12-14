<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\UserHelper;
use CodeIgniter\API\ResponseTrait;

class TindakanDetailController extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		$this->tindakanDetailModel = model("TindakandetailModel");
		$this->userHelper = new UserHelper();

		$this->userRole = $this->userHelper->get_login_info()["role"];
		$this->userId = $this->userHelper->get_login_info()["id"];
	}

	public function index($idTindakan)
	{
		$arrData = $this->tindakanDetailModel
			->where("id_tindakan", $idTindakan)
			->findAll();

		return $this->respond([
			"is_login" => true,
			"data" => $arrData
		]);
	}

	public function show($idDetail)
	{
		$arrData = $this->tindakanDetailModel->find($idDetail);

		return $this->respond([
			"is_login" => true,
			"data" => $arrData
		]);
	}

	public function insert($idTindakan)
	{
		$arrPost = $this->request->getPost();
		$arrPost["id_tindakan"] = $idTindakan;
		$arrPost["id_karyawan_create"] = $this->userId;

		$status = $this->tindakanDetailModel->save($arrPost);

		return $this->respond([
			"is_login" => true,
			"status" => $status
		]);
	}

	public function update($idDetail)
	{
		$arrPost = $this->request->getJSON();
		$arrPost->id_tindakan_detail = $idDetail;

		$status = $this->tindakanDetailModel->save($arrPost);
		$arrData = $this->tindakanDetailModel->find($idDetail);

		return $this->respond([
			"is_login" => true,
			"status" => $status,
			"data" => $arrData
		]);
	}

	public function delete($idDetail)
	{
		$status = $this->tindakanDetailModel->delete($idDetail);
		if ($status) {
			$status = true;
		} else {
			$status = false;
		}

		return $this->respond([
			"is_login" => true,
			"status" => $status
		]);
	}
}
