<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Perbaikan;
use App\Models\Pegawai;
use App\Models\Kerusakan;
use App\Models\Gejala;
use App\Models\Mperbaikan;
use App\Models\DetPerbaikan;

class PerbaikanController extends BaseController
{
    private $perbaikan;
    private $pegawai;
    private $kerusakan;
    private $gejala;
    private $m_perbaikan;
    private $detPerbaikan;
    private $sesion;

    public function __construct()
    {
        $this->perbaikan = new Perbaikan();
        $this->gejala = new Gejala();
        $this->kerusakan = new Kerusakan();
        $this->pegawai = new Pegawai();
        $this->m_perbaikan = new Mperbaikan();
        $this->detPerbaikan = new DetPerbaikan();
        $this->session = session();
    }

    public function datatables()
    {
        if ($this->request->isAJAX()) {
            if ($this->session->get('role_id') == 3) {
                $perbaikan = $this->perbaikan->getAll($this->session->get('pegawai_id'));
            } else {
                $perbaikan = $this->perbaikan->getAll();
            }

            $record = [];
            $no = 1;
            foreach ($perbaikan as $key => $value) {
                $row = [];
                $row[] = $no;
                $row[] = $value['nama_customer'];
                $row[] = $value['alamat_customer'];
                $row[] = $value['no_telepon_customer'];
                $row[] = $this->pegawai->getPegawai($value['id_cs'], 'nama_pegawai');
                $row[] = $this->pegawai->getPegawai($value['id_teknisi'], 'nama_pegawai');

                $row[] = $value['tanggal_konsultasi'];
                // $row[] = $value['tanggal_mulai_perbaikan'];

                // if ($value['tanggal_selesai_perbaikan'] == NULL) {
                //     $selesai_perbaikan = "-";
                // } else {
                //     $selesai_perbaikan = $value['tanggal_selesai_perbaikan'];
                // }
                // $row[] = $selesai_perbaikan;

                // tampilan status selesai dan belum selesai
                if ($value['status_perbaikan'] == 0) {
                    $status = '<button type="button" class="btn btn-block bg-gradient-warning">Belum Selesai</button>';
                } else if ($value['status_perbaikan'] == 1) {
                    $status = '<button type="button" class="btn btn-block bg-gradient-success">Selesai</button>';
                }

                $row[] = $status;
                $row[] = $value['tanggal_selesai_perbaikan'];

                $button = "";
                $button .= '<button type="button" name="print" url="' . base_url('perbaikan/report_perbaikan/' . $value['id']) . '" class="print btn btn-primary btn-sm"><i class = "fa fa-print"></i></button> ';
                //jika status perbaikan bernilai 0 (belum selesai maka tombol akan tampil dan sebaliknya)
                if ($value['status_perbaikan'] == 0) {
                    $button .= '<button type="button" name="update" url="' . base_url('perbaikan/update_perbaikan/' . $value['id']) . '" class="edit btn btn-warning btn-sm"><i class = "fas fa-pencil-alt"></i></button> ';
                }

                $row[] = $button;
                $record[] = $row;
                $no++;
            }

            $response = [
                'data' => $record,
            ];
            return json_encode($response);
        } else {
            die('Access Via Ajax Request');
        }
    }

    public function index()
    {
        //nampilkan hanya hasil konsul punya cs

        if ($this->session->get('role_id') == 3) {
            return view('cs/perbaikan/index');
        }
        return view('perbaikan/index');
    }

    public function update_perbaikan($id)
    {
        $update = $this->perbaikan->update_tanggal_perbaikan($id);
        if ($update['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Diubah',
            ];
        } else if ($update['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $update['error']
            ];
        }
        return json_encode($response);
    }

    // Print Laporan
    public function report($id)
    {
        $perbaikan = $this->perbaikan->where(['id' => $id])->get()->getRow();
        $m_perbaikan = $this->m_perbaikan->where(['id_perbaikan' => $id])->get()->getResult('array');
        $detPerbaikan = $this->detPerbaikan->where(['id_perbaikan' => $id])->get()->getResult('array');

        $gejala = [];
        foreach ($m_perbaikan as $key => $value) {
            $row = [];
            $row['kode_gejala'] = $this->gejala->getGejala($value['id_gejala'], 'kode_gejala');
            $row['nama_gejala'] = $this->gejala->getGejala($value['id_gejala'], 'nama_gejala');
            if ($value['answer'] == 0) {
                $answer = 'Ya';
            } else if ($value['answer'] == 1) {
                $answer = 'Tidak';
            }
            $row['answer'] = $answer;
            $gejala[] = $row;
        }

        $kerusakan = [];
        foreach($detPerbaikan as $key => $value) {
            $row = [];
            $row['kode_kerusakan'] = $this->kerusakan->getKerusakan($value['id_kerusakan'], 'kode_kerusakan');
            $row['nama_kerusakan'] = $this->kerusakan->getKerusakan($value['id_kerusakan'], 'nama_kerusakan');
            $row['penyebab_kerusakan'] = $this->kerusakan->getKerusakan($value['id_kerusakan'], 'penyebab_kerusakan');
            $row['solusi_kerusakan'] = $this->kerusakan->getKerusakan($value['id_kerusakan'], 'solusi_kerusakan');
            $kerusakan[] = $row;
        }

        $data = [
            'perbaikan' => $perbaikan,
            'gejala' => $gejala,
            'kerusakan' => $kerusakan,
            'total_kerusakan' => count($kerusakan),
            'pegawai' => [
                'cs' => $this->pegawai->getPegawai($perbaikan->id_cs, 'nama_pegawai'),
                'teknisi' => $this->pegawai->getPegawai($perbaikan->id_teknisi, 'nama_pegawai')
            ]
        ];

        return view('cs/perbaikan/print', $data);
    }
}
