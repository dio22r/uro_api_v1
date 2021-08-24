<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Project extends Entity
{
	public $id_project;
	public $kode_user;
	public $nama_project;
	public $nama_perusahaan;
	public $id_karyawan; // manager

	public $Status;

	public $tanggal_mulai;
	public $tanggal_selesai;
	public $keterangan;

	public $karyawan = [];

	public function add_karyawan(Karyawan $karyawan)
	{
		$this->karyawan[] = $karyawan;
	}
}
