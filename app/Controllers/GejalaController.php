<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Gejala;

class GejalaController extends BaseController
{
    private $gejala;

    public function __construct()
    {
        $this->gejala = new Gejala();
    }

    public function datatables()
    {
        if ($this->request->isAJAX()) {
            $gejala = $this->gejala->getAll();
            $record = [];
            $no = 1;
            foreach ($gejala as $value) {
                $row = [];
                $row[] = $no;
                $row[] = $value['kode_gejala'];
                $row[] = $value['nama_gejala'];
                $button = '<button type="button" name="update" url="' . base_url('master_kerusakan/gejala/edit_gejala/' . $value['id']) . '" class="edit btn btn-warning btn-sm"><i class = "fa fa-edit"></i></button> ';
                $button .= '<button type="button" name="delete" url="' . base_url('master_kerusakan/gejala/destroy_gejala/' . $value['id']) . '" class="delete btn btn-danger btn-sm"><i class = "fa fa-trash"></i></button> ';
                $row[] = $button;
                $record[] = $row;
                $no++;
            }
            $response = [
                'data' => $record
            ];
            return json_encode($response);
        } else {
            die('Only AJAX Request');
        }
    }

    public function index()
    {
        //
        $data = [
            'url_add' => base_url('master_kerusakan/gejala/create_gejala'),
        ];
        return view('master_gejala/index', $data);
    }

    public function create_gejala()
    {
        $data = [
            'action' => base_url('master_kerusakan/gejala/store_gejala')
        ];
        return view('master_gejala/form', $data);
    }

    public function store_gejala()
    {
        $store = $this->gejala->store_gejala($this->request);
        if ($store['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Ditambah',
                'url' => base_url('master_kerusakan/gejala')
            ];
        } else if ($store['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $store['messages']
            ];
        }
        return json_encode($response);
    }

    public function edit_gejala($id)
    {
        $gejala = $this->gejala->edit_gejala($id);
        $data = [
            'gejala' => $gejala,
            'action' => base_url('master_kerusakan/gejala/update_gejala/' . $id)
        ];
        return view('master_gejala/form', $data);
    }

    public function update_gejala($id)
    {
        $store = $this->gejala->update_gejala($this->request, $id);
        if ($store['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Diubah',
                'url' => base_url('master_kerusakan/gejala')
            ];
        } else if ($store['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $store['messages']
            ];
        }
        return json_encode($response);
    }

    public function destroy_gejala($id)
    {
        $destroy = $this->gejala->destroy_gejala($id);
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
