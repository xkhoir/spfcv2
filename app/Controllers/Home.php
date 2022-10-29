<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Pegawai;
use App\Models\Kerusakan;
use App\Models\Gejala;
use App\Models\Perbaikan;

class Home extends BaseController
{
    private $session;
    private $user;
    private $pegawai;
    private $gejala;
    private $perbaikan;
    private $kerusakan;


    public function __construct()
    {
        $this->user = new User();
        $this->pegawai = new Pegawai();
        $this->gejala = new Gejala();
        $this->kerusakan = new Kerusakan();
        $this->perbaikan = new Perbaikan();
        $this->session = session();
    }

    //tampilan card dasboard
    public function index()
    {
        if ($this->session->get('role_id') == 1 || $this->session->get('role_id') == 2) {

            $pegawai = $this->pegawai->findAll();
            $user = $this->user->findAll();
            $gejala = $this->gejala->findAll();
            $kerusakan = $this->kerusakan->findAll();
            $perbaikan = $this->perbaikan->findAll();

            $data = [
                'pegawai' => count($pegawai),
                'user' => count($user),
                'kerusakan' => count($kerusakan),
                'perbaikan' => count($perbaikan),
                'gejala' => count($gejala)
            ];

            return view('test/dashboard', $data);
        } else if ($this->session->get('role_id') == 3) {
            return view('cs/dashboard/index');
        }
    }
}
