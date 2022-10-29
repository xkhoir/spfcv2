<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Pegawai;
use App\Models\Role;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;

class PegawaiController extends BaseController
{

    private $pegawai;
    private $role;

    public function __construct()
    {
        $this->pegawai = new Pegawai();
        $this->role = new Role();
    }

    public function datatables()
    {
        if ($this->request->isAJAX()) {
            $pegawai = $this->pegawai->getAll();
            $record = [];
            $no = 1;
            foreach ($pegawai as $value) {
                $row = [];
                $row[] = $no;
                $row[] = $value['kode_pegawai'];
                $row[] = $value['nama_pegawai'];
                $row[] = $this->role->getRoleName($value['role_id']);
                $row[] = $value['alamat_pegawai'];
                $row[] = $value['nomor_telepon_pegawai'];
                $button = '<button type="button" name="update" url="' . base_url('master_user/pegawai/edit_pegawai/' . $value['id']) . '" class="edit btn btn-warning btn-sm"><i class = "fa fa-edit"></i></button> ';
                $button .= '<button type="button" name="delete" url="' . base_url('master_user/pegawai/destroy_pegawai/' . $value['id']) . '" class="delete btn btn-danger btn-sm"><i class = "fa fa-trash"></i></button> ';
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
        //

        $data = [
            'url_add' => base_url('master_user/pegawai/create_pegawai')
        ];
        return view('master_pegawai/index_pegawai', $data);
    }

    public function create_pegawai()
    {
        $role = $this->role->getAllRole();
        $data = [
            'action' => base_url('master_user/pegawai/store_pegawai'),
            'role' => $role,
        ];
        return view('master_pegawai/form_pegawai', $data);
    }

    public function store_pegawai()
    {
        $store = $this->pegawai->store_pegawai($this->request);
        if ($store['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Ditambah',
                'url' => base_url('master_user/pegawai')
            ];
        } else if ($store['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $store['messages']
            ];
        }
        return json_encode($response);
    }

    public function edit_pegawai($id)
    {
        $role = $this->role->getAllRole();
        $pegawai = $this->pegawai->edit_pegawai($id);

        $data = [
            'action' => base_url('master_user/pegawai/update_pegawai/' . $id),
            'role' => $role,
            'pegawai' => $pegawai
        ];

        return view('master_pegawai/form_pegawai', $data);
    }

    public function update_pegawai($id)
    {
        $update = $this->pegawai->update_pegawai($this->request, $id);
        if ($update['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Diubah',
                'url' => base_url('master_user/pegawai')
            ];
        } else if ($update['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $update['messages']
            ];
        }
        return json_encode($response);
    }

    public function destroy_pegawai($id)
    {
        $update = $this->pegawai->destroy_pegawai($id);
        if ($update['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Dihapus',
            ];
        } else if ($update['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $update['messages']
            ];
        }
        return json_encode($response);
    }
}
