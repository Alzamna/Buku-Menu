<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-eye me-2"></i>Detail Pesanan #<?= $pesanan['id'] ?>
        </h1>
        <a href="<?= base_url('admin/pesanan') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Pesanan Info -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Pesanan
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>ID Pesanan:</strong></td>
                            <td>#<?= $pesanan['id'] ?></td>
                        </tr>
                        <tr>
                            <td><strong>Restoran:</strong></td>
                            <td><?= esc($pesanan['nama_restoran']) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Metode:</strong></td>
                            <td>
                                <?php if ($pesanan['metode'] === 'dine_in'): ?>
                                    <span class="badge bg-primary">Dine In</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Take Away</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <?php
                                $statusClass = '';
                                $statusText = '';
                                switch ($pesanan['status']) {
                                    case 'pending':
                                        $statusClass = 'bg-warning';
                                        $statusText = 'Pending';
                                        break;
                                    case 'confirmed':
                                        $statusClass = 'bg-info';
                                        $statusText = 'Dikonfirmasi';
                                        break;
                                    case 'completed':
                                        $statusClass = 'bg-success';
                                        $statusText = 'Selesai';
                                        break;
                                    case 'cancelled':
                                        $statusClass = 'bg-danger';
                                        $statusText = 'Dibatalkan';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $statusClass ?>"><?= $statusText ?></span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Waktu Pesan:</strong></td>
                            <td><?= date('d/m/Y H:i', strtotime($pesanan['waktu_pesan'])) ?></td>
                        </tr>
                        <tr>
                            <td><strong>Total:</strong></td>
                            <td><strong class="text-success">Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-cogs me-2"></i>Update Status
                    </h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/pesanan/update-status/' . $pesanan['id']) ?>" method="post">
                        <?= csrf_field(); ?>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Pesanan</label>
                            <select class="form-control" id="status" name="status">
                                <option value="pending" <?= $pesanan['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                <option value="confirmed" <?= $pesanan['status'] === 'confirmed' ? 'selected' : '' ?>>Dikonfirmasi</option>
                                <option value="completed" <?= $pesanan['status'] === 'completed' ? 'selected' : '' ?>>Selesai</option>
                                <option value="cancelled" <?= $pesanan['status'] === 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update Status
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Info Identitas Customer -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <i class="fas fa-user me-2"></i>Identitas Pemesan
        </h6>
    </div>
    <div class="card-body">
        <table class="table table-borderless">
            <tr>
                <td><strong>Nama:</strong></td>
                <td><?= esc($pesanan['nama'] ?? '-') ?></td>
            </tr>
            <tr>
                <td><strong>No HP:</strong></td>
                <td><?= esc($pesanan['telepon'] ?? '-') ?></td>
            </tr>
            <tr>
                <td><strong>Meja:</strong></td>
                <td><?= esc($pesanan['meja'] ?? '-') ?></td>
            </tr>
        </table>
    </div>
</div>

    <!-- Detail Items -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Detail Item Pesanan
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Subtotal</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($detail_list)): ?>
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada detail pesanan</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($detail_list as $index => $detail): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($detail['nama_menu']) ?></strong>
                                    </td>
                                    <td><?= $detail['jumlah'] ?></td>
                                    <td>Rp <?= number_format($detail['harga_satuan'], 0, ',', '.') ?></td>
                                    <td><strong>Rp <?= number_format($detail['subtotal'], 0, ',', '.') ?></strong></td>
                                    <td>
                                        <?php if ($detail['catatan']): ?>
                                            <small class="text-muted"><?= esc($detail['catatan']) ?></small>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total:</strong></td>
                            <td colspan="2"><strong class="text-success">Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?> 