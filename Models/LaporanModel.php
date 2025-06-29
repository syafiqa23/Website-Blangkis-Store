<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'transaction';
    protected $primaryKey = 'id';

    protected $allowedFields = ['username', 'alamat', 'created_at', 'status', 'total_harga', 'ongkir'];

    public function getLaporanGlobal()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getLaporanPeriodik($awal, $akhir)
    {
        return $this->where('created_at >=', $awal)
                    ->where('created_at <=', $akhir)
                    ->orderBy('created_at', 'DESC')
                    ->findAll();
    }

    public function getPendapatan($awal, $akhir)
    {
        return $this->select('SUM(total_harga) as total, SUM(ongkir) as total_ongkir')
                    ->where('status', 1)
                    ->where('created_at >=', $awal)
                    ->where('created_at <=', $akhir)
                    ->first();
    }
}