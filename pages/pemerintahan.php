<?php
// pages/pemerintahan.php
$stmt = $pdo->query("SELECT * FROM aparatur ORDER BY urutan ASC");
$allAparatur = $stmt->fetchAll();
?>
<div class="space-y-4">

    <!-- HEADER TITLE FORMAL -->
    <div class="card-custom p-4 bg-gradient-to-r from-emerald-900 to-teal-950 text-white border-0">
        <h2 class="text-lg sm:text-xl font-black uppercase tracking-wide">
            <i class="fa-solid fa-users-gear mr-2 text-amber-400"></i> Struktur Aparatur Pemerintah Desa
        </h2>
        <p class="text-xs text-emerald-200 mt-0.5">
            Pemerintah Desa Montong Betok, Kecamatan Montong Gading, Kabupaten Lombok Timur
        </p>
    </div>

    <!-- PIMPINAN DESA (PJ KADES & SEKDES) - FORMAL SHARP -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <?php foreach (array_slice($allAparatur, 0, 2) as $pimpinan): ?>
        <div class="card-custom p-3.5 flex flex-col sm:flex-row items-center sm:items-start gap-3 bg-white">
            <img src="<?= htmlspecialchars($pimpinan['foto'] ?: 'https://desamb.id/assets/images/pengguna/kuser.png'); ?>" alt="<?= htmlspecialchars($pimpinan['nama']); ?>" class="w-20 h-24 object-cover border-2 border-emerald-700 shadow-xs shrink-0">
            <div class="text-center sm:text-left space-y-1">
                <span class="text-[9px] font-bold uppercase tracking-wider text-emerald-900 bg-emerald-100 px-1.5 py-0.5 border border-emerald-300 inline-block font-mono">
                    Pimpinan Desa
                </span>
                <h3 class="text-xs sm:text-sm font-black text-slate-900 leading-snug"><?= htmlspecialchars($pimpinan['nama']); ?></h3>
                <p class="text-xs font-bold text-emerald-800"><?= htmlspecialchars($pimpinan['jabatan']); ?></p>
                <div class="pt-1 text-[11px] text-slate-600">
                    <span class="font-semibold text-emerald-700"><i class="fa-solid fa-check text-[9px] mr-1"></i>Status: <?= htmlspecialchars($pimpinan['status_kehadiran']); ?></span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- SEMUA PERANGKAT DESA & KADUS (FORMAL GRID) -->
    <div class="card-custom p-4">
        <div class="border-b border-slate-200 pb-2.5 mb-3 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center">
                <i class="fa-solid fa-id-badge text-emerald-700 mr-2"></i> Perangkat Desa &amp; Kepala Wilayah Dusun
            </h3>
            <span class="text-[11px] text-slate-500 font-mono">Total: <?= count($allAparatur); ?> Aparatur</span>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2.5">
            <?php foreach (array_slice($allAparatur, 2) as $item): ?>
            <div class="bg-white border border-slate-200 p-2.5 text-center flex flex-col justify-between hover:border-emerald-700 transition">
                <div>
                    <div class="w-16 h-20 mx-auto overflow-hidden border border-slate-300 mb-2">
                        <img src="<?= htmlspecialchars($item['foto'] ?: 'https://desamb.id/assets/images/pengguna/kuser.png'); ?>" alt="<?= htmlspecialchars($item['nama']); ?>" class="w-full h-full object-cover">
                    </div>
                    <h4 class="text-xs font-bold text-slate-900 line-clamp-1">
                        <?= htmlspecialchars($item['nama']); ?>
                    </h4>
                    <p class="text-[10px] text-emerald-800 font-semibold mt-0.5 line-clamp-2 leading-tight">
                        <?= htmlspecialchars($item['jabatan']); ?>
                    </p>
                </div>
                <div class="mt-2 pt-1.5 border-t border-slate-100">
                    <span class="text-[9px] font-mono font-bold text-slate-600 uppercase">
                        <?= htmlspecialchars($item['status_kehadiran']); ?>
                    </span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
