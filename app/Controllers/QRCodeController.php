<?php

namespace App\Controllers;

use App\Models\RestoranModel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QRCodeController extends BaseController
{
    protected $restoranModel;

    public function __construct()
    {
        $this->restoranModel = new RestoranModel();
    }

    public function generate($restoranId)
    {
        $restoran = $this->restoranModel->find($restoranId);
        
        if (!$restoran) {
            return $this->response->setJSON(['error' => 'Restoran tidak ditemukan']);
        }

        // Generate menu URL
        $menuUrl = base_url("customer/menu/{$restoranId}");

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

    public function download($restoranId)
    {
        $restoran = $this->restoranModel->find($restoranId);
        
        if (!$restoran) {
            return redirect()->back()->with('error', 'Restoran tidak ditemukan!');
        }

        // Generate menu URL
        $menuUrl = base_url("customer/menu/{$restoranId}");

        // Create QR Code
        $qrCode = new QrCode($menuUrl);
        $qrCode->setSize(300);
        $qrCode->setMargin(10);

        // Create writer
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Set filename
        $filename = 'qr_menu_' . $restoran['nama'] . '.png';
        $filename = preg_replace('/[^a-zA-Z0-9_-]/', '_', $filename);

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

        $menuUrl = base_url("customer/menu/{$restoranId}");

        $data = [
            'title' => 'QR Code Menu - ' . $restoran['nama'],
            'restoran' => $restoran,
            'menu_url' => $menuUrl,
            'qr_code_url' => base_url("qrcode/generate/{$restoranId}"),
        ];

        return view('admin/qrcode/display', $data);
    }
} 