<?php
// includes/navbar.php
$page = $_GET['page'] ?? 'beranda';
if (!function_exists('navActive')) {
    function navActive($current, $target) {
        return ($current === $target) 
            ? 'bg-emerald-700 text-white font-bold border-b-2 border-amber-400' 
            : 'text-emerald-100 hover:bg-emerald-800 hover:text-white';
    }
}
?>
<nav class="bg-desa-950 border-t border-desa-800 sticky top-0 z-40 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-11">
            
            <!-- Desktop Navigation Menu (Formal Tabs) -->
            <div class="hidden lg:flex items-center space-x-0.5 text-xs h-full">
                <a href="index.php?page=beranda" class="px-3 h-full flex items-center gap-1.5 transition <?= navActive($page, 'beranda'); ?>">
                    <i class="fa-solid fa-house"></i> Beranda
                </a>
                <a href="index.php?page=profil" class="px-3 h-full flex items-center gap-1.5 transition <?= navActive($page, 'profil'); ?>">
                    <i class="fa-solid fa-address-card"></i> Profil Desa
                </a>
                <a href="index.php?page=pemerintahan" class="px-3 h-full flex items-center gap-1.5 transition <?= navActive($page, 'pemerintahan'); ?>">
                    <i class="fa-solid fa-users-gear"></i> Aparatur Desa
                </a>
                <a href="index.php?page=layanan" class="px-3 h-full flex items-center gap-1.5 transition <?= navActive($page, 'layanan'); ?>">
                    <i class="fa-solid fa-file-signature"></i> Layanan Mandiri
                </a>
                <a href="index.php?page=statistik" class="px-3 h-full flex items-center gap-1.5 transition <?= navActive($page, 'statistik'); ?>">
                    <i class="fa-solid fa-chart-column"></i> Data Statistik
                </a>
                <a href="index.php?page=apbd" class="px-3 h-full flex items-center gap-1.5 transition <?= navActive($page, 'apbd'); ?>">
                    <i class="fa-solid fa-chart-pie"></i> APBD Desa
                </a>
                <a href="index.php?page=berita" class="px-3 h-full flex items-center gap-1.5 transition <?= navActive($page, 'berita'); ?>">
                    <i class="fa-solid fa-newspaper"></i> Kabar Desa
                </a>
                <a href="index.php?page=pengaduan" class="px-3 h-full flex items-center gap-1.5 transition <?= navActive($page, 'pengaduan'); ?>">
                    <i class="fa-solid fa-comments"></i> Pengaduan
                </a>
                <a href="index.php?page=peta" class="px-3 h-full flex items-center gap-1.5 transition <?= navActive($page, 'peta'); ?>">
                    <i class="fa-solid fa-map-location-dot"></i> SIG Peta
                </a>
            </div>

            <!-- Quick Action: Cek Resi (Formal Square Button) -->
            <div class="hidden lg:flex items-center">
                <a href="index.php?page=layanan#cek-resi" class="text-xs bg-emerald-700 hover:bg-emerald-600 text-white font-semibold px-3 py-1.5 transition flex items-center gap-1.5 border border-emerald-500">
                    <i class="fa-solid fa-magnifying-glass text-[11px]"></i> Cek Resi Surat
                </a>
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex lg:hidden items-center justify-between w-full">
                <span class="text-xs font-bold text-emerald-200 uppercase tracking-wide">
                    Navigasi Portal
                </span>
                <button type="button" onclick="toggleMobileNav()" class="text-emerald-100 hover:text-white p-2 focus:outline-none">
                    <i class="fa-solid fa-bars text-base" id="nav-icon-menu"></i>
                </button>
            </div>

        </div>

        <!-- Mobile Navigation Menu Dropdown (Formal Sharp) -->
        <div id="mobile-menu" class="hidden lg:hidden py-2 border-t border-desa-800 space-y-0.5 text-xs">
            <a href="index.php?page=beranda" class="block px-3 py-2 border-l-2 <?= ($page === 'beranda') ? 'border-amber-400 bg-emerald-800 text-white font-bold' : 'border-transparent text-emerald-100'; ?>">
                <i class="fa-solid fa-house mr-2"></i> Beranda
            </a>
            <a href="index.php?page=profil" class="block px-3 py-2 border-l-2 <?= ($page === 'profil') ? 'border-amber-400 bg-emerald-800 text-white font-bold' : 'border-transparent text-emerald-100'; ?>">
                <i class="fa-solid fa-address-card mr-2"></i> Profil Desa
            </a>
            <a href="index.php?page=pemerintahan" class="block px-3 py-2 border-l-2 <?= ($page === 'pemerintahan') ? 'border-amber-400 bg-emerald-800 text-white font-bold' : 'border-transparent text-emerald-100'; ?>">
                <i class="fa-solid fa-users-gear mr-2"></i> Aparatur Desa
            </a>
            <a href="index.php?page=layanan" class="block px-3 py-2 border-l-2 <?= ($page === 'layanan') ? 'border-amber-400 bg-emerald-800 text-white font-bold' : 'border-transparent text-emerald-100'; ?>">
                <i class="fa-solid fa-file-signature mr-2"></i> Layanan Mandiri
            </a>
            <a href="index.php?page=statistik" class="block px-3 py-2 border-l-2 <?= ($page === 'statistik') ? 'border-amber-400 bg-emerald-800 text-white font-bold' : 'border-transparent text-emerald-100'; ?>">
                <i class="fa-solid fa-chart-column mr-2"></i> Data Statistik
            </a>
            <a href="index.php?page=apbd" class="block px-3 py-2 border-l-2 <?= ($page === 'apbd') ? 'border-amber-400 bg-emerald-800 text-white font-bold' : 'border-transparent text-emerald-100'; ?>">
                <i class="fa-solid fa-chart-pie mr-2"></i> APBD Desa
            </a>
            <a href="index.php?page=berita" class="block px-3 py-2 border-l-2 <?= ($page === 'berita') ? 'border-amber-400 bg-emerald-800 text-white font-bold' : 'border-transparent text-emerald-100'; ?>">
                <i class="fa-solid fa-newspaper mr-2"></i> Kabar Desa
            </a>
            <a href="index.php?page=pengaduan" class="block px-3 py-2 border-l-2 <?= ($page === 'pengaduan') ? 'border-amber-400 bg-emerald-800 text-white font-bold' : 'border-transparent text-emerald-100'; ?>">
                <i class="fa-solid fa-comments mr-2"></i> Pengaduan Warga
            </a>
            <a href="index.php?page=peta" class="block px-3 py-2 border-l-2 <?= ($page === 'peta') ? 'border-amber-400 bg-emerald-800 text-white font-bold' : 'border-transparent text-emerald-100'; ?>">
                <i class="fa-solid fa-map-location-dot mr-2"></i> SIG Peta Wilayah
            </a>
            <div class="pt-2 px-3">
                <a href="index.php?page=layanan#cek-resi" class="block text-center bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold px-3 py-1.5 text-xs transition border border-amber-600">
                    <i class="fa-solid fa-magnifying-glass mr-1"></i> Cek Status Resi Surat
                </a>
            </div>
        </div>

    </div>
</nav>

<script>
    function toggleMobileNav() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('nav-icon-menu');
        if (menu.classList.contains('hidden')) {
            menu.classList.remove('hidden');
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-xmark');
        } else {
            menu.classList.add('hidden');
            icon.classList.remove('fa-xmark');
            icon.classList.add('fa-bars');
        }
    }
</script>
