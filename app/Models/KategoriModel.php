<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama', 'restoran_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama' => 'required|min_length[2]|max_length[100]',
        'restoran_id' => 'required|integer|is_not_unique[restoran.id]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama kategori harus diisi',
            'min_length' => 'Nama kategori minimal 2 karakter',
            'max_length' => 'Nama kategori maksimal 100 karakter',
        ],
        'restoran_id' => [
            'required' => 'Restoran harus dipilih',
            'integer' => 'ID Restoran tidak valid',
            'is_not_unique' => 'Restoran tidak ditemukan',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getKategoriByRestoran($restoranId)
    {
        return $this->where('restoran_id', $restoranId)
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    public function getKategoriWithMenuCount($restoranId)
    {
        return $this->select('kategori.*, COUNT(menu.id) as jumlah_menu')
                    ->join('menu', 'menu.kategori_id = kategori.id', 'left')
                    ->where('kategori.restoran_id', $restoranId)
                    ->groupBy('kategori.id')
                    ->orderBy('kategori.nama', 'ASC')
                    ->findAll();
    }
} 