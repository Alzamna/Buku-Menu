<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Menu
        </h1>
        <a href="<?= base_url('admin/menu') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-utensils me-2"></i>Form Edit Menu
            </h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('admin/menu/edit/' . $menu['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field(); ?>
            <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                <i class="fas fa-utensils me-2"></i>Nama Menu <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?= session('errors.nama') ? 'is-invalid' : '' ?>" 
                                   id="nama" name="nama" value="<?= old('nama', $menu['nama']) ?>" required>
                            <?php if (session('errors.nama')): ?>
                                <div class="invalid-feedback"><?= session('errors.nama') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="kategori_id" class="form-label">
                                <i class="fas fa-tags me-2"></i>Kategori <span class="text-danger">*</span>
                            </label>
                            <select class="form-control <?= session('errors.kategori_id') ? 'is-invalid' : '' ?>" 
                                    id="kategori_id" name="kategori_id" required>
                                <option value="">Pilih Kategori</option>
                                <?php foreach ($kategori_list as $kategori): ?>
                                    <option value="<?= $kategori['id'] ?>" 
                                            <?= old('kategori_id', $menu['kategori_id']) == $kategori['id'] ? 'selected' : '' ?>>
                                        <?= esc($kategori['nama']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if (session('errors.kategori_id')): ?>
                                <div class="invalid-feedback"><?= session('errors.kategori_id') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="harga" class="form-label">
                                <i class="fas fa-money-bill me-2"></i>Harga <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control <?= session('errors.harga') ? 'is-invalid' : '' ?>" 
                                   id="harga" name="harga" value="<?= old('harga', $menu['harga']) ?>" min="0" required>
                            <?php if (session('errors.harga')): ?>
                                <div class="invalid-feedback"><?= session('errors.harga') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="stok" class="form-label">
                                <i class="fas fa-boxes me-2"></i>Stok <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control <?= session('errors.stok') ? 'is-invalid' : '' ?>" 
                                   id="stok" name="stok" value="<?= old('stok', $menu['stok']) ?>" min="0" required>
                            <?php if (session('errors.stok')): ?>
                                <div class="invalid-feedback"><?= session('errors.stok') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">
                        <i class="fas fa-align-left me-2"></i>Deskripsi
                    </label>
                    <textarea class="form-control <?= session('errors.deskripsi') ? 'is-invalid' : '' ?>" 
                              id="deskripsi" name="deskripsi" rows="3"><?= old('deskripsi', $menu['deskripsi']) ?></textarea>
                    <?php if (session('errors.deskripsi')): ?>
                        <div class="invalid-feedback"><?= session('errors.deskripsi') ?></div>
                    <?php endif; ?>
                </div>
                
                <div class="mb-3">
                    <label for="gambar" class="form-label">
                        <i class="fas fa-image me-2"></i>Gambar Menu
                    </label>
                    <?php if ($menu['gambar']): ?>
                        <div class="mb-2">
                            <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                                 alt="Gambar saat ini" class="img-thumbnail" style="max-width: 200px;">
                            <br><small class="text-muted">Gambar saat ini</small>
                        </div>
                    <?php endif; ?>
                    <input type="file" class="form-control <?= session('errors.gambar') ? 'is-invalid' : '' ?>" 
                           id="gambar" name="gambar" accept="image/*">
                    <?php if (session('errors.gambar')): ?>
                        <div class="invalid-feedback"><?= session('errors.gambar') ?></div>
                    <?php endif; ?>
                    <div class="form-text">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar</div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Menu
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 