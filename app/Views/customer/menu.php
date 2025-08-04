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
        .menu-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .restaurant-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            text-align: center;
        }
        .category-tabs {
            background: #f8f9fa;
            border-radius: 0;
            padding: 1rem;
        }
        .nav-pills .nav-link {
            border-radius: 25px;
            margin: 0 5px;
            color: #6c757d;
            border: 2px solid transparent;
        }
        .nav-pills .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
        }
        .menu-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
        .menu-card:hover {
            transform: translateY(-5px);
        }
        .menu-image {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .menu-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #28a745;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: none;
            background: #667eea;
            color: white;
            font-weight: bold;
        }

        .btn:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }
        .form-control:disabled {
            background-color: #e9ecef !important;
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }
        .quantity-btn.disabled {
            background: #6c757d !important;
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }
        textarea:disabled {
            background-color: #e9ecef !important;
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }
        .menu-card.disabled {
            opacity: 0.6 !important;
            filter: grayscale(30%) !important;
            pointer-events: none;
        }
        .menu-card.disabled .card-body {
            background-color: #f8f9fa;
        }
        .menu-card.disabled .card-title {
            color: #6c757d;
        }
        .menu-card.disabled .card-text {
            color: #adb5bd;
        }
        .menu-card.disabled .menu-price {
            color: #6c757d;
        }
        .menu-card.disabled .menu-image {
            filter: grayscale(50%);
        }
        .menu-card.disabled .card-img-top {
            filter: grayscale(50%);
        }
        .menu-card.disabled .bg-light {
            filter: grayscale(50%);
        }
        .quantity-input {
            width: 50px;
            text-align: center;
            border: 2px solid #e9ecef;
            border-radius: 10px;
        }
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils me-2"></i><?= $restoran['nama'] ?>
            </a>
            
            <div class="navbar-nav ms-auto">
                <a href="<?= base_url('customer/cart') ?>" class="btn btn-primary position-relative">
                    <i class="fas fa-shopping-cart me-2"></i>Keranjang
                    <?php 
                    $cart = session()->get('cart') ?? [];
                    $cartCount = count($cart);
                    if ($cartCount > 0): 
                    ?>
                        <span class="cart-badge"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <!-- Alert messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <!-- Restaurant Header -->
        <div class="menu-container">
            <div class="restaurant-header">
                <i class="fas fa-store fa-3x mb-3"></i>
                <h2 class="mb-2"><?= $restoran['nama'] ?></h2>
                <?php if ($meja): ?>
                    <div class="alert alert-light alert-dismissible fade show mb-3" role="alert">
                        <i class="fas fa-table me-2"></i>
                        <strong>Meja <?= $meja['nomor_meja'] ?></strong>
                        <?php if ($meja['keterangan']): ?>
                            - <?= $meja['keterangan'] ?>
                        <?php endif; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                <p class="mb-2">
                    <i class="fas fa-map-marker-alt me-2"></i><?= $restoran['alamat'] ?>
                </p>
                <p class="mb-0">
                    <i class="fas fa-phone me-2"></i><?= $restoran['kontak'] ?>
                </p>
            </div>

            <!-- Category Tabs -->
            <div class="category-tabs">
                <ul class="nav nav-pills justify-content-center" id="categoryTabs" role="tablist">
                    <?php foreach ($kategori_list as $index => $kategori): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" 
                                    id="tab-<?= $kategori['id'] ?>" 
                                    data-bs-toggle="pill" 
                                    data-bs-target="#content-<?= $kategori['id'] ?>" 
                                    type="button" 
                                    role="tab">
                                <i class="fas fa-tag me-2"></i><?= $kategori['nama'] ?>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Menu Content -->
            <div class="tab-content p-4" id="categoryTabContent">
                <?php foreach ($kategori_list as $index => $kategori): ?>
                    <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" 
                         id="content-<?= $kategori['id'] ?>" 
                         role="tabpanel">
                        
                        <div class="row">
                            <?php 
                            $menuInKategori = $menu_by_kategori[$kategori['nama']] ?? [];
                            if (empty($menuInKategori)): 
                            ?>
                                <div class="col-12 text-center">
                                    <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada menu dalam kategori ini</h5>
                                </div>
                            <?php else: ?>
                                <?php foreach ($menuInKategori as $menu): ?>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card menu-card <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>" style="position: relative;">
                                            <?php if ($menu['stok'] <= 0): ?>
                                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                                                     style="background: rgba(0,0,0,0.1); z-index: 10; border-radius: 15px; pointer-events: none;">
                                                    <div class="bg-danger text-white px-3 py-2 rounded-pill fw-bold">
                                                        <i class="fas fa-times-circle me-2"></i>HABIS
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($menu['gambar']): ?>
                                                <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                                                     class="card-img-top menu-image" 
                                                     alt="<?= $menu['nama'] ?>">
                                            <?php else: ?>
                                                <div class="card-img-top menu-image bg-light d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-utensils fa-3x text-muted"></i>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="card-body">
                                                <h5 class="card-title"><?= $menu['nama'] ?></h5>
                                                <p class="card-text text-muted">
                                                    <?= $menu['deskripsi'] ?: 'Tidak ada deskripsi' ?>
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <span class="menu-price">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></span>
                                                    <?php if ($menu['stok'] > 0): ?>
                                                        <span class="badge bg-success">Stok: <?= $menu['stok'] ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger">Habis</span>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <form action="<?= base_url('customer/add-to-cart') ?>" method="post">
                                                        <?= csrf_field(); ?>
                                                    <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Jumlah:</label>
                                                        <div class="quantity-control">
                                                            <button type="button" class="quantity-btn <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>" 
                                                                    onclick="<?= $menu['stok'] > 0 ? 'decreaseQuantity(' . $menu['id'] . ')' : '' ?>" 
                                                                    <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                                                -
                                                            </button>
                                                            <input type="number" name="jumlah" id="quantity-<?= $menu['id'] ?>" 
                                                                   class="form-control quantity-input" value="1" min="1" max="<?= $menu['stok'] ?>"
                                                                   <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                                            <button type="button" class="quantity-btn <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>" 
                                                                    onclick="<?= $menu['stok'] > 0 ? 'increaseQuantity(' . $menu['id'] . ', ' . $menu['stok'] . ')' : '' ?>" 
                                                                    <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                                                +
                                                            </button>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Catatan (opsional):</label>
                                                        <textarea name="catatan" class="form-control" rows="2" 
                                                                  placeholder="Contoh: Tidak pedas, tambah sayur, dll"
                                                                  <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>></textarea>
                                                    </div>
                                                    
                                                    <button type="submit" class="btn w-100 <?= $menu['stok'] > 0 ? 'btn-primary' : 'btn-secondary' ?>" 
                                                            <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                                        <i class="fas fa-plus me-2"></i>
                                                        <?= $menu['stok'] > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' ?>
                                                    </button>
                                                    
                                                    <?php if ($menu['stok'] <= 0): ?>
                                                        <div class="text-center mt-2">
                                                            <small class="text-muted">
                                                                <i class="fas fa-info-circle me-1"></i>
                                                                Menu ini sedang tidak tersedia
                                                            </small>
                                                        </div>
                                                    <?php endif; ?>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function increaseQuantity(menuId, maxStock) {
            const input = document.getElementById('quantity-' + menuId);
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
            }
        }

        function decreaseQuantity(menuId) {
            const input = document.getElementById('quantity-' + menuId);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>
</body>
</html> 