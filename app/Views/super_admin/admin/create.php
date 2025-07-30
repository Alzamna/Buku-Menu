<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-user-plus me-2"></i>Tambah Admin Restoran
        </h1>
        <a href="<?= base_url('super-admin/admin') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user me-2"></i>Form Tambah Admin
            </h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('super-admin/admin/create') ?>" method="post">
                    <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fas fa-user me-2"></i>Username <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>" 
                                   id="username" name="username" value="<?= old('username') ?>" required>
                            <?php if (session('errors.username')): ?>
                                <div class="invalid-feedback"><?= session('errors.username') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-2"></i>Password <span class="text-danger">*</span>
                            </label>
                            <input type="password" class="form-control <?= session('errors.password') ? 'is-invalid' : '' ?>" 
                                   id="password" name="password" required>
                            <?php if (session('errors.password')): ?>
                                <div class="invalid-feedback"><?= session('errors.password') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="restoran_id" class="form-label">
                        <i class="fas fa-store me-2"></i>Restoran <span class="text-danger">*</span>
                    </label>
                    <select class="form-control <?= session('errors.restoran_id') ? 'is-invalid' : '' ?>" 
                            id="restoran_id" name="restoran_id" required>
                        <option value="">Pilih Restoran</option>
                        <?php foreach ($restoran_list as $restoran): ?>
                            <option value="<?= $restoran['id'] ?>" <?= old('restoran_id') == $restoran['id'] ? 'selected' : '' ?>>
                                <?= esc($restoran['nama']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (session('errors.restoran_id')): ?>
                        <div class="invalid-feedback"><?= session('errors.restoran_id') ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 