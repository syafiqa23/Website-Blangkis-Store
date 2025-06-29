<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\KategoriModel;

class ProdukController extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->produkModel = new ProductModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $produk = $this->produkModel->findAll();
        return view('admin/v_produk', ['product' => $produk]);
    }

    public function create()
    {
        $foto = $this->request->getFile('foto');
        $namaFoto = '';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move('NiceAdmin/assets/img/', $namaFoto);
        }

        $this->produkModel->save([
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'foto' => $namaFoto
        ]);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $dataLama = $this->produkModel->find($id);
        $namaFoto = $dataLama['foto'];

        if ($this->request->getPost('check')) {
            $foto = $this->request->getFile('foto');

            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                // Hapus foto lama
                if ($namaFoto && file_exists("NiceAdmin/assets/img/" . $namaFoto)) {
                    unlink("NiceAdmin/assets/img/" . $namaFoto);
                }

                $namaFoto = $foto->getRandomName();
                $foto->move('NiceAdmin/assets/img/', $namaFoto);
            }
        }

        $this->produkModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'foto' => $namaFoto
        ]);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $data = $this->produkModel->find($id);

        if ($data && $data['foto'] && file_exists('NiceAdmin/assets/img/' . $data['foto'])) {
            unlink('NiceAdmin/assets/img/' . $data['foto']);
        }

        $this->produkModel->delete($id);
        return redirect()->to(base_url('admin/produk'))->with('success', 'Data berhasil dihapus');
    }

    public function download()
    {
        // export ke excel/pdf bisa ditambahkan di sini
        return redirect()->to(base_url('admin/produk'))->with('success', 'Fitur download belum diimplementasi');
    }
}
