<?php

namespace App\Models;

use CodeIgniter\Model;

class KonsultasiTmp extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'konsultasitmps';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_cs',
        'parent_gejala',
        'child_gejala',
        'answer',
    ];
}
