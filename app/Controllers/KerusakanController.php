<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Kerusakan;

class KerusakanController extends BaseController
{

    private $kerusakan;

    public function __construct()
    {
        $this->kerusakan = new Kerusakan();
    }

    public function datatables()
    {
        if ($this->request->isAJAX()) {
            $kerusakan = $this->kerusakan->getAll();
            $record = [];
            $no = 1;
            foreach ($kerusakan as $value) {
                $row = [];
                $row[] = $no;
                $row[] = $value['kode_kerusakan'];
                $row[] = $value['nama_kerusakan'];
                $row[] = $value['penyebab_kerusakan'];
                $row[] = $value['solusi_kerusakan'];
                $button = '<button type="button" name="update" url="' . base_url('master_kerusakan/kerusakan/edit_kerusakan/' . $value['id']) . '" class="edit btn btn-warning btn-sm"><i class = "fa fa-edit"></i></button> ';
                $button .= '<button type="button" name="delete" url="' . base_url('master_kerusakan/kerusakan/destroy_kerusakan/' . $value['id']) . '" class="delete btn btn-danger btn-sm"><i class = "fa fa-trash"></i></button> ';
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
            'url_add' => base_url('master_kerusakan/kerusakan/create_kerusakan')
        ];
        return view('master_kerusakan/index', $data);
    }

    public function create_kerusakan()
    {
        $data = [
            'action' => base_url('master_kerusakan/kerusakan/store_kerusakan')
        ];
        return view('master_kerusakan/form', $data);
    }

    public function store_kerusakan()
    {
        $store = $this->kerusakan->store_kerusakan($this->request);
        if ($store['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Ditambah',
                'url' => base_url('master_kerusakan/kerusakan')
            ];
        } else if ($store['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $store['messages']
            ];
        }
        return json_encode($response);
    }

    public function edit_kerusakan($id)
    {
        $kerusakan = $this->kerusakan->edit_kerusakan($id);
        $data = [
            'kerusakan' => $kerusakan,
            'action' => base_url('master_kerusakan/kerusakan/update_kerusakan/' . $id)
        ];
        return view('master_kerusakan/form', $data);
    }

    public function update_kerusakan($id)
    {
        $update = $this->kerusakan->update_kerusakan($this->request, $id);
        if ($update['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Diubah',
                'url' => base_url('master_kerusakan/kerusakan')
            ];
        } else if ($update['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $update['messages']
            ];
        }
        return json_encode($response);
    }

    public function destroy_kerusakan($id)
    {
        $destroy = $this->kerusakan->destroy_kerusakan($id);
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
