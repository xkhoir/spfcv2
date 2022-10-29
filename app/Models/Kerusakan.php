<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class Kerusakan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'kerusakans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'kode_kerusakan',
        'nama_kerusakan',
        'penyebab_kerusakan',
        'solusi_kerusakan'
    ];

    public function validation($request)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_kerusakan' => [
                'label' => 'Nama Kerusakan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Kerusakan Tidak Boleh Kosong'
                ],
            ],

            'penyebab_kerusakan' => [
                'label' => 'Penyebab Kerusakan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Penyebab Kerusakan Tidak Boleh Kosong'
                ],
            ],

            'solusi_kerusakan' => [
                'label' => 'Solusi Kerusakan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Solusi Kerusakan Tidak Boleh Kosong'
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

    public function getAll()
    {
        $kerusakan = $this->findAll();
        return $kerusakan;
    }

    public function getKerusakan($id, $attr)
    {
        $kerusakan = $this->where(['id' => $id])->first();
        return $kerusakan[$attr];
    }

    public function store_kerusakan($request)
    {
        helper(['form', 'url']);

        $validation = $this->validation($request);
        $post = $request->getVar();

        if ($validation['status'] == true) {

            $kerusakan = $this->select('id')->orderBy('id', 'desc')->limit(1)->get()->getRow();

            if (empty($kerusakan)) {
                $id = 1;
                $kode_kerusakan = "K" . $id;
            } else {
                $id = $kerusakan->id + 1;
                $kode_kerusakan = "K" . $id;
            }

            $this->db->transBegin();

            try {
                $this->insert([
                    'id' => $id,
                    'kode_kerusakan' => $kode_kerusakan,
                    'nama_kerusakan' => $post['nama_kerusakan'],
                    'penyebab_kerusakan' => $post['penyebab_kerusakan'],
                    'solusi_kerusakan' => $post['solusi_kerusakan']
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

    public function edit_kerusakan($id)
    {
        $kerusakan = $this->select('*')->where(['id' => $id])->get();
        return $kerusakan->getRow();
    }

    public function update_kerusakan($request, $id)
    {
        helper(['form', 'url']);

        $validation = $this->validation($request);
        $post = $request->getVar();

        if ($validation['status'] == true) {

            $this->db->transBegin();

            $kerusakan = $this->select('*')->where(['id' => $id])->get()->getRow();

            try {
                $this->update(['id' => $id], [
                    'id' => $id,
                    'kode_kerusakan' => $kerusakan->kode_kerusakan,
                    'nama_kerusakan' => $post['nama_kerusakan'],
                    'penyebab_kerusakan' => $post['penyebab_kerusakan'],
                    'solusi_kerusakan' => $post['solusi_kerusakan']
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

    public function destroy_kerusakan($id)
    {
        $this->where(['id' => $id])->delete();
        return [
            'status' => true
        ];
    }

    public function getLatestKerusakan()
    {
        $sql = "select*from kerusakans where id not in (select id_kerusakan from aturans)";
        $query = $this->db->query($sql);
        return $query->getResult('array');
    }

    public function getExistKerusakan($id)
    {
        $sql = "select*from kerusakans where id = $id or id not in (select id_kerusakan from aturans)";
        $query = $this->db->query($sql);
        return $query->getResult('array');
    }
}
