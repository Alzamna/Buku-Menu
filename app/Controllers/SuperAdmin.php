<?php

namespace App\Controllers;

use App\Models\RestoranModel;
use App\Models\UserModel;

class SuperAdmin extends BaseController
{
    protected $restoranModel;
    protected $userModel;

    public function __construct()
    {
        $this->restoranModel = new RestoranModel();
        $this->userModel = new UserModel();

        // Check if user is super admin
        if (session()->get('role') !== 'super_admin') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak!');
        }
    }

    public function dashboard()
    {
        $data = [
            'title' => 'Dashboard Super Admin',
            'total_restoran' => $this->restoranModel->countAll(),
            'total_admin' => $this->userModel->where('role', 'admin_restoran')->countAllResults(),
            'restoran_list' => $this->restoranModel->getRestoranWithStats()
        ];

        return view('super_admin/dashboard', $data);
    }

    public function restoran()
    {
        $data = [
            'title' => 'Kelola Restoran',
            'restoran_list' => $this->restoranModel->getRestoranWithStats()
        ];

        return view('super_admin/restoran/index', $data);
    }

    public function restoranCreate()
    {
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'nama' => 'required|min_length[3]|max_length[255]',
                'alamat' => 'required|min_length[10]',
                'kontak' => 'required|min_length[10]|max_length[100]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'nama' => $this->request->getPost('nama'),
                    'alamat' => $this->request->getPost('alamat'),
                    'kontak' => $this->request->getPost('kontak'),
                ];

                if ($this->restoranModel->insert($data)) {
                    session()->setFlashdata('success', 'Restoran berhasil ditambahkan!');
                    return redirect()->to('/super-admin/restoran');
                } else {
                    session()->setFlashdata('error', 'Gagal menambahkan restoran!');
                }
            } else {
                session()->setFlashdata('error', 'Validasi gagal!');
            }
        }

        $data = [
            'title' => 'Tambah Restoran',
            'validation' => \Config\Services::validation()
        ];

        return view('super_admin/restoran/create', $data);
    }

    public function restoranEdit($id)
    {
        $restoran = $this->restoranModel->find($id);

        if (!$restoran) {
            return redirect()->to('/super-admin/restoran')->with('error', 'Restoran tidak ditemukan!');
        }

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'nama' => 'required|min_length[3]|max_length[255]',
                'alamat' => 'required|min_length[10]',
                'kontak' => 'required|min_length[10]|max_length[100]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'nama' => $this->request->getPost('nama'),
                    'alamat' => $this->request->getPost('alamat'),
                    'kontak' => $this->request->getPost('kontak'),
                ];

                if ($this->restoranModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Restoran berhasil diupdate!');
                    return redirect()->to('/super-admin/restoran');
                } else {
                    session()->setFlashdata('error', 'Gagal mengupdate restoran!');
                }
            } else {
                session()->setFlashdata('error', 'Validasi gagal!');
            }
        }

        $data = [
            'title' => 'Edit Restoran',
            'restoran' => $restoran,
            'validation' => \Config\Services::validation()
        ];

        return view('super_admin/restoran/edit', $data);
    }

    public function restoranDelete($id)
    {
        if ($this->restoranModel->delete($id)) {
            session()->setFlashdata('success', 'Restoran berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus restoran!');
        }

        return redirect()->to('/super-admin/restoran');
    }

    public function admin()
    {
        $data = [
            'title' => 'Kelola Admin Restoran',
            'admin_list' => $this->userModel->getAdminRestoran()
        ];

        return view('super_admin/admin/index', $data);
    }

    public function adminCreate()
    {
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
                'password' => 'required|min_length[6]',
                'restoran_id' => 'required|integer|is_not_unique[restoran.id]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'username' => $this->request->getPost('username'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'role' => 'admin_restoran',
                    'restoran_id' => $this->request->getPost('restoran_id'),
                ];

                if ($this->userModel->insert($data)) {
                    session()->setFlashdata('success', 'Admin berhasil ditambahkan!');
                    return redirect()->to('/super-admin/admin');
                } else {
                    session()->setFlashdata('error', 'Gagal menambahkan admin!');
                }
            } else {
                session()->setFlashdata('error', 'Validasi gagal!');
            }
        }

        $data = [
            'title' => 'Tambah Admin Restoran',
            'restoran_list' => $this->restoranModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('super_admin/admin/create', $data);
    }

    public function adminDelete($id)
    {
        $admin = $this->userModel->find($id);

        if ($admin && $admin['role'] === 'admin_restoran') {
            if ($this->userModel->delete($id)) {
                session()->setFlashdata('success', 'Admin berhasil dihapus!');
            } else {
                session()->setFlashdata('error', 'Gagal menghapus admin!');
            }
        } else {
            session()->setFlashdata('error', 'Admin tidak ditemukan!');
        }

        return redirect()->to('/super-admin/admin');
    }
}