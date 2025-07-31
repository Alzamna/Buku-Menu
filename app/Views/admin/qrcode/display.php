<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-qrcode me-2"></i>QR Code Menu per Meja
        </h1>
        <div>
            <a href="<?= base_url('admin/meja') ?>" class="btn btn-info me-2">
                <i class="fas fa-table me-2"></i>Kelola Meja
            </a>
            <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

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
                            <p class="text-muted">Silakan tambahkan meja terlebih dahulu untuk membuat QR code</p>
                            <a href="<?= base_url('admin/meja/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Tambah Meja
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="row">
                            <?php foreach ($meja_list as $meja): ?>
                                <div class="col-md-4 col-lg-3 mb-4">
                                    <div class="card border-primary h-100">
                                        <div class="card-header bg-primary text-white text-center">
                                            <h6 class="mb-0">
                                                <i class="fas fa-table me-2"></i>Meja <?= $meja['nomor_meja'] ?>
                                            </h6>
                                        </div>
                                        <div class="card-body text-center">
                                            <div class="mb-3">
                                                <img src="<?= base_url('admin/qrcode/generate-meja/' . $restoran['id'] . '/' . $meja['id']) ?>" 
                                                     alt="QR Code Meja <?= $meja['nomor_meja'] ?>" 
                                                     class="img-fluid" 
                                                     style="max-width: 200px;">
                                            </div>
                                            <div class="mb-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-link me-1"></i>
                                                    <?= base_url('customer/menu/' . $restoran['id'] . '/meja/' . $meja['id']) ?>
                                                </small>
                                            </div>
                                            <div class="d-grid gap-2">
                                                <a href="<?= base_url('admin/qrcode/download-meja/' . $restoran['id'] . '/' . $meja['id']) ?>" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-download me-2"></i>Download QR Code
                                                </a>
                                                <button class="btn btn-outline-primary btn-sm" 
                                                        onclick="copyLink('<?= base_url('customer/menu/' . $restoran['id'] . '/meja/' . $meja['id']) ?>')">
                                                    <i class="fas fa-copy me-2"></i>Copy Link
                                                </button>
                                                <a href="<?= base_url('customer/menu/' . $restoran['id'] . '/meja/' . $meja['id']) ?>" 
                                                   target="_blank" 
                                                   class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-external-link-alt me-2"></i>Preview
                                                </a>
                                            </div>
                                        </div>
                                        <?php if ($meja['keterangan']): ?>
                                            <div class="card-footer bg-light">
                                                <small class="text-muted">
                                                    <i class="fas fa-info-circle me-1"></i><?= $meja['keterangan'] ?>
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="fas fa-print fa-2x text-primary mb-2"></i>
                                    <h6>Print QR Code</h6>
                                    <p class="text-muted small">Cetak QR Code untuk ditempel di setiap meja</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="fas fa-share fa-2x text-success mb-2"></i>
                                    <h6>Share Link</h6>
                                    <p class="text-muted small">Bagikan link menu ke pelanggan</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <i class="fas fa-eye fa-2x text-info mb-2"></i>
                                    <h6>Preview Menu</h6>
                                    <p class="text-muted small">Lihat tampilan menu pelanggan</p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyLink(link) {
    const textArea = document.createElement('textarea');
    textArea.value = link;
    document.body.appendChild(textArea);
    textArea.select();
    
    try {
        document.execCommand('copy');
        alert('Link berhasil disalin ke clipboard!');
    } catch (err) {
        console.error('Gagal menyalin link: ', err);
        alert('Gagal menyalin link. Silakan salin manual.');
    }
    
    document.body.removeChild(textArea);
}
</script>
<?= $this->endSection() ?> 