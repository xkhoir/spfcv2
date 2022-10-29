<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use PhpOffice\PhpSpreadsheet\Reader;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use App\Models\Kerusakan;
use App\Models\Gejala;
use Exception;

class MasterScenarioSeeder extends Seeder
{

    private $gejala;
    private $kerusakan;

    public function __construct()
    {
        $this->gejala = new Gejala();
        $this->kerusakan = new Kerusakan();
    }

    public function run()
    {
        //

        // dd('../public/gejala.csv');

        $reader = new Csv();

        $file_gejala = '../public/excel csv/gejalas.csv';

        $file_kerusakan = '../public/excel csv/kerusakans.csv';

        $sheet_gejala = $reader->load($file_gejala);

        $data_gejala = $sheet_gejala->getActiveSheet()->toArray();

        $sheet_kerusakan = $reader->load($file_kerusakan);

        $data_kerusakan = $sheet_kerusakan->getActiveSheet()->toArray();

        $this->gejala->db->transBegin();

        try {

            for ($i = 0; $i < count($data_gejala); $i++) {
                $this->gejala->insert([
                    'id' => $data_gejala[$i][0],
                    'kode_gejala' => $data_gejala[$i][1],
                    'nama_gejala' => $data_gejala[$i][2]
                ]);
            }

            $this->gejala->db->transCommit();

            $this->kerusakan->db->transBegin();

            try {

                for ($j = 0; $j < count($data_kerusakan); $j++) {
                    $this->kerusakan->insert([
                        'id' => $data_kerusakan[$j][0],
                        'kode_kerusakan' => $data_kerusakan[$j][1],
                        'nama_kerusakan' => $data_kerusakan[$j][2],
                        'penyebab_kerusakan' => $data_kerusakan[$j][3],
                        'solusi_kerusakan' => $data_kerusakan[$j][4]
                    ]);
                }

                $this->kerusakan->db->transCommit();

            } catch (Exception $e) {
                $this->kerusakan->db->transRollback();
                die("Ekskusi Kerusakan Gagal");
            }
        } catch (Exception $e) {
            $this->gejala->db->transRollback();
            die("Ekskusi Gejala Gagal");
        }
    }
}
