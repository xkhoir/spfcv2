<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Gejala extends Migration
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

            'kode_gejala' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],

            'nama_gejala' => [
                'type' => 'varchar',
                'constraint' => '255'
            ]
        ]);

		$this->forge->addKey('id', TRUE);

        $this->forge->createTable('gejalas', TRUE);
    }

    public function down()
    {
        //

        $this->forge->dropTable('gejalas');
    }
}
