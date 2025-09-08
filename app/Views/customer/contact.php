<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Identitas Pelanggan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --coffee-green: #114b36;
            --coffee-green-600: #0d3a2a;
            --coffee-green-400: #1c6b4c;
            --surface: #ffffff;
            --surface-soft: #f1f6f3;
            --text-primary: #102a26;
            --text-muted: #6b7c75;
        }

        * { font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; }

        body {
            background: radial-gradient(1200px 600px at 20% -10%, #e7f1eb 0%, transparent 60%),
                        radial-gradient(1200px 600px at 120% 110%, #e7f1eb 0%, transparent 60%),
                        #f9fbf9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-primary);
        }

        .card-form {
            background: var(--surface);
            padding: 2rem;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(17, 75, 54, 0.08);
            width: 100%;
            max-width: 560px;
            border: 1px solid rgba(17, 75, 54, 0.06);
        }

        .form-title {
            font-weight: 700;
            margin-bottom: 1.75rem;
            text-align: center;
            color: var(--text-primary);
            letter-spacing: 0.2px;
        }

        .form-title .badge-icon {
            width: 44px;
            height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: linear-gradient(180deg, #ecf6f1, #e3f1eb);
            color: var(--coffee-green);
            margin-right: 10px;
            box-shadow: inset 0 -1px 0 rgba(17, 75, 54, 0.06);
        }

        label.form-label { font-weight: 600; color: var(--text-primary); }

        .form-control {
            border-radius: 14px;
            border: 1px solid #e6eee6;
            padding: 0.8rem 1rem;
            background: #fff;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: var(--coffee-green-400);
            box-shadow: 0 0 0 0.2rem rgba(17, 75, 54, 0.10);
        }

        .total-box {
            background-color: var(--surface-soft);
            padding: 1.1rem 1.25rem;
            border-radius: 16px;
            text-align: center;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(17, 75, 54, 0.06);
        }

        .total-box h5 {
            margin: 0 0 0.25rem 0;
            font-weight: 600;
            color: var(--text-muted);
        }

        .total-box .harga {
            font-size: 1.6rem;
            color: var(--coffee-green);
            font-weight: 700;
        }

        .btn-primary {
            border-radius: 14px;
            padding: 0.85rem;
            font-weight: 600;
            background-color: var(--coffee-green);
            border-color: var(--coffee-green);
        }

        .btn-primary:hover, .btn-primary:focus {
            background-color: var(--coffee-green-600);
            border-color: var(--coffee-green-600);
        }
    </style>
</head>

<body>

    <div class="card-form">
        <h3 class="form-title"><span class="badge-icon">☕</span> Data Pemesan</h3>

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