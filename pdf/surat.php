<?php
require_once __DIR__ . '/../../config/database.php';
$pdo = getDB();

if (!isset($_GET['id'])) {
    die('ID surat tidak ditemukan.');
}

$stmt = $pdo->prepare("SELECT * FROM permohonan_surat WHERE id = ?");
$stmt->execute([(int)$_GET['id']]);
$surat = $stmt->fetch();

if (!$surat) {
    die('Surat tidak ditemukan.');
}

$html = "<!DOCTYPE html><html><head><meta charset='utf-8'><title>Surat - {$surat['no_resi']}</title></head><body style='font-family:sans-serif;'>
<h2>Surat Keterangan — Desa Montong Betok</h2>
<p><b>No. Resi:</b> {$surat['no_resi']}</p>
<p><b>NIK:</b> {$surat['nik']}</p>
<p><b>Nama:</b> {$surat['nama']}</p>
<p><b>Dusun:</b> {$surat['dusun']}</p>
<p><b>Jenis Surat:</b> {$surat['jenis_surat']}</p>
<p><b>Status:</b> {$surat['status']}</p>
<hr>
<p>Diterbitkan otomatis oleh Sistem Informasi Desa Montong Betok.</p>
</body></html>";

header('Content-Type: text/html; charset=utf-8');
echo $html;
