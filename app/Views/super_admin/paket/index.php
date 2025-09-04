<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa-solid fa-star me-2"></i><?= $title; ?>
        </h1>
        <a href="<?= base_url('super-admin/paket/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Paket
        </a>
    </div>

    <!-- Admin List -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Paket Restoran
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Harga</th>
                            <th>Durasi</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($paket_list)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data paket</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($paket_list as $index => $paket): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($paket['nama']) ?></strong>
                                    </td>
                                    <td>Rp. <?= esc(number_format($paket['harga'], 0, ',', '.')) ?></td>
                                    <td>
                                        <span class="badge bg-info"><?= $paket['durasi']; ?> Bulan</span>
                                    </td>
                                    <td><?= $paket['deskripsi']; ?></td>
                                    <td>
                                        <a href="<?= base_url('super-admin/paket/edit/' . $paket['id']) ?>"
                                            class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('super-admin/paket/delete/' . $paket['id']) ?>"
                                            class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
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