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

            <div class="form-group" id="infoKunjunganGroup">
                <label for="namaOpd" id="labelInformasi">Nama OPD *</label>
                
                <!-- Input untuk OPD Kota Padang -->
                <div id="containerOpdPadang">
                    <input type="text" id="namaOpd" name="nama_opd" list="opdList" 
                           placeholder="Contoh: DINAS KOMUNIKASI DAN INFORMATIKA" 
                           value="{{ old('nama_opd') }}" required>
                    <datalist id="opdList">
                        <option value="INSPEKTORAT">
                        <option value="SEKRETARIAT DPRD">
                        <option value="BADAN KESATUAN BANGSA POLITIK">
                        <option value="BADAN PERENCANAAN PEMBANGUNAN DAERAH (BAPPEDA)">
                        <option value="BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH (BPKAD)">
                        <option value="BADAN KEPEGAWAIAN DAN PENGEMBANGAN SDM (BKPSDM)">
                        <option value="BADAN PENANGGULANGAN BENCANA DAERAH (BPBD)">
                        <option value="BADAN PENDAPATAN DAERAH (BAPENDA)">
                        <option value="SATUAN POLISI PAMONG PRAJA (SATPOL PP)">
                        <option value="DINAS LINGKUNGAN HIDUP (DLH)">
                        <option value="DINAS SOSIAL">
                        <option value="BAGIAN PENGADAAN BARANG/JASA">
                        <option value="BAGIAN TATA PEMERINTAHAN">
                        <option value="BAGIAN HUKUM">
                        <option value="BAGIAN ADMINISTRASI PEMBANGUNAN DAN PERENCANAAN">
                        <option value="BAGIAN KESEJAHTERAAN RAKYAT (KESRA)">
                        <option value="BAGIAN ORGANISASI">
                        <option value="BAGIAN PROTOKOL DAN KOMUNIKASI PIMPINAN (PROKOPIM)">
                        <option value="BAGIAN KERJASAMA">
                        <option value="KECAMATAN PADANG BARAT">
                        <option value="KECAMATAN PADANG TIMUR">
                        <option value="KECAMATAN PADANG SELATAN">
                        <option value="KECAMATAN PADANG UTARA">
                        <option value="KECAMATAN NANGGALO">
                        <option value="KECAMATAN PAUH">
                        <option value="KECAMATAN KOTO TANGAH">
                        <option value="KECAMATAN LUBUK BEGALUNG">
                        <option value="KECAMATAN LUBUK KILANGAN">
                        <option value="KECAMATAN KURANJI">
                        <option value="KECAMATAN BUNGUS TELUK KABUNG">
                        <option value="UNIT ORGANISASI BERSIFAT KHUSUS RUMAH SAKIT UMUM DAERAH dr. RASIDIN">
                    </datalist>
                    <small>Ketik nama OPD atau pilih dari saran yang muncul</small>
                </div>

                <div id="containerGovSumbar" style="display: none;">
                    <select id="namaGovSumbar" name="nama_gov_sumbar" class="select2-gov" disabled>
                        <option value="">-- Pilih Pemerintah Daerah --</option>
                        @php
                            $govs = [
                                'Pemerintah Provinsi Sumatera Barat', 'Pemerintah Kota Padang', 'Pemerintah Kota Bukittinggi',
                                'Pemerintah Kota Padang Panjang', 'Pemerintah Kota Pariaman', 'Pemerintah Kota Payakumbuh',
                                'Pemerintah Kota Sawahlunto', 'Pemerintah Kota Solok', 'Pemerintah Kabupaten Agam',
                                'Pemerintah Kabupaten Dharmasraya', 'Pemerintah Kabupaten Kepulauan Mentawai',
                                'Pemerintah Kabupaten Lima Puluh Kota', 'Pemerintah Kabupaten Padang Pariaman',
                                'Pemerintah Kabupaten Pasaman', 'Pemerintah Kabupaten Pasaman Barat',
                                'Pemerintah Kabupaten Pesisir Selatan', 'Pemerintah Kabupaten Sijunjung',
                                'Pemerintah Kabupaten Solok', 'Pemerintah Kabupaten Solok Selatan',
                                'Pemerintah Kabupaten Tanah Datar'
                            ];
                        @endphp
                        @foreach($govs as $gov)
                            <option value="{{ $gov }}" {{ old('nama_opd') == $gov ? 'selected' : '' }}>{{ $gov }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Input Teks untuk Umum/Lainnya -->
                <div id="containerManualInfo" style="display: none;">
                    <input type="text" id="manualInfo" name="manual_info" 
                           placeholder="Masukkan nama instansi / informasi" 
                           value="{{ old('nama_opd') }}" disabled>
                </div>
            </div>

            <div class="form-group" id="pejabatGroup">
                <label for="namaPejabat">Nama Pejabat/Kepala OPD</label>
                <input type="text" id="namaPejabat" name="nama_pejabat" 
                       placeholder="Masukkan nama pejabat" 
                       value="{{ old('nama_pejabat') }}">
                <small>Silakan isi nama pejabat yang dituju</small>
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



            <div class="section-title">
                <i class="fas fa-shield-alt"></i>
                <h3>E. Persetujuan</h3>
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
    // Initialize Select2 untuk Gov dropdown
    $(document).ready(function() {
        $('.select2-gov').select2({
            placeholder: '-- Pilih --',
            allowClear: true,
            width: '100%'
        });

        // Toggle info Berdasarkan Kategori
        $('#kategoriTamu').on('change', function() {
            const kategori = $(this).val();
            const label = $('#labelInformasi');
            const podPadang = $('#containerOpdPadang');
            const govSumbar = $('#containerGovSumbar');
            const manualInfo = $('#containerManualInfo');
            const pejabatGroup = $('#pejabatGroup');

            // Reset input statuses
            $('#namaOpd').prop('disabled', true).prop('required', false);
            $('#namaGovSumbar').prop('disabled', true).prop('required', false);
            $('#manualInfo').prop('disabled', true).prop('required', false);
            
            podPadang.hide();
            govSumbar.hide();
            manualInfo.hide();
            pejabatGroup.hide();

            if (kategori === 'opd-padang') {
                label.text('Nama OPD *');
                podPadang.show();
                pejabatGroup.show();
                $('#namaOpd').prop('disabled', false).prop('required', true).attr('name', 'nama_opd');
            } else if (kategori === 'pemerintah-lain') {
                label.text('Nama Pemerintah Daerah *');
                govSumbar.show();
                $('#namaGovSumbar').prop('disabled', false).prop('required', true).attr('name', 'nama_opd');
            } else {
                label.text('Nama Instansi / Informasi Kunjungan *');
                manualInfo.show();
                $('#manualInfo').prop('disabled', false).prop('required', true).attr('name', 'nama_opd');
            }
        });

        // Trigger change untuk initial state
        $('#kategoriTamu').trigger('change');
    });



    function resetForm() {
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


</script>
@endsection
