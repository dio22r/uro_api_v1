<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class UserController extends BaseController
{
	use ResponseTrait;

	public function __construct()
	{
		$this->userHelper = new \App\Helpers\UserHelper();
		$this->userModel = model('App\Models\KaryawanModel');

		$this->session = \Config\Services::session();
	}


	public function login()
	{
		$status = false;
		$msg = "Harap centang kode keamanan";

		// $check = $this->userHelper->verify_captcha($this->request);
		$check["success"] = true;
		if ($check["success"]) {
			$email = $this->request->getPost("email");
			$password = $this->request->getPost("password");

			$arrData = $this->userModel
				->where(['email' => $email, 'status' => 1])
				->first();

			$msg = "Username Tidak Ditemukan";
			if ($arrData) {
				$msg = "Password Salah";
				if (password_verify($password, $arrData["password"])) {
					$this->userHelper->set_login_info($arrData);
					$status = true;
					$msg = "Login Berhasil";
				}
			}
		}

		$arrRes = [
			"status" => $status,
			"msg" => $msg
		];

		return $this->respond($arrRes, 200);
	}

	public function logout()
	{
		$this->session->destroy();

		$arrRes = [
			"status" => true,
			"msg" => "Logout Berhasil"
		];

		return $this->respond($arrRes, 200);
	}

	public function register()
	{
		$arrData = [
			"nama" => $this->request->getPost("nama"),
			"password" => $this->request->getPost("password"),
			"email" => $this->request->getPost("email")
		];

		$arrRes = $this->userHelper->insert_data($arrData);

		if ($arrRes["status"]) {
			// send email activation
		}

		return $this->respond($arrRes, 200);
	}

	public function aktivasi($code)
	{
		if (!$code) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

		$arrWhere = ["kode_aktivasi" => $code, "status" => 0];
		$result = $this->userModel->where($arrWhere)
			->set(['status' => 1])
			->update();

		$arrReady = [
			'status' => false,
			'msg' => "Maaf ya, sepertinya ada kesalahan kode aktifasi mohon diperiksa lagi atau silahkan hubungi kami.",
			'arr_data' => [],
		];

		if ($result) {
			$arrWhere = array("kode_aktivasi" => $code, "status" => 1);
			$result = $this->userModel->where($arrWhere)->first();

			if ($result) {
				$arrReady = [
					'status' => true,
					'msg' => "Aktifasi Sukses",
					'arr_data' => ['Email' => $result["email"]]
				];
			}
		}

		return $this->respond($arrReady, 200);
	}

	public function forgot_password()
	{
		$email = $this->request->getPost();

		$arrData = $this->userModel
			->where("email", $email)
			->where("status", 1)
			->first();

		$result = [
			"status" => false
		];

		if ($arrData) {
			$title = "URO APPS: Reset Password";

			$kodeReset = md5(rand());

			$result = $this->userModel->update($arrData["id"], ["kode_reset" => $kodeReset]);

			if ($result) {
				$arrView = [
					"title" => $title,
					"nama" => $arrData["nama"],
					"url" => base_url("/api/forgot/" . $kodeReset)
				];

				$html = view("email/forgot_password", $arrView);
				$result = $this->userHelper->send_mail($email, $title, $html);
			}
		}

		return $this->respond($result, 200);
	}

	public function reset_password($code)
	{
		if (!$code) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

		$newpassword = substr(md5(rand()), 0, 8);

		$arrWhere = ["kode_reset" => $code];
		$result = $this->userModel->where($arrWhere)
			->set(['password' => $newpassword])
			->update();

		$arrReady = [
			'status' => false,
			'msg' => "reset password gagal",
			'arr_data' => [],
		];

		if ($result) {
			$arrWhere = array("kode_aktivasi" => $code, "status" => 1);
			$result = $this->userModel->where($arrWhere)->first();

			if ($result) {
				$arrReady = [
					'status' => true,
					'msg' => "Reset Sukses",
					'arr_data' => [
						'email' => $result["email"],
						"password" => $newpassword
					]
				];
			}
		}

		return $this->respond($arrReady, 200);
	}

	public function view_email()
	{
		$arrView = [
			"title" => "test",
			"nama" => "Nama",
			"url" => "#"
		];

		return view("email/forgot_password", $arrView);
	}

	public function show()
	{
		$arrReady = $this->userModel
			->find($this->userHelper->get_login_info()["id"]);

		return $this->respond($arrReady, 200);
	}

	public function update()
	{
		$id = $this->userHelper->get_login_info()["id"];

		$status = false;
		if ($id) {
			$arrUpdate = $this->request->getPost();
			$this->userModel->exclude_field(["status", "password"]);

			$arrUpdate["id"] = $id;
			$status = $this->userModel
				->save($arrUpdate);
		}

		$arrRes = [
			"status" => $status,
			"arrErr" => $this->userModel->errors()
		];

		return $this->respond($arrRes, 200);
	}

	public function update_akun()
	{
		$id = $this->userHelper->get_login_info()["id"];

		$status = false;
		$arrErr = [];
		if ($id) {
			$arrUpdate = [
				"id" => $id,
				"nama" => $this->request->getPost("nama"),
				"email" => $this->request->getPost("email")
			];

			$status = $this->userModel
				->save($arrUpdate);

			$arrErr = $this->userModel->errors();
		}

		$arrRes = [
			"status" => $status,
			"arrErr" => $arrErr
		];

		return $this->respond($arrRes, 200);
	}

	public function update_password()
	{
		$arrDet = $this->userHelper->change_password(
			$this->request->getPost("password_old"),
			$this->request->getPost("password"),
			$this->request->getPost("re_password")
		);

		$arrRes = [
			"status" => $arrDet["status"],
			"arrErr" => $arrDet["arrErr"]
		];

		return $this->respond($arrRes, 200);
	}
}
