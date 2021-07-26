<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\ProyekkuHelper;
use App\Helpers\UserHelper;
use CodeIgniter\API\ResponseTrait;

class ProyekkuController extends BaseController
{
	use ResponseTrait;

	protected $arrRoleUserEdit = [1, 2];

	public function __construct()
	{
		$this->projectModel = model("ProjectModel");
		$this->userHelper = new UserHelper();
		$this->proyekkuHelper = new ProyekkuHelper();

		$this->userRole = $this->userHelper->get_login_info()["role"];
		$this->userId = $this->userHelper->get_login_info()["id"];
	}

	public function index()
	{
		$arrData = $this->proyekkuHelper->json_table(
			$this->userId,
			$this->userRole,
			$this->request->getGet("next")
		);

		$nextPage = false;
		$status = false;
		if ($arrData) {
			$status = true;
			$nextPage = $arrData[count($arrData) - 1]["created_at"];
		}

		$arrRes = [
			"status" => $status,
			"arrData" => $arrData,
			"nextPage" => $nextPage
		];

		return $this->respond($arrRes, 200);
	}

	public function create()
	{
		if (!in_array($this->userRole, $this->arrRoleUserEdit)) {
			$arrRes = [
				"status" => false,
				"msg" => "Operation Not Allowed"
			];
			return $this->respond($arrRes, 401);
		}

		$arrInsert = $this->request->getPost();
		$arrRes = $this->proyekkuHelper->insert_project($arrInsert);

		return $this->respond($arrRes, 200);
	}

	public function show($id)
	{
		$arrData = $this->proyekkuHelper->show_project($id);

		$status = false;
		if ($arrData) {
			$status = true;
		}

		$arrRes = [
			"status" => $status,
			"arrData" => $arrData
		];

		return $this->respond($arrRes, 200);
	}

	public function update($id)
	{
		if (!in_array($this->userRole, $this->arrRoleUserEdit)) {
			$arrRes = [
				"status" => false,
				"msg" => "Operation Not Allowed"
			];
			return $this->respond($arrRes, 401);
		}

		$arrUpdate = (array) $this->request->getJSON();
		$arrRes = $this->proyekkuHelper->update_project($id, $arrUpdate);

		return $this->respond($arrRes, 200);
	}

	public function delete($id)
	{
		$arrData = $this->projectModel
			->where("id_karyawan", $this->userId)
			->where("id_project", $id)
			->first();

		$msg = "Project gagal dihapus";
		$status = false;
		if ($arrData) {
			$status = $this->projectModel->delete($id);
			if ($status) {
				$msg = "Project berhasil di hapus";
			}
		}

		$arrRes = [
			"status" => $status,
			"msg" => $msg
		];

		return $this->respond($arrRes, 200);
	}
}
