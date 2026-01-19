<?php
require_once __DIR__ . '/config/database.php';

$error = '';
$success = '';

// Proses submit form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Use global connection from config
        global $conn;
        
        if (!$conn || $conn->connect_error) {
            throw new Exception('Koneksi database gagal! Pastikan database sudah di-setup.');
        }
        
        // Ambil dan bersihkan input
        $nama_lengkap = clean_input($_POST['nama_lengkap']);
        $nomor_hp = clean_input($_POST['nomor_hp']);
        $email = !empty($_POST['email']) ? clean_input($_POST['email']) : null;
        $instansi = clean_input($_POST['instansi']);
        $kategori_tamu = clean_input($_POST['kategori_tamu']);
        $jenis_layanan = clean_input($_POST['jenis_layanan']);
        $keperluan = clean_input($_POST['keperluan']);
        $sistem_terkait = !empty($_POST['sistem_terkait']) ? clean_input($_POST['sistem_terkait']) : null;
        $pegawai_dituju = !empty($_POST['pegawai_dituju']) ? clean_input($_POST['pegawai_dituju']) : null;
        $tanggal_kunjungan = date('Y-m-d');
        $jam_kunjungan = date('H:i:s');
        $persetujuan = isset($_POST['persetujuan']) ? 1 : 0;
        
        // Validasi
        if (empty($nama_lengkap) || empty($nomor_hp) || empty($instansi) || 
            empty($kategori_tamu) || empty($jenis_layanan) || empty($keperluan)) {
            throw new Exception('Semua field wajib harus diisi!');
        }
        
        // Validasi nomor HP
        if (!preg_match('/^62[0-9]{9,13}$/', $nomor_hp)) {
            throw new Exception('Format nomor HP tidak valid! Gunakan format 62xxxxxxxxxx');
        }
        
        // Validasi email jika diisi
        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Format email tidak valid!');
        }
        
        // Validasi persetujuan
        if (!$persetujuan) {
            throw new Exception('Anda harus menyetujui penggunaan data!');
        }
        
        // Upload foto jika ada
        $foto_tamu = null;
        if (isset($_FILES['foto_tamu']) && $_FILES['foto_tamu']['error'] == 0) {
            $target_dir = 'uploads/foto_tamu/';
            
            // Buat direktori jika belum ada
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $foto_tamu = upload_file($_FILES['foto_tamu'], $target_dir);
        }
        
        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO buku_tamu (nama_lengkap, nomor_hp, email, instansi, kategori_tamu, jenis_layanan, keperluan, sistem_terkait, pegawai_dituju, tanggal_kunjungan, jam_kunjungan, foto_tamu, persetujuan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param("ssssssssssssi", 
            $nama_lengkap, $nomor_hp, $email, $instansi, $kategori_tamu, 
            $jenis_layanan, $keperluan, $sistem_terkait, $pegawai_dituju, 
            $tanggal_kunjungan, $jam_kunjungan, $foto_tamu, $persetujuan
        );
        
        if ($stmt->execute()) {
            $success = 'Data buku tamu berhasil disimpan! Terima kasih atas kunjungan Anda.';
            // Clear form
            $_POST = array();
        } else {
            throw new Exception('Gagal menyimpan data!');
        }
        
        $stmt->close();
        $conn->close();
        
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Tamu e-Government - Diskominfo Kota Padang</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo">
                     <img src="assets/img/logo.jpeg" alt="Logo Diskominfo">
                    </div>
                    <div class="logo-text">
                        <h1>Diskominfo Kota Padang</h1>
                        <p>Buku Tamu e-Government</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="admin/login.php" class="btn-admin">
                        <i class="fas fa-user-shield"></i> Admin
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="form-container">
                <div class="form-header">
                    <h2><i class="fas fa-clipboard-list"></i> Form Buku Tamu</h2>
                    <p>Silakan isi formulir berikut untuk keperluan dokumentasi kunjungan</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i>
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="guest-book-form">
                    <!-- A. Identitas Tamu -->
                    <section class="form-section">
                        <div class="section-title">
                            <i class="fas fa-user"></i>
                            <h3>A. Identitas Tamu</h3>
                        </div>

                        <div class="form-group">
                            <label for="namaLengkap">Nama Lengkap *</label>
                            <input type="text" id="namaLengkap" name="nama_lengkap" required 
                                   placeholder="Contoh: Budi Santoso" value="<?php echo isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="nomorHp">Nomor Handphone / WhatsApp *</label>
                            <input type="tel" id="nomorHp" name="nomor_hp" required 
                                   placeholder="628123456789"
                                   pattern="[0-9]{10,14}"
                                   value="<?php echo isset($_POST['nomor_hp']) ? htmlspecialchars($_POST['nomor_hp']) : ''; ?>">
                            <small>Keterangan: Diawali kode negara (62…)</small>
                        </div>

                        <div class="form-group">
                            <label for="email">Email (Opsional)</label>
                            <input type="email" id="email" name="email" 
                                   placeholder="Contoh: budi@email.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="instansi">Instansi / Asal Tamu *</label>
                            <input type="text" id="instansi" name="instansi" required 
                                   placeholder="Contoh: OPD Kota Padang / Universitas / Perusahaan / Masyarakat" value="<?php echo isset($_POST['instansi']) ? htmlspecialchars($_POST['instansi']) : ''; ?>">
                        </div>
                    </section>

                    <!-- B. Kategori Tamu -->
                    <section class="form-section">
                        <div class="section-title">
                            <i class="fas fa-tags"></i>
                            <h3>B. Kategori Tamu</h3>
                        </div>

                        <div class="form-group">
                            <label for="kategoriTamu">Kategori Tamu *</label>
                            <select id="kategoriTamu" name="kategori_tamu" required>
                                <option value="">-- Pilih Kategori --</option>
                                <option value="opd-padang" <?php echo (isset($_POST['kategori_tamu']) && $_POST['kategori_tamu'] == 'opd-padang') ? 'selected' : ''; ?>>OPD Kota Padang</option>
                                <option value="pemerintah-lain" <?php echo (isset($_POST['kategori_tamu']) && $_POST['kategori_tamu'] == 'pemerintah-lain') ? 'selected' : ''; ?>>Pemerintah Daerah Lain</option>
                                <option value="mahasiswa-akademisi" <?php echo (isset($_POST['kategori_tamu']) && $_POST['kategori_tamu'] == 'mahasiswa-akademisi') ? 'selected' : ''; ?>>Mahasiswa / Akademisi</option>
                                <option value="perusahaan-vendor" <?php echo (isset($_POST['kategori_tamu']) && $_POST['kategori_tamu'] == 'perusahaan-vendor') ? 'selected' : ''; ?>>Perusahaan / Vendor</option>
                                <option value="masyarakat-umum" <?php echo (isset($_POST['kategori_tamu']) && $_POST['kategori_tamu'] == 'masyarakat-umum') ? 'selected' : ''; ?>>Masyarakat Umum</option>
                            </select>
                        </div>
                    </section>

                    <!-- C. Informasi Kunjungan e-Government -->
                    <section class="form-section">
                        <div class="section-title">
                            <i class="fas fa-info-circle"></i>
                            <h3>C. Informasi Kunjungan e-Government</h3>
                        </div>

                        <div class="form-group">
                            <label for="jenisLayanan">Jenis Layanan e-Government *</label>
                            <select id="jenisLayanan" name="jenis_layanan" required>
                                <option value="">-- Pilih Layanan --</option>
                                <option value="pengembangan-aplikasi" <?php echo (isset($_POST['jenis_layanan']) && $_POST['jenis_layanan'] == 'pengembangan-aplikasi') ? 'selected' : ''; ?>>Pengembangan Aplikasi</option>
                                <option value="integrasi-sistem" <?php echo (isset($_POST['jenis_layanan']) && $_POST['jenis_layanan'] == 'integrasi-sistem') ? 'selected' : ''; ?>>Integrasi Sistem</option>
                                <option value="website-opd" <?php echo (isset($_POST['jenis_layanan']) && $_POST['jenis_layanan'] == 'website-opd') ? 'selected' : ''; ?>>Website OPD</option>
                                <option value="data-statistik" <?php echo (isset($_POST['jenis_layanan']) && $_POST['jenis_layanan'] == 'data-statistik') ? 'selected' : ''; ?>>Data & Statistik</option>
                                <option value="keamanan-informasi" <?php echo (isset($_POST['jenis_layanan']) && $_POST['jenis_layanan'] == 'keamanan-informasi') ? 'selected' : ''; ?>>Keamanan Informasi</option>
                                <option value="konsultasi-layanan-digital" <?php echo (isset($_POST['jenis_layanan']) && $_POST['jenis_layanan'] == 'konsultasi-layanan-digital') ? 'selected' : ''; ?>>Konsultasi Layanan Digital</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="keperluan">Keperluan Kunjungan *</label>
                            <textarea id="keperluan" name="keperluan" required rows="4"
                                      placeholder="Contoh: Konsultasi pengembangan aplikasi pelayanan publik berbasis web"><?php echo isset($_POST['keperluan']) ? htmlspecialchars($_POST['keperluan']) : ''; ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="sistemTerkait">Sistem / Aplikasi Terkait (Jika Ada)</label>
                            <input type="text" id="sistemTerkait" name="sistem_terkait" 
                                   placeholder="Contoh: Website OPD, SIMPEG, SIPD" value="<?php echo isset($_POST['sistem_terkait']) ? htmlspecialchars($_POST['sistem_terkait']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="pegawaiDituju">Pegawai e-Government yang Dituju (Opsional)</label>
                            <input type="text" id="pegawaiDituju" name="pegawai_dituju" 
                                   placeholder="Contoh: Tim Programmer e-Gov" value="<?php echo isset($_POST['pegawai_dituju']) ? htmlspecialchars($_POST['pegawai_dituju']) : ''; ?>">
                        </div>
                    </section>

                    <!-- D. Waktu Kunjungan -->
                    <section class="form-section">
                        <div class="section-title">
                            <i class="fas fa-clock"></i>
                            <h3>D. Waktu Kunjungan</h3>
                        </div>

                        <div class="form-group">
                            <label for="tanggalKunjungan">Tanggal Kunjungan</label>
                            <input type="text" id="tanggalKunjungan" name="tanggal_kunjungan" readonly 
                                   value="<?php echo date('d/m/Y'); ?>">
                            <small>Otomatis oleh sistem</small>
                        </div>

                        <div class="form-group">
                            <label for="jamKunjungan">Jam Kunjungan</label>
                            <input type="text" id="jamKunjungan" name="jam_kunjungan" readonly 
                                   value="<?php echo date('H:i:s'); ?>">
                            <small>Otomatis oleh sistem</small>
                        </div>
                    </section>

                    <!-- E. Dokumentasi -->
                    <section class="form-section">
                        <div class="section-title">
                            <i class="fas fa-camera"></i>
                            <h3>E. Dokumentasi</h3>
                        </div>

                        <div class="form-group">
                            <label for="fotoTamu">Foto Tamu (Opsional)</label>
                            <div class="photo-upload">
                                <div class="photo-preview" id="photoPreview">
                                    <i class="fas fa-camera"></i>
                                    <span>Preview Foto</span>
                                </div>
                                <div class="upload-controls">
                                    <input type="file" id="fotoTamu" name="foto_tamu" accept="image/*" capture="camera" onchange="previewPhoto(event)">
                                    <button type="button" class="btn-secondary" onclick="document.getElementById('fotoTamu').click()">
                                        <i class="fas fa-camera"></i> Ambil Foto
                                    </button>
                                    <button type="button" class="btn-secondary" onclick="document.getElementById('fotoTamu').click()">
                                        <i class="fas fa-upload"></i> Upload File
                                    </button>
                                </div>
                                <small>Keterangan: Digunakan sebagai dokumentasi kunjungan e-Government</small>
                            </div>
                        </div>
                    </section>

                    <!-- F. Persetujuan -->
                    <section class="form-section">
                        <div class="section-title">
                            <i class="fas fa-shield-alt"></i>
                            <h3>F. Persetujuan</h3>
                        </div>

                        <div class="form-group">
                            <div class="checkbox-group">
                                <input type="checkbox" id="persetujuan" name="persetujuan" required>
                                <label for="persetujuan">
                                    Saya menyetujui data yang diinput digunakan untuk keperluan administrasi Bidang e-Government Diskominfo Kota Padang.
                                </label>
                            </div>
                        </div>
                    </section>

                    <!-- Tombol Aksi -->
                    <div class="form-actions">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-paper-plane"></i> Kirim Buku Tamu
                        </button>
                        <button type="reset" class="btn-secondary" onclick="resetForm()">
                            <i class="fas fa-redo"></i> Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> Dinas Komunikasi dan Informatika Kota Padang. All rights reserved.</p>
        </footer>
    </div>

    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('photoPreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview Foto">`;
                }
                reader.readAsDataURL(file);
            }
        }

        function resetForm() {
            document.getElementById('guestBookForm').reset();
            document.getElementById('photoPreview').innerHTML = '<i class="fas fa-camera"></i><span>Preview Foto</span>';
            
            // Update waktu kembali ke saat ini
            document.getElementById('tanggalKunjungan').value = '<?php echo date('d/m/Y'); ?>';
            document.getElementById('jamKunjungan').value = '<?php echo date('H:i:s'); ?>';
        }

        // Update waktu setiap detik
        setInterval(function() {
            if (!document.getElementById('jamKunjungan').value || document.getElementById('jamKunjungan').value === '<?php echo date('H:i:s'); ?>') {
                document.getElementById('jamKunjungan').value = new Date().toLocaleTimeString('en-GB');
            }
        }, 1000);
    </script>
</body>
</html>