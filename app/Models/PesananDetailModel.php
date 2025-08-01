<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananDetailModel extends Model
{
    protected $table = 'pesanan_detail';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['pesanan_id', 'menu_id', 'jumlah', 'harga_satuan', 'subtotal', 'catatan'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'pesanan_id' => 'required|integer|is_not_unique[pesanan.id]',
        'menu_id' => 'required|integer|is_not_unique[menu.id]',
        'jumlah' => 'required|integer|greater_than[0]',
        'harga_satuan' => 'required|numeric|greater_than[0]',
        'subtotal' => 'required|numeric|greater_than[0]',
    ];

    protected $validationMessages = [
        'pesanan_id' => [
            'required' => 'ID Customer harus diisi',
            'integer' => 'ID Customer tidak valid',
            'is_not_unique' => 'Pesanan tidak ditemukan',
        ],
        'menu_id' => [
            'required' => 'ID Menu harus diisi',
            'integer' => 'ID Menu tidak valid',
            'is_not_unique' => 'Menu tidak ditemukan',
        ],
        'jumlah' => [
            'required' => 'Jumlah harus diisi',
            'integer' => 'Jumlah harus berupa angka',
            'greater_than' => 'Jumlah harus lebih dari 0',
        ],
        'harga_satuan' => [
            'required' => 'Harga satuan harus diisi',
            'numeric' => 'Harga satuan harus berupa angka',
            'greater_than' => 'Harga satuan harus lebih dari 0',
        ],
        'subtotal' => [
            'required' => 'Subtotal harus diisi',
            'numeric' => 'Subtotal harus berupa angka',
            'greater_than' => 'Subtotal harus lebih dari 0',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getDetailByPesanan($pesananId)
    {
        return $this->select('pesanan_detail.*, menu.nama as nama_menu, menu.gambar')
                    ->join('menu', 'menu.id = pesanan_detail.menu_id')
                    ->where('pesanan_detail.pesanan_id', $pesananId)
                    ->findAll();
    }

    public function createDetailFromCart($pesananId, $cartItems)
    {
        $details = [];
        
        foreach ($cartItems as $item) {
            $details[] = [
                'pesanan_id' => $pesananId,
                'menu_id' => $item['menu_id'],
                'jumlah' => $item['jumlah'],
                'harga_satuan' => $item['harga'],
                'subtotal' => $item['harga'] * $item['jumlah'],
                'catatan' => $item['catatan'] ?? null,
            ];
        }
        
        return $this->insertBatch($details);
    }
} 