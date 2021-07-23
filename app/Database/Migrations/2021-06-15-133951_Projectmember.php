<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Projectmember extends Migration
{
	public function up()
	{

		$this->forge->addField([
			'id_project_member' => [
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
				'type' => "bigint"
			],
			'id_project' => [
				'type' => "bigint"
			],
			'status' => [
				'type' => "int",
				'constraint' => 5
			]
		]);

		$this->forge->addKey('id_project_member', true);
		$this->forge->addKey('id_project');
		$this->forge->addKey('id_karyawan');

		$this->forge->createTable('project_member');
	}

	public function down()
	{
		$this->forge->dropTable('project_member');
	}
}
