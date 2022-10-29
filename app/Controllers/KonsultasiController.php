<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Gejala;
use App\Models\Kerusakan;
use App\Models\Aturan;
use App\Models\AturanBreadth;
use App\Models\KonsultasiTmp;
use App\Models\Mperbaikan;
use App\Models\Pegawai;
use App\Models\Perbaikan;
use App\Models\DetPerbaikan;
use Exception;

class KonsultasiController extends BaseController
{
    private $gejala;
    private $kerusakan;
    private $aturan;
    private $aturan_breadth;
    private $konsultasi_tmp;
    private $perbaikan;
    private $m_perbaikan;
    private $pegawai;
    private $detPerbaikan;
    private $session;
    private $id_cs;

    public function __construct()
    {
        $this->gejala = new Gejala();
        $this->kerusakan = new Kerusakan();
        $this->aturan = new Aturan();
        $this->aturan_breadth = new AturanBreadth();
        $this->konsultasi_tmp = new KonsultasiTmp();
        $this->pegawai = new Pegawai();
        $this->perbaikan = new Perbaikan();
        $this->m_perbaikan = new Mperbaikan();
        $this->detPerbaikan = new DetPerbaikan();
        $this->session = session();
        $this->id_cs = $this->session->get('pegawai_id');
    }

    public function index()
    {
        //

        $this->konsultasi_tmp->where(['id_cs' => $this->id_cs])->delete();

        $sql_gejala = "select*from gejalas where id = 1 and id not in (select child_kode_gejala from aturanbreadths)";
        $gejala = $this->gejala->db->query($sql_gejala);

        $data = [
            'gejala' => $gejala->getRow(),
            'parent_gejala' => 0,
            'action' => base_url('konsultasi/savequestion')
        ];

        if ($this->session->get('role_id') == 3) {
            return view('cs/konsultasi/index', $data);
        }

        return view('konsultasi/index', $data);
    }

    private function mappingKonsultasi($data)
    {
        $konsultasi = [];
        foreach ($data as $key => $value) {
            $row = [];
            $row['kode_gejala'] = $this->gejala->getGejala($value['child_gejala'], 'kode_gejala');
            $row['nama_gejala'] = $this->gejala->getGejala($value['child_gejala'], 'nama_gejala');
            if ($value['answer'] == 0) {
                $answer = 'Ya';
            } else if ($value['answer'] == 1) {
                $answer = 'Tidak';
            }
            $row['answer'] = $answer;
            $konsultasi[] = $row;
        }
        return $konsultasi;
    }

    private function mappingKerusakan($data)
    {
        $kerusakan = [];
        $kerusakan['id_kerusakan'] = $data->id_kerusakan;
        $kerusakan['kode_kerusakan'] = $this->kerusakan->getKerusakan($data->id_kerusakan, 'kode_kerusakan');
        $kerusakan['nama_kerusakan'] = $this->kerusakan->getKerusakan($data->id_kerusakan, 'nama_kerusakan');
        $kerusakan['penyebab_kerusakan'] = $this->kerusakan->getKerusakan($data->id_kerusakan, 'penyebab_kerusakan');
        $kerusakan['solusi_kerusakan'] = $this->kerusakan->getKerusakan($data->id_kerusakan, 'solusi_kerusakan');
        return $kerusakan;
    }

    private function cekKerusakanTerdekat($id)
    {
        $sql = "select a.id_kerusakan, b.* from aturanbreadths a join kerusakans b on a.id_kerusakan = b.id where a.parent_kode_gejala = $id";
        $query = $this->kerusakan->db->query($sql)->getResult('array');
        return $query;
    }

    public function saveQuestion()
    {
        $post = $this->request->getVar();

        if (!isset($post['answer'])) {
            return json_encode([
                'status' => 422,
                'messages' => ['Silahkan Memilih Salah Satu']
            ]);
        }

        $teknisi = $this->pegawai->getAllTeknisi();

        $this->konsultasi_tmp->db->transBegin();

        // Cek Jika Parent Gejala = 0
        if ($post['parent_gejala'] == 0) {
            $parent_gejala = NULL;
        } else {
            $parent_gejala = $post['parent_gejala'];
        }

        // Cek apakah ada kesamaan data inputan konsultasitmps untuk menghindari data kembar
        $check_exist_konsul = $this->konsultasi_tmp->where([
            'id_cs' => $this->id_cs,
            'parent_gejala' => $parent_gejala,
            'child_gejala' => $post['child_gejala'],
        ])->first();

        // jika tidak terdapat data yang sama, input jawaban ke tabel konsultasitmps
        if (empty($check_exist_konsul)) {
            try {
                $this->konsultasi_tmp->insert([
                    'id_cs' => $this->id_cs,
                    'parent_gejala' => $parent_gejala,
                    'child_gejala' => $post['child_gejala'],
                    'answer' => $post['answer']
                ]);
            } catch (Exception $e) {
                $this->konsultasi_tmp->db->transRollback();
            }
        }

        $this->konsultasi_tmp->db->transCommit();

        // mengambil data konsultasi sementara atau temporary
        $konsul = $this->konsultasi_tmp->where([
            'id_cs' => $this->id_cs,
        ])->get();

        $nama_pegawai = $this->pegawai->getPegawai($this->id_cs, 'nama_pegawai');

        if ($post['parent_gejala'] == 0 && $post['answer'] == 1) {
            // Jika parent gejala = 0 dan jawaban tidak (1)
            $next_gejala = $post['child_gejala'] + 1;
            // tambahkan inputan child_gejala + 1 untuk memanipulasi gejala selanjutnya

            $sql_gejala = "select*from gejalas where id = " . $next_gejala . " and id not in (select child_kode_gejala from aturanbreadths)"; // query gejala dengan id sesuai variabel $next_gejala dengan kriteria record tidak ada dikolom child_kode_gejala tabel aturanbreadths

            $gejala = $this->gejala->db->query($sql_gejala)->getRow();

            if (empty($gejala)) {

                // jika gejala kosong maka tampilkan data kerusakan 
                // namun dengan kerusakan tidak ditemukan
                $data = [
                    'nama_pegawai' => $nama_pegawai,
                    'teknisi' => $teknisi,
                    'kerusakan' => NULL,
                    'konsultasi' => $this->mappingKonsultasi($konsul->getResult('array')),
                    'action' => base_url('konsultasi/savekonsultasi'),
                    'kemungkinan' => false, // tidak ada kemungkinan karena belum memilih gejala sama sekali
                    'form' => false, // tidak menampilkan form karena gk ada kerusakan
                ];

                if ($this->session->get('role_id') == 3) {
                    return view('cs/konsultasi/form_perbaikan', $data);
                }

                return view('konsultasi/form_perbaikan', $data);
            }

            // jika ada maka tampilkan data gejala selanjutnya

            $data = [
                'gejala' => $gejala,
                'parent_gejala' => 0,
                //parent gejala tetap karena belum ada perubahan parent
                'action' => base_url('konsultasi/savequestion')
            ];

            if ($this->session->get('role_id') == 3) {
                return view('cs/konsultasi/index', $data);
            }

            return view('konsultasi/index', $data);
        } else if ($post['parent_gejala'] == 0 && $post['answer'] == 0) {
            // Jika parent gejala = 0 dan jawaban ya (0)

            $sql_aturan = "select*from aturanbreadths where parent_kode_gejala = " . $post['child_gejala'] . " and child_kode_gejala not in (select child_gejala from konsultasitmps where id_cs = " . $this->id_cs . ") limit 1"; // query aturanbreadths sesuai dengan parent_kode_gejala mengambil dari child_gejala dengan kriteria child_kode_gejala tidak ada di kolom child_gejala dengan ketentuan sesuai dengan id_cs pada tabel konsultasitmps (anggap tabel konsultasitmps adalah tempat yang sudah dialalui dan tidak ada dalam kolom yang sudah dilalui oke)
            $aturan = $this->aturan_breadth->db->query($sql_aturan)->getRow();

            $sql_gejala = "select*from gejalas where id = " . $aturan->child_kode_gejala;
            // ambil nama gejala sesuai child_kode_gejala yang sudah diambil

            $gejala = $this->gejala->db->query($sql_gejala)->getRow();

            $data = [
                'gejala' => $gejala,
                'parent_gejala' => $post['child_gejala'],
                // ganti parent_gejala dengan child_gejala karena sudah ada perubahan parent_gejala
                'action' => base_url('konsultasi/savequestion')
            ];

            if ($this->session->get('role_id') == 3) {
                return view('cs/konsultasi/index', $data);
            }

            return view('konsultasi/index', $data);
        } else {
            // jika parent_gejala != 0 dan jawaban ya (0)
            if ($post['answer'] == 0) {

                // cek kerusakan dulu di aturan breadth
                $sql_cek_kerusakan = "select*from aturanbreadths where parent_kode_gejala = " . $post['parent_gejala'] . " and child_kode_gejala = " . $post['child_gejala']; // query aturanbreadths dengan kriteria parent_kode_gejala = parent_gejala dan child_kode_gejala = child_kode_gejala untuk menemukan apakah ada kerusakan contoh (parent_gejala = 1 dan child_gejala = 4)
                $cek_kerusakan = $this->aturan_breadth->db->query($sql_cek_kerusakan)->getRow();

                // jika id_kerusakan != null maka tampilkan form kerusakan
                if ($cek_kerusakan->id_kerusakan != null) {

                    $data = [
                        'nama_pegawai' => $nama_pegawai,
                        'teknisi' => $teknisi,
                        'kerusakan' => $this->mappingKerusakan($cek_kerusakan),
                        'konsultasi' => $this->mappingKonsultasi($konsul->getResult('array')),
                        'action' => base_url('konsultasi/savekonsultasi'),
                        'kemungkinan' => false, // buat ambil kemungkinan namun tidak ada kemungkinan karena sudah sesuai rule
                        'form' => true, // buat nampilin form karena ada kerusakan
                    ];

                    if ($this->session->get('role_id') == 3) {
                        return view('cs/konsultasi/form_perbaikan', $data);
                    }

                    return view('konsultasi/form_perbaikan', $data);
                }

                // jika id_kerusakan == null belum ditemukan kerusakan, 
                // maka lanjutkan untuk mencari pertanyaan berikutnya
                $sql_aturan = "select*from aturanbreadths where parent_kode_gejala = " . $post['child_gejala'] . " and child_kode_gejala not in (select child_gejala from konsultasitmps where id_cs = " . $this->id_cs . ") limit 1"; // query aturanbreadths sesuai dengan parent_kode_gejala mengambil dari child_gejala dengan kriteria child_kode_gejala tidak ada di kolom child_gejala dengan ketentuan sesuai dengan id_cs pada tabel konsultasitmps (anggap tabel konsultasitmps adalah tempat yang sudah dialalui dan tidak ada dalam kolom yang sudah dilalui oke)
                $aturan = $this->aturan_breadth->db->query($sql_aturan)->getRow();

                $sql_gejala = "select*from gejalas where id = " . $aturan->child_kode_gejala;

                $gejala = $this->gejala->db->query($sql_gejala)->getRow();

                $data = [
                    'gejala' => $gejala,
                    'parent_gejala' => $post['child_gejala'],
                    // ganti parent_gejala dengan child_gejala karena sudah ada perubahan parent_gejala
                    'action' => base_url('konsultasi/savequestion')
                ];

                if ($this->session->get('role_id') == 3) {
                    return view('cs/konsultasi/index', $data);
                }

                return view('konsultasi/index', $data);
            } else if ($post['answer'] == 1) {

                // jika parent_gejala != 0 dan jawaban tidak (1)

                $sql_aturan = "select*from aturanbreadths where parent_kode_gejala = " . $post['parent_gejala'] . " and child_kode_gejala not in (select child_gejala from konsultasitmps where id_cs = " . $this->id_cs . ") limit 1";
                // query aturanbreadths sesuai dengan parent_kode_gejala mengambil dari parent_gejala dengan kriteria child_kode_gejala tidak ada di kolom child_gejala dengan ketentuan sesuai dengan id_cs pada tabel konsultasitmps 
                //(anggap tabel konsultasitmps adalah tempat yang sudah dialalui dan tidak ada dalam kolom yang sudah dilalui oke)
                $aturan = $this->aturan->db->query($sql_aturan)->getRow();

                // jika dalam aturan tidak kosong atau ada child_kode_gejala 
                // maka tampilkan pertanyaan berikut sesuai child_kode_gejala
                if (!empty($aturan)) {
                    $sql_gejala = "select*from gejalas where id = " . $aturan->child_kode_gejala;
                    $gejala = $this->gejala->db->query($sql_gejala)->getRow();

                    $data = [
                        'gejala' => $gejala,
                        'parent_gejala' => $post['parent_gejala'],
                        'action' => base_url('konsultasi/savequestion')
                    ];

                    if ($this->session->get('role_id') == 3) {
                        return view('cs/konsultasi/index', $data);
                    }

                    return view('konsultasi/index', $data);
                } else {

                    // tampung kerusakan diambil dari parent_gejala di konsultasitmp terakhir dan dijadikan parent_kode_gejala
                    $tmp_kerusakan = [];

                    $id_cs = $this->id_cs;

                    // ambil parent_gejala terakhir di konsultasitmps
                    $query_konsultasi = "select parent_gejala from konsultasitmps where id_cs = $id_cs order by id desc limit 1";
                    $konsultasi = $this->konsultasi_tmp->db->query($query_konsultasi)->getResult('array');

                    // cek kerusakan jika tidak ada kerusakan maka tidak akan tampil kerusakan
                    foreach ($konsultasi as $key => $value) {
                        $tmp_kerusakan[] = $this->cekKerusakanTerdekat($value['parent_gejala']);
                    } 

                    $data = [
                        'nama_pegawai' => $nama_pegawai,
                        'teknisi' => $teknisi,
                        'kerusakan' => $tmp_kerusakan, // kerusakan kemungkinan
                        'konsultasi' => $this->mappingKonsultasi($konsul->getResult('array')),
                        'action' => base_url('konsultasi/savekonsultasi'),
                        'kemungkinan' => true, // buat nampilkan kemungkinan
                        'form' => true, // buat nampilkan form
                    ];

                    if ($this->session->get('role_id') == 3) {
                        return view('cs/konsultasi/form_perbaikan', $data);
                    }

                    return view('konsultasi/form_perbaikan', $data);
                }
            }
        }
    }

    public function saveKonsultasi()
    {
        $post = $this->request->getVar();

        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama_customer' => [
                'label' => 'Nama Customer',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Customer Tidak Boleh Kosong'
                ],
            ],

            'no_telepon_customer' => [
                'label' => 'Nomor Telepon Customer',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nomor Telepon Customer Tidak Boleh Kosong'
                ],
            ],

            'alamat_customer' => [
                'label' => 'Alamat Customer',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Alamat Customer Tidak Boleh Kosong'
                ],
            ],

            'nama_teknisi' => [
                'label' => 'Nama Teknisi',
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama Teknisi Tidak Boleh Kosong'
                ],
            ],
        ]);

        if ($validation->withRequest($this->request)->run()) {

            $konsultasi_tmp = $this->konsultasi_tmp->where([
                'id_cs' => $this->id_cs
            ])->get()->getResult('array');

            $this->perbaikan->db->transBegin();

            $latest_id = $this->perbaikan->select('id')->orderBy('id', 'desc')->limit(1)->get()->getRow();

            if (empty($latest_id)) {
                $id = 1;
            } else {
                $id = $latest_id->id + 1;
            }

            try {
                $this->perbaikan->insert([
                    'id' => $id,
                    'id_cs' => $this->id_cs,
                    'id_teknisi' => $post['nama_teknisi'],
                    'nama_customer' => $post['nama_customer'],
                    'alamat_customer' => $post['alamat_customer'],
                    'no_telepon_customer' => $post['no_telepon_customer'],
                    'tanggal_konsultasi' => date('Y-m-d'),
                    'tanggal_mulai_perbaikan' => date('Y-m-d'),
                    'tanggal_selesai_perbaikan' => NULL,
                    'status_perbaikan' => 0,
                ]);
            } catch (Exception $e) {
                $this->perbaikan->db->transRollback();
                return json_encode([
                    'status' => 422,
                    'messages' => [$e->getMessage()],
                ]);
            }

            $this->perbaikan->db->transCommit();

            $this->m_perbaikan->db->transBegin();

            for ($i = 0; $i < count($konsultasi_tmp); $i++) {
                try {
                    $this->m_perbaikan->insert([
                        'id_perbaikan' => $id,
                        'id_gejala' => $konsultasi_tmp[$i]['child_gejala'],
                        'answer' => $konsultasi_tmp[$i]['answer']
                    ]);
                } catch (Exception $e) {
                    $this->m_perbaikan->db->transRollback();
                    return json_encode([
                        'status' => 422,
                        'messages' => [$e->getMessage()],
                    ]);
                }
            }

            $this->m_perbaikan->db->transCommit();

            $this->detPerbaikan->db->transBegin();

            try {
                if (is_array($post['id_kerusakan'])) {
                    foreach ($post['id_kerusakan'] as $value) {
                        $this->detPerbaikan->insert([
                            'id_perbaikan' => $id,
                            'id_kerusakan' => $value
                        ]);
                    }
                } else {
                    $this->detPerbaikan->insert([
                        'id_perbaikan' => $id,
                        'id_kerusakan' => $post['id_kerusakan']
                    ]);
                }
            } catch (Exception $e) {
                $this->detPerbaikan->db->transRollback();
                return json_encode([
                    'status' => 422,
                    'messages' => [$e->getMessage()],
                ]);
            }

            $this->detPerbaikan->db->transCommit();

            return json_encode([
                'status' => 200,
                'messages' => ['Perbaikan Sukses Ditambahkan'],
                'url' => base_url('perbaikan'),
            ]);

        } else {
            return json_encode([
                'status' => 422,
                'messages' => $validation->getErrors(),
            ]);
        }
    }
}
