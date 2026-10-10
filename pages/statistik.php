<?php
// pages/statistik.php
?>
<div class="space-y-4">

    <!-- HEADER TITLE FORMAL -->
    <div class="card-custom p-4 bg-gradient-to-r from-emerald-900 to-teal-950 text-white border-0">
        <h2 class="text-lg sm:text-xl font-black uppercase tracking-wide">
            <i class="fa-solid fa-chart-column mr-2 text-amber-400"></i> Statistik Kependudukan &amp; Demografi
        </h2>
        <p class="text-xs text-emerald-200 mt-0.5">
            Data Demografi Resmi Desa Montong Betok Berdasarkan Buku Administrasi Kependudukan
        </p>
    </div>

    <!-- SUMMARY CARDS (FORMAL SHARP BOXES) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center">
        <div class="bg-white p-3 border border-slate-300">
            <span class="text-[10px] uppercase font-bold text-slate-500 block">Total Penduduk</span>
            <span class="text-lg font-black text-slate-900 font-mono">9.462</span>
            <span class="text-[10px] text-emerald-800 font-semibold block">Jiwa</span>
        </div>
        <div class="bg-white p-3 border border-slate-300">
            <span class="text-[10px] uppercase font-bold text-slate-500 block">Laki-Laki</span>
            <span class="text-lg font-black text-blue-700 font-mono">4.638</span>
            <span class="text-[10px] text-slate-500 block">49.02%</span>
        </div>
        <div class="bg-white p-3 border border-slate-300">
            <span class="text-[10px] uppercase font-bold text-slate-500 block">Perempuan</span>
            <span class="text-lg font-black text-rose-700 font-mono">4.824</span>
            <span class="text-[10px] text-slate-500 block">50.98%</span>
        </div>
        <div class="bg-white p-3 border border-slate-300">
            <span class="text-[10px] uppercase font-bold text-slate-500 block">Kepala Keluarga</span>
            <span class="text-lg font-black text-amber-700 font-mono">2.784</span>
            <span class="text-[10px] text-slate-500 block">KK</span>
        </div>
    </div>

    <!-- GRAFIK 1: GENDER & DUSUN (FORMAL SHARP) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <!-- Chart Gender -->
        <div class="card-custom p-3.5">
            <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-1.5 mb-2.5 uppercase tracking-wide flex items-center justify-between">
                <span><i class="fa-solid fa-venus-mars text-emerald-700 mr-1.5"></i> Komposisi Jenis Kelamin</span>
                <span class="text-[10px] text-slate-500 font-mono">Persentase</span>
            </h3>
            <div class="h-56 flex items-center justify-center">
                <canvas id="chartGender"></canvas>
            </div>
        </div>

        <!-- Chart Dusun -->
        <div class="card-custom p-3.5">
            <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-1.5 mb-2.5 uppercase tracking-wide flex items-center justify-between">
                <span><i class="fa-solid fa-map-location-dot text-emerald-700 mr-1.5"></i> Persebaran per Dusun</span>
                <span class="text-[10px] text-slate-500 font-mono">Jiwa</span>
            </h3>
            <div class="h-56 flex items-center justify-center">
                <canvas id="chartDusun"></canvas>
            </div>
        </div>
    </div>

    <!-- GRAFIK 2: PEKERJAAN & KELOMPOK UMUR (FORMAL SHARP) -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <!-- Chart Pekerjaan -->
        <div class="card-custom p-3.5">
            <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-1.5 mb-2.5 uppercase tracking-wide flex items-center justify-between">
                <span><i class="fa-solid fa-briefcase text-emerald-700 mr-1.5"></i> Mata Pencaharian / Pekerjaan</span>
                <span class="text-[10px] text-slate-500 font-mono">Mayoritas</span>
            </h3>
            <div class="h-56 flex items-center justify-center">
                <canvas id="chartPekerjaan"></canvas>
            </div>
        </div>

        <!-- Chart Umur -->
        <div class="card-custom p-3.5">
            <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-1.5 mb-2.5 uppercase tracking-wide flex items-center justify-between">
                <span><i class="fa-solid fa-children text-emerald-700 mr-1.5"></i> Kelompok Rentang Usia</span>
                <span class="text-[10px] text-slate-500 font-mono">Demografi</span>
            </h3>
            <div class="h-56 flex items-center justify-center">
                <canvas id="chartUmur"></canvas>
            </div>
        </div>
    </div>

    <!-- TABEL DATA DUSUN (FORMAL RECTANGULAR TABLE) -->
    <div class="card-custom p-3.5">
        <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-2 mb-2.5 uppercase tracking-wide flex items-center">
            <i class="fa-solid fa-table-list text-emerald-700 mr-2"></i> Rincian Kependudukan Wilayah Dusun
        </h3>
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left border border-slate-200">
                <thead class="bg-slate-100 text-slate-800 font-bold border-b border-slate-300 uppercase text-[11px]">
                    <tr>
                        <th class="py-2 px-3 border-r border-slate-200">No</th>
                        <th class="py-2 px-3 border-r border-slate-200">Wilayah Dusun</th>
                        <th class="py-2 px-3 border-r border-slate-200">Kepala Dusun (Kadus)</th>
                        <th class="py-2 px-3 text-center border-r border-slate-200">Laki-Laki</th>
                        <th class="py-2 px-3 text-center border-r border-slate-200">Perempuan</th>
                        <th class="py-2 px-3 text-center">Total Jiwa</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 text-slate-700">
                    <tr class="hover:bg-slate-50">
                        <td class="py-1.5 px-3 border-r border-slate-200 font-semibold font-mono">1</td>
                        <td class="py-1.5 px-3 border-r border-slate-200 font-bold text-slate-900">Dusun Lekong Rempung</td>
                        <td class="py-1.5 px-3 border-r border-slate-200">Feri Jayadi, S.Pd</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">1.050</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">1.090</td>
                        <td class="py-1.5 px-3 text-center font-bold text-emerald-900 font-mono bg-emerald-50/40">2.140</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="py-1.5 px-3 border-r border-slate-200 font-semibold font-mono">2</td>
                        <td class="py-1.5 px-3 border-r border-slate-200 font-bold text-slate-900">Dusun Mujur</td>
                        <td class="py-1.5 px-3 border-r border-slate-200">Saroan</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">970</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">1.010</td>
                        <td class="py-1.5 px-3 text-center font-bold text-emerald-900 font-mono bg-emerald-50/40">1.980</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="py-1.5 px-3 border-r border-slate-200 font-semibold font-mono">3</td>
                        <td class="py-1.5 px-3 border-r border-slate-200 font-bold text-slate-900">Dusun Temubireng</td>
                        <td class="py-1.5 px-3 border-r border-slate-200">Supriadi</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">915</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">955</td>
                        <td class="py-1.5 px-3 text-center font-bold text-emerald-900 font-mono bg-emerald-50/40">1.870</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="py-1.5 px-3 border-r border-slate-200 font-semibold font-mono">4</td>
                        <td class="py-1.5 px-3 border-r border-slate-200 font-bold text-slate-900">Dusun Otak Desa</td>
                        <td class="py-1.5 px-3 border-r border-slate-200">Manhari</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">863</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">897</td>
                        <td class="py-1.5 px-3 text-center font-bold text-emerald-900 font-mono bg-emerald-50/40">1.760</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <td class="py-1.5 px-3 border-r border-slate-200 font-semibold font-mono">5</td>
                        <td class="py-1.5 px-3 border-r border-slate-200 font-bold text-slate-900">Dusun Temayang</td>
                        <td class="py-1.5 px-3 border-r border-slate-200">Uhel Wirahadi</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">840</td>
                        <td class="py-1.5 px-3 text-center border-r border-slate-200 font-mono">872</td>
                        <td class="py-1.5 px-3 text-center font-bold text-emerald-900 font-mono bg-emerald-50/40">1.712</td>
                    </tr>
                    <tr class="bg-slate-100 font-black text-slate-900">
                        <td colspan="3" class="py-2 px-3 text-right border-r border-slate-200 uppercase text-[11px]">JUMLAH TOTAL:</td>
                        <td class="py-2 px-3 text-center border-r border-slate-200 font-mono">4.638</td>
                        <td class="py-2 px-3 text-center border-r border-slate-200 font-mono">4.824</td>
                        <td class="py-2 px-3 text-center font-mono text-emerald-900 bg-emerald-100/70">9.462</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- SCRIPT INISIALISASI CHART.JS -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Chart Gender
    new Chart(document.getElementById('chartGender'), {
        type: 'doughnut',
        data: {
            labels: ['Laki-Laki (4.638)', 'Perempuan (4.824)'],
            datasets: [{
                data: [4638, 4824],
                backgroundColor: ['#1d4ed8', '#be123c'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });

    // 2. Chart Dusun
    new Chart(document.getElementById('chartDusun'), {
        type: 'bar',
        data: {
            labels: ['Lekong Rempung', 'Mujur', 'Temubireng', 'Otak Desa', 'Temayang'],
            datasets: [{
                label: 'Jumlah Jiwa',
                data: [2140, 1980, 1870, 1760, 1712],
                backgroundColor: '#15803d',
                borderRadius: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // 3. Chart Pekerjaan
    new Chart(document.getElementById('chartPekerjaan'), {
        type: 'bar',
        data: {
            labels: ['Petani/Pekebun', 'Buruh Tani', 'Wiraswasta', 'PNS/Guru', 'Karyawan', 'Lainnya'],
            datasets: [{
                label: 'Jumlah',
                data: [4120, 2150, 1240, 310, 680, 962],
                backgroundColor: '#b45309',
                borderRadius: 0
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });

    // 4. Chart Rentang Usia
    new Chart(document.getElementById('chartUmur'), {
        type: 'pie',
        data: {
            labels: ['0-14 Thn', '15-64 Thn', '65+ Thn'],
            datasets: [{
                data: [2180, 6450, 832],
                backgroundColor: ['#0369a1', '#15803d', '#7e22ce'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
});
</script>
