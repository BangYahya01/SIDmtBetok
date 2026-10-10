<?php
// admin/pengaduan.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

$msg = null;

// Tanggapi Pengaduan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'respon_aduan') {
    $id = (int)$_POST['id'];
    $status = trim($_POST['status']);
    $tanggapan = trim($_POST['tanggapan']);

    $stmt = $pdo->prepare("UPDATE pengaduan SET status = ?, tanggapan = ? WHERE id = ?");
    $stmt->execute([$status, $tanggapan, $id]);
    $msg = "Tanggapan pengaduan warga berhasil disimpan!";
}

// Ambil semua aduan
$aduans = $pdo->query("SELECT * FROM pengaduan ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengaduan Warga | Operator Desa Montong Betok</title>
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
            <a href="berita.php" class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-newspaper text-emerald-600"></i> Kelola Berita Desa
            </a>
            <a href="pengaduan.php" class="bg-emerald-700 text-white px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-comments"></i> Respon Pengaduan Warga
            </a>
        </div>
    </div>

    <!-- MAIN BODY -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-grow w-full space-y-6">

        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-xl font-black text-slate-900">Aspirasi &amp; Pengaduan Masyarakat</h1>
                <p class="text-xs text-slate-500">Tinjau keluhan warga dan berikan tanggapan resmi pemerintah desa.</p>
            </div>
        </div>

        <?php if ($msg): ?>
        <div class="p-3 bg-emerald-100 border border-emerald-300 rounded-lg text-xs text-emerald-800 font-bold flex items-center gap-2">
            <i class="fa-solid fa-check-circle text-emerald-600"></i> <?= htmlspecialchars($msg); ?>
        </div>
        <?php endif; ?>

        <!-- DAFTAR PENGADUAN -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="divide-y divide-slate-100 text-xs">
                <?php foreach ($aduans as $aduan): 
                    $badge = 'bg-yellow-100 text-yellow-800 border-yellow-300';
                    if ($aduan['status'] === 'Ditindaklanjuti') $badge = 'bg-blue-100 text-blue-800 border-blue-300';
                    if ($aduan['status'] === 'Selesai') $badge = 'bg-emerald-100 text-emerald-800 border-emerald-300';
                ?>
                <div class="p-5 space-y-3">
                    <div class="flex flex-wrap justify-between items-center gap-2">
                        <div class="flex items-center gap-2">
                            <span class="font-bold text-slate-900 text-sm"><?= htmlspecialchars($aduan['nama']); ?></span>
                            <span class="text-slate-400">&bull;</span>
                            <span class="text-emerald-700 font-semibold"><?= htmlspecialchars($aduan['dusun']); ?></span>
                            <span class="text-slate-400">&bull;</span>
                            <span class="text-slate-400 text-[11px]"><?= date('d M Y, H:i', strtotime($aduan['tanggal'])); ?> WITA</span>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold border <?= $badge; ?>">
                            <?= htmlspecialchars($aduan['status']); ?>
                        </span>
                    </div>

                    <div>
                        <h4 class="font-bold text-slate-900 text-sm"><?= htmlspecialchars($aduan['judul']); ?></h4>
                        <p class="text-slate-600 mt-1 leading-relaxed"><?= nl2br(htmlspecialchars($aduan['isi'])); ?></p>
                    </div>

                    <?php if (!empty($aduan['tanggapan'])): ?>
                    <div class="p-3 bg-emerald-50 rounded-lg border-l-4 border-emerald-600 text-emerald-950">
                        <strong class="block text-[11px] text-emerald-800">Tanggapan Resmi Desa:</strong>
                        <p class="mt-0.5"><?= nl2br(htmlspecialchars($aduan['tanggapan'])); ?></p>
                    </div>
                    <?php endif; ?>

                    <div class="pt-2">
                        <button onclick="openResponModal(<?= htmlspecialchars(json_encode($aduan)); ?>)" class="bg-emerald-700 hover:bg-emerald-800 text-white px-3 py-1.5 rounded text-xs font-semibold transition flex items-center gap-1">
                            <i class="fa-solid fa-reply"></i> Berikan Tanggapan / Update Status
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </main>

    <!-- MODAL RESPON ADUAN -->
    <div id="modalRespon" class="fixed inset-0 bg-slate-950/60 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden border border-slate-200">
            <div class="bg-slate-900 text-white p-4 flex justify-between items-center">
                <h3 class="font-bold text-sm">Respon Aspirasi Warga</h3>
                <button onclick="closeResponModal()" class="text-slate-400 hover:text-white">&times;</button>
            </div>
            <form action="pengaduan.php" method="POST" class="p-5 space-y-4 text-xs">
                <input type="hidden" name="action" value="respon_aduan">
                <input type="hidden" name="id" id="modal-aduan-id">

                <div>
                    <label class="block text-slate-500 mb-0.5">Topik Laporan:</label>
                    <div class="font-bold text-slate-900" id="modal-aduan-judul"></div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Penanganan:</label>
                    <select name="status" id="modal-aduan-status" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 bg-white font-semibold">
                        <option value="Diterima">Diterima</option>
                        <option value="Ditindaklanjuti">Ditindaklanjuti</option>
                        <option value="Selesai">Selesai</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Tanggapan Resmi Pemerintah Desa:</label>
                    <textarea name="tanggapan" id="modal-aduan-tanggapan" rows="4" required placeholder="Tuliskan tindakan atau penjelasan yang diberikan pemerintah desa..." class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t">
                    <button type="button" onclick="closeResponModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded font-semibold text-slate-700">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded font-bold">Simpan Tanggapan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openResponModal(data) {
            document.getElementById('modal-aduan-id').value = data.id;
            document.getElementById('modal-aduan-judul').innerText = data.judul + ' (oleh ' + data.nama + ')';
            document.getElementById('modal-aduan-status').value = data.status;
            document.getElementById('modal-aduan-tanggapan').value = data.tanggapan || '';
            document.getElementById('modalRespon').classList.remove('hidden');
            document.getElementById('modalRespon').classList.add('flex');
        }
        function closeResponModal() {
            document.getElementById('modalRespon').classList.add('hidden');
            document.getElementById('modalRespon').classList.remove('flex');
        }
    </script>

</body>
</html>
