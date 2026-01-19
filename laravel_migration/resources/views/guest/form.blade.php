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
                       placeholder="628123456789"
                       pattern="[0-9]{10,14}"
                       value="{{ old('nomor_hp') }}">
                <small>Keterangan: Diawali kode negara (62…)</small>
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
                    <option value="mahasiswa-akademisi" {{ old('kategori_tamu') == 'mahasiswa-akademisi' ? 'selected' : '' }}>Mahasiswa / Akademisi</option>
                    <option value="perusahaan-vendor" {{ old('kategori_tamu') == 'perusahaan-vendor' ? 'selected' : '' }}>Perusahaan / Vendor</option>
                    <option value="masyarakat-umum" {{ old('kategori_tamu') == 'masyarakat-umum' ? 'selected' : '' }}>Masyarakat Umum</option>
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

            <div class="form-group">
                <label for="sistemTerkait">Sistem / Aplikasi Terkait (Jika Ada)</label>
                <input type="text" id="sistemTerkait" name="sistem_terkait" 
                       placeholder="Contoh: Website OPD, SIMPEG, SIPD" value="{{ old('sistem_terkait') }}">
            </div>

            <div class="form-group">
                <label for="pegawaiDituju">Pegawai e-Government yang Dituju (Opsional)</label>
                <input type="text" id="pegawaiDituju" name="pegawai_dituju" 
                       placeholder="Contoh: Tim Programmer e-Gov" value="{{ old('pegawai_dituju') }}">
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
</script>
@endsection
