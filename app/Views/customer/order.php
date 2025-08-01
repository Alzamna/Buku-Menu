<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
        }

        .order-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .order-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            text-align: center;
        }

        .order-item {
            border: 1px solid #e9ecef;
            border-radius: 15px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .order-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }

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
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-check-circle me-2"></i>Pesanan Berhasil
            </a>

            <div class="navbar-nav ms-auto">
                <a href="<?= base_url() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-home me-2"></i>Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
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
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-info-circle me-2"></i>Detail Pesanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>ID Pesanan:</strong></td>
                                                <td>#<?= $pesanan['id'] ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Restoran:</strong></td>
                                                <td><?= esc($restoran['nama']) ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Metode:</strong></td>
                                                <td>
                                                    <?php if ($pesanan['metode'] === 'dine_in'): ?>
                                                        <span class="badge bg-primary">Dine In</span>
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
                                                <td><strong class="text-success">Rp
                                                        <?= number_format($pesanan['total'] * 1.11, 0, ',', '.') ?></strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (!empty($pesanan['nama']) || !empty($pesanan['telepon']) ): ?>
                            <div class="px-4 pt-3">
                                <div class="card shadow mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            <i class="fas fa-user me-2"></i>Informasi Pelanggan
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Nama:</strong> <?= esc($pesanan['nama']) ?></p>
                                        <p><strong>No HP:</strong> <?= esc($pesanan['telepon']) ?></p>
                                   
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Order Items -->
                        <div class="card shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-list me-2"></i>Item Pesanan
                                </h6>
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
                                                <p class="text-success mb-0">
                                                    <strong>Rp
                                                        <?= number_format($detail['subtotal'], 0, ',', '.') ?></strong>
                                                </p>
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
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-info-circle me-2"></i>Instruksi
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <h6><i class="fas fa-lightbulb me-2"></i>Langkah Selanjutnya:</h6>
                                    <ol class="mb-0">
                                        <li>Tunjukkan ID Pesanan (#<?= $pesanan['id'] ?>) ke kasir</li>
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
                                        <li>Simpan ID Pesanan untuk referensi</li>
                                    </ul>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="<?= base_url() ?>" class="btn btn-primary">
                                        <i class="fas fa-utensils me-2"></i>Pesan Lagi
                                    </a>
                                    <a href="<?= base_url('customer/clear-cart') ?>" class="btn btn-outline-secondary">
                                        <i class="fas fa-trash me-2"></i>Kosongkan Keranjang
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
</body>

</html>