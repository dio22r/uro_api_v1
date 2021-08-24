<?php

namespace App\Entities;

use CodeIgniter\Entity;

class Tindakan extends Entity
{
	public $idTindakan;
	public $created_at;
	public $updated_at;
	public $KodeUser;
	public $Tanggal;
	public $JamMulai;
	public $JamSelesai;
	public $Tindakan;
	public $Status;
	public $IDProject;

	protected $datamap = [];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];
}
