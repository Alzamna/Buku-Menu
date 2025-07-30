<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menus';             // Nama tabel database
    protected $primaryKey = 'id';                // Primary key
    protected $useAutoIncrement = true;

    protected $returnType = 'array';             // Bisa 'object' atau 'array'
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'nama',
        'deskripsi',
        'harga',
        'gambar',
        'kategori'
    ]; // Field yang boleh diinput

    protected $useTimestamps = true;                  // Otomatis kelola created_at dan updated_at
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validasi opsional (bisa kamu aktifkan jika ingin digunakan)
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
}
