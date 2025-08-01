<?php

namespace App\Models;

use CodeIgniter\Model;

class RestoranModel extends Model
{
    protected $table = 'restoran';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama', 'alamat', 'kontak', 'uuid'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[255]',
        'alamat' => 'required|min_length[10]',
        'kontak' => 'required|min_length[10]|max_length[100]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama restoran harus diisi',
            'min_length' => 'Nama restoran minimal 3 karakter',
            'max_length' => 'Nama restoran maksimal 255 karakter',
        ],
        'alamat' => [
            'required' => 'Alamat harus diisi',
            'min_length' => 'Alamat minimal 10 karakter',
        ],
        'kontak' => [
            'required' => 'Kontak harus diisi',
            'min_length' => 'Kontak minimal 10 karakter',
            'max_length' => 'Kontak maksimal 100 karakter',
        ],
    ];

    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    public function findByUuid($uuid)
    {
        return $this->where('uuid', $uuid)->first();
    }

    public function getRestoranWithStats()
    {
        return $this->select('restoran.*, 
                             COUNT(DISTINCT kategori.id) as jumlah_kategori,
                             COUNT(DISTINCT menu.id) as jumlah_menu,
                             COUNT(DISTINCT pesanan.id) as jumlah_pesanan')
                    ->join('kategori', 'kategori.restoran_id = restoran.id', 'left')
                    ->join('menu', 'menu.kategori_id = kategori.id', 'left')
                    ->join('pesanan', 'pesanan.restoran_id = restoran.id', 'left')
                    ->groupBy('restoran.id')
                    ->findAll();
    }
} 