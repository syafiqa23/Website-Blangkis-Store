<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Libraries\Dompdf;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        $this->cart->insert(array(
            'id'        => $this->request->getPost('id'),
            'qty'       => 1,
            'price'     => $this->request->getPost('harga'),
            'name'      => $this->request->getPost('nama'),
            'options'   => array('foto' => $this->request->getPost('foto'))
        ));
        session()->setflashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');
        return redirect()->to(base_url('/'));
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }
    public function checkout()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        return view('v_checkout', $data);
    }
    public function getLocation()
    {
        //keyword pencarian yang dikirimkan dari halaman checkout
        $search = $this->request->getGet('search');

        $response = $this->client->request(
            'GET',
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . $search . '&limit=50',
            [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }

    public function getCost()
    {
        //ID lokasi yang dikirimkan dari halaman checkout
        $destination = $this->request->getGet('destination');

        //parameter daerah asal pengiriman, berat produk, dan kurir dibuat statis
        //valuenya => 64999 : PEDURUNGAN TENGAH , 1000 gram, dan JNE
        $response = $this->client->request(
            'POST',
            'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
            [
                'multipart' => [
                    [
                        'name' => 'origin',
                        'contents' => '64999'
                    ],
                    [
                        'name' => 'destination',
                        'contents' => $destination
                    ],
                    [
                        'name' => 'weight',
                        'contents' => '1000'
                    ],
                    [
                        'name' => 'courier',
                        'contents' => 'jne'
                    ]
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data']);
    }public function buy()
{
    if ($this->request->getPost()) {
        $buktiPath = null;

        // Log semua input POST
        log_message('info', 'POST Request: ' . json_encode($this->request->getPost()));

        // Handle upload bukti pembayaran
        $file = $this->request->getFile('bukti_pembayaran');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            if ($file->move('uploads/bukti/', $namaFile)) {
                $buktiPath = 'uploads/bukti/' . $namaFile;
                log_message('info', 'Bukti pembayaran berhasil diupload: ' . $buktiPath);
            } else {
                log_message('error', 'File gagal dipindahkan.');
            }
        } else {
            if ($file) {
                log_message('error', 'File tidak valid: ' . $file->getErrorString());
            } else {
                log_message('error', 'File tidak ditemukan dalam request.');
            }
        }

        // Tetapkan nilai default jika kosong
        $totalHarga = $this->request->getPost('total_harga') ?: 0;
        $ongkir = $this->request->getPost('ongkir') ?: 0;

        $dataForm = [
            'username' => $this->request->getPost('username'),
            'total_harga' => $totalHarga,
            'alamat' => $this->request->getPost('alamat'),
            'kelurahan' => $this->request->getPost('kelurahan'),
            'kelurahan_nama' => $this->request->getPost('nama_kelurahan'),
            'ongkir' => $ongkir,
            'status' => 0,
            'status_bayar' => $buktiPath ? 'menunggu konfirmasi' : 'belum',
            'bukti_pembayaran' => $buktiPath,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];

        log_message('info', 'Data yang akan diinsert: ' . json_encode($dataForm));

        // Simpan transaksi
        if (!$this->transaction->insert($dataForm)) {
            log_message('error', 'Insert transaksi gagal: ' . json_encode($this->transaction->errors()));
            return redirect()->back()->with('failed', 'Gagal membuat pesanan. Silakan coba lagi.');
        }

        $lastId = $this->transaction->getInsertID();

        // Simpan detail keranjang
        foreach ($this->cart->contents() as $item) {
            $this->transaction_detail->insert([
                'transaction_id' => $lastId,
                'product_id' => $item['id'],
                'jumlah' => $item['qty'],
                'diskon' => 0,
                'subtotal_harga' => $item['qty'] * $item['price'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ]);
        }

        $this->cart->destroy();

        return redirect()->to('invoice/' . $lastId)->with('success', 'Pesanan berhasil dibuat.');
    }

    return redirect()->back()->with('failed', 'Data tidak valid.');
}


    public function invoice($id)
    {
        $transaction = $this->transaction->find($id);

        if (!$transaction) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Invoice tidak ditemukan.');
        }

        $details = $this->transaction_detail
            ->select('transaction_detail.*, product.nama, product.harga, product.foto, product.deskripsi') // ← tambahkan deskripsi
            ->join('product', 'product.id = transaction_detail.product_id')
            ->where('transaction_id', $id)
            ->findAll();


        return view('v_invoice', [
            'transaction' => $transaction, // ini disamakan
            'details' => $details
        ]);
        $dompdf = new Dompdf();
        $html = view('v_invoice', $data); // view invoice
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('invoice_' . $id . '.pdf', false); // false = preview di browser
    }



    public function invoiceRedirect()
    {
        $id = $this->request->getGet('id');
        if ($id && is_numeric($id)) {
            return redirect()->to(base_url('invoice/' . $id));
        }
        return redirect()->back()->with('failed', 'ID Transaksi tidak valid.');
    }

    public function uploadBuktiPembayaran($id)
    {
        $transaction = $this->transaction->find($id);
        if (!$transaction) {
            return redirect()->back()->with('failed', 'Transaksi tidak ditemukan');
        }

        $file = $this->request->getFile('bukti_pembayaran');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads/bukti/', $namaFile);

            $this->transaction->update($id, [
                'bukti_pembayaran' => 'uploads/bukti/' . $namaFile,
                'status_bayar' => 'menunggu konfirmasi'
            ]);

            return redirect()->to(base_url('invoice/' . $id))->with('success', 'Bukti pembayaran sudah terupload.');
        }

        return redirect()->back()->with('failed', 'Gagal mengunggah file.');
    }
}
