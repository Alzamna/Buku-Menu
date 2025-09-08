<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --coffee-green: #114b36;
            --coffee-green-600: #0d3a2a;
            --coffee-green-400: #1c6b4c;
            --surface: #ffffff;
            --surface-soft: #f1f6f3;
        }
        body {
            background: radial-gradient(1200px 600px at 20% -10%, #e7f1eb 0%, transparent 60%),
                        radial-gradient(1200px 600px at 120% 110%, #e7f1eb 0%, transparent 60%),
                        #f9fbf9;
            min-height: 100vh;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(17, 75, 54, 0.08);
        }
        .cart-container {
            background: var(--surface);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            margin-top: 20px;
            margin-bottom: 20px;
            box-shadow: 0 20px 40px rgba(17, 75, 54, 0.06);
            border: 1px solid rgba(17, 75, 54, 0.06);
        }
        .cart-header {
            background: linear-gradient(135deg, #1a6a4c 0%, #114b36 100%);
            color: white;
            border-radius: 24px 24px 0 0;
            padding: 2rem;
            text-align: center;
        }
        .cart-item {
            border: 1px solid rgba(17, 75, 54, 0.08);
            border-radius: 16px;
            margin-bottom: 12px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            background: #fff;
        }
        .cart-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(17, 75, 54, 0.08);
        }
        .item-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 12px;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: none;
            background: var(--coffee-green);
            color: white;
            font-weight: bold;
        }
        .quantity-input {
            width: 34px;
            text-align: center;
            border: none;
            background: transparent;
            border-radius: 8px;
            box-shadow: none;
            color: #0f2e26;
            font-weight: 600;
        }
        .quantity-input:focus { outline: none; box-shadow: none; }
        /* hide number input spinners */
        input[type=number]::-webkit-outer-spin-button,
        input[type=number]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        input[type=number] { -moz-appearance: textfield; appearance: textfield; }
        .meta { list-style: none; padding: 0; margin: 2px 0 0; display: flex; gap: 10px; color: #6b7c75; font-size: 0.85rem; }
        .meta i { color: #f5b301; }
        .list-order,
        .list-order-total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 600;
        }
        .list-order.line { border-bottom: 1px dashed rgba(17, 75, 54, 0.2); padding-bottom: 10px; }
        .list-order-total span { color: var(--coffee-green); font-size: 1.2rem; }
        .tf-btn.large.primary { display: inline-block; width: 100%; padding: 0.9rem 1.2rem; border-radius: 14px; background: var(--coffee-green); color: #fff; text-align: center; border: none; }
        .tf-btn.large.primary:hover { background: var(--coffee-green-600); color: #fff; }
        .btn-primary { background-color: var(--coffee-green); border-color: var(--coffee-green); }
        .btn-primary:hover, .btn-primary:focus { background-color: var(--coffee-green-600); border-color: var(--coffee-green-600); }
        .btn-outline-primary { color: var(--coffee-green); border-color: var(--coffee-green); }
        .btn-outline-primary:hover { background-color: var(--coffee-green); border-color: var(--coffee-green); }
        .btn-secondary { background-color: var(--coffee-green-400); border-color: var(--coffee-green-400); }
        .btn-secondary:hover { background-color: var(--coffee-green); border-color: var(--coffee-green); }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
            </a>
            
            
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
                        <a href="<?= base_url('customer/menu') ?>" class="btn btn-primary">
                            <i class="fas fa-utensils me-2"></i>Lihat Menu
                        </a>
                    </div>
                <?php else: ?>
                    <form action="<?= base_url('customer/update-cart') ?>" method="post">
                            <?= csrf_field(); ?>
                        <?php foreach ($cart as $index => $item): ?>
                            <div class="cart-item p-3">
                                <div class="row align-items-center g-3">
                                    <div class="col-3 col-md-2">
                                        <?php if ($item['gambar']): ?>
                                            <img src="<?= base_url('uploads/menu/' . $item['gambar']) ?>" 
                                                 alt="<?= $item['nama'] ?>" class="item-image">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center item-image">
                                                <i class="fas fa-utensils text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-9 col-md-10">
                                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                            <div>
                                                <h6 class="mb-1"><?= esc($item['nama']) ?></h6>
                                                <ul class="meta">
                                                    <li><i class="fas fa-star"></i> 4.8 <span class="text-muted">(125)</span></li>
                                                    <li>16 min</li>
                                                </ul>
                                                <div class="fw-bold mt-1" style="color: var(--coffee-green);">Rp <?= number_format($item['harga'], 0, ',', '.') ?></div>
                                            </div>
                                            <div class="quantity-control">
                                                <button type="button" class="quantity-btn" onclick="decreaseQuantity(<?= $index ?>)">-</button>
                                                <input type="number" name="jumlah_<?= $index ?>" class="form-control text-center quantity-input" value="<?= $item['jumlah'] ?>" min="1">
                                                <button type="button" class="quantity-btn" onclick="increaseQuantity(<?= $index ?>)">+</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-2 mt-2">
                                            <input type="text" name="catatan_<?= $index ?>" class="form-control" placeholder="Catatan (opsional)" value="<?= esc($item['catatan'] ?? '') ?>">
                                            <a href="<?= base_url('customer/remove-from-cart/' . $index) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus item ini?')"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <div class="mt-4">
                        <?php
                            $restoranUuid = session('restoran_uuid');
                            $mejaUuid = session('meja_uuid');

                            $menuUrl = $restoranUuid
                                ? base_url('customer/menu/' . $restoranUuid . ($mejaUuid ? '/' . $mejaUuid : ''))
                                : base_url('/'); // fallback kalau session kosong
                            ?>
                        
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="<?= $menuUrl ?>" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Lanjut Belanja</a>
                            <button type="submit" class="btn btn-warning"><i class="fas fa-sync me-2"></i>Update Keranjang</button>
                        </div>

                        <div class="mt-4 mb-3">
                            <p class="list-order line mb-2"><span>Subtotal</span><span>Rp <?= number_format($total, 0, ',', '.') ?></span></p>
                            <p class="list-order-total"><span>Total</span><span>Rp <?= number_format($total, 0, ',', '.') ?></span></p>
                            <a href="<?= base_url('customer/identity') ?>" class="tf-btn large primary">Checkout</a>
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