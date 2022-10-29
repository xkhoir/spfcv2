<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Aturan extends Migration
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

            'id_kerusakan' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'gejala' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],

        ]);

		$this->forge->addKey('id', TRUE);

        $this->forge->addForeignKey('id_kerusakan', 'kerusakans', 'id');

        $this->forge->createTable('aturans', TRUE);
    }

    public function down()
    {
        //
        $this->forge->dropTable('aturans');
    }
}
