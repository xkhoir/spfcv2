<?php

namespace App\Models;

use CodeIgniter\Model;

class Mperbaikan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'mperbaikans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_perbaikan',
        'id_gejala',
        'answer',
    ];
}
