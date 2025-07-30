<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users me-2"></i>Kelola Admin Restoran
        </h1>
        <a href="<?= base_url('super-admin/admin/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Admin
        </a>
    </div>

    <!-- Admin List -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Admin Restoran
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Restoran</th>
                            <th>Role</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($admin_list)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data admin</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($admin_list as $index => $admin): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($admin['username']) ?></strong>
                                    </td>
                                    <td><?= esc($admin['nama_restoran'] ?? 'Tidak ada restoran') ?></td>
                                    <td>
                                        <span class="badge bg-info"><?= ucfirst(str_replace('_', ' ', $admin['role'])) ?></span>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($admin['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('super-admin/admin/delete/' . $admin['id']) ?>" 
                                           class="btn btn-sm btn-danger" title="Hapus"
                                           onclick="return confirm('Yakin ingin menghapus admin ini?')">
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