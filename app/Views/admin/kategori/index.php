<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-tags me-2"></i>Kelola Kategori
        </h1>
        <a href="<?= base_url('admin/kategori/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Kategori
        </a>
    </div>

    <!-- Kategori List -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Kategori Menu
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Jumlah Menu</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kategori_list)): ?>
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data kategori</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kategori_list as $index => $kategori): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($kategori['nama']) ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><?= $kategori['jumlah_menu'] ?? 0 ?></span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($kategori['created_at'])) ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/kategori/edit/' . $kategori['id']) ?>" 
                                               class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/kategori/delete/' . $kategori['id']) ?>" 
                                               class="btn btn-sm btn-danger" title="Hapus"
                                               onclick="return confirm('Yakin ingin menghapus kategori ini?')">
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