<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Meja
        </h1>
        <a href="<?= base_url('admin/meja') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Alert messages -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-store me-2"></i><?= $restoran['nama'] ?>
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/meja/update/' . $meja['id']) ?>" method="post">
                        <?= csrf_field(); ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nomor_meja" class="form-label">
                                        <i class="fas fa-table me-2"></i>Nomor Meja <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control <?= session()->getFlashdata('errors.nomor_meja') ? 'is-invalid' : '' ?>" 
                                           id="nomor_meja" 
                                           name="nomor_meja" 
                                           value="<?= old('nomor_meja', $meja['nomor_meja']) ?>" 
                                           placeholder="Contoh: 1, A1, VIP1" 
                                           required>
                                    <?php if (session()->getFlashdata('errors.nomor_meja')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.nomor_meja') ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-text">
                                        Masukkan nomor atau kode meja (maksimal 50 karakter)
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">
                                        <i class="fas fa-toggle-on me-2"></i>Status <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select <?= session()->getFlashdata('errors.status') ? 'is-invalid' : '' ?>" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="aktif" <?= old('status', $meja['status']) == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="nonaktif" <?= old('status', $meja['status']) == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                    </select>
                                    <?php if (session()->getFlashdata('errors.status')): ?>
                                        <div class="invalid-feedback">
                                            <?= session()->getFlashdata('errors.status') ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="form-text">
                                        Status meja untuk menentukan apakah QR code dapat digunakan
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">
                                <i class="fas fa-info-circle me-2"></i>Keterangan
                            </label>
                            <textarea class="form-control <?= session()->getFlashdata('errors.keterangan') ? 'is-invalid' : '' ?>" 
                                      id="keterangan" 
                                      name="keterangan" 
                                      rows="3" 
                                      placeholder="Contoh: Meja di dekat jendela, Meja untuk 4 orang"><?= old('keterangan', $meja['keterangan']) ?></textarea>
                            <?php if (session()->getFlashdata('errors.keterangan')): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors.keterangan') ?>
                                </div>
                            <?php endif; ?>
                            <div class="form-text">
                                Keterangan tambahan untuk meja ini (opsional)
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong><br>
                                    • QR code akan tetap sama meskipun data meja diubah<br>
                                    • Jika status diubah menjadi nonaktif, QR code tidak dapat digunakan<br>
                                    • Perubahan akan langsung terlihat di halaman QR code
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Perhatian:</strong><br>
                                    • Jika mengubah nomor meja, pastikan QR code yang sudah dicetak diganti<br>
                                    • Meja yang nonaktif tidak akan muncul di halaman QR code
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/meja') ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Meja
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 