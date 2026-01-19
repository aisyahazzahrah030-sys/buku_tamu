CREATE DATABASE IF NOT EXISTS buku_tamu_diskominfo;

USE buku_tamu_diskominfo;

-- Tabel untuk admin
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk buku tamu
CREATE TABLE IF NOT EXISTS buku_tamu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_lengkap VARCHAR(100) NOT NULL,
    nomor_hp VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    instansi VARCHAR(100) NOT NULL,
    kategori_tamu ENUM('opd-padang', 'pemerintah-lain', 'mahasiswa-akademisi', 'perusahaan-vendor', 'masyarakat-umum') NOT NULL,
    jenis_layanan ENUM('pengembangan-aplikasi', 'integrasi-sistem', 'website-opd', 'data-statistik', 'keamanan-informasi', 'konsultasi-layanan-digital') NOT NULL,
    keperluan TEXT NOT NULL,
    sistem_terkait VARCHAR(100),
    pegawai_dituju VARCHAR(100),
    tanggal_kunjungan DATE NOT NULL,
    jam_kunjungan TIME NOT NULL,
    foto_tamu VARCHAR(255),
    persetujuan BOOLEAN NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert admin default (password: admin123)
INSERT INTO admin (username, password, nama_lengkap) VALUES 
('admin', 'admin123', 'Administrator Diskominfo');

-- Buat direktori untuk foto tamu
-- Anda perlu membuat folder 'uploads/foto_tamu' di root project