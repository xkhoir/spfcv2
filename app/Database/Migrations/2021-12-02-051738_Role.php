<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Role extends Migration
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

            'nama_role' => [
                'type' => 'varchar',
                'constraint' => '255'
            ]
        ]);

		$this->forge->addKey('id', TRUE);

        $this->forge->createTable('roles', TRUE);

    }

    public function down()
    {
        //

        $this->forge->dropTable('roles');
    }
}
