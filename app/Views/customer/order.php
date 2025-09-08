<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root { --coffee-green:#114b36; --coffee-green-600:#0d3a2a; --surface:#ffffff; }
        body {
            background: radial-gradient(1200px 600px at 20% -10%, #e7f1eb 0%, transparent 60%),
                        radial-gradient(1200px 600px at 120% 110%, #e7f1eb 0%, transparent 60%),
                        #f9fbf9;
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(17,75,54,.08);
        }

        .order-container {
            background: var(--surface);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            margin-top: 20px;
            margin-bottom: 20px;
            box-shadow: 0 20px 40px rgba(17,75,54,.06);
            border: 1px solid rgba(17,75,54,.06);
        }

        .order-header {
            background: linear-gradient(135deg,#1a6a4c 0%,#114b36 100%);
            color: white;
            border-radius: 24px 24px 0 0;
            padding: 2rem;
            text-align: center;
        }

        .card.shadow { border: 1px solid rgba(17,75,54,.08); border-radius: 16px; }
        .card-header { background:#fff; border-bottom: 1px dashed rgba(17,75,54,.15); }
        .section-title { font-weight: 700; color:#102a26; display:flex; align-items:center; gap:10px; margin:0; }
        .section-title i { color: var(--coffee-green); }

        .order-item {
            border: 1px solid rgba(17,75,54,.08);
            border-radius: 14px;
            margin-bottom: 12px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            background:#fff;
        }

        .order-item:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(17,75,54,.08); }

        .item-image {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 12px;
        }

        .price { color: var(--coffee-green); font-weight: 700; }
        .btn-primary { background-color: var(--coffee-green); border-color: var(--coffee-green); }
        .btn-primary:hover, .btn-primary:focus { background-color: var(--coffee-green-600); border-color: var(--coffee-green-600); }

        .success-animation {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 20px;">
        <!-- Order Success Header -->
        <div class="order-container">
            <div class="order-header">
                <i class="fas fa-check-circle fa-3x mb-3 success-animation"></i>
                <h2 class="mb-2">Pesanan Berhasil!</h2>
                <p class="mb-0">Terima kasih telah memesan di <?= esc($restoran['nama']) ?></p>
            </div>

            <div class="p-4">
                <div class="row">
                    <div class="col-md-8">
                        <!-- Order Details -->
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <h6 class="section-title"><i class="fas fa-info-circle"></i> Detail Pesanan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>ID Customer:</strong></td>
                                                <td>#<?= $pesanan['kode_unik'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Restoran:</strong></td>
                                                <td><?= esc($restoran['nama']) ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Metode:</strong></td>
                                                <td>
                                                    <?php if ($pesanan['metode'] === 'dine_in'): ?>
                                                        <span class="badge bg-dark">Dine In</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">Take Away</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status:</strong></td>
                                                <td>
                                                    <?php
                                                    $statusClass = '';
                                                    $statusText = '';
                                                    switch ($pesanan['status']) {
                                                        case 'pending':
                                                            $statusClass = 'bg-warning';
                                                            $statusText = 'Proses';
                                                            break;
                                                        case 'confirmed':
                                                            $statusClass = 'bg-info';
                                                            $statusText = 'Antar';
                                                            break;
                                                        case 'completed':
                                                            $statusClass = 'bg-success';
                                                            $statusText = 'Selesai';
                                                            break;
                                                        case 'cancelled':
                                                            $statusClass = 'bg-danger';
                                                            $statusText = 'Dibatalkan';
                                                            break;
                                                    }
                                                    ?>
                                                    <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Waktu Pesan:</strong></td>
                                                <td><?= date('d/m/Y H:i', strtotime($pesanan['waktu_pesan'])) ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Subtotal:</strong></td>
                                                <td>Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>PPN (11%):</strong></td>
                                                <td>Rp <?= number_format($pesanan['total'] * 0.11, 0, ',', '.') ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total:</strong></td>
                                                <td><strong class="price">Rp <?= number_format($pesanan['total'] * 1.11, 0, ',', '.') ?></strong></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($pesanan['nama']) || !empty($pesanan['telepon'])): ?>
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h6 class="section-title"><i class="fas fa-user"></i> Informasi Pelanggan</h6>
                                </div>
                                <div class="card-body">
                                    <p><strong>Nama:</strong> <?= esc($pesanan['nama']) ?></p>
                                    <p><strong>No HP:</strong> <?= esc($pesanan['telepon']) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Order Items -->
                        <div class="card shadow">
                            <div class="card-header">
                                <h6 class="section-title"><i class="fas fa-list"></i> Item Pesanan</h6>
                            </div>
                            <div class="card-body">
                                <?php foreach ($detail_list as $detail): ?>
                                    <div class="order-item p-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-2">
                                                <?php if ($detail['gambar']): ?>
                                                    <img src="<?= base_url('uploads/menu/' . $detail['gambar']) ?>"
                                                        alt="<?= $detail['nama_menu'] ?>" class="item-image">
                                                <?php else: ?>
                                                    <div
                                                        class="bg-light d-flex align-items-center justify-content-center item-image">
                                                        <i class="fas fa-utensils text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-md-4">
                                                <h6 class="mb-1"><?= esc($detail['nama_menu']) ?></h6>
                                                <p class="text-muted mb-0">
                                                    Jumlah: <?= $detail['jumlah'] ?> x Rp
                                                    <?= number_format($detail['harga_satuan'], 0, ',', '.') ?>
                                                </p>
                                                <?php if ($detail['catatan']): ?>
                                                    <small class="text-info">
                                                        <i class="fas fa-sticky-note me-1"></i><?= esc($detail['catatan']) ?>
                                                    </small>
                                                <?php endif; ?>
                                            </div>

                                            <div class="col-md-3">
                                                <p class="mb-0 price">Rp <?= number_format($detail['subtotal'], 0, ',', '.') ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <!-- Instructions -->
                        <div class="card shadow">
                            <div class="card-header">
                                <h6 class="section-title"><i class="fas fa-info-circle"></i> Instruksi</h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-lightbulb me-2"></i>Langkah Selanjutnya:</h6>
                                    <ol class="mb-0">
                                        <li>Tunjukkan ID Customer (#<?= $pesanan['kode_unik'] ?>) ke kasir</li>
                                        <li>Lakukan pembayaran sesuai total yang tertera</li>
                                        <li>Tunggu pesanan Anda diproses</li>
                                        <li>Ambil pesanan sesuai metode yang dipilih</li>
                                    </ol>
                                </div>

                                <div class="alert alert-warning">
                                    <h6><i class="fas fa-exclamation-triangle me-2"></i>Perhatian:</h6>
                                    <ul class="mb-0">
                                        <li>Pesanan akan dibatalkan jika tidak dibayar dalam 15 menit</li>
                                        <li>Pastikan data pesanan sudah benar</li>
                                        <li>Simpan ID Customer untuk referensi</li>
                                    </ul>
                                </div>

                                <div class="d-grid gap-2">
                                    <?php 
                                    // Try to get restaurant and table info from session first
                                    $restoranUuid = session()->get('completion_restoran_uuid');
                                    $mejaUuid = session()->get('completion_meja_uuid');
                                    
                                    // If session data is not available, try to get from pesanan data
                                    if (!$restoranUuid && isset($restoran)) {
                                        $restoranUuid = $restoran['uuid'];
                                    }
                                    
                                    // If meja info is not available in session, try to get from pesanan data
                                    if (!$mejaUuid && isset($pesanan['meja']) && $pesanan['meja']) {
                                        // Try to find meja by nomor_meja
                                        $mejaModel = new \App\Models\MejaModel();
                                        $meja = $mejaModel->where('restoran_id', $pesanan['restoran_id'])
                                                         ->where('nomor_meja', $pesanan['meja'])
                                                         ->first();
                                        if ($meja) {
                                            $mejaUuid = $meja['uuid'];
                                        }
                                    }
                                    
                                    if ($restoranUuid) {
                                        $menuUrl = base_url("customer/menu/{$restoranUuid}");
                                        if ($mejaUuid) {
                                            $menuUrl = base_url("customer/menu/{$restoranUuid}/meja/{$mejaUuid}");
                                        }
                                    } else {
                                        $menuUrl = base_url('/');
                                    }
                                    ?>
                                    <a href="<?= $menuUrl ?>" class="btn btn-primary">
                                        <i class="fas fa-utensils me-2"></i>Pesan Lagi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Clean up session data after page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Send request to clean up session data
            fetch('<?= base_url('customer/cleanup-completion-session') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            });
        });
    </script>
</body>

</html>