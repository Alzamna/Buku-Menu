<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-table me-2"></i>Kelola Meja
        </h1>
        <div>
            <a href="<?= base_url('admin/qrcode') ?>" class="btn btn-info me-2">
                <i class="fas fa-qrcode me-2"></i>QR Code
            </a>
            <a href="<?= base_url('admin/meja/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Meja
            </a>
        </div>
    </div>

    <!-- Alert messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-store me-2"></i><?= $restoran['nama'] ?>
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (empty($meja_list)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-table fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Belum ada meja yang ditambahkan</h5>
                            <p class="text-muted">Silakan tambahkan meja untuk membuat QR code per meja</p>
                            <a href="<?= base_url('admin/meja/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Meja Pertama
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">Nomor Meja</th>
                                        <th width="30%">Keterangan</th>
                                        <th width="15%">Status</th>
                                        <th width="20%">Tanggal Dibuat</th>
                                        <th width="15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($meja_list as $meja): ?>
                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td>
                                                <strong>Meja <?= $meja['nomor_meja'] ?></strong>
                                            </td>
                                            <td>
                                                <?= $meja['keterangan'] ?: '<span class="text-muted">-</span>' ?>
                                            </td>
                                            <td>
                                                <?php if ($meja['status'] == 'aktif'): ?>
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check me-1"></i>Aktif
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-times me-1"></i>Nonaktif
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?= date('d/m/Y H:i', strtotime($meja['created_at'])) ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= base_url('admin/meja/edit/' . $meja['id']) ?>" 
                                                       class="btn btn-sm btn-warning" 
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('qrcode/download-meja/' . $restoran['uuid'] . '/' . $meja['uuid']) ?>" 
                                                       class="btn btn-sm btn-success" 
                                                       title="Download QR Code">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-danger" 
                                                            onclick="confirmDelete(<?= $meja['id'] ?>, '<?= $meja['nomor_meja'] ?>')"
                                                            title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-4">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Total Meja:</strong> <?= count($meja_list) ?> meja
                                    </div>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="<?= base_url('admin/qrcode') ?>" class="btn btn-info">
                                        <i class="fas fa-qrcode me-2"></i>Lihat Semua QR Code
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus meja <strong id="mejaNomor"></strong>?</p>
                <p class="text-muted small">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <a href="#" id="deleteButton" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>Hapus
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, nomorMeja) {
    document.getElementById('mejaNomor').textContent = nomorMeja;
    document.getElementById('deleteButton').href = '<?= base_url('admin/meja/delete/') ?>' + id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
<?= $this->endSection() ?> 