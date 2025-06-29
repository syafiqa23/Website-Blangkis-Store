<?php 
namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
	protected $table = 'product'; 
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'nama','deskripsi','harga','jumlah','foto','kategori_id','created_at','updated_at'
	];  
	public function getWithCategory()
    {
        return $this->select('product.*, kategori.nama_kategori, kategori.deskripsi as deskripsi_kategori')
                    ->join('kategori', 'kategori.id = product.kategori_id', 'left')
                    ->findAll();
    }
}