<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-shopping-cart me-2"></i>Kelola Pesanan
        </h1>
    </div>
<!-- Search bar -->
<div class="d-flex justify-content-end mb-3">
    <form action="<?= base_url('admin/pesanan') ?>" method="get" class="d-flex" style="max-width: 300px;">
        <input type="text" name="q" class="form-control form-control-sm me-2" placeholder="Cari ID / Nama...">
        <button type="submit" class="btn btn-sm btn-primary">
            <i class="fas fa-search"></i>
        </button>
    </form>
</div>
    <!-- Pesanan List -->
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-list me-2"></i>Daftar Pesanan
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>ID Pesanan</th>
                            <th>ID Customer</th>
                            <th>Nama Customer</th>
                            <th>Metode</th>
                            <th>No Meja</th>
                            <th>Total</th>
                            <th>Waktu Pesan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pesanan_list)): ?>
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada data pesanan</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($pesanan_list as $index => $pesanan): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong>#<?= $pesanan['id'] ?></strong>
                                    </td>
                                    <td>
                                        <strong>#<?= $pesanan['kode_unik'] ?></strong>
                                    </td>
                                    <td><?= htmlspecialchars($pesanan['nama']) ?></td>
                                    <td>
                                        <?php if ($pesanan['metode'] === 'dine_in'): ?>
                                            <span class="badge bg-primary">Dine In</span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Take Away</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (isset($pesanan['meja']) && $pesanan['meja']): ?>
                                            <span class="badge bg-info">
                                                <i class="fas fa-table me-1"></i><?= $pesanan['meja'] ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <strong class="text-success">Rp <?= number_format($pesanan['total'], 0, ',', '.') ?></strong>
                                    </td>
                                    <td><?= date('d/m/Y H:i', strtotime($pesanan['waktu_pesan'])) ?></td>
                                    <td>
                                        <?php
                                        $statusClass = '';
                                        $statusText = '';
                                        switch ($pesanan['status']) {
                                            case 'pending':
                                                $statusClass = 'bg-warning';
                                                $statusText = 'Proses';
                                                break;
                                            case 'confirmed':
                                                $statusClass = 'bg-info';
                                                $statusText = 'Antar';
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
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/pesanan/detail/' . $pesanan['id']) ?>" 
                                               class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <?php if ($pesanan['status'] === 'pending'): ?>
                                                <button type="button" class="btn btn-sm btn-success" title="Konfirmasi"
                                                        onclick="updateStatus(<?= $pesanan['id'] ?>, 'confirmed')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" title="Batalkan"
                                                        onclick="updateStatus(<?= $pesanan['id'] ?>, 'cancelled')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php elseif ($pesanan['status'] === 'confirmed'): ?>
                                                <button type="button" class="btn btn-sm btn-success" title="Selesai"
                                                        onclick="updateStatus(<?= $pesanan['id'] ?>, 'completed')">
                                                    <i class="fas fa-check-double"></i>
                                                </button>
                                            <?php endif; ?>
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

<script>
function updateStatus(pesananId, status) {
    if (confirm('Yakin ingin mengubah status pesanan ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('admin/pesanan/update-status/') ?>' + pesananId;
        
        const statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        statusInput.value = status;
        
        form.appendChild(statusInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
<?= $this->endSection() ?> 