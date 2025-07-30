<?php

// Simple test untuk kategori
echo "Testing kategori functionality...\n";

// Load CodeIgniter
require_once 'vendor/autoload.php';

// Initialize CodeIgniter
$app = \Config\Services::codeigniter();
$app->initialize();

try {
    // Test database connection
    $db = \Config\Database::connect();
    echo "✓ Database connection successful\n";
    
    // Check if kategori table exists
    if ($db->tableExists('kategori')) {
        echo "✓ Kategori table exists\n";
        
        // Check if restoran table exists and has data
        if ($db->tableExists('restoran')) {
            $restoran = $db->table('restoran')->get()->getRow();
            if ($restoran) {
                echo "✓ Restoran found: " . $restoran->nama . " (ID: " . $restoran->id . ")\n";
                
                // Test insert kategori
                $testData = [
                    'nama' => 'Test Kategori ' . date('Y-m-d H:i:s'),
                    'restoran_id' => $restoran->id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                echo "Testing insert with data: " . json_encode($testData) . "\n";
                
                $result = $db->table('kategori')->insert($testData);
                
                if ($result) {
                    $insertId = $db->insertID();
                    echo "✓ Insert successful. ID: " . $insertId . "\n";
                    
                    // Verify the insert
                    $inserted = $db->table('kategori')->where('id', $insertId)->get()->getRow();
                    if ($inserted) {
                        echo "✓ Data verified in database\n";
                        
                        // Clean up test data
                        $db->table('kategori')->delete(['id' => $insertId]);
                        echo "✓ Test data cleaned up\n";
                    } else {
                        echo "✗ Data not found after insert!\n";
                    }
                } else {
                    echo "✗ Insert failed\n";
                    echo "DB Error: " . json_encode($db->error()) . "\n";
                }
            } else {
                echo "✗ No restoran data found\n";
            }
        } else {
            echo "✗ Restoran table does not exist\n";
        }
    } else {
        echo "✗ Kategori table does not exist\n";
    }
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\nTest completed.\n"; 