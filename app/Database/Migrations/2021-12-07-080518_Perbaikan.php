<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Perbaikan extends Migration
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

            'id_kerusakan' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
                'default' => NULL,
            ],

            'id_teknisi' => [
                'type' => 'int',
                'constraint' => 11,
                'unsigned' => true,
            ],

            'nama_customer' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],

            'alamat_customer' => [
                'type' => 'TEXT',
            ],

            'no_telepon_customer' => [
                'type' => 'varchar',
                'constraint' => '255'
            ],

            'tanggal_konsultasi' => [
                'type' => 'date',
                'default' => NULL
            ],

            'tanggal_mulai_perbaikan' => [
                'type' => 'date',
                'default' => NULL
            ],

            'tanggal_selesai_perbaikan' => [
                'type' => 'date',
                'default' => NULL
            ],

            'status_perbaikan' => [
                'type' => 'int',
                'default' => 0
            ],

        ]);

        $this->forge->addKey('id', TRUE);

        $this->forge->addForeignKey('id_cs', 'pegawais', 'id');

        $this->forge->addForeignKey('id_teknisi', 'pegawais', 'id');

        $this->forge->createTable('perbaikans', TRUE);
    }

    public function down()
    {
        //
        $this->forge->dropTable('perbaikans');
    }
}
