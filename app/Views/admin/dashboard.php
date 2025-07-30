<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Admin Restoran
        </h1>
    </div>

    <!-- Welcome Card -->
    <div class="card shadow mb-4">
        <div class="card-body text-center">
            <i class="fas fa-store fa-3x text-primary mb-3"></i>
            <h4>Selamat Datang, <?= session()->get('username') ?>!</h4>
            <p class="text-muted">Anda mengelola restoran: <strong><?= $restoran['nama'] ?></strong></p>
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="border-end">
                        <h5 class="text-primary"><?= $total_kategori ?></h5>
                        <small class="text-muted">Kategori Menu</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="border-end">
                        <h5 class="text-success"><?= $total_menu ?></h5>
                        <small class="text-muted">Total Menu</small>
                    </div>
                </div>
                <div class="col-md-4">
                    <h5 class="text-warning"><?= $total_pesanan ?></h5>
                    <small class="text-muted">Total Pesanan</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Kategori Menu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_kategori ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-tags fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Menu
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_menu ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pesanan
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_pesanan ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Pesanan Pending
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pesanan_pending ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus-circle me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= base_url('admin/kategori/create') ?>" class="btn btn-primary">
                            <i class="fas fa-tags me-2"></i>Tambah Kategori
                        </a>
                        <a href="<?= base_url('admin/menu/create') ?>" class="btn btn-success">
                            <i class="fas fa-utensils me-2"></i>Tambah Menu
                        </a>
                        <a href="<?= base_url('admin/pesanan') ?>" class="btn btn-warning">
                            <i class="fas fa-shopping-cart me-2"></i>Lihat Pesanan
                        </a>
                        <a href="<?= base_url('admin/qrcode/display/' . session()->get('restoran_id')) ?>" class="btn btn-info">
                            <i class="fas fa-qrcode me-2"></i>QR Code Menu
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Restoran
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h6><i class="fas fa-store me-2"></i><?= $restoran['nama'] ?></h6>
                            <p class="text-muted mb-2">
                                <i class="fas fa-map-marker-alt me-2"></i><?= $restoran['alamat'] ?>
                            </p>
                            <p class="text-muted mb-3">
                                <i class="fas fa-phone me-2"></i><?= $restoran['kontak'] ?>
                            </p>
                        </div>
                    </div>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Terakhir diperbarui: <?= date('d/m/Y H:i') ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="card shadow mt-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-shopping-cart me-2"></i>Pesanan Terbaru
            </h6>
        </div>
        <div class="card-body">
            <div class="text-center">
                <a href="<?= base_url('admin/pesanan') ?>" class="btn btn-primary">
                    <i class="fas fa-eye me-2"></i>Lihat Semua Pesanan
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 