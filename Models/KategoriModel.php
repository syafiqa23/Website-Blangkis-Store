<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kategori','deskripsi', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
