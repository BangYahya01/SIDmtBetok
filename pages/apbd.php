<?php
// pages/apbd.php
$stmt = $pdo->query("SELECT * FROM apbd ORDER BY jenis DESC, id ASC");
$apbdRows = $stmt->fetchAll();

$totalPendapatanAnggaran = 0;
$totalPendapatanRealisasi = 0;
$totalBelanjaAnggaran = 0;
$totalBelanjaRealisasi = 0;

foreach ($apbdRows as $row) {
    if ($row['jenis'] === 'Pendapatan') {
        $totalPendapatanAnggaran += $row['anggaran'];
        $totalPendapatanRealisasi += $row['realisasi'];
    } elseif ($row['jenis'] === 'Belanja') {
        $totalBelanjaAnggaran += $row['anggaran'];
        $totalBelanjaRealisasi += $row['realisasi'];
    }
}
?>
<div class="space-y-4">

    <!-- HEADER TITLE FORMAL -->
    <div class="card-custom p-4 bg-gradient-to-r from-emerald-900 to-teal-950 text-white border-0">
        <h2 class="text-lg sm:text-xl font-black uppercase tracking-wide">
            <i class="fa-solid fa-chart-pie mr-2 text-amber-400"></i> Transparansi APBD Desa Tahun 2026
        </h2>
        <p class="text-xs text-emerald-200 mt-0.5">
            Akuntabilitas Publik Anggaran Pendapatan dan Belanja Desa Montong Betok
        </p>
    </div>

    <!-- RINGKASAN ANGGARAN & REALISASI (FORMAL SHARP) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <!-- Pendapatan -->
        <div class="card-custom p-4 bg-white">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-900">
                    <i class="fa-solid fa-arrow-down-long mr-1 text-emerald-700"></i> Total Pendapatan Desa
                </span>
                <span class="text-[10px] font-bold text-emerald-900 bg-emerald-100 px-1.5 py-0.5 border border-emerald-300 font-mono">
                    T.A 2026
                </span>
            </div>
            <div class="text-xl font-black text-slate-900 font-mono">
                Rp <?= number_format($totalPendapatanAnggaran, 0, ',', '.'); ?>
            </div>
            <div class="mt-2.5">
                <div class="flex justify-between text-[11px] text-slate-600 mb-1 font-mono">
                    <span>Realisasi: <strong>Rp <?= number_format($totalPendapatanRealisasi, 0, ',', '.'); ?></strong></span>
                    <span class="font-bold text-emerald-800">
                        <?= round(($totalPendapatanRealisasi / ($totalPendapatanAnggaran ?: 1)) * 100, 1); ?>%
                    </span>
                </div>
                <div class="w-full bg-slate-200 h-2 border border-slate-300">
                    <div class="bg-emerald-700 h-full" style="width: <?= min(100, ($totalPendapatanRealisasi / ($totalPendapatanAnggaran ?: 1)) * 100); ?>%"></div>
                </div>
            </div>
        </div>

        <!-- Belanja -->
        <div class="card-custom p-4 bg-white">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-amber-900">
                    <i class="fa-solid fa-arrow-up-long mr-1 text-amber-700"></i> Total Belanja Desa
                </span>
                <span class="text-[10px] font-bold text-amber-900 bg-amber-100 px-1.5 py-0.5 border border-amber-300 font-mono">
                    T.A 2026
                </span>
            </div>
            <div class="text-xl font-black text-slate-900 font-mono">
                Rp <?= number_format($totalBelanjaAnggaran, 0, ',', '.'); ?>
            </div>
            <div class="mt-2.5">
                <div class="flex justify-between text-[11px] text-slate-600 mb-1 font-mono">
                    <span>Realisasi: <strong>Rp <?= number_format($totalBelanjaRealisasi, 0, ',', '.'); ?></strong></span>
                    <span class="font-bold text-amber-800">
                        <?= round(($totalBelanjaRealisasi / ($totalBelanjaAnggaran ?: 1)) * 100, 1); ?>%
                    </span>
                </div>
                <div class="w-full bg-slate-200 h-2 border border-slate-300">
                    <div class="bg-amber-600 h-full" style="width: <?= min(100, ($totalBelanjaRealisasi / ($totalBelanjaAnggaran ?: 1)) * 100); ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABEL RINCIAN PENDAPATAN & BELANJA (FORMAL RECTANGULAR TABLE) -->
    <div class="card-custom p-4">
        <div class="border-b border-slate-200 pb-2 mb-3 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center">
                <i class="fa-solid fa-file-invoice-dollar text-emerald-700 mr-2"></i> Rincian APBDes Montong Betok
            </h3>
            <span class="text-[11px] text-slate-500 font-mono">Tahun Anggaran 2026</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border border-slate-200">
                <thead class="bg-slate-100 text-slate-800 font-bold border-b border-slate-300 uppercase text-[11px]">
                    <tr>
                        <th class="py-2 px-3 border-r border-slate-200">Klasifikasi</th>
                        <th class="py-2 px-3 border-r border-slate-200">Uraian / Rincian Program</th>
                        <th class="py-2 px-3 text-right border-r border-slate-200">Anggaran (Rp)</th>
                        <th class="py-2 px-3 text-right border-r border-slate-200">Realisasi (Rp)</th>
                        <th class="py-2 px-3 text-center">Persentase</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700">
                    <?php foreach ($apbdRows as $row): 
                        $pct = round(($row['realisasi'] / ($row['anggaran'] ?: 1)) * 100, 1);
                        $badge = ($row['jenis'] === 'Pendapatan') ? 'bg-emerald-100 text-emerald-900 border-emerald-300' : 'bg-amber-100 text-amber-900 border-amber-300';
                    ?>
                    <tr class="hover:bg-slate-50">
                        <td class="py-1.5 px-3 border-r border-slate-200 whitespace-nowrap">
                            <span class="px-1.5 py-0.5 text-[9px] font-bold border <?= $badge; ?> uppercase">
                                <?= htmlspecialchars($row['jenis']); ?>
                            </span>
                        </td>
                        <td class="py-1.5 px-3 border-r border-slate-200 font-medium text-slate-900">
                            <?= htmlspecialchars($row['rincian']); ?>
                        </td>
                        <td class="py-1.5 px-3 text-right border-r border-slate-200 font-mono font-semibold">
                            <?= number_format($row['anggaran'], 0, ',', '.'); ?>
                        </td>
                        <td class="py-1.5 px-3 text-right border-r border-slate-200 font-mono text-emerald-800 font-semibold">
                            <?= number_format($row['realisasi'], 0, ',', '.'); ?>
                        </td>
                        <td class="py-1.5 px-3 text-center font-bold font-mono">
                            <?= $pct; ?>%
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
