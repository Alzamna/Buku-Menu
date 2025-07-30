
<body>

<div class="header">
  <h2><?= esc($restoName ?? 'Nama Restoran') ?></h2>
  <p><?= esc($restoDescription ?? 'Deskripsi singkat restoran') ?></p>
</div>

<div class="menu-category">
  <?php foreach ($kategori as $kat): ?>
        <button class="btn btn-outline-primary btn-sm" onclick="filterKategori('<?= esc($kat) ?>')">
          <?= esc(ucwords($kat)) ?>
        </button>
  <?php endforeach; ?>
  <button class="btn btn-outline-secondary btn-sm" onclick="filterKategori('all')">Semua</button>
</div>

<div class="container mt-3" id="menu-list">
  <div class="row">
    <?php foreach ($menus as $menu): ?>
          <div class="col-12 mb-3 menu-box" data-kategori="<?= esc($menu['kategori']) ?>">
            <div class="menu-item">
              <?php if (!empty($menu['gambar'])): ?>
                    <img src="<?= base_url('uploads/' . $menu['gambar']) ?>" alt="<?= esc($menu['nama']) ?>">
              <?php endif; ?>
              <div class="menu-name"><?= esc($menu['nama']) ?></div>
              <div class="menu-price">Rp<?= number_format($menu['harga'], 0, ',', '.') ?></div>
              <p class="text-muted"><?= esc($menu['deskripsi']) ?></p>
            </div>
          </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
  function filterKategori(kategori) {
    let items = document.querySelectorAll('.menu-box');
    items.forEach(function(item) {
      item.style.display = (kategori === 'all' || item.dataset.kategori === kategori) ? 'block' : 'none';
    });
  }
</script>


