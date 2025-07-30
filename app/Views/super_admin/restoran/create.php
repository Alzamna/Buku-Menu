<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus me-2"></i>Tambah Restoran
        </h1>
        <a href="<?= base_url('super-admin/restoran') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-store me-2"></i>Form Tambah Restoran
            </h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('super-admin/restoran/create') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                <i class="fas fa-store me-2"></i>Nama Restoran <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>"
                                id="nama" name="nama" value="<?= old('nama') ?>" required>
                            <?php if (session('errors.nama')): ?>
                                <div class="invalid-feedback"><?= session('errors.nama') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kontak" class="form-label">
                                <i class="fas fa-phone me-2"></i>Kontak <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?= session('errors.kontak') ? 'is-invalid' : '' ?>"
                                id="kontak" name="kontak" value="<?= old('kontak') ?>" required>
                            <?php if (session('errors.kontak')): ?>
                                <div class="invalid-feedback"><?= session('errors.kontak') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="alamat" class="form-label">
                        <i class="fas fa-map-marker-alt me-2"></i>Alamat <span class="text-danger">*</span>
                    </label>
                    <textarea class="form-control <?= session('errors.alamat') ? 'is-invalid' : '' ?>" id="alamat"
                        name="alamat" rows="3" required><?= old('alamat') ?></textarea>
                    <?php if (session('errors.alamat')): ?>
                        <div class="invalid-feedback"><?= session('errors.alamat') ?></div>
                    <?php endif; ?>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Restoran
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>