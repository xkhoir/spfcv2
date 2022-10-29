<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Kerusakan extends Migration
{
    public function up()
    {
        //

        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true
            ],

            'kode_kerusakan' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],

            'nama_kerusakan' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],

            'penyebab_kerusakan' => [
                'type' => 'TEXT',
            ],

            'solusi_kerusakan' => [
                'type' => 'TEXT',
            ],
        ]);

		$this->forge->addKey('id', TRUE);

        $this->forge->createTable('kerusakans', TRUE);
    }

    public function down()
    {
        //

        $this->forge->dropTable('kerusakans');
    }
}
