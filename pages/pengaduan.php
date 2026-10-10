<?php
// pages/pengaduan.php
$alertSuccess = null;
$alertError = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'kirim_aduan') {
    $nama = trim($_POST['nama'] ?? '');
    $dusun = trim($_POST['dusun'] ?? '');
    $judul = trim($_POST['judul'] ?? '');
    $isi = trim($_POST['isi'] ?? '');

    if (empty($nama) || empty($dusun) || empty($judul) || empty($isi)) {
        $alertError = "Mohon lengkapi seluruh kolom formulir aspirasi.";
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO pengaduan (nama, dusun, judul, isi, status) VALUES (?, ?, ?, ?, 'Diterima')");
            $stmt->execute([$nama, $dusun, $judul, $isi]);
            $alertSuccess = "Aspirasi Anda berhasil dikirim dan tercatat dalam sistem informasi desa. Aparatur terkait akan segera menindaklanjuti laporan Anda.";
        } catch (PDOException $e) {
            $alertError = "Terjadi kesalahan sistem: " . $e->getMessage();
        }
    }
}

// Ambil pengaduan publik yang sudah masuk
$stmtAduan = $pdo->query("SELECT * FROM pengaduan ORDER BY id DESC LIMIT 15");
$aduanList = $stmtAduan->fetchAll();
?>
<div class="space-y-4">

    <!-- HEADER TITLE FORMAL -->
    <div class="card-custom p-4 bg-gradient-to-r from-emerald-900 to-teal-950 text-white border-0">
        <h2 class="text-lg sm:text-xl font-black uppercase tracking-wide">
            <i class="fa-solid fa-comments mr-2 text-amber-400"></i> Pengaduan &amp; Aspirasi Warga
        </h2>
        <p class="text-xs text-emerald-200 mt-0.5">
            Saluran Resmi Partisipasi Masyarakat Demi Akuntabilitas Tata Kelola Desa Montong Betok
        </p>
    </div>

    <!-- NOTIFIKASI FORMAL -->
    <?php if ($alertSuccess): ?>
    <div class="bg-emerald-50 border-l-4 border-emerald-700 p-3 border border-slate-300 flex items-start gap-2.5">
        <i class="fa-solid fa-circle-check text-emerald-700 text-lg mt-0.5"></i>
        <div>
            <h4 class="text-xs font-bold text-emerald-950 uppercase">Laporan Berhasil Diterima</h4>
            <p class="text-xs text-emerald-900 mt-0.5"><?= htmlspecialchars($alertSuccess); ?></p>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($alertError): ?>
    <div class="bg-rose-50 border-l-4 border-rose-700 p-3 border border-slate-300 flex items-start gap-2.5">
        <i class="fa-solid fa-triangle-exclamation text-rose-700 text-lg mt-0.5"></i>
        <div>
            <h4 class="text-xs font-bold text-rose-950 uppercase">Peringatan Formulir</h4>
            <p class="text-xs text-rose-900 mt-0.5"><?= htmlspecialchars($alertError); ?></p>
        </div>
    </div>
    <?php endif; ?>

    <!-- FORM INPUT ASPIRASI (FORMAL SHARP) -->
    <div class="card-custom p-4">
        <h3 class="text-xs font-bold text-slate-900 border-b border-slate-200 pb-2 mb-3 uppercase tracking-wide flex items-center">
            <i class="fa-solid fa-bullhorn text-emerald-700 mr-2"></i> Tulis Aspirasi / Pengaduan Baru
        </h3>

        <form action="index.php?page=pengaduan" method="POST" class="space-y-3">
            <input type="hidden" name="action" value="kirim_aduan">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">
                        Nama Lengkap Pelapor <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="nama" required placeholder="Contoh: Ahmad Sanusi" class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">
                        Asal Wilayah Dusun <span class="text-red-600">*</span>
                    </label>
                    <select name="dusun" required class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white">
                        <option value="">-- Pilih Wilayah Dusun --</option>
                        <option value="Dusun Lekong Rempung">Dusun Lekong Rempung</option>
                        <option value="Dusun Mujur">Dusun Mujur</option>
                        <option value="Dusun Temubireng">Dusun Temubireng</option>
                        <option value="Dusun Otak Desa">Dusun Otak Desa</option>
                        <option value="Dusun Temayang">Dusun Temayang</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">
                    Topik / Judul Pengaduan <span class="text-red-600">*</span>
                </label>
                <input type="text" name="judul" required placeholder="Contoh: Perbaikan Saluran Irigasi Sawah di Dusun Mujur" class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">
                    Uraian Masalah / Rincian Aspirasi <span class="text-red-600">*</span>
                </label>
                <textarea name="isi" rows="3" required placeholder="Jelaskan secara rinci lokasi, kondisi fisik, dan permohonan Anda..." class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white"></textarea>
            </div>

            <button type="submit" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs transition border border-emerald-800 flex items-center gap-1.5">
                <i class="fa-solid fa-paper-plane"></i> Kirim Aspirasi
            </button>
        </form>
    </div>

    <!-- DAFTAR PENGADUAN & TINDAK LANJUT (FORMAL SHARP) -->
    <div class="card-custom p-4">
        <div class="border-b border-slate-200 pb-2 mb-3 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center">
                <i class="fa-solid fa-list-check text-emerald-700 mr-2"></i> Arsip Aduan Masuk &amp; Tindak Lanjut Desa
            </h3>
            <span class="text-[11px] text-slate-500 font-mono">Publik &amp; Transparan</span>
        </div>

        <div class="space-y-3">
            <?php foreach ($aduanList as $aduan): 
                $badge = 'bg-yellow-50 text-yellow-900 border-yellow-400';
                if ($aduan['status'] === 'Ditindaklanjuti') $badge = 'bg-blue-50 text-blue-900 border-blue-400';
                if ($aduan['status'] === 'Selesai') $badge = 'bg-emerald-50 text-emerald-950 border-emerald-600';
            ?>
            <div class="p-3 bg-white border border-slate-300 space-y-1.5">
                <div class="flex flex-wrap justify-between items-center gap-2 border-b border-slate-200 pb-1.5">
                    <div class="flex items-center gap-2 text-xs">
                        <strong class="text-slate-900"><?= htmlspecialchars($aduan['nama']); ?></strong>
                        <span class="text-slate-400">&bull;</span>
                        <span class="text-emerald-800 font-medium"><?= htmlspecialchars($aduan['dusun']); ?></span>
                        <span class="text-slate-400">&bull;</span>
                        <span class="text-slate-400 text-[10px] font-mono"><?= date('d/m/Y H:i', strtotime($aduan['tanggal'])); ?> WITA</span>
                    </div>
                    <span class="px-2 py-0.5 text-[10px] font-bold border <?= $badge; ?> font-mono">
                        <?= htmlspecialchars($aduan['status']); ?>
                    </span>
                </div>

                <h4 class="text-xs font-bold text-slate-900">
                    <?= htmlspecialchars($aduan['judul']); ?>
                </h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    <?= nl2br(htmlspecialchars($aduan['isi'])); ?>
                </p>

                <?php if (!empty($aduan['tanggapan'])): ?>
                <div class="mt-2 p-2.5 bg-emerald-50 border-l-4 border-emerald-700 text-xs text-slate-800 border-r border-t border-b border-slate-200">
                    <strong class="font-bold text-emerald-950 flex items-center gap-1 text-[11px] uppercase">
                        <i class="fa-solid fa-reply text-emerald-700"></i> Tanggapan Resmi Pemerintah Desa:
                    </strong>
                    <p class="text-emerald-900 leading-relaxed mt-0.5">
                        <?= nl2br(htmlspecialchars($aduan['tanggapan'])); ?>
                    </p>
                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>
