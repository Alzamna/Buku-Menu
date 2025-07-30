<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeys extends Migration
{
    public function up()
    {
        // Add foreign key for users table
        $this->db->query('ALTER TABLE users ADD CONSTRAINT fk_users_restoran FOREIGN KEY (restoran_id) REFERENCES restoran(id) ON DELETE CASCADE ON UPDATE CASCADE');
        
        // Add foreign key for kategori table
        $this->db->query('ALTER TABLE kategori ADD CONSTRAINT fk_kategori_restoran FOREIGN KEY (restoran_id) REFERENCES restoran(id) ON DELETE CASCADE ON UPDATE CASCADE');
        
        // Add foreign key for menu table
        $this->db->query('ALTER TABLE menu ADD CONSTRAINT fk_menu_kategori FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE CASCADE ON UPDATE CASCADE');
        
        // Add foreign key for pesanan table
        $this->db->query('ALTER TABLE pesanan ADD CONSTRAINT fk_pesanan_restoran FOREIGN KEY (restoran_id) REFERENCES restoran(id) ON DELETE CASCADE ON UPDATE CASCADE');
        
        // Add foreign key for pesanan_detail table
        $this->db->query('ALTER TABLE pesanan_detail ADD CONSTRAINT fk_pesanan_detail_pesanan FOREIGN KEY (pesanan_id) REFERENCES pesanan(id) ON DELETE CASCADE ON UPDATE CASCADE');
        $this->db->query('ALTER TABLE pesanan_detail ADD CONSTRAINT fk_pesanan_detail_menu FOREIGN KEY (menu_id) REFERENCES menu(id) ON DELETE CASCADE ON UPDATE CASCADE');
    }

    public function down()
    {
        // Drop foreign keys
        $this->db->query('ALTER TABLE users DROP FOREIGN KEY fk_users_restoran');
        $this->db->query('ALTER TABLE kategori DROP FOREIGN KEY fk_kategori_restoran');
        $this->db->query('ALTER TABLE menu DROP FOREIGN KEY fk_menu_kategori');
        $this->db->query('ALTER TABLE pesanan DROP FOREIGN KEY fk_pesanan_restoran');
        $this->db->query('ALTER TABLE pesanan_detail DROP FOREIGN KEY fk_pesanan_detail_pesanan');
        $this->db->query('ALTER TABLE pesanan_detail DROP FOREIGN KEY fk_pesanan_detail_menu');
    }
} 