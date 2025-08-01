<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Identitas Pelanggan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-form {
            background: white;
            padding: 2rem;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }

        .form-title {
            font-weight: 600;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-control {
            border-radius: 10px;
        }

        .total-box {
            background-color: #f0f4f8;
            padding: 1rem;
            border-radius: 12px;
            text-align: center;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .total-box h5 {
            margin: 0;
            font-weight: 500;
        }

        .total-box .harga {
            font-size: 1.5rem;
            color: #28a745;
            font-weight: bold;
            margin-top: 0.3rem;
        }

        .btn-primary {
            border-radius: 12px;
            padding: 0.75rem;
            font-weight: 500;
        }
    </style>
</head>

<body>

    <div class="card-form">
        <h3 class="form-title">🧾 Data Pemesan</h3>

        <form action="<?= base_url('customer/submit-identitas') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama Customer" required>
            </div>

            <div class="mb-3">
                <label for="telepon" class="form-label">Nomor HP</label>
                <input type="text" class="form-control" id="telepon" name="telepon" placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="total-box">
                <h5>Total Bayar</h5>
                <div class="harga">Rp <?= number_format($total, 0, ',', '.') ?></div>
            </div>

            <button type="submit" class="btn btn-primary w-100">Lanjutkan</button>
        </form>
    </div>

</body>

</html>