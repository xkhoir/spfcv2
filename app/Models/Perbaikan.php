<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class Perbaikan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'perbaikans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_cs',
        'id_teknisi',
        'nama_customer',
        'alamat_customer',
        'no_telepon_customer',
        'tanggal_konsultasi',
        'tanggal_mulai_perbaikan',
        'tanggal_selesai_perbaikan',
        'status_perbaikan'
    ];

    public function getAll($role = null)
    {
        if (empty($role)) {
            $perbaikan = $this->findAll();
            return $perbaikan;
        } else {
            $perbaikan = $this->where([
                'id_cs' => $role
            ])->get();
            return $perbaikan->getResult('array');
        }
    }

    public function update_tanggal_perbaikan($id)
    {
        $this->db->transBegin();

        try {
            //update status perbaikan
            $this->update(['id' => $id], [
                'tanggal_selesai_perbaikan' => date('Y-m-d'),
                'status_perbaikan' => 1
            ]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return [
                'status' => false,
                'error' => $e->getMessage()
            ];
        }

        $this->db->transCommit();
        return [
            'status' => true,
        ];
    }
}
