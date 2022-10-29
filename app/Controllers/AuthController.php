<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\Pegawai;

class AuthController extends BaseController
{

    private $user;

    public function __construct()
    {
        $this->user = new User();
        $this->pegawai = new Pegawai();
    }

    public function index()
    {
        //

        $data = [
            'action' => base_url('auth/login_act')
        ];
        return view('auth/login', $data);
    }

    public function login()
    {
        helper(['form', 'url']);

        $session = session();

        $post = $this->request->getVar();

        $validation = $this->user->login_validate($this->request);

        if ($validation['status'] == true) {

            $login_check = $this->user->where([
                'username' => $post['username'],
                'password' => md5($post['password'])
            ])->first();

            if (!empty($login_check)) {
                if ($login_check['username'] != $post['username']) {
                    $response = [
                        'status' => 422,
                        'messages' => ['username tidak cocok dengan yang diinput']
                    ];

                    return json_encode($response);
                }

                if ($login_check['password'] != md5($post['password'])) {
                    $response = [
                        'status' => 422,
                        'messages' => ['password tidak cocok dengan yang diinput']
                    ];

                    return json_encode($response);
                }

                $nama_pegawai = $this->pegawai->getPegawai($login_check['pegawai_id'], 'nama_pegawai');
                $kode_pegawai = $this->pegawai->getPegawai($login_check['pegawai_id'], 'kode_pegawai');
                $role_pegawai = $this->pegawai->getPegawai($login_check['pegawai_id'], 'role_id');

                $session->set([
                    'logged' => true,
                    'id' => $login_check['id'],
                    'pegawai_id' => $login_check['pegawai_id'],
                    'nama_pegawai' => $nama_pegawai,
                    'kode_pegawai' => $kode_pegawai,
                    'role_id' => $role_pegawai
                ]);

                $response = [
                    'status' => 200,
                    'messages' => 'Login Sukses',
                    'url' => base_url('/')
                ];

                return json_encode($response);
            } else {
                $response = [
                    'status' => 422,
                    'messages' => ['username dan password tidak ditemukan']
                ];

                return json_encode($response);
            }
        } else if ($validation['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $validation['error']
            ];

            return json_encode($response);
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return json_encode([
            'status' => 200,
            'messages' => 'Anda Sudah Keluar Dari Sistem',
            'url' => base_url('auth/login')
        ]);
    }
}
