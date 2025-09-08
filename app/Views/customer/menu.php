<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'navy-green': {
                            50: '#f0f7f4',
                            100: '#d9ebe2',
                            200: '#b7d7c9',
                            300: '#88bbaa',
                            400: '#5c9988',
                            500: '#427e6e',
                            600: '#336457',
                            700: '#2b5147',
                            800: '#25423a',
                            900: '#203731',
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }
        .category-tab {
            transition: all 0.3s ease;
        }
        .category-tab:hover, .category-tab.active {
            background-color: #336457;
            color: white;
        }
        .menu-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .quantity-btn {
            transition: all 0.2s ease;
        }
        .quantity-btn:hover:not(:disabled) {
            background-color: #2b5147;
        }
        
        /* Styling untuk header dan nav yang diperbaiki */
        .delivery-nav {
            background: #336457;
            color: white;
            transition: all 0.3s ease;
        }
        .delivery-nav.scrolled {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .info-header {
            background-color: white;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .info-header.hidden {
            opacity: 0;
            transform: translateY(-100%);
            pointer-events: none;
            height: 0;
            padding: 0;
            overflow: hidden;
            margin: 0;
        }
        .floating-cart {
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }
        .floating-cart:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }
        .header-info-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            font-size: 0.875rem;
        }
        .header-info-item {
            display: flex;
            align-items: center;
            white-space: nowrap;
        }
        .divider {
            color: #d1d5db;
        }
        /* Styling untuk kategori baru */
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .category-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .category-card:hover {
            transform: scale(1.03);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Info Header -->
    <div id="restaurantHeader" class="info-header pt-16">
        <div class="container mx-auto px-4 py-4">
            <div class="header-info-row text-gray-600">
                <?php if ($meja): ?>
                    <div class="header-info-item">
                        <i class="fas fa-table mr-2"></i>
                        <span>Meja <?= $meja['nomor_meja'] ?></span>
                        <?php if ($meja['keterangan']): ?>
                            <span class="mx-2">-</span>
                            <span><?= $meja['keterangan'] ?></span>
                        <?php endif; ?>
                    </div>
                    <span class="divider">•</span>
                <?php endif; ?>
                
                <div class="header-info-item">
                    <i class="fas fa-map-marker-alt mr-2"></i>
                    <span class="truncate max-w-xs"><?= $restoran['alamat'] ?></span>
                </div>
                <span class="divider">•</span>
                
                <div class="header-info-item">
                    <i class="fas fa-phone mr-2"></i>
                    <span><?= $restoran['kontak'] ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery Navigation -->
    <nav id="stickyNav" class="delivery-nav fixed w-full z-50 top-0">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center">
            <a href="#" class="flex items-center">
                <div class="w-8 h-8 rounded-full bg-white bg-opacity-20 flex items-center justify-center mr-2">
                    <i class="fas fa-utensils text-white"></i>
                </div>
                <span class="text-white font-semibold"><?= $restoran['nama'] ?></span>
            </a>
        </div>
    </nav>

    <div class="container mx-auto px-4 pt-4 pb-16 mt-4">
        <!-- Alert messages -->
        <?php if (session()->getFlashdata('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <p><?= session()->getFlashdata('error') ?></p>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <p><?= session()->getFlashdata('success') ?></p>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Search -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" placeholder="Cari menu..." 
                       class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-200 focus:outline-none focus:ring-2 focus:ring-navy-green-500 focus:border-transparent">
            </div>
        </div>

        <!-- Category Tabs -->
        <div class="mb-6 bg-white rounded-xl shadow-sm p-4">
            <div class="flex overflow-x-auto space-x-3 pb-2 hide-scrollbar">
                <button class="category-tab px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap active" data-category="all">Semua</button>
                <?php foreach ($kategori_list as $kategori): ?>
                <button class="category-tab px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap" data-category="<?= $kategori['nama'] ?>"><?= $kategori['nama'] ?></button>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Menu Container Section (Filterable) -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-navy-green-800">Menu Kami</h3>
                <a href="#" class="text-sm text-navy-green-600 font-medium">View all <i class="fas fa-chevron-right text-xs ml-1"></i></a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6" id="menuContainer">
                <?php 
                // Display all menu items initially
                foreach ($kategori_list as $kategori): 
                    $menuInKategori = $menu_by_kategori[$kategori['nama']] ?? [];
                    foreach ($menuInKategori as $menu): 
                ?>
                    <div class="menu-card bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100" data-category="<?= $kategori['nama'] ?>" data-name="<?= strtolower($menu['nama']) ?>">
                        <?php if ($menu['stok'] <= 0): ?>
                            <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full z-10">
                                HABIS
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($menu['gambar']): ?>
                            <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                                 class="w-full h-48 object-cover" 
                                 alt="<?= $menu['nama'] ?>">
                        <?php else: ?>
                            <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                <i class="fas fa-utensils text-gray-300 text-4xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <div class="p-2 sm:p-3 md:p-4">
                            <div class="flex justify-between items-start mb-2 sm:mb-3">
                                <h4 class="text-sm sm:text-base font-semibold text-navy-green-800 break-words"><?= $menu['nama'] ?></h4>
                                <span class="text-xs sm:text-sm text-navy-green-600 font-bold whitespace-nowrap ml-1">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></span>
                            </div>
                            
                            <p class="text-gray-500 text-xs sm:text-sm mb-1 sm:mb-2 line-clamp-2 sm:line-clamp-3">
                                <?= $menu['deskripsi'] ?: 'Tidak ada deskripsi' ?>
                            </p>
                            
                            <div class="flex items-center text-xs text-gray-500 mb-1 sm:mb-2">
                                <div class="flex items-center mr-3">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span>4.4 (25)</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-clock mr-1"></i>
                                    <span>16 min</span>
                                </div>
                            </div>
                            
                            <form action="<?= base_url('customer/add-to-cart') ?>" method="post">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                                
                                <div class="flex items-center justify-between mb-2 sm:mb-3">
                                    <label class="text-xs sm:text-sm font-medium text-gray-700">Jumlah:</label>
                                    <div class="flex items-center space-x-1 sm:space-x-2">
                                        <button type="button" 
                                                onclick="<?= $menu['stok'] > 0 ? 'decreaseQuantity(' . $menu['id'] . ')' : '' ?>" 
                                                class="quantity-btn w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-navy-green-100 text-navy-green-800 flex items-center justify-center text-xs sm:text-sm <?= $menu['stok'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                                <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                            -
                                        </button>
                                        <input type="number" name="jumlah" id="quantity-<?= $menu['id'] ?>" 
                                               class="w-8 sm:w-12 text-center border border-gray-200 rounded-md py-1 text-xs sm:text-sm <?= $menu['stok'] <= 0 ? 'bg-gray-100' : '' ?>" 
                                               value="1" min="1" max="<?= $menu['stok'] ?>"
                                               <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                        <button type="button" 
                                                onclick="<?= $menu['stok'] > 0 ? 'increaseQuantitySection(\'' . $kategori['nama'] . '\', ' . $menu['id'] . ', ' . $menu['stok'] . ')' : '' ?>" 
                                                class="quantity-btn w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-navy-green-100 text-navy-green-800 flex items-center justify-center text-xs sm:text-sm <?= $menu['stok'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                                <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                            +
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-2 sm:mb-4">
                                    <textarea name="catatan" 
                                              class="w-full px-3 sm:px-4 py-1 sm:py-2 text-xs sm:text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-green-500 focus:border-transparent <?= $menu['stok'] <= 0 ? 'bg-gray-100' : '' ?>" 
                                              rows="2" 
                                              placeholder="Tambah catatan..."
                                              <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>></textarea>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full py-2 sm:py-3 text-xs sm:text-sm bg-navy-green-600 text-white rounded-lg font-medium hover:bg-navy-green-700 transition duration-200 flex items-center justify-center <?= $menu['stok'] <= 0 ? 'bg-gray-400 hover:bg-gray-400 cursor-not-allowed' : '' ?>"
                                        <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                    <i class="fas fa-plus mr-1 sm:mr-2"></i>
                                    <?= $menu['stok'] > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' ?>
                                </button>
                            </form>
                        </div>
                    </div>
                <?php 
                    endforeach;
                endforeach; 
                
                if (empty($kategori_list) || empty($menu_by_kategori)): 
                ?>
                    <div class="col-span-3 text-center py-10">
                        <i class="fas fa-utensils text-gray-300 text-4xl mb-3"></i>
                        <h5 class="text-gray-500">Belum ada menu tersedia</h5>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <?php
        // Ambil maksimal 3 kategori untuk ditampilkan sebagai section
        $sectionCategories = array_slice($kategori_list, 0, 3);
        
        // Tampilkan section untuk setiap kategori (maksimal 3)
        foreach ($sectionCategories as $index => $kategori):
            $menuItems = $menu_by_kategori[$kategori['nama']] ?? [];
            if (empty($menuItems)) continue;
            
            // Tentukan warna border untuk kategori ini
            $borderColors = ['border-yellow-400', 'border-blue-400', 'border-green-400'];
            $borderColor = $borderColors[$index] ?? 'border-gray-200';
        ?>
        <!-- <?= $kategori['nama'] ?> Section -->
        <div class="mb-8">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-navy-green-800">
                    <?= $kategori['nama'] ?>
                    <?php if ($index === 0): ?>
                    <span class="inline-block ml-1 bg-yellow-400 rounded-full w-2 h-2"></span>
                    <?php endif; ?>
                </h3>
                <a href="#" class="text-sm text-navy-green-600 font-medium" onclick="filterMenuByCategory('<?= $kategori['nama'] ?>')">View all <i class="fas fa-chevron-right text-xs ml-1"></i></a>
            </div>
            
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
                <?php foreach (array_slice($menuItems, 0, 6) as $menu): // Batasi 6 item ?>
                <div class="menu-card bg-white rounded-xl shadow-sm overflow-hidden border border-gray-100" data-category="<?= $kategori['nama'] ?>" data-name="<?= strtolower($menu['nama']) ?>">
                    <?php if ($menu['stok'] <= 0): ?>
                        <div class="absolute top-4 right-4 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full z-10">
                            HABIS
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($menu['gambar']): ?>
                        <img src="<?= base_url('uploads/menu/' . $menu['gambar']) ?>" 
                             class="w-full h-48 object-cover" 
                             alt="<?= $menu['nama'] ?>">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-utensils text-gray-300 text-4xl"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="p-2 sm:p-3 md:p-4">
                        <div class="flex justify-between items-start mb-2 sm:mb-3">
                            <h4 class="text-sm sm:text-base font-semibold text-navy-green-800 break-words"><?= $menu['nama'] ?></h4>
                            <span class="text-xs sm:text-sm text-navy-green-600 font-bold whitespace-nowrap ml-1">Rp <?= number_format($menu['harga'], 0, ',', '.') ?></span>
                        </div>
                        
                        <p class="text-gray-500 text-xs sm:text-sm mb-1 sm:mb-2 line-clamp-2 sm:line-clamp-3">
                            <?= $menu['deskripsi'] ?: 'Tidak ada deskripsi' ?>
                        </p>
                        
                        <div class="flex items-center text-xs text-gray-500 mb-1 sm:mb-2">
                            <div class="flex items-center mr-3">
                                <i class="fas fa-star text-yellow-400 mr-1"></i>
                                <span>4.4 (25)</span>
                            </div>
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                <span>16 min</span>
                            </div>
                        </div>
                        
                        <form action="<?= base_url('customer/add-to-cart') ?>" method="post">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="menu_id" value="<?= $menu['id'] ?>">
                            
                            <div class="flex items-center justify-between mb-2 sm:mb-3">
                                <label class="text-xs sm:text-sm font-medium text-gray-700">Jumlah:</label>
                                <div class="flex items-center space-x-1 sm:space-x-2">
                                    <button type="button" 
                                            onclick="<?= $menu['stok'] > 0 ? 'decreaseQuantitySection(\'' . $kategori['nama'] . '\', ' . $menu['id'] . ')' : '' ?>" 
                                            class="quantity-btn w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-navy-green-100 text-navy-green-800 flex items-center justify-center text-xs sm:text-sm <?= $menu['stok'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                            <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                        -
                                    </button>
                                    <input type="number" name="jumlah" id="quantity-section-<?= $kategori['nama'] ?>-<?= $menu['id'] ?>" 
                                           class="w-8 sm:w-12 text-center border border-gray-200 rounded-md py-1 text-xs sm:text-sm <?= $menu['stok'] <= 0 ? 'bg-gray-100' : '' ?>" 
                                           value="1" min="1" max="<?= $menu['stok'] ?>"
                                           <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                    <button type="button" 
                                            onclick="<?= $menu['stok'] > 0 ? 'increaseQuantitySection(\'' . $kategori['nama'] . '\', ' . $menu['id'] . ', ' . $menu['stok'] . ')' : '' ?>" 
                                            class="quantity-btn w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-navy-green-100 text-navy-green-800 flex items-center justify-center text-xs sm:text-sm <?= $menu['stok'] <= 0 ? 'opacity-50 cursor-not-allowed' : '' ?>"
                                            <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                        +
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-2 sm:mb-4">
                                    <textarea name="catatan" 
                                              class="w-full px-3 sm:px-4 py-1 sm:py-2 text-xs sm:text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-navy-green-500 focus:border-transparent <?= $menu['stok'] <= 0 ? 'bg-gray-100' : '' ?>" 
                                              rows="2" 
                                              placeholder="Tambah catatan..."
                                              <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>></textarea>
                                </div>
                                
                                <button type="submit" 
                                        class="w-full py-2 sm:py-3 text-xs sm:text-sm bg-navy-green-600 text-white rounded-lg font-medium hover:bg-navy-green-700 transition duration-200 flex items-center justify-center <?= $menu['stok'] <= 0 ? 'bg-gray-400 hover:bg-gray-400 cursor-not-allowed' : '' ?>"
                                        <?= $menu['stok'] <= 0 ? 'disabled' : '' ?>>
                                    <i class="fas fa-plus mr-1 sm:mr-2"></i>
                                    <?= $menu['stok'] > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' ?>
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 right-0 bg-white shadow-lg border-t border-gray-200 px-4 py-3 flex justify-around items-center">
        <a href="#" class="flex flex-col items-center text-navy-green-600">
            <i class="fas fa-home mb-1"></i>
            <span class="text-xs">Home</span>
        </a>
        <a href="<?= base_url('customer/cart') ?>" class="flex flex-col items-center text-gray-500 relative">
            <i class="fas fa-shopping-cart mb-1"></i>
            <span class="text-xs">Keranjang</span>
            <?php 
            $cart = session()->get('cart') ?? [];
            $cartCount = count($cart);
            if ($cartCount > 0): 
            ?>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center shadow-md">
                    <?= $cartCount ?>
                </span>
            <?php endif; ?>
        </a>
    </div>

    <script>
        function increaseQuantity(menuId, maxStock) {
            // Update input di menu all
            const input = document.getElementById('quantity-' + menuId);
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                
                // Update semua input dengan menu ID yang sama di section kategori
                updateAllSectionInputs(menuId, currentValue + 1);
            }
        }

        function decreaseQuantity(menuId) {
            // Update input di menu all
            const input = document.getElementById('quantity-' + menuId);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                
                // Update semua input dengan menu ID yang sama di section kategori
                updateAllSectionInputs(menuId, currentValue - 1);
            }
        }
        
        function increaseQuantitySection(section, menuId, maxStock) {
            // Update input di section kategori
            const input = document.getElementById('quantity-section-' + section + '-' + menuId);
            const currentValue = parseInt(input.value);
            if (currentValue < maxStock) {
                input.value = currentValue + 1;
                
                // Update input di menu all
                const mainInput = document.getElementById('quantity-' + menuId);
                if (mainInput) {
                    mainInput.value = currentValue + 1;
                }
                
                // Update input di section kategori lain
                updateAllSectionInputs(menuId, currentValue + 1, section);
            }
        }

        function decreaseQuantitySection(section, menuId) {
            // Update input di section kategori
            const input = document.getElementById('quantity-section-' + section + '-' + menuId);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                
                // Update input di menu all
                const mainInput = document.getElementById('quantity-' + menuId);
                if (mainInput) {
                    mainInput.value = currentValue - 1;
                }
                
                // Update input di section kategori lain
                updateAllSectionInputs(menuId, currentValue - 1, section);
            }
        }
        
        // Fungsi untuk mengupdate semua input dengan menu ID yang sama di semua section
        function updateAllSectionInputs(menuId, newValue, excludeSection = null) {
            // Cari semua input yang mengandung ID menu yang sama di semua section
            const allInputs = document.querySelectorAll('input[id*="-' + menuId + '"]');
            
            allInputs.forEach(input => {
                // Skip input yang sedang diupdate (untuk menghindari loop tak terbatas)
                if (input.id === 'quantity-' + menuId || 
                    (excludeSection && input.id === 'quantity-section-' + excludeSection + '-' + menuId)) {
                    return;
                }
                
                input.value = newValue;
            });
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            filterMenuBySearch(searchTerm);
        });

        // Filter menu by category (hanya berlaku untuk section menu all)
        function filterMenuByCategory(category) {
            // Highlight selected category tab
            document.querySelectorAll('.category-tab').forEach(tab => {
                const tabCategory = tab.getAttribute('data-category');
                if (tabCategory === category) {
                    tab.classList.add('active');
                } else {
                    tab.classList.remove('active');
                }
            });
            
            // Update section title
            const menuContainerTitle = document.querySelector('.mb-8 h3');
            if (category === 'all') {
                menuContainerTitle.textContent = 'Menu Kami';
            } else {
                menuContainerTitle.textContent = category;
            }
            
            // Hanya filter menu di container utama (menu all)
            const menuItems = document.querySelectorAll('#menuContainer .menu-card');
            
            menuItems.forEach(item => {
                const itemCategory = item.getAttribute('data-category');
                
                if (category === 'all' || category === itemCategory) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Filter menu by search term (hanya berlaku untuk section menu all)
        function filterMenuBySearch(searchTerm) {
            const menuItems = document.querySelectorAll('#menuContainer .menu-card');
            
            menuItems.forEach(item => {
                const itemName = item.getAttribute('data-name');
                
                if (itemName.includes(searchTerm)) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }

        // Script untuk sticky navigation yang diperbaiki
        const stickyNav = document.getElementById('stickyNav');
        const header = document.getElementById('restaurantHeader');
        let lastScrollTop = 0;
        let isScrolling;
        let scrollTimer;
        
        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            
            // Clear our timeout throughout the scroll
            window.clearTimeout(isScrolling);
            window.clearTimeout(scrollTimer);
            
            // Prevent multiple scroll events from causing glitches
            if (!scrollTimer) {
                scrollTimer = setTimeout(function() {
                    // Determine scroll direction
                    if (scrollTop > lastScrollTop && scrollTop > 50) {
                        // Scrolling down - hide header
                        header.classList.add('hidden');
                        stickyNav.classList.add('scrolled');
                    } else {
                        // Scrolling up - show header
                        header.classList.remove('hidden');
                        if (scrollTop < 10) {
                            stickyNav.classList.remove('scrolled');
                        }
                    }
                    
                    // Set a timeout to run after scrolling ends
                    isScrolling = setTimeout(function() {
                        // Reset nav background if at top of page
                        if (scrollTop < 10) {
                            stickyNav.classList.remove('scrolled');
                        }
                    }, 100);
                    
                    lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // For Mobile or negative scrolling
                    scrollTimer = null;
                }, 10);
            }
        }, { passive: true });
        
        // Initialize with 'all' category on page load and add event listeners to category tabs
        document.addEventListener('DOMContentLoaded', function() {
            // Add click event listeners to category tabs
            document.querySelectorAll('.category-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    const category = this.getAttribute('data-category');
                    filterMenuByCategory(category);
                });
            });
            
            // Initialize with 'all' category
            filterMenuByCategory('all');
        });
    </script>
</body>
</html>