<?php
/**
 * Database Connection & Auto-Setup
 * Mendukung SQLite lokal, MySQL/XAMPP, dan Supabase PostgreSQL.
 * Untuk Supabase, isi variabel environment berikut:
 *   DB_DRIVER=supabase
 *   DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
 *   DB_PORT=5432
 *   DB_NAME=postgres
 *   DB_USER=postgres
 *   DB_PASS=your-password
 * atau gunakan DATABASE_URL=postgresql://user:pass@host:5432/postgres?sslmode=require
 */

function loadDotEnv($path) {
    $envFile = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . '.env';
    if (!is_file($envFile)) {
        return;
    }

    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if ($lines === false) {
        return;
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }

        [$key, $value] = array_pad(explode('=', $line, 2), 2, '');
        $key = trim($key);
        $value = trim($value);

        if ($key === '') {
            continue;
        }

        if (($value[0] ?? '') === '"' && substr($value, -1) === '"') {
            $value = substr($value, 1, -1);
        } elseif (($value[0] ?? '') === "'" && substr($value, -1) === "'") {
            $value = substr($value, 1, -1);
        }

        $_ENV[$key] = $value;
        putenv($key . '=' . $value);
    }
}

loadDotEnv(__DIR__ . '/..');

function getEnvValue($keys, $default = null) {
    foreach ((array) $keys as $key) {
        $value = getenv($key);
        if ($value !== false && $value !== null && $value !== '') {
            return $value;
        }

        if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
            return $_ENV[$key];
        }
    }

    return $default;
}

$autoDriver = getEnvValue(['DB_DRIVER', 'DATABASE_DRIVER'], getEnvValue(['DATABASE_URL', 'DB_URL', 'SUPABASE_DB_URL'], null) ? 'supabase' : 'sqlite');
define('DB_DRIVER', strtolower($autoDriver));
define('DB_HOST', getEnvValue(['DB_HOST', 'SUPABASE_HOST'], 'localhost'));
define('DB_PORT', getEnvValue(['DB_PORT', 'SUPABASE_PORT'], '5432'));
define('DB_NAME', getEnvValue(['DB_NAME', 'PGDATABASE', 'SUPABASE_DB'], 'db_montong_betok'));
define('DB_USER', getEnvValue(['DB_USER', 'PGUSER', 'SUPABASE_USER'], 'root'));
define('DB_PASS', getEnvValue(['DB_PASS', 'PGPASSWORD', 'SUPABASE_PASSWORD'], ''));
define('DB_URL', getEnvValue(['DB_URL', 'DATABASE_URL', 'SUPABASE_DB_URL'], ''));
define('SUPABASE_URL', getEnvValue(['SUPABASE_URL', 'NEXT_PUBLIC_SUPABASE_URL'], ''));
define('SUPABASE_ANON_KEY', getEnvValue(['SUPABASE_ANON_KEY', 'NEXT_PUBLIC_SUPABASE_ANON_KEY', 'SUPABASE_KEY', 'SUPABASE_API_KEY'], ''));
define('SUPABASE_SERVICE_ROLE_KEY', getEnvValue(['SUPABASE_SERVICE_ROLE_KEY', 'SUPABASE_SERVICE_KEY'], ''));

function getSupabaseHeaders($withServiceRole = false) {
    $key = $withServiceRole ? SUPABASE_SERVICE_ROLE_KEY : SUPABASE_ANON_KEY;

    return [
        'Authorization: Bearer ' . $key,
        'apikey: ' . $key,
        'Content-Type: application/json',
    ];
}

function isPostgresDriver() {
    return in_array(DB_DRIVER, ['postgres', 'pgsql', 'supabase'], true);
}

function buildPdoDsn() {
    if (DB_URL !== '') {
        $parsed = parse_url(DB_URL);
        if ($parsed !== false && isset($parsed['scheme'])) {
            $scheme = strtolower((string) $parsed['scheme']);
            if (str_starts_with($scheme, 'postgres')) {
                $host = $parsed['host'] ?? DB_HOST;
                $port = $parsed['port'] ?? DB_PORT;
                $dbname = ltrim($parsed['path'] ?? '/', '/');
                $user = $parsed['user'] ?? DB_USER;
                $pass = $parsed['pass'] ?? DB_PASS;

                return "pgsql:host={$host};port={$port};dbname={$dbname};user={$user};password={$pass}";
            }
        }
    }

    switch (DB_DRIVER) {
        case 'mysql':
            return "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
        case 'postgres':
        case 'pgsql':
        case 'supabase':
            return "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";user=" . DB_USER . ";password=" . DB_PASS;
        case 'sqlite':
        default:
            return "sqlite:" . __DIR__ . '/../database.sqlite';
    }
}

function getDB() {
    static $pdo = null;
    if ($pdo !== null) {
        return $pdo;
    }

    try {
        if (DB_DRIVER === 'sqlite') {
            $dbPath = __DIR__ . '/../database.sqlite';
            $isNew = !file_exists($dbPath);
            $pdo = new PDO("sqlite:" . $dbPath);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            if ($isNew || filesize($dbPath) === 0) {
                initDatabase($pdo);
            }
        } else {
            $pdo = new PDO(buildPdoDsn());
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            initDatabase($pdo);
        }

        return $pdo;
    } catch (PDOException $e) {
        die("Gagal menghubungkan ke database: " . $e->getMessage());
    }
}

function initDatabase($pdo) {
    $isPg = isPostgresDriver();
    $idColumn = $isPg ? 'BIGINT GENERATED BY DEFAULT AS IDENTITY PRIMARY KEY' : 'INTEGER PRIMARY KEY AUTOINCREMENT';
    $timestampDefault = $isPg ? 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP' : 'DATETIME DEFAULT CURRENT_TIMESTAMP';
    $dateDefault = $isPg ? 'DATE DEFAULT CURRENT_DATE' : 'DATE DEFAULT CURRENT_DATE';

    // 1. Tabel Berita
    $pdo->exec("CREATE TABLE IF NOT EXISTS berita (
        id {$idColumn},
        judul TEXT NOT NULL,
        slug TEXT NOT NULL,
        kategori TEXT NOT NULL,
        ringkasan TEXT,
        isi TEXT NOT NULL,
        gambar TEXT,
        penulis TEXT DEFAULT 'Administrator',
        tanggal {$dateDefault},
        dilihat INTEGER DEFAULT 0
    )");

    // 2. Tabel Aparatur Desa
    $pdo->exec("CREATE TABLE IF NOT EXISTS aparatur (
        id {$idColumn},
        nama TEXT NOT NULL,
        jabatan TEXT NOT NULL,
        foto TEXT,
        status_kehadiran TEXT DEFAULT 'Hadir',
        urutan INTEGER DEFAULT 0
    )");

    // 3. Tabel Permohonan Surat Online
    $pdo->exec("CREATE TABLE IF NOT EXISTS permohonan_surat (
        id {$idColumn},
        no_resi TEXT UNIQUE NOT NULL,
        nik TEXT NOT NULL,
        nama TEXT NOT NULL,
        dusun TEXT NOT NULL,
        no_hp TEXT NOT NULL,
        jenis_surat TEXT NOT NULL,
        keperluan TEXT,
        status TEXT DEFAULT 'Menunggu Verifikasi',
        keterangan_admin TEXT,
        tanggal_pengajuan {$timestampDefault}
    )");

    // 4. Tabel Pengaduan Warga
    $pdo->exec("CREATE TABLE IF NOT EXISTS pengaduan (
        id {$idColumn},
        nama TEXT NOT NULL,
        dusun TEXT NOT NULL,
        judul TEXT NOT NULL,
        isi TEXT NOT NULL,
        status TEXT DEFAULT 'Diterima',
        tanggapan TEXT,
        tanggal {$timestampDefault}
    )");

    // 5. Tabel Admin
    $pdo->exec("CREATE TABLE IF NOT EXISTS admin_users (
        id {$idColumn},
        username TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        nama TEXT NOT NULL,
        role TEXT DEFAULT 'Admin'
    )");

    // 6. Tabel APBD
    $pdo->exec("CREATE TABLE IF NOT EXISTS apbd (
        id {$idColumn},
        tahun INTEGER NOT NULL,
        jenis TEXT NOT NULL,
        rincian TEXT NOT NULL,
        anggaran REAL NOT NULL,
        realisasi REAL NOT NULL
    )");

    $adminCount = $pdo->query("SELECT COUNT(*) AS total FROM admin_users")->fetchColumn();
    if ((int) $adminCount === 0) {
        $adminPass = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admin_users (username, password, nama, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['admin', $adminPass, 'Operator Desa Montong Betok', 'Administrator']);
    }

    $aparaturCount = $pdo->query("SELECT COUNT(*) AS total FROM aparatur")->fetchColumn();
    if ((int) $aparaturCount === 0) {
        $stmtAparatur = $pdo->prepare("INSERT INTO aparatur (nama, jabatan, foto, status_kehadiran, urutan) VALUES (?, ?, ?, ?, ?)");
        $aparaturData = [
            ['Dian Asmara Desa, S.Pd', 'Pj. Kepala Desa', 'https://desamb.id/desa/upload/user_pict/SVD0D_1763441725979995.jpg', 'Hadir', 1],
            ['RONY FARICK ZIATH, S.Pd.I', 'Sekretaris Desa', 'https://desamb.id/desa/upload/user_pict/7fsFc_1763340467310145.jpg', 'Hadir', 2],
            ['FERI JAYADI, S.Pd', 'Kepala Wilayah Dusun Lekong Rempung', 'https://desamb.id/desa/upload/user_pict/x7b7j_1763342840777032.jpg', 'Hadir', 3],
            ['SAROAN', 'Kepala Wilayah Dusun Mujur', 'https://desamb.id/desa/upload/user_pict/uqxWI_1763439406531736.jpg', 'Hadir', 4],
            ['SUPRIADI', 'Kepala Wilayah Dusun Temubireng', 'https://desamb.id/assets/images/pengguna/kuser.png', 'Hadir', 5],
            ['MANHARI', 'Kepala Wilayah Dusun Otak Desa', 'https://desamb.id/assets/images/pengguna/kuser.png', 'Hadir', 6],
            ['UHEL WIRAHADI', 'Kepala Wilayah Dusun Temayang', 'https://desamb.id/assets/images/pengguna/kuser.png', 'Hadir', 7],
            ['MARIANI', 'Kaur TU dan Umum', 'https://desamb.id/desa/upload/user_pict/gQTuq_1763439295720252.jpeg', 'Hadir', 8],
            ['ROSIN IHSANI', 'Kaur Perencanaan', 'https://desamb.id/desa/upload/user_pict/x7b7j_1763439686933999.jpg', 'Hadir', 9],
            ['HARDIMAN', 'Kaur Keuangan', 'https://desamb.id/assets/images/pengguna/kuser.png', 'Hadir', 10],
            ['KARYAWAN', 'Kasi Pemerintahan', 'https://desamb.id/desa/upload/user_pict/kRCbS_1763524886324697.jpg', 'Hadir', 11],
            ['HERMAN JAYADI', 'Kasi Kesra', 'https://desamb.id/assets/images/pengguna/kuser.png', 'Hadir', 12],
            ['BAIQ ILDA AYUDYA', 'Staf Pelayanan', 'https://desamb.id/desa/upload/user_pict/VD0D0_1763440955601537.jpeg', 'Hadir', 13],
            ['WAHYU NOVIA YULIANTI', 'Staf Administrasi', 'https://desamb.id/desa/upload/user_pict/IdA9D_1763440926859398.jpeg', 'Hadir', 14]
        ];
        foreach ($aparaturData as $row) {
            $stmtAparatur->execute($row);
        }
    }

    $beritaCount = $pdo->query("SELECT COUNT(*) AS total FROM berita")->fetchColumn();
    if ((int) $beritaCount === 0) {
        $stmtBerita = $pdo->prepare("INSERT INTO berita (judul, slug, kategori, ringkasan, isi, gambar, penulis, tanggal, dilihat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $beritaData = [
            [
                'LELANG TANAH PECATU DESA MONTONG BETOK',
                'lelang-tanah-pecatu-desa-montong-betok',
                'Pengumuman',
                'Lelang tanah Pecatu Desa Montong Betok yang akan dilaksanakan secara terbuka bagi warga masyarakat yang berminat.',
                '<p>Pemerintah Desa Montong Betok mengumumkan bahwa pelaksanaan <strong>Lelang Tanah Pecatu</strong> akan diselenggarakan secara terbuka untuk seluruh masyarakat. Kegiatan ini bertujuan untuk mengoptimalkan pemanfaatan aset desa dan transparansi pengelolaan tanah kas desa.</p><p>Bagi warga yang berminat mengikuti pelelangan dapat mendaftarkan diri di Kantor Desa Montong Betok pada jam kerja atau menghubungi sekretariat desa.</p>',
                'https://desamb.id/desa/upload/artikel/sedang_A9D3h_1767582034_pecatu.webp',
                'Administrator',
                '2026-01-05',
                342
            ],
            [
                'Analisis SDM dan Profil Kependudukan Desa Montong Betok',
                'analisis-sdm-desa-montong-betok',
                'Berita Desa',
                'Analisis kependudukan dan pemetaan potensi sumber daya manusia untuk mendukung program pembangunan desa berkelanjutan.',
                '<p>Analisis profil kependudukan dan sumber daya manusia (SDM) di Desa Montong Betok terus dimutakhirkan. Langkah ini dilakukan agar seluruh program intervensi sosial, bantuan pangan, dan pelatihan kerja tepat sasaran berdasarkan data statistik kependudukan terbaru.</p>',
                'https://desamb.id/desa/upload/artikel/sedang_dA9D3_1765520604_tidak_belum_sekolah.webp',
                'Administrator',
                '2025-12-12',
                215
            ],
            [
                'PENGHIJAUAN: Kerjasama Pemdes Montong Betok dengan Mahasiswa KKN',
                'penghijauan-kerjasama-pemdes-dan-kkn',
                'Berita Desa',
                'Kegiatan penanaman bibit pohon di area mata air dan fasilitas umum guna menjaga kelestarian lingkungan desa.',
                '<p>Pemerintah Desa Montong Betok bekerja sama dengan mahasiswa KKN dan elemen pemuda Karang Taruna melaksanakan aksi nyata penanaman pohon penghijauan di sekitar daerah tangkapan air dan bahu jalan desa. Kegiatan ini diharapkan memperkuat ketahanan air dan keasrian lingkungan desa.</p>',
                'https://desamb.id/desa/upload/artikel/sedang_QTuqx_1763431016_MATA_AIR.webp',
                'Administrator',
                '2025-11-18',
                198
            ],
            [
                'Penyaluran Bantuan Pangan (BAPANG) untuk Warga Penerima Manfaat',
                'penyaluran-bantuan-pangan-bapang',
                'Berita Desa',
                'Penyaluran perdana beras bantuan pangan bagi keluarga penerima manfaat di seluruh dusun se-Desa Montong Betok.',
                '<p>Pemerintah Desa Montong Betok menyalurkan bantuan pangan berupa beras dari Badan Pangan Nasional (Bapanas) kepada masyarakat penerima manfaat. Pembagian dilakukan secara tertib dan transparan di aula kantor desa dengan pendampingan aparatur kewilayahan (Kadus).</p>',
                'https://desamb.id/desa/upload/artikel/sedang_uqxWI_1763338863_bapang.webp',
                'Administrator',
                '2025-11-17',
                450
            ],
            [
                'Turnamen Silaturahmi Tenis Meja Antar-Dusun Desa Montong Betok',
                'turnamen-silaturahmi-tenis-meja',
                'Kegiatan Warga',
                'Meriahnya kejuaraan tenis meja sebagai wadah silaturahmi pemuda dan masyarakat antar dusun.',
                '<p>Dalam rangka mempererat tali persaudaraan dan kekompakan warga, Karang Taruna Desa Montong Betok menggelar Turnamen Tenis Meja Cup. Pertandingan yang berlangsung sengit dan sportif ini mendapat apresiasi antusias dari ratusan warga penonton.</p>',
                'https://desamb.id/desa/upload/artikel/sedang_cKx7b_1763338450_TENIS_MEJA.webp',
                'Administrator',
                '2025-11-17',
                320
            ],
            [
                'Gawe Desa Praja Yatim II: Semarak Santunan & Doa Bersama',
                'gawe-desa-praja-yatim-ii-montong-betok',
                'Budaya & Religi',
                'Kegiatan tahunan santunan anak yatim piatu dan khitanan massal oleh Lembaga Adat dan Mahasiswa KKN.',
                '<p>Lembaga Adat Desa Montong Betok bersama mahasiswa KKN menyelenggarakan "Gawe Desa Praja Yatim II". Acara ini mencakup santunan anak yatim, khitanan massal gratis, dan pengajian akbar yang dihadiri oleh seluruh tokoh agama, tokoh masyarakat, dan pimpinan wilayah.</p>',
                'https://desamb.id/desa/upload/artikel/sedang_WIdA9_1763108002_sunatan_masal.webp',
                'Administrator',
                '2025-11-14',
                580
            ],
            [
                'Sosialisasi Pengelolaan Sampah Mandiri Bersama DLHK dan Karang Taruna',
                'sosialisasi-pengelolaan-sampah-dlhk-kkn',
                'Edukasi',
                'Pemberdayaan warga mengenai pemilahan sampah organik dan anorganik demi mewujudkan desa bersih dan sehat.',
                '<p>Program kerja kolaborasi antara mahasiswa KKN, Karang Taruna, dan Dinas Lingkungan Hidup dan Kehutanan (DLHK) ini memberikan pemahaman teknis kepada warga tentang pengelolaan sampah dari skala rumah tangga hingga bank sampah desa.</p>',
                'https://desamb.id/desa/upload/artikel/sedang_7b7j0_1763105782_WhatsApp_Image_2025-11-13_at_13_19_38.webp',
                'Administrator',
                '2025-11-14',
                275
            ]
        ];
        foreach ($beritaData as $row) {
            $stmtBerita->execute($row);
        }
    }

    $apbdCount = $pdo->query("SELECT COUNT(*) AS total FROM apbd")->fetchColumn();
    if ((int) $apbdCount === 0) {
        $stmtAPBD = $pdo->prepare("INSERT INTO apbd (tahun, jenis, rincian, anggaran, realisasi) VALUES (?, ?, ?, ?, ?)");
        $apbdData = [
            [2026, 'Pendapatan', 'Dana Desa (DDS)', 1150000000, 1150000000],
            [2026, 'Pendapatan', 'Alokasi Dana Desa (ADD)', 620000000, 620000000],
            [2026, 'Pendapatan', 'Bagi Hasil Pajak & Retribusi', 45000000, 45000000],
            [2026, 'Pendapatan', 'Pendapatan Asli Desa (PADes)', 35000000, 32000000],
            [2026, 'Belanja', 'Bidang Penyelenggaraan Pemerintahan Desa', 580000000, 560000000],
            [2026, 'Belanja', 'Bidang Pelaksanaan Pembangunan Desa (Fisik & Irigasi)', 790000000, 745000000],
            [2026, 'Belanja', 'Bidang Pembinaan Kemasyarakatan & Karang Taruna', 140000000, 135000000],
            [2026, 'Belanja', 'Bidang Pemberdayaan Masyarakat & Pertanian', 240000000, 220000000],
            [2026, 'Belanja', 'Bidang Penanggulangan Bencana & Darurat', 100000000, 75000000]
        ];
        foreach ($apbdData as $row) {
            $stmtAPBD->execute($row);
        }
    }

    // 7. Tabel SIG Lokasi
    $pdo->exec("CREATE TABLE IF NOT EXISTS lokasi (
        id {$idColumn},
        nama TEXT NOT NULL,
        lat REAL NOT NULL,
        lng REAL NOT NULL,
        kategori TEXT DEFAULT 'Umum',
        dusun TEXT DEFAULT 'Montong Betok',
        foto TEXT,
        deskripsi TEXT,
        tanggal {$timestampDefault}
    )");

    $lokasiCount = $pdo->query("SELECT COUNT(*) AS total FROM lokasi")->fetchColumn();
    if ((int) $lokasiCount === 0) {
        $stmtLokasi = $pdo->prepare("INSERT INTO lokasi (nama, lat, lng, kategori, dusun, foto, deskripsi) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $lokasiData = [
            ['Kantor Desa Montong Betok', -8.523, 116.412, 'Pemerintahan', 'Montong Betok', 'https://desamb.id/assets/images/kantor_desa.jpg', 'Pusat administrasi dan layanan surat warga.'],
            ['Dusun Lekong Rempung', -8.530, 116.405, 'Dusun', 'Lekong Rempung', '', 'Wilayah utara dengan akses jalan utama.'],
            ['Dusun Mujur', -8.518, 116.420, 'Dusun', 'Mujur', '', 'Wilayah timur, dekat area lelang tanah Pecatu.'],
            ['Dusun Temubireng', -8.515, 116.410, 'Dusun', 'Temubireng', '', 'Wilayah selatan dengan potensi pertanian.'],
            ['Dusun Otak Desa', -8.528, 116.418, 'Dusun', 'Otak Desa', '', 'Wilayah barat, dekat mata air dan irigasi.'],
            ['Dusun Temayang', -8.520, 116.400, 'Dusun', 'Temayang', '', 'Wilayah barat laut, akses ke jalan kabupaten.'],
        ];
        foreach ($lokasiData as $row) {
            $stmtLokasi->execute($row);
        }
    }

    $suratCount = $pdo->query("SELECT COUNT(*) AS total FROM permohonan_surat")->fetchColumn();
    if ((int) $suratCount === 0) {
        $pdo->exec("INSERT INTO permohonan_surat (no_resi, nik, nama, dusun, no_hp, jenis_surat, keperluan, status, keterangan_admin) VALUES 
            ('SRT-202601-0001', '5203110101900001', 'Ahmad Ridwan', 'Dusun Lekong Rempung', '081234567890', 'Surat Keterangan Usaha (SKU)', 'Pengajuan Kredit Usaha Rakyat (KUR) BRI', 'Siap Diambil', 'Surat telah ditandatangani Pj. Kepala Desa. Silakan ambil di loket kantor desa membawa fotokopi KTP.'),
            ('SRT-202601-0002', '5203110202950002', 'Siti Maryam', 'Dusun Mujur', '085234567891', 'Surat Keterangan Tidak Mampu (SKTM)', 'Persyaratan Beasiswa Kuliah Mahasiswa KKN', 'Sedang Diproses', 'Sedang dalam verifikasi berkas oleh Kasi Kesra.'),
            ('SRT-202601-0003', '5203110303980003', 'Hendra Kusuma', 'Dusun Temubireng', '087834567892', 'Surat Keterangan Domisili', 'Persyaratan pendaftaran kerja', 'Menunggu Verifikasi', 'Menunggu verifikasi admin loket.')
        ");
    }

    $aduanCount = $pdo->query("SELECT COUNT(*) AS total FROM pengaduan")->fetchColumn();
    if ((int) $aduanCount === 0) {
        $pdo->exec("INSERT INTO pengaduan (nama, dusun, judul, isi, status, tanggapan) VALUES 
            ('M. Junaidi', 'Dusun Temayang', 'Perbaikan Lampu Penerangan Jalan', 'Mohon lampu jalan di pertigaan menuju dusun temayang diperbaiki karena sudah mati selama 1 pekan.', 'Ditindaklanjuti', 'Terima kasih, permohonan sudah diteruskan ke tim teknis desa untuk penggantian bohlam hari ini.'),
            ('Lalu Supardi', 'Dusun Otak Desa', 'Saluran Irigasi Tersumbat Sedimen', 'Saluran irigasi dekat sawah warga tertutup lumpur setelah hujan deras, air meluap ke badan jalan.', 'Selesai', 'Gotong royong bersama warga dan mahasiswa KKN telah dilaksanakan untuk membersihkan saluran tersebut.')
        ");
    }
}

