<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pegawai extends Migration
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

            'role_id' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'kode_pegawai' => [
                'type' => 'varchar',
                'constraint' => 255,
            ],

            'nama_pegawai' => [
                'type' => 'varchar',
                'constraint' => 255,
                'default' => NULL,
            ],

            'alamat_pegawai' => [
                'type' => 'TEXT',
                'default' => NULL,
            ],

            'nomor_telepon_pegawai' => [
                'type' => 'varchar',
                'constraint' => 255,
                'default' => NULL,
            ],
        ]);

        $this->forge->addKey('id', TRUE);

        $this->forge->addForeignKey('role_id', 'roles', 'id');

        $this->forge->createTable('pegawais', TRUE);

    }

    public function down()
    {
        //
        $this->forge->dropTable('pegawais');
    }
}
