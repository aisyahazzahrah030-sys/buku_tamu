<?php
// Database setup script
echo "<h1>🔧 Database Setup</h1>";

// Connection parameters
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'buku_tamu_diskominfo';

echo "<h2>📊 Step 1: Testing Connection</h2>";

// Test connection to MySQL server
$conn = new mysqli($host, $user, $pass);

if ($conn->connect_error) {
    echo "<p style='color:red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
    echo "<h3>❌ ERROR: Tidak bisa connect ke MySQL</h3>";
    echo "<p>Pastikan:</p>";
    echo "<ul>";
    echo "<li>XAMPP MySQL sudah running</li>";
    echo "<li>Port 3306 tidak bentrok</li>";
    echo "<li>Username/password MySQL benar</li>";
    echo "</ul>";
    exit;
}

echo "<p style='color:green;'>✅ Connected to MySQL server successfully</p>";

// Create database if not exists
echo "<h2>📦 Step 2: Creating Database</h2>";
$sql = "CREATE DATABASE IF NOT EXISTS $db_name CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✅ Database '$db_name' created/exists</p>";
} else {
    echo "<p style='color:red;'>❌ Error creating database: " . $conn->error . "</p>";
    exit;
}

// Select database
$conn->select_db($db_name);

// Create admin table
echo "<h2>👤 Step 3: Creating Admin Table</h2>";
$sql = "CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✅ Admin table created/exists</p>";
} else {
    echo "<p style='color:red;'>❌ Error creating admin table: " . $conn->error . "</p>";
}

// Create buku tamu table
echo "<h2>📋 Step 4: Creating Buku Tamu Table</h2>";
$sql = "CREATE TABLE IF NOT EXISTS buku_tamu (
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
)";

if ($conn->query($sql) === TRUE) {
    echo "<p style='color:green;'>✅ Buku tamu table created/exists</p>";
} else {
    echo "<p style='color:red;'>❌ Error creating buku tamu table: " . $conn->error . "</p>";
}

// Insert default admin if not exists
echo "<h2>🔐 Step 5: Creating Default Admin</h2>";
$sql = "SELECT COUNT(*) as count FROM admin WHERE username = 'admin'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $sql = "INSERT INTO admin (username, password, nama_lengkap) VALUES ('admin', '$hashed_password', 'Administrator Diskominfo')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>✅ Default admin created: admin / admin123</p>";
    } else {
        echo "<p style='color:red;'>❌ Error creating admin: " . $conn->error . "</p>";
    }
} else {
    echo "<p style='color:green;'>✅ Default admin already exists</p>";
}

echo "<h2>🎉 Step 6: Verification</h2>";

// Verify tables
$tables = ['admin', 'buku_tamu'];
foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "<p style='color:green;'>✅ Table '$table' exists</p>";
    } else {
        echo "<p style='color:red;'>❌ Table '$table' missing</p>";
    }
}

$conn->close();

echo "<h2>🚀 Setup Complete!</h2>";
echo "<p style='color:green;font-size:18px;'>✅ Database setup selesai!</p>";
echo "<p>Sekarang anda bisa login ke:</p>";
echo "<ul>";
echo "<li><a href='admin/login.php' style='color:blue;'>Admin Login: admin / admin123</a></li>";
echo "<li><a href='index.php' style='color:blue;'>Form Buku Tamu</a></li>";
echo "</ul>";
echo "<p><strong>Catatan:</strong> Hapus file setup.php setelah setup selesai!</p>";
?>