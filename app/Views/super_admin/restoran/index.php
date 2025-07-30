<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-store me-2"></i>Kelola Restoran
        </h1>
        <a href="<?= base_url('super-admin/restoran/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Restoran
        </a>
    </div>

    <!-- Restoran List -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Restoran
            </h6>
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
</div>
<?= $this->endSection() ?> 