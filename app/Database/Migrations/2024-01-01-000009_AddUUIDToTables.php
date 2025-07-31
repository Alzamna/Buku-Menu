<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUUIDToTables extends Migration
{
    public function up()
    {
        // Add UUID to restoran table
        $this->forge->addColumn('restoran', [
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false,
                'after' => 'id',
            ],
        ]);

        // Add UUID to meja table
        $this->forge->addColumn('meja', [
            'uuid' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false,
                'after' => 'id',
            ],
        ]);

        // Add unique indexes for UUIDs
        $this->db->query('ALTER TABLE restoran ADD UNIQUE INDEX idx_restoran_uuid (uuid)');
        $this->db->query('ALTER TABLE meja ADD UNIQUE INDEX idx_meja_uuid (uuid)');
    }

    public function down()
    {
        // Remove indexes
        $this->db->query('ALTER TABLE restoran DROP INDEX idx_restoran_uuid');
        $this->db->query('ALTER TABLE meja DROP INDEX idx_meja_uuid');

        // Remove UUID columns
        $this->forge->dropColumn('restoran', 'uuid');
        $this->forge->dropColumn('meja', 'uuid');
    }
} 