<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;

    protected $allowedFields = ['restoran_id', 'metode', 'total', 'waktu_pesan', 'status', 'nama', 'telepon', 'meja', 'catatan_pesanan', 'kode_unik',];


    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'restoran_id' => 'required|integer|is_not_unique[restoran.id]',
        'metode' => 'required|in_list[dine_in,take_away]',
        'total' => 'required|numeric|greater_than[0]',
        'waktu_pesan' => 'required|valid_date',
        'status' => 'required|in_list[pending,confirmed,completed,cancelled]',
    ];

    protected $validationMessages = [
        'restoran_id' => [
            'required' => 'Restoran harus dipilih',
            'integer' => 'ID Restoran tidak valid',
            'is_not_unique' => 'Restoran tidak ditemukan',
        ],
        'metode' => [
            'required' => 'Metode harus dipilih',
            'in_list' => 'Metode tidak valid',
        ],
        'total' => [
            'required' => 'Total harus diisi',
            'numeric' => 'Total harus berupa angka',
            'greater_than' => 'Total harus lebih dari 0',
        ],
        'waktu_pesan' => [
            'required' => 'Waktu pesan harus diisi',
            'valid_date' => 'Format waktu tidak valid',
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status tidak valid',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getPesananByRestoran($restoranId)
    {
        return $this->where('restoran_id', $restoranId)
            ->orderBy('waktu_pesan', 'DESC')
            ->findAll();
    }

    public function getPesananWithPagination($restoranId, $query = null, $filter = 'terbaru', $status = '', $page = 1, $perPage = 15)
    {
        $builder = $this->where('restoran_id', $restoranId);
        
        // Apply search filter
        if ($query) {
            $builder->groupStart()
                ->like('nama', $query)
                ->orLike('kode_unik', $query)
                ->orLike('metode', $query)
                ->orLike('status', $query)
                ->groupEnd();
        }

        // Apply status filter
        if ($status && $status !== '') {
            $builder->where('status', $status);
        }

        // Apply sorting filter
        if ($filter === 'terbaru') {
            $builder->orderBy('waktu_pesan', 'DESC');
        } else {
            $builder->orderBy('waktu_pesan', 'ASC');
        }

        // Get total count for pagination
        $total = $builder->countAllResults(false);
        
        // Apply pagination
        $offset = ($page - 1) * $perPage;
        $data = $builder->limit($perPage, $offset)->findAll();

        return [
            'data' => $data,
            'total' => $total,
            'total_pages' => ceil($total / $perPage),
            'current_page' => $page
        ];
    }

    public function getPesananWithDetails($pesananId)
    {
        return $this->select('pesanan.*, restoran.nama as nama_restoran')
            ->join('restoran', 'restoran.id = pesanan.restoran_id')
            ->where('pesanan.id', $pesananId)
            ->first();
    }

    public function getPesananByStatus($restoranId, $status)
    {
        return $this->where('restoran_id', $restoranId)
            ->where('status', $status)
            ->orderBy('waktu_pesan', 'DESC')
            ->findAll();
    }

    public function updateStatus($pesananId, $status)
    {
        return $this->update($pesananId, ['status' => $status]);
    }
    public function getPesananWithDetailsByKodeUnik($kodeUnik)
    {
        return $this->select('pesanan.*, restoran.nama as nama_restoran')
            ->join('restoran', 'restoran.id = pesanan.restoran_id')
            ->where('pesanan.kode_unik', $kodeUnik)
            ->first();
    }

}