<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;

class SearchController extends BaseController
{
    public function index()
    {
        helper(['form', 'text']);

        $query = $this->request->getPost('query');
        $model = new ProductModel();

        $results = $model->like('nama', $query)
                         ->orLike('deskripsi', $query)
                         ->findAll();

        return view('v_search_result', [
            'query' => $query,
            'results' => $results
        ]);
    }
}
