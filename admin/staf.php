<?php
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    $stmt = $pdo->prepare("INSERT INTO aparatur (nama, jabatan, foto, status_kehadiran, urutan) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$_POST['nama'], $_POST['jabatan'], $_POST['foto'], $_POST['status'], (int)$_POST['urutan']]);
    $msg = 'Staf/aparatur ditambahkan.';
}
$staf = $pdo->query("SELECT * FROM aparatur ORDER BY urutan ASC")->fetchAll();
include __DIR__ . '/login_check.php';
?><!DOCTYPE html>
<html><head><title>Kelola Staf — Admin</title>
<script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-100 p-6">
<div class="max-w-5xl mx-auto bg-white rounded-xl shadow p-6">
<h1 class="text-xl font-bold text-emerald-800 mb-4">Kelola Staf &amp; Aparatur Desa</h1>
<?php if ($msg): ?><div class="bg-emerald-100 p-3 rounded mb-4 text-sm"><?= $msg ?></div><?php endif; ?>
<form method="POST" class="grid md:grid-cols-4 gap-2 mb-4 bg-slate-50 p-3 rounded border">
  <input name="nama" placeholder="Nama" class="px-2 py-1 border rounded text-xs" required>
  <input name="jabatan" placeholder="Jabatan" class="px-2 py-1 border rounded text-xs">
  <input name="foto" placeholder="URL foto" class="px-2 py-1 border rounded text-xs">
  <input name="status" placeholder="Status (Hadir/Tidak)" class="px-2 py-1 border rounded text-xs">
  <input name="urutan" placeholder="Urutan" type="number" class="px-2 py-1 border rounded text-xs">
  <button name="tambah" class="md:col-span-4 bg-emerald-700 text-white py-1.5 rounded font-bold text-xs">+ Tambah Aparatur</button>
</form>
<table class="w-full text-xs border-collapse border border-slate-200">
<thead class="bg-emerald-800 text-white"><tr><th class="p-2">Nama</th><th>Jabatan</th><th>Status</th><th>Urutan</th></tr></thead>
<tbody>
<?php foreach ($staf as $s): ?>
<tr class="border-b hover:bg-slate-50">
  <td class="p-2 font-bold"><?= htmlspecialchars($s['nama']) ?></td>
  <td class="p-2"><?= htmlspecialchars($s['jabatan']) ?></td>
  <td class="p-2"><?= htmlspecialchars($s['status_kehadiran']) ?></td>
  <td class="p-2"><?= $s['urutan'] ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
</body>
</html>
