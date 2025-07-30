<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-qrcode me-2"></i>QR Code Menu
        </h1>
        <a href="<?= base_url('admin/dashboard') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-store me-2"></i><?= $restoran['nama'] ?>
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="text-primary mb-3">
                                    <i class="fas fa-qrcode me-2"></i>QR Code Menu
                                </h5>
                                <div class="border rounded p-3 bg-light">
                                    <img src="<?= $qr_code_url ?>" alt="QR Code Menu" class="img-fluid" style="max-width: 300px;">
                                </div>
                                <div class="mt-3">
                                    <a href="<?= base_url('qrcode/download/' . $restoran['id']) ?>" class="btn btn-success">
                                        <i class="fas fa-download me-2"></i>Download QR Code
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h5 class="text-info mb-3">
                                    <i class="fas fa-link me-2"></i>Link Menu
                                </h5>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="<?= $menu_url ?>" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard()">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Petunjuk:</strong><br>
                                    1. Scan QR Code dengan smartphone<br>
                                    2. Atau klik link di atas untuk membuka menu<br>
                                    3. Pelanggan dapat memilih menu dan melakukan pemesanan
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-print fa-2x text-primary mb-2"></i>
                                <h6>Print QR Code</h6>
                                <p class="text-muted small">Cetak QR Code untuk ditempel di meja</p>
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
                    
                    <div class="mt-4">
                        <a href="<?= $menu_url ?>" target="_blank" class="btn btn-primary">
                            <i class="fas fa-external-link-alt me-2"></i>Preview Menu Pelanggan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard() {
    const linkInput = document.querySelector('input[readonly]');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999); // For mobile devices
    
    try {
        document.execCommand('copy');
        alert('Link berhasil disalin ke clipboard!');
    } catch (err) {
        console.error('Gagal menyalin link: ', err);
        alert('Gagal menyalin link. Silakan salin manual.');
    }
}
</script>
<?= $this->endSection() ?> 