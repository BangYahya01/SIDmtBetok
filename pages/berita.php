<?php
// pages/berita.php
$cari = trim($_GET['cari'] ?? '');
$kategori = trim($_GET['kategori'] ?? '');

$sql = "SELECT * FROM berita WHERE 1=1";
$params = [];

if (!empty($cari)) {
    $sql .= " AND (judul LIKE ? OR isi LIKE ? OR ringkasan LIKE ?)";
    $params[] = "%$cari%";
    $params[] = "%$cari%";
    $params[] = "%$cari%";
}

if (!empty($kategori)) {
    $sql .= " AND kategori = ?";
    $params[] = $kategori;
}

$sql .= " ORDER BY tanggal DESC, id DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$beritaList = $stmt->fetchAll();

// Ambil daftar kategori unik
$stmtKat = $pdo->query("SELECT DISTINCT kategori FROM berita ORDER BY kategori ASC");
$kategoriList = $stmtKat->fetchAll(PDO::FETCH_COLUMN);
?>
<div class="space-y-4">

    <!-- HEADER TITLE FORMAL -->
    <div class="card-custom p-4 bg-gradient-to-r from-emerald-900 to-teal-950 text-white border-0">
        <h2 class="text-lg sm:text-xl font-black uppercase tracking-wide">
            <i class="fa-solid fa-newspaper mr-2 text-amber-400"></i> Kabar &amp; Warta Desa
        </h2>
        <p class="text-xs text-emerald-200 mt-0.5">
            Informasi Terkini, Pengumuman, dan Dokumentasi Kegiatan Resmi Desa Montong Betok
        </p>
    </div>

    <!-- FILTER & PENCARIAN (FORMAL SHARP) -->
    <div class="card-custom p-3 bg-slate-50">
        <form action="index.php" method="GET" class="flex flex-col sm:flex-row gap-2 items-center">
            <input type="hidden" name="page" value="berita">
            
            <div class="w-full sm:w-1/3">
                <select name="kategori" onchange="this.form.submit()" class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white">
                    <option value="">-- Semua Kategori Berita --</option>
                    <?php foreach ($kategoriList as $kat): ?>
                    <option value="<?= htmlspecialchars($kat); ?>" <?= ($kategori === $kat) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($kat); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="w-full sm:w-2/3 flex gap-1.5">
                <input type="text" name="cari" value="<?= htmlspecialchars($cari); ?>" placeholder="Ketik kata kunci berita..." class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white">
                <button type="submit" class="px-3.5 py-1.5 bg-emerald-700 hover:bg-emerald-800 text-white text-xs font-bold transition shrink-0 border border-emerald-800">
                    <i class="fa-solid fa-search"></i>
                </button>
                <?php if (!empty($cari) || !empty($kategori)): ?>
                <a href="index.php?page=berita" class="px-3 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-semibold transition shrink-0 border border-slate-300">
                    Reset
                </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- DAFTAR BERITA (FORMAL SHARP CARDS) -->
    <?php if (!empty($beritaList)): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
        <?php foreach ($beritaList as $news): ?>
        <article class="card-custom overflow-hidden flex flex-col justify-between hover:border-emerald-700 transition group">
            <div>
                <div class="h-44 overflow-hidden relative border-b border-slate-200">
                    <img src="<?= htmlspecialchars($news['gambar'] ?: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600'); ?>" alt="<?= htmlspecialchars($news['judul']); ?>" class="w-full h-full object-cover">
                    <span class="absolute top-1.5 left-1.5 bg-emerald-800 text-white text-[10px] font-bold px-2 py-0.5 uppercase tracking-wide">
                        <?= htmlspecialchars($news['kategori']); ?>
                    </span>
                </div>
                <div class="p-3 space-y-1.5">
                    <div class="flex items-center text-[10px] text-slate-500 gap-2.5 font-mono">
                        <span><i class="fa-regular fa-calendar text-emerald-700 mr-1"></i><?= date('d/m/Y', strtotime($news['tanggal'])); ?></span>
                        <span><i class="fa-regular fa-user text-emerald-700 mr-1"></i><?= htmlspecialchars($news['penulis']); ?></span>
                    </div>
                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-emerald-800 transition line-clamp-2 leading-snug">
                        <a href="index.php?page=detail-berita&id=<?= $news['id']; ?>">
                            <?= htmlspecialchars($news['judul']); ?>
                        </a>
                    </h3>
                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed">
                        <?= htmlspecialchars($news['ringkasan']); ?>
                    </p>
                </div>
            </div>
            
            <div class="p-3 pt-2 border-t border-slate-100 flex justify-between items-center text-xs">
                <span class="text-[10px] text-slate-400 font-mono">
                    <i class="fa-regular fa-eye mr-1"></i><?= number_format($news['dilihat']); ?> kali
                </span>
                <a href="index.php?page=detail-berita&id=<?= $news['id']; ?>" class="font-bold text-emerald-800 hover:underline flex items-center gap-1">
                    Baca <i class="fa-solid fa-angle-right text-[10px]"></i>
                </a>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="card-custom p-6 text-center text-slate-500 space-y-1.5">
        <i class="fa-regular fa-folder-open text-3xl text-slate-400"></i>
        <p class="text-xs">Tidak ada berita yang sesuai dengan filter atau kata kunci Anda.</p>
        <a href="index.php?page=berita" class="inline-block text-xs font-semibold text-emerald-800 underline">
            Lihat semua berita
        </a>
    </div>
    <?php endif; ?>

</div>
