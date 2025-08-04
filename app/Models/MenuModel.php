<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['nama', 'harga', 'kategori_id', 'gambar', 'deskripsi', 'stok'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[255]',
        'harga' => 'required|numeric|greater_than[0]',
        'kategori_id' => 'required|integer|is_not_unique[kategori.id]',
        'stok' => 'required|integer|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama menu harus diisi',
            'min_length' => 'Nama menu minimal 3 karakter',
            'max_length' => 'Nama menu maksimal 255 karakter',
        ],
        'harga' => [
            'required' => 'Harga harus diisi',
            'numeric' => 'Harga harus berupa angka',
            'greater_than' => 'Harga harus lebih dari 0',
        ],
        'kategori_id' => [
            'required' => 'Kategori harus dipilih',
            'integer' => 'ID Kategori tidak valid',
            'is_not_unique' => 'Kategori tidak ditemukan',
        ],
        'stok' => [
            'required' => 'Stok harus diisi',
            'integer' => 'Stok harus berupa angka',
            'greater_than_equal_to' => 'Stok tidak boleh negatif',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getMenuByKategori($kategoriId)
    {
        return $this->where('kategori_id', $kategoriId)
                    ->where('stok >', 0)
                    ->orderBy('nama', 'ASC')
                    ->findAll();
    }

    public function getMenuByRestoran($restoranId)
    {
        return $this->select('menu.*, kategori.nama as nama_kategori')
                    ->join('kategori', 'kategori.id = menu.kategori_id')
                    ->where('kategori.restoran_id', $restoranId)
                    ->orderBy('kategori.nama', 'ASC')
                    ->orderBy('menu.nama', 'ASC')
                    ->findAll();
    }

    public function getMenuWithKategori($restoranId)
    {
        return $this->select('menu.*, kategori.nama as nama_kategori')
                    ->join('kategori', 'kategori.id = menu.kategori_id')
                    ->where('kategori.restoran_id', $restoranId)
                    ->orderBy('kategori.nama', 'ASC')
                    ->orderBy('menu.nama', 'ASC')
                    ->findAll();
    }

    public function updateStok($menuId, $jumlah)
    {
        $menu = $this->find($menuId);
        if ($menu) {
            $newStok = $menu['stok'] - $jumlah;
            if ($newStok >= 0) {
                return $this->update($menuId, ['stok' => $newStok]);
            }
        }
        return false;
    }
} 
