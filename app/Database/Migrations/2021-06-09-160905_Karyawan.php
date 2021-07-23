<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Karyawan extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' => 'BIGINT',
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
			'kode_user' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => true,
			],
			'password' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'nama' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'alamat_ktp' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'kota_ktp' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'propinsi_ktp' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'negara_ktp' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'telepon' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'jenis_kelamin' => [
				'type' => 'varchar',
				'constraint' => 1,
				'null' => false,
			],
			'no_induk' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'email' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => false,
			],
			'alamat_domisili' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'kota_domisili' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'propinsi_domisili' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'negara_domisili' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'tempat_lahir' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => false,
			],
			'tanggal_lahir' => [
				'type' => 'date',
				'null' => true,
			],
			'pekerjaan' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => false,
			],
			'status' => [
				'type' => 'varchar',
				'constraint' => 5,
				'null' => true,
			],
			'id_jabatan' => [
				'type' => 'INT',
				'null' => true,
			],
			'kode_aktivasi' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
		]);

		$this->forge->addKey('id', true);
		$this->forge->addUniqueKey('kode_user');
		$this->forge->addKey('id_jabatan');

		$this->forge->createTable('karyawan');
	}

	public function down()
	{
		$this->forge->dropTable('karyawan');
	}
}
