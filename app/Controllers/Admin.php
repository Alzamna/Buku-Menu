<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\MenuModel;
use App\Models\PesananModel;
use App\Models\RestoranModel;

class Admin extends BaseController
{
    protected $kategoriModel;
    protected $menuModel;
    protected $pesananModel;
    protected $restoranModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->menuModel = new MenuModel();
        $this->pesananModel = new PesananModel();
        $this->restoranModel = new RestoranModel();
        
        // Check if user is admin restoran
        if (session()->get('role') !== 'admin_restoran') {
            return redirect()->to('/auth')->with('error', 'Akses ditolak!');
        }

    }

    public function dashboard()
    {
        $restoranId = session()->get('restoran_id');
        
        $data = [
            'title' => 'Dashboard Admin Restoran',
            'restoran' => $this->restoranModel->find($restoranId),
            'total_kategori' => $this->kategoriModel->where('restoran_id', $restoranId)->countAllResults(),
            'total_menu' => $this->menuModel->select('menu.*')
                                          ->join('kategori', 'kategori.id = menu.kategori_id')
                                          ->where('kategori.restoran_id', $restoranId)
                                          ->countAllResults(),
            'total_pesanan' => $this->pesananModel->where('restoran_id', $restoranId)->countAllResults(),
            'pesanan_pending' => $this->pesananModel->where('restoran_id', $restoranId)
                                                   ->where('status', 'pending')
                                                   ->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }

    // Kategori Management
    public function kategori()
    {
        $restoranId = session()->get('restoran_id');
        
        $data = [
            'title' => 'Kelola Kategori',
            'kategori_list' => $this->kategoriModel->getKategoriWithMenuCount($restoranId)
        ];

        return view('admin/kategori/index', $data);
    }

    public function kategoriCreate()
    {
        $restoranId = session()->get('restoran_id');

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'nama' => 'required|min_length[2]|max_length[100]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'nama' => $this->request->getPost('nama'),
                    'restoran_id' => $restoranId,
                ];

                if ($this->kategoriModel->insert($data)) {
                    session()->setFlashdata('success', 'Kategori berhasil ditambahkan!');
                    return redirect()->to('/admin/kategori');
                } else {
                    session()->setFlashdata('error', 'Gagal menambahkan kategori!');
                }
            } else {
                session()->setFlashdata('error', 'Validasi gagal!');
            }
        }

        $data = [
            'title' => 'Tambah Kategori',
            'validation' => \Config\Services::validation()
        ];

        return view('admin/kategori/create', $data);
    }

    public function kategoriEdit($id)
    {
        $restoranId = session()->get('restoran_id');
        $kategori = $this->kategoriModel->where('id', $id)
                                       ->where('restoran_id', $restoranId)
                                       ->first();
        
        if (!$kategori) {
            return redirect()->to('/admin/kategori')->with('error', 'Kategori tidak ditemukan!');
        }

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'nama' => 'required|min_length[2]|max_length[100]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'nama' => $this->request->getPost('nama'),
                ];

                if ($this->kategoriModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Kategori berhasil diupdate!');
                    return redirect()->to('/admin/kategori');
                } else {
                    session()->setFlashdata('error', 'Gagal mengupdate kategori!');
                }
            } else {
                session()->setFlashdata('error', 'Validasi gagal!');
            }
        }

        $data = [
            'title' => 'Edit Kategori',
            'kategori' => $kategori,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/kategori/edit', $data);
    }

    public function kategoriDelete($id)
    {
        $restoranId = session()->get('restoran_id');
        $kategori = $this->kategoriModel->where('id', $id)
                                       ->where('restoran_id', $restoranId)
                                       ->first();
        
        if ($kategori) {
            if ($this->kategoriModel->delete($id)) {
                session()->setFlashdata('success', 'Kategori berhasil dihapus!');
            } else {
                session()->setFlashdata('error', 'Gagal menghapus kategori!');
            }
        } else {
            session()->setFlashdata('error', 'Kategori tidak ditemukan!');
        }

        return redirect()->to('/admin/kategori');
    }

    // Menu Management
    public function menu()
    {
        $restoranId = session()->get('restoran_id');
        
        $data = [
            'title' => 'Kelola Menu',
            'menu_list' => $this->menuModel->getMenuWithKategori($restoranId)
        ];

        return view('admin/menu/index', $data);
    }

    public function menuCreate()
    {
        $restoranId = session()->get('restoran_id');

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'nama' => 'required|min_length[3]|max_length[255]',
                'harga' => 'required|numeric|greater_than[0]',
                'kategori_id' => 'required|integer|is_not_unique[kategori.id]',
                'stok' => 'required|integer|greater_than_equal_to[0]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'nama' => $this->request->getPost('nama'),
                    'harga' => $this->request->getPost('harga'),
                    'kategori_id' => $this->request->getPost('kategori_id'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'stok' => $this->request->getPost('stok'),
                ];

                // Handle image upload
                $gambar = $this->request->getFile('gambar');
                if ($gambar->isValid() && !$gambar->hasMoved()) {
                    $newName = $gambar->getRandomName();
                    $gambar->move(ROOTPATH . 'public/uploads/menu', $newName);
                    $data['gambar'] = $newName;
                }

                if ($this->menuModel->insert($data)) {
                    session()->setFlashdata('success', 'Menu berhasil ditambahkan!');
                    return redirect()->to('/admin/menu');
                } else {
                    session()->setFlashdata('error', 'Gagal menambahkan menu!');
                }
            } else {
                session()->setFlashdata('error', 'Validasi gagal!');
            }
        }

        $data = [
            'title' => 'Tambah Menu',
            'kategori_list' => $this->kategoriModel->getKategoriByRestoran($restoranId),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/menu/create', $data);
    }

    public function menuEdit($id)
    {
        $restoranId = session()->get('restoran_id');
        $menu = $this->menuModel->select('menu.*, kategori.restoran_id')
                               ->join('kategori', 'kategori.id = menu.kategori_id')
                               ->where('menu.id', $id)
                               ->where('kategori.restoran_id', $restoranId)
                               ->first();
        
        if (!$menu) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan!');
        }

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'nama' => 'required|min_length[3]|max_length[255]',
                'harga' => 'required|numeric|greater_than[0]',
                'kategori_id' => 'required|integer|is_not_unique[kategori.id]',
                'stok' => 'required|integer|greater_than_equal_to[0]',
            ];

            if ($this->validate($rules)) {
                $data = [
                    'nama' => $this->request->getPost('nama'),
                    'harga' => $this->request->getPost('harga'),
                    'kategori_id' => $this->request->getPost('kategori_id'),
                    'deskripsi' => $this->request->getPost('deskripsi'),
                    'stok' => $this->request->getPost('stok'),
                ];

                // Handle image upload
                $gambar = $this->request->getFile('gambar');
                if ($gambar->isValid() && !$gambar->hasMoved()) {
                    $newName = $gambar->getRandomName();
                    $gambar->move(ROOTPATH . 'public/uploads/menu', $newName);
                    $data['gambar'] = $newName;
                }

                if ($this->menuModel->update($id, $data)) {
                    session()->setFlashdata('success', 'Menu berhasil diupdate!');
                    return redirect()->to('/admin/menu');
                } else {
                    session()->setFlashdata('error', 'Gagal mengupdate menu!');
                }
            } else {
                session()->setFlashdata('error', 'Validasi gagal!');
            }
        }

        $data = [
            'title' => 'Edit Menu',
            'menu' => $menu,
            'kategori_list' => $this->kategoriModel->getKategoriByRestoran($restoranId),
            'validation' => \Config\Services::validation()
        ];

        return view('admin/menu/edit', $data);
    }

    public function menuDelete($id)
    {
        $restoranId = session()->get('restoran_id');
        $menu = $this->menuModel->select('menu.*, kategori.restoran_id')
                               ->join('kategori', 'kategori.id = menu.kategori_id')
                               ->where('menu.id', $id)
                               ->where('kategori.restoran_id', $restoranId)
                               ->first();
        
        if ($menu) {
            if ($this->menuModel->delete($id)) {
                session()->setFlashdata('success', 'Menu berhasil dihapus!');
            } else {
                session()->setFlashdata('error', 'Gagal menghapus menu!');
            }
        } else {
            session()->setFlashdata('error', 'Menu tidak ditemukan!');
        }

        return redirect()->to('/admin/menu');
    }

    // Pesanan Management
    public function pesanan()
    {
        $restoranId = session()->get('restoran_id');
        
        $data = [
            'title' => 'Kelola Pesanan',
            'pesanan_list' => $this->pesananModel->getPesananByRestoran($restoranId)
        ];

        return view('admin/pesanan/index', $data);
    }

    public function pesananDetail($id)
    {
        $restoranId = session()->get('restoran_id');
        $pesanan = $this->pesananModel->getPesananWithDetails($id);
        
        if (!$pesanan || $pesanan['restoran_id'] != $restoranId) {
            return redirect()->to('/admin/pesanan')->with('error', 'Pesanan tidak ditemukan!');
        }

        $pesananDetailModel = new \App\Models\PesananDetailModel();
        
        $data = [
            'title' => 'Detail Pesanan',
            'pesanan' => $pesanan,
            'detail_list' => $pesananDetailModel->getDetailByPesanan($id)
        ];

        return view('admin/pesanan/detail', $data);
    }

    public function pesananUpdateStatus($id)
    {
        $restoranId = session()->get('restoran_id');
        $pesanan = $this->pesananModel->where('id', $id)
                                     ->where('restoran_id', $restoranId)
                                     ->first();
        
        if (!$pesanan) {
            return redirect()->to('/admin/pesanan')->with('error', 'Pesanan tidak ditemukan!');
        }

        $status = $this->request->getPost('status');
        
        if ($this->pesananModel->updateStatus($id, $status)) {
            session()->setFlashdata('success', 'Status pesanan berhasil diupdate!');
        } else {
            session()->setFlashdata('error', 'Gagal mengupdate status pesanan!');
        }

        return redirect()->to('/admin/pesanan');
    }
} 