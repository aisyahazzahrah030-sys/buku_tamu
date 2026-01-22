<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kunjungan - Buku Tamu Diskominfo</title>
    <style>
        @media print {
            body { 
                font-size: 12px; 
                margin: 20px;
            }
            .no-print { 
                display: none; 
            }
            .print-break {
                page-break-inside: avoid;
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
        }
        
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
            padding-bottom: 10px;
        }
        
        .header-logo {
            width: 80px;
            height: auto;
        }

        .header-text {
            text-align: center;
            flex-grow: 1;
            padding: 0 20px;
        }
        
        .header-text h1 {
            font-size: 18px;
            margin: 0;
            color: #000;
            text-transform: uppercase;
            line-height: 1.2;
        }
        
        .header-text h2 {
            font-size: 16px;
            margin: 2px 0;
            color: #000;
            text-transform: uppercase;
        }
        
        .header-text p {
            margin: 2px 0;
            font-size: 12px;
        }

        .double-line {
            border-top: 3px solid #000;
            border-bottom: 1px solid #000;
            height: 2px;
            margin-bottom: 20px;
        }
        
        .info-box {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        
        .info-box strong {
            display: inline-block;
            width: 150px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }
        
        th {
            background: #1e3c72;
            color: white;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }
        
        .signature {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
        }
        
        .signature-box {
            text-align: center;
            width: 200px;
        }
        
        .signature-box .line {
            border-bottom: 1px solid #000;
            margin: 30px 0 5px;
        }
        
        .no-print {
            background: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px 0;
            display: inline-block;
            text-decoration: none;
        }
        
        .no-print:hover {
            background: #218838;
        }

        .btn-close {
            background: #dc3545;
            margin-left: 10px;
        }

        .btn-close:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="no-print">
        🖨️ Cetak Laporan
    </button>
    
    <button onclick="window.close()" class="no-print btn-close">
        ✖ Tutup
    </button>
    
    <div class="header">
        <img src="{{ asset('assets/img/logo_padang.png') }}" class="header-logo" alt="Logo Padang">
        <div class="header-text">
            <h1>LAPORAN BUKU TAMU E-GOVERNMENT</h1>
            <h1>DINAS KOMUNIKASI DAN INFORMATIKA</h1>
            <h1>KOTA PADANG</h1>
        </div>
        <img src="{{ asset('assets/img/logo_kominfo.png') }}" class="header-logo" alt="Logo Kominfo">
    </div>
    <div class="double-line"></div>
    
    <div class="info-box">
        <strong>Periode Laporan:</strong> 
        @if(request('tanggal_awal') && request('tanggal_akhir'))
            {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('l, d F Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('l, d F Y') }}
        @elseif(request('tanggal_awal'))
            Dari {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('l, d F Y') }} hingga sekarang
        @elseif(request('tanggal_akhir'))
            Hingga {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('l, d F Y') }}
        @else
            Semua data
        @endif
        <br>
        <strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('l, d F Y H:i:s') }}
        <br>
        <strong>Total Tamu:</strong> {{ $guests->count() }} orang
    </div>
    
    @if(request('search') || request('kategori') || request('jenis_layanan'))
    <div class="info-box">
        <strong>Filter Aktif:</strong><br>
        @if(request('search')) Pencarian: {{ request('search') }}<br> @endif
        @if(request('kategori')) Kategori: {{ request('kategori') }}<br> @endif
    </div>
    @endif
    
    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                <th width="200">Hari, Tanggal</th>
                <th width="150">Nama Lengkap</th>
                <th width="80">No. HP</th>
                <th width="120">Instansi</th>
                <th width="100">Kategori</th>
                <th width="120">Instansi / OPD</th>
                <th width="120">Pejabat Dituju</th>
                <th>Keperluan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guests as $guest)
                <tr class="print-break">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        {{ $guest->tanggal_kunjungan->translatedFormat('l, d F Y') }}
                        <br>{{ \Carbon\Carbon::parse($guest->jam_kunjungan)->format('H:i') }}
                    </td>
                    <td>{{ $guest->nama_lengkap }}</td>
                    <td>{{ $guest->nomor_hp }}</td>
                    <td>{{ $guest->instansi }}</td>
                    <td>{{ $guest->kategori_tamu }}</td>
                    <td>{{ $guest->nama_opd }}</td>
                    <td>{{ $guest->nama_pejabat }}</td>
                    <td>{{ Str::limit($guest->keperluan, 100) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p><em>Laporan ini dicetak secara otomatis dari Sistem Buku Tamu e-Government</em></p>
        <p>© {{ date('Y') }} Dinas Komunikasi dan Informatika Kota Padang</p>
    </div>
    
    <div class="signature">
        <div class="signature-box">
            <p>Mengetahui,</p>
            <p>Kepala Dinas</p>
            <p>Komunikasi dan Informatika</p>
            <p>Kota Padang</p>
            <div class="line"></div>
            <p><strong>(Nama Kepala Dinas)</strong></p>
            <p>NIP. 1234567890123456</p>
        </div>
        
        <div class="signature-box">
            <p>Padang, {{ now()->translatedFormat('d F Y') }}</p>
            <p>Petugas Administrasi</p>
            <div class="line"></div>
            <p><strong>{{ auth()->user()->name ?? 'Admin' }}</strong></p>
            <p>NIP. 1234567890123456</p>
        </div>
    </div>
</body>
</html>
