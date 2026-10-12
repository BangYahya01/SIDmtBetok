<?php
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$stmt = $pdo->query("SELECT * FROM lokasi ORDER BY kategori, nama");
$lokasi = $stmt->fetchAll();
$title = "Peta Wilayah — Desa Montong Betok";
?>
<section class="py-12 bg-gradient-to-br from-emerald-900 to-slate-900 text-white">
  <div class="max-w-6xl mx-auto px-4">
    <h1 class="text-3xl font-extrabold mb-2">Sistem Informasi Geografis</h1>
    <p class="text-slate-300 mb-6">Pemetaan lokasi administrasi, dusun, dan fasilitas umum Desa Montong Betok.</p>

    <div id="map" class="w-full h-[520px] rounded-2xl shadow-2xl border border-emerald-700"></div>

    <div class="grid md:grid-cols-3 gap-4 mt-6">
      <?php foreach ($lokasi as $l): ?>
        <div class="bg-white/10 backdrop-blur rounded-xl p-4 border border-white/10 hover:bg-white/15 transition">
          <h3 class="font-bold text-emerald-300"><?= htmlspecialchars($l['nama']) ?></h3>
          <span class="text-xs uppercase tracking-wide text-slate-400"><?= htmlspecialchars($l['kategori']) ?> — <?= htmlspecialchars($l['dusun']) ?></span>
          <p class="text-sm text-slate-200 mt-1">Lat: <?= $l['lat'] ?>, Lng: <?= $l['lng'] ?></p>
          <?php if ($l['deskripsi']): ?><p class="text-xs text-slate-300 mt-1"><?= htmlspecialchars($l['deskripsi']) ?></p><?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  const map = L.map('map').setView([-8.523, 116.412], 13);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OSM' }).addTo(map);
  <?php foreach ($lokasi as $l): ?>
    L.marker([<?= $l['lat'] ?>, <?= $l['lng'] ?>]).addTo(map)
      .bindPopup('<b><?= addslashes($l['nama']) ?></b><br><?= htmlspecialchars($l['kategori']) ?>');
  <?php endforeach; ?>
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
