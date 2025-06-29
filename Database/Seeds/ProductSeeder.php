<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // membuat data dengan kategori_id dan deskripsi
        $data = [
            [
                'kategori_id' => 1,
                'nama'        => 'ASUS TUF A15 FA506NF',
                'deskripsi'   => 'Laptop gaming bertenaga dengan prosesor AMD Ryzen dan grafis RTX, cocok untuk bermain game dan produktivitas berat.',
                'harga'       => 10899000,
                'jumlah'      => 5,
                'foto'        => 'asus_tuf_a15.jpg',
                'created_at'  => date("Y-m-d H:i:s"),
            ],
            [
                'kategori_id' => 2,
                'nama'        => 'Asus Vivobook 14 A1404ZA',
                'deskripsi'   => 'Laptop harian dengan performa andal, desain tipis dan ringan, cocok untuk pelajar dan pekerja kantoran.',
                'harga'       => 6899000,
                'jumlah'      => 7,
                'foto'        => 'asus_vivobook_14.jpg',
                'created_at'  => date("Y-m-d H:i:s"),
            ],
            [
                'kategori_id' => 2,
                'nama'        => 'Lenovo IdeaPad Slim 3-14IAU7',
                'deskripsi'   => 'Laptop serbaguna dengan desain slim dan prosesor Intel generasi terbaru, ideal untuk pekerjaan ringan hingga menengah.',
                'harga'       => 6299000,
                'jumlah'      => 5,
                'foto'        => 'lenovo_idepad_slim_3.jpg',
                'created_at'  => date("Y-m-d H:i:s"),
            ]
        ];

        // insert ke tabel
        foreach ($data as $item) {
            $this->db->table('product')->insert($item);
        }
    }
}
