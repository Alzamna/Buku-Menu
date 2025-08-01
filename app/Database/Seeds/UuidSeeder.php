<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UuidSeeder extends Seeder
{
    public function run()
    {
        // Load the UUID helper
        helper('uuid');

        // Update existing restoran records with UUIDs
        $restoranModel = new \App\Models\RestoranModel();
        $restoranList = $restoranModel->findAll();
        
        foreach ($restoranList as $restoran) {
            if (empty($restoran['uuid'])) {
                $restoranModel->update($restoran['id'], [
                    'uuid' => generate_secure_uuid()
                ]);
            }
        }

        // Update existing meja records with UUIDs
        $mejaModel = new \App\Models\MejaModel();
        $mejaList = $mejaModel->findAll();
        
        foreach ($mejaList as $meja) {
            if (empty($meja['uuid'])) {
                $mejaModel->update($meja['id'], [
                    'uuid' => generate_secure_uuid()
                ]);
            }
        }

        echo "UUIDs have been added to existing data.\n";
    }
} 