<style>
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
    .photo-preview-detail {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        margin-top: 0.5rem;
    }
</style>

<div class="detail-row">
    <div class="detail-label">Nama Lengkap</div>
    <div class="detail-value">{{ $guest->nama_lengkap }}</div>
</div>
<div class="detail-row">
    <div class="detail-label">Nomor HP</div>
    <div class="detail-value">{{ $guest->nomor_hp }}</div>
</div>
<div class="detail-row">
    <div class="detail-label">Email</div>
    <div class="detail-value">{{ $guest->email ?: '-' }}</div>
</div>
<div class="detail-row">
    <div class="detail-label">Instansi</div>
    <div class="detail-value">{{ $guest->instansi }}</div>
</div>
<div class="detail-row">
    <div class="detail-label">Kategori Tamu</div>
    <div class="detail-value">{{ $guest->kategori_tamu }}</div>
</div>
<div class="detail-row">
    <div class="detail-label">Jenis Layanan</div>
    <div class="detail-value">{{ $guest->jenis_layanan }}</div>
</div>
<div class="detail-row">
    <div class="detail-label">Keperluan</div>
    <div class="detail-value">{{ $guest->keperluan }}</div>
</div>
<div class="detail-row">
    <div class="detail-label">Waktu Kunjungan</div>
    <div class="detail-value">{{ $guest->tanggal_kunjungan->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($guest->jam_kunjungan)->format('H:i') }}</div>
</div>
@if($guest->foto_tamu)
<div class="detail-row">
    <div class="detail-label">Foto Tamu</div>
    <div class="detail-value">
        <img src="{{ asset('storage/' . $guest->foto_tamu) }}" alt="Foto Tamu" class="photo-preview-detail">
    </div>
</div>
@endif
