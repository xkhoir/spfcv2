<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AturanBreadth extends Migration
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

            'id_aturan' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'parent_kode_gejala' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'child_kode_gejala' => [
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

        $this->forge->addForeignKey('id_aturan', 'aturans', 'id');

        $this->forge->addForeignKey('parent_kode_gejala', 'gejalas', 'id');

        $this->forge->addForeignKey('child_kode_gejala', 'gejalas', 'id');

        $this->forge->addForeignKey('id_kerusakan', 'kerusakans', 'id');

        $this->forge->createTable('aturanbreadths', TRUE);
    }

    public function down()
    {
        //
        $this->forge->dropTable('aturanbreadths');
    }
}
