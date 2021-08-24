<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Karyawan extends Entity
{
	public $id;
	public $kode_user;
	public $email;
	public $password;
	public $nama;

	public $no_induk;
	public $alamat_ktp;
	public $kota_ktp;
	public $propinsi_ktp;
	public $negara_ktp;

	public $alamat_domisili;
	public $kota_domisili;
	public $propinsi_domisili;
	public $negara_domisili;

	public $telepon;
	public $jenis_kelamin;
	public $pekerjaan;
	public $tempat_lahir;
	public $tanggal_lahir;
	public $status;
	public $id_jabatan;
}
