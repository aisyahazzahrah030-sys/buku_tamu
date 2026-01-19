<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Cek login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Use global connection from config
global $conn;

if (!$conn || $conn->connect_error) {
    die("Koneksi database gagal! Pastikan database sudah di-setup.");
}

// Get all data from buku tamu
$sql = "SELECT * FROM buku_tamu ORDER BY created_at DESC";
$result = $conn->query($sql);

// Helper functions
function get_kategori_label($kategori) {
    $labels = [
        'opd-padang' => 'OPD Kota Padang',
        'pemerintah-lain' => 'Pemerintah Daerah Lain',
        'mahasiswa-akademisi' => 'Mahasiswa / Akademisi',
        'perusahaan-vendor' => 'Perusahaan / Vendor',
        'masyarakat-umum' => 'Masyarakat Umum'
    ];
    return $labels[$kategori] ?? $kategori;
}

function get_layanan_label($layanan) {
    $labels = [
        'pengembangan-aplikasi' => 'Pengembangan Aplikasi',
        'integrasi-sistem' => 'Integrasi Sistem',
        'website-opd' => 'Website OPD',
        'data-statistik' => 'Data & Statistik',
        'keamanan-informasi' => 'Keamanan Informasi',
        'konsultasi-layanan-digital' => 'Konsultasi Layanan Digital'
    ];
    return $labels[$layanan] ?? $layanan;
}

// Get statistics
$total_records = $result->num_rows;
$today = date('Y-m-d');
$today_sql = "SELECT COUNT(*) as count FROM buku_tamu WHERE DATE(tanggal_kunjungan) = '$today'";
$today_result = $conn->query($today_sql);
$today_count = $today_result->fetch_assoc()['count'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Buku Tamu Diskominfo</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            color: #333;
        }
        .admin-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .logo-section {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logo {
            background: rgba(255,255,255,0.2);
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .logo-text h1 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }
        .logo-text span {
            font-size: 0.8rem;
            opacity: 0.9;
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .logout-btn {
            background: rgba(220,53,69,0.8);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .logout-btn:hover {
            background: rgba(220,53,69,1);
            transform: translateY(-2px);
        }
        .admin-main {
            padding: 2rem 0;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .stat-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .stat-content h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #495057;
            margin-bottom: 0.2rem;
        }
        .stat-content p {
            color: #6c757d;
            font-size: 0.875rem;
        }
        .data-section {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #e9ecef;
        }
        .section-header h3 {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #495057;
        }
        .export-buttons {
            display: flex;
            gap: 0.5rem;
        }
        .btn-export {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            font-size: 0.875rem;
            color: white;
            transition: all 0.3s ease;
        }
        .btn-export:first-child {
            background: #28a745;
        }
        .btn-export:last-child {
            background: #007bff;
        }
        .btn-export:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        .table-container {
            overflow-x: auto;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }
        .data-table th,
        .data-table td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .data-table th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
        }
        .data-table tbody tr:hover {
            background: #f8f9fa;
        }
        .badge {
            background: #e9ecef;
            color: #495057;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
        }
        .btn-view,
        .btn-delete {
            padding: 0.25rem 0.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 0.25rem;
            background: #17a2b8;
            color: white;
        }
        .btn-delete {
            background: #dc3545;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            background: white;
            border-radius: 10px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        .modal-header {
            padding: 1.5rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-close {
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #6c757d;
        }
        .modal-body {
            padding: 1.5rem;
        }
        .detail-row {
            display: flex;
            padding: 0.75rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #495057;
            min-width: 180px;
            flex-shrink: 0;
        }
        .detail-value {
            color: #212529;
            flex: 1;
        }
    </style>
</head>
<body class="admin-page">
    <!-- Header -->
    <header class="admin-header">
        <div class="header-content">
            <div class="logo-section">
                <div class="logo">🏛️</div>
                <div class="logo-text">
                    <h1>Diskominfo Padang</h1>
                    <span>Buku Tamu e-Government</span>
                </div>
            </div>
            <div class="user-menu">
                <span>👤 <?php echo htmlspecialchars($_SESSION['admin_nama']); ?></span>
                <a href="logout.php" class="logout-btn">
                    🚪 Logout
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="admin-main">
        <div class="dashboard-container">
            <!-- Stats Cards -->
            <div class="stats-cards">
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-content">
                        <h3><?php echo $total_records; ?></h3>
                        <p>Total Tamu</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📅</div>
                    <div class="stat-content">
                        <h3><?php echo $today_count; ?></h3>
                        <p>Hari Ini</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📊</div>
                    <div class="stat-content">
                        <h3><?php echo $total_records; ?></h3>
                        <p>Minggu Ini</p>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">📈</div>
                    <div class="stat-content">
                        <h3><?php echo $total_records; ?></h3>
                        <p>Bulan Ini</p>
                    </div>
                </div>
            </div>

            <!-- Data Section -->
            <div class="data-section">
                <div class="section-header">
                    <h3>📋 Data Buku Tamu</h3>
                    <div class="export-buttons">
                        <a href="export_excel.php" class="btn-export">
                            📊 Export Excel
                        </a>
                        <a href="laporan_pdf.php" class="btn-export">
                            🖨️ Cetak Laporan
                        </a>
                    </div>
                </div>
                
                <div class="table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Lengkap</th>
                                <th>Instansi</th>
                                <th>Kategori</th>
                                <th>Layanan</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($result->num_rows > 0): ?>
                                <?php $no = 1; ?>
                                <?php while ($row = $result->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['nama_lengkap']); ?></strong><br>
                                            <small><?php echo htmlspecialchars($row['nomor_hp']); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($row['instansi']); ?></td>
                                        <td><span class="badge"><?php echo get_kategori_label($row['kategori_tamu']); ?></span></td>
                                        <td><span class="badge"><?php echo get_layanan_label($row['jenis_layanan']); ?></span></td>
                                        <td><?php echo date('d/m/Y', strtotime($row['tanggal_kunjungan'])); ?></td>
                                        <td><?php echo date('H:i', strtotime($row['jam_kunjungan'])); ?></td>
                                        <td>
                                            <button class="btn-view" onclick="viewDetail(<?php echo $row['id']; ?>)">
                                                👁️
                                            </button>
                                            <button class="btn-delete" onclick="deleteData(<?php echo $row['id']; ?>)">
                                                🗑️
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="8" style="text-align:center;">Tidak ada data ditemukan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- Detail Modal -->
    <div id="detailModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Detail Tamu</h3>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>
            <div class="modal-body" id="detailContent">
                Loading...
            </div>
        </div>
    </div>

    <script>
        function viewDetail(id) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'get_detail.php?id=' + id, true);
            xhr.onload = function() {
                if (this.status === 200) {
                    document.getElementById('detailContent').innerHTML = this.responseText;
                    document.getElementById('detailModal').style.display = 'flex';
                }
            };
            xhr.send();
        }

        function deleteData(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                const xhr = new XMLHttpRequest();
                xhr.open('GET', 'delete.php?id=' + id, true);
                xhr.onload = function() {
                    if (this.status ===200) {
                        location.reload();
                    }
                };
                xhr.send();
            }
        }

        function closeModal() {
            document.getElementById('detailModal').style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>