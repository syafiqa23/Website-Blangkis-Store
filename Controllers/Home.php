<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class Home extends BaseController
{
    protected $product;
    protected $transaction;
    protected $transaction_detail;
    function __construct()
    {
        helper('form');
        helper('number');
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }
    public function index(): string
    {
        //if (!session()->get('isLoggedIn')) {
        //  return redirect()->to('login');
        //}
        $product = $this->product->getWithCategory();
        $data['product'] = $product;
        return view('v_home', $data);
    }
    public function profile()
    {
        $username = session()->get('username');
        $data['username'] = $username;

        $buy = $this->transaction->where('username', $username)->findAll();
        $data['buy'] = $buy;

        $product = [];

        if (!empty($buy)) {
            foreach ($buy as $item) {
                $detail = $this->transaction_detail->select('transaction_detail.*, product.nama, product.harga, product.foto')->join('product', 'transaction_detail.product_id=product.id')->where('transaction_id', $item['id'])->findAll();

                if (!empty($detail)) {
                    $product[$item['id']] = $detail;
                }
            }
        }

        $data['product'] = $product;

        return view('v_profile', $data);
    }
    public function search()
    {
        $query = $this->request->getPost('query');
        // Lakukan pencarian, misal ke tabel product
        $productModel = new \App\Models\ProductModel();
        $results = $productModel
            ->like('nama', $query)
            ->orLike('deskripsi', $query)
            ->findAll();

        return view('v_search_result', ['results' => $results, 'query' => $query]);
    }
}
