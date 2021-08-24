<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\TindakanHelper;
use App\Helpers\UserHelper;
use CodeIgniter\API\ResponseTrait;

class TindakanController extends BaseController
{
	use ResponseTrait;

	protected $arrRoleUserEdit = [1, 2];

	public function __construct()
	{
		$this->tindakanModel = model("TindakanModel");
		$this->tindakanHelper = new TindakanHelper();
		$this->userHelper = new UserHelper();

		$this->userRole = $this->userHelper->get_login_info()["role"];
		$this->userId = $this->userHelper->get_login_info()["id"];
	}

	public function index($idProject)
	{
		$result = $this->tindakanHelper->json_table($idProject);

		return $this->respond($result);
	}

	public function create($idProject)
	{
		if (!in_array($this->userRole, $this->arrRoleUserEdit)) {
			$arrRes = [
				"status" => false,
				"msg" => "Operation Not Allowed"
			];
			return $this->respond($arrRes, 401);
		}

		$arrData = $this->request->getPost();

		$result = $this->tindakanHelper->insert_tindakan($idProject, $arrData);

		return $this->respond($result);
	}

	public function show($idTindakan)
	{
		$result = $this->tindakanHelper->get_tindakan_detail($idTindakan);

		return $this->respond($result);
	}

	public function update($idTindakan)
	{
		if (!in_array($this->userRole, $this->arrRoleUserEdit)) {
			$arrRes = [
				"status" => false,
				"msg" => "Operation Not Allowed"
			];
			return $this->respond($arrRes, 401);
		}

		$arrData = $this->request->getJSON();

		$result = $this->tindakanHelper->update_tindakan($idTindakan, $arrData);

		return $this->respond($result);
	}

	public function delete($idTindakan)
	{
		if (!in_array($this->userRole, $this->arrRoleUserEdit)) {
			$arrRes = [
				"status" => false,
				"msg" => "Operation Not Allowed"
			];
			return $this->respond($arrRes, 401);
		}

		$this->tindakanModel->delete($idTindakan);
	}
}
