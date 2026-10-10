<?php
// admin/login.php
session_start();
require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

$error = null;

if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM admin_users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['nama'];
        $_SESSION['admin_role'] = $user['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = "Username atau password yang Anda masukkan salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrator | Desa Montong Betok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-slate-900 min-h-screen flex items-center justify-center p-4 font-sans text-slate-800">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-slate-700">
        <div class="bg-emerald-900 p-6 text-white text-center border-b-4 border-amber-400">
            <div class="w-16 h-16 bg-white p-2 rounded-2xl mx-auto shadow-md mb-3 flex items-center justify-center">
                <img src="https://desamb.id/desa/logo/GkRCb_1762898002_logo__1_-removebg-preview.png" alt="Logo" class="max-h-full">
            </div>
            <h1 class="text-xl font-black uppercase tracking-wider">Desa Montong Betok</h1>
            <p class="text-xs text-emerald-200 mt-1">Panel Administrasi &amp; Operator Desa</p>
        </div>

        <div class="p-6 sm:p-8 space-y-4">
            <?php if ($error): ?>
            <div class="p-3 bg-rose-50 border border-rose-200 rounded-lg text-xs text-rose-700 font-medium flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation text-rose-500"></i>
                <?= htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <form action="login.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Username</label>
                    <div class="relative">
                        <i class="fa-solid fa-user absolute left-3 top-3 text-slate-400 text-xs"></i>
                        <input type="text" name="username" required placeholder="admin" value="admin" class="w-full pl-9 pr-3 py-2 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                    <div class="relative">
                        <i class="fa-solid fa-lock absolute left-3 top-3 text-slate-400 text-xs"></i>
                        <input type="password" name="password" required placeholder="admin123" value="admin123" class="w-full pl-9 pr-3 py-2 text-xs rounded-lg border border-slate-300 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                    </div>
                </div>

                <div class="p-2.5 bg-emerald-50 border border-emerald-200 rounded-lg text-[11px] text-emerald-900">
                    <i class="fa-solid fa-info-circle text-emerald-600 mr-1"></i> Akun bawaan: Username: <strong>admin</strong> | Password: <strong>admin123</strong>
                </div>

                <button type="submit" class="w-full py-2.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-lg text-xs transition shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i> Masuk ke Dashboard
                </button>
            </form>

            <div class="pt-2 text-center">
                <a href="../index.php" class="text-xs text-emerald-700 hover:underline">
                    <i class="fa-solid fa-arrow-left text-[10px] mr-1"></i> Kembali ke Halaman Utama
                </a>
            </div>
        </div>
    </div>

</body>
</html>
