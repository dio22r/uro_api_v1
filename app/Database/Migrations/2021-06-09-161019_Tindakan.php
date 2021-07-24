<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tindakan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_tindakan' => [
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
			'id_karyawan' => [ // manager
				'type' => 'bigint',
			],
			'id_project' => [
				'type' => 'BIGINT',
			],
			'tanggal' => [
				'type' => 'date',
				'null' => true,
			],
			'jam_mulai' => [
				'type' => 'time',
				'null' => true,
			],
			'jam_selesai' => [
				'type' => 'time',
				'null' => true,
			],
			'tindakan' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => true,
			],
			'status' => [
				'type' => 'varchar',
				'constraint' => 4,
			],
		]);
		$this->forge->addKey('id_tindakan', true);
		$this->forge->addKey('id_karyawan');
		$this->forge->addKey('id_project');

		$this->forge->createTable('tindakan');
	}

	public function down()
	{
		$this->forge->dropTable('tindakan');
	}
}
