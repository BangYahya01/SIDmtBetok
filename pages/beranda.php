<?php
// pages/beranda.php
$stmtSlider = $pdo->query("SELECT * FROM berita ORDER BY tanggal DESC, id DESC LIMIT 5");
$sliderNews = $stmtSlider->fetchAll();

$stmtBerita = $pdo->query("SELECT * FROM berita ORDER BY tanggal DESC, id DESC LIMIT 6");
$allNews = $stmtBerita->fetchAll();
?>

<!-- HERO SLIDER SECTION (FORMAL SHARP EDGES) -->
<section class="relative bg-slate-900 border border-slate-300" x-data="{
    active: 0,
    items: [
        <?php foreach ($sliderNews as $i => $item): ?>
        {
            title: '<?= addslashes(htmlspecialchars($item['judul'])); ?>',
            category: '<?= addslashes(htmlspecialchars($item['kategori'])); ?>',
            desc: '<?= addslashes(htmlspecialchars($item['ringkasan'])); ?>',
            img: '<?= addslashes(htmlspecialchars($item['gambar'])); ?>',
            link: 'index.php?page=detail-berita&id=<?= $item['id']; ?>'
        }<?= $i < count($sliderNews)-1 ? ',' : ''; ?>
        <?php endforeach; ?>
    ],
    next() { this.active = (this.active + 1) % this.items.length; },
    prev() { this.active = (this.active - 1 + this.items.length) % this.items.length; },
    init() {
        setInterval(() => { this.next(); }, 6000);
    }
}">
    <!-- Slider Image Container -->
    <div class="relative h-60 sm:h-72 md:h-80 w-full overflow-hidden bg-slate-950">
        <template x-for="(item, index) in items" :key="index">
            <div x-show="active === index" 
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="absolute inset-0">
                <img :src="item.img" :alt="item.title" class="w-full h-full object-cover opacity-60">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/50 to-transparent flex flex-col justify-end p-4 sm:p-6">
                    <span class="bg-amber-500 text-slate-950 text-[10px] font-black uppercase px-2 py-0.5 w-fit mb-1.5" x-text="item.category"></span>
                    <h2 class="text-lg sm:text-xl md:text-2xl font-black text-white leading-tight">
                        <a :href="item.link" class="hover:text-amber-300 transition" x-text="item.title"></a>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-200 mt-1 line-clamp-2 max-w-2xl" x-text="item.desc"></p>
                    
                    <div class="flex items-center justify-between mt-3 pt-2 border-t border-white/20">
                        <a :href="item.link" class="text-xs bg-emerald-700 hover:bg-emerald-600 text-white font-semibold px-3 py-1 transition inline-flex items-center gap-1 border border-emerald-500">
                            Selengkapnya <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </a>
                        <div class="flex items-center gap-1">
                            <template x-for="(dot, dotIndex) in items" :key="dotIndex">
                                <button @click="active = dotIndex" :class="active === dotIndex ? 'bg-amber-400 w-5' : 'bg-white/50 w-2'" class="h-1.5 transition-all"></button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Arrow navigation -->
    <button @click="prev()" class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black/90 text-white w-8 h-8 flex items-center justify-center transition">
        <i class="fa-solid fa-chevron-left text-xs"></i>
    </button>
    <button @click="next()" class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black/90 text-white w-8 h-8 flex items-center justify-center transition">
        <i class="fa-solid fa-chevron-right text-xs"></i>
    </button>
</section>

<!-- QUICK ACTION BUTTONS (FORMAL RECTANGULAR BOXES) -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
    <a href="index.php?page=layanan" class="card-custom p-3 flex flex-col items-center text-center group hover:bg-emerald-50/40 transition">
        <div class="w-10 h-10 bg-emerald-100 text-emerald-800 flex items-center justify-center text-xl mb-1.5 border border-emerald-300">
            <i class="fa-solid fa-file-circle-check"></i>
        </div>
        <span class="text-xs font-bold text-slate-900 uppercase tracking-tight">Layanan Surat</span>
        <span class="text-[10px] text-slate-500">Permohonan Online</span>
    </a>

    <a href="index.php?page=apbd" class="card-custom p-3 flex flex-col items-center text-center group hover:bg-emerald-50/40 transition">
        <div class="w-10 h-10 bg-amber-100 text-amber-800 flex items-center justify-center text-xl mb-1.5 border border-amber-300">
            <i class="fa-solid fa-chart-pie"></i>
        </div>
        <span class="text-xs font-bold text-slate-900 uppercase tracking-tight">APBDes 2026</span>
        <span class="text-[10px] text-slate-500">Transparansi Anggaran</span>
    </a>

    <a href="index.php?page=statistik" class="card-custom p-3 flex flex-col items-center text-center group hover:bg-emerald-50/40 transition">
        <div class="w-10 h-10 bg-blue-100 text-blue-800 flex items-center justify-center text-xl mb-1.5 border border-blue-300">
            <i class="fa-solid fa-users"></i>
        </div>
        <span class="text-xs font-bold text-slate-900 uppercase tracking-tight">Data Penduduk</span>
        <span class="text-[10px] text-slate-500">9.462 Jiwa Terdata</span>
    </a>

    <a href="index.php?page=pengaduan" class="card-custom p-3 flex flex-col items-center text-center group hover:bg-emerald-50/40 transition">
        <div class="w-10 h-10 bg-rose-100 text-rose-800 flex items-center justify-center text-xl mb-1.5 border border-rose-300">
            <i class="fa-solid fa-bullhorn"></i>
        </div>
        <span class="text-xs font-bold text-slate-900 uppercase tracking-tight">Pengaduan</span>
        <span class="text-[10px] text-slate-500">Aspirasi Warga</span>
    </a>

    <a href="index.php?page=peta" class="card-custom p-3 flex flex-col items-center text-center group hover:bg-emerald-50/40 transition">
        <div class="w-10 h-10 bg-violet-100 text-violet-800 flex items-center justify-center text-xl mb-1.5 border border-violet-300">
            <i class="fa-solid fa-map-location-dot"></i>
        </div>
        <span class="text-xs font-bold text-slate-900 uppercase tracking-tight">SIG Peta</span>
        <span class="text-[10px] text-slate-500">Wilayah Desa</span>
    </a>
</div>

<!-- SAMBUTAN PJ. KEPALA DESA (FORMAL INSTITUTIONAL BOX) -->
<div class="card-custom p-4 bg-white">
    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
        <div class="shrink-0 text-center">
            <img src="https://desamb.id/desa/upload/user_pict/SVD0D_1763441725979995.jpg" alt="Pj. Kepala Desa" class="w-20 h-24 object-cover border-2 border-emerald-700 shadow-xs mx-auto">
            <h4 class="text-xs font-bold text-slate-900 mt-1.5">Dian Asmara Desa, S.Pd</h4>
            <span class="text-[10px] text-emerald-900 font-semibold bg-emerald-100 px-2 py-0.5 border border-emerald-300 inline-block uppercase">Pj. Kepala Desa</span>
        </div>
        <div class="space-y-1.5 text-xs text-slate-700 leading-relaxed text-center sm:text-left">
            <div class="border-b border-slate-200 pb-1.5">
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider block">Pemerintah Desa Montong Betok</span>
                <h3 class="text-sm font-black text-slate-900 uppercase">
                    Sambutan Pj. Kepala Desa Montong Betok
                </h3>
            </div>
            <p class="italic text-slate-800 font-medium">
                "Assalamu’alaikum Warahmatullahi Wabarakatuh. Selamat datang di Portal Resmi Pemerintah Desa Montong Betok, Kecamatan Montong Gading, Kabupaten Lombok Timur."
            </p>
            <p>
                Website ini hadir sebagai media transparansi tata kelola pemerintahan, publikasi APBD desa, serta percepatan pelayanan administrasi masyarakat melalui Layanan Mandiri. Seluruh aparatur desa senantiasa berkomitmen memberikan pelayanan terbaik bagi warga.
            </p>
        </div>
    </div>
</div>

<!-- DAFTAR ARTIKEL & BERITA TERKINI -->
<div class="card-custom">
    <div class="p-3 border-b border-slate-200 flex justify-between items-center bg-slate-50">
        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center">
            <i class="fa-solid fa-newspaper text-emerald-700 mr-2"></i> Kabar &amp; Warta Terkini Desa
        </h3>
        <a href="index.php?page=berita" class="text-xs text-emerald-800 hover:underline font-semibold flex items-center gap-1">
            Indeks Berita <i class="fa-solid fa-angle-right text-[10px]"></i>
        </a>
    </div>

    <div class="p-3.5 grid grid-cols-1 md:grid-cols-2 gap-3.5">
        <?php foreach ($allNews as $news): ?>
        <article class="flex flex-col bg-white border border-slate-200 hover:border-emerald-600 transition group">
            <div class="h-40 overflow-hidden relative border-b border-slate-200">
                <img src="<?= htmlspecialchars($news['gambar'] ?: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=600'); ?>" alt="<?= htmlspecialchars($news['judul']); ?>" class="w-full h-full object-cover">
                <span class="absolute top-1.5 left-1.5 bg-emerald-800 text-white text-[10px] font-bold px-2 py-0.5 uppercase tracking-wide">
                    <?= htmlspecialchars($news['kategori']); ?>
                </span>
            </div>
            <div class="p-3 flex flex-col justify-between flex-grow space-y-2">
                <div>
                    <div class="flex items-center text-[10px] text-slate-500 gap-2.5 mb-1 font-mono">
                        <span><i class="fa-regular fa-calendar text-emerald-700 mr-1"></i><?= date('d/m/Y', strtotime($news['tanggal'])); ?></span>
                        <span><i class="fa-regular fa-user text-emerald-700 mr-1"></i><?= htmlspecialchars($news['penulis']); ?></span>
                    </div>
                    <h4 class="text-xs sm:text-sm font-bold text-slate-900 group-hover:text-emerald-800 transition line-clamp-2 leading-snug">
                        <a href="index.php?page=detail-berita&id=<?= $news['id']; ?>">
                            <?= htmlspecialchars($news['judul']); ?>
                        </a>
                    </h4>
                    <p class="text-xs text-slate-600 line-clamp-2 mt-1 leading-relaxed">
                        <?= htmlspecialchars($news['ringkasan']); ?>
                    </p>
                </div>
                <div class="pt-2 border-t border-slate-100 flex justify-between items-center text-[11px]">
                    <span class="text-slate-400 font-mono">
                        <i class="fa-regular fa-eye mr-1"></i><?= number_format($news['dilihat']); ?> kali
                    </span>
                    <a href="index.php?page=detail-berita&id=<?= $news['id']; ?>" class="font-bold text-emerald-800 hover:underline flex items-center gap-1">
                        Baca <i class="fa-solid fa-angle-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</div>

<!-- GALERI KEGIATAN DESA (FORMAL SHARP) -->
<div class="card-custom p-3.5">
    <div class="flex justify-between items-center border-b border-slate-200 pb-2 mb-3">
        <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center">
            <i class="fa-solid fa-camera text-emerald-700 mr-2"></i> Galeri Dokumentasi Kegiatan Desa
        </h3>
        <span class="text-[11px] text-slate-500">Pemerintah Desa &amp; KKN 2026</span>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
        <div class="group relative border border-slate-300 h-28 overflow-hidden">
            <img src="https://desamb.id/desa/upload/galeri/kecil_qxWId_1763109910_WhatsApp_Image_2025-11-13_at_13_19_38.webp" alt="Sosialisasi Pengolahan Sampah" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-950/70 p-1.5 flex items-end opacity-90">
                <p class="text-[10px] text-white font-medium line-clamp-1">Sosialisasi Sampah DLHK &amp; KKN</p>
            </div>
        </div>

        <div class="group relative border border-slate-300 h-28 overflow-hidden">
            <img src="https://desamb.id/desa/upload/galeri/kecil_A9D3h_1763109871_sunatan_masal.webp" alt="Gawe Desa Praja Yatim" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-950/70 p-1.5 flex items-end opacity-90">
                <p class="text-[10px] text-white font-medium line-clamp-1">Gawe Desa Praja Yatim</p>
            </div>
        </div>

        <div class="group relative border border-slate-300 h-28 overflow-hidden">
            <img src="https://desamb.id/desa/upload/galeri/kecil_GkRCb_1763689771_depan_kandes.webp" alt="Halaman Kantor Desa" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-950/70 p-1.5 flex items-end opacity-90">
                <p class="text-[10px] text-white font-medium line-clamp-1">Kantor Desa Montong Betok</p>
            </div>
        </div>

        <div class="group relative border border-slate-300 h-28 overflow-hidden">
            <img src="https://desamb.id/desa/upload/galeri/kecil_J7fsF_1763109888_WhatsApp_Image_2025-10-23_at_07_57_38_88178046.webp" alt="Khitanan Massal" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-slate-950/70 p-1.5 flex items-end opacity-90">
                <p class="text-[10px] text-white font-medium line-clamp-1">Khitanan Massal Desa</p>
            </div>
        </div>
    </div>
</div>
