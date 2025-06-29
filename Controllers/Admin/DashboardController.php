<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\TransactionModel;

class DashboardController extends BaseController
{
    public function index()
{
    helper('number');

    $produkModel = new ProductModel();
    $userModel = new UserModel();
    $transaksiModel = new TransactionModel();

    // Ambil pendapatan
    $row = $transaksiModel
        ->where('status', 'lunas')
        ->selectSum('total_harga')
        ->get()
        ->getRow();

    $total_pendapatan = $row->total_harga ?? 0;

    return view('admin/v_dashboard', [
        'total_produk' => $produkModel->countAll(),
        'total_konsumen' => $userModel->where('role', 'guest')->countAllResults(),
        'total_transaksi' => $transaksiModel->countAll(),
        'total_pendapatan' => $total_pendapatan
    ]);
}

}
