<?php

namespace App\Models;

use CodeIgniter\Model;
use Exception;

class User extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'pegawai_id',
        'username',
        'password',
        'is_access'
    ];

    public function getAll()
    {
        $user = $this->findAll();
        return $user;
    }

    public function edit_user($id)
    {
        $user = $this->where(['id' => $id])->get();
        return $user->getRow();
    }

    public function validation($request)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'password_1' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Tidak Boleh Kosong'
                ],
            ],
            'password_2' => [
                'label' => 'Password Konfirmasi',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Konfirmasi Tidak Boleh Kosong'
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

    public function update_user($request, $id)
    {
        helper(['form', 'url']);

        $validation = $this->validation($request);
        $post = $request->getVar();

        if ($validation['status'] == true) {

            if (md5($post['password_1']) != md5($post['password_2'])) {
                return [
                    'status' => false,
                    'messages' => 'Password dan Password Konfirmasi Tidak Sama'
                ];
            }

            $this->db->transBegin();

            try {
                $this->update(['id' => $id], [
                    'password' => md5($post['password_2']),
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

    public function destroy_user($id)
    {
        $this->where(['id' => $id])->delete();
        return [
            'status' => true
        ];
    }

    public function login_validate($request)
    {
        $validation = \Config\Services::validation();

        $validation->setRules([
            'username' => [
                'label' => 'Username',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Username Tidak Boleh Kosong'
                ],
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password Tidak Boleh Kosong'
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
}
