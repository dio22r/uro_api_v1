<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Project extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_project' => [
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
			'id_karyawan' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => true,
			],
			'nama_project' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => true,
			],
			'nama_perusahaan' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => true,
			],
			'tanggal_mulai' => [
				'type' => 'date',
				'null' => true,
			],
			'tanggal_selesai' => [
				'type' => 'date',
				'null' => true,
			],
			'keterangan' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => true,
			],
			'status' => [
				'type' => 'int',
				'constraint' => 5,
			],
		]);
		$this->forge->addKey('id_project', true);
		$this->forge->addKey('id_karyawan');

		$this->forge->createTable('project');
	}

	public function down()
	{
		$this->forge->dropTable('project');
	}
}
