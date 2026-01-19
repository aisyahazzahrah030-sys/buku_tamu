<?php
session_start();
require_once '../config/database.php';

// Cek login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Get data with filters
$search = isset($_GET['search']) ? clean_input($_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? clean_input($_GET['kategori']) : '';
$jenis_layanan = isset($_GET['jenis_layanan']) ? clean_input($_GET['jenis_layanan']) : '';
$tanggal_awal = isset($_GET['tanggal_awal']) ? clean_input($_GET['tanggal_awal']) : '';
$tanggal_akhir = isset($_GET['tanggal_akhir']) ? clean_input($_GET['tanggal_akhir']) : '';

// Build query
$where = [];
if ($search) {
    $where[] = "(nama_lengkap LIKE '%$search%' OR instansi LIKE '%$search%')";
}
if ($kategori) {
    $where[] = "kategori_tamu = '$kategori'";
}
if ($jenis_layanan) {
    $where[] = "jenis_layanan = '$jenis_layanan'";
}
if ($tanggal_awal) {
    $where[] = "tanggal_kunjungan >= '$tanggal_awal'";
}
if ($tanggal_akhir) {
    $where[] = "tanggal_kunjungan <= '$tanggal_akhir'";
}

$where_clause = !empty($where) ? 'WHERE ' . implode(' AND ', $where) : '';

// Get all data for PDF
$sql = "SELECT * FROM buku_tamu $where_clause ORDER BY tanggal_kunjungan DESC, jam_kunjungan DESC";
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
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kunjungan - Buku Tamu Diskominfo</title>
    <style>
        @media print {
            body { 
                font-size: 12px; 
                margin: 20px;
            }
            .no-print { 
                display: none; 
            }
            .print-break {
                page-break-inside: avoid;
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 24px;
            margin: 0;
            color: #1e3c72;
        }
        
        .header h2 {
            font-size: 18px;
            margin: 5px 0;
            color: #2a5298;
        }
        
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .info-box strong {
            display: inline-block;
            width: 150px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        th {
            background: #1e3c72;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }
        
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-box .line {
            border-bottom: 1px solid #000;
            margin: 30px 0 5px;
        }
        
        .no-print {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px 0;
            display: inline-block;
        }
        
        .no-print:hover {
            background: #218838;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="no-print">
        🖨️ Cetak Laporan
    </button>
    
    <button onclick="window.history.back()" class="no-print">
        ← Kembali ke Dashboard
    </button>
    
    <div class="header">
        <h1>LAPORAN KUNJUNGAN E-GOVERNMENT</h1>
        <h2>DINAS KOMUNIKASI DAN INFORMATIKA</h2>
        <h2>KOTA PADANG</h2>
        <p>Jl. M. Yamin No. 24 Padang</p>
        <p>Telp: (0751) 123456 | Email: diskominfo@padang.go.id</p>
    </div>
    
    <div class="info-box">
        <strong>Periode Laporan:</strong> 
        <?php 
            if ($tanggal_awal && $tanggal_akhir) {
                echo date('d/m/Y', strtotime($tanggal_awal)) . ' - ' . date('d/m/Y', strtotime($tanggal_akhir));
            } elseif ($tanggal_awal) {
                echo 'Dari ' . date('d/m/Y', strtotime($tanggal_awal)) . ' hingga sekarang';
            } elseif ($tanggal_akhir) {
                echo 'Hingga ' . date('d/m/Y', strtotime($tanggal_akhir));
            } else {
                echo 'Semua data';
            }
        ?>
        <br>
        <strong>Tanggal Cetak:</strong> <?php echo date('d/m/Y H:i:s'); ?>
        <br>
        <strong>Total Tamu:</strong> <?php echo $result->num_rows; ?> orang
    </div>
    
    <?php if ($search || $kategori || $jenis_layanan): ?>
    <div class="info-box">
        <strong>Filter Aktif:</strong><br>
        <?php if ($search): ?>Pencarian: <?php echo htmlspecialchars($search); ?><br><?php endif; ?>
        <?php if ($kategori): ?>Kategori: <?php echo get_kategori_label($kategori); ?><br><?php endif; ?>
        <?php if ($jenis_layanan): ?>Layanan: <?php echo get_layanan_label($jenis_layanan); ?><br><?php endif; ?>
    </div>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="120">Tanggal</th>
                <th width="150">Nama Lengkap</th>
                <th width="80">No. HP</th>
                <th width="120">Instansi</th>
                <th width="100">Kategori</th>
                <th width="100">Layanan</th>
                <th width="80">Pegawai Dituju</th>
                <th>Keperluan</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr class="print-break">
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['tanggal_kunjungan'])); ?> 
                            <br><?php echo date('H:i', strtotime($row['jam_kunjungan'])); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                        <td><?php echo htmlspecialchars($row['nomor_hp']); ?></td>
                        <td><?php echo htmlspecialchars($row['instansi']); ?></td>
                        <td><?php echo get_kategori_label($row['kategori_tamu']); ?></td>
                        <td><?php echo get_layanan_label($row['jenis_layanan']); ?></td>
                        <td><?php echo htmlspecialchars($row['pegawai_dituju'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars(substr($row['keperluan'], 0, 100)) . (strlen($row['keperluan']) > 100 ? '...' : ''); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="footer">
        <p><em>Laporan ini dicetak secara otomatis dari Sistem Buku Tamu e-Government</em></p>
        <p>© <?php echo date('Y'); ?> Dinas Komunikasi dan Informatika Kota Padang</p>
    </div>
    
    <div class="signature">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala Dinas</p>
            <p>Komunikasi dan Informatika</p>
            <p>Kota Padang</p>
            <div class="line"></div>
            <p><strong>(Nama Kepala Dinas)</strong></p>
            <p>NIP. 1234567890123456</p>
        </div>
        
        <div class="signature-box">
            <p>Padang, <?php echo date('d F Y'); ?></p>
            <p>Petugas Administrasi</p>
            <div class="line"></div>
            <p><strong><?php echo htmlspecialchars($_SESSION['admin_nama']); ?></strong></p>
            <p>NIP. 1234567890123456</p>
        </div>
    </div>
</body>
</html>