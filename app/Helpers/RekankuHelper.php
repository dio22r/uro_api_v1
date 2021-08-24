<?php

namespace App\Helpers;

class RekankuHelper
{
  public function __construct()
  {
    $this->karyawanModel = model("KaryawanModel");
    $this->userHelper = new UserHelper();
    $this->userRole = $this->userHelper->get_login_info()["role"];
    $this->userId = $this->userHelper->get_login_info()["id"];
  }

  public function findAll($arrWhere = [], $select = "DISTINCT(karyawan.id), karyawan.nama")
  {
    $query = $this->karyawanModel->select($select)
      ->join("project_member t1", "karyawan.id = t1.id_karyawan AND t1.id_karyawan != $this->userId AND t1.deleted_at IS NULL")
      ->join("project t2", "t1.id_project = t2.id_project AND t2.deleted_at IS NULL");

    if ($this->userRole == 2) {
      // $query->where("t2.id_karyawan", $this->userId);
    } elseif ($this->userRole == 3) {
      $query->join("project_member t3", "t2.id_project = t3.id_project AND t3.deleted_at IS NULL")
        ->where("t3.id_karyawan", $this->userId);
    }

    $arrRekan = $query->where($arrWhere)->findAll();

    return $arrRekan;
  }

  public function find($idKaryawan)
  {
    $arrColumn = [
      "id",
      "kode_user",
      "nama",
      "telepon",
      "jenis_kelamin",
      "email",
      "alamat_domisili",
      "kota_domisili",
      "propinsi_domisili",
      "negara_domisili",
      "pekerjaan",
      "tanggal_lahir",
      "tempat_lahir",
      "id_jabatan",
    ];

    $column = implode(", ", $arrColumn);
    $arrData = $this->findAll(["karyawan.id" => $idKaryawan], $column);

    if ($arrData) {
      $arrData = $arrData[0];
    }
    return $arrData;
  }
}
