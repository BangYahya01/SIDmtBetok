<?php
// pages/detail-berita.php
$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("SELECT * FROM berita WHERE id = ?");
$stmt->execute([$id]);
$news = $stmt->fetch();

if (!$news) {
    echo '<div class="card-custom p-6 text-center text-slate-600 text-xs">Berita tidak ditemukan. <a href="index.php?page=berita" class="text-emerald-800 font-bold underline">Kembali ke Berita</a></div>';
    return;
}

// Update views
$pdo->prepare("UPDATE berita SET dilihat = dilihat + 1 WHERE id = ?")->execute([$id]);
$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div class="space-y-4">

    <!-- BREADCRUMB (FORMAL) -->
    <nav class="flex text-xs text-slate-500 gap-1.5 items-center">
        <a href="index.php?page=beranda" class="hover:text-emerald-800">Beranda</a>
        <i class="fa-solid fa-angle-right text-[9px]"></i>
        <a href="index.php?page=berita" class="hover:text-emerald-800">Kabar Desa</a>
        <i class="fa-solid fa-angle-right text-[9px]"></i>
        <span class="text-slate-800 font-semibold truncate max-w-xs"><?= htmlspecialchars($news['judul']); ?></span>
    </nav>

    <!-- ARTIKEL UTAMA (FORMAL SHARP) -->
    <article class="card-custom p-5 space-y-4">
        <div>
            <span class="bg-emerald-100 text-emerald-900 text-[10px] font-bold px-2 py-0.5 border border-emerald-300 inline-block mb-2 uppercase tracking-wide">
                <?= htmlspecialchars($news['kategori']); ?>
            </span>
            <h1 class="text-lg sm:text-xl md:text-2xl font-black text-slate-900 leading-tight">
                <?= htmlspecialchars($news['judul']); ?>
            </h1>

            <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mt-2 pt-2 border-t border-slate-200 font-mono">
                <span><i class="fa-regular fa-calendar text-emerald-700 mr-1"></i> <?= date('d F Y', strtotime($news['tanggal'])); ?></span>
                <span><i class="fa-regular fa-user text-emerald-700 mr-1"></i> <?= htmlspecialchars($news['penulis']); ?></span>
                <span><i class="fa-regular fa-eye text-emerald-700 mr-1"></i> <?= number_format($news['dilihat'] + 1); ?> kali dibaca</span>
            </div>
        </div>

        <?php if (!empty($news['gambar'])): ?>
        <div class="border border-slate-300">
            <img src="<?= htmlspecialchars($news['gambar']); ?>" alt="<?= htmlspecialchars($news['judul']); ?>" class="w-full max-h-[420px] object-cover">
        </div>
        <?php endif; ?>

        <!-- KONTEN ARTIKEL -->
        <div class="text-xs sm:text-sm text-slate-800 leading-relaxed space-y-3 pt-1 border-b border-slate-200 pb-5">
            <?= $news['isi']; ?>
        </div>

        <!-- SHARE KE MEDIA SOSIAL (FORMAL SQUARE BUTTONS) -->
        <div class="flex flex-wrap justify-between items-center gap-2 pt-1">
            <div class="flex items-center gap-1.5 text-xs font-bold text-slate-800">
                <span class="uppercase text-[11px]">Bagikan:</span>
                <a href="https://api.whatsapp.com/send?text=<?= urlencode($news['judul'] . ' - ' . $currentUrl); ?>" target="_blank" class="w-7 h-7 bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-700 transition text-xs border border-emerald-700">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($currentUrl); ?>" target="_blank" class="w-7 h-7 bg-blue-700 text-white flex items-center justify-center hover:bg-blue-800 transition text-xs border border-blue-800">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?text=<?= urlencode($news['judul'] . ' ' . $currentUrl); ?>" target="_blank" class="w-7 h-7 bg-slate-900 text-white flex items-center justify-center hover:bg-slate-800 transition text-xs border border-slate-900">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
            </div>

            <a href="index.php?page=berita" class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold px-3 py-1.5 transition inline-flex items-center gap-1 border border-slate-300">
                <i class="fa-solid fa-arrow-left text-[10px]"></i> Kembali ke Arsip Berita
            </a>
        </div>
    </article>

</div>
