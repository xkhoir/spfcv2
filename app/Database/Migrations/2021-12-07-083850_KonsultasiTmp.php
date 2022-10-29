<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class KonsultasiTmp extends Migration
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

            'id_cs' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'parent_gejala' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'default' => NULL,
            ],

            'child_gejala' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'default' => NULL,
            ],

            'answer' => [
                'type' => 'int',
                'constraint' => 11,
            ],

        ]);

        $this->forge->addKey('id', TRUE);

        $this->forge->addForeignKey('id_cs', 'pegawais', 'id');

        $this->forge->addForeignKey('parent_gejala', 'gejalas', 'id');

        $this->forge->addForeignKey('child_gejala', 'gejalas', 'id');

        $this->forge->createTable('konsultasitmps', TRUE);
    }

    public function down()
    {
        //
        $this->forge->dropTable('konsultasitmps');
    }
}
