<?php
// Insert sample data for dashboard
echo "<h1>📊 Insert Sample Data</h1>";

// Connection parameters
$host = 'localhost';
$user = 'root';
$pass = '';
$db_name = 'buku_tamu_diskominfo';

// Connect to database
$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    echo "<p style='color:red;'>❌ Connection failed: " . $conn->connect_error . "</p>";
    exit;
}

echo "<h2>📋 Menambahkan Data Sample Buku Tamu</h2>";

$sample_data = [
    [
        'nama_lengkap' => 'Budi Santoso',
        'nomor_hp' => '628123456789',
        'email' => 'budi.santoso@diskominfo.padang.go.id',
        'instansi' => 'Dinas Komunikasi dan Informatika Kota Padang',
        'kategori_tamu' => 'opd-padang',
        'jenis_layanan' => 'pengembangan-aplikasi',
        'keperluan' => 'Konsultasi pengembangan aplikasi pelayanan publik berbasis web untuk peningkatan layanan masyarakat',
        'sistem_terkait' => 'Website OPD, E-Government Portal',
        'pegawai_dituju' => 'Tim Programmer e-Government',
        'tanggal_kunjungan' => date('Y-m-d'),
        'jam_kunjungan' => date('H:i:s'),
        'persetujuan' => 1
    ],
    [
        'nama_lengkap' => 'Dr. Andi Wijaya, M.Kom',
        'nomor_hp' => '628987654321',
        'email' => 'andi.wijaya@unp.ac.id',
        'instansi' => 'Universitas Negeri Padang',
        'kategori_tamu' => 'mahasiswa-akademisi',
        'jenis_layanan' => 'konsultasi-layanan-digital',
        'keperluan' => 'Riset kolaborasi tentang implementasi e-government di Kota Padang untuk penelitian tesis doctoral',
        'sistem_terkait' => null,
        'pegawai_dituju' => 'Kepala Bidang e-Government',
        'tanggal_kunjungan' => date('Y-m-d', strtotime('-1 day')),
        'jam_kunjungan' => '10:30:00',
        'persetujuan' => 1
    ],
    [
        'nama_lengkap' => 'Ahmad Fauzi',
        'nomor_hp' => '628223344556',
        'email' => 'ahmad.fauzi@teknologi-indonesia.co.id',
        'instansi' => 'PT Teknologi Indonesia Maju',
        'kategori_tamu' => 'perusahaan-vendor',
        'jenis_layanan' => 'integrasi-sistem',
        'keperluan' => 'Presentasi dan demo solusi integrasi sistem pembayaran digital untuk meningkatkan PAD (Pendapatan Asli Daerah)',
        'sistem_terkait' => 'SIMPEG, SIPD, e-Pajak',
        'pegawai_dituju' => 'Tim Integrasi Sistem',
        'tanggal_kunjungan' => date('Y-m-d', strtotime('-2 days')),
        'jam_kunjungan' => '14:00:00',
        'persetujuan' => 1
    ],
    [
        'nama_lengkap' => 'Siti Nurhaliza',
        'nomor_hp' => '628556677889',
        'email' => 'siti.nurhaliza@sumbarprov.go.id',
        'instansi' => 'Pemerintah Provinsi Sumatera Barat',
        'kategori_tamu' => 'pemerintah-lain',
        'jenis_layanan' => 'data-statistik',
        'keperluan' => 'Konsultasi dan sharing data statistik kunjungan wisata ke Padang untuk integrasi sistem monitoring pariwisata provinsi',
        'sistem_terkait' => 'Sistem Data Statistik',
        'pegawai_dituju' => 'Kepala Seksi Data dan Statistik',
        'tanggal_kunjungan' => date('Y-m-d', strtotime('-3 days')),
        'jam_kunjungan' => '09:00:00',
        'persetujuan' => 1
    ],
    [
        'nama_lengkap' => 'Rudi Hermawan',
        'nomor_hp' => '628889990011',
        'email' => null,
        'instansi' => 'Masyarakat Umum',
        'kategori_tamu' => 'masyarakat-umum',
        'jenis_layanan' => 'website-opd',
        'keperluan' => 'Mengurus pembuatan website untuk UMKM binaan di Kecamatan Padang Utara',
        'sistem_terkait' => null,
        'pegawai_dituju' => 'Tim Web Development',
        'tanggal_kunjungan' => date('Y-m-d', strtotime('-4 days')),
        'jam_kunjungan' => '11:15:00',
        'persetujuan' => 1
    ],
    [
        'nama_lengkap' => 'Ir. Diana Pratiwi',
        'nomor_hp' => '628776655443',
        'email' => 'diana.pratiwi@cybersecurity.co.id',
        'instansi' => 'PT Cyber Security Indonesia',
        'kategori_tamu' => 'perusahaan-vendor',
        'jenis_layanan' => 'keamanan-informasi',
        'keperluan' => 'Audit keamanan sistem e-government dan rekomendasi peningkatan infrastruktur keamanan data',
        'sistem_terkait' => 'E-Government Portal, Database Server',
        'pegawai_dituju' => 'Kepala Bidang Keamanan Informasi',
        'tanggal_kunjungan' => date('Y-m-d', strtotime('-5 days')),
        'jam_kunjungan' => '13:30:00',
        'persetujuan' => 1
    ]
];

$inserted_count = 0;

foreach ($sample_data as $data) {
    // Cek apakah data sudah ada (berdasarkan nama dan tanggal)
    $check_sql = "SELECT id FROM buku_tamu WHERE nama_lengkap = ? AND tanggal_kunjungan = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("ss", $data['nama_lengkap'], $data['tanggal_kunjungan']);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();
    
    if ($check_result->num_rows == 0) {
        // Insert data
        $insert_sql = "INSERT INTO buku_tamu (nama_lengkap, nomor_hp, email, instansi, kategori_tamu, jenis_layanan, keperluan, sistem_terkait, pegawai_dituju, tanggal_kunjungan, jam_kunjungan, persetujuan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("ssssssssssii", 
            $data['nama_lengkap'], 
            $data['nomor_hp'], 
            $data['email'], 
            $data['instansi'], 
            $data['kategori_tamu'], 
            $data['jenis_layanan'], 
            $data['keperluan'], 
            $data['sistem_terkait'], 
            $data['pegawai_dituju'], 
            $data['tanggal_kunjungan'], 
            $data['jam_kunjungan'], 
            $data['persetujuan']
        );
        
        if ($insert_stmt->execute()) {
            $inserted_count++;
            echo "<p style='color:green;'>✅ Berhasil insert: " . htmlspecialchars($data['nama_lengkap']) . " (" . $data['instansi'] . ")</p>";
        } else {
            echo "<p style='color:red;'>❌ Gagal insert: " . htmlspecialchars($data['nama_lengkap']) . " - " . $insert_stmt->error . "</p>";
        }
        
        $insert_stmt->close();
    } else {
        echo "<p style='color:orange;'>⚠️ Data sudah ada: " . htmlspecialchars($data['nama_lengkap']) . "</p>";
    }
    
    $check_stmt->close();
}

echo "<h2>📊 Summary</h2>";
echo "<p style='color:blue;'>📈 Total data yang diinsert: <strong>$inserted_count</strong></p>";

// Show current data count
$count_sql = "SELECT COUNT(*) as total FROM buku_tamu";
$count_result = $conn->query($count_sql);
$total_count = $count_result->fetch_assoc()['total'];
echo "<p style='color:blue;'>📊 Total data di buku tamu: <strong>$total_count</strong></p>";

// Show recent data
echo "<h3>👥 Data Terbaru:</h3>";
$recent_sql = "SELECT nama_lengkap, instansi, kategori_tamu, jenis_layanan, tanggal_kunjungan FROM buku_tamu ORDER BY created_at DESC LIMIT 5";
$recent_result = $conn->query($recent_sql);

if ($recent_result->num_rows > 0) {
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr style='background: #f0f0f0;'><th>Nama</th><th>Instansi</th><th>Kategori</th><th>Layanan</th><th>Tanggal</th></tr>";
    
    while ($row = $recent_result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
        echo "<td>" . htmlspecialchars($row['instansi']) . "</td>";
        echo "<td>" . htmlspecialchars($row['kategori_tamu']) . "</td>";
        echo "<td>" . htmlspecialchars($row['jenis_layanan']) . "</td>";
        echo "<td>" . date('d/m/Y', strtotime($row['tanggal_kunjungan'])) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p style='color:red;'>❌ Tidak ada data ditemukan</p>";
}

$conn->close();

echo "<h2>🚀 Selanjutnya:</h2>";
echo "<ul>";
echo "<li><a href='admin/login.php' style='color:blue;'>🔐 Login Admin</a> untuk melihat dashboard</li>";
echo "<li><a href='index.php' style='color:blue;'>📝 Form Buku Tamu</a> untuk input data baru</li>";
echo "<li><a href='admin/dashboard.php' style='color:blue;'>📊 Dashboard</a> untuk lihat semua data</li>";
echo "</ul>";

echo "<p><strong>⚠️ Catatan:</strong> Hapus file sample_data.php setelah digunakan untuk keamanan!</p>";
?>