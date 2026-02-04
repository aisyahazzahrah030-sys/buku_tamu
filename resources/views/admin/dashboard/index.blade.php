@extends('layouts.admin')

@section('content')
<!-- Stats Cards -->
<div class="stats-cards">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-content">
            <h3>{{ $total_records }}</h3>
            <p>Total Tamu</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📅</div>
        <div class="stat-content">
            <h3>{{ $today_count }}</h3>
            <p>Hari Ini</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📊</div>
        <div class="stat-content">
            <h3>{{ $total_records }}</h3>
            <p>Minggu Ini</p>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📈</div>
        <div class="stat-content">
            <h3>{{ $total_records }}</h3>
            <p>Bulan Ini</p>
        </div>
    </div>
</div>

<!-- Data Section -->
<div class="data-section">
    <div class="section-header" style="flex-wrap: wrap; gap: 1rem;">
        <h3>📋 Data Buku Tamu</h3>
        
        <form action="{{ route('admin.dashboard') }}" method="GET" class="filter-form" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
            <div class="date-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <label for="tanggal_awal" style="font-size: 0.875rem; color: #6c757d;">Dari:</label>
                <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ request('tanggal_awal') }}" class="form-control" style="padding: 0.4rem; border: 1px solid #ced4da; border-radius: 4px;" onchange="this.form.submit()">
            </div>
            <div class="date-group" style="display: flex; align-items: center; gap: 0.5rem;">
                <label for="tanggal_akhir" style="font-size: 0.875rem; color: #6c757d;">Sampai:</label>
                <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="form-control" style="padding: 0.4rem; border: 1px solid #ced4da; border-radius: 4px;" onchange="this.form.submit()">
            </div>
            <button type="submit" class="btn-filter" style="display: none; padding: 0.4rem 1rem; border: none; border-radius: 4px; background: #667eea; color: white; cursor: pointer;">
                🔍 Filter
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn-reset" style="padding: 0.4rem 1rem; text-decoration: none; border: 1px solid #6c757d; border-radius: 4px; color: #6c757d;">
                Reset
            </a>
        </form>

        <div class="export-buttons">
            <a href="{{ route('admin.guests.export', request()->query()) }}" class="btn-export">
                📊 Export Excel
            </a>
            <a href="{{ route('admin.guests.print', request()->query()) }}" class="btn-export" target="_blank" style="background: #17a2b8;">
                🖨️ Cetak Laporan
            </a>
        </div>
    </div>
    
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Lengkap</th>
                    <th>Kategori</th>
                    <th>Instansi Tujuan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <strong>{{ $guest->nama_lengkap }}</strong><br>
                            <small>{{ $guest->nomor_hp }}</small>
                        </td>
                        <td><span class="badge">{{ $guest->kategori_tamu }}</span></td>
                        <td>{{ $guest->nama_opd }} @if($guest->nama_pejabat)<br><small>({{ $guest->nama_pejabat }})</small>@endif</td>
                        <td>{{ $guest->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($guest->jam_kunjungan)->format('H:i') }}</td>
                        <td>
                            <button class="btn-view" onclick="viewDetail({{ $guest->id }})">
                                👁️
                            </button>
                            <a href="{{ route('admin.guests.edit', $guest->id) }}" class="btn-edit" style="text-decoration:none; display:inline-block;">
                                ✏️
                            </a>
                            <form action="{{ route('admin.guests.destroy', $guest->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">
                                    🗑️
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align:center;">Tidak ada data ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Detail Modal -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Detail Tamu</h3>
            <button class="modal-close" onclick="closeModal()">&times;</button>
        </div>
        <div class="modal-body" id="detailContent">
            Loading...
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    /* Reuse dashboard styles from original project */
    .dashboard-container {
        padding: 0 2rem;
    }
    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .stat-icon {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .stat-content h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #495057;
        margin-bottom: 0.2rem;
    }
    .stat-content p {
        color: #6c757d;
        font-size: 0.875rem;
    }
    .data-section {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #e9ecef;
    }
    .export-buttons {
        display: flex;
        gap: 0.5rem;
    }
    .btn-export {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
        color: white;
        background: #28a745;
        transition: all 0.3s ease;
    }
    .btn-export:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    }
    .table-container {
        overflow-x: auto;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    .data-table th,
    .data-table td {
        padding: 0.75rem;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }
    .data-table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #495057;
    }
    .badge {
        background: #e9ecef;
        color: #495057;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        font-size: 0.75rem;
    }
    .btn-view,
    .btn-delete {
        padding: 0.25rem 0.5rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 0.25rem;
        background: #17a2b8;
        color: white;
    }
    .btn-delete {
        background: #dc3545;
    }
    .btn-edit {
        padding: 0.25rem 0.5rem;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 0.25rem;
        background: #ffc107;
        color: white !important;
    }
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        align-items: center;
        justify-content: center;
    }
    .modal-content {
        background: white;
        border-radius: 10px;
        max-width: 600px;
        width: 90%;
        max-height: 80vh;
        overflow-y: auto;
    }
    .modal-header {
        padding: 1.5rem;
        border-bottom: 1px solid #dee2e6;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6c757d;
    }
    .modal-body {
        padding: 1.5rem;
    }
</style>
<script>
    function viewDetail(id) {
        // Fetch detail using AJAX
        fetch(`{{ url('admin/guests') }}/${id}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('detailContent').innerHTML = html;
                document.getElementById('detailModal').style.display = 'flex';
            });
    }

    function closeModal() {
        document.getElementById('detailModal').style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            event.target.style.display = 'none';
        }
    }
</script>
@endsection
