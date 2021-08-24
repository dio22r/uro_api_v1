<?php

namespace App\Models;

use CodeIgniter\Model;

class TindakandetailModel extends Model
{
	protected $DBGroup              = 'default';
	protected $table                = 'tindakan_detail';
	protected $primaryKey           = 'id_tindakan_detail';
	protected $useAutoIncrement     = true;
	protected $insertID             = 0;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $protectFields        = true;
	protected $allowedFields        = [
		"id_karyawan_create",
		"id_karyawan_complete",
		"id_tindakan",
		"tanggal",
		"jam_mulai",
		"jam_selesai",
		"aktifitas",
		"status"
	];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks       = true;
	protected $beforeInsert         = [];
	protected $afterInsert          = [];
	protected $beforeUpdate         = [];
	protected $afterUpdate          = [];
	protected $beforeFind           = [];
	protected $afterFind            = [];
	protected $beforeDelete         = [];
	protected $afterDelete          = [];
}
