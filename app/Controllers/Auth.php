<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
  use ResponseTrait;

  public function __construct()
  {
    $this->memberModel = new \App\Models\memberModel();
  }

  public function login()
  {
    $arrPost = $this->request->getPost();
    if (!$arrPost) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

    $arrReady = [
      "status" => false,
      "msg" => "maaf username atau password anda salah",
      "arrDet" => [
        "Email" => "email atau password salah",
        "password" => "email atau password salah"
      ]
    ];

    $arrWhere = ["Email" => $arrPost["Email"], "Status" => 1];
    $result = $this->memberModel->where($arrWhere)->first();

    if ($result) {
      if (password_verify($arrPost["password"], $result["password"])) {
        // $this->memberModel->set_login_data($result);

        $arrReady = [
          "status" => true,
          "msg" => "Selamat datang",
          "arrDet" => []
        ];
      }
    }

    return $this->respond($arrReady, 200);
  }

  public function aktivasi($code = "")
  {
    if (!$code) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

    $arrWhere = ["KodeAktivasi" => $code, "Status" => 0];
    $result = $this->memberModel->where($arrWhere)
      ->set(['Status' => 1])
      ->update();

    $arrReady = [
      'status' => false,
      'msg' => "Maaf ya, sepertinya ada kesalahan kode aktifasi mohon diperiksa lagi atau silahkan hubungi kami.",
      'arr_data' => [],
    ];

    if ($result) {
      $arrWhere = array("KodeAktivasi" => $code, "Status" => 1);
      $result = $this->memberModel->where($arrWhere)->first();

      if ($result) {
        $arrReady = [
          'status' => true,
          'msg' => "Aktifasi Sukses",
          'arr_data' => ['Email' => $result["Email"]]
        ];
      }
    }

    return $this->respond($arrReady, 200);
  }

  public function logout()
  {
    // logout
    $this->session->destroy();
    $arrReady = ['status' => true];
    return $this->respond($arrReady, 200);
  }
}
