<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus me-2"></i>Tambah Kategori
        </h1>
        <a href="<?= base_url('admin/kategori') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-tags me-2"></i>Form Tambah Kategori
            </h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/kategori/create') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="mb-3">
                    <label for="nama" class="form-label">
                        <i class="fas fa-tag me-2"></i>Nama Kategori <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>" id="nama"
                        name="nama" value="<?= old('nama') ?>" required>
                    <?php if (session('errors.nama')): ?>
                        <div class="invalid-feedback"><?= session('errors.nama') ?></div>
                    <?php endif; ?>
                    <div class="form-text">Contoh: Makanan, Minuman, Snack, dll</div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>