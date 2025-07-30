<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard' ?> - Sistem Menu Restoran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            margin: 2px 0;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(5px);
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: 700;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .btn {
            border-radius: 10px;
        }
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <i class="fas fa-utensils fa-2x text-white mb-2"></i>
                        <h5 class="text-white">Menu Restoran</h5>
                        <small class="text-white-50"><?= session()->get('username') ?></small>
                    </div>
                    
                    <ul class="nav flex-column">
                        <?php if (session()->get('role') === 'super_admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= current_url() == base_url('super-admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('super-admin/dashboard') ?>">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= strpos(current_url(), 'super-admin/restoran') !== false ? 'active' : '' ?>" href="<?= base_url('super-admin/restoran') ?>">
                                    <i class="fas fa-store me-2"></i>Kelola Restoran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= strpos(current_url(), 'super-admin/admin') !== false ? 'active' : '' ?>" href="<?= base_url('super-admin/admin') ?>">
                                    <i class="fas fa-users me-2"></i>Kelola Admin
                                </a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link <?= current_url() == base_url('admin/dashboard') ? 'active' : '' ?>" href="<?= base_url('admin/dashboard') ?>">
                                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= strpos(current_url(), 'admin/kategori') !== false ? 'active' : '' ?>" href="<?= base_url('admin/kategori') ?>">
                                    <i class="fas fa-tags me-2"></i>Kelola Kategori
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= strpos(current_url(), 'admin/menu') !== false ? 'active' : '' ?>" href="<?= base_url('admin/menu') ?>">
                                    <i class="fas fa-utensils me-2"></i>Kelola Menu
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= strpos(current_url(), 'admin/pesanan') !== false ? 'active' : '' ?>" href="<?= base_url('admin/pesanan') ?>">
                                    <i class="fas fa-shopping-cart me-2"></i>Kelola Pesanan
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="nav-item mt-3">
                            <a class="nav-link" href="<?= base_url('auth/logout') ?>" onclick="return confirm('Yakin ingin logout?')">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm rounded-bottom mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".sidebar">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <span class="navbar-brand">
                            <i class="fas fa-utensils me-2"></i><?= $title ?? 'Dashboard' ?>
                        </span>
                        
                        <div class="navbar-nav ms-auto">
                            <span class="navbar-text">
                                <i class="fas fa-user me-1"></i><?= session()->get('username') ?>
                            </span>
                        </div>
                    </div>
                </nav>

                <!-- Flash messages -->
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Page content -->
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 