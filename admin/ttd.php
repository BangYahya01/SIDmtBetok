<?php
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload_ttd'])) {
    $file = $_FILES['ttd_file'] ?? null;
    if ($file && $file['error'] === 0) {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowed = ['png','jpg','jpeg','gif'];
        if (in_array($ext, $allowed)) {
            $path = __DIR__ . '/../uploads/ttd/' . 'ttd_' . date('YmdHis') . '.' . $ext;
            move_uploaded_file($file['tmp_name'], $path);
            $msg = 'Tanda tangan digital berhasil diunggah: ' . basename($path);
        } else {
            $msg = 'Format file tidak didukung. Gunakan PNG/JPG.';
        }
    } else {
        $msg = 'Pilih file tanda tangan.';
    }
}
include __DIR__ . '/login_check.php';
?><!DOCTYPE html>
<html><head><title>Tanda Tangan Digital</title><script src="https://cdn.tailwindcss.com"></script></head>
<body class="bg-slate-100 p-6">
<div class="max-w-md mx-auto bg-white rounded-xl shadow p-6">
<h1 class="text-xl font-bold text-emerald-800 mb-4">Tanda Tangan Digital</h1>
<?php if ($msg): ?><div class="bg-emerald-100 p-3 rounded mb-4 text-sm"><?= $msg ?></div><?php endif; ?>
<form method="POST" enctype="multipart/form-data" class="space-y-4">
  <label class="block text-sm font-bold">Unggah gambar tanda tangan (PNG/JPG)</label>
  <input type="file" name="ttd_file" accept="image/png,image/jpeg,image/jpg,image/gif" class="w-full border rounded px-2 py-1 text-xs" required>
  <button name="upload_ttd" class="w-full bg-violet-700 hover:bg-violet-800 text-white font-bold py-2 rounded">Upload Tanda Tangan</button>
</form>
<p class="text-xs text-slate-500 mt-3">File akan disimpan di <code>uploads/ttd/</code> dan dapat digunakan untuk PDF surat.</p>
</div>
</body></html>
