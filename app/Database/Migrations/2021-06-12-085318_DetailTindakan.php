<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetailTindakan extends Migration
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
				'type' => "timestamp",
				"null" => true
			],
			'updated_at' => [
				'type' => "timestamp",
				"null" => true
			],
			'deleted_at' => [
				'type' => "timestamp",
				"null" => true
			],
			'id_karyawan' => [
				'type' => "BIGINT"
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
			'id_project' => [
				'type' => "bigint"
			],
			'id_tindakan' => [
				'type' => "bigint",
			]
		]);

		$this->forge->addKey('id_tindakan_detail', true);
		$this->forge->addKey('id_project');
		$this->forge->addKey('id_tindakan');

		$this->forge->createTable('detail_tindakan');
	}

	public function down()
	{
		$this->forge->dropTable('detail_tindakan');
	}
}
