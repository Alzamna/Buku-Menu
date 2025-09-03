<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-utensils me-2"></i>Menu <?= esc($restoran['nama']) ?>
        </h1>
        <a href="<?= base_url('super-admin/dashboard') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Dashboard
        </a>
    </div>

    <!-- Restaurant Info -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-info-circle me-2"></i>Informasi Restoran
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Nama:</strong> <?= esc($restoran['nama']) ?></p>
                    <p><strong>Alamat:</strong> <?= esc($restoran['alamat']) ?></p>
                </div>
                <div class="col-md-6">
                    <p><strong>Kontak:</strong> <?= esc($restoran['kontak']) ?></p>
                    <p><strong>Total Menu:</strong> <span class="badge bg-success"><?= count($menu_list) ?></span></p>
                    <p><strong>Total Kategori:</strong> <span class="badge bg-info"><?= count($kategori_list) ?></span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu List -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Menu
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($kategori_list)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>Restoran ini belum memiliki kategori menu.
                </div>
            <?php else: ?>
                <!-- Category Tabs (sama seperti di customer/menu.php) -->
                <ul class="nav nav-pills mb-4" id="categoryTabs" role="tablist">
                    <?php foreach ($kategori_list as $index => $kategori): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" 
                                    id="tab-<?= $kategori['id'] ?>" 
                                    data-bs-toggle="pill" 
                                    data-bs-target="#content-<?= $kategori['id'] ?>" 
                                    type="button" 
                                    role="tab">
                                <i class="fas fa-tag me-2"></i><?= esc($kategori['nama']) ?>
                                <span class="badge bg-primary ms-1"><?= count($menu_by_kategori[$kategori['nama']] ?? []) ?></span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <!-- Menu Content (sama seperti di customer/menu.php) -->
                <div class="tab-content" id="categoryTabContent">
                    <?php foreach ($kategori_list as $index => $kategori): ?>
                        <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" 
                             id="content-<?= $kategori['id'] ?>" 
                             role="tabpanel">
                            
                            <?php 
                            $menuInKategori = $menu_by_kategori[$kategori['nama']] ?? [];
                            if (empty($menuInKategori)): 
                            ?>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Tidak ada menu dalam kategori ini.
                                </div>
                            <?php else: ?>
                                <div class="row">
                                    <?php foreach ($menuInKategori as $menu): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <?php if ($menu['gambar']): ?>
                                                    <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                                                         class="card-img-top" 
                                                         alt="<?= esc($menu['nama']) ?>"
                                                         style="height: 200px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                                                         style="height: 200px;">
                                                        <i class="fas fa-utensils fa-3x text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= esc($menu['nama']) ?></h5>
                                                    <p class="card-text text-muted">
                                                        <?= esc($menu['deskripsi'] ?: 'Tidak ada deskripsi') ?>
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-success fw-bold">
                                                            Rp <?= number_format($menu['harga'], 0, ',', '.') ?>
                                                        </span>
                                                        <span class="badge bg-<?= $menu['stok'] > 0 ? 'success' : 'danger' ?>">
                                                            Stok: <?= $menu['stok'] ?>
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-transparent">
                                                    <small class="text-muted">
                                                        Kategori: <?= esc($menu['nama_kategori']) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Tambahkan script Bootstrap untuk tabs -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->endSection() ?>