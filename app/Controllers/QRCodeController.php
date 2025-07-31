<?php

namespace App\Controllers;

use App\Models\RestoranModel;
use App\Models\MejaModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeController extends BaseController
{
    protected $restoranModel;
    protected $mejaModel;

    public function __construct()
    {
        $this->restoranModel = new RestoranModel();
        $this->mejaModel = new MejaModel();
    }

    public function index()
    {
        $restoranId = session()->get('restoran_id');
        return redirect()->to("admin/qrcode/display/{$restoranId}");
    }

    public function generate($restoranId, $mejaId = null)
    {
        $restoran = $this->restoranModel->find($restoranId);
        
        if (!$restoran) {
            return $this->response->setJSON(['error' => 'Restoran tidak ditemukan']);
        }

        // Generate menu URL with meja parameter
        if ($mejaId) {
            $menuUrl = base_url("customer/menu/{$restoranId}/meja/{$mejaId}");
        } else {
            $menuUrl = base_url("customer/menu/{$restoranId}");
        }

        // Create QR Code
        $qrCode = new QrCode($menuUrl);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        // Create writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Output QR Code as PNG
        return $this->response
            ->setContentType('image/png')
            ->setBody($result->getString());
    }

    public function download($restoranId, $mejaId = null)
    {
        $restoran = $this->restoranModel->find($restoranId);
        
        if (!$restoran) {
            return redirect()->back()->with('error', 'Restoran tidak ditemukan!');
        }

        $meja = null;
        if ($mejaId) {
            $meja = $this->mejaModel->find($mejaId);
            if (!$meja || $meja['restoran_id'] != $restoranId) {
                return redirect()->back()->with('error', 'Meja tidak ditemukan!');
            }
        }

        // Generate menu URL with meja parameter
        if ($mejaId) {
            $menuUrl = base_url("customer/menu/{$restoranId}/meja/{$mejaId}");
        } else {
            $menuUrl = base_url("customer/menu/{$restoranId}");
        }

        // Create QR Code
        $qrCode = new QrCode($menuUrl);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        // Create writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Set filename
        if ($meja) {
            $filename = 'qr_menu_' . $restoran['nama'] . '_meja_' . $meja['nomor_meja'] . '.png';
        } else {
            $filename = 'qr_menu_' . $restoran['nama'] . '.png';
        }
        $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $filename);

        // Download QR Code
        return $this->response
            ->setContentType('image/png')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($result->getString());
    }

    public function display($restoranId)
    {
        $restoran = $this->restoranModel->find($restoranId);
        
        if (!$restoran) {
            return redirect()->back()->with('error', 'Restoran tidak ditemukan!');
        }

        // Get all meja for this restoran
        $mejaList = $this->mejaModel->getMejaByRestoran($restoranId);

        $data = [
            'title' => 'QR Code Menu - ' . $restoran['nama'],
            'restoran' => $restoran,
            'meja_list' => $mejaList,
        ];

        return view('admin/qrcode/display', $data);
    }

    public function generateMeja($restoranId, $mejaId)
    {
        $restoran = $this->restoranModel->find($restoranId);
        $meja = $this->mejaModel->find($mejaId);
        
        if (!$restoran || !$meja || $meja['restoran_id'] != $restoranId) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        // Generate menu URL with meja parameter
        $menuUrl = base_url("customer/menu/{$restoranId}/meja/{$mejaId}");

        // Create QR Code
        $qrCode = new QrCode($menuUrl);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        // Create writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Output QR Code as PNG
        return $this->response
            ->setContentType('image/png')
            ->setBody($result->getString());
    }

    public function downloadMeja($restoranId, $mejaId)
    {
        $restoran = $this->restoranModel->find($restoranId);
        $meja = $this->mejaModel->find($mejaId);
        
        if (!$restoran || !$meja || $meja['restoran_id'] != $restoranId) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        // Generate menu URL with meja parameter
        $menuUrl = base_url("customer/menu/{$restoranId}/meja/{$mejaId}");

        // Create QR Code
        $qrCode = new QrCode($menuUrl);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        // Create writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Set filename
        $filename = 'qr_menu_' . $restoran['nama'] . '_meja_' . $meja['nomor_meja'] . '.png';
        $filename = preg_replace('/[^a-zA-Z0-9_.-]/', '_', $filename);

        // Download QR Code
        return $this->response
            ->setContentType('image/png')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($result->getString());
    }
} 