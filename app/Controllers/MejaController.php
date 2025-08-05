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
        $restoran = $this->restoranModel->find($restoranId);

        $restoranUuid = $restoran['uuid'];
        $filter = $this->request->getGet('filter') ?? 'aktif';
        $search = $this->request->getGet('q') ?? '';
        $page = (int) ($this->request->getGet('page') ?? 1);
        $perPage = 15;

        $result = $this->mejaModel->getMejaByRestoranUuidWithPaginationAndFilterAndSearch(
            $restoranUuid,
            $filter,
            $search,
            $page,
            $perPage
        );

        $data = [
            'title' => 'Kelola Meja',
            'restoran' => $restoran,
            'meja_list' => $result['data'],
            'total_records' => $result['total'],
            'current_filter' => $filter,
            'current_query' => $search,
            'current_page' => $page,
            'total_pages' => $result['total_pages'],
        ];

        return view('admin/meja/index', $data);
    }


    public function create()
    {
        $restoranId = session()->get('restoran_id');
        $restoran = $this->restoranModel->find($restoranId);

        $data = [
            'title' => 'Tambah Meja',
            'restoran' => $restoran,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/meja/create', $data);
    }

    public function store()
    {
        $restoranId = session()->get('restoran_id');

        $rules = [
            'nomor_meja' => 'required|min_length[1]|max_length[50]',
            'status' => 'required|in_list[aktif,nonaktif]',
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
                'restoran_id' => $restoranId,
                'nomor_meja' => $this->request->getPost('nomor_meja'),
                'keterangan' => $this->request->getPost('keterangan') ?: null,
                'status' => $this->request->getPost('status'),
                'uuid' => $uuid,
            ];

            if ($this->mejaModel->insert($data)) {
                session()->setFlashdata('success', 'Meja berhasil ditambahkan!');
                return redirect()->to('/admin/meja');
            } else {
                session()->setFlashdata('error', 'Gagal menambahkan meja!');
            }
        } else {
            // Set error messages for each field
            $errors = $this->validator->getErrors();
            foreach ($errors as $field => $error) {
                session()->setFlashdata('errors.' . $field, $error);
            }
            session()->setFlashdata('error', 'Validasi gagal! Silakan periksa kembali data yang dimasukkan.');
        }

        return redirect()->back()->withInput();
    }

    public function edit($id)
    {
        $restoranId = session()->get('restoran_id');
        $meja = $this->mejaModel->find($id);

        if (!$meja || $meja['restoran_id'] != $restoranId) {
            return redirect()->to('/admin/meja')->with('error', 'Meja tidak ditemukan!');
        }

        $restoran = $this->restoranModel->find($restoranId);

        $data = [
            'title' => 'Edit Meja',
            'meja' => $meja,
            'restoran' => $restoran,
            'validation' => \Config\Services::validation()
        ];

        return view('admin/meja/edit', $data);
    }

    public function update($id)
    {
        $restoranId = session()->get('restoran_id');
        $meja = $this->mejaModel->find($id);

        if (!$meja || $meja['restoran_id'] != $restoranId) {
            return redirect()->to('/admin/meja')->with('error', 'Meja tidak ditemukan!');
        }

        $rules = [
            'nomor_meja' => 'required|min_length[1]|max_length[50]',
            'status' => 'required|in_list[aktif,nonaktif]',
        ];

        if ($this->validate($rules)) {
            $data = [
                'nomor_meja' => $this->request->getPost('nomor_meja'),
                'keterangan' => $this->request->getPost('keterangan') ?: null,
                'status' => $this->request->getPost('status'),
            ];

            if ($this->mejaModel->update($id, $data)) {
                session()->setFlashdata('success', 'Meja berhasil diupdate!');
                return redirect()->to('/admin/meja');
            } else {
                session()->setFlashdata('error', 'Gagal mengupdate meja!');
            }
        } else {
            // Set error messages for each field
            $errors = $this->validator->getErrors();
            foreach ($errors as $field => $error) {
                session()->setFlashdata('errors.' . $field, $error);
            }
            session()->setFlashdata('error', 'Validasi gagal! Silakan periksa kembali data yang dimasukkan.');
        }

        return redirect()->back()->withInput();
    }

    public function delete($id)
    {
        $restoranId = session()->get('restoran_id');
        $meja = $this->mejaModel->find($id);

        if (!$meja || $meja['restoran_id'] != $restoranId) {
            return redirect()->to('/admin/meja')->with('error', 'Meja tidak ditemukan!');
        }

        if ($this->mejaModel->delete($id)) {
            session()->setFlashdata('success', 'Meja berhasil dihapus!');
        } else {
            session()->setFlashdata('error', 'Gagal menghapus meja!');
        }

        return redirect()->to('/admin/meja');
    }
} 