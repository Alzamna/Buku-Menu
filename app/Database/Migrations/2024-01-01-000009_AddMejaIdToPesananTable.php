<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMejaIdToPesananTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pesanan', [
            'meja_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => true,
                'after' => 'restoran_id',
            ],
        ]);
        
        $this->forge->addForeignKey('meja_id', 'meja', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropForeignKey('pesanan', 'pesanan_meja_id_foreign');
        $this->forge->dropColumn('pesanan', 'meja_id');
    }
} 