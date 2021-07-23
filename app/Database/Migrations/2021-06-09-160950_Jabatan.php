<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Jabatan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_jabatan' => [
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'created_at' => [
				'type' => 'timestamp',
				'null' => true
			],
			'updated_at' => [
				'type' => 'timestamp',
				'null' => true
			],
			'deleted_at' => [
				'type' => 'timestamp',
				'null' => true
			],
			'nama_jabatan' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => true,
			],
			'keterangan' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => true,
			],
		]);
		$this->forge->addKey('id_jabatan', true);

		$this->forge->createTable('jabatan');
	}

	public function down()
	{
		$this->forge->dropTable('jabatan');
	}
}
