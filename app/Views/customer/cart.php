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
        .cart-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        .cart-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px 20px 0 0;
            padding: 2rem;
            text-align: center;
        }
        .cart-item {
            border: 1px solid #e9ecef;
            border-radius: 15px;
            margin-bottom: 15px;
            transition: transform 0.3s ease;
        }
        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            background: #667eea;
            color: white;
            font-weight: bold;
        }
        .quantity-input {
            width: 50px;
            text-align: center;
            border: 2px solid #e9ecef;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
            </a>
            
            <div class="navbar-nav ms-auto">
                <a href="<?= base_url() ?>" class="btn btn-outline-primary">
                    <i class="fas fa-home me-2"></i>Beranda
                </a>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 100px;">
        <!-- Cart Header -->
        <div class="cart-container">
            <div class="cart-header">
                <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                <h2 class="mb-2">Keranjang Belanja</h2>
                <p class="mb-0">Total <?= count($cart) ?> item</p>
            </div>

            <div class="p-4">
                <?php if (empty($cart)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">Keranjang Belanja Kosong</h4>
                        <p class="text-muted">Belum ada item di keranjang belanja Anda</p>
                        <a href="<?= base_url() ?>" class="btn btn-primary">
                            <i class="fas fa-utensils me-2"></i>Lihat Menu
                        </a>
                    </div>
                <?php else: ?>
                    <form action="<?= base_url('customer/update-cart') ?>" method="post">
                            <?= csrf_field(); ?>
                        <?php foreach ($cart as $index => $item): ?>
                            <div class="cart-item p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <?php if ($item['gambar']): ?>
                                            <img src="<?= base_url('uploads/menu/' . $item['gambar']) ?>" 
                                                 alt="<?= $item['nama'] ?>" class="item-image">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center item-image">
                                                <i class="fas fa-utensils text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <h6 class="mb-1"><?= esc($item['nama']) ?></h6>
                                        <p class="text-success mb-0">
                                            <strong>Rp <?= number_format($item['harga'], 0, ',', '.') ?></strong>
                                        </p>
                                    </div>
                                    
                                   <div class="col-md-2">
    <div class="quantity-control d-flex align-items-center justify-content-center">
        <button type="button" class="quantity-btn btn btn-outline-secondary mx-2" onclick="decreaseQuantity(<?= $index ?>)">-</button>
                                
                                        <input type="number" name="jumlah_<?= $index ?>" class="form-control text-center quantity-input mx-2"
                                            value="<?= $item['jumlah'] ?>" min="1" style="max-width: 60px;">
                                
                                        <button type="button" class="quantity-btn btn btn-outline-secondary mx-2"
                                            onclick="increaseQuantity(<?= $index ?>)">+</button>
                                    </div>
                                </div>

                                    
                                    <div class="col-md-3">
                                        <input type="text" name="catatan_<?= $index ?>" 
                                               class="form-control" 
                                               placeholder="Catatan (opsional)"
                                               value="<?= esc($item['catatan'] ?? '') ?>">
                                    </div>
                                    
                                    <div class="col-md-1">
                                        <a href="<?= base_url('customer/remove-from-cart/' . $index) ?>" 
                                           class="btn btn-sm btn-danger" 
                                           onclick="return confirm('Yakin ingin menghapus item ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                        <?php
                            $restoranUuid = session('restoran_uuid');
                            $mejaUuid = session('meja_uuid');

                            $menuUrl = $restoranUuid
                                ? base_url('customer/menu/' . $restoranUuid . ($mejaUuid ? '/' . $mejaUuid : ''))
                                : base_url('/'); // fallback kalau session kosong
                            ?>
                        
                        <a href="<?= $menuUrl ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Lanjut Belanja
                        </a>




                                <button type="submit" class="btn btn-warning ms-2">
                                    <i class="fas fa-sync me-2"></i>Update Keranjang
                                </button>
                            </div>
                            
                            <div class="text-end">
                                <h4 class="text-success">Total: Rp <?= number_format($total, 0, ',', '.') ?></h4>
                                <a href="<?= base_url('customer/identity') ?>" class="btn btn-primary btn-lg">
                                    <i class="fas fa-credit-card me-2"></i>Checkout
                                </a>
                            </div>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function increaseQuantity(index) {
            const input = document.querySelector(`input[name="jumlah_${index}"]`);
            const currentValue = parseInt(input.value);
            input.value = currentValue + 1;
        }

        function decreaseQuantity(index) {
            const input = document.querySelector(`input[name="jumlah_${index}"]`);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
            }
        }
    </script>
</body>
</html> 