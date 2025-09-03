<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">
        Menu Restoran: <?= esc($restoran['nama']) ?>
    </h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Menu</h6>
        </div>
        <div class="card-body">
            <?php if (empty($menus)): ?>
                <p class="text-center">Belum ada menu di restoran ini.</p>
            <?php else: ?>
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($menus as $i => $menu): ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td>
                                    <?php if (!empty($menu['gambar'])): ?>
                                        <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>"
                                            alt="Gambar <?= esc($menu['nama']) ?>" class="img-thumbnail"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                    <?php else: ?>
                                        <span class="text-muted">Tidak ada</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($menu['nama']) ?></td>
                                <td><?= esc($menu['kategori_nama']) ?></td>
                                <td>Rp <?= number_format($menu['harga'], 0, ',', '.') ?></td>
                                <td><?= $menu['stok'] ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?= base_url('super-admin/dashboard') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<?= $this->endSection() ?>