<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use CodeIgniter\HTTP\ResponseInterface;

class CheckoutController extends BaseController
{
    public function buy()
    {
        $session = session();

        // Validasi form
        if (!$this->validate([
            'alamat' => 'required',
            'kelurahan' => 'required',
            'layanan' => 'required',
           'bukti_pembayaran' => 'uploaded[bukti_pembayaran]|ext_in[bukti_pembayaran,jpg,jpeg,png,pdf]'

        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Upload file bukti pembayaran
        $file = $this->request->getFile('bukti_pembayaran');
        $fileName = $file->getRandomName();

        if ($file->isValid() && !$file->hasMoved()) {
            $file->move('uploads/bukti', $fileName);
        }

        // Simpan transaksi
        $transactionModel = new TransactionModel();
        $transactionId = $transactionModel->insert([
            'username'          => $session->get('username'),
            'alamat'            => $this->request->getPost('alamat'),
            'kelurahan'         => $this->request->getPost('nama_kelurahan'),
            'layanan'           => $this->request->getPost('layanan'),
            'ongkir'            => $this->request->getPost('ongkir'),
            'total_harga'       => $this->request->getPost('total_harga'),
            'status_bayar'      => 'pending',
            'bukti_pembayaran'  => 'uploads/bukti/' . $fileName,
            'created_at'        => date('Y-m-d H:i:s')
        ]);

        // Simpan detail transaksi
        $cart = \Config\Services::cart();
        $items = $cart->contents();

        $detailModel = new TransactionDetailModel();

        foreach ($items as $item) {
            $detailModel->insert([
                'transaction_id' => $transactionId,
                'product_id'     => $item['id'],
                'jumlah'         => $item['qty'],
                'harga'          => $item['price']
            ]);
        }

        // Kosongkan keranjang setelah checkout
        $cart->destroy();

        return redirect()->to('/checkout/success');
    }

    public function success()
    {
        return view('success_checkout');
    }
}
