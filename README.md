# Website Resmi Desa Montong Betok (PHP Backend & OpenSID Architecture)
**Kecamatan Montong Gading, Kabupaten Lombok Timur, Provinsi Nusa Tenggara Barat**  
*Proyek KKN 2026 &bull; Referensi Langsung: [https://desamb.id/](https://desamb.id/)*

---

## 📌 Ringkasan Proyek
Aplikasi web desa berbasis **PHP** murni (Native/Modular) dan didesain responsif menggunakan **Tailwind CSS**, **FontAwesome 6**, dan **Chart.js**. Website ini mengadopsi struktur Sistem Informasi Desa (OpenSID) dengan data otentik langsung dari portal resmi [desamb.id](https://desamb.id/).

---

## 🚀 Cara Menjalankan Aplikasi

### Cara 1: Menggunakan File Batch (Paling Praktis)
1. Buka folder `D:\KKN 2026\Project\web_desa`.
2. Klik ganda (double click) file **`jalankan_server.bat`**.
3. Browser akan otomatis terbuka ke alamat `http://localhost:8000`.

### Cara 2: Menjalankan via Terminal / Command Prompt
Buka terminal di folder proyek dan jalankan:
```bash
"C:\xampp\php\php.exe" -S localhost:8000
```
Lalu buka browser Anda ke `http://localhost:8000`.

### Migrasi ke Supabase
Aplikasi sudah mendukung koneksi ke Supabase PostgreSQL dari `config/database.php`.

Set variabel environment berikut sebelum menjalankan aplikasi:
```bash
set DB_DRIVER=supabase
set DB_HOST=aws-0-ap-southeast-1.pooler.supabase.com
set DB_PORT=5432
set DB_NAME=postgres
set DB_USER=postgres
set DB_PASS=PASSWORD_Supabase_Anda
```

Atau untuk koneksi langsung:
```bash
set DATABASE_URL=postgresql://postgres:PASSWORD_Supabase_Anda@db.xxxxxxxxxxxx.supabase.co:5432/postgres?sslmode=require
```

Setelah variabel terisi, jalankan aplikasi seperti biasa. File SQL siap pakai ada di `config/database_supabase.sql` dan dapat dijalankan langsung di Supabase SQL Editor.

---

## 🔑 Akun Login Administrator / Operator Desa
* **URL Login**: `http://localhost:8000/admin/login.php` (atau klik menu **Login Admin** di pojok kanan atas)
* **Username**: `admin`
* **Password**: `admin123`

---

## 📂 Struktur Direktori Proyek

```
web_desa/
├── config/
│   ├── database.php          # Koneksi database PDO (SQLite / MySQL) & auto-migration
│   └── database_mysql.sql    # Schema & dump SQL jika ingin diimpor ke phpMyAdmin
├── includes/
│   ├── header.php            # Identitas desa, logo Lombok Timur, ticker info, & meta SEO
│   ├── navbar.php            # Navigasi utama responsif (desktop & mobile)
│   ├── sidebar.php           # Widget pencarian, aparatur, statistik, agenda, & peta kantor
│   └── footer.php            # Kontak resmi, profil dusun, & copyright KKN 2026
├── pages/
│   ├── beranda.php           # Hero carousel, tombol cepat, sambutan kades, berita, & galeri
│   ├── profil.php            # Visi & Misi, Sejarah Desa, & Wilayah Dusun
│   ├── pemerintahan.php      # Struktur pimpinan (Pj. Kades, Sekdes) & 14 aparatur desa
│   ├── layanan.php           # Layanan Mandiri: Permohonan surat online & Pelacakan no. resi
│   ├── statistik.php         # Grafik interaktif Chart.js (Gender, Dusun, Pekerjaan, Umur)
│   ├── apbd.php              # Transparansi APBD Desa 2026 (Anggaran vs Realisasi)
│   ├── berita.php            # Daftar artikel & pengumuman dengan filter kategori & search
│   ├── detail-berita.php     # Halaman baca artikel lengkap dengan tombol share medsos
│   └── pengaduan.php         # Form pengaduan/aspirasi warga & status tindak lanjut desa
├── admin/
│   ├── index.php             # Dashboard ringkasan (surat pending, total berita, aduan)
│   ├── login.php             # Halaman autentikasi operator desa
│   ├── logout.php            # Keluar sesi admin
│   ├── surat.php             # Verifikasi berkas permohonan surat & update status resi
│   ├── berita.php            # Publikasi & kelola artikel berita desa
│   └── pengaduan.php         # Berikan tanggapan resmi atas keluhan/aspirasi warga
├── database.sqlite           # Database mandiri SQLite (otomatis terisi data resmi desamb.id)
├── jalankan_server.bat       # Script 1-klik untuk start server lokal & buka browser
├── index.php                 # Front controller / router aplikasi
└── README.md                 # Dokumentasi proyek
```

---

## 🌟 Fitur Utama yang Telah Berfungsi Penuh:
1. **Layanan Mandiri Permohonan Surat Online**:
   * Warga mengisi formulir (NIK, Nama, Dusun, No HP WhatsApp, Jenis Surat: SKU, SKTM, Domisili, SKCK, dsb.).
   * Otomatis menerbitkan **Nomor Resi Unik** (misal: `SRT-202609-XXXX`).
   * Warga dapat melacak status suratnya secara real-time (*Menunggu Verifikasi*, *Sedang Diproses*, *Siap Diambil*, *Ditolak*).
2. **Kabar & Berita Desa Dinamis**:
   * Data artikel riil dari Montong Betok (Lelang Tanah Pecatu, Analisis SDM, Penghijauan KKN, Bantuan Pangan, dsb.).
   * Penghitung jumlah pembaca (*view counter*).
   * Filter kategori dan pencarian kata kunci.
3. **Statistik Demografi & Grafik Interaktif (Chart.js)**:
   * Menampilkan data kependudukan nyata Montong Betok (Total: 9.462 jiwa, Laki-laki: 4.638, Perempuan: 4.824).
   * Grafik komposisi jenis kelamin, persebaran 5 dusun, pekerjaan, dan piramida usia.
4. **Transparansi APBD Desa**:
   * Menampilkan rincian pendapatan (Dana Desa DDS, ADD, PADes) dan belanja fisik/sosial tahun 2026 beserta progress bar realisasinya.
5. **Aspirasi & Pengaduan Warga**:
   * Formulir aduan warga langsung masuk ke database.
   * Pemerintah desa dapat menanggapi dan mengubah statusnya menjadi *Ditindaklanjuti* atau *Selesai*.
6. **Dashboard Operator / Admin Desa**:
   * Panel khusus untuk memverifikasi surat masuk, menerbitkan artikel baru, dan merespon pengaduan warga.
