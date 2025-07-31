<?php

// Setup script untuk menambahkan UUID ke database
require_once 'vendor/autoload.php';

// Load CodeIgniter
$app = require_once 'app/Config/Paths.php';
$paths = new \Config\Paths();
$bootstrap = rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
$app = require_once $bootstrap;

// Load database
$db = \Config\Database::connect();

// Load UUID helper
require_once 'app/Helpers/UuidHelper.php';

echo "Menambahkan UUID ke database...\n";

// Add UUID columns to restoran table
try {
    $db->query("ALTER TABLE restoran ADD COLUMN uuid VARCHAR(36) NULL AFTER id");
    echo "✓ Kolom uuid ditambahkan ke tabel restoran\n";
} catch (Exception $e) {
    echo "⚠ Kolom uuid sudah ada di tabel restoran\n";
}

// Add UUID columns to meja table
try {
    $db->query("ALTER TABLE meja ADD COLUMN uuid VARCHAR(36) NULL AFTER id");
    echo "✓ Kolom uuid ditambahkan ke tabel meja\n";
} catch (Exception $e) {
    echo "⚠ Kolom uuid sudah ada di tabel meja\n";
}

// Add unique indexes
try {
    $db->query("ALTER TABLE restoran ADD UNIQUE INDEX idx_restoran_uuid (uuid)");
    echo "✓ Index uuid ditambahkan ke tabel restoran\n";
} catch (Exception $e) {
    echo "⚠ Index uuid sudah ada di tabel restoran\n";
}

try {
    $db->query("ALTER TABLE meja ADD UNIQUE INDEX idx_meja_uuid (uuid)");
    echo "✓ Index uuid ditambahkan ke tabel meja\n";
} catch (Exception $e) {
    echo "⚠ Index uuid sudah ada di tabel meja\n";
}

// Update existing restoran records with UUIDs
$restoranModel = new \App\Models\RestoranModel();
$restoranList = $restoranModel->findAll();

foreach ($restoranList as $restoran) {
    if (empty($restoran['uuid'])) {
        $restoranModel->update($restoran['id'], [
            'uuid' => generate_secure_uuid()
        ]);
        echo "✓ UUID ditambahkan ke restoran: {$restoran['nama']}\n";
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
        echo "✓ UUID ditambahkan ke meja: {$meja['nomor_meja']}\n";
    }
}

echo "\n✅ Setup UUID selesai!\n";
echo "Sekarang URL menu menggunakan UUID untuk keamanan.\n";
echo "Contoh URL baru: /customer/menu/{uuid}/meja/{uuid}\n"; 