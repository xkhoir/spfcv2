<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Aturan;
use App\Models\AturanBreadth;
use App\Models\Kerusakan;
use App\Models\Gejala;

class AturanController extends BaseController
{

    private $aturan;
    private $aturan_breadth;
    private $kerusakan;
    private $gejala;

    public function __construct()
    {
        $this->aturan = new Aturan();
        $this->aturan_breadth = new AturanBreadth();
        $this->kerusakan = new Kerusakan();
        $this->gejala = new Gejala();
    }

    public function datatables()
    {
        if ($this->request->isAJAX()) {
            $aturan = $this->aturan->getAll();
            $record = [];
            $no = 1;
            foreach ($aturan as $value) {
                $row = [];
                $row[] = $no;
                $row[] = $this->kerusakan->getKerusakan($value['id_kerusakan'], 'nama_kerusakan');
                $exp_gejala = explode('->', $value['gejala']);
                $gejala_imp = [];
                foreach ($exp_gejala as $value_gejala) {
                    $kode_gejala = $this->gejala->getGejala($value_gejala, 'kode_gejala');
                    $gejala_imp[] = $kode_gejala;
                }
                $row[] = implode('->', $gejala_imp);
                $button = '<button type="button" name="update" url="' . base_url('aturan/edit_aturan/' . $value['id']) . '" class="edit btn btn-warning btn-sm"><i class = "fa fa-edit"></i></button> ';
                $button .= '<button type="button" name="delete" url="' . base_url('aturan/destroy_aturan/' . $value['id']) . '" class="delete btn btn-danger btn-sm"><i class = "fa fa-trash"></i></button> ';
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

    // untuk form tambah aturan atau rule checkbox
    private function rulePair($id = null)
    {
        $gejala = $this->gejala->getAll();

        if (!empty($id)) {
            $pair_rule = $this->aturan->getAturan($id, 'gejala');

            $explode_gejala = explode("->", $pair_rule);

            $rule_gejala = [];

            foreach ($explode_gejala as $value) {

                $rule_gejala[] = $value;
            }
        }

        $html = '';

        $html .= "<div class = 'col-md-12'>";

        for ($i = 0; $i < count($gejala); $i++) {
            $html .= "<div class='checkbox'>";
            $html .= "<label>";
            if (!empty($rule_gejala)) {
                if (in_array($gejala[$i]['id'], $rule_gejala)) {
                    $html .= "<input type='checkbox' name='kode_gejala[]' id='" . $gejala[$i]['id'] . "'value='" . $gejala[$i]['id'] . "' checked>";
                    $html .= $gejala[$i]['kode_gejala'] . "-" . $gejala[$i]['nama_gejala'];
                } else {
                    $html .= "<input type='checkbox' name='kode_gejala[]' id='" . $gejala[$i]['id'] . "'value='" . $gejala[$i]['id'] . "'>";
                    $html .= $gejala[$i]['kode_gejala'] . "-" . $gejala[$i]['nama_gejala'];
                }
            } else {
                $html .= "<input type='checkbox' name='kode_gejala[]' id='" . $gejala[$i]['id'] . "'value='" . $gejala[$i]['id'] . "'>";
                $html .= $gejala[$i]['kode_gejala'] . "-" . $gejala[$i]['nama_gejala'];
            }
            $html .= "</label>";
            $html .= "</div>";
        }
        $html .= "</div>";

        return $html;
    }

    public function index()
    {
        //
        $data = [
            'url_add' => base_url('aturan/create_aturan'),
        ];
        return view('aturan/index', $data);
    }

    public function create_aturan()
    {
        $gejala = $this->rulePair();
        $kerusakan = $this->kerusakan->getLatestKerusakan();

        $data = [
            'gejala' => $gejala,
            'kerusakan' => $kerusakan,
            'action' => base_url('aturan/store_aturan')
        ];

        return view('aturan/form', $data);
    }

    public function store_aturan()
    {
        $store = $this->aturan->store_aturan($this->request);
        if ($store['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Ditambah',
                'url' => base_url('aturan')
            ];
        } else if ($store['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $store['messages']
            ];
        }
        return json_encode($response);
    }

    public function edit_aturan($id)
    {
        $aturan = $this->aturan->edit_aturan($id);
        $gejala = $this->rulePair($id);
        $kerusakan = $this->kerusakan->getExistKerusakan($aturan->id_kerusakan);

        $data = [
            'aturan' => $aturan,
            'gejala' => $gejala,
            'kerusakan' => $kerusakan,
            'action' => base_url('aturan/update_aturan/' . $id)
        ];

        return view('aturan/form', $data);
    }

    public function update_aturan($id)
    {
        $store = $this->aturan->update_aturan($this->request, $id);
        if ($store['status'] == true) {
            $response = [
                'status' => 200,
                'messages' => 'Data Sukses Diubah',
                'url' => base_url('aturan')
            ];
        } else if ($store['status'] == false) {
            $response = [
                'status' => 422,
                'messages' => $store['messages']
            ];
        }
        return json_encode($response);
    }

    public function destroy_aturan($id)
    {
        $destroy = $this->aturan->destroy_aturan($id);
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
