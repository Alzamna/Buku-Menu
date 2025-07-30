<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // Insert Super Admin
        $this->db->table('users')->insert([
            'username' => 'superadmin',
            'password' => password_hash('superadmin123', PASSWORD_DEFAULT),
            'role' => 'super_admin',
            'restoran_id' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Insert sample restaurant
        $this->db->table('restoran')->insert([
            'nama' => 'Restoran Sample',
            'alamat' => 'Jl. Sample No. 123, Jakarta',
            'kontak' => '08123456789',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        $restoranId = $this->db->insertID();

        // Insert Admin Restoran
        $this->db->table('users')->insert([
            'username' => 'admin',
            'password' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin_restoran',
            'restoran_id' => $restoranId,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        // Insert default categories
        $kategoriDefault = ['Makanan', 'Minuman'];
        
        foreach ($kategoriDefault as $kategori) {
            $this->db->table('kategori')->insert([
                'nama' => $kategori,
                'restoran_id' => $restoranId,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }

        // Insert sample menu items
        $kategoriMakanan = $this->db->table('kategori')->where('nama', 'Makanan')->get()->getRow()->id;
        $kategoriMinuman = $this->db->table('kategori')->where('nama', 'Minuman')->get()->getRow()->id;

        $menuItems = [
            [
                'nama' => 'Nasi Goreng',
                'harga' => 25000,
                'kategori_id' => $kategoriMakanan,
                'deskripsi' => 'Nasi goreng dengan telur, ayam, dan sayuran',
                'stok' => 50,
            ],
            [
                'nama' => 'Mie Goreng',
                'harga' => 22000,
                'kategori_id' => $kategoriMakanan,
                'deskripsi' => 'Mie goreng dengan telur dan sayuran',
                'stok' => 40,
            ],
            [
                'nama' => 'Es Teh Manis',
                'harga' => 5000,
                'kategori_id' => $kategoriMinuman,
                'deskripsi' => 'Es teh manis segar',
                'stok' => 100,
            ],
            [
                'nama' => 'Es Jeruk',
                'harga' => 8000,
                'kategori_id' => $kategoriMinuman,
                'deskripsi' => 'Es jeruk peras segar',
                'stok' => 80,
            ],
        ];

        foreach ($menuItems as $menu) {
            $this->db->table('menu')->insert([
                'nama' => $menu['nama'],
                'harga' => $menu['harga'],
                'kategori_id' => $menu['kategori_id'],
                'deskripsi' => $menu['deskripsi'],
                'stok' => $menu['stok'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}