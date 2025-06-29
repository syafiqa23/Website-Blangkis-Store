<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TransactionModel;

class OrderController extends BaseController
{
    public function index()
    {
        helper('number');

        $model = new TransactionModel();
        $data['orders'] = $model->orderBy('created_at', 'DESC')->findAll();

        return view('admin/v_order', $data);
    }

    public function konfirmasiBayar($id)
    {
        $model = new TransactionModel();
        $model->update($id, ['status_bayar' => 'lunas']);

        // Cek apakah sudah dikirim, jika ya maka status = 2 (selesai)
        $order = $model->find($id);
        if ($order['status_kirim'] === 'sampai') {
            $model->update($id, ['status' => 2]); // Selesai
        } else {
            $model->update($id, ['status' => 0]); // Diproses
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }

    public function konfirmasiKirim($id)
    {
        $model = new TransactionModel();
        $model->update($id, ['status_kirim' => 'sampai']);

        // Cek apakah sudah dibayar, jika ya maka status = 2 (selesai)
        $order = $model->find($id);
        if ($order['status_bayar'] === 'lunas') {
            $model->update($id, ['status' => 2]); // Selesai
        } else {
            $model->update($id, ['status' => 1]); // Dikirim tapi belum lunas
        }

        return redirect()->back()->with('success', 'Status kirim diperbarui.');
    }
}
