@extends('layouts.admin')

@section('content')
<div class="edit-container">
    <div class="header-section">
        <h3>✏️ Edit Data Tamu</h3>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            ← Kembali
        </a>
    </div>

    <div class="form-card">
        <form action="{{ route('admin.guests.update', $guest->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $guest->nama_lengkap) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Nomor HP</label>
                <input type="text" name="nomor_hp" value="{{ old('nomor_hp', $guest->nomor_hp) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label>Instansi</label>
                <input type="text" name="instansi" value="{{ old('instansi', $guest->instansi) }}" class="form-control" required>
            </div>

            <div class="form-row">
                <div class="form-group col">
                    <label>Kategori</label>
                    <select name="kategori_tamu" class="form-control" required>
                        @php
                            $kategoris = [
                                'opd-padang' => 'OPD Kota Padang',
                                'pemerintah-lain' => 'Pemerintah Daerah Lain',
                                'umum' => 'Umum'
                            ];
                        @endphp
                        @foreach($kategoris as $val => $label)
                            <option value="{{ $val }}" {{ $guest->kategori_tamu == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col">
                    <label>Tanggal Kunjungan</label>
                    <input type="date" name="tanggal_kunjungan" value="{{ old('tanggal_kunjungan', $guest->tanggal_kunjungan->format('Y-m-d')) }}" class="form-control" required>
                </div>

                <div class="form-group col">
                    <label>Jam Kunjungan</label>
                    <input type="time" name="jam_kunjungan" value="{{ old('jam_kunjungan', \Carbon\Carbon::parse($guest->jam_kunjungan)->format('H:i')) }}" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label>Instansi / OPD</label>
                <input type="text" name="nama_opd" value="{{ old('nama_opd', $guest->nama_opd) }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Keperluan</label>
                <textarea name="keperluan" class="form-control" rows="3" required>{{ old('keperluan', $guest->keperluan) }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .edit-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem;
    }
    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    .btn-back {
        text-decoration: none;
        color: #6c757d;
        font-weight: 600;
    }
    .form-card {
        background: white;
        padding: 2rem;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .form-row {
        display: flex;
        gap: 1.5rem;
    }
    .col {
        flex: 1;
    }
    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #667eea;
        outline: none;
    }
    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #495057;
    }
    .btn-save {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 6px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s;
    }
    .btn-save:hover {
        transform: translateY(-2px);
    }
</style>
@endsection
