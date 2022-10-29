<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use App\Models\Aturan;
use App\Models\AturanBreadth;
use Exception;

class AturanScenarioSeeder extends Seeder
{
    private $aturan;
    private $aturan_breadth;

    public function __construct()
    {
        $this->aturan = new Aturan();
        $this->aturan_breadth = new AturanBreadth();
    }

    public function run()
    {
        //

        $reader = new Csv();

        $file_aturan = '../public/excel csv/aturans.csv';

        $sheet_aturan = $reader->load($file_aturan);

        $data_aturan = $sheet_aturan->getActiveSheet()->toArray();

        $this->aturan->db->transBegin();

        try {

            for ($i = 0; $i < count($data_aturan); $i++) {

                $this->aturan->insert([
                    'id' => $data_aturan[$i][0],
                    'id_kerusakan' => $data_aturan[$i][1],
                    'gejala' => $data_aturan[$i][2]
                ]);
            }
        } catch (Exception $e) {
            $this->aturan->db->transRollback();
            die("Gagal Eksekusi Aturan");
        }

        $this->aturan->db->transCommit();

        $file_aturan_breadth = '../public/excel csv/aturanbreadths.csv';

        $sheet_aturan_breadth = $reader->load($file_aturan_breadth);

        $data_aturan_breadth = $sheet_aturan_breadth->getActiveSheet()->toArray();

        // dd($data_aturan_breadth);

        $this->aturan_breadth->db->transBegin();

        try {

            for ($i = 0; $i < count($data_aturan_breadth); $i++) {
                $this->aturan_breadth->insert([
                    'id' => $data_aturan_breadth[$i][0],
                    'id_aturan' => $data_aturan_breadth[$i][1],
                    'parent_kode_gejala' => $data_aturan_breadth[$i][2],
                    'child_kode_gejala' => $data_aturan_breadth[$i][3],
                    'id_kerusakan' => $data_aturan_breadth[$i][4],
                ]);
            }
        } catch (Exception $e) {
            $this->aturan_breadth->db->transRollback();
            die("Gagal Eksekusi Aturan Breadth". $e->getMessage());
        }

        $this->aturan_breadth->db->transCommit();
    }
}
