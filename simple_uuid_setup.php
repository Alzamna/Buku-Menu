<?php

// Simple UUID setup script - no CodeIgniter dependencies
$host = 'localhost';
$dbname = 'buku_menu';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Menambahkan UUID ke database...\n";
    
    // Add UUID columns
    try {
        $pdo->exec("ALTER TABLE restoran ADD COLUMN uuid VARCHAR(36) NULL AFTER id");
        echo "✓ Kolom uuid ditambahkan ke tabel restoran\n";
    } catch (PDOException $e) {
        echo "⚠ Kolom uuid sudah ada di tabel restoran\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE meja ADD COLUMN uuid VARCHAR(36) NULL AFTER id");
        echo "✓ Kolom uuid ditambahkan ke tabel meja\n";
    } catch (PDOException $e) {
        echo "⚠ Kolom uuid sudah ada di tabel meja\n";
    }
    
    // Add indexes
    try {
        $pdo->exec("ALTER TABLE restoran ADD UNIQUE INDEX idx_restoran_uuid (uuid)");
        echo "✓ Index uuid ditambahkan ke tabel restoran\n";
    } catch (PDOException $e) {
        echo "⚠ Index uuid sudah ada di tabel restoran\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE meja ADD UNIQUE INDEX idx_meja_uuid (uuid)");
        echo "✓ Index uuid ditambahkan ke tabel meja\n";
    } catch (PDOException $e) {
        echo "⚠ Index uuid sudah ada di tabel meja\n";
    }
    
    // Generate UUIDs for existing data
    $stmt = $pdo->query("SELECT id FROM restoran WHERE uuid IS NULL");
    $restoranList = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($restoranList as $id) {
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
        
        $stmt = $pdo->prepare("UPDATE restoran SET uuid = ? WHERE id = ?");
        $stmt->execute([$uuid, $id]);
        echo "✓ UUID ditambahkan ke restoran ID: $id\n";
    }
    
    $stmt = $pdo->query("SELECT id FROM meja WHERE uuid IS NULL");
    $mejaList = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    foreach ($mejaList as $id) {
        $uuid = sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
        
        $stmt = $pdo->prepare("UPDATE meja SET uuid = ? WHERE id = ?");
        $stmt->execute([$uuid, $id]);
        echo "✓ UUID ditambahkan ke meja ID: $id\n";
    }
    
    echo "\n✅ Setup UUID selesai!\n";
    echo "Sekarang URL menu menggunakan UUID untuk keamanan.\n";
    echo "Contoh URL baru: /customer/menu/{uuid}/meja/{uuid}\n";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Pastikan database credentials benar dan database 'buku_menu' ada.\n";
} 