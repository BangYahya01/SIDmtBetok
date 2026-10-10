<?php
// includes/header.php
if (!defined('APP_INIT')) {
    define('APP_INIT', true);
}
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

$currentPage = $_GET['page'] ?? 'beranda';
$pageTitles = [
    'beranda' => 'Portal Resmi Desa Montong Betok',
    'profil' => 'Profil & Visi Misi - Desa Montong Betok',
    'pemerintahan' => 'Pemerintahan & Aparatur Desa - Desa Montong Betok',
    'layanan' => 'Layanan Mandiri & Permohonan Surat Online',
    'berita' => 'Kabar Desa & Berita Terkini',
    'detail-berita' => 'Baca Berita - Desa Montong Betok',
    'statistik' => 'Data Kependudukan & Statistik Desa',
    'apbd' => 'Transparansi Keuangan & APBD Desa',
    'pengaduan' => 'Lapor Desa & Pengaduan Warga'
];
$title = $pageTitles[$currentPage] ?? 'Portal Resmi Desa Montong Betok';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title); ?> | Kec. Montong Gading, Lombok Timur</title>
    
    <!-- Meta SEO -->
    <meta name="description" content="Website Resmi Pemerintah Desa Montong Betok, Kecamatan Montong Gading, Kabupaten Lombok Timur, NTB.">
    <meta name="keywords" content="Desa Montong Betok, Montong Gading, Lombok Timur, OpenSID, Layanan Mandiri, KKN 2026">
    <link rel="shortcut icon" href="https://desamb.id/desa/logo/GkRCb_1762898002_logo__1_-removebg-preview.png" type="image/png">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        desa: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            500: '#15803d',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                            950: '#052e16'
                        },
                        amberbrand: '#d97706'
                    },
                    fontFamily: {
                        sans: ['Inter', 'Poppins', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;900&display=swap" rel="stylesheet">
    
    <!-- Chart.js for Interactive Statistics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }
        /* Formal Card Style: Radius Dihilangkan / Dibuat Tajam Tegas */
        .card-custom {
            background: #ffffff;
            border-radius: 0px !important;
            border: 1px solid #cbd5e1;
            border-top: 3px solid #15803d;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04);
        }
    </style>
</head>
<body class="text-slate-800 antialiased flex flex-col min-h-screen">

    <!-- MAIN BRAND HEADER (AUTHENTIC DESAMB.ID STYLE) -->
    <header style="background-image: url('https://desamb.id/assets/front/css/images/latar_website.jpg?v2fea19cb8b4f08ffe6b24e38cc2e0829');" class="bg-center bg-cover bg-no-repeat relative text-white shadow-md">
        <!-- Dark Overlay -->
        <div class="absolute bg-gray-800 bg-opacity-60 top-0 left-0 right-0 h-full"></div>

        <!-- TOP BAR SECTION (KATEGORI & TOMBOL AKSI) -->
        <section class="relative z-10 px-3 lg:px-5 pt-3">
            <div class="max-w-7xl mx-auto flex flex-col lg:flex-row justify-between items-center gap-2">
                <ul class="text-xs flex items-center space-x-2">
                    <li>
                        <span class="text-emerald-300 font-bold uppercase tracking-wider text-[11px]">
                            <i class="fa-solid fa-landmark mr-1"></i> Portal Resmi Desa
                        </span>
                    </li>
                    <li class="text-slate-400">|</li>
                    <li>
                        <a href="index.php?page=berita" class="text-slate-200 hover:text-amber-400 transition font-medium">
                            <i class="fa-solid fa-newspaper mr-1"></i> Berita Desa
                        </a>
                    </li>
                </ul>

                <div class="flex items-center gap-2">
                    <a href="index.php?page=layanan" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold px-3 py-1.5 transition border border-emerald-500 flex items-center gap-1 shadow-sm">
                        Layanan Mandiri <i class="fas fa-external-link-alt text-[10px] ml-1"></i>
                    </a>
                    <a href="admin/login.php" class="bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-bold px-3 py-1.5 transition border border-amber-600 flex items-center gap-1 shadow-sm">
                        Login Admin <i class="fas fa-external-link-alt text-[10px] ml-1"></i>
                    </a>
                </div>
            </div>
        </section>

        <!-- CENTER LOGO & MARQUEE SECTION (AUTHENTIC DESAMB.ID) -->
        <section class="relative z-10 text-center space-y-2 mt-3 px-3 lg:px-5">
            <a href="index.php?page=beranda" class="inline-block group">
                <figure>
                    <img src="https://desamb.id/desa/logo/GkRCb_1762898002_logo__1_-removebg-preview.png" alt="Logo Desa Montong Betok" class="h-16 mx-auto pb-2 drop-shadow">
                </figure>
                <span class="text-2xl sm:text-3xl font-black uppercase tracking-wide block drop-shadow text-white">Montong Betok</span>
                <p class="text-xs text-emerald-100 font-medium max-w-xl mx-auto drop-shadow-sm mt-0.5">
                    Kec. Montong Gading, Kab. Lombok Timur, Provinsi Nusa Tenggara Barat
                </p>
            </a>

            <!-- MINI GALLERY MARQUEE (DESAMB.ID AUTHENTIC CAROUSEL) -->
            <marquee onmouseover="this.stop();" onmouseout="this.start();" scrollamount="4" class="block w-11/12 sm:w-8/12 md:w-5/12 lg:w-4/12 mx-auto pt-1">
                <div class="grid grid-flow-col gap-3 shadow-lg pt-1">
                    <a href="index.php?page=detail-berita&id=7" class="block w-32 h-20 border border-white/30" title="SOSIALISASI PENGOLAHAN SAMPAH">
                        <img src="https://desamb.id/desa/upload/galeri/kecil_qxWId_1763109910_WhatsApp_Image_2025-11-13_at_13_19_38.webp" alt="SOSIALISASI PENGOLAHAN SAMPAH" class="w-32 h-20 object-cover">
                    </a>
                    <a href="index.php?page=detail-berita&id=6" class="block w-32 h-20 border border-white/30" title="GAWE DESA PRAJA YATIM II DESA MONTONG BETOK">
                        <img src="https://desamb.id/desa/upload/galeri/kecil_A9D3h_1763109871_sunatan_masal.webp" alt="GAWE DESA PRAJA YATIM II DESA MONTONG BETOK" class="w-32 h-20 object-cover">
                    </a>
                    <a href="index.php?page=beranda" class="block w-32 h-20 border border-white/30" title="Halaman Depan Kantor Desa">
                        <img src="https://desamb.id/desa/upload/galeri/kecil_GkRCb_1763689771_depan_kandes.webp" alt="Halaman Depan Kantor Desa" class="w-32 h-20 object-cover">
                    </a>
                    <a href="index.php?page=detail-berita&id=6" class="block w-32 h-20 border border-white/30" title="GAWE DESA PRAJA YATIM II DESA MONTONG BETOK">
                        <img src="https://desamb.id/desa/upload/galeri/kecil_J7fsF_1763109888_WhatsApp_Image_2025-10-23_at_07_57_38_88178046.webp" alt="GAWE DESA PRAJA YATIM II DESA MONTONG BETOK" class="w-32 h-20 object-cover">
                    </a>
                </div>
            </marquee>
        </section>

        <!-- RUNNING TEXT TICKER (BOTTOM HEADER) -->
        <div class="block px-3 bg-white text-white bg-opacity-20 py-1.5 text-xs mt-4 mb-0 z-20 relative border-t border-white/10">
            <marquee onmouseover="this.stop();" onmouseout="this.start();" scrollamount="5" class="block divide-x-4 relative font-medium">
                <span class="px-3">
                    Selamat Datang di Website Resmi Desa Montong Betok, Kecamatan Montong Gading, Lombok Timur, Nusa Tenggara Barat
                </span>
                <span class="px-3">
                    Pengumuman: Lelang Tanah Pecatu Desa Montong Betok T.A 2026/2027 dibuka untuk umum.
                </span>
                <span class="px-3">
                    Pelayanan Mandiri: Permohonan Surat Keterangan Usaha (SKU), Domisili, dan SKTM dapat diajukan secara online 24 jam.
                </span>
            </marquee>
        </div>
    </header>

    <!-- INCLUDE NAVBAR DIRECTLY BELOW HEADER -->
    <?php include __DIR__ . '/navbar.php'; ?>

