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
        .navbar { background: rgba(255,255,255,.95)!important; backdrop-filter: blur(10px); border-bottom: 1px solid rgba(17,75,54,.08); }
        .checkout-container { background: var(--surface); border-radius: 24px; margin-top: 20px; margin-bottom: 20px; box-shadow: 0 20px 40px rgba(17,75,54,.06); border: 1px solid rgba(17,75,54,.06); }
        .checkout-header { background: linear-gradient(135deg,#1a6a4c 0%,#114b36 100%); color:#fff; border-radius: 24px 24px 0 0; padding: 2rem; text-align:center; }
        .section-title { font-weight: 700; color:#102a26; display:flex; align-items:center; gap:10px; margin:0; }
        .section-title i { color: var(--coffee-green); }
        .card.shadow { border: 1px solid rgba(17,75,54,.08); border-radius: 16px; }
        .card-header { background:#fff; border-bottom: 1px dashed rgba(17,75,54,.15); }
        .order-summary { border:1px solid rgba(17,75,54,.08); border-radius:14px; margin-bottom:12px; background:#fff; transition: transform .25s ease, box-shadow .25s ease; }
        .order-summary:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(17,75,54,.08); }
        .item-image { width:64px; height:64px; object-fit: cover; border-radius: 12px; }
        .price { color: var(--coffee-green); font-weight: 700; }
        .meta { color:#6b7c75; font-size:.9rem; }
        .btn-primary { background-color: var(--coffee-green); border-color: var(--coffee-green); border-radius: 14px; padding:.9rem; }
        .btn-primary:hover, .btn-primary:focus { background-color: var(--coffee-green-600); border-color: var(--coffee-green-600); }
        .summary-row { display:flex; justify-content:space-between; margin-bottom:.5rem; }
        .summary-row strong { color:#102a26; }
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
                <a href="<?= base_url('customer/cart') ?>" class="btn btn-outline-dark">
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
                                    <h6 class="section-title"><i class="fas fa-list"></i> Ringkasan Pesanan</h6>
                                </div>
                                <div class="card-body">
                                    <?php foreach ($cart as $index => $item): ?>
                                        <div class="order-summary p-3">
                                            <div class="row align-items-center g-3">
                                                <div class="col-3 col-md-2">
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

                                                <div class="col-9 col-md-10">
                                                    <div class="d-flex justify-content-between flex-wrap gap-2">
                                                        <div>
                                                            <h6 class="mb-1"><?= esc($item['nama']) ?></h6>
                                                            <div class="meta">Jumlah: <?= $item['jumlah'] ?> x Rp <?= number_format($item['harga'], 0, ',', '.') ?></div>
                                                            <?php if ($item['catatan']): ?>
                                                                <small class="text-info"><i class="fas fa-sticky-note me-1"></i><?= esc($item['catatan']) ?></small>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="price">Rp <?= number_format($item['harga'] * $item['jumlah'], 0, ',', '.') ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Delivery Method -->
                            <div class="card shadow mb-4">
                                <div class="card-header">
                                    <h6 class="section-title"><i class="fas fa-truck"></i> Metode Pengambilan</h6>
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
                                    <h6 class="section-title"><i class="fas fa-calculator"></i> Ringkasan Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    <div class="summary-row"><span>Subtotal</span><span>Rp <?= number_format($total, 0, ',', '.') ?></span></div>
                                    <div class="summary-row"><span>PPN (11%)</span><span>Rp <?= number_format($total * 0.11, 0, ',', '.') ?></span></div>
                                    <hr>
                                    <div class="summary-row mb-3"><strong>Total</strong><strong class="price">Rp <?= number_format($total * 1.11, 0, ',', '.') ?></strong></div>

                                    <input type="hidden" name="restoran_id"
                                        value="<?= session()->get('restoran_id') ?? 1 ?>">

                                    <button type="submit" class="btn btn-primary w-100 btn-lg"><i class="fas fa-credit-card me-2"></i>Buat Pesanan</button>

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
                            <div class="row pt-3">
                                <div class="col-12">
                                    <div class="card shadow mb-4">
                                        <div class="card-header">
                                            <h6 class="section-title"><i class="fas fa-user"></i> Informasi Pelanggan</h6>
                                        </div>
                                        <div class="card-body">
                                            <p><strong>Nama:</strong> <?= esc($identitas['nama']) ?></p>
                                            <p><strong>No HP:</strong> <?= esc($identitas['telepon']) ?></p>
                                        </div>
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