<?php
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$msg = '';

// Tambah titik SIG
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $stmt = $pdo->prepare("INSERT INTO lokasi (nama, lat, lng, kategori, dusun, foto, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nama'], (float)$_POST['lat'], (float)$_POST['lng'],
        $_POST['kategori'], $_POST['dusun'], $_POST['foto'], $_POST['deskripsi']
    ]);
    $msg = 'Lokasi SIG berhasil ditambahkan.';
}

// Hapus titik
if (isset($_GET['hapus'])) {
    $stmt = $pdo->prepare("DELETE FROM lokasi WHERE id = ?");
    $stmt->execute([(int)$_GET['hapus']]);
    $msg = 'Lokasi SIG dihapus.';
}

$lokasi = $pdo->query("SELECT * FROM lokasi ORDER BY kategori, nama")->fetchAll();
include __DIR__ . '/login_check.php';
?><!DOCTYPE html>
<html>
<head><title>Admin SIG — Desa Montong Betok</title>
<link rel="stylesheet" href="https://cdn.tailwindcss.com">
</head>
<body class="bg-slate-100 p-6">
<div class="max-w-4xl mx-auto bg-white rounded-xl shadow p-6">
<h1 class="text-xl font-bold text-emerald-800 mb-4">Admin SIG — Kelola Titik Peta</h1>
<?php if ($msg): ?><div class="bg-emerald-100 text-emerald-900 p-3 rounded mb-4"><?= $msg ?></div><?php endif; ?>

<form method="POST" class="grid md:grid-cols-3 gap-3 mb-6 bg-slate-50 p-4 rounded border border-slate-200">
  <input name="nama" placeholder="Nama lokasi" class="px-3 py-2 border rounded" required>
  <input name="lat" placeholder="Latitude" type="number" step="any" class="px-3 py-2 border rounded" required>
  <input name="lng" placeholder="Longitude" type="number" step="any" class="px-3 py-2 border rounded" required>
  <input name="kategori" placeholder="Kategori" class="px-3 py-2 border rounded" required>
  <input name="dusun" placeholder="Dusun" class="px-3 py-2 border rounded">
  <input name="foto" placeholder="URL foto (opsional)" class="px-3 py-2 border rounded">
  <textarea name="deskripsi" placeholder="Deskripsi" class="md:col-span-3 px-3 py-2 border rounded"></textarea>
  <button name="tambah" class="md:col-span-3 bg-emerald-700 text-white py-2 rounded font-bold hover:bg-emerald-600">+ Tambah Lokasi</button>
</form>

<table class="w-full text-sm border-collapse border border-slate-300">
<thead class="bg-emerald-800 text-white"><tr><th class="p-2 text-left">Nama</th><th>Lat</th><th>Lng</th><th>Kategori</th><th>Aksi</th></tr></thead>
<tbody>
<?php foreach ($lokasi as $l): ?>
<tr class="border-b hover:bg-slate-50">
  <td class="p-2"><?= htmlspecialchars($l['nama']) ?></td>
  <td class="p-2"><?= $l['lat'] ?></td>
  <td class="p-2"><?= $l['lng'] ?></td>
  <td class="p-2"><?= htmlspecialchars($l['kategori']) ?></td>
  <td class="p-2"><a href="?hapus=<?= $l['id'] ?>" onclick="return confirm('Hapus?')" class="text-red-600 hover:underline">Hapus</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</body>
</html>
