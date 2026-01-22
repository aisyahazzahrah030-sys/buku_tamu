@extends('layouts.app')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h2><i class="fas fa-clipboard-list"></i> Form Buku Tamu</h2>
        <p>Silakan isi formulir berikut untuk keperluan dokumentasi kunjungan</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('guest.store') }}" enctype="multipart/form-data" class="guest-book-form">
        @csrf
        <!-- A. Identitas Tamu -->
        <section class="form-section">
            <div class="section-title">
                <i class="fas fa-user"></i>
                <h3>A. Identitas Tamu</h3>
            </div>

            <div class="form-group">
                <label for="namaLengkap">Nama Lengkap *</label>
                <input type="text" id="namaLengkap" name="nama_lengkap" required 
                       placeholder="Contoh: Budi Santoso" value="{{ old('nama_lengkap') }}">
            </div>

            <div class="form-group">
                <label for="nomorHp">Nomor Handphone / WhatsApp *</label>
                <input type="tel" id="nomorHp" name="nomor_hp" required 
                       placeholder="Contoh: 08123456789 atau 628123456789"
                       pattern="[0-9]{10,14}"
                       value="{{ old('nomor_hp') }}">

            </div>

            <div class="form-group">
                <label for="email">Email (Opsional)</label>
                <input type="email" id="email" name="email" 
                       placeholder="Contoh: budi@email.com" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="instansi">Instansi / Asal Tamu *</label>
                <input type="text" id="instansi" name="instansi" required 
                       placeholder="Contoh: OPD Kota Padang / Universitas / Perusahaan / Masyarakat" value="{{ old('instansi') }}">
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
                    <option value="opd-padang" {{ old('kategori_tamu') == 'opd-padang' ? 'selected' : '' }}>OPD Kota Padang</option>
                    <option value="pemerintah-lain" {{ old('kategori_tamu') == 'pemerintah-lain' ? 'selected' : '' }}>Pemerintah Daerah Lain</option>
                    <option value="umum" {{ old('kategori_tamu') == 'umum' ? 'selected' : '' }}>Umum</option>
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
                <label for="namaOpd">Nama OPD *</label>
                <select id="namaOpd" name="nama_opd" class="select2-opd" required>
                    <option value="">-- Ketik atau Pilih OPD --</option>
                    <!-- Contoh data OPD - nanti akan diisi lengkap -->
                    <option value="inspektorat" data-pejabat="Drs. ARFIAN" {{ old('nama_opd') == 'inspektorat' ? 'selected' : '' }}>INSPEKTORAT</option>
                    <option value="sekretariat-dprd" data-pejabat="HENDRIZAL AZHAR, SH, MM" {{ old('nama_opd') == 'sekretariat-dprd' ? 'selected' : '' }}>SEKRETARIAT DPRD</option>
                    <option value="badan-kesatuan-bangsa-politik" data-pejabat="Drs. SYAHENDRI BARKAH" {{ old('nama_opd') == 'badan-kesatuan-bangsa-politik' ? 'selected' : '' }}>BADAN KESATUAN BANGSA POLITIK</option>
                    <option value="badan-perencanaan-pembangunan-daerah" data-pejabat="Yenni Yuliza, ST, MT" {{ old('nama_opd') == 'badan-perencanaan-pembangunan-daerah' ? 'selected' : '' }}>BADAN PERENCANAAN PEMBANGUNAN DAERAH (BAPPEDA)</option>
                    <option value="bpkad" data-pejabat="RAJU MINROPA, S.STP, M.Si" {{ old('nama_opd') == 'bpkad' ? 'selected' : '' }}>BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH (BPKAD)</option>
                    <option value="bkpsdm" data-pejabat="Ir. MAIRIZON, M.Si" {{ old('nama_opd') == 'bkpsdm' ? 'selected' : '' }}>BADAN KEPEGAWAIAN DAN PENGEMBANGAN SDM (BKPSDM)</option>
                    <option value="bpbd" data-pejabat="HENDRI ZULVITON, ST, MT" {{ old('nama_opd') == 'bpbd' ? 'selected' : '' }}>BADAN PENANGGULANGAN BENCANA DAERAH (BPBD)</option>
                    <option value="bapenda" data-pejabat="Drs. YOSEFRIAWAN" {{ old('nama_opd') == 'bapenda' ? 'selected' : '' }}>BADAN PENDAPATAN DAERAH (BAPENDA)</option>
                    <option value="satpol-pp" data-pejabat="-" {{ old('nama_opd') == 'satpol-pp' ? 'selected' : '' }}>SATUAN POLISI PAMONG PRAJA (SATPOL PP)</option>
                    <option value="dlh" data-pejabat="FADELAN FITRA MASTA, ST,MT" {{ old('nama_opd') == 'dlh' ? 'selected' : '' }}>DINAS LINGKUNGAN HIDUP (DLH)</option>
                    <option value="dinas-sosial" data-pejabat="ERI SENDJAYA, S. Sos, S.Sos, M.Si" {{ old('nama_opd') == 'dinas-sosial' ? 'selected' : '' }}>DINAS SOSIAL</option>
                    <option value="bagian-pengadaan-barang-jasa" data-pejabat="MALVI HENDRI, S.T., M.Si." {{ old('nama_opd') == 'bagian-pengadaan-barang-jasa' ? 'selected' : '' }}>BAGIAN PENGADAAN BARANG/JASA</option>
                    <option value="bagian-tata-pemerintahan" data-pejabat="EKA PUTRA BUHARI, S.STP., M.P.A." {{ old('nama_opd') == 'bagian-tata-pemerintahan' ? 'selected' : '' }}>BAGIAN TATA PEMERINTAHAN</option>
                    <option value="bagian-hukum" data-pejabat="RITA ENGLENI, SH, MSI" {{ old('nama_opd') == 'bagian-hukum' ? 'selected' : '' }}>BAGIAN HUKUM</option>
                    <option value="bagian-administrasi-pembangunan-perencanaan" data-pejabat="ERWIN, M. M.A" {{ old('nama_opd') == 'bagian-administrasi-pembangunan-perencanaan' ? 'selected' : '' }}>BAGIAN ADMINISTRASI PEMBANGUNAN DAN PERENCANAAN</option>
                    <option value="bagian-kesra" data-pejabat="JASMAN, S.Sos., M.M" {{ old('nama_opd') == 'bagian-kesra' ? 'selected' : '' }}>BAGIAN KESEJAHTERAAN RAKYAT (KESRA)</option>
                    <option value="bagian-organisasi" data-pejabat="Tablig Nasution" {{ old('nama_opd') == 'bagian-organisasi' ? 'selected' : '' }}>BAGIAN ORGANISASI</option>
                    <option value="bagian-prokopim" data-pejabat="TOMMY TRD" {{ old('nama_opd') == 'bagian-prokopim' ? 'selected' : '' }}>BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN (PROKOPIM)</option>
                    <option value="bagian-kerjasama" data-pejabat="-" {{ old('nama_opd') == 'bagian-kerjasama' ? 'selected' : '' }}>BAGIAN KERJASAMA</option>
                    <option value="kecamatan-padang-barat" data-pejabat="-" {{ old('nama_opd') == 'kecamatan-padang-barat' ? 'selected' : '' }}>KECAMATAN PADANG BARAT</option>
                    <option value="kecamatan-padang-timur" data-pejabat="-" {{ old('nama_opd') == 'kecamatan-padang-timur' ? 'selected' : '' }}>KECAMATAN PADANG TIMUR</option>
                    <option value="kecamatan-padang-selatan" data-pejabat="Wilman Muchtar" {{ old('nama_opd') == 'kecamatan-padang-selatan' ? 'selected' : '' }}>KECAMATAN PADANG SELATAN</option>
                    <option value="kecamatan-padang-utara" data-pejabat="SA`AT, S.Pd., M.T" {{ old('nama_opd') == 'kecamatan-padang-utara' ? 'selected' : '' }}>KECAMATAN PADANG UTARA</option>
                    <option value="kecamatan-nanggalo" data-pejabat="AMRIZAL, S.Sos" {{ old('nama_opd') == 'kecamatan-nanggalo' ? 'selected' : '' }}>KECAMATAN NANGGALO</option>
                    <option value="kecamatan-pauh" data-pejabat="T MASFETRIN, S.Pt., M.Si" {{ old('nama_opd') == 'kecamatan-pauh' ? 'selected' : '' }}>KECAMATAN PAUH</option>
                    <option value="kecamatan-koto-tangah" data-pejabat="FIZLAN SETIAWAN, S.STP., M.M" {{ old('nama_opd') == 'kecamatan-koto-tangah' ? 'selected' : '' }}>KECAMATAN KOTO TANGAH</option>
                    <option value="kecamatan-lubuk-begalung" data-pejabat="NOFIANDI AMIR, S.H., M.H" {{ old('nama_opd') == 'kecamatan-lubuk-begalung' ? 'selected' : '' }}>KECAMATAN LUBUK BEGALUNG</option>
                    <option value="kecamatan-lubuk-kilangan" data-pejabat="AFRIALDI MASBIRAN, SH, M. HUM" {{ old('nama_opd') == 'kecamatan-lubuk-kilangan' ? 'selected' : '' }}>KECAMATAN LUBUK KILANGAN</option>
                    <option value="kecamatan-kuranji" data-pejabat="RIDO SATRIA, S.STP" {{ old('nama_opd') == 'kecamatan-kuranji' ? 'selected' : '' }}>KECAMATAN KURANJI</option>
                    <option value="kecamatan-bungus-teluk-kabung" data-pejabat="Harnoldi, SH, MM" {{ old('nama_opd') == 'kecamatan-bungus-teluk-kabung' ? 'selected' : '' }}>KECAMATAN BUNGUS TELUK KABUNG</option>
                    <option value="rsud-dr-rasidin" data-pejabat="dr. DESY SUSANTY" {{ old('nama_opd') == 'rsud-dr-rasidin' ? 'selected' : '' }}>UNIT ORGANISASI BERSIFAT KHUSUS RUMAH SAKIT UMUM DAERAH dr. RASIDIN</option>
                    <!-- Data OPD lengkap akan ditambahkan di sini -->
                </select>
                <small>Ketik nama OPD untuk mencari lebih cepat</small>
            </div>

            <div class="form-group">
                <label for="jenisLayanan">Jenis Layanan e-Government *</label>
                <select id="jenisLayanan" name="jenis_layanan" required>
                    <option value="">-- Pilih Layanan --</option>
                    <option value="pengembangan-aplikasi" {{ old('jenis_layanan') == 'pengembangan-aplikasi' ? 'selected' : '' }}>Pengembangan Aplikasi</option>
                    <option value="integrasi-sistem" {{ old('jenis_layanan') == 'integrasi-sistem' ? 'selected' : '' }}>Integrasi Sistem</option>
                    <option value="website-opd" {{ old('jenis_layanan') == 'website-opd' ? 'selected' : '' }}>Website OPD</option>
                    <option value="data-statistik" {{ old('jenis_layanan') == 'data-statistik' ? 'selected' : '' }}>Data & Statistik</option>
                    <option value="keamanan-informasi" {{ old('jenis_layanan') == 'keamanan-informasi' ? 'selected' : '' }}>Keamanan Informasi</option>
                    <option value="konsultasi-layanan-digital" {{ old('jenis_layanan') == 'konsultasi-layanan-digital' ? 'selected' : '' }}>Konsultasi Layanan Digital</option>
                </select>
            </div>

            <div class="form-group">
                <label for="keperluan">Keperluan Kunjungan *</label>
                <textarea id="keperluan" name="keperluan" required rows="4"
                          placeholder="Contoh: Konsultasi pengembangan aplikasi pelayanan publik berbasis web">{{ old('keperluan') }}</textarea>
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
                       value="{{ date('d/m/Y') }}">
                <small>Otomatis oleh sistem</small>
            </div>

            <div class="form-group">
                <label for="jamKunjungan">Jam Kunjungan</label>
                <input type="text" id="jamKunjungan" name="jam_kunjungan" readonly 
                       value="{{ date('H:i:s') }}">
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
                        <!-- Hidden File Input -->
                        <input type="file" id="fotoTamu" name="foto_tamu" accept="image/*" capture="environment" onchange="previewPhoto(event)" style="display: none;">
                        
                        <!-- Buttons -->
                        <button type="button" class="btn-secondary" onclick="openCameraModal()">
                            <i class="fas fa-camera"></i> Ambil Foto (Webcam)
                        </button>
                        <button type="button" class="btn-secondary" onclick="document.getElementById('fotoTamu').click()">
                            <i class="fas fa-upload"></i> Upload File
                        </button>
                    </div>
                    <small>Keterangan: Digunakan sebagai dokumentasi kunjungan e-Government</small>
                </div>
            </div>

            <!-- Camera Modal (Hidden by default) -->
            <div id="cameraModal" class="camera-modal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; justify-content:center; align-items:center; flex-direction:column;">
                <div style="background:white; padding:20px; border-radius:10px; text-align:center; max-width:90%; width:500px;">
                    <h3>Ambil Foto</h3>
                    <video id="cameraVideo" autoplay playsinline style="width:100%; border-radius:8px; margin-bottom:15px; background:#000;"></video>
                    <canvas id="cameraCanvas" style="display:none;"></canvas>
                    <div style="display:flex; justify-content:center; gap:10px;">
                        <button type="button" class="btn-primary" onclick="capturePhoto()">
                            <i class="fas fa-camera"></i> Jepret
                        </button>
                        <button type="button" class="btn-secondary" onclick="closeCameraModal()">
                            Batal
                        </button>
                    </div>
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
                    <input type="checkbox" id="persetujuan" name="persetujuan" required checked>
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
@endsection

@section('scripts')
<script>
    // Initialize Select2 untuk OPD dropdown
    $(document).ready(function() {
        $('.select2-opd').select2({
            placeholder: '-- Ketik atau Pilih OPD --',
            allowClear: true,
            width: '100%',
            language: {
                noResults: function() {
                    return "OPD tidak ditemukan";
                },
                searching: function() {
                    return "Mencari...";
                }
            }
        });

        // Auto-populate nama pejabat ketika OPD dipilih
        $('#namaOpd').on('change', function() {
            // Logika nama pejabat dihapus
        });

        // Trigger change event jika ada old value (untuk error validation)
        if ($('#namaOpd').val()) {
            $('#namaOpd').trigger('change');
        }
    });

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
        // Reset preview
        document.getElementById('photoPreview').innerHTML = '<i class="fas fa-camera"></i><span>Preview Foto</span>';
        
        // Reset time (handled by interval below for display)
    }

    // Update waktu setiap detik
    setInterval(function() {
        document.getElementById('jamKunjungan').value = new Date().toLocaleTimeString('en-GB');
    }, 1000);

    // Auto-format phone number on blur
    document.getElementById('nomorHp').addEventListener('blur', function() {
        let value = this.value.trim();
        if (value.startsWith('0')) {
            this.value = '62' + value.substring(1);
        }
    });

    // Camera Logic
    let stream = null;

    async function openCameraModal() {
        const modal = document.getElementById('cameraModal');
        const video = document.getElementById('cameraVideo');
        
        // Cek apakah browser mendukung
        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            alert('Browser Anda tidak mendukung akses kamera atau koneksi tidak aman (HTTPS). Pastikan Anda mengakses via HTTPS.');
            return;
        }

        try {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
            modal.style.display = 'flex';
        } catch (err) {
            console.error(err);
            alert('Gagal mengakses kamera: ' + err.message + '\n\nPastikan Anda mengizinkan akses kamera dan menggunakan HTTPS.');
        }
    }

    function closeCameraModal() {
        const modal = document.getElementById('cameraModal');
        modal.style.display = 'none';
        
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
    }

    function capturePhoto() {
        const video = document.getElementById('cameraVideo');
        const canvas = document.getElementById('cameraCanvas');
        const context = canvas.getContext('2d');
        const fileInput = document.getElementById('fotoTamu');

        // Set canvas dimensions to match video
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        // Draw video frame to canvas
        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        // Convert canvas to blob/file
        canvas.toBlob(function(blob) {
            // Create a File object
            const file = new File([blob], "camera_capture_" + new Date().getTime() + ".jpg", { type: "image/jpeg" });
            
            // Validate file size/type if needed
            
            // Create a DataTransfer to set the file input value
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            fileInput.files = dataTransfer.files;
            
            // Trigger preview
            // Create a fake event object to reuse previewPhoto function or just call it directly logic
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('photoPreview').innerHTML = `<img src="${e.target.result}" alt="Preview Foto">`;
            }
            reader.readAsDataURL(file);

            closeCameraModal();
        }, 'image/jpeg', 0.8);
    }
</script>
@endsection
