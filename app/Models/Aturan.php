<?php

namespace App\Models;

use CodeIgniter\Model;
use App\Models\AturanBreadth;
use Exception;

class Aturan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'aturans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_kerusakan',
        'gejala'
    ];

    public function validation($request)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'kode_kerusakan' => [
                'label' => 'Kode Kerusakan',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode Kerusakan Tidak Boleh Kosong'
                ],
            ],
            'kode_gejala' => [
                'label' => 'Kode Gejala',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kode Gejala Tidak Boleh Kosong'
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
        $aturan = $this->findAll();
        return $aturan;
    }

    public function getAturan($id, $attr)
    {
        $aturan = $this->where(['id' => $id])->first();
        return $aturan[$attr];
    }

    public function store_aturan($request)
    {
        helper(['form', 'url']);

        $validation = $this->validation($request);
        $post = $request->getVar();

        if ($validation['status'] == true) {

            $list_gejala = implode('->', $post['kode_gejala']);

            $this->db->transBegin();

            try {

                $aturan_breadth = new AturanBreadth();

                $this->insert([
                    'id_kerusakan' => $post['kode_kerusakan'],
                    'gejala' => $list_gejala
                ]);

                $gejala_id = $this->select('id')->orderBy('id', 'DESC')->limit(1)->get()->getRow();

                $row = [];
                $gejala = [];

                for ($i = 0; $i < count($post['kode_gejala']); $i++) {
                    if ($i != count($post['kode_gejala']) - 1) {
                        $row['parent_kode_gejala'] = $post['kode_gejala'][$i];
                        $row['child_kode_gejala'] = $post['kode_gejala'][$i + 1];
                        $gejala[] = $row;
                    }
                }

                $row = [];
                $rule = [];

                for ($j = 0; $j < count($gejala); $j++) {
                    if ($j == count($gejala) - 1) {
                        $aturan_breadth->insert([
                            'id_aturan' => $gejala_id->id,
                            'parent_kode_gejala' => $gejala[$j]['parent_kode_gejala'],
                            'child_kode_gejala' => $gejala[$j]['child_kode_gejala'],
                            'id_kerusakan' => $post['kode_kerusakan']
                        ]);
                    } else {
                        $aturan_breadth->insert([
                            'id_aturan' => $gejala_id->id,
                            'parent_kode_gejala' => $gejala[$j]['parent_kode_gejala'],
                            'child_kode_gejala' => $gejala[$j]['child_kode_gejala'],
                            'id_kerusakan' => NULL
                        ]);
                    }
                }

                $this->db->transCommit();
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

    public function edit_aturan($id)
    {
        $aturan = $this->where(['id' => $id])->get();
        return $aturan->getRow();
    }

    public function update_aturan($request, $id)
    {
        helper(['form', 'url']);

        $validation = $this->validation($request);
        $post = $request->getVar();

        if ($validation['status'] == true) {

            $list_gejala = implode('->', $post['kode_gejala']);

            $this->db->transBegin();

            try {

                $aturan_breadth = new AturanBreadth();

                $this->update(['id' => $id], [
                    'id_kerusakan' => $post['kode_kerusakan'],
                    'gejala' => $list_gejala
                ]);

                $aturan_breadth->where(['id_aturan' => $id])->delete();

                $row = [];
                $gejala = [];

                for ($i = 0; $i < count($post['kode_gejala']); $i++) {
                    if ($i != count($post['kode_gejala']) - 1) {
                        $row['parent_kode_gejala'] = $post['kode_gejala'][$i];
                        $row['child_kode_gejala'] = $post['kode_gejala'][$i + 1];
                        $gejala[] = $row;
                    }
                }

                $row = [];
                $rule = [];

                for ($j = 0; $j < count($gejala); $j++) {
                    if ($j == count($gejala) - 1) {
                        $aturan_breadth->insert([
                            'id_aturan' => $id,
                            'parent_kode_gejala' => $gejala[$j]['parent_kode_gejala'],
                            'child_kode_gejala' => $gejala[$j]['child_kode_gejala'],
                            'id_kerusakan' => $post['kode_kerusakan']
                        ]);
                    } else {
                        $aturan_breadth->insert([
                            'id_aturan' => $id,
                            'parent_kode_gejala' => $gejala[$j]['parent_kode_gejala'],
                            'child_kode_gejala' => $gejala[$j]['child_kode_gejala'],
                            'id_kerusakan' => NULL
                        ]);
                    }
                }

                $this->db->transCommit();
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

    public function destroy_aturan($id)
    {
        $aturan_breadth = new AturanBreadth();
        $aturan_breadth->where(['id_aturan' => $id])->delete();
        $this->where(['id' => $id])->delete();
        return [
            'status' => true
        ];
    }
}
