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
    protected $allowedFields = ['restoran_id', 'nomor_meja', 'keterangan', 'status', 'uuid'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'restoran_id' => 'required|integer|is_not_unique[restoran.id]',
        'nomor_meja' => 'required|min_length[1]|max_length[50]',
        'status' => 'required|in_list[aktif,nonaktif]',
    ];

    protected $validationMessages = [
        'restoran_id' => [
            'required' => 'Restoran harus dipilih',
            'integer' => 'ID Restoran tidak valid',
            'is_not_unique' => 'Restoran tidak ditemukan',
        ],
        'nomor_meja' => [
            'required' => 'Nomor meja harus diisi',
            'min_length' => 'Nomor meja minimal 1 karakter',
            'max_length' => 'Nomor meja maksimal 50 karakter',
        ],
        'status' => [
            'required' => 'Status harus dipilih',
            'in_list' => 'Status tidak valid',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function findByUuid($uuid)
    {
        return $this->where('uuid', $uuid)->first();
    }

    public function getMejaByRestoran($restoranId)
    {
        return $this->where('restoran_id', $restoranId)
                    ->orderBy('nomor_meja', 'ASC')
                    ->findAll();
    }

    public function getMejaByRestoranUuid($restoranUuid)
    {
        return $this->select('meja.*')
                    ->join('restoran', 'restoran.id = meja.restoran_id')
                    ->where('restoran.uuid', $restoranUuid)
                    ->orderBy('meja.nomor_meja', 'ASC')
                    ->findAll();
    }

    public function getMejaByRestoranUuidWithPagination($restoranUuid, $page = 1, $perPage = 15)
    {
        $builder = $this->select('meja.*')
                        ->join('restoran', 'restoran.id = meja.restoran_id')
                        ->where('restoran.uuid', $restoranUuid)
                        ->orderBy('meja.nomor_meja', 'ASC');

        $total = $builder->countAllResults(false);

        $offset = ($page - 1) * $perPage;
        $data = $builder->limit($perPage, $offset)->findAll();

        return [
            'data' => $data,
            'total' => $total,
            'total_pages' => ceil($total / $perPage),
            'current_page' => $page
        ];
    }

    public function getMejaByRestoranUuidWithPaginationAndFilter($restoranUuid, $filter = 'aktif', $page = 1, $perPage = 15)
    {
        $builder = $this->select('meja.*')
                        ->join('restoran', 'restoran.id = meja.restoran_id')
                        ->where('restoran.uuid', $restoranUuid)
                        ->orderBy('meja.nomor_meja', 'ASC');

        if ($filter === 'aktif') {
            $builder->where('meja.status', 'aktif');
        } else if ($filter === 'nonaktif') {
            $builder->where('meja.status', 'nonaktif');
        } else if ($filter === 'semua') {
            $builder->where('meja.status', 'aktif');
            $builder->orWhere('meja.status', 'nonaktif');
        }

        $total = $builder->countAllResults(false);

        $offset = ($page - 1) * $perPage;
        $data = $builder->limit($perPage, $offset)->findAll();

        return [
            'data' => $data,
            'total' => $total,
            'total_pages' => ceil($total / $perPage),
            'current_page' => $page
        ];
    }

    public function getMejaByRestoranUuidWithPaginationAndFilterAndSearch($restoranUuid, $filter = 'aktif', $search = '', $page = 1, $perPage = 15)
    {
        $builder = $this->select('meja.*')
                        ->join('restoran', 'restoran.id = meja.restoran_id')
                        ->where('restoran.uuid', $restoranUuid)
                        ->orderBy('meja.nomor_meja', 'ASC');

        if ($search) {
            $builder->like('meja.nomor_meja', $search);
        }

        if ($filter === 'aktif') {
            $builder->where('meja.status', 'aktif');
        } else if ($filter === 'nonaktif') {
            $builder->where('meja.status', 'nonaktif');
        } else if ($filter === 'semua') {
            $builder->where('meja.status', 'aktif');
            $builder->orWhere('meja.status', 'nonaktif');
        }

        $total = $builder->countAllResults(false);

        $offset = ($page - 1) * $perPage;
        $data = $builder->limit($perPage, $offset)->findAll();

        return [
            'data' => $data,
            'total' => $total,
            'total_pages' => ceil($total / $perPage),
            'current_page' => $page
        ];
    }
} 