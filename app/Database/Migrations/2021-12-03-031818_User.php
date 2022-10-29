<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class User extends Migration
{
    public function up()
    {
        //
        $this->forge->addField([
            'id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'pegawai_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'username' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],

            'password' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],

            'is_access' => [
                'type' => 'TEXT',
                'default' => 0,
            ],
        ]);

        $this->forge->addKey('id', TRUE);

        $this->forge->addForeignKey('pegawai_id', 'pegawais', 'id');

        $this->forge->createTable('users', TRUE);
    }

    public function down()
    {
        //

        $this->forge->dropTable('users');
    }
}
