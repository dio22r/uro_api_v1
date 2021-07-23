<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EventLog extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id_event_log' => [
				'type' => 'BIGINT',
				'unsigned' => true,
				'auto_increment' => true,
			],
			'id_karyawan' => [
				'type' => 'varchar',
				'constraint' => 45,
			],
			'keterangan' => [
				'type' => 'varchar',
				'constraint' => 45,
			],
			'tanggal' => [
				'type' => 'date',
			],
			'jam' => [
				'type' => 'time',
			],
			'tipe' => [
				'type' => 'varchar',
				'constraint' => 5,
				'null' => true,
				'comments' => 'untuk menunjukkan bahwa event tersebut normal atau error'
			],
		]);

		$this->forge->addKey('id_event_log', true);
		$this->forge->addKey('id_karyawan');

		$this->forge->createTable('event_log');
	}

	public function down()
	{
		$this->forge->dropTable('event_log');
	}
}
