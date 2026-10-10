<?php
/**
 * Portal Resmi Pemerintah Desa Montong Betok
 * Kecamatan Montong Gading, Kabupaten Lombok Timur, NTB
 * Desain Formal Instansi Pemerintahan / OpenSID
 */

define('APP_INIT', true);

// Muat konfigurasi database & auto-migration
require_once __DIR__ . '/config/database.php';
$pdo = getDB();

// Routing Halaman
$allowedPages = [
    'beranda' => 'pages/beranda.php',
    'profil' => 'pages/profil.php',
    'pemerintahan' => 'pages/pemerintahan.php',
    'layanan' => 'pages/layanan.php',
    'statistik' => 'pages/statistik.php',
    'apbd' => 'pages/apbd.php',
    'berita' => 'pages/berita.php',
    'detail-berita' => 'pages/detail-berita.php',
    'pengaduan' => 'pages/pengaduan.php',
    'peta' => 'pages/peta.php'
];

$page = $_GET['page'] ?? 'beranda';
if (!array_key_exists($page, $allowedPages)) {
    $page = 'beranda';
}

// Include Template Header
include __DIR__ . '/includes/header.php';
?>

<!-- MAIN CONTAINER (LAYOUT 2 KOLOM FORMAL DENGAN GAP KOMPAK) -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex-grow w-full">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4">

        <!-- KOLOM UTAMA (8 KOLOM DI DESKTOP) -->
        <div class="lg:col-span-8 space-y-4">
            <?php include __DIR__ . '/' . $allowedPages[$page]; ?>
        </div>

        <!-- KOLOM SIDEBAR WIDGET (4 KOLOM DI DESKTOP) -->
        <div class="lg:col-span-4">
            <?php include __DIR__ . '/includes/sidebar.php'; ?>
        </div>

    </div>
</main>

<?php
// Include Template Footer
include __DIR__ . '/includes/footer.php';
?>
