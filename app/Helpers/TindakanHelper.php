<?php

namespace App\Helpers;

use CodeIgniter\Database\Exceptions\DatabaseException;

class TindakanHelper
{
  public function __construct()
  {
    $this->tindakanModel =  model("TindakanModel");
    $this->tindakanDetailModel =  model("TindakandetailModel");
    $this->tindakanMemberModel =  model("TindakanmemberModel");

    $this->userHelper = new UserHelper();
    $this->userRole = $this->userHelper->get_login_info()["role"];
    $this->userId = $this->userHelper->get_login_info()["id"];
  }

  public function json_table($idProject)
  {
    $arrTindakan = $this->tindakanModel->where("id_project", $idProject)->findAll();

    return [
      "data" => $arrTindakan
    ];
  }

  public function get_tindakan_detail($idTindakan)
  {
    $status = false;
    $msg = "Data Tidak Ditemukan";

    $arrTindakan = $this->tindakanModel->find($idTindakan);
    if ($arrTindakan) {
      $arrTindakan["member"] = $this->tindakanMemberModel
        ->select("t1.id, t1.nama, t1.id_jabatan, t1.email")
        ->join("karyawan t1", "t1.id = id_karyawan")
        ->where("id_tindakan", $idTindakan)->findAll();
      $arrTindakan["detail"] = $this->tindakanDetailModel->where("id_tindakan", $idTindakan)->findAll();

      $status = true;
      $msg = "Oke";
    }

    return [
      "data" => $arrTindakan,
      "msg" => $msg,
      "status" => $status
    ];
  }

  public function insert_tindakan($idProject, $arrInsert)
  {
    $status = false;
    $arrErr = [];

    unset($arrInsert["id_tindakan"]);
    $arrInsert["id_project"] = $idProject;

    if ((!isset($arrInsert["karyawan"]) || count($arrInsert["karyawan"]) < 1) || (!isset($arrInsert["detail"]) || count($arrInsert["detail"]) < 1)) {
      return [
        "status" => false,
        "msg" => "Ditugaskan ke dan Daftar Tugas harus diisi",
        "arrErr" => []
      ];
    }

    $msg = "Data Gagal disimpan";
    try {
      $this->tindakanModel->transStart();
      $arrInsert["id_karyawan"] = $this->userId;
      $result = $this->tindakanModel->save($arrInsert);
      $idTindakan = $this->tindakanModel->insertID;

      $status = FALSE;
      if ($result) {
        foreach ($arrInsert["karyawan"] as $key => $val) {
          $karyInsert = [
            "id_tindakan" => $idTindakan,
            "id_karyawan" => $val,
            "status" => 1
          ];

          $this->tindakanMemberModel->save($karyInsert);
        }

        foreach ($arrInsert["detail"] as $key => $val) {
          $detInsert = [
            "id_tindakan" => $idTindakan,
            "id_karyawan_create" => $this->userId,
            "aktifitas" => $val,
            "status" => 1
          ];

          $this->tindakanDetailModel->save($detInsert);
        }

        $status = $this->tindakanModel->transStatus();
      }

      if ($status === FALSE) {
        $this->tindakanModel->transRollback();
      } else {
        $msg = "Data Berhasil di Simpan";
        $this->tindakanModel->transCommit();
      }
    } catch (DatabaseException $e) {
      $arrErr = ["Terjadi Kesalahan Pada System"];
    }

    return [
      "status" => $status,
      "msg" => $msg,
      "arrErr" => $arrErr
    ];
  }

  public function update_tindakan($idTindakan, $arrUpdate)
  {
    $status = false;
    $arrErr = [];

    $arrUpdate->id_tindakan = $idTindakan;

    $msg = "Data Gagal disimpan";
    try {
      $this->tindakanModel->transStart();
      // $arrUpdate->id_karyawan = $this->userId;

      $arrData = $this->tindakanModel->find($idTindakan);

      if ($arrData["id_karyawan"] == $this->userId) {
        $status = $this->tindakanModel->save($arrUpdate);
        if ($status) {
          $this->_update_detail($idTindakan, $arrUpdate);
          $this->_update_tindakan_member($idTindakan, $arrUpdate);
          $status = $this->tindakanModel->transStatus();
        }
      }

      if ($status === FALSE) {
        $this->tindakanModel->transRollback();
      } else {
        $msg = "Data Berhasil di Simpan";
        $this->tindakanModel->transCommit();
      }
    } catch (DatabaseException $e) {
      $arrErr = ["Terjadi Kesalahan Pada System"];
    }

    return [
      "status" => $status,
      "msg" => $msg,
      "arrErr" => $arrErr
    ];
  }

  protected function _update_tindakan_member($idTindakan, $arrUpdate)
  {
    $this->tindakanMemberModel
      ->where("id_tindakan", $idTindakan)
      ->whereNotIn("id_karyawan", $arrUpdate->karyawan)
      ->delete();

    foreach ($arrUpdate->karyawan as $key => $val) {
      $arrWhere = [
        "id_tindakan" => $idTindakan,
        "id_karyawan" => $val,
      ];
      $check = $this->tindakanMemberModel
        ->where($arrWhere)
        ->withDeleted()
        ->first();

      if ($check) {
        if ($check["deleted_at"] != null) {
          $this->tindakanMemberModel
            ->where($arrWhere)
            ->set(["deleted_at" => null])
            ->update();
        }
      } else {
        $karyInsert = [
          "id_tindakan" => $idTindakan,
          "id_karyawan" => $val,
          "status" => 1
        ];
        $this->tindakanMemberModel->save($karyInsert);
      }
    }
  }

  protected function _update_detail($idTindakan, $arrUpdate)
  {
    $idDetailKeep = [];
    foreach ($arrUpdate->detail as $key => $objVal) {
      if ($objVal->id_tindakan_detail != "") {
        // update
        $idDetailKeep[] = $objVal->id_tindakan_detail;
        $detailupdate = [
          "aktifitas" => $objVal->aktifitas,
          "status" => $objVal->status
        ];

        $this->tindakanDetailModel->update($objVal->id_tindakan_detail, $detailupdate);
      } else {
        // insert
        $detailupdate = [
          "aktifitas" => $objVal->aktifitas,
          "status" => $objVal->status,
          "id_karyawan_create" => $this->userId,
          "id_tindakan" => $idTindakan
        ];
        $this->tindakanDetailModel->insert($detailupdate);
        $idDetailKeep[] = $this->tindakanDetailModel->insertID;
      }
    }

    $this->tindakanDetailModel
      ->whereNotIn("id_tindakan_detail", $idDetailKeep)
      ->where("id_tindakan", $idTindakan)
      ->delete();
  }
}
