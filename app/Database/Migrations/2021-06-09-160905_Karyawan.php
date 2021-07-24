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
			],
			'alamat_ktp' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'kota_ktp' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'propinsi_ktp' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'negara_ktp' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'telepon' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'jenis_kelamin' => [
				'type' => 'varchar',
				'constraint' => 1,
			],
			'no_induk' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'email' => [
				'type' => 'varchar',
				'constraint' => 45,
				'null' => false,
			],
			'alamat_domisili' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'kota_domisili' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'propinsi_domisili' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'negara_domisili' => [
				'type' => 'varchar',
				'constraint' => 255,
			],
			'tempat_lahir' => [
				'type' => 'varchar',
				'constraint' => 45,
			],
			'tanggal_lahir' => [
				'type' => 'date',
				'null' => true,
			],
			'pekerjaan' => [
				'type' => 'varchar',
				'constraint' => 45,
			],
			'status' => [
				'type' => 'int',
				'constraint' => 5,
			],
			'id_jabatan' => [
				'type' => 'INT',
				'null' => false,
			],
			'kode_aktivasi' => [
				'type' => 'varchar',
				'constraint' => 255,
				'null' => false,
			],
			'kode_reset' => [
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
