<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tachometer-alt me-2"></i>Dashboard Super Admin
        </h1>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Restoran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_restoran ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-store fa-2x text-gray-300"></i>
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
                                Total Admin Restoran
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total_admin ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Restoran List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-store me-2"></i>Daftar Restoran
            </h6>
            <a href="<?= base_url('super-admin/restoran/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-1"></i>Tambah Restoran
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Restoran</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Kategori</th>
                            <th>Menu</th>
                            <th>Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($restoran_list)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data restoran</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($restoran_list as $index => $restoran): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($restoran['nama']) ?></strong>
                                    </td>
                                    <td><?= esc($restoran['alamat']) ?></td>
                                    <td><?= esc($restoran['kontak']) ?></td>
                                    <td>
                                        <span class="badge bg-info"><?= $restoran['jumlah_kategori'] ?? 0 ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><?= $restoran['jumlah_menu'] ?? 0 ?></span>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning"><?= $restoran['jumlah_pesanan'] ?? 0 ?></span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('super-admin/restoran/edit/' . $restoran['id']) ?>"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('super-admin/restoran/delete/' . $restoran['id']) ?>"
                                                class="btn btn-sm btn-danger" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus restoran ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <!-- View Menu Button -->
                                           <a href="<?= base_url('super-admin/restoran/menu/' . $restoran['id']) ?>" class="btn btn-sm btn-info"
                                            title="Lihat Menu">
                                            <i class="fas fa-search"></i>
                                        </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
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
                        <a href="<?= base_url('super-admin/restoran/create') ?>" class="btn btn-primary">
                            <i class="fas fa-store me-2"></i>Tambah Restoran Baru
                        </a>
                        <a href="<?= base_url('super-admin/admin/create') ?>" class="btn btn-success">
                            <i class="fas fa-user-plus me-2"></i>Tambah Admin Restoran
                        </a>
                        <a href="<?= base_url('super-admin/restoran') ?>" class="btn btn-info">
                            <i class="fas fa-list me-2"></i>Lihat Semua Restoran
                        </a>
                        <a href="<?= base_url('super-admin/admin') ?>" class="btn btn-warning">
                            <i class="fas fa-users me-2"></i>Kelola Admin
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Sistem Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary"><?= $total_restoran ?></h4>
                                <small class="text-muted">Restoran Terdaftar</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success"><?= $total_admin ?></h4>
                            <small class="text-muted">Admin Aktif</small>
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
</div>
<?= $this->endSection() ?>