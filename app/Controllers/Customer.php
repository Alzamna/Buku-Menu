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

    public function menu($restoranId)
    {
        $restoran = $this->restoranModel->find($restoranId);
        
        if (!$restoran) {
            return redirect()->to('/')->with('error', 'Restoran tidak ditemukan!');
        }

        $kategoriList = $this->kategoriModel->getKategoriByRestoran($restoranId);
        $menuList = $this->menuModel->getMenuByRestoran($restoranId);

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
            'kategori_list' => $kategoriList,
            'menu_by_kategori' => $menuByKategori,
        ];

        return view('customer/menu', $data);
    }

    public function addToCart()
    {
        if ($this->request->getMethod() !== 'post') {
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

    public function checkout()
    {
        $cart = session()->get('cart') ?? [];
        
        if (empty($cart)) {
            return redirect()->to('/')->with('error', 'Keranjang kosong!');
        }

        if ($this->request->getMethod() === 'post') {
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

            // Create order
            $pesananData = [
                'restoran_id' => $restoranId,
                'metode' => $metode,
                'total' => $total,
                'waktu_pesan' => date('Y-m-d H:i:s'),
                'status' => 'pending',
            ];

            $pesananId = $this->pesananModel->insert($pesananData);

            if ($pesananId) {
                // Create order details
                $this->pesananDetailModel->createDetailFromCart($pesananId, $cart);

                // Update stock
                foreach ($cart as $item) {
                    $this->menuModel->updateStok($item['menu_id'], $item['jumlah']);
                }

                // Clear cart
                session()->remove('cart');

                session()->setFlashdata('success', 'Pesanan berhasil dibuat!');
                return redirect()->to("/customer/order/{$pesananId}");
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
        ];

        return view('customer/checkout', $data);
    }

    public function order($pesananId)
    {
        $pesanan = $this->pesananModel->getPesananWithDetails($pesananId);
        
        if (!$pesanan) {
            return redirect()->to('/')->with('error', 'Pesanan tidak ditemukan!');
        }

        $detailList = $this->pesananDetailModel->getDetailByPesanan($pesananId);

        $data = [
            'title' => 'Detail Pesanan',
            'pesanan' => $pesanan,
            'detail_list' => $detailList,
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