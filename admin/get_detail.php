<?php
session_start();
require_once __DIR__ . '/../config/database.php';

// Cek login
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(401);
    echo 'Unauthorized';
    exit;
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Use global connection from config
    global $conn;
    
    $stmt = $conn->prepare("SELECT * FROM buku_tamu WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
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
        <div class="detail-view">
            <div class="detail-row">
                <div class="detail-label">Nama Lengkap:</div>
                <div class="detail-value"><?php echo htmlspecialchars($row['nama_lengkap']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Nomor HP:</div>
                <div class="detail-value"><?php echo htmlspecialchars($row['nomor_hp']); ?></div>
            </div>
            <?php if ($row['email']): ?>
            <div class="detail-row">
                <div class="detail-label">Email:</div>
                <div class="detail-value"><?php echo htmlspecialchars($row['email']); ?></div>
            </div>
            <?php endif; ?>
            <div class="detail-row">
                <div class="detail-label">Instansi:</div>
                <div class="detail-value"><?php echo htmlspecialchars($row['instansi']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Kategori Tamu:</div>
                <div class="detail-value"><?php echo get_kategori_label($row['kategori_tamu']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jenis Layanan:</div>
                <div class="detail-value"><?php echo get_layanan_label($row['jenis_layanan']); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Keperluan:</div>
                <div class="detail-value"><?php echo nl2br(htmlspecialchars($row['keperluan'])); ?></div>
            </div>
            <?php if ($row['sistem_terkait']): ?>
            <div class="detail-row">
                <div class="detail-label">Sistem Terkait:</div>
                <div class="detail-value"><?php echo htmlspecialchars($row['sistem_terkait']); ?></div>
            </div>
            <?php endif; ?>
            <?php if ($row['pegawai_dituju']): ?>
            <div class="detail-row">
                <div class="detail-label">Pegawai yang Dituju:</div>
                <div class="detail-value"><?php echo htmlspecialchars($row['pegawai_dituju']); ?></div>
            </div>
            <?php endif; ?>
            <div class="detail-row">
                <div class="detail-label">Tanggal Kunjungan:</div>
                <div class="detail-value"><?php echo date('d/m/Y', strtotime($row['tanggal_kunjungan'])); ?></div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Jam Kunjungan:</div>
                <div class="detail-value"><?php echo date('H:i', strtotime($row['jam_kunjungan'])); ?></div>
            </div>
            <?php if ($row['foto_tamu']): ?>
            <div class="detail-row">
                <div class="detail-label">Foto Tamu:</div>
                <div class="detail-value">
                    <img src="../uploads/foto_tamu/<?php echo htmlspecialchars($row['foto_tamu']); ?>" 
                         alt="Foto Tamu" style="max-width: 200px; border-radius: 8px;">
                </div>
            </div>
            <?php endif; ?>
            <div class="detail-row">
                <div class="detail-label">Persetujuan:</div>
                <div class="detail-value">
                    <?php echo $row['persetujuan'] ? '✅ Disetujui' : '❌ Tidak Disetujui'; ?>
                </div>
            </div>
            <div class="detail-row">
                <div class="detail-label">Dibuat:</div>
                <div class="detail-value"><?php echo date('d/m/Y H:i:s', strtotime($row['created_at'])); ?></div>
            </div>
        </div>
        
        <style>
        .detail-view {
            font-size: 0.95rem;
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
        <?php
    } else {
        echo 'Data tidak ditemukan';
    }
    
    $stmt->close();
} else {
    echo 'ID tidak valid';
}
?>