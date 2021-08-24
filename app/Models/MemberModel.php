<?php

namespace App\Models;

use CodeIgniter\Model;

class MemberModel extends Model
{
  protected $table      = 'karyawan';
  protected $primaryKey = 'id';

  protected $useAutoIncrement = true;

  protected $returnType     = 'array';

  protected $allowedFields = [
    // "KodeUser",
    "password",
    "Nama",
    "AlamatKTP",
    "KotaKTP",
    "PropinsiKTP",
    "NegaraKTP",
    "Telepon",
    "JenisKelamin",
    "NoInduk",
    "Email",
    "AlamatDomisili",
    "KotaDomisili",
    "PropinsiDomisili",
    "NegaraDomisili",
    "TempatLahir",
    "Pekerjaan",
    "TanggalLahir",
    "Status",
    // "IDJabatan",
  ];

  protected $beforeInsert = ['_hashPassword', "_gen_activation_code"];
  protected $beforeUpdate = ['_hashPassword'];

  protected $useTimestamps = true;
  protected $createdField  = 'created_at';
  protected $updatedField  = 'updated_at';

  protected $validationRules    = [
    "Nama" => "required",
    "Email" => "required|valid_email|is_unique[karyawan.Email,id,{id}]"
  ];

  protected $validationMessages = [
    "Nama" => [
      "required" => "Nama Tidak Boleh Kosong",
    ],
    "Email" => [
      "required" => "Email Tidak Boleh Kosong",
      "valid_email" => "Email Tidak Valid",
      "is_unique" => "Email Sudah Terdaftar"
    ]
  ];

  protected $skipValidation = false;


  /**
   * hashPassword merupakan fungsi callback untuk melakukan generate password
   * yang akan di jalankan ketika user menjalankan perintah insert atau update
   * dan fungsi callback ini di inisiasi di property $beforeInsert & $beforeUpdate
   * 
   */
  protected function _hashPassword(array $data)
  {
    if (!isset($data['data']['password'])) return $data;

    $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
    return $data;
  }

  /**
   * gen_activation_code merupakan fungsi untuk menggenerate code aktifasi yang akan
   * dijalankan ketika user melakukan insert, fungsi callback ini di inisiasi dalam
   * property $beforeInsert
   */
  protected function _gen_activation_code(array $data)
  {
    $data['data']['KodeAktivasi'] =  md5($data['data']["Email"] . "&&" . $data['data']["password"]);
    return $data;
  }
}
