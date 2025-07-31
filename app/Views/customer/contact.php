<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Identitas Pelanggan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light py-5">
    <div class="container py-5" style="margin-top: 100px; max-width: 600px;">
    <h3 class="mb-4">Isi Identitas Anda</h3>

    <form action="<?= base_url('customer/submit-identitas') ?>" method="post">
            <?= csrf_field() ?>
    
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
    
            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor HP</label>
                <input type="text" class="form-control" id="telepon" name="telepon" required>
            </div>
    
            <div class="mb-3">
                <label for="meja" class="form-label">Nomor Meja</label>
                <input type="text" class="form-control" id="meja" name="meja" required>
            </div>
    
            <div class="mb-4">
                <h5>Total Bayar:
                    <strong>Rp <?= number_format($total, 0, ',', '.') ?></strong>
                </h5>
            </div>
    
            <button type="submit" class="btn btn-primary w-100">Lanjut </button>
        </form>
    </div>

</body>

</html>