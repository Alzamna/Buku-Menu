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
        $restoran = $this->restoranModel->find($restoranId);
        
        if (!$restoran) {
            return redirect()->back()->with('error', 'Restoran tidak ditemukan!');
        }
        
        // Generate UUID if it doesn't exist
        if (empty($restoran['uuid'])) {
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
            $this->restoranModel->update($restoranId, ['uuid' => $uuid]);
            $restoran['uuid'] = $uuid;
        }
        
        return redirect()->to("admin/qrcode/display/{$restoran['uuid']}");
    }

    public function generate($restoranUuid, $mejaUuid = null)
    {
        $restoran = $this->restoranModel->findByUuid($restoranUuid);
        
        if (!$restoran) {
            return $this->response->setJSON(['error' => 'Restoran tidak ditemukan']);
        }

        // Generate menu URL with meja parameter
        if ($mejaUuid) {
            $menuUrl = base_url("customer/menu/{$restoranUuid}/meja/{$mejaUuid}");
        } else {
            $menuUrl = base_url("customer/menu/{$restoranUuid}");
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

    public function download($restoranUuid, $mejaUuid = null)
    {
        $restoran = $this->restoranModel->findByUuid($restoranUuid);
        
        if (!$restoran) {
            return redirect()->back()->with('error', 'Restoran tidak ditemukan!');
        }

        $meja = null;
        if ($mejaUuid) {
            $meja = $this->mejaModel->findByUuid($mejaUuid);
            if (!$meja || $meja['restoran_id'] != $restoran['id']) {
                return redirect()->back()->with('error', 'Meja tidak ditemukan!');
            }
        }

        // Generate menu URL with meja parameter
        if ($mejaUuid) {
            $menuUrl = base_url("customer/menu/{$restoranUuid}/meja/{$mejaUuid}");
        } else {
            $menuUrl = base_url("customer/menu/{$restoranUuid}");
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

    public function display($restoranUuid)
    {
        $restoran = $this->restoranModel->findByUuid($restoranUuid);
        
        if (!$restoran) {
            return redirect()->back()->with('error', 'Restoran tidak ditemukan!');
        }

        // Get all meja for this restoran
        $mejaList = $this->mejaModel->getMejaByRestoranUuid($restoranUuid);
        
        // Generate UUIDs for meja that don't have them
        helper('uuid');
        foreach ($mejaList as &$meja) {
            if (empty($meja['uuid'])) {
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
                $this->mejaModel->update($meja['id'], ['uuid' => $uuid]);
                $meja['uuid'] = $uuid;
            }
        }

        $data = [
            'title' => 'QR Code Menu - ' . $restoran['nama'],
            'restoran' => $restoran,
            'meja_list' => $mejaList,
        ];

        return view('admin/qrcode/display', $data);
    }

    public function generateMeja($restoranUuid, $mejaUuid)
    {
        $restoran = $this->restoranModel->findByUuid($restoranUuid);
        $meja = $this->mejaModel->findByUuid($mejaUuid);
        
        if (!$restoran || !$meja || $meja['restoran_id'] != $restoran['id']) {
            return $this->response->setJSON(['error' => 'Data tidak ditemukan']);
        }

        // Generate menu URL with meja parameter
        $menuUrl = base_url("customer/menu/{$restoranUuid}/meja/{$mejaUuid}");

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

    public function downloadMeja($restoranUuid, $mejaUuid)
    {
        $restoran = $this->restoranModel->findByUuid($restoranUuid);
        $meja = $this->mejaModel->findByUuid($mejaUuid);
        
        if (!$restoran || !$meja || $meja['restoran_id'] != $restoran['id']) {
            return redirect()->back()->with('error', 'Data tidak ditemukan!');
        }

        // Generate menu URL with meja parameter
        $menuUrl = base_url("customer/menu/{$restoranUuid}/meja/{$mejaUuid}");

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