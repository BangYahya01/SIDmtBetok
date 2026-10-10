<?php
// admin/index.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

// Hitung Statistik
$totalSurat = $pdo->query("SELECT COUNT(*) FROM permohonan_surat")->fetchColumn();
$suratPending = $pdo->query("SELECT COUNT(*) FROM permohonan_surat WHERE status = 'Menunggu Verifikasi'")->fetchColumn();
$totalBerita = $pdo->query("SELECT COUNT(*) FROM berita")->fetchColumn();
$totalAduan = $pdo->query("SELECT COUNT(*) FROM pengaduan")->fetchColumn();

// Permohonan Surat Terbaru
$stmtSurat = $pdo->query("SELECT * FROM permohonan_surat ORDER BY id DESC LIMIT 5");
$recentSurat = $stmtSurat->fetchAll();

// Aspirasi Warga Terbaru
$stmtAduan = $pdo->query("SELECT * FROM pengaduan ORDER BY id DESC LIMIT 5");
$recentAduan = $stmtAduan->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Operator Desa | Montong Betok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans text-slate-800 flex flex-col min-h-screen">

    <!-- TOPBAR ADMIN -->
    <header class="bg-slate-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="https://desamb.id/desa/logo/GkRCb_1762898002_logo__1_-removebg-preview.png" alt="Logo" class="h-9">
                <div>
                    <span class="text-sm font-black uppercase text-white tracking-wide block">Desa Montong Betok</span>
                    <span class="text-[10px] text-emerald-400 font-semibold block">Panel Administrator &bull; OpenSID v23</span>
                </div>
            </div>

            <div class="flex items-center space-x-4 text-xs">
                <a href="../index.php" target="_blank" class="text-slate-300 hover:text-white flex items-center gap-1">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Web
                </a>
                <span class="text-slate-600">|</span>
                <span class="text-slate-300">
                    <i class="fa-solid fa-user-circle text-emerald-400 mr-1"></i> <?= htmlspecialchars($_SESSION['admin_name']); ?>
                </span>
                <a href="logout.php" class="bg-rose-600 hover:bg-rose-700 text-white px-3 py-1.5 rounded font-bold transition">
                    <i class="fa-solid fa-power-off mr-1"></i> Keluar
                </a>
            </div>
        </div>
    </header>

    <!-- NAVIGATION TABS -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex space-x-2 py-2 text-xs font-semibold overflow-x-auto">
            <a href="index.php" class="bg-emerald-700 text-white px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="surat.php" class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-file-signature text-emerald-600"></i> Kelola Surat Masuk
                <?php if ($suratPending > 0): ?>
                <span class="bg-amber-500 text-slate-900 text-[10px] font-black px-1.5 py-0.2 rounded-full"><?= $suratPending; ?></span>
                <?php endif; ?>
            </a>
            <a href="berita.php" class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-newspaper text-emerald-600"></i> Kelola Berita Desa
            </a>
            <a href="pengaduan.php" class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-comments text-emerald-600"></i> Respon Pengaduan Warga
            </a>
            <a href="pengaduan.php" class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-comments text-emerald-600"></i> Kelola Staf Desa
            </a>
        </div>
    </div>

    <!-- MAIN BODY -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-grow w-full space-y-6">

        <!-- STATISTIC COUNTERS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Surat Pending Verifikasi</span>
                    <span class="text-2xl font-black text-amber-600 font-mono"><?= $suratPending; ?></span>
                    <span class="text-[10px] text-slate-400 block mt-0.5">Menunggu respon operator</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Total Permohonan Surat</span>
                    <span class="text-2xl font-black text-emerald-700 font-mono"><?= $totalSurat; ?></span>
                    <span class="text-[10px] text-slate-400 block mt-0.5">Semua pengajuan online</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Berita &amp; Artikel Terbit</span>
                    <span class="text-2xl font-black text-blue-700 font-mono"><?= $totalBerita; ?></span>
                    <span class="text-[10px] text-slate-400 block mt-0.5">Informasi publik desa</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-newspaper"></i>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 block">Aspirasi &amp; Aduan Warga</span>
                    <span class="text-2xl font-black text-rose-700 font-mono"><?= $totalAduan; ?></span>
                    <span class="text-[10px] text-slate-400 block mt-0.5">Partisipasi masyarakat</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-comments"></i>
                </div>
            </div>
        </div>

        <!-- 2 KOLOM TABEL DATA CEPAT -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Permohonan Surat Terbaru -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center">
                        <i class="fa-solid fa-file-signature text-emerald-600 mr-2"></i> Permohonan Surat Terbaru
                    </h3>
                    <a href="surat.php" class="text-xs text-emerald-700 hover:underline font-semibold">Kelola Semua &rarr;</a>
                </div>

                <div class="divide-y divide-slate-100 text-xs">
                    <?php foreach ($recentSurat as $s): 
                        $statusClass = 'bg-yellow-100 text-yellow-800';
                        if ($s['status'] === 'Sedang Diproses') $statusClass = 'bg-blue-100 text-blue-800';
                        if ($s['status'] === 'Siap Diambil') $statusClass = 'bg-emerald-100 text-emerald-800';
                        if ($s['status'] === 'Ditolak') $statusClass = 'bg-rose-100 text-rose-800';
                    ?>
                    <div class="py-2.5 flex justify-between items-center gap-2">
                        <div>
                            <span class="font-mono font-bold text-emerald-800 block"><?= htmlspecialchars($s['no_resi']); ?></span>
                            <span class="font-bold text-slate-900"><?= htmlspecialchars($s['nama']); ?></span>
                            <span class="text-[11px] text-slate-500 block"><?= htmlspecialchars($s['jenis_surat']); ?> &bull; <?= htmlspecialchars($s['dusun']); ?></span>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold <?= $statusClass; ?>">
                            <?= htmlspecialchars($s['status']); ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Pengaduan Terbaru -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-5 space-y-4">
                <div class="flex justify-between items-center border-b pb-3">
                    <h3 class="text-sm font-bold text-slate-900 flex items-center">
                        <i class="fa-solid fa-comments text-rose-600 mr-2"></i> Pengaduan Warga Terbaru
                    </h3>
                    <a href="pengaduan.php" class="text-xs text-emerald-700 hover:underline font-semibold">Tanggapi Semua &rarr;</a>
                </div>

                <div class="divide-y divide-slate-100 text-xs">
                    <?php foreach ($recentAduan as $a): 
                        $statusBadge = 'bg-yellow-100 text-yellow-800';
                        if ($a['status'] === 'Ditindaklanjuti') $statusBadge = 'bg-blue-100 text-blue-800';
                        if ($a['status'] === 'Selesai') $statusBadge = 'bg-emerald-100 text-emerald-800';
                    ?>
                    <div class="py-2.5 flex justify-between items-start gap-2">
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-slate-900"><?= htmlspecialchars($a['nama']); ?></span>
                                <span class="text-slate-400 text-[10px]">(<?= htmlspecialchars($a['dusun']); ?>)</span>
                            </div>
                            <p class="font-medium text-slate-700"><?= htmlspecialchars($a['judul']); ?></p>
                            <p class="text-slate-500 text-[11px] line-clamp-1"><?= htmlspecialchars($a['isi']); ?></p>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold shrink-0 <?= $statusBadge; ?>">
                            <?= htmlspecialchars($a['status']); ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

    </main>

</body>
</html>
