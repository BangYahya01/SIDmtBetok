# PLAN SIG — Sistem Informasi Geografis Web Desa

## 1. Komponen SIG
- Peta interaktif (Leaflet + OpenStreetMap)
- Tabel `lokasi` (id, nama, lat, lng, kategori, dusun, foto, deskripsi)
- Layer: kantor desa, 5 dusun, fasilitas umum, area lelang/pengaduan

## 2. Integrasi dengan Web
- `pages/peta.php` — halaman publik
- `admin/peta.php` — input/edit titik
- Link ke statistik, berita, profil, layanan surat

## 3. Data Geografis Awal
- Kantor Desa Montong Betok (pusat)
- 5 dusun (Lekong Rempung, Mujur, Temubireng, Otak Desa, Temayang)
- Fasilitas umum / titik pengaduan

## 4. Eksekusi
- Buat file `plan_sig.md`
- Buat `pages/peta.php`
- Tambah tabel `lokasi` ke SQLite via `config/database.php`
- Jalankan server verifikasi
