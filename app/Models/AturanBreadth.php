<?php

namespace App\Models;

use CodeIgniter\Model;

class AturanBreadth extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'aturanbreadths';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_aturan',
        'parent_kode_gejala',
        'child_kode_gejala',
        'id_kerusakan'
    ];
}
