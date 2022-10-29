<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class Gejala extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'gejalas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kode_gejala',
        'nama_gejala'
    ];

    public function getAll()
    {
        $gejala = $this->findAll();
        return $gejala;
    }

    public function getGejala($id, $attr)
    {
        $gejala = $this->where(['id' => $id])->first();
        return $gejala[$attr];
    }

    public function validation($request)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_gejala' => [
                'label' => 'Nama Gejala',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Gejala Tidak Boleh Kosong'
                ],
            ],
        ]);

        if ($validation->withRequest($request)->run()) {
            return [
                'status' => true
            ];
        } else {
            return [
                'status' => false,
                'error' => $validation->getErrors(),
            ];
        }
    }

    public function store_gejala($request)
    {
        helper(['form', 'url']);

        $validation = $this->validation($request);
        $post = $request->getVar();

        if ($validation['status'] == true) {

            $gejala = $this->select('id')->orderBy('id', 'desc')->limit(1)->get()->getRow();

            if (empty($gejala)) {
                $id = 1;
                $kode_gejala = "G" . $id;
            } else {
                $id = $gejala->id + 1;
                $kode_gejala = "G" . $id;
            }

            $this->db->transBegin();

            try {
                $this->insert([
                    'id' => $id,
                    'kode_gejala' => $kode_gejala,
                    'nama_gejala' => $post['nama_gejala']
                ]);
            } catch (Exception $e) {
                $this->db->transRollback();
                return [
                    'status' => false,
                    'messages' => [$e->getMessage()]
                ];
            }

            $this->db->transCommit();

            return [
                'status' => true
            ];
        } else if ($validation['status'] == false) {
            return [
                'status' => false,
                'messages' => $validation['error']
            ];
        }
    }

    public function edit_gejala($id)
    {
        $gejala = $this->select('*')->where(['id' => $id])->get();
        return $gejala->getRow();
    }

    public function update_gejala($request, $id)
    {
        helper(['form', 'url']);

        $validation = $this->validation($request);
        $post = $request->getVar();

        if ($validation['status'] == true) {

            $this->db->transBegin();

            $gejala = $this->select('*')->where(['id' => $id])->get()->getRow();

            try {
                $this->update(['id' => $id], [
                    'id' => $id,
                    'kode_gejala' => $gejala->kode_gejala,
                    'nama_gejala' => $post['nama_gejala']
                ]);
            } catch (Exception $e) {
                $this->db->transRollback();
                return [
                    'status' => false,
                    'messages' => [$e->getMessage()]
                ];
            }

            $this->db->transCommit();

            return [
                'status' => true
            ];
        } else if ($validation['status'] == false) {
            return [
                'status' => false,
                'messages' => $validation['error']
            ];
        }
    }

    public function destroy_gejala($id)
    {
        $this->where(['id' => $id])->delete();
        return [
            'status' => true
        ];
    }
}
