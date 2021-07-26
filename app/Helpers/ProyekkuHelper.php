<?php

namespace App\Helpers;

use CodeIgniter\Database\Exceptions\DatabaseException;

class ProyekkuHelper
{
  public function __construct()
  {
    $this->projectModel =  model("ProjectModel");
    $this->projectMemberModel = model("ProjectMemberModel");
    $this->karyawanModel = model("KaryawanModel");

    $this->userHelper = new UserHelper();
    $this->userRole = $this->userHelper->get_login_info()["role"];
    $this->userId = $this->userHelper->get_login_info()["id"];
  }

  public function json_table($nextPage)
  {
    $arrWhere = ["t1.id_karyawan" => $this->userId];
    if ($this->userRole == 2) {
      $arrWhere = ["project.id_karyawan" => $this->userId];
    }

    if ($nextPage) {
      $arrWhere["project.created_at >"] = $nextPage;
    }

    $arrData = $this->projectModel->select("DISTINCT(project.id_project),  project.*")
      ->join("project_member t1", "project.id_project = t1.id_project", "left")
      ->join("karyawan t2", "project.id_karyawan = t2.id", "left")
      ->where($arrWhere)
      ->orderBy("project.created_at")
      ->findAll(0, 5);

    return $arrData;
  }

  public function show_project($id)
  {
    $arrWhere = ["t2.id_karyawan" => $this->userId];
    if ($this->userRole == 2) {
      $arrWhere = ["project.id_karyawan" => $this->userId];
    }

    $arrData = $this->projectModel->select("project.*, t1.nama")
      ->join("karyawan t1", "project.id_karyawan = t1.id", "left")
      ->join("project_member t2", "project.id_project = t2.id_project", "left")
      ->where("project.id_project", $id)
      ->where($arrWhere)
      ->first();

    if ($arrData) {
      $arrKaryawan = $this->projectMemberModel
        ->select("t1.id, t1.nama, t1.email")
        ->join("karyawan t1", "t1.id = project_member.id_karyawan")
        ->where("project_member.id_project", $id)
        ->find();

      $arrData["karyawan"] = $arrKaryawan;
    }

    return $arrData;
  }

  public function insert_project($arrInsert)
  {
    $status = false;
    $arrErr = [];

    $arrInsert["id_karyawan"] = $this->userId;
    $arrInsert["status"] = 0;

    if (!isset($arrInsert["karyawan"]) || count($arrInsert["karyawan"]) < 1) {
      return [
        "status" => false,
        "msg" => "Karyawan harus diisi",
        "arrErr" => []
      ];
    }

    try {
      $this->projectModel->transStart();

      $this->projectModel->save($arrInsert);
      $id = $this->projectModel->insertID;

      $status = FALSE;
      if ($id) {
        foreach ($arrInsert["karyawan"] as $key => $val) {
          $karyInsert = [
            "id_project" => $id,
            "id_karyawan" => $val,
            "status" => 1
          ];

          $this->projectMemberModel->save($karyInsert);
        }

        $status = $this->projectModel->transStatus();
      }

      if ($status === FALSE) {
        $arrErr = $this->projectModel->errors();
        $this->projectModel->transRollback();
      } else {
        $this->projectModel->transCommit();
      }
    } catch (DatabaseException $e) {
      $status = false;
    }

    $msg = "Project Berhasil Tersimpan";
    if (!$status) {
      $msg = "Project Gagal Tersimpan";
    }

    return [
      "status" => $status,
      "msg" => $msg,
      "arrErr" => $arrErr
    ];
  }

  public function update_project($id, $arrUpdate)
  {
    $status = false;
    $arrErr = [];


    $arrUpdate["id_project"] = $id;
    $arrUpdate["id_karyawan"] = $this->userId;

    if (!isset($arrUpdate["karyawan"]) || count($arrUpdate["karyawan"]) < 1) {
      return [
        "status" => false,
        "msg" => "Karyawan harus diisi",
        "arrErr" => []
      ];
    }

    try {
      $this->projectModel->transStart();

      $status = $this->projectModel->save($arrUpdate);

      if ($status) {
        foreach ($arrUpdate["del_karyawan"] as $key => $val) {
          $this->projectMemberModel
            ->where("id_project", $id)
            ->where("id_karyawan", $val)
            ->delete();
        }

        foreach ($arrUpdate["karyawan"] as $key => $val) {
          $arrWhere = [
            "id_project" => $id,
            "id_karyawan" => $val
          ];
          $check = $this->projectMemberModel
            ->where($arrWhere)
            ->first();

          if ($check) {
            $this->projectMemberModel
              ->where($arrWhere)
              ->set(["deleted_at" => null])
              ->update();
          } else {
            $karyInsert = [
              "id_project" => $id,
              "id_karyawan" => $val,
              "status" => 1
            ];
            $this->projectMemberModel->save($karyInsert);
          }
        }

        $status = $this->projectModel->transStatus();
      }

      if ($status === FALSE) {
        $arrErr = $this->projectModel->errors();
        $this->projectModel->transRollback();
      } else {
        $this->projectModel->transCommit();
      }
    } catch (DatabaseException $e) {
      $status = false;
    }

    $msg = "Project Berhasil Tersimpan";
    if (!$status) {
      $msg = "Project Gagal Tersimpan";
    }

    return [
      "status" => $status,
      "msg" => $msg,
      "arrErr" => $arrErr
    ];
  }
}
