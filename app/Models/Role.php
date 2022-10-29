<?php

namespace App\Models;

use CodeIgniter\Model;

class Role extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'roles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields    = ['nama_role'];

    public function getRoleName($id)
    {
        $role = $this->where([
            'id' => $id
        ])->first();
        return $role['nama_role'];
    }

    public function getAllRole()
    {
        $sql_role = "select*from roles where id != 1";
        return $this->db->query($sql_role)->getResult('array');
    }
}
