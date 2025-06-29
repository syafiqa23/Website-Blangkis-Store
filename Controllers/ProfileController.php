<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class ProfileController extends BaseController
{
    protected $transaction;
    protected $transactionDetail;

    public function __construct()
    {
        $this->transaction = new TransactionModel();
        $this->transactionDetail = new TransactionDetailModel();
    }

    public function index()
    {
        helper('number');

        $username = session()->get('username');

        $buy = $this->transaction
            ->where('username', $username)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Ambil detail produk per transaksi
        $product = [];
        foreach ($buy as $row) {
            $product[$row['id']] = $this->transactionDetail
                ->select('transaction_detail.*, product.nama, product.harga, product.foto, product.deskripsi')
                ->join('product', 'product.id = transaction_detail.product_id')
                ->where('transaction_id', $row['id'])
                ->findAll();
        }

        return view('v_profile', [
            'buy' => $buy,
            'product' => $product,
            'username' => $username,
            'transactions' => $buy // ini penting untuk bagian cetak invoice!
        ]);
    }
    public function konfirmasiDiterima($id)
{
    $username = session()->get('username');

    // Pastikan user hanya bisa update transaksi miliknya
    $transaksi = $this->transaction->where('id', $id)->where('username', $username)->first();

    if (!$transaksi) {
        return redirect()->back()->with('failed', 'Transaksi tidak ditemukan.');
    }

    $this->transaction->update($id, ['status_kirim' => 'diterima', 'updated_at' => date('Y-m-d H:i:s')]);

    return redirect()->back()->with('success', 'Status pengiriman telah dikonfirmasi.');
}

}
