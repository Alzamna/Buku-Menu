<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['username', 'password', 'role', 'restoran_id'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username,id,{id}]',
        'password' => 'required|min_length[6]',
        'role' => 'required|in_list[super_admin,admin_restoran]',
    ];

    protected $validationMessages = [
        'username' => [
            'required' => 'Username harus diisi',
            'min_length' => 'Username minimal 3 karakter',
            'max_length' => 'Username maksimal 100 karakter',
            'is_unique' => 'Username sudah digunakan',
        ],
        'password' => [
            'required' => 'Password harus diisi',
            'min_length' => 'Password minimal 6 karakter',
        ],
        'role' => [
            'required' => 'Role harus dipilih',
            'in_list' => 'Role tidak valid',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getUsersByRole($role)
    {
        return $this->where('role', $role)->findAll();
    }

    public function getAdminRestoran()
    {
        return $this->select('users.*, restoran.nama as nama_restoran')
                    ->join('restoran', 'restoran.id = users.restoran_id', 'left')
                    ->where('users.role', 'admin_restoran')
                    ->findAll();
    }

    public function authenticate($username, $password)
    {
        $user = $this->where('username', $username)->first();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        
        return false;
    }
} 