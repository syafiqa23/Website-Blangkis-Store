<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KategoriModel;
use App\Models\ProductModel;

class KategoriController extends BaseController
{
    protected $kategori;
    protected $produk;

    public function __construct()
    {
        $this->kategori = new KategoriModel();
        $this->produk = new ProductModel();
    }

    // Tampilkan data kategori
    public function index()
    {
        $kategori = $this->kategori->findAll();

        return view('admin/v_kategori', [
            'kategori' => $kategori
        ]);
    }

    // Tambah kategori
    public function create()
    {
        $data = $this->request->getPost();

        if ($this->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
        ])) {
            $this->kategori->save([
                'nama_kategori' => $data['nama_kategori'],
                'deskripsi'     => $data['deskripsi'],
            ]);

            return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('failed', 'Data tidak lengkap.');
        }
    }

    // Edit kategori
    public function edit($id)
    {
        $data = $this->request->getPost();

        if ($this->validate([
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
        ])) {
            $this->kategori->update($id, [
                'nama_kategori' => $data['nama_kategori'],
                'deskripsi'     => $data['deskripsi'],
            ]);

            return redirect()->back()->with('success', 'Kategori berhasil diubah.');
        } else {
            return redirect()->back()->with('failed', 'Data tidak lengkap.');
        }
    }

    // Hapus kategori
    public function delete($id)
    {
        $this->kategori->delete($id);
        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
