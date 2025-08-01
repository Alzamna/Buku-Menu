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
            margin: 0;
            padding: 0;
        }

        .completion-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        .completion-header {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 3rem;
            text-align: center;
        }

        .success-animation {
            animation: bounce 2s infinite;
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
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

        .order-details {
            border: 1px solid #e9ecef;
            border-radius: 15px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .order-details:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            border-radius: 25px;
        }

        .progress-container {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 2rem;
            margin: 2rem 0;
        }

        .progress-step {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .progress-step.completed {
            color: #28a745;
        }

        .progress-step.current {
            color: #007bff;
            font-weight: bold;
        }

        .progress-step.pending {
            color: #6c757d;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        .step-icon.completed {
            background: #28a745;
            color: white;
        }

        .step-icon.current {
            background: #007bff;
            color: white;
        }

        .step-icon.pending {
            background: #6c757d;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 20px;">
        <!-- Completion Header -->
        <div class="completion-container fade-in">
            <div class="completion-header">
                <i class="fas fa-check-circle fa-4x mb-3 success-animation"></i>
                <h2 class="mb-2">Pesanan Berhasil!</h2>
                <p class="mb-0">Pesanan Anda telah diterima dan sedang diproses</p>
                <?php if (isset($restoran)): ?>
                    <p class="mb-0 mt-2">
                        <i class="fas fa-store me-2"></i><?= esc($restoran['nama']) ?>
                    </p>
                    <p class="mb-0 mt-1 text-white-50">
                        <small>Nomor pesanan: #<?= $pesanan['kode_unik'] ?></small>
                    </p>
                <?php endif; ?>
            </div>

            <div class="p-4">
                <!-- Order Information -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-receipt me-2"></i>Informasi Pesanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Nomor Pesanan:</strong></p>
                                        <h5 class="text-primary">#<?= $pesanan['kode_unik'] ?></h5>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Status:</strong></p>
                                        <span class="badge bg-warning status-badge">
                                            <i class="fas fa-clock me-1"></i>Menunggu
                                        </span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Metode:</strong></p>
                                        <span class="text-muted">
                                            <?= $pesanan['metode'] == 'dine_in' ? 'Dine In' : 'Take Away' ?>
                                        </span>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Waktu Pesan:</strong></p>
                                        <span class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($pesanan['waktu_pesan'])) ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Order Details -->
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-list me-2"></i>Detail Pesanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <?php foreach ($detail_list as $detail): ?>
                                    <div class="order-details p-3">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
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
                                            <div class="col-md-4 text-end">
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
                        <!-- Payment Summary -->
                        <div class="card shadow mb-4">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-calculator me-2"></i>Ringkasan Pembayaran
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal:</span>
                                    <span>Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span>PPN (11%):</span>
                                    <span>Rp <?= number_format($pesanan['total'] * 0.11, 0, ',', '.') ?></span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-3">
                                    <strong>Total:</strong>
                                    <strong class="text-success">Rp
                                        <?= number_format($pesanan['total'] * 1.11, 0, ',', '.') ?></strong>
                                </div>

                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Pembayaran:</strong><br>
                                    Lakukan pembayaran di kasir
                                </div>
                            </div>
                        </div>

                        <!-- Progress Status -->
                        <div class="card shadow">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">
                                    <i class="fas fa-tasks me-2"></i>Status Pesanan
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="progress-container">
                                    <div class="progress-step completed">
                                        <div class="step-icon completed">
                                            <i class="fas fa-check"></i>
                                        </div>
                                        <div>
                                            <strong>Pesanan Dibuat</strong><br>
                                            <small class="text-muted">Pesanan telah diterima</small>
                                        </div>
                                    </div>

                                    <div class="progress-step current">
                                        <div class="step-icon current">
                                            <i class="fas fa-utensils"></i>
                                        </div>
                                        <div>
                                            <strong>Sedang Diproses</strong><br>
                                            <small class="text-muted">Tim kami sedang menyiapkan pesanan</small>
                                        </div>
                                    </div>

                                    <div class="progress-step pending">
                                        <div class="step-icon pending">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div>
                                            <strong>Siap Diambil</strong><br>
                                            <small class="text-muted">Pesanan siap untuk diambil</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center mt-4">
                    <?php 
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
                    <a href="<?= $menuUrl ?>" class="btn btn-primary btn-lg me-3" style="border-radius: 25px; padding: 12px 30px;">
                        <i class="fas fa-utensils me-2"></i>Kembali ke Menu
                    </a>
                    <a href="<?= base_url("customer/order/{$pesanan['kode_unik']}") ?>"
                        class="btn btn-outline-primary btn-lg" style="border-radius: 25px; padding: 12px 30px;">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
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