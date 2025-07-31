<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCustomerInfoToPesanan extends Migration
{
    public function up()
    {
        $this->forge->addColumn('pesanan', [
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
                'after' => 'restoran_id',
            ],
            'nomor_hp' => [
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => true,
                'after' => 'nama',
            ],
            'nomor_meja' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
                'after' => 'nomor_hp',
            ],
            'catatan_pesanan' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'nomor_meja',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('pesanan', ['nama', 'nomor_hp', 'nomor_meja', 'catatan_pesanan']);
    }
} 