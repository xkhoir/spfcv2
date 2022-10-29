<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Pegawai;
use App\Models\Role;
use App\Models\User;
use Exception;

class UserScenarioSeeder extends Seeder
{
    private $pegawai;
    private $role;
    private $user;
    private $faker;

    public function __construct()
    {
        $this->pegawai = new Pegawai();
        $this->role = new Role();
        $this->user = new User();
        $this->faker = \Faker\Factory::create('id_ID');
    }
    public function run()
    {
        //

        $role_name = [
            'Super Admin',
            'Admin',
            'Customer Service',
            'Teknisi'
        ];

        for ($i = 0; $i < 4; $i++) {
            $this->role->insert([
                'nama_role' => $role_name[$i]
            ]);
        }

        for ($i = 0; $i < 5; $i++) {
            $id = rand(2, 4);

            if ($id == 2) {
                $kode = "AD" . $i + 1;
            } else if ($id == 3) {
                $kode = "CS" . $i + 1;
            } else if ($id == 4) {
                $kode = "TK" . $i + 1;
            }

            $this->pegawai->db->transBegin();
            try {

                if ($i + 1 == 1) {
                    $this->pegawai->insert([
                        'id' => $i + 1,
                        'role_id' => $this->role->where([
                            'id' => 1
                        ])->first()['id'],
                        'kode_pegawai' => "admin",
                        'nama_pegawai' => "admin",
                        'alamat_pegawai' => "Surabaya",
                        // 'alamat_pegawai' => $this->faker->address,
                        'nomor_telepon_pegawai' => $this->faker->phoneNumber
                    ]);

                    $this->user->insert([
                        'pegawai_id' => $i + 1,
                        'username' => "admin",
                        'password' => md5('user'),
                        'is_access' => 0
                    ]);
                } else {
                    $this->pegawai->insert([
                        'id' => $i + 1,
                        'role_id' => $this->role->where([
                            'id' => $id
                        ])->first()['id'],
                        'kode_pegawai' => $kode,
                        'nama_pegawai' => $this->faker->name,
                        'alamat_pegawai' => $this->faker->address,
                        'nomor_telepon_pegawai' => $this->faker->phoneNumber
                    ]);

                    if ($id != 4) {
                        $this->user->insert([
                            'pegawai_id' => $i + 1,
                            'username' => $kode,
                            'password' => md5('123'),
                            'is_access' => 0
                        ]);
                    }
                }
            } catch (Exception $e) {
                $this->pegawai->db->transRollback();
            }
            $this->pegawai->db->transCommit();
        }
    }
}
