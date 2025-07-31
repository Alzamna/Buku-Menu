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

        .completion-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
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

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
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
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-check-circle me-2"></i>Pesanan Selesai
            </a>

            <div class="navbar-nav ms-auto">
                <a href="<?= base_url('/') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-home me-2"></i>Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <!-- Completion Header -->
        <div class="completion-container">
            <div class="completion-header">
                <i class="fas fa-check-circle fa-4x mb-3 success-animation"></i>
                <h2 class="mb-2">Pesanan Berhasil!</h2>
                <p class="mb-0">Pesanan selesai, silahkan tunggu</p>
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
                                        <h5 class="text-primary">#<?= $pesanan['id'] ?></h5>
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
                    <a href="<?= base_url('/') ?>" class="btn btn-primary btn-lg me-3">
                        <i class="fas fa-home me-2"></i>Kembali ke Beranda
                    </a>
                    <a href="<?= base_url("customer/order/{$pesanan['id']}") ?>" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-eye me-2"></i>Lihat Detail
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html> 