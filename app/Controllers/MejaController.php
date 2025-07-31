<?php

namespace App\Controllers;

use App\Models\MejaModel;
use App\Models\RestoranModel;

class MejaController extends BaseController
{
    protected $mejaModel;
    protected $restoranModel;

    public function __construct()
    {
        $this->mejaModel = new MejaModel();
        $this->restoranModel = new RestoranModel();
    }

    public function index()
    {
        $restoranId = session()->get('restoran_id');
        $mejaList = $this->mejaModel->getMejaByRestoran($restoranId);
        $restoran = $this->restoranModel->find($restoranId);

        $data = [
            'title' => 'Kelola Meja - ' . $restoran['nama'],
            'meja_list' => $mejaList,
            'restoran' => $restoran,
        ];

        return view('admin/meja/index', $data);
    }

    public function create()
    {
        $restoranId = session()->get('restoran_id');
        $restoran = $this->restoranModel->find($restoranId);

        $data = [
            'title' => 'Tambah Meja - ' . $restoran['nama'],
            'restoran' => $restoran,
        ];

        return view('admin/meja/create', $data);
    }

    public function store()
    {
        $restoranId = session()->get('restoran_id');
        
        $rules = [
            'nomor_meja' => 'required|max_length[50]',
            'keterangan' => 'max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'restoran_id' => $restoranId,
            'nomor_meja' => $this->request->getPost('nomor_meja'),
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => 'aktif',
        ];

        if ($this->mejaModel->insert($data)) {
            return redirect()->to('admin/meja')->with('success', 'Meja berhasil ditambahkan!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal menambahkan meja!');
        }
    }

    public function edit($id)
    {
        $restoranId = session()->get('restoran_id');
        $meja = $this->mejaModel->find($id);
        
        if (!$meja || $meja['restoran_id'] != $restoranId) {
            return redirect()->to('admin/meja')->with('error', 'Meja tidak ditemukan!');
        }

        $restoran = $this->restoranModel->find($restoranId);

        $data = [
            'title' => 'Edit Meja - ' . $restoran['nama'],
            'meja' => $meja,
            'restoran' => $restoran,
        ];

        return view('admin/meja/edit', $data);
    }

    public function update($id)
    {
        $restoranId = session()->get('restoran_id');
        $meja = $this->mejaModel->find($id);
        
        if (!$meja || $meja['restoran_id'] != $restoranId) {
            return redirect()->to('admin/meja')->with('error', 'Meja tidak ditemukan!');
        }

        $rules = [
            'nomor_meja' => 'required|max_length[50]',
            'keterangan' => 'max_length[255]',
            'status' => 'required|in_list[aktif,nonaktif]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'nomor_meja' => $this->request->getPost('nomor_meja'),
            'keterangan' => $this->request->getPost('keterangan'),
            'status' => $this->request->getPost('status'),
        ];

        if ($this->mejaModel->update($id, $data)) {
            return redirect()->to('admin/meja')->with('success', 'Meja berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui meja!');
        }
    }

    public function delete($id)
    {
        $restoranId = session()->get('restoran_id');
        $meja = $this->mejaModel->find($id);
        
        if (!$meja || $meja['restoran_id'] != $restoranId) {
            return redirect()->to('admin/meja')->with('error', 'Meja tidak ditemukan!');
        }

        if ($this->mejaModel->delete($id)) {
            return redirect()->to('admin/meja')->with('success', 'Meja berhasil dihapus!');
        } else {
            return redirect()->to('admin/meja')->with('error', 'Gagal menghapus meja!');
        }
    }
} 