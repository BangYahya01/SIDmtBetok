<?php
// admin/berita.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

$msg = null;
$err = null;

// Tambah Berita Baru
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'tambah_berita') {
    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $ringkasan = trim($_POST['ringkasan'] ?? '');
    $isi = trim($_POST['isi'] ?? '');
    $gambar = trim($_POST['gambar'] ?? '');
    $penulis = $_SESSION['admin_name'] ?? 'Administrator';

    if (empty($judul) || empty($kategori) || empty($isi)) {
        $err = "Judul, kategori, dan isi berita wajib diisi!";
    } else {
        // Buat slug
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $judul)));
        if (empty($gambar)) {
            $gambar = 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=800';
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO berita (judul, slug, kategori, ringkasan, isi, gambar, penulis, tanggal) VALUES (?, ?, ?, ?, ?, ?, ?, CURRENT_DATE)");
            $stmt->execute([$judul, $slug, $kategori, $ringkasan, $isi, $gambar, $penulis]);
            $msg = "Berita baru berhasil diterbitkan!";
        } catch (PDOException $e) {
            $err = "Gagal menerbitkan berita: " . $e->getMessage();
        }
    }
}

// Hapus Berita
if (isset($_GET['hapus'])) {
    $idHapus = (int)$_GET['hapus'];
    $stmt = $pdo->prepare("DELETE FROM berita WHERE id = ?");
    $stmt->execute([$idHapus]);
    $msg = "Berita berhasil dihapus!";
}

// Ambil semua berita
$beritas = $pdo->query("SELECT * FROM berita ORDER BY tanggal DESC, id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita Desa | Operator Desa Montong Betok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-100 font-sans text-slate-800 flex flex-col min-h-screen">

    <!-- TOPBAR ADMIN -->
    <header class="bg-slate-900 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="https://desamb.id/desa/logo/GkRCb_1762898002_logo__1_-removebg-preview.png" alt="Logo" class="h-9">
                <div>
                    <span class="text-sm font-black uppercase text-white tracking-wide block">Desa Montong Betok</span>
                    <span class="text-[10px] text-emerald-400 font-semibold block">Panel Administrator &bull; OpenSID v23</span>
                </div>
            </div>

            <div class="flex items-center space-x-4 text-xs">
                <a href="../index.php" target="_blank" class="text-slate-300 hover:text-white flex items-center gap-1">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Lihat Web
                </a>
                <span class="text-slate-600">|</span>
                <span class="text-slate-300">
                    <i class="fa-solid fa-user-circle text-emerald-400 mr-1"></i> <?= htmlspecialchars($_SESSION['admin_name']); ?>
                </span>
                <a href="logout.php" class="bg-rose-600 hover:bg-rose-700 text-white px-3 py-1.5 rounded font-bold transition">
                    <i class="fa-solid fa-power-off mr-1"></i> Keluar
                </a>
            </div>
        </div>
    </header>

    <!-- NAVIGATION TABS -->
    <div class="bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex space-x-2 py-2 text-xs font-semibold overflow-x-auto">
            <a href="index.php" class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-gauge-high"></i> Dashboard
            </a>
            <a href="surat.php" class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-file-signature text-emerald-600"></i> Kelola Surat Masuk
            </a>
            <a href="berita.php" class="bg-emerald-700 text-white px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-newspaper"></i> Kelola Berita Desa
            </a>
            <a href="pengaduan.php" class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-comments text-emerald-600"></i> Respon Pengaduan Warga
            </a>
        </div>
    </div>

    <!-- MAIN BODY -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-grow w-full space-y-6">

        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-black text-slate-900">Kelola Warta &amp; Berita Desa</h1>
                <p class="text-xs text-slate-500">Publikasikan artikel, dokumentasi kegiatan, atau pengumuman resmi desa.</p>
            </div>
        </div>

        <?php if ($msg): ?>
        <div class="p-3 bg-emerald-100 border border-emerald-300 rounded-lg text-xs text-emerald-800 font-bold flex items-center gap-2">
            <i class="fa-solid fa-check-circle text-emerald-600"></i> <?= htmlspecialchars($msg); ?>
        </div>
        <?php endif; ?>

        <?php if ($err): ?>
        <div class="p-3 bg-rose-100 border border-rose-300 rounded-lg text-xs text-rose-800 font-bold flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-rose-600"></i> <?= htmlspecialchars($err); ?>
        </div>
        <?php endif; ?>

        <!-- FORM TAMBAH BERITA -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-4">
            <h3 class="text-sm font-bold text-slate-900 border-b pb-3 flex items-center">
                <i class="fa-solid fa-plus-circle text-emerald-600 mr-2"></i> Tulis Berita / Pengumuman Baru
            </h3>

            <form action="berita.php" method="POST" class="space-y-4 text-xs">
                <input type="hidden" name="action" value="tambah_berita">

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-slate-700 mb-1">Judul Berita <span class="text-red-500">*</span></label>
                        <input type="text" name="judul" required placeholder="Contoh: Kerja Bakti Pembersihan Saluran Dusun Temayang" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" required class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 bg-white">
                            <option value="Berita Desa">Berita Desa</option>
                            <option value="Pengumuman">Pengumuman</option>
                            <option value="Kegiatan Warga">Kegiatan Warga</option>
                            <option value="Budaya & Religi">Budaya &amp; Religi</option>
                            <option value="Edukasi">Edukasi</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">URL Gambar / Sampul Foto</label>
                    <input type="url" name="gambar" placeholder="https://example.com/foto-kegiatan.jpg (Bisa dikosongkan untuk gambar default)" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ringkasan Singkat (Lead Paragraph)</label>
                    <input type="text" name="ringkasan" placeholder="Ringkasan 1-2 kalimat untuk cuplikan di kartu berita" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Isi Lengkap Berita (Mendukung Format HTML &amp; Paragraf) <span class="text-red-500">*</span></label>
                    <textarea name="isi" rows="6" required placeholder="Tuliskan berita lengkap di sini..." class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 font-mono"></textarea>
                </div>

                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition shadow flex items-center gap-1.5">
                    <i class="fa-solid fa-paper-plane"></i> Publikasikan Berita
                </button>
            </form>
        </div>

        <!-- DAFTAR BERITA TERBIT -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-4 border-b bg-slate-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-slate-900">Daftar Berita yang Sudah Diterbitkan</h3>
                <span class="text-xs text-slate-500 font-medium">Total: <?= count($beritas); ?> Artikel</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-100 text-slate-700 font-bold uppercase border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">Gambar</th>
                            <th class="py-3 px-4">Judul &amp; Kategori</th>
                            <th class="py-3 px-4">Penulis &amp; Tanggal</th>
                            <th class="py-3 px-4 text-center">Dibaca</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <?php foreach ($beritas as $b): ?>
                        <tr class="hover:bg-slate-50">
                            <td class="py-2.5 px-4 w-16">
                                <img src="<?= htmlspecialchars($b['gambar'] ?: 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?q=80&w=200'); ?>" alt="Thumb" class="w-12 h-10 object-cover rounded">
                            </td>
                            <td class="py-2.5 px-4 max-w-md">
                                <a href="../index.php?page=detail-berita&id=<?= $b['id']; ?>" target="_blank" class="font-bold text-slate-900 hover:text-emerald-700 transition block">
                                    <?= htmlspecialchars($b['judul']); ?>
                                </a>
                                <span class="text-[10px] text-emerald-800 bg-emerald-100 px-2 py-0.5 rounded font-bold inline-block mt-0.5">
                                    <?= htmlspecialchars($b['kategori']); ?>
                                </span>
                            </td>
                            <td class="py-2.5 px-4 whitespace-nowrap">
                                <span class="block text-slate-900 font-medium"><?= htmlspecialchars($b['penulis']); ?></span>
                                <span class="text-[10px] text-slate-400"><?= date('d/m/Y', strtotime($b['tanggal'])); ?></span>
                            </td>
                            <td class="py-2.5 px-4 text-center font-mono font-semibold">
                                <?= number_format($b['dilihat']); ?>
                            </td>
                            <td class="py-2.5 px-4 text-center whitespace-nowrap">
                                <a href="berita.php?hapus=<?= $b['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')" class="text-rose-600 hover:text-rose-800 font-semibold px-2 py-1 bg-rose-50 hover:bg-rose-100 rounded transition">
                                    <i class="fa-solid fa-trash-can mr-1"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>
