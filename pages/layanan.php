<?php
// pages/layanan.php
$alertSuccess = null;
$alertError = null;
$newResi = null;

// Proses Form Permohonan Surat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajukan_surat') {
    $nik = trim($_POST['nik'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $dusun = trim($_POST['dusun'] ?? '');
    $no_hp = trim($_POST['no_hp'] ?? '');
    $jenis_surat = trim($_POST['jenis_surat'] ?? '');
    $keperluan = trim($_POST['keperluan'] ?? '');

    if (empty($nik) || empty($nama) || empty($dusun) || empty($no_hp) || empty($jenis_surat)) {
        $alertError = "Mohon lengkapi seluruh formulir bertanda bintang (*).";
    } elseif (strlen($nik) < 16) {
        $alertError = "NIK harus berjumlah 16 digit sesuai KTP/KK.";
    } else {
        // Buat nomor resi unik
        $randomCode = strtoupper(substr(uniqid(), -4));
        $no_resi = "SRT-" . date('Ym') . "-" . $randomCode;

        try {
            $stmt = $pdo->prepare("INSERT INTO permohonan_surat (no_resi, nik, nama, dusun, no_hp, jenis_surat, keperluan, status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Menunggu Verifikasi')");
            $stmt->execute([$no_resi, $nik, $nama, $dusun, $no_hp, $jenis_surat, $keperluan]);
            $alertSuccess = "Permohonan surat berhasil dikirim! Silakan simpan Nomor Resi Anda untuk melacak proses pembuatan surat.";
            $newResi = $no_resi;
        } catch (PDOException $e) {
            $alertError = "Terjadi kesalahan sistem: " . $e->getMessage();
        }
    }
}

// Cek Resi
$searchQuery = trim($_GET['cari_resi'] ?? '');
$hasilResi = null;
if (!empty($searchQuery)) {
    $stmtCek = $pdo->prepare("SELECT * FROM permohonan_surat WHERE no_resi = ? OR nik = ? ORDER BY id DESC LIMIT 5");
    $stmtCek->execute([$searchQuery, $searchQuery]);
    $hasilResi = $stmtCek->fetchAll();
}
?>
<div class="space-y-4">

    <!-- HEADER TITLE FORMAL -->
    <div class="card-custom p-4 bg-gradient-to-r from-emerald-900 to-teal-950 text-white border-0">
        <h2 class="text-lg sm:text-xl font-black uppercase tracking-wide">
            <i class="fa-solid fa-file-signature mr-2 text-amber-400"></i> Layanan Mandiri Online Desa
        </h2>
        <p class="text-xs text-emerald-200 mt-0.5">
            Pelayanan Administrasi Surat Kependudukan Resmi &bull; Cepat, Mudah, dan Transparan
        </p>
    </div>

    <!-- ALUR PENGURUSAN (FORMAL RECTANGLES) -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center text-xs">
        <div class="bg-white p-3 border border-slate-300">
            <span class="w-6 h-6 bg-slate-900 text-amber-400 font-bold flex items-center justify-center mx-auto mb-1.5 text-[11px] font-mono">1</span>
            <h4 class="font-bold text-slate-900 uppercase text-[11px]">Isi Formulir</h4>
            <p class="text-[10px] text-slate-500 mt-0.5">Data diri &amp; NIK sesuai KTP</p>
        </div>
        <div class="bg-white p-3 border border-slate-300">
            <span class="w-6 h-6 bg-slate-900 text-amber-400 font-bold flex items-center justify-center mx-auto mb-1.5 text-[11px] font-mono">2</span>
            <h4 class="font-bold text-slate-900 uppercase text-[11px]">Dapat Resi</h4>
            <p class="text-[10px] text-slate-500 mt-0.5">Simpan nomor registrasi</p>
        </div>
        <div class="bg-white p-3 border border-slate-300">
            <span class="w-6 h-6 bg-slate-900 text-amber-400 font-bold flex items-center justify-center mx-auto mb-1.5 text-[11px] font-mono">3</span>
            <h4 class="font-bold text-slate-900 uppercase text-[11px]">Verifikasi</h4>
            <p class="text-[10px] text-slate-500 mt-0.5">Pemeriksaan oleh loket</p>
        </div>
        <div class="bg-white p-3 border border-slate-300">
            <span class="w-6 h-6 bg-slate-900 text-amber-400 font-bold flex items-center justify-center mx-auto mb-1.5 text-[11px] font-mono">4</span>
            <h4 class="font-bold text-slate-900 uppercase text-[11px]">Ambil Surat</h4>
            <p class="text-[10px] text-slate-500 mt-0.5">Ambil di kantor desa</p>
        </div>
    </div>

    <!-- NOTIFIKASI SUKSES / ERROR (FORMAL RECTANGULAR) -->
    <?php if ($alertSuccess): ?>
    <div class="bg-emerald-50 border-l-4 border-emerald-700 p-3.5 border border-slate-300 shadow-xs">
        <div class="flex items-start gap-3">
            <i class="fa-solid fa-circle-check text-emerald-700 text-xl mt-0.5"></i>
            <div>
                <h4 class="text-xs font-bold text-emerald-950 uppercase">Permohonan Surat Berhasil Dikirim</h4>
                <p class="text-xs text-emerald-900 mt-0.5"><?= htmlspecialchars($alertSuccess); ?></p>
                <div class="mt-2.5 p-2 bg-white border border-emerald-400 inline-block">
                    <span class="text-[10px] text-slate-500 block uppercase font-mono font-semibold">Nomor Resi Pelacakan Dokumen:</span>
                    <span class="text-base font-mono font-black text-emerald-900 tracking-wider"><?= htmlspecialchars($newResi); ?></span>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($alertError): ?>
    <div class="bg-rose-50 border-l-4 border-rose-700 p-3.5 border border-slate-300 shadow-xs">
        <div class="flex items-center gap-2.5">
            <i class="fa-solid fa-triangle-exclamation text-rose-700 text-lg"></i>
            <div>
                <h4 class="text-xs font-bold text-rose-950 uppercase">Peringatan Validasi Formulir</h4>
                <p class="text-xs text-rose-900 mt-0.5"><?= htmlspecialchars($alertError); ?></p>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- SEKSI 1: FORMULIR PENGAJUAN SURAT (FORMAL SHARP) -->
    <div class="card-custom p-4">
        <div class="border-b border-slate-200 pb-2.5 mb-3.5 flex items-center justify-between">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center">
                <i class="fa-solid fa-pen-to-square text-emerald-700 mr-2"></i> Formulir Pengajuan Dokumen Surat
            </h3>
            <span class="text-[11px] text-emerald-800 font-semibold bg-emerald-50 px-2 py-0.5 border border-emerald-300">
                Layanan Publik Gratis
            </span>
        </div>

        <form action="index.php?page=layanan" method="POST" class="space-y-3">
            <input type="hidden" name="action" value="ajukan_surat">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">
                        Nomor Induk Kependudukan (NIK) <span class="text-red-600">*</span>
                    </label>
                    <input type="number" name="nik" required placeholder="5203xxxxxxxxxxxx" class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white font-mono">
                    <span class="text-[10px] text-slate-500">16 digit angka sesuai KTP/KK</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">
                        Nama Lengkap Pemohon <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="nama" required placeholder="Nama lengkap sesuai KTP" class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">
                        Dusun Domisili <span class="text-red-600">*</span>
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

                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">
                        Nomor Kontak / WhatsApp Aktif <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="no_hp" required placeholder="08xxxxxxxxxx" class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white font-mono">
                    <span class="text-[10px] text-slate-500">Untuk pemberitahuan status dokumen surat</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">
                    Jenis Dokumen Surat yang Diajukan <span class="text-red-600">*</span>
                </label>
                <select name="jenis_surat" required class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white font-semibold">
                    <option value="">-- Pilih Jenis Surat --</option>
                    <option value="Surat Keterangan Usaha (SKU)">Surat Keterangan Usaha (SKU)</option>
                    <option value="Surat Keterangan Tidak Mampu (SKTM)">Surat Keterangan Tidak Mampu (SKTM)</option>
                    <option value="Surat Keterangan Domisili">Surat Keterangan Domisili</option>
                    <option value="Surat Pengantar SKCK">Surat Pengantar SKCK</option>
                    <option value="Surat Keterangan Kehilangan">Surat Keterangan Kehilangan</option>
                    <option value="Surat Keterangan Belum Menikah">Surat Keterangan Belum Menikah</option>
                    <option value="Surat Keterangan Kematian">Surat Keterangan Kematian</option>
                    <option value="Surat Keterangan Kelahiran">Surat Keterangan Kelahiran</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">
                    Keperluan / Keterangan Pengajuan
                </label>
                <textarea name="keperluan" rows="3" placeholder="Jelaskan tujuan permohonan surat (misal: syarat pengajuan KUR BRI, beasiswa, pendaftaran kerja)..." class="w-full px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white"></textarea>
            </div>

            <div class="pt-1">
                <button type="submit" class="px-5 py-2 bg-emerald-700 hover:bg-emerald-800 text-white font-bold text-xs transition border border-emerald-800 flex items-center justify-center gap-1.5">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Permohonan Surat
                </button>
            </div>
        </form>
    </div>

    <!-- SEKSI 2: CEK RESI / STATUS PERMOHONAN (FORMAL RECTANGULAR) -->
    <div id="cek-resi" class="card-custom p-4 bg-slate-50 scroll-mt-16">
        <div class="border-b border-slate-200 pb-2.5 mb-3">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wide flex items-center">
                <i class="fa-solid fa-magnifying-glass text-emerald-700 mr-2"></i> Lacak Status Permohonan Surat (Cek Resi)
            </h3>
            <p class="text-xs text-slate-600 mt-0.5">Masukkan Nomor Resi Registrasi (Contoh: SRT-202601-0001) atau NIK 16 digit Anda.</p>
        </div>

        <form action="index.php" method="GET" class="flex flex-col sm:flex-row gap-2 mb-4">
            <input type="hidden" name="page" value="layanan">
            <input type="text" name="cari_resi" value="<?= htmlspecialchars($searchQuery); ?>" placeholder="Ketik Nomor Resi atau NIK..." class="flex-grow px-3 py-1.5 text-xs border border-slate-300 focus:outline-none focus:border-emerald-700 bg-white font-mono">
            <button type="submit" class="px-4 py-1.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition flex items-center justify-center gap-1 shrink-0 border border-slate-900">
                <i class="fa-solid fa-search"></i> Cek Status
            </button>
        </form>

        <?php if (!empty($searchQuery)): ?>
            <?php if (!empty($hasilResi)): ?>
            <div class="space-y-2.5">
                <h4 class="text-xs font-bold text-slate-800 uppercase">Data Permohonan Ditemukan:</h4>
                <?php foreach ($hasilResi as $resi): ?>
                <div class="bg-white p-3 border border-slate-300 space-y-2">
                    <div class="flex flex-wrap justify-between items-center gap-2 border-b border-slate-200 pb-2">
                        <div>
                            <span class="text-[9px] text-slate-400 block font-mono uppercase font-bold">Nomor Resi:</span>
                            <span class="text-sm font-bold text-emerald-900 font-mono"><?= htmlspecialchars($resi['no_resi']); ?></span>
                        </div>
                        <div>
                            <?php 
                            $status = $resi['status'];
                            $badgeClass = 'bg-yellow-50 text-yellow-900 border-yellow-400';
                            if ($status === 'Sedang Diproses') $badgeClass = 'bg-blue-50 text-blue-900 border-blue-400';
                            if ($status === 'Siap Diambil') $badgeClass = 'bg-emerald-50 text-emerald-950 border-emerald-600';
                            if ($status === 'Ditolak') $badgeClass = 'bg-rose-50 text-rose-900 border-rose-400';
                            ?>
                            <span class="px-2.5 py-0.5 text-xs font-bold border <?= $badgeClass; ?> font-mono">
                                <?= htmlspecialchars($status); ?>
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 text-xs text-slate-700">
                        <div>
                            <span class="text-slate-500 block text-[10px] uppercase font-semibold">Nama Pemohon:</span>
                            <strong class="text-slate-900"><?= htmlspecialchars($resi['nama']); ?></strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-[10px] uppercase font-semibold">Jenis Surat:</span>
                            <strong class="text-slate-900"><?= htmlspecialchars($resi['jenis_surat']); ?></strong>
                        </div>
                        <div>
                            <span class="text-slate-500 block text-[10px] uppercase font-semibold">Wilayah Dusun:</span>
                            <strong class="text-slate-900"><?= htmlspecialchars($resi['dusun']); ?></strong>
                        </div>
                    </div>

                    <?php if (!empty($resi['keterangan_admin'])): ?>
                    <div class="mt-2 p-2 bg-slate-50 border border-slate-200 text-xs text-slate-800">
                        <strong class="text-emerald-900 block text-[10px] uppercase"><i class="fa-solid fa-comment-dots mr-1"></i> Catatan Petugas Loket Desa:</strong>
                        <?= nl2br(htmlspecialchars($resi['keterangan_admin'])); ?>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="p-3 bg-white border border-slate-300 text-center text-xs text-slate-600">
                Tidak ditemukan data permohonan dengan Resi atau NIK <strong>"<?= htmlspecialchars($searchQuery); ?>"</strong>. Pastikan data yang dimasukkan sudah sesuai.
            </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</div>
