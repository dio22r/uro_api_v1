<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Tindakanmember extends Migration
{
	public function up()
	{

		$this->forge->addField([
			'id_tindakan_member' => [
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
				'type' => "bigint"
			],
			'id_tindakan' => [
				'type' => "bigint"
			],
			'status' => [
				'type' => "int",
				'constraint' => 5
			]
		]);

		$this->forge->addKey('id_tindakan_member', true);
		$this->forge->addKey('id_tindakan');
		$this->forge->addKey('id_karyawan');

		$this->forge->createTable('tindakan_member');
	}

	public function down()
	{
		$this->forge->dropTable('tindakan_member');
	}
}
