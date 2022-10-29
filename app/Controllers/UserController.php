<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pegawai;
use App\Models\User;

class UserController extends BaseController
{

    private $user;
    private $pegawai;

    public function __construct()
    {
        $this->user = new User();
        $this->pegawai = new Pegawai();
    }

    public function datatables()
    {
        if ($this->request->isAJAX()) {

            $user = $this->user->getAll();
            $record = [];
            $no = 1;

            foreach ($user as $value) {
                $row = [];
                $row[] = $no;
                $row[] = $value['username'];
                $row[] = $this->pegawai->getPegawai($value['pegawai_id'], 'nama_pegawai');
                $button = '<button type="button" name="update" url="' . base_url('master_user/user/edit_user/' . $value['id']) . '" class="edit btn btn-warning btn-sm"><i class = "fa fa-edit"></i></button> ';
                $button .= '<button type="button" name="delete" url="' . base_url('master_user/user/destroy_user/' . $value['id']) . '" class="delete btn btn-danger btn-sm"><i class = "fa fa-trash"></i></button> ';
                $row[] = $button;
                $no++;
                $record[] = $row;
            }

            $response = [
                'data' => $record
            ];

            return json_encode($response);
        } else {
            die('Access Via Ajax Request');
        }
    }

    public function index()
    {
        //
        return view('master_user/index_user');
    }

    public function edit_user($id)
    {
        $user = $this->user->edit_user($id);
        $data = [
            'user' => $user,
            'action' => base_url('master_user/user/update_user/' . $id),
        ];
        return view('master_user/form_user', $data);
    }

    public function update_user($id)
    {
        $update = $this->user->update_user($this->request, $id);
        if ($update['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Diubah',
                'url' => base_url('master_user/user')
            ];
        } else if ($update['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => [$update['messages']]
            ];
        }
        return json_encode($response);
    }

    public function destroy_user($id)
    {
        $destroy = $this->user->destroy_user($id);
        if ($destroy['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Dihapus',
            ];
        } else if ($destroy['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $destroy['messages']
            ];
        }
        return json_encode($response);
    }
}
