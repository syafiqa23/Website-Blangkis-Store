<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class LaporanPendapatanController extends BaseController
{
    public function index()
    {
        return view('admin/v_laporan_pendapatan', [
            'data' => [],
            'awal' => '',
            'akhir' => '',
            'pendapatan' => 0,
            'laba' => 0 
        ]);
    }

    public function filter()
    {
        $awal = $this->request->getPost('awal');
        $akhir = $this->request->getPost('akhir');

        $transactionModel = new TransactionModel();
        $detailModel = new \App\Models\TransactionDetailModel();

        $transaksi = $transactionModel->where('status_bayar', 'lunas')
            ->where('created_at >=', $awal)
            ->where('created_at <=', $akhir)
            ->findAll();

        $pendapatan = array_sum(array_column($transaksi, 'total_harga'));

        // Hitung laba
        $laba = 0;
        foreach ($transaksi as $trx) {
            $details = $detailModel
                ->select('transaction_detail.*, product.harga, product.modal')
                ->join('product', 'product.id = transaction_detail.product_id')
                ->where('transaction_id', $trx['id'])
                ->findAll();

            foreach ($details as $detail) {
                $laba += ($detail['harga'] - $detail['modal']) * $detail['jumlah'];
            }
        }

        return view('admin/v_laporan_pendapatan', [
            'transaksi' => $transaksi,
            'data' => $transaksi,
            'awal' => $awal,
            'akhir' => $akhir,
            'pendapatan' => $pendapatan,
            'laba' => $laba, // <- ini penting!
        ]);
    }
}
