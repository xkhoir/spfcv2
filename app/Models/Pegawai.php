<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\RequestInterface;
use Config\Validation;
use App\Models\User;
use Exception;

class Pegawai extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pegawais';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'role_id',
        'kode_pegawai',
        'nama_pegawai',
        'alamat_pegawai',
        'nomor_telepon_pegawai'
    ];

    public function validation($request)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_pegawai' => [
                'label' => 'Nama Pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Pegawai Tidak Boleh Kosong'
                ],
            ],
            'jabatan_pegawai' => [
                'label' => 'Jabatan Pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jabatan Pegawai Tidak Boleh Kosong'
                ],
            ],
            'alamat_pegawai' => [
                'label' => 'Alamat Pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Pegawai Tidak Boleh Kosong'
                ],
            ],
            'nomor_telepon_pegawai' => [
                'label' => 'Nomor Telepon Pegawai',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor Telepon Pegawai Tidak Boleh Kosong'
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
        $pegawai = $this->findAll();
        return $pegawai;
    }

    public function getPegawai($id, $attr)
    {
        $pegawai = $this->where(['id' => $id])->first();
        return $pegawai[$attr];
    }

    public function getAllTeknisi()
    {
        $teknisi = $this->where([
            'role_id' => 4
        ])->get();
        return $teknisi->getResult('array');
    }

    public function store_pegawai($request)
    {

        $user = new User();
        helper(['form', 'url']);

        $validation = $this->validation($request);
        $post = $request->getVar();
        if ($validation['status'] == true) {

            $kode_peg = $this->select('id')->orderBy('id', 'desc')->limit(1)->get()->getRow();

            if ($post['jabatan_pegawai'] == 1) {
                $kode_pegawai = "SA" . $kode_peg->id + 1;
            } else if ($post['jabatan_pegawai'] == 2) {
                $kode_pegawai = "AD" . $kode_peg->id + 1;
            } else if ($post['jabatan_pegawai'] == 3) {
                $kode_pegawai = "CS" . $kode_peg->id + 1;
            } else if ($post['jabatan_pegawai'] == 4) {
                $kode_pegawai = "TK" . $kode_peg->id + 1;
            }

            $this->db->transBegin();

            try {
                $this->insert([
                    'role_id' => $post['jabatan_pegawai'],
                    'kode_pegawai' => $kode_pegawai,
                    'nama_pegawai' => ucwords($post['nama_pegawai']),
                    'alamat_pegawai' => ucwords($post['alamat_pegawai']),
                    'nomor_telepon_pegawai' => $post['nomor_telepon_pegawai']
                ]);

                $id_peg = $this->select('*')->orderBy('id', 'desc')->limit(1)->get()->getRow();

                if ($post['jabatan_pegawai'] != 4) {
                    $user->insert([
                        'pegawai_id' => $id_peg->id,
                        'username' => $id_peg->kode_pegawai,
                        'password' => md5('123'),
                        'is_access' => 0
                    ]);
                }
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

    public function edit_pegawai($id)
    {
        $user = $this->select('*')->where(['id' => $id])->get();
        return $user->getRow();
    }

    public function update_pegawai($request, $id)
    {
        $user = new User();
        helper(['form', 'url']);

        $validation = $this->validation($request);
        $post = $request->getVar();

        if ($validation['status'] == true) {

            if ($post['jabatan_pegawai'] == 1) {
                $kode_pegawai = "SA" . $id;
            } else if ($post['jabatan_pegawai'] == 2) {
                $kode_pegawai = "AD" . $id;
            } else if ($post['jabatan_pegawai'] == 3) {
                $kode_pegawai = "CS" . $id;
            } else if ($post['jabatan_pegawai'] == 4) {
                $kode_pegawai = "TK" . $id;
            }

            $this->db->transBegin();

            try {
                $this->update(['id' => $id], [
                    'role_id' => $post['jabatan_pegawai'],
                    'kode_pegawai' => $kode_pegawai,
                    'nama_pegawai' => ucwords($post['nama_pegawai']),
                    'alamat_pegawai' => ucwords($post['alamat_pegawai']),
                    'nomor_telepon_pegawai' => $post['nomor_telepon_pegawai']
                ]);

                $id_peg = $this->select('*')->where(['id' => $id])->get()->getRow();

                if ($post['jabatan_pegawai'] != 4) {
                    $user->update(['pegawai_id' => $id], [
                        'username' => $id_peg->kode_pegawai,
                        'password' => md5('123'),
                        'is_access' => 0
                    ]);
                }
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

    public function destroy_pegawai($id)
    {
        $user = new User();
        $user->where(['pegawai_id' => $id])->delete();
        $this->where(['id' => $id])->delete();
        return [
            'status' => true
        ];
    }
}
