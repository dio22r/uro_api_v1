<?php

namespace App\Helpers;

use \App\Entities\UserEntity;
use Faker\Provider\Uuid;

class UserHelper
{
  public function __construct()
  {
    $this->session = \Config\Services::session();
    $this->email = \Config\Services::email();

    $this->userModel =  model("\App\Models\KaryawanModel");
  }

  public function insert_data($arrData)
  {
    $arrInsert = [
      "nama" => $arrData["nama"],
      "password" => $arrData["password"],
      "email" => $arrData["email"],
      "status" => 0,
      "id_jabatan" => 3,
    ];

    try {
      // set key;

      $this->_set_pwd_rules();
      $status = $this->userModel->save($arrInsert);
      $regId = $this->userModel->getInsertID();

      if ($status) {
        $arrJson = [
          'status' => true,
          'msg' => 'Data telah tersimpan',
        ];
      } else {
        $arrJson = [
          'status' => false,
          'msg' => $this->userModel->errors(),
        ];
      }
    } catch (\Exception $e) {
      $arrJson = [
        'status' => false,
        'msg' => $e->getMessage(),
      ];
    }

    return $arrJson;
  }

  protected function _set_pwd_rules()
  {
    $this->userModel->setValidationRule('password', 'required|min_length[8]');
    $this->userModel->setValidationMessage('password', [
      'required' => 'Password harus di isi minimal 8 Karakter',
      'min_length' => 'Password harus di isi minimal 8 Karakter'
    ]);
  }

  public function change_password($old, $new)
  {
    $id = $this->session->get('id');
    $arrData = $this->userModel
      ->where("id", $id)
      ->first();

    $status = false;
    $arrErr = [];
    // password olld
    if (!password_verify($old, $arrData["password"])) {
      $arrErr["password_old"] = "Password Lama Tidak Sesuai";
    }

    if (trim($new) != "") {
      $arrErr["password"] = "Harap Mengisi Password baru";
    }

    if (!$arrErr) {
      $arrData["password"] = $new;
      $status = $this->userModel->update($id, $arrData);
      if (!$status) {
        $arrErr = $this->userModel->errors();
      }
    }

    return [
      "status" => $status,
      "arrErr" => $arrErr
    ];
  }

  public function set_login_info($arrUser)
  {
    $this->session->set("id", $arrUser["id"]);
    $this->session->set("nama", $arrUser["nama"]);
    $this->session->set("role", $arrUser["id_jabatan"]);
  }

  public function check_login()
  {
    if (empty($this->session->get('id'))) {
      return false;
    } else {
      return $this->session->get('id');
    }
  }

  public function get_login_info()
  {
    $arrData = [
      'id' => $this->session->get("id"),
      'nama' => $this->session->get("nama"),
      'role' => $this->session->get("role"),
    ];

    return $arrData;
  }

  public function send_mail($to, $title, $message)
  {
    $this->email->setFrom("dioratar@gmail.com", "URO APPS");
    $this->email->setTo($to);

    $this->email->setSubject($title);
    $this->email->setMessage($message);

    $status = $this->email->send();

    return [
      "status" => $status,
      "to" => $to, // $this->email->ErrorInfo()
      "title" => $title
    ];
  }
}
