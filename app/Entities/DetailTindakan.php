<?php

namespace App\Entities;

use CodeIgniter\Entity;

class DetailTindakan extends Entity
{
	public $IdTindakanDetail;
	public $created_at;
	public $updated_at;
	public $KodeUser;
	public $Tanggal;
	public $JamMulai;
	public $JamSelesai;
	public $Aktifitas;
	public $IDProject;
	public $IDTindakan;

	protected $datamap = [];
	protected $dates   = [
		'created_at',
		'updated_at',
		'deleted_at',
	];
	protected $casts   = [];
}
