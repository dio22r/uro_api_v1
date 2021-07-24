<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'karyawan';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDelete        = true;
	protected $protectFields        = true;
	protected $allowedFields = [
		"kode_user",
		"password",
		"nama",
		"alamat_ktp",
		"kota_ktp",
		"propinsi_ktp",
		"negara_ktp",
		"telepon",
		"jenis_kelamin",
		"no_induk",
		"email",
		"alamat_domisili",
		"kota_domisili",
		"propinsi_domisili",
		"negara_domisili",
		"tempat_lahir",
		"tanggal_lahir",
		"pekerjaan",
		"status",
		"id_jabatan",
		"kode_aktivasi",
		"kode_reset"
	];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules    = [
		"nama" => "required",
		"email" => "required|valid_email|is_unique[karyawan.email,id,{id}]"
	];

	protected $validationMessages = [
		"nama" => [
			"required" => "Nama Tidak Boleh Kosong",
		],
		"email" => [
			"required" => "Email Tidak Boleh Kosong",
			"valid_email" => "Email Tidak Valid",
			"is_unique" => "Email Sudah Terdaftar"
		]
	];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert = ['_hashPassword', "_gen_activation_code"];
	protected $afterInsert          = [];
	protected $beforeUpdate = ['_hashPassword'];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];




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
		$data['data']['kode_aktivasi'] =  md5($data['data']["email"] . "&&" . $data['data']["password"] . rand());
		return $data;
	}

	public function exclude_field($arrFields = ["id_jabatan", "status"])
	{
		$this->allowedFields = array_diff($this->allowedFields, $arrFields);
	}
}
