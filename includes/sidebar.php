<?php
// includes/sidebar.php
if (!isset($pdo)) {
    require_once __DIR__ . '/../config/database.php';
    $pdo = getDB();
}

// Ambil data aparatur teratas (Kades & Sekdes)
$stmtAparatur = $pdo->query("SELECT * FROM aparatur ORDER BY urutan ASC LIMIT 4");
$aparaturs = $stmtAparatur->fetchAll();

// Ambil berita terbaru untuk widget
$stmtRecent = $pdo->query("SELECT id, judul, slug, tanggal, gambar FROM berita ORDER BY tanggal DESC, id DESC LIMIT 4");
$recentNews = $stmtRecent->fetchAll();
?>
<aside class="space-y-4">

    <!-- WIDGET 1: PENCARIAN BERITA (FORMAL SHARP) -->
    <div class="card-custom p-3.5">
        <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-2 mb-2.5 uppercase tracking-wide flex items-center justify-between">
            <span><i class="fa-solid fa-magnifying-glass text-emerald-700 mr-1.5"></i> Pencarian Portal</span>
        </h3>
        <form action="index.php" method="GET" class="space-y-2">
            <input type="hidden" name="page" value="berita">
            <div class="relative">
                <input type="text" name="cari" value="<?= htmlspecialchars($_GET['cari'] ?? '') ?>" placeholder="Ketik kata kunci..." class="w-full pl-8 pr-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-600 bg-white">
                <i class="fa-solid fa-search absolute left-2.5 top-2 text-slate-400 text-xs"></i>
            </div>
            <button type="submit" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-semibold py-1.5 text-xs transition border border-emerald-800">
                Cari Berita
            </button>
        </form>
    </div>

    <!-- WIDGET 2: APARATUR DESA (FORMAL SQUARE AVATARS) -->
    <div class="card-custom p-3.5">
        <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2.5">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center">
                <i class="fa-solid fa-users text-emerald-700 mr-1.5"></i> Aparatur Desa
            </h3>
            <a href="index.php?page=pemerintahan" class="text-[11px] text-emerald-700 hover:underline font-semibold">Semua &rarr;</a>
        </div>
        
        <div class="space-y-2">
            <?php foreach ($aparaturs as $ap): ?>
            <div class="flex items-center gap-2.5 p-2 bg-slate-50 border border-slate-200">
                <img src="<?= htmlspecialchars($ap['foto'] ?: 'https://desamb.id/assets/images/pengguna/kuser.png'); ?>" alt="<?= htmlspecialchars($ap['nama']); ?>" class="w-10 h-11 object-cover border border-slate-300 shrink-0">
                <div class="overflow-hidden leading-tight">
                    <h4 class="text-xs font-bold text-slate-900 truncate"><?= htmlspecialchars($ap['nama']); ?></h4>
                    <p class="text-[11px] text-emerald-800 font-medium truncate mt-0.5"><?= htmlspecialchars($ap['jabatan']); ?></p>
                    <span class="inline-block text-[9px] font-bold text-emerald-700 uppercase mt-0.5">
                        <i class="fa-solid fa-check text-[8px] mr-0.5"></i><?= htmlspecialchars($ap['status_kehadiran']); ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- WIDGET 3: STATISTIK PENDUDUK RINGKAS -->
    <div class="card-custom p-3.5">
        <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-2.5">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center">
                <i class="fa-solid fa-chart-pie text-emerald-700 mr-1.5"></i> Demografi Penduduk
            </h3>
            <a href="index.php?page=statistik" class="text-[11px] text-emerald-700 hover:underline font-semibold">Rincian &rarr;</a>
        </div>

        <div class="grid grid-cols-2 gap-2 text-center mb-2">
            <div class="bg-slate-50 border border-slate-200 p-2">
                <span class="text-[10px] uppercase font-bold text-slate-500 block">Laki-Laki</span>
                <span class="text-sm font-black text-blue-700 font-mono">4.638</span>
                <span class="text-[10px] text-slate-500 block">49.02%</span>
            </div>
            <div class="bg-slate-50 border border-slate-200 p-2">
                <span class="text-[10px] uppercase font-bold text-slate-500 block">Perempuan</span>
                <span class="text-sm font-black text-rose-700 font-mono">4.824</span>
                <span class="text-[10px] text-slate-500 block">50.98%</span>
            </div>
        </div>

        <div class="bg-emerald-50 border border-emerald-200 p-2.5 text-center">
            <span class="text-[10px] font-bold text-slate-600 uppercase block">Total Penduduk Terdaftar</span>
            <div class="text-base font-black text-emerald-950 font-mono leading-tight">9.462 <span class="text-xs font-medium text-slate-600">Jiwa</span></div>
            <span class="text-[10px] text-emerald-800 font-medium block mt-0.5">5 Dusun Se-Desa Montong Betok</span>
        </div>
    </div>

    <!-- WIDGET 4: BERITA TERKINI -->
    <div class="card-custom p-3.5">
        <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-2 mb-2.5 uppercase tracking-wide flex items-center">
            <i class="fa-solid fa-newspaper text-emerald-700 mr-1.5"></i> Berita Terkini
        </h3>
        <div class="space-y-2.5">
            <?php foreach ($recentNews as $news): ?>
            <a href="index.php?page=detail-berita&id=<?= $news['id']; ?>" class="flex gap-2 group pb-2 border-b border-slate-100 last:border-0 last:pb-0">
                <img src="<?= htmlspecialchars($news['gambar'] ?: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=300'); ?>" alt="<?= htmlspecialchars($news['judul']); ?>" class="w-14 h-12 object-cover border border-slate-200 shrink-0">
                <div class="overflow-hidden">
                    <h4 class="text-xs font-bold text-slate-800 line-clamp-2 group-hover:text-emerald-700 transition leading-snug">
                        <?= htmlspecialchars($news['judul']); ?>
                    </h4>
                    <span class="text-[10px] text-slate-400 mt-0.5 block font-mono">
                        <i class="fa-regular fa-calendar mr-1 text-emerald-600"></i><?= date('d M Y', strtotime($news['tanggal'])); ?>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- WIDGET 5: AGENDA & JADWAL LAYANAN -->
    <div class="card-custom p-3.5">
        <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-2 mb-2.5 uppercase tracking-wide flex items-center">
            <i class="fa-solid fa-calendar-check text-emerald-700 mr-1.5"></i> Jam Layanan Kantor
        </h3>
        <div class="space-y-1.5 text-xs text-slate-700">
            <div class="flex justify-between py-1 border-b border-slate-200">
                <span class="font-medium">Senin - Kamis</span>
                <span class="font-bold text-slate-900 font-mono">08:00 - 15:30 WITA</span>
            </div>
            <div class="flex justify-between py-1 border-b border-slate-200">
                <span class="font-medium">Jumat</span>
                <span class="font-bold text-slate-900 font-mono">08:00 - 11:30 WITA</span>
            </div>
            <div class="flex justify-between py-1 text-rose-700">
                <span class="font-medium">Sabtu - Minggu</span>
                <span class="font-bold">Libur Pelayanan</span>
            </div>
        </div>
        <div class="mt-2.5 bg-amber-50 border border-amber-200 p-2 text-[11px] text-amber-950">
            <i class="fa-solid fa-circle-info text-amber-600 mr-1"></i> Pengajuan permohonan surat online dapat dilakukan <strong>24 Jam</strong>.
        </div>
    </div>

    <!-- WIDGET 6: PETA KANTOR DESA -->
    <div class="card-custom p-3.5">
        <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-2 mb-2.5 uppercase tracking-wide flex items-center">
            <i class="fa-solid fa-map-location-dot text-emerald-700 mr-1.5"></i> Lokasi Kantor Desa
        </h3>
        <div class="border border-slate-300 mb-2">
            <iframe 
                src="https://www.openstreetmap.org/export/embed.html?bbox=116.3945545%2C-8.6096261%2C116.4145545%2C-8.5896261&amp;layer=mapnik&amp;marker=-8.5996261%2C116.4045545" 
                class="w-full h-40 border-0" 
                loading="lazy">
            </iframe>
        </div>
        <a href="https://www.openstreetmap.org/#map=16/-8.5996261/116.4045545" target="_blank" class="block text-center text-xs text-emerald-800 hover:underline font-semibold">
            <i class="fa-solid fa-arrow-up-right-from-square mr-1 text-[10px]"></i> Buka di OpenStreetMap
        </a>
    </div>

</aside>
