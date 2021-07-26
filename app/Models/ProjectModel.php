<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
  protected $DBGroup              = 'default';
  protected $table                = 'project';
  protected $primaryKey           = 'id_project';
  protected $useAutoIncrement     = true;
  protected $insertID             = 0;
  protected $returnType           = 'array';
  protected $useSoftDeletes       = true;
  protected $protectFields        = true;
  protected $allowedFields = [
    "id_karyawan",
    "nama_project",
    "nama_perusahaan",
    "tanggal_mulai",
    "tanggal_selesai",
    "keterangan",
    "status"
  ];

  protected $useTimestamps        = true;
  protected $dateFormat           = 'datetime';
  protected $createdField         = 'created_at';
  protected $updatedField         = 'updated_at';
  protected $deletedField         = 'deleted_at';

  protected $validationRules    = [
    "nama_project" => "required",
    // "TanggalMulai" => "required|valid_email|is_unique[karyawan.Email,id,{id}]"
  ];

  protected $validationMessages = [
    "nama_project" => [
      "required" => "Nama Tidak Boleh Kosong",
    ]
  ];

  protected $skipValidation = false;
  protected $cleanValidationRules = true;
}
