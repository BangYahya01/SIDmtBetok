-- SQL Schema & Data Dump untuk MySQL (phpMyAdmin XAMPP)
-- Database: db_montong_betok
-- Referensi: https://desamb.id/

CREATE DATABASE IF NOT EXISTS `db_montong_betok` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_montong_betok`;

-- 1. Tabel Berita
CREATE TABLE IF NOT EXISTS `berita` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `judul` VARCHAR(255) NOT NULL,
    `slug` VARCHAR(255) NOT NULL,
    `kategori` VARCHAR(100) NOT NULL,
    `ringkasan` TEXT,
    `isi` LONGTEXT NOT NULL,
    `gambar` VARCHAR(500),
    `penulis` VARCHAR(100) DEFAULT 'Administrator',
    `tanggal` DATE DEFAULT (CURRENT_DATE),
    `dilihat` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Tabel Aparatur Desa
CREATE TABLE IF NOT EXISTS `aparatur` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(150) NOT NULL,
    `jabatan` VARCHAR(150) NOT NULL,
    `foto` VARCHAR(500),
    `status_kehadiran` VARCHAR(50) DEFAULT 'Hadir',
    `urutan` INT DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Tabel Permohonan Surat Online
CREATE TABLE IF NOT EXISTS `permohonan_surat` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `no_resi` VARCHAR(50) UNIQUE NOT NULL,
    `nik` VARCHAR(20) NOT NULL,
    `nama` VARCHAR(150) NOT NULL,
    `dusun` VARCHAR(100) NOT NULL,
    `no_hp` VARCHAR(25) NOT NULL,
    `jenis_surat` VARCHAR(150) NOT NULL,
    `keperluan` TEXT,
    `status` VARCHAR(50) DEFAULT 'Menunggu Verifikasi',
    `keterangan_admin` TEXT,
    `tanggal_pengajuan` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 4. Tabel Pengaduan Warga
CREATE TABLE IF NOT EXISTS `pengaduan` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nama` VARCHAR(150) NOT NULL,
    `dusun` VARCHAR(100) NOT NULL,
    `judul` VARCHAR(255) NOT NULL,
    `isi` TEXT NOT NULL,
    `status` VARCHAR(50) DEFAULT 'Diterima',
    `tanggapan` TEXT,
    `tanggal` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 5. Tabel Admin
CREATE TABLE IF NOT EXISTS `admin_users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `nama` VARCHAR(100) NOT NULL,
    `role` VARCHAR(50) DEFAULT 'Admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 6. Tabel APBD
CREATE TABLE IF NOT EXISTS `apbd` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tahun` INT NOT NULL,
    `jenis` VARCHAR(50) NOT NULL,
    `rincian` VARCHAR(255) NOT NULL,
    `anggaran` DOUBLE NOT NULL,
    `realisasi` DOUBLE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Admin default (admin / admin123)
INSERT INTO `admin_users` (`username`, `password`, `nama`, `role`) VALUES 
('admin', '$2y$10$wN92Xh187vT9u248qWlhxe9m9zY62vR8Q9Qd.h.5c95P5eJ9j0nWW', 'Operator Desa Montong Betok', 'Administrator')
ON DUPLICATE KEY UPDATE `username`=`username`;
