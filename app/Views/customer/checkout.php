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

        .checkout-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .checkout-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            text-align: center;
        }

        .order-summary {
            border: 1px solid #e9ecef;
            border-radius: 15px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }

        .order-summary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-credit-card me-2"></i>Checkout
            </a>

            <div class="navbar-nav ms-auto">
                <a href="<?= base_url('customer/cart') ?>" class="btn btn-outline-primary">
                    <i class="fas fa-shopping-cart me-2"></i>Keranjang
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <!-- Checkout Header -->
        <div class="checkout-container">
            <div class="checkout-header">
                <i class="fas fa-credit-card fa-3x mb-3"></i>
                <h2 class="mb-2">Checkout</h2>
                <p class="mb-0">Lengkapi pesanan Anda</p>
            </div>

            <div class="p-4">
                <form action="<?= base_url('customer/checkout') ?>" method="post">
                    <?= csrf_field(); ?>
                    <div class="row">
                        <div class="col-md-8">
                            <!-- Order Summary -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-list me-2"></i>Ringkasan Pesanan
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($cart as $index => $item): ?>
                                        <div class="order-summary p-3">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <?php if ($item['gambar']): ?>
                                                        <img src="<?= base_url('uploads/menu/' . $item['gambar']) ?>"
                                                            alt="<?= $item['nama'] ?>" class="item-image">
                                                    <?php else: ?>
                                                        <div
                                                            class="bg-light d-flex align-items-center justify-content-center item-image">
                                                            <i class="fas fa-utensils text-muted"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="col-md-4">
                                                    <h6 class="mb-1"><?= esc($item['nama']) ?></h6>
                                                    <p class="text-muted mb-0">
                                                        Jumlah: <?= $item['jumlah'] ?> x Rp
                                                        <?= number_format($item['harga'], 0, ',', '.') ?>
                                                    </p>
                                                    <?php if ($item['catatan']): ?>
                                                        <small class="text-info">
                                                            <i class="fas fa-sticky-note me-1"></i><?= esc($item['catatan']) ?>
                                                        </small>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="col-md-3">
                                                    <p class="text-success mb-0">
                                                        <strong>Rp
                                                            <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></strong>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Delivery Method -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-truck me-2"></i>Metode Pengambilan
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="metode" id="dine_in"
                                                    value="dine_in" checked>
                                                <label class="form-check-label" for="dine_in">
                                                    <i class="fas fa-utensils me-2"></i>Dine In
                                                </label>
                                                <small class="form-text text-muted">Makan di tempat</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="metode"
                                                    id="take_away" value="take_away">
                                                <label class="form-check-label" for="take_away">
                                                    <i class="fas fa-shopping-bag me-2"></i>Take Away
                                                </label>
                                                <small class="form-text text-muted">Bawa pulang</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <!-- Payment Summary -->
                            <div class="card shadow">
                                <div class="card-header">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        <i class="fas fa-calculator me-2"></i>Ringkasan Pembayaran
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Subtotal:</span>
                                        <span>Rp <?= number_format($total, 0, ',', '.') ?></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>PPN (11%):</span>
                                        <span>Rp <?= number_format($total * 0.11, 0, ',', '.') ?></span>
                                    </div>
                                    <hr>
                                    <div class="d-flex justify-content-between mb-3">
                                        <strong>Total:</strong>
                                        <strong class="text-success">Rp
                                            <?= number_format($total * 1.11, 0, ',', '.') ?></strong>
                                    </div>

                                    <input type="hidden" name="restoran_id"
                                        value="<?= session()->get('restoran_id') ?? 1 ?>">

                                    <button type="submit" class="btn btn-primary w-100 btn-lg">
                                        <i class="fas fa-credit-card me-2"></i>Buat Pesanan
                                    </button>

                                    <div class="text-center mt-3">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Pembayaran dilakukan di kasir
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php $identitas = session()->get('identitas'); ?>
                        <?php if (!empty($identitas)): ?>

                            <div class="px-4 pt-3">
                                <div class="card shadow mb-4">
                                    <div class="card-header bg-light">
                                        <h6 class="m-0 font-weight-bold text-primary">
                                            <i class="fas fa-user me-2"></i>Informasi Pelanggan
                                        </h6>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Nama:</strong> <?= esc($identitas['nama']) ?></p>
                                        <p><strong>No HP:</strong> <?= esc($identitas['telepon']) ?></p>
                                       
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>


                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>