<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-utensils me-2"></i>Kelola Menu
        </h1>
        <a href="<?= base_url('admin/menu/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Menu
        </a>
    </div>

    <!-- Menu List -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Menu
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($menu_list)): ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data menu</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($menu_list as $index => $menu): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <?php if ($menu['gambar']): ?>
                                            <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" alt="<?= $menu['nama'] ?>"
                                                class="img-thumbnail" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-utensils text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong><?= esc($menu['nama']) ?></strong>
                                        <?php if ($menu['deskripsi']): ?>
                                            <br><small class="text-muted"><?= esc($menu['deskripsi']) ?></small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?= esc($menu['nama_kategori']) ?></span>
                                    </td>
                                    <td>
                                        <strong class="text-success">Rp
                                            <?= number_format($menu['harga'], 0, ',', '.') ?></strong>
                                    </td>
                                    <td>
                                        <?php if ($menu['stok'] > 0): ?>
                                            <span class="badge bg-success"><?= $menu['stok'] ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Habis</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/menu/edit/' . $menu['id']) ?>"
                                                class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= base_url('admin/menu/delete/' . $menu['id']) ?>"
                                                class="btn btn-sm btn-danger" title="Hapus"
                                                onclick="return confirm('Yakin ingin menghapus menu ini?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                            <a href="#" class="btn btn-sm btn-info" title="Preview" 
                                                data-bs-toggle="modal" data-bs-target="#previewModal-<?= $menu['id'] ?>">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
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
<?php foreach ($menu_list as $menu): ?>
<div class="modal fade" id="previewModal-<?= $menu['id'] ?>" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">
          <i class="fas fa-eye me-2"></i>Preview Menu
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="d-flex justify-content-center">
          <div class="card menu-card shadow-sm rounded-4 p-3" style="max-width: 350px; width: 100%;">

            <?php if ($menu['gambar']): ?>
              <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                   class="card-img-top menu-image rounded-3 mb-3" 
                   alt="<?= esc($menu['nama']) ?>" 
                   style="height: 180px; object-fit: cover;">
            <?php else: ?>
              <div class="card-img-top menu-image bg-light d-flex align-items-center justify-content-center rounded-3 mb-3" 
                   style="height: 180px;">
                <i class="fas fa-utensils fa-3x text-muted"></i>
              </div>
            <?php endif; ?>

            <!-- Detail Menu -->
            <div class="card-body text-start">
              <h5 class="card-title fw-bold "><?= esc($menu['nama']) ?></h5>
              <p class="text-muted"><?= $menu['deskripsi'] ?: 'Tidak ada deskripsi' ?></p>
              <p class="menu-price text-success fw-bold">
                Rp <?= number_format($menu['harga'], 0, ',', '.') ?>
              </p>

              <form>
                <div class="d-flex justify-content-center align-items-center mb-3">
                  <button type="button" class="btn btn-outline-primary rounded-circle px-3">-</button>
                  <input type="text" class="form-control text-center mx-2" value="1" 
                         style="width: 60px;" readonly>
                  <button type="button" class="btn btn-outline-primary rounded-circle px-3">+</button>
                </div>
                <div class="mb-3 text-start">
                  <label class="form-label">Tambah Catatan:</label>
                  <textarea class="form-control" rows="2" 
                            placeholder="Catatan untuk penjual"></textarea>
                </div>
                <button type="button" class="btn btn-primary w-100 rounded-3 fw-bold">
                  <i class="fas fa-plus me-2"></i> Tambah ke Keranjang
                </button>
              </form>
            </div>

          </div>
        </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>

<?= $this->endSection() ?>
<style>
    .menu-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
        }
          .menu-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            margin-bottom: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .menu-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 280px;
            /* Bisa disesuaikan */
        }

        .card.menu-card {
            min-height: 500px;
            /* Sesuaikan dengan kebutuhan tampilan */
        }
        .menu-card:hover {
            transform: translateY(-5px);
        }
        .menu-image {
            height: 200px;
            object-fit: cover;
            border-radius: 15px 15px 0 0;
        }
        .menu-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #28a745;
        }
        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .quantity-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: none;
            background: #667eea;
            color: white;
            font-weight: bold;
        }

        .btn:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }
        .form-control:disabled {
            background-color: #e9ecef !important;
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }
        .quantity-btn.disabled {
            background: #6c757d !important;
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }
        textarea:disabled {
            background-color: #e9ecef !important;
            opacity: 0.6 !important;
            cursor: not-allowed !important;
        }
        .menu-card.disabled {
            opacity: 0.6 !important;
            filter: grayscale(30%) !important;
            pointer-events: none;
        }
        .menu-card.disabled .card-body {
            background-color: #f8f9fa;
        }
        .menu-card.disabled .card-title {
            color: #6c757d;
        }
        .menu-card.disabled .card-text {
            color: #adb5bd;
        }
        .menu-card.disabled .menu-price {
            color: #6c757d;
        }
        .menu-card.disabled .menu-image {
            filter: grayscale(50%);
        }
        .menu-card.disabled .card-img-top {
            filter: grayscale(50%);
        }
        .menu-card.disabled .bg-light {
            filter: grayscale(50%);
        }
        .quantity-input {
            width: 50px;
            text-align: center;
            border: 2px solid #e9ecef;
            border-radius: 10px;
        }
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3545;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
</style>