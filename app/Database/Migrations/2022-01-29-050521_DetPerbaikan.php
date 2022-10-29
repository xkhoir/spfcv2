<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DetPerbaikan extends Migration
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

            'id_perbaikan' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'id_kerusakan' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'default' => NULL,
            ],

        ]);

        $this->forge->addKey('id', TRUE);

        $this->forge->addForeignKey('id_perbaikan', 'perbaikans', 'id');

        $this->forge->addForeignKey('id_kerusakan', 'kerusakans', 'id');

        $this->forge->createTable('detperbaikans', TRUE);
    }

    public function down()
    {
        //
        $this->forge->dropTable('detperbaikans');
    }
}
