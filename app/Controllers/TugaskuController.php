<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\UserHelper;
use CodeIgniter\API\ResponseTrait;

class TugaskuController extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		$this->tindakanModel = model("TindakanModel");
		$this->userHelper = new UserHelper();

		$this->userRole = $this->userHelper->get_login_info()["role"];
		$this->userId = $this->userHelper->get_login_info()["id"];
	}

	public function index()
	{
		$arrTindakan = [];

		$query = $this->tindakanModel->select("tindakan.*, t2.nama_project")
			->join("tindakan_member t1", "tindakan.id_tindakan = t1.id_tindakan AND t1.deleted_at IS NULL")
			->join("project t2", "tindakan.id_project = t2.id_project");

		if ($this->userRole == 2) { // manager
			$arrTindakan = $query->where("t2.id_karyawan", $this->userId)
				->findAll();
		} elseif ($this->userRole == 3) {
			$arrTindakan = $query->where("t1.id_karyawan", $this->userId)
				->findAll();
		}

		return $this->respond([
			"is_login" => true,
			"status" => true,
			"data" => $arrTindakan
		]);
	}
}
