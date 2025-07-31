<?php

namespace App\Models;

use CodeIgniter\Model;

class MejaModel extends Model
{
    protected $table = 'meja';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['restoran_id', 'nomor_meja', 'keterangan', 'status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'restoran_id' => 'required|integer',
        'nomor_meja' => 'required|max_length[50]',
        'status' => 'required|in_list[aktif,nonaktif]',
    ];
    protected $validationMessages = [
        'restoran_id' => [
            'required' => 'ID Restoran harus diisi',
            'integer' => 'ID Restoran harus berupa angka',
        ],
        'nomor_meja' => [
            'required' => 'Nomor meja harus diisi',
            'max_length' => 'Nomor meja maksimal 50 karakter',
        ],
        'status' => [
            'required' => 'Status harus diisi',
            'in_list' => 'Status harus aktif atau nonaktif',
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    public function getMejaByRestoran($restoranId)
    {
        return $this->where('restoran_id', $restoranId)
                    ->where('status', 'aktif')
                    ->orderBy('nomor_meja', 'ASC')
                    ->findAll();
    }

    public function getMejaWithRestoran($mejaId)
    {
        return $this->select('meja.*, restoran.nama as nama_restoran')
                    ->join('restoran', 'restoran.id = meja.restoran_id')
                    ->where('meja.id', $mejaId)
                    ->first();
    }
} 