<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Cek login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="buku_tamu_' . date('Y-m-d') . '.xls"');
header('Cache-Control: max-age=0');

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

$sql = "SELECT * FROM buku_tamu $where_clause ORDER BY created_at DESC";
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

// Create Excel content
echo "<table border='1'>";
echo "<tr>
    <th>No</th>
    <th>Nama Lengkap</th>
    <th>Nomor HP</th>
    <th>Email</th>
    <th>Instansi</th>
    <th>Kategori Tamu</th>
    <th>Jenis Layanan</th>
    <th>Keperluan</th>
    <th>Sistem Terkait</th>
    <th>Pegawai Dituju</th>
    <th>Tanggal Kunjungan</th>
    <th>Jam Kunjungan</th>
    <th>Foto</th>
    <th>Persetujuan</th>
    <th>Dibuat</th>
</tr>";

if ($result->num_rows > 0) {
    $no = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $no++ . "</td>";
        echo "<td>" . htmlspecialchars($row['nama_lengkap']) . "</td>";
        echo "<td>" . htmlspecialchars($row['nomor_hp']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['instansi']) . "</td>";
        echo "<td>" . get_kategori_label($row['kategori_tamu']) . "</td>";
        echo "<td>" . get_layanan_label($row['jenis_layanan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['keperluan']) . "</td>";
        echo "<td>" . htmlspecialchars($row['sistem_terkait']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pegawai_dituju']) . "</td>";
        echo "<td>" . date('d/m/Y', strtotime($row['tanggal_kunjungan'])) . "</td>";
        echo "<td>" . date('H:i', strtotime($row['jam_kunjungan'])) . "</td>";
        echo "<td>" . ($row['foto_tamu'] ? 'Ada' : 'Tidak Ada') . "</td>";
        echo "<td>" . ($row['persetujuan'] ? 'Ya' : 'Tidak') . "</td>";
        echo "<td>" . date('d/m/Y H:i:s', strtotime($row['created_at'])) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='15'>Tidak ada data ditemukan</td></tr>";
}

echo "</table>";
?>