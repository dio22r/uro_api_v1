<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tindakandetail extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_tindakan_detail' => [
				'type' => 'BIGINT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'created_at' => [
				'type' => 'datetime',
				'null' => true
			],
			'updated_at' => [
				'type' => 'datetime',
				'null' => true
			],
			'deleted_at' => [
				'type' => 'datetime',
				'null' => true
			],
			'id_karyawan_create' => [
				'type' => "BIGINT"
			],
			'id_karyawan_complete' => [
				'type' => "BIGINT"
			],
			'id_tindakan' => [
				'type' => "bigint",
			],
			'tanggal' => [
				'type' => "date"
			],
			'jam_mulai' => [
				'type' => "time"
			],
			'jam_selesai' => [
				'type' => "time"
			],
			'aktifitas' => [
				'type' => "varchar",
				'constraint' => 45
			],
			'status' => [
				'type' => 'int',
				'constraint' => 4
			]
		]);

		$this->forge->addKey('id_tindakan_detail', true);
		$this->forge->addKey('id_karyawan_create');
		$this->forge->addKey('id_karyawan_complete');
		$this->forge->addKey('id_tindakan');

		$this->forge->createTable('tindakan_detail');
	}

	public function down()
	{
		$this->forge->dropTable('tindakan_detail');
	}
}
