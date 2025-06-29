<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class KonsumenController extends BaseController
{
    public function index()
    {
        $model = new UserModel();
        $data['konsumen'] = $model->where('role', 'guest')->orderBy('created_at', 'DESC')->findAll();

        return view('admin/v_konsumen', $data);
    }
}
