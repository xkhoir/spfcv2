<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Mperbaikan extends Migration
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

            'id_gejala' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'answer' => [
                'type' => 'int',
                'constraint' => 11,
            ],
        ]);

        $this->forge->addKey('id', TRUE);

        $this->forge->addForeignKey('id_perbaikan', 'perbaikans', 'id');

        $this->forge->addForeignKey('id_gejala', 'gejalas', 'id');

        $this->forge->createTable('mperbaikans', TRUE);
    }

    public function down()
    {
        //
        $this->forge->dropTable('mperbaikans');
    }
}
