<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa-solid fa-star me-2"></i><?= $title; ?>
        </h1>
        <a href="<?= base_url('super-admin/admin') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fa-solid fa-star me-2"></i>Form Tambah Paket
            </h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('super-admin/paket/edit/' . $paket['id']) ?>" method="post">
                <?= csrf_field(); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                <i class="fa-solid fa-star me-2"></i>Nama Paket <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control <?= isset(session()->getFlashdata('errors')['nama']) ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama', $paket['nama']) ?>" required>
                            <?php if (isset(session()->getFlashdata('errors')['nama'])): ?>
                                <small class="text-danger"><?= session()->getFlashdata('errors')['nama']; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="harga" class="form-label">
                                <i class="fa-solid fa-money-bill me-2"></i>Harga <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-text">
                                    Rp.
                                </div>
                                <input type="number" class="form-control <?= isset(session('errors')['harga']) ? 'is-invalid' : '' ?>" id="harga" name="harga" value="<?= old('harga', $paket['harga']) ?>" required>
                            </div>
                            <?php if (isset(session()->getFlashdata('errors')['harga']) != null): ?>
                                <small class="text-danger"><?= session()->getFlashdata('errors')['harga']; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fa-solid fa-clock me-2"></i>Durasi <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number" class="form-control <?= isset(session('errors')['durasi'])  ? 'is-invalid' : '' ?>" id="durasi" name="durasi" value="<?= old('durasi', $paket['durasi']) ?>" maxlength="3" required>
                                <div class="input-group-text">
                                    Bulan
                                </div>
                            </div>
                            <?php if (isset(session('errors')['durasi'])): ?>
                                <small class="text-danger"><?= session('errors')['durasi']; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="username" class="form-label">
                                <i class="fa-solid fa-bars-staggered me-2"></i>Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control <?= isset(session('errors')['deskripsi']) ? 'is-invalid' : '' ?>" id="deskripsi" name="deskripsi" rows="3" required><?= old('deskripsi', $paket['deskripsi']) ?></textarea>
                            <?php if (isset(session('errors')['deskripsi'])): ?>
                                <small class="text-danger"><?= session('errors')['deskripsi']; ?></small>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Simpan Paket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>