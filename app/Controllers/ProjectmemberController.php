<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\UserHelper;
use CodeIgniter\API\ResponseTrait;

class ProjectmemberController extends BaseController
{
	use ResponseTrait;

	protected $arrRoleUserEdit = [1, 2];

	public function __construct()
	{
		$this->projectMemberModel = model("ProjectMemberModel");
		$this->userHelper = new UserHelper();

		$this->userRole = $this->userHelper->get_login_info()["role"];
		$this->userId = $this->userHelper->get_login_info()["id"];
	}

	public function index($idProject)
	{
		$arrData = $this->projectMemberModel
			->select("t1.id, t1.nama, t1.id_jabatan, t1.email")
			->join("karyawan t1", "project_member.id_karyawan = t1.id")
			->where("id_project", $idProject)
			->findAll();

		return $this->respond([
			"is_login" => true,
			"status" => true,
			"idProject" => $idProject,
			"data" => $arrData,
			"msg" => ""
		]);
	}
}
