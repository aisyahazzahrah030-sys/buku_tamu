<?php
// Fungsi helper tanpa database
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$error = '';
$success = '';

// Proses submit form (simulasi)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Ambil dan bersihkan input
        $nama_lengkap = clean_input($_POST['nama_lengkap'] ?? '');
        $nomor_hp = clean_input($_POST['nomor_hp'] ?? '');
        $email = !empty($_POST['email']) ? clean_input($_POST['email']) : null;
        $instansi = clean_input($_POST['instansi'] ?? '');
        $kategori_tamu = clean_input($_POST['kategori_tamu'] ?? '');
        $jenis_layanan = clean_input($_POST['jenis_layanan'] ?? '');
        $keperluan = clean_input($_POST['keperluan'] ?? '');
        $sistem_terkait = !empty($_POST['sistem_terkait']) ? clean_input($_POST['sistem_terkait']) : null;
        $pegawai_dituju = !empty($_POST['pegawai_dituju']) ? clean_input($_POST['pegawai_dituju']) : null;
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
        
        // Simulasi sukses (dalam production, ini akan disimpan ke database)
        $success = '✅ Data buku tamu berhasil disimpan! Terima kasih atas kunjungan Anda.';
        
        // Log data untuk debugging
        error_log("Buku Tamu: $nama_lengkap - $instansi - " . date('Y-m-d H:i:s'));
        
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
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
        }
        .container {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .header {
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
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        .logo-text h1 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .logo-text p {
            font-size: 0.9rem;
            opacity: 0.9;
        }
        .header-actions {
            display: flex;
            gap: 1rem;
        }
        .btn-admin {
            background: rgba(255,255,255,0.2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
        }
        .btn-admin:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        .main-content {
            flex: 1;
            padding: 2rem 0;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .form-header h2 {
            font-size: 1.8rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        .guest-book-form {
            padding: 2rem;
        }
        .form-section {
            margin-bottom: 2rem;
        }
        .section-title {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e9ecef;
        }
        .section-title i {
            color: #667eea;
            font-size: 1.2rem;
        }
        .section-title h3 {
            color: #495057;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #495057;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: inherit;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102,126,234,0.1);
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .form-group small {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }
        .photo-upload {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }
        .photo-preview {
            width: 150px;
            height: 150px;
            margin: 0 auto 1rem;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            overflow: hidden;
        }
        .upload-controls {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-bottom: 1rem;
        }
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 0.5rem;
        }
        .checkbox-group input[type="checkbox"] {
            margin-top: 0.25rem;
            width: auto;
        }
        .checkbox-group label {
            margin-bottom: 0;
            cursor: pointer;
        }
        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e9ecef;
        }
        .btn-primary,
        .btn-secondary {
            padding: 0.75rem 2rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102,126,234,0.3);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .footer {
            background: #343a40;
            color: white;
            text-align: center;
            padding: 1.5rem 0;
            margin-top: auto;
        }
        .demo-badge {
            background: #ffc107;
            color: #000;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: bold;
            margin-left: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-content">
                <div class="logo-section">
                    <div class="logo">🏛️</div>
                    <div class="logo-text">
                        <h1>Diskominfo Kota Padang</h1>
                        <p>Buku Tamu e-Government</p>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="admin/login_standalone.php" class="btn-admin">
                        👨‍💼 Admin <span class="demo-badge">DEMO</span>
                    </a>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="main-content">
            <div class="form-container">
                <div class="form-header">
                    <h2>📋 Form Buku Tamu</h2>
                    <p>Silakan isi formulir berikut untuk keperluan dokumentasi kunjungan</p>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        ⚠️ <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success">
                        ✅ <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" class="guest-book-form">
                    <!-- A. Identitas Tamu -->
                    <section class="form-section">
                        <div class="section-title">
                            <span>👤</span>
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
                            <span>🏷️</span>
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
                            <span>ℹ️</span>
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
                            <span>🕒</span>
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
                            <span>📷</span>
                            <h3>E. Dokumentasi</h3>
                        </div>

                        <div class="form-group">
                            <label for="fotoTamu">Foto Tamu (Opsional)</label>
                            <div class="photo-upload">
                                <div class="photo-preview" id="photoPreview">
                                    📷<br>
                                    <span>Preview Foto</span>
                                </div>
                                <div class="upload-controls">
                                    <input type="file" id="fotoTamu" name="foto_tamu" accept="image/*" capture="camera" onchange="previewPhoto(event)">
                                    <button type="button" class="btn-secondary" onclick="document.getElementById('fotoTamu').click()">
                                        📷 Ambil Foto
                                    </button>
                                    <button type="button" class="btn-secondary" onclick="document.getElementById('fotoTamu').click()">
                                        📁 Upload File
                                    </button>
                                </div>
                                <small>Keterangan: Digunakan sebagai dokumentasi kunjungan e-Government</small>
                            </div>
                        </div>
                    </section>

                    <!-- F. Persetujuan -->
                    <section class="form-section">
                        <div class="section-title">
                            <span>🔐</span>
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
                            📤 Kirim Buku Tamu
                        </button>
                        <button type="reset" class="btn-secondary" onclick="resetForm()">
                            🔄 Reset Form
                        </button>
                    </div>
                </form>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer">
            <p>&copy; <?php echo date('Y'); ?> Dinas Komunikasi dan Informatika Kota Padang. All rights reserved.</p>
            <p><small>🟡 Mode Demo - Untuk production, import database.sql terlebih dahulu</small></p>
        </footer>
    </div>

    <script>
        function previewPhoto(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('photoPreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview Foto" style="width:100%;height:100%;object-fit:cover;">`;
                }
                reader.readAsDataURL(file);
            }
        }

        function resetForm() {
            document.getElementById('guestBookForm').reset();
            document.getElementById('photoPreview').innerHTML = '📷<br><span>Preview Foto</span>';
            
            // Update waktu kembali ke saat ini
            document.getElementById('tanggalKunjungan').value = '<?php echo date('d/m/Y'); ?>';
            document.getElementById('jamKunjungan').value = '<?php echo date('H:i:s'); ?>';
        }

        // Update waktu setiap detik
        setInterval(function() {
            const jamElement = document.getElementById('jamKunjungan');
            if (jamElement && jamElement.value === '<?php echo date('H:i:s'); ?>') {
                jamElement.value = new Date().toLocaleTimeString('en-GB');
            }
        }, 1000);
    </script>
</body>
</html>