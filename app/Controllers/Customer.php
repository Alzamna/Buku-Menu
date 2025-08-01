<?php

namespace App\Controllers;

use App\Models\KategoriModel;
use App\Models\MenuModel;
use App\Models\PesananModel;
use App\Models\PesananDetailModel;
use App\Models\RestoranModel;

class Customer extends BaseController
{
    protected $kategoriModel;
    protected $menuModel;
    protected $pesananModel;
    protected $pesananDetailModel;
    protected $restoranModel;

    public function __construct()
    {
        $this->kategoriModel = new KategoriModel();
        $this->menuModel = new MenuModel();
        $this->pesananModel = new PesananModel();
        $this->pesananDetailModel = new PesananDetailModel();
        $this->restoranModel = new RestoranModel();
    }

    public function menu($restoranUuid, $mejaUuid = null)
    {
        $restoran = $this->restoranModel->findByUuid($restoranUuid);

        if (!$restoran) {
            return redirect()->to('/')->with('error', 'Restoran tidak ditemukan!');
        }

        // Store restaurant ID in session for checkout
        session()->set('restoran_id', $restoran['id']);

        $meja = null;
        if ($mejaUuid) {
            $mejaModel = new \App\Models\MejaModel();
            $meja = $mejaModel->findByUuid($mejaUuid);
            if (!$meja || $meja['restoran_id'] != $restoran['id']) {
                return redirect()->to('/')->with('error', 'Meja tidak ditemukan!');
            }
            // Store meja_id in session for checkout
            session()->set('meja_id', $meja['id']);
        } else {
            // Clear meja_id from session if no meja specified
            session()->remove('meja_id');
        }

        $kategoriList = $this->kategoriModel->getKategoriByRestoran($restoran['id']);
        $menuList = $this->menuModel->getMenuByRestoran($restoran['id']);

        // Group menu by category
        $menuByKategori = [];
        foreach ($menuList as $menu) {
            $kategoriName = $menu['nama_kategori'];
            if (!isset($menuByKategori[$kategoriName])) {
                $menuByKategori[$kategoriName] = [];
            }
            $menuByKategori[$kategoriName][] = $menu;
        }

        $data = [
            'title' => 'Menu - ' . $restoran['nama'],
            'restoran' => $restoran,
            'meja' => $meja,
            'kategori_list' => $kategoriList,
            'menu_by_kategori' => $menuByKategori,
        ];

        return view('customer/menu', $data);
    }

    public function addToCart()
    {
        if ($this->request->getMethod() !== 'POST') {
            return redirect()->back();
        }

        $menuId = $this->request->getPost('menu_id');
        $jumlah = (int) $this->request->getPost('jumlah');
        $catatan = $this->request->getPost('catatan');

        if ($jumlah <= 0) {
            session()->setFlashdata('error', 'Jumlah harus lebih dari 0!');
            return redirect()->back();
        }

        $menu = $this->menuModel->find($menuId);
        if (!$menu || $menu['stok'] < $jumlah) {
            session()->setFlashdata('error', 'Stok tidak mencukupi!');
            return redirect()->back();
        }

        // Get current cart
        $cart = session()->get('cart') ?? [];

        // Check if item already exists in cart
        $itemExists = false;
        foreach ($cart as &$item) {
            if ($item['menu_id'] == $menuId) {
                $item['jumlah'] += $jumlah;
                $item['catatan'] = $catatan ?: $item['catatan'];
                $itemExists = true;
                break;
            }
        }

        // Add new item if not exists
        if (!$itemExists) {
            $cart[] = [
                'menu_id' => $menuId,
                'nama' => $menu['nama'],
                'harga' => $menu['harga'],
                'jumlah' => $jumlah,
                'catatan' => $catatan,
                'gambar' => $menu['gambar'],
            ];
        }

        session()->set('cart', $cart);
        session()->setFlashdata('success', 'Menu berhasil ditambahkan ke keranjang!');

        return redirect()->back();
    }

    public function cart()
    {
        $cart = session()->get('cart') ?? [];

        if (empty($cart)) {
            return redirect()->to('/')->with('error', 'Keranjang kosong!');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        $data = [
            'title' => 'Keranjang Belanja',
            'cart' => $cart,
            'total' => $total,
        ];

        return view('customer/cart', $data);
    }

    public function updateCart()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->back();
        }

        $cart = session()->get('cart') ?? [];
        $updatedCart = [];

        foreach ($cart as $index => $item) {
            $jumlah = (int) $this->request->getPost("jumlah_{$index}");
            $catatan = $this->request->getPost("catatan_{$index}");

            if ($jumlah > 0) {
                $item['jumlah'] = $jumlah;
                $item['catatan'] = $catatan;
                $updatedCart[] = $item;
            }
        }

        session()->set('cart', $updatedCart);
        session()->setFlashdata('success', 'Keranjang berhasil diupdate!');

        return redirect()->to('/customer/cart');
    }

    public function removeFromCart($index)
    {
        $cart = session()->get('cart') ?? [];

        if (isset($cart[$index])) {
            unset($cart[$index]);
            $cart = array_values($cart); // Re-index array
            session()->set('cart', $cart);
            session()->setFlashdata('success', 'Item berhasil dihapus dari keranjang!');
        }

        return redirect()->to('/customer/cart');
    }

    public function identityForm()
    {
        $cart = session()->get('cart') ?? [];
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        return view('customer/contact', [
            'total' => $total
        ]);
    }

    public function submitIdentitas()
    {
        $identitas = [
            'nama' => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),

        ];
        session()->set('identitas', $identitas);
        return redirect()->to('/customer/checkout');

    }

    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
        $identitas = session()->get('identitas') ?? [];

        if (empty($cart)) {
            return redirect()->to('/')->with('error', 'Keranjang kosong!');
        }
        if (empty($identitas)) {
            return redirect()->to('/')->with('error', 'Identitas tidak lengkap!');
        }

        if ($this->request->getMethod() == 'POST') {
            $metode = $this->request->getPost('metode');
            $restoranId = $this->request->getPost('restoran_id');

            if (!in_array($metode, ['dine_in', 'take_away'])) {
                session()->setFlashdata('error', 'Metode tidak valid!');
                return redirect()->back();
            }

            // Calculate total
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['harga'] * $item['jumlah'];
            }

            // Get customer info from session
            $nama = $identitas['nama'] ?? '';
            $nomorHp = $identitas['telepon'] ?? '';

            // Get meja info (if any)
            $mejaId = session()->get('meja_id');
            $nomorMeja = null;
            if ($mejaId) {
                $mejaModel = new \App\Models\MejaModel();
                $meja = $mejaModel->find($mejaId);
                $nomorMeja = $meja ? $meja['nomor_meja'] : null;
            }

            $kodeUnik = bin2hex(random_bytes(4)); // e.g., a1b2c3d4

            $pesananData = [
                'restoran_id' => $restoranId,
                'nama' => $nama,
                'nomor_hp' => $nomorHp,
                'nomor_meja' => $nomorMeja,
                'catatan_pesanan' => null,
                'metode' => $metode,
                'total' => $total,
                'waktu_pesan' => date('Y-m-d H:i:s'),
                'status' => 'confirmed',
                'kode_unik' => $kodeUnik,
                'telepon' => $identitas['telepon']
            ];

            $pesananId = $this->pesananModel->insert($pesananData);

            if ($pesananId) {
                $this->pesananDetailModel->createDetailFromCart($pesananId, $cart);

                foreach ($cart as $item) {
                    $this->menuModel->updateStok($item['menu_id'], $item['jumlah']);
                }

                session()->remove('cart');
                session()->remove('identitas');

                session()->setFlashdata('success', 'Pesanan berhasil dibuat!');
                return redirect()->to("/customer/completion/{$kodeUnik}");
            } else {
                session()->setFlashdata('error', 'Gagal membuat pesanan!');
                return redirect()->back();
            }
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['harga'] * $item['jumlah'];
        }

        $data = [
            'title' => 'Checkout',
            'cart' => $cart,
            'total' => $total,
            'identitas' => $identitas,
        ];

        return view('customer/checkout', $data);
    }


    public function completion($kodeUnik)
    {
        $pesanan = $this->pesananModel->where('kode_unik', $kodeUnik)->first();

        if (!$pesanan) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan!');
        }

        $detailList = $this->pesananDetailModel->getDetailByPesanan($pesanan['id']);

        $data = [
            'title' => 'Pesanan Selesai',
            'pesanan' => $pesanan,
            'detail_list' => $detailList,
        ];

        return view('customer/completion', $data);
    }


    public function order($kodeUnik)
    {
        $pesanan = $this->pesananModel->where('kode_unik', $kodeUnik)->first();

        if (!$pesanan) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan!');
        }

        $detailList = $this->pesananDetailModel->getDetailByPesanan($pesanan['id']);
        $restoran = $this->restoranModel->find($pesanan['restoran_id']);

        $data = [
            'title' => 'Detail Pesanan',
            'pesanan' => $pesanan,
            'detail_list' => $detailList,
            'restoran' => $restoran,
        ];

        return view('customer/order', $data);
    }


    public function clearCart()
    {
        session()->remove('cart');
        session()->setFlashdata('success', 'Keranjang berhasil dikosongkan!');
        return redirect()->to('/');
    }

}