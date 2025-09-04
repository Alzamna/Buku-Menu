<?php

namespace App\Controllers;

use App\Models\RestoranModel;
use App\Models\UserModel;
use App\Models\KategoriModel;
use App\Models\MenuModel;
use App\Models\PaketModel;

class SuperAdmin extends BaseController
{
    protected $restoranModel;
    protected $userModel;
    protected $kategoriModel;
    protected $menuModel;
    protected $paketModel;

    public function __construct()
    {
        $this->restoranModel = new RestoranModel();
        $this->userModel = new UserModel();
        $this->kategoriModel = new KategoriModel();
        $this->menuModel = new MenuModel();
        $this->paketModel = new PaketModel();

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

    // Tambahkan method ini di dalam class SuperAdmin

    public function restoranMenu($restoranId)
    {
        // Ambil data restoran
        $restoran = $this->restoranModel->find($restoranId);

        if (!$restoran) {
            return redirect()->to('/super-admin/dashboard')->with('error', 'Restoran tidak ditemukan!');
        }

        // Gunakan method yang sama seperti di Customer controller
        $kategoriList = $this->kategoriModel->getKategoriByRestoran($restoran['id']);
        $menuList = $this->menuModel->getMenuByRestoran($restoran['id']);

        // Group menu by category (sama seperti di Customer controller)
        $menuByKategori = [];
        foreach ($menuList as $menu) {
            $kategoriName = $menu['nama_kategori'];
            if (!isset($menuByKategori[$kategoriName])) {
                $menuByKategori[$kategoriName] = [];
            }
            $menuByKategori[$kategoriName][] = $menu;
        }

        $data = [
            'title' => 'Menu ' . $restoran['nama'],
            'restoran' => $restoran,
            'kategori_list' => $kategoriList,
            'menu_by_kategori' => $menuByKategori,
            'menu_list' => $menuList
        ];

        return view('super_admin/restoran/menu', $data);
    }

    public function restoran()
    {
        $data = [
            'title' => 'Kelola Restoran',
            'restoran_list' => $this->restoranModel->getRestoranWithStats()
        ];

        return view('super_admin/restoran/index', $data);
    }
    public function viewmenu($restoranId)
    {
        // Ambil data restoran
        $restoran = $this->restoranModel->find($restoranId);
        if (!$restoran) {
            return redirect()->to('super-admin/restoran')->with('error', 'Restoran tidak ditemukan');
        }

        // Ambil semua menu yang ada di restoran ini
        $menus = $this->menuModel
            ->select('menu.*, kategori.nama as kategori_nama')
            ->join('kategori', 'kategori.id = menu.kategori_id')
            ->where('kategori.restoran_id', $restoranId)
            ->findAll();

        $data = [
            'title' => 'Daftar Menu - ' . $restoran['nama'],
            'restoran' => $restoran,
            'menus' => $menus
        ];

        return view('super_admin/restoran_menu', $data);
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
                helper('uuid');
                if (!function_exists('generate_secure_uuid')) {
                    // Fallback to simple UUID generation
                    $uuid = sprintf(
                        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                        mt_rand(0, 0xffff),
                        mt_rand(0, 0xffff),
                        mt_rand(0, 0xffff),
                        mt_rand(0, 0x0fff) | 0x4000,
                        mt_rand(0, 0x3fff) | 0x8000,
                        mt_rand(0, 0xffff),
                        mt_rand(0, 0xffff),
                        mt_rand(0, 0xffff)
                    );
                } else {
                    $uuid = \generate_secure_uuid();
                }
                $data = [
                    'nama' => $this->request->getPost('nama'),
                    'alamat' => $this->request->getPost('alamat'),
                    'kontak' => $this->request->getPost('kontak'),
                    'uuid' => $uuid,
                ];

                if ($this->restoranModel->insert($data)) {
                    session()->setFlashdata('success', 'Restoran berhasil ditambahkan!');
                    return redirect()->to('/super-admin/restoran');
                } else {
                    session()->setFlashdata('error', 'Gagal menambahkan restoran!');
                }
            } else {
                // Set error messages for each field
                $errors = $this->validator->getErrors();
                foreach ($errors as $field => $error) {
                    session()->setFlashdata('errors.' . $field, $error);
                }
                session()->setFlashdata('error', 'Validasi gagal! Silakan periksa kembali data yang dimasukkan.');
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
                // Set error messages for each field
                $errors = $this->validator->getErrors();
                foreach ($errors as $field => $error) {
                    session()->setFlashdata('errors.' . $field, $error);
                }
                session()->setFlashdata('error', 'Validasi gagal! Silakan periksa kembali data yang dimasukkan.');
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

    // Master Paket

    public function paket()
    {
        $data = [
            'title' => 'Kelola Paket Langganan Restoran',
            'paket_list' => $this->paketModel->findAll(),
        ];

        return view('super_admin/paket/index', $data);
    }

    public function paketCreate()
    {
        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama restoran harus di isi.',
                    ]
                ],
                'harga' => [
                    'rules' => 'required|integer',
                    'errors' => [
                        'required' => 'Harga harus di isi.',
                        'integer' => 'Harga harus berisi angka.',
                    ]
                ],
                'durasi' => [
                    'rules' => 'required|integer',
                    'errors' => [
                        'required' => 'Durasi harus di isi.',
                        'integer' => 'Durasi harus berisi angka.',
                    ]
                ],
                'deskripsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Deskripsi harus di isi.',
                    ]
                ],
            ];

            if ($this->validate($rules)) {
                if ($this->paketModel->insert($this->request->getPost())) {
                    session()->setFlashdata('success', 'Paket berhasil ditambahkan!');
                    return redirect()->to('/super-admin/paket');
                } else {
                    session()->setFlashdata('error', 'Gagal menambahkan admin!');
                }
            } else {
                session()->setFlashdata('error', 'Validasi gagal!');
                session()->setFlashdata('errors', $this->validator->getErrors());
            }
        }

        $data = [
            'title' => 'Tambah Paket Restoran',
            'restoran_list' => $this->restoranModel->findAll(),
            'validation' => \Config\Services::validation()
        ];

        return view('super_admin/paket/create', $data);
    }

    public function paketEdit($id)
    {
        $paket = $this->paketModel->find($id);

        if (!$paket) {
            return redirect()->to('/super-admin/paket')->with('error', 'Paket tidak ditemukan!');
        }

        if ($this->request->getMethod() == 'POST') {
            $rules = [
                'nama' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Nama restoran harus di isi.',
                    ]
                ],
                'harga' => [
                    'rules' => 'required|integer',
                    'errors' => [
                        'required' => 'Harga harus di isi.',
                        'integer' => 'Harga harus berisi angka.',
                    ]
                ],
                'durasi' => [
                    'rules' => 'required|integer',
                    'errors' => [
                        'required' => 'Durasi harus di isi.',
                        'integer' => 'Durasi harus berisi angka.',
                    ]
                ],
                'deskripsi' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => 'Deskripsi harus di isi.',
                    ]
                ],
            ];

            if ($this->validate($rules)) {
                if ($this->paketModel->update($id, $this->request->getPost())) {
                    session()->setFlashdata('success', 'Paket berhasil diupdate!');
                    return redirect()->to('/super-admin/paket');
                } else {
                    session()->setFlashdata('error', 'Gagal mengupdate paket!');
                }
            } else {
                session()->setFlashdata('error', 'Validasi gagal! Silakan periksa kembali data yang dimasukkan.');
                session()->setFlashdata('errors', $this->validator->getErrors());
            }
        }

        $data = [
            'title' => 'Edit Paket',
            'paket' => $paket,
            'validation' => \Config\Services::validation()
        ];

        return view('super_admin/paket/edit', $data);
    }

    public function paketDelete($id)
    {
        $paket = $this->paketModel->find($id);

        if ($paket) {
            if ($this->paketModel->delete($id)) {
                session()->setFlashdata('success', 'Paket berhasil dihapus!');
            } else {
                session()->setFlashdata('error', 'Gagal menghapus Paket!');
            }
        } else {
            session()->setFlashdata('error', 'Paket tidak ditemukan!');
        }

        return redirect()->to('/super-admin/paket');
    }
}
