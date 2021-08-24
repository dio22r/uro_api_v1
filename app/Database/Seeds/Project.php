<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Project extends Seeder
{
	public function run()
	{
		$data = [
			[
				'KodeUser' => '001',
				'NamaProject' => 'Project 1',
				'Status' => 1
			],
			[
				'KodeUser' => '001',
				'NamaProject' => 'Project 2',
				'Status' => 1
			],
			[
				'KodeUser' => '001',
				'NamaProject' => 'Project 3',
				'Status' => 1
			]
		];

		$this->db->table('project')->insertBatch($data);
	}
}
