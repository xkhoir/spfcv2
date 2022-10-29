<?php

namespace App\Models;

use CodeIgniter\Model;

class DetPerbaikan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'detperbaikans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = [
        'id_perbaikan',
        'id_kerusakan'
    ];
}
