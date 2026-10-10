<?php
// admin/surat.php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

$msg = null;

// Proses Update Status Surat
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_status') {
    $id = (int)$_POST['id'];
    $status = trim($_POST['status']);
    $keterangan = trim($_POST['keterangan_admin']);

    $stmt = $pdo->prepare("UPDATE permohonan_surat SET status = ?, keterangan_admin = ? WHERE id = ?");
    $stmt->execute([$status, $keterangan, $id]);
    $msg = "Status surat berhasil diperbarui!";
}

// Ambil semua surat
$stmt = $pdo->query("SELECT * FROM permohonan_surat ORDER BY id DESC");
$suratList = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Permohonan Surat | Operator Desa Montong Betok</title>
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
            <a href="surat.php" class="bg-emerald-700 text-white px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-file-signature"></i> Kelola Surat Masuk
            </a>
            <a href="berita.php" class="text-slate-600 hover:bg-slate-100 px-3 py-2 rounded-lg flex items-center gap-1.5 shrink-0">
                <i class="fa-solid fa-newspaper text-emerald-600"></i> Kelola Berita Desa
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
                <h1 class="text-xl font-black text-slate-900">Kelola Permohonan Surat Warga</h1>
                <p class="text-xs text-slate-500">Verifikasi berkas, ubah status pengerjaan, dan beri catatan instruksi pengambilan.</p>
            </div>
        </div>

        <?php if ($msg): ?>
        <div class="p-3 bg-emerald-100 border border-emerald-300 rounded-lg text-xs text-emerald-800 font-bold flex items-center gap-2">
            <i class="fa-solid fa-check-circle text-emerald-600"></i> <?= htmlspecialchars($msg); ?>
        </div>
        <?php endif; ?>

        <!-- TABEL SURAT MASUK -->
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="bg-slate-100 text-slate-700 font-bold uppercase border-b border-slate-200">
                        <tr>
                            <th class="py-3 px-4">No. Resi</th>
                            <th class="py-3 px-4">Nama &amp; NIK Pemohon</th>
                            <th class="py-3 px-4">Dusun / No HP</th>
                            <th class="py-3 px-4">Jenis Surat &amp; Keperluan</th>
                            <th class="py-3 px-4">Status &amp; Keterangan</th>
                            <th class="py-3 px-4 text-center">Aksi / Verifikasi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        <?php foreach ($suratList as $s): 
                            $statusClass = 'bg-yellow-100 text-yellow-800 border-yellow-300';
                            if ($s['status'] === 'Sedang Diproses') $statusClass = 'bg-blue-100 text-blue-800 border-blue-300';
                            if ($s['status'] === 'Siap Diambil') $statusClass = 'bg-emerald-100 text-emerald-800 border-emerald-300';
                            if ($s['status'] === 'Ditolak') $statusClass = 'bg-rose-100 text-rose-800 border-rose-300';
                        ?>
                        <tr class="hover:bg-slate-50">
                            <td class="py-3 px-4 font-mono font-bold text-emerald-800 whitespace-nowrap">
                                <?= htmlspecialchars($s['no_resi']); ?>
                                <span class="block text-[10px] text-slate-400 font-sans font-normal"><?= date('d/m/Y H:i', strtotime($s['tanggal_pengajuan'])); ?></span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-bold text-slate-900 block"><?= htmlspecialchars($s['nama']); ?></span>
                                <span class="font-mono text-slate-500 text-[11px]"><?= htmlspecialchars($s['nik']); ?></span>
                            </td>
                            <td class="py-3 px-4">
                                <span class="font-medium text-slate-800 block"><?= htmlspecialchars($s['dusun']); ?></span>
                                <span class="text-emerald-700 font-mono text-[11px]">
                                    <i class="fa-brands fa-whatsapp text-emerald-600 mr-1"></i><?= htmlspecialchars($s['no_hp']); ?>
                                </span>
                            </td>
                            <td class="py-3 px-4 max-w-xs">
                                <strong class="text-slate-900 block"><?= htmlspecialchars($s['jenis_surat']); ?></strong>
                                <span class="text-slate-500 text-[11px] line-clamp-2"><?= htmlspecialchars($s['keperluan']); ?></span>
                            </td>
                            <td class="py-3 px-4 max-w-xs">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold border <?= $statusClass; ?>">
                                    <?= htmlspecialchars($s['status']); ?>
                                </span>
                                <?php if (!empty($s['keterangan_admin'])): ?>
                                <p class="text-[11px] text-slate-500 mt-1 line-clamp-2 italic">
                                    "<?= htmlspecialchars($s['keterangan_admin']); ?>"
                                </p>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-center whitespace-nowrap">
                                <button onclick="openModal(<?= htmlspecialchars(json_encode($s)); ?>)" class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-1.5 rounded text-xs font-semibold transition shadow flex items-center gap-1 mx-auto">
                                    <i class="fa-solid fa-pen-to-square"></i> Proses
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- MODAL PROSES SURAT -->
    <div id="modalSurat" class="fixed inset-0 bg-slate-950/60 hidden items-center justify-center p-4 z-50">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full overflow-hidden border border-slate-200">
            <div class="bg-slate-900 text-white p-4 flex justify-between items-center">
                <h3 class="font-bold text-sm">Verifikasi Permohonan Surat</h3>
                <button onclick="closeModal()" class="text-slate-400 hover:text-white">&times;</button>
            </div>
            <form action="surat.php" method="POST" class="p-5 space-y-4 text-xs">
                <input type="hidden" name="action" value="update_status">
                <input type="hidden" name="id" id="modal-id">

                <div>
                    <label class="block text-slate-500 mb-0.5">Pemohon &amp; Resi:</label>
                    <div class="font-bold text-slate-900" id="modal-nama"></div>
                    <div class="font-mono text-emerald-800 text-[11px]" id="modal-resi"></div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Permohonan:</label>
                    <select name="status" id="modal-status" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 bg-white font-semibold">
                        <option value="Menunggu Verifikasi">Menunggu Verifikasi</option>
                        <option value="Sedang Diproses">Sedang Diproses</option>
                        <option value="Siap Diambil">Siap Diambil</option>
                        <option value="Ditolak">Ditolak</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Catatan / Keterangan untuk Pemohon:</label>
                    <textarea name="keterangan_admin" id="modal-ket" rows="3" placeholder="Contoh: Surat sudah ditandatangani. Silakan ambil di loket pelayanan kantor desa jam 08:00 - 15:30 WITA." class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500"></textarea>
                </div>

                <div class="flex justify-end gap-2 pt-2 border-t">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 rounded font-semibold text-slate-700">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded font-bold">Simpan Status</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(data) {
            document.getElementById('modal-id').value = data.id;
            document.getElementById('modal-nama').innerText = data.nama + ' (' + data.jenis_surat + ')';
            document.getElementById('modal-resi').innerText = 'Resi: ' + data.no_resi;
            document.getElementById('modal-status').value = data.status;
            document.getElementById('modal-ket').value = data.keterangan_admin || '';
            document.getElementById('modalSurat').classList.remove('hidden');
            document.getElementById('modalSurat').classList.add('flex');
        }
        function closeModal() {
            document.getElementById('modalSurat').classList.add('hidden');
            document.getElementById('modalSurat').classList.remove('flex');
        }
    </script>

</body>
</html>
