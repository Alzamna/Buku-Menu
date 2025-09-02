<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-utensils me-2"></i>Kelola Menu
        </h1>
        <a href="<?= base_url('admin/menu/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Menu
        </a>
    </div>

    <!-- Menu List -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Menu
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($menu_list)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data menu</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($menu_list as $index => $menu): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <?php if ($menu['gambar']): ?>
                                            <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" alt="<?= $menu['nama'] ?>"
                                                class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-utensils text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= esc($menu['nama']) ?></strong>
                                        <?php if ($menu['deskripsi']): ?>
                                            <br><small class="text-muted"><?= esc($menu['deskripsi']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?= esc($menu['nama_kategori']) ?></span>
                                    </td>
                                    <td>
                                        <strong class="text-success">Rp
                                            <?= number_format($menu['harga'], 0, ',', '.') ?></strong>
                                    </td>
                                    <td>
                                        <?php if ($menu['stok'] > 0): ?>
                                            <span class="badge bg-success"><?= $menu['stok'] ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/menu/edit/' . $menu['id']) ?>"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/menu/delete/' . $menu['id']) ?>"
                                                class="btn btn-sm btn-danger" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus menu ini?')">
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