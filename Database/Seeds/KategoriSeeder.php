<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        $data = [
            [
                'nama_kategori' => 'Blangkon Jawa Timur',
                'deskripsi'     => 'Blangkon khas daerah Jawa Timur dengan corak budaya arek dan tapal kuda.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'nama_kategori' => 'Blangkon Jawa Tengah',
                'deskripsi'     => 'Blangkon tradisional dari Jawa Tengah, mencerminkan budaya keraton Yogyakarta dan Solo.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'nama_kategori' => 'Blangkon Jawa Barat',
                'deskripsi'     => 'Blangkon dari Jawa Barat dengan pengaruh budaya Sunda, khas dengan warna dan bentuknya.',
                'created_at'    => $now,
                'updated_at'    => $now,
            ]
        ];

        $this->db->table('kategori')->insertBatch($data);
    }
}
