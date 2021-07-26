<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Karyawan extends Seeder
{
	public function run()
	{
		$data = [
			[
				'nama' => 'user 1',
				'kode_user' => '001',
				'email'    => 'user1@theempire.com',
				'password' => password_hash("12345", PASSWORD_DEFAULT),
				"status"   => 1
			],
			[
				'nama' => 'user 2',
				'kode_user' => '002',
				'email'    => 'user2@theempire.com',
				'password' => password_hash("12345", PASSWORD_DEFAULT),
				"status"   => 1
			],
			[
				'nama' => 'user 3',
				'kode_user' => '003',
				'email'    => 'user3@theempire.com',
				'password' => password_hash("12345", PASSWORD_DEFAULT),
				"status"   => 1
			],
			[
				'nama' => 'user 4',
				'kode_user' => '004',
				'email'    => 'user4@theempire.com',
				'password' => password_hash("12345", PASSWORD_DEFAULT),
				"status"   => 1
			],
			[
				'nama' => 'user 5',
				'kode_user' => '005',
				'email'    => 'user5@theempire.com',
				'password' => password_hash("12345", PASSWORD_DEFAULT),
				"status"   => 1
			],
			[
				'nama' => 'user 1',
				'kode_user' => '006',
				'email'    => 'dio.22ratar@gmail.com',
				'password' => password_hash("12345", PASSWORD_DEFAULT),
				"status"   => 1
			],
		];

		$this->db->table('karyawan')->insertBatch($data);
	}
}
