<?php
echo "<h1>🔧 Setup Database</h1>";

// Connect ke MySQL
$conn = new mysqli('localhost', 'root', '');

if ($conn->connect_error) {
    die("<p style='color:red;'>❌ Tidak bisa connect ke MySQL: " . $conn->connect_error . "</p>");
}

// Create database
$conn->query("CREATE DATABASE IF NOT EXISTS buku_tamu_diskominfo");
$conn->select_db("buku_tamu_diskominfo");

// Create admin table
$conn->query("CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Create buku tamu table
$conn->query("CREATE TABLE IF NOT EXISTS buku_tamu (
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
)");

// Create admin if not exists
$check = $conn->query("SELECT COUNT(*) as count FROM admin WHERE username = 'admin'");
$row = $check->fetch_assoc();

if ($row['count'] == 0) {
    $password = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->query("INSERT INTO admin (username, password, nama_lengkap) VALUES ('admin', '$password', 'Administrator Diskominfo')");
    echo "<p style='color:green;'>✅ Admin created: admin / admin123</p>";
} else {
    echo "<p style='color:green;'>✅ Admin already exists</p>";
}

// Insert sample data
$sample_data = [
    ["Budi Santoso", "628123456789", "budi@email.com", "Dinas Kominfo Padang", "opd-padang", "pengembangan-aplikasi", "Konsultasi aplikasi pelayanan publik", "Website OPD", "Tim Programmer", date('Y-m-d'), date('H:i:s')],
    ["Andi Wijaya", "628987654321", "andi@unp.ac.id", "Universitas Negeri Padang", "mahasiswa-akademisi", "konsultasi-layanan-digital", "Riset e-government", null, "Kepala Bidang", date('Y-m-d', strtotime('-1 day')), "10:30:00"],
    ["Ahmad Fauzi", "628223344556", "ahmad@vendor.com", "PT Teknologi Indonesia", "perusahaan-vendor", "integrasi-sistem", "Demo sistem pembayaran", "SIMPEG, SIPD", "Tim Integrasi", date('Y-m-d', strtotime('-2 days')), "14:00:00"]
];

foreach ($sample_data as $data) {
    $stmt = $conn->prepare("INSERT INTO buku_tamu (nama_lengkap, nomor_hp, email, instansi, kategori_tamu, jenis_layanan, keperluan, sistem_terkait, pegawai_dituju, tanggal_kunjungan, jam_kunjungan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $data[0], $data[1], $data[2], $data[3], $data[4], $data[5], $data[6], $data[7], $data[8], $data[9], $data[10]);
    $stmt->execute();
    $stmt->close();
}

echo "<p style='color:green;'>✅ Sample data inserted</p>";

// Count data
$count = $conn->query("SELECT COUNT(*) as total FROM buku_tamu")->fetch_assoc()['total'];
echo "<p style='color:blue;'>📊 Total data buku tamu: $count</p>";

$conn->close();

echo "<h2>🚀 Setup Complete!</h2>";
echo "<p><a href='admin/login.php' style='color:blue;font-size:18px;'>🔐 Login Admin (admin/admin123)</a></p>";
echo "<p><a href='index.php' style='color:blue;font-size:18px;'>📝 Form Buku Tamu</a></p>";
?>