# MASTER PROMPT

# SISTEM INFORMASI DESA — CMS + ADMINISTRASI SURAT DIGITAL

## 1. PERAN

Bertindak sebagai:

* Senior Full-Stack Developer
* System Architect
* UI/UX Designer
* Database Engineer
* CMS Developer
* PDF Document Engineer
* Security Engineer
* QA Engineer

Bangun sebuah **Sistem Informasi Desa modern berbasis CMS** yang memiliki dua bagian utama:

1. WEBSITE PUBLIK DESA
2. ADMIN DASHBOARD / CMS + ADMINISTRASI SURAT

Sistem harus benar-benar dinamis.

PRINSIP UTAMA:

> **APA YANG DIATUR DAN DIPUBLISH DARI CMS, ITULAH YANG DITAMPILKAN PADA WEBSITE PUBLIK.**

Jangan membuat konten website secara hardcoded.

---

# 2. TUJUAN SISTEM

Sistem digunakan untuk:

* website resmi desa;
* pengelolaan informasi desa;
* pengelolaan berita;
* pengelolaan profil desa;
* pengelolaan perangkat desa;
* pengelolaan data penduduk;
* pengelolaan statistik;
* pengelolaan agenda;
* pengelolaan galeri;
* pengelolaan dokumen;
* pengelolaan potensi desa;
* pengelolaan layanan;
* pembuatan surat;
* pembuatan PDF;
* tanda tangan surat;
* arsip surat;
* pencarian surat;
* tracking nomor surat;
* manajemen pengguna.

---

# 3. ARSITEKTUR SISTEM

Gunakan arsitektur:

                    WEBSITE PUBLIK
                           │
                           ▼
                    NEXT.JS FRONTEND
                           │
                           ▼
                    API / SERVER ACTION
                           │
                           ▼
                    APPLICATION LOGIC
                           │
            ┌──────────────┴──────────────┐
            ▼                             ▼
       CMS CONTENT                  ADMINISTRASI DESA
            │                             │
            ▼                             ▼
        DATABASE                  DATA PENDUDUK
                                          │
                                          ▼
                                   SISTEM SURAT
                                          │
                                          ▼
                                   PDF GENERATOR
                                          │
                                          ▼
                              SIGNATURE / TANDA TANGAN
                                          │
                                          ▼
                                    ARSIP SURAT
```

---

# 4. TECH STACK

Gunakan:

### Frontend

* Next.js
* React
* TypeScript
* Tailwind CSS

### UI

* shadcn/ui
* Lucide Icons
* Framer Motion jika diperlukan

### Backend

* Next.js Server Actions / Route Handlers
* TypeScript

### Database

* PostgreSQL
* Prisma ORM

### Authentication

* Auth.js / NextAuth

### PDF

Gunakan library PDF yang stabil dan cocok untuk server-side rendering.

Prioritaskan:

* PDF yang layout-nya konsisten;
* hasil PDF siap cetak;
* font dapat dikontrol;
* dukungan gambar/signature;
* page break;
* header/footer.

---

# 5. CMS

CMS harus menjadi pusat pengelolaan website.

Admin dapat mengontrol:

* homepage;
* navbar;
* footer;
* profil;
* berita;
* agenda;
* galeri;
* dokumen;
* perangkat desa;
* statistik;
* potensi;
* layanan;
* kontak;
* social media;
* banner;
* pengumuman.

Tidak boleh hardcode.

---

# 6. SISTEM "WHAT YOU SEE IS WHAT YOU GET"

Terapkan konsep:

> **WHAT YOU SEE IS WHAT YOU GET**

Contoh:

Admin membuat berita:

```text
Judul:
Musyawarah Desa

Status:
Published

Tampilkan di homepage:
YES
```

Maka otomatis website:

```text
Homepage
└── Berita
    └── Musyawarah Desa
```

Jika:

```text
Tampilkan di homepage:
NO
```

berita tidak tampil di homepage.

---

# 7. CMS HOMEPAGE BUILDER

Admin dapat mengatur section homepage.

Minimal section:

* Hero
* Sambutan Kepala Desa
* Statistik
* Berita
* Agenda
* Potensi Desa
* Galeri
* Pengumuman
* CTA
* Footer.

Setiap section memiliki:

```text
enabled
title
subtitle
order
layout
visibility
```

Admin dapat:

* aktifkan;
* nonaktifkan;
* mengubah urutan;
* mengubah judul;
* mengubah isi;
* mengubah gambar.

Gunakan sistem ordering.

Contoh:

```text
1 Hero
2 Sambutan
3 Statistik
4 Berita
5 Agenda
6 Potensi
7 Galeri
```

---

# 8. ADMIN DASHBOARD

Dashboard harus modern dan profesional.

Sidebar:

```text
Dashboard

WEBSITE
├── Beranda
├── Profil Desa
├── Berita
├── Agenda
├── Galeri
├── Potensi Desa
├── Dokumen
├── Layanan
└── Pengaturan Website

DATA DESA
├── Penduduk
├── Kartu Keluarga
├── Perangkat Desa
├── Statistik
└── Wilayah

ADMINISTRASI
├── Buat Surat
├── Template Surat
├── Surat Masuk
├── Surat Keluar
├── Arsip Surat
└── Nomor Surat

SISTEM
├── Pengguna
├── Role & Permission
├── Activity Log
└── Settings
```

---

# 9. DATA PENDUDUK

Buat database penduduk.

Data minimal:

```text
NIK
No KK
Nama
Tempat Lahir
Tanggal Lahir
Jenis Kelamin
Alamat
Dusun
RT
RW
Agama
Status Perkawinan
Pekerjaan
Pendidikan
Kewarganegaraan
Nomor HP
Status Penduduk
```

Status:

```text
AKTIF
PINDAH
MENINGGAL
```

---

# 10. PENCARIAN PENDUDUK

Admin dapat mencari berdasarkan:

* NIK;
* nama;
* nomor KK;
* alamat;
* dusun;
* RT;
* RW.

Gunakan autocomplete/search.

Ketika penduduk dipilih:

```text
NIK → otomatis terisi
Nama → otomatis terisi
Alamat → otomatis terisi
Tempat/Tanggal Lahir → otomatis terisi
```

---

# 11. SISTEM SURAT DIGITAL

Ini adalah fitur utama sistem.

Admin dapat membuat surat dari:

```text
Administrasi
→ Buat Surat
```

Kemudian:

```text
Pilih Jenis Surat
↓
Pilih Penduduk
↓
Data otomatis terisi
↓
Isi data tambahan
↓
Preview surat
↓
Pilih pejabat penandatangan
↓
Signature
↓
Generate PDF
↓
Simpan Arsip
```

---

# 12. TEMPLATE SURAT

Buat sistem template surat yang dapat dibuat admin.

Admin dapat:

* membuat template;
* mengedit template;
* menduplikasi template;
* mengaktifkan/nonaktifkan;
* menghapus template;
* menentukan jenis surat.

Contoh:

```text
Surat Keterangan Domisili
Surat Keterangan Usaha
Surat Keterangan Tidak Mampu
Surat Keterangan Pengantar
Surat Keterangan Kelahiran
Surat Keterangan Kematian
Surat Keterangan Pindah
Surat Keterangan Belum Menikah
Surat Keterangan Penghasilan
Surat Undangan
Surat Permohonan
Surat lainnya.
```

Jangan membatasi sistem hanya pada daftar tersebut.

Admin harus bisa membuat jenis surat baru.

---

# 13. CUSTOM SURAT BUILDER

Buat **Custom Letter Builder**.

Admin dapat membuat template surat menggunakan editor.

Template mendukung:

```text
Text
Heading
Paragraph
Table
Image
Logo
Signature
Divider
Space
Numbering
```

Dan variable dinamis.

Contoh:

```text
{{NIK}}
{{NAMA}}
{{TEMPAT_LAHIR}}
{{TANGGAL_LAHIR}}
{{ALAMAT}}
{{DUSUN}}
{{RT}}
{{RW}}
{{PEKERJAAN}}
{{STATUS_PERKAWINAN}}
```

Data surat:

```text
{{NOMOR_SURAT}}
{{TANGGAL_SURAT}}
{{KEPERLUAN}}
{{KETERANGAN}}
```

Data desa:

```text
{{NAMA_DESA}}
{{KECAMATAN}}
{{KABUPATEN}}
{{PROVINSI}}
{{ALAMAT_DESA}}
```

Data pejabat:

```text
{{NAMA_KEPALA_DESA}}
{{JABATAN}}
{{NIP}}
```

---

# 14. VARIABLE SYSTEM

Buat variable manager.

Contoh:

```text
Penduduk

{{NIK}}
{{NAMA}}
{{TTL}}
{{ALAMAT}}
{{PEKERJAAN}}

Surat

{{NOMOR_SURAT}}
{{TANGGAL_SURAT}}
{{PERIHAL}}

Desa

{{NAMA_DESA}}
{{KECAMATAN}}
{{KABUPATEN}}

Pejabat

{{NAMA_PEJABAT}}
{{JABATAN}}
```

Admin dapat melihat daftar variable yang tersedia.

Klik variable:

```text
{{NAMA}}
```

otomatis dimasukkan ke editor.

---

# 15. FORM SURAT DINAMIS

Template dapat menentukan field tambahan.

Misalnya Surat Keterangan Usaha membutuhkan:

```text
Nama Usaha
Jenis Usaha
Alamat Usaha
Lama Usaha
```

Maka template memiliki custom fields:

```text
nama_usaha
jenis_usaha
alamat_usaha
lama_usaha
```

Ketika surat dibuat, form otomatis menghasilkan field tersebut.

Jangan membuat form berbeda secara hardcode untuk setiap surat.

---

# 16. PREVIEW SURAT

Setelah form diisi:

```text
PREVIEW
```

Admin dapat melihat surat sebelum dibuat PDF.

Preview harus semirip mungkin dengan PDF final.

Layout:

```text
┌────────────────────────────────────┐
│              LOGO                  │
│         PEMERINTAH DESA            │
│         DESA MONTONG BETOK         │
│────────────────────────────────────│
│                                    │
│       SURAT KETERANGAN             │
│       Nomor: xxx/xxx/xxx           │
│                                    │
│ Isi surat...                       │
│                                    │
│                                    │
│                         Kepala Desa│
│                         [SIGNATURE]│
└────────────────────────────────────┘
```

---

# 17. PDF GENERATOR

Setelah preview disetujui:

```text
Generate PDF
```

Sistem membuat PDF final.

PDF harus:

* A4;
* margin configurable;
* font configurable;
* header;
* footer;
* nomor surat;
* isi;
* signature;
* logo;
* tanda tangan;
* page numbering jika diperlukan.

File:

```text
surat-2026-001.pdf
```

Simpan ke storage.

---

# 18. SIGNATURE / TANDA TANGAN

Implementasikan sistem tanda tangan.

Admin dapat mengelola signature pejabat.

Data:

```text
Nama
Jabatan
Signature Image
Status
```

Signature disimpan secara aman.

Saat membuat surat:

```text
Penandatangan:
[ Kepala Desa ▼ ]
```

Sistem otomatis mengambil:

```text
Nama
Jabatan
Signature
```

dan menempatkannya pada posisi yang ditentukan template.

---

# 19. SIGNATURE POSITION

Template surat harus dapat menentukan:

```text
signature position
signature width
signature height
signature alignment
```

Contoh:

```text
RIGHT
CENTER
LEFT
```

Dengan koordinat/layout yang dapat disesuaikan.

---

# 20. SIGNATURE SECURITY

Jangan menganggap gambar tanda tangan saja sebagai "tanda tangan elektronik tersertifikasi".

Sistem harus membedakan:

```text
SIGNATURE IMAGE
```

dan

```text
ELECTRONIC SIGNATURE
```

Jika implementasi menggunakan signature image:

beri label internal:

```text
Tanda tangan digital internal
```

Jika nantinya membutuhkan tanda tangan elektronik tersertifikasi, arsitektur harus dapat diintegrasikan dengan penyedia layanan TTE yang sesuai regulasi Indonesia.

---

# 21. NOMOR SURAT OTOMATIS

Buat sistem penomoran.

Contoh:

```text
001/DS-MB/X/2026
002/DS-MB/X/2026
003/DS-MB/X/2026
```

Format dapat dikonfigurasi admin.

Variable:

```text
{NO}
{KODE}
{BULAN}
{TAHUN}
```

Contoh template:

```text
{NO}/SK/{BULAN_ROMAWI}/{TAHUN}
```

Nomor harus aman dari duplicate.

Gunakan database transaction.

---

# 22. ARSIP SURAT

Setiap surat yang dibuat otomatis masuk arsip.

Data:

```text
ID
Nomor Surat
Jenis Surat
Pemohon
NIK
Tanggal
Penandatangan
Status
PDF
CreatedBy
CreatedAt
```

Status:

```text
DRAFT
GENERATED
SIGNED
ARCHIVED
CANCELLED
```

---

# 23. SEARCH ARSIP

Admin dapat mencari:

* nomor surat;
* NIK;
* nama;
* jenis surat;
* tanggal;
* penandatangan;
* status.

Tambahkan:

* filter;
* pagination;
* sorting;
* export.

---

# 24. SURAT MASUK

Jika diperlukan, buat modul:

```text
Surat Masuk
```

Field:

```text
Nomor
Tanggal
Pengirim
Perihal
File
Disposisi
Status
```

---

# 25. SURAT KELUAR

Modul:

```text
Surat Keluar
```

Surat yang dibuat sistem otomatis dapat masuk ke surat keluar.

---

# 26. ROLE SYSTEM

Minimal:

### SUPER ADMIN

Full access.

### ADMIN DESA

Mengelola CMS dan administrasi.

### OPERATOR

Mengelola penduduk dan surat.

### KEPALA DESA

Melihat dan menyetujui surat.

### STAFF

Access terbatas.

Gunakan RBAC.

---

# 27. APPROVAL SURAT

Jika diperlukan:

```text
DRAFT
↓
DIPERIKSA
↓
DISETUJUI
↓
DITANDATANGANI
↓
FINAL
```

Kepala Desa dapat melakukan approval.

Jangan memungkinkan operator mengubah surat yang sudah final tanpa membuat versi baru.

---

# 28. VERSIONING

Surat harus memiliki version.

Contoh:

```text
Surat #001
Version 1
Version 2
Version 3
```

Jika surat final diedit:

buat versi baru.

Jangan overwrite dokumen final tanpa jejak.

---

# 29. AUDIT LOG

Catat aktivitas:

```text
User
Action
Module
Record
Timestamp
IP
```

Contoh:

```text
Operator
CREATE
SURAT
001/SK/X/2026
2026-10-05 09:00
```

---

# 30. WEBSITE PUBLIK

Website publik tetap mengikuti desain website referensi Desa Montong Betok.

Tetapi semua konten mengambil data CMS.

Minimal:

```text
Home
Profil Desa
Pemerintahan
Berita
Agenda
Potensi
Statistik
Galeri
Dokumen
Layanan
Kontak
```

Sesuaikan dengan hasil analisis website referensi.

---

# 31. HUBUNGAN CMS DAN WEBSITE

Jangan membuat:

```text
Admin → input data → copy paste ke website
```

Harus:

```text
Admin
 ↓
Database
 ↓
Website membaca database
 ↓
Data langsung tampil
```

Contoh:

Admin mengubah:

```text
Nama Kepala Desa
```

maka:

```text
Homepage
Profil
Pemerintahan
Footer
Surat
```

yang menggunakan variable tersebut harus otomatis mendapatkan data terbaru.

---

# 32. GLOBAL VILLAGE SETTINGS

Buat:

```text
Village Settings
```

Data:

```text
Nama Desa
Logo
Alamat
Kecamatan
Kabupaten
Provinsi
Kode Pos
Telepon
WhatsApp
Email
Website
Latitude
Longitude
Nama Kepala Desa
NIP
Signature Kepala Desa
```

Gunakan data ini secara global.

---

# 33. GLOBAL LETTERHEAD

Buat pengaturan kop surat:

```text
Logo
Nama Pemerintah
Nama Desa
Kecamatan
Kabupaten
Provinsi
Alamat
Kode Pos
Telepon
Email
Website
```

Admin dapat mengatur apakah kop:

```text
Aktif
Tidak Aktif
```

---

# 34. DATABASE UTAMA

Gunakan Prisma.

Minimal model:

```text
User
Role
Permission

VillageSetting
VillageOfficial

Resident
Family

News
NewsCategory
Agenda
Gallery
Document
VillagePotential
VillageService
HomepageSection

LetterTemplate
LetterField
Letter
LetterVariable
Signature

IncomingMail
OutgoingMail

NumberSequence
AuditLog
```

Tambahkan relasi dan indexing yang sesuai.

---

# 35. DATA PRIVACY

Data penduduk adalah data sensitif.

Jangan tampilkan data penduduk pada website publik.

Website publik hanya boleh menampilkan data agregat/statistik yang memang diperbolehkan.

Data seperti:

```text
NIK
Nomor KK
Alamat lengkap
Nomor HP
```

hanya dapat diakses oleh role yang berwenang.

---

# 36. SECURITY

Implementasikan:

* RBAC
* password hashing
* secure session
* validation
* server-side authorization
* rate limiting
* secure file upload
* file type validation
* file size validation
* audit logging
* CSRF protection jika diperlukan
* secure headers
* environment variables.

Jangan hardcode credential.

---

# 37. FILE STORAGE

Pisahkan:

```text
/public
```

untuk aset publik.

Dan private storage:

```text
/storage/private
```

untuk:

* surat;
* data penduduk;
* signature;
* dokumen internal.

Dokumen privat tidak boleh dapat diakses langsung hanya dengan mengetahui URL.

---

# 38. UI SURAT

Buat workflow yang sederhana.

Contoh:

```text
┌─────────────────────────────────────────┐
│ BUAT SURAT                              │
├─────────────────────────────────────────┤
│ Jenis Surat                             │
│ [ Surat Keterangan Usaha ▼ ]            │
│                                         │
│ Penduduk                                │
│ [ Cari NIK / Nama................ ]     │
│                                         │
│ Nama                                     │
│ [ otomatis ]                            │
│                                         │
│ NIK                                      │
│ [ otomatis ]                            │
│                                         │
│ Data Tambahan                           │
│ Nama Usaha                              │
│ [..............................]         │
│                                         │
│ Penandatangan                            │
│ [ Kepala Desa ▼ ]                       │
│                                         │
│ [ SIMPAN DRAFT ] [ PREVIEW ]            │
└─────────────────────────────────────────┘
```

---

# 39. PREVIEW + PDF

Gunakan split-screen jika memungkinkan:

```text
┌──────────── FORM ────────────┬──── PREVIEW ────────┐
│                              │                     │
│ Jenis Surat                  │    KOP SURAT        │
│ Penduduk                     │                     │
│ Data                         │    Isi surat...     │
│                              │                     │
│                              │             SIGN    │
│ [Preview]                    │                     │
└──────────────────────────────┴─────────────────────┘
```

Setiap perubahan form harus memperbarui preview.

---

# 40. CMS EDITOR

Untuk content editor gunakan rich text editor modern.

Mendukung:

* bold;
* italic;
* heading;
* list;
* link;
* image;
* table;
* alignment.

Untuk surat, gunakan editor/template khusus yang mampu menghasilkan PDF konsisten.

---

# 41. RESPONSIVE

Admin dashboard:

* desktop;
* tablet;
* mobile.

Website:

* 320px;
* 375px;
* 390px;
* 414px;
* 768px;
* 1024px;
* 1280px;
* 1440px;
* 1920px.

Tidak boleh horizontal overflow.

---

# 42. SEO

Website publik:

* metadata;
* Open Graph;
* sitemap;
* robots;
* schema;
* canonical;
* optimized images.

Admin dashboard tidak perlu di-index.

Gunakan:

```text
noindex
```

untuk halaman admin.

---

# 43. PERFORMANCE

Gunakan:

* Next.js server rendering;
* caching;
* optimized image;
* lazy loading;
* pagination;
* database indexing;
* query optimization.

Jangan mengambil seluruh data database jika hanya membutuhkan 10 record.

---

# 44. TESTING

Test:

### CMS

* create;
* edit;
* delete;
* publish;
* draft;
* reorder;
* visibility.

### Penduduk

* create;
* edit;
* search;
* filter.

### Surat

* create;
* template;
* dynamic variable;
* preview;
* PDF;
* signature;
* numbering;
* archive.

### Security

* RBAC;
* unauthorized access;
* file access;
* authentication.

### PDF

Periksa:

* margin;
* font;
* logo;
* alignment;
* signature;
* page break;
* nomor surat.

---

# 45. FINAL PRINCIPLE

Sistem ini bukan sekadar:

> "Website Desa"

tetapi:

> **CMS WEBSITE DESA + DATA MANAGEMENT + ADMINISTRASI SURAT DIGITAL + PDF GENERATOR + SIGNATURE + ARSIP**

Semua harus terintegrasi.

Alur utama:

```text
CMS
 ↓
DATABASE
 ↓
WEBSITE PUBLIK
```

dan:

```text
DATA PENDUDUK
 ↓
TEMPLATE SURAT
 ↓
FORM DINAMIS
 ↓
PREVIEW
 ↓
SIGNATURE
 ↓
PDF
 ↓
ARSIP SURAT
```

---

# 46. DEFINITION OF DONE

Project hanya dianggap selesai jika:

[ ] Website publik berjalan
[ ] CMS berjalan
[ ] Admin dashboard berjalan
[ ] Login berjalan
[ ] RBAC berjalan
[ ] Data penduduk berjalan
[ ] Search penduduk berjalan
[ ] Template surat berjalan
[ ] Custom letter builder berjalan
[ ] Dynamic variable berjalan
[ ] Form surat dinamis berjalan
[ ] Preview surat berjalan
[ ] PDF generator berjalan
[ ] Signature berjalan
[ ] Nomor surat otomatis berjalan
[ ] Arsip surat berjalan
[ ] Search arsip berjalan
[ ] Audit log berjalan
[ ] Website mengambil data CMS
[ ] Tidak ada hardcoded content utama
[ ] Responsive
[ ] SEO
[ ] Security
[ ] PDF hasil cetak benar
[ ] npm run lint berhasil
[ ] npm run build berhasil
[ ] Tidak ada console error

---

# 47. CARA BEKERJA

Jangan langsung membuat seluruh sistem sekaligus.

Kerjakan secara bertahap:

### PHASE 1

Audit website referensi.

### PHASE 2

Buat architecture.

### PHASE 3

Buat database schema.

### PHASE 4

Buat authentication + RBAC.

### PHASE 5

Buat CMS.

### PHASE 6

Buat website publik.

### PHASE 7

Buat data penduduk.

### PHASE 8

Buat template surat.

### PHASE 9

Buat custom letter builder.

### PHASE 10

Buat PDF generator.

### PHASE 11

Buat signature.

### PHASE 12

Buat arsip surat.

### PHASE 13

Buat audit log.

### PHASE 14

Testing.

### PHASE 15

Visual QA dan production build.

Jangan lanjut ke phase berikutnya jika fondasi phase sebelumnya rusak.

---

# 48. HASIL AKHIR

Hasil akhir harus terasa seperti:

**Website resmi Desa + CMS profesional + Sistem Administrasi Desa.**

Admin tidak perlu mengubah source code untuk mengubah konten.

Admin cukup masuk:

```text
/admin
```

kemudian:

```text
Edit → Save → Publish
```

dan website publik langsung menggunakan data terbaru.

Untuk surat:

```text
/admin/surat
```

kemudian:

```text
Pilih template
→ pilih penduduk
→ isi data
→ preview
→ pilih penandatangan
→ generate PDF
→ signature
→ simpan
```

Semua surat tersimpan sebagai arsip dan dapat dicari kembali.

Mulai implementasi dari **PHASE 1 — ANALISIS WEBSITE REFERENSI**, kemudian lanjutkan secara sistematis sampai project dapat dijalankan dan production build berhasil.
