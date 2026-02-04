<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kunjungan - Buku Tamu Diskominfo</title>
    <style>
        @page {
            margin: 0;
        }
        @media print {
            body { 
                font-size: 12px; 
                margin: 2cm;
            }
            .no-print { 
                display: none !important; 
            }
            .print-break {
                page-break-inside: avoid;
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.4;
            color: #000; /* Hitam pekat */
        }
        
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 5px;
            padding-bottom: 10px;
        }
        
        .header-logo {
<<<<<<< HEAD
            height: 85px;
=======
<<<<<<< HEAD
            width: 70px;
            height: auto;
=======
            height: 100px;
>>>>>>> 0f4d7ad561b1c0fb9671f0834d99deb380977c31
            width: auto;
>>>>>>> e5993d63a6d54bf1faaaa67d81e44c8f8629a51a
        }

        .header-text {
            text-align: center;
            flex-grow: 1;
            padding: 0 10px;
        }
        
        .header-text h1 {
            font-size: 16px;
            margin: 0;
            color: #000;
            text-transform: uppercase;
            line-height: 1.2;
<<<<<<< HEAD
            letter-spacing: 0.5px;
        }
        
        .header-text h2 {
            font-size: 14px;
            margin: 2px 0;
            color: #000;
            text-transform: uppercase;
        }
        
        .header-text p {
            margin: 2px 0;
            font-size: 12px;
        }

=======
            font-weight: bold;
        }
        
>>>>>>> 0f4d7ad561b1c0fb9671f0834d99deb380977c31
        .double-line {
            border-top: 2px solid #000;
            border-bottom: 1px solid #000;
            height: 1.5px;
            margin-bottom: 15px;
        }
        
        .info-box {
            background: #fff;
            border: 1px solid #000; /* Border hitam pekat */
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
            font-size: 11px;
            color: #000;
        }
        
        .info-box strong {
            display: inline-block;
            width: 120px;
            font-weight: bold;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        
        th, td {
            border: 1px solid #000; /* Border hitam pekat */
            padding: 6px 4px;
            text-align: left;
            vertical-align: middle;
            font-size: 10px;
            word-wrap: break-word;
            text-transform: capitalize;
            color: #000;
        }
        
        th {
            background: #fff; /* Latar putih agar garis hitam jelas */
            color: #000;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        
        .no-cap {
            text-transform: none !important;
        }
        
        .text-center {
            text-align: center;
        }
        
<<<<<<< HEAD
        tr:nth-child(even) {
            background: #fff; /* Hilangkan warna selang-seling */
=======
        .text-right {
            text-align: right;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }
        
        .no-print {
            margin: 20px 0;
            display: inline-block;
            text-decoration: none;
        }
        
        .btn-close {
            background: #dc3545;
            margin-left: 10px;
>>>>>>> e5993d63a6d54bf1faaaa67d81e44c8f8629a51a
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 11px;
            color: #000;
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px; text-align: right; padding: 0 20px;">
        <button onclick="window.print()" class="no-print" style="padding: 10px 20px; border: none; border-radius: 5px; background: #28a745; color: white; cursor: pointer; font-size: 16px;">🖨️ Cetak Laporan</button>
        <button onclick="window.close()" class="no-print btn-close" style="padding: 10px 20px; border: none; border-radius: 5px; background: #dc3545; color: white; cursor: pointer; font-size: 16px; margin-left: 10px;">Tutup</button>
    </div>
    <div class="header">
        <img src="{{ asset('assets/img/logo_padang_baru.jpg') }}?v={{ time() }}" class="header-logo" alt="Logo Padang">
        <div class="header-text">
            <h1>LAPORAN BUKU TAMU E-GOVERNMENT</h1>
            <h2>DINAS KOMUNIKASI DAN INFORMATIKA</h2>
            <h2>KOTA PADANG</h2>
        </div>
        <img src="{{ asset('assets/img/logo_kominfo_baru.jpg') }}?v={{ time() }}" class="header-logo" alt="Logo Kominfo">
    </div>
    <div class="double-line"></div>
    
    <div class="info-box">
        <strong>Periode Laporan:</strong> 
        @if(request('tanggal_awal') && request('tanggal_akhir'))
            {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y') }}
        @elseif(request('tanggal_awal'))
            Dari {{ \Carbon\Carbon::parse(request('tanggal_awal'))->translatedFormat('d F Y') }} hingga sekarang
        @elseif(request('tanggal_akhir'))
            Hingga {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->translatedFormat('d F Y') }}
        @else
            Semua data
        @endif
        <br>
        <strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y H:i:s') }}
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
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">Waktu</th>
                <th style="width: 15%;">Nama Tamu</th>
                <th style="width: 10%;">No. HP</th>
                <th style="width: 10%;">Kategori</th>
                <th style="width: 15%;">Asal Instansi</th>
                <th style="width: 14%;">Tujuan / Pejabat</th>
                <th style="width: 20%;">Keperluan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guests as $guest)
                @php
                    $kategoriLabels = [
                        'opd-padang' => 'OPD Kota Padang',
                        'pemerintah-lain' => 'Pemerintah Lain',
                        'umum' => 'Umum'
                    ];
                    $label = $kategoriLabels[$guest->kategori_tamu] ?? $guest->kategori_tamu;
                @endphp
                <tr class="print-break">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="no-cap">
                        {{ $guest->tanggal_kunjungan->translatedFormat('d/m/Y') }}<br>
                        {{ \Carbon\Carbon::parse($guest->jam_kunjungan)->format('H:i') }}
                    </td>
                    <td><strong>{{ $guest->nama_lengkap }}</strong></td>
                    <td class="no-cap text-center" style="font-size: 9px;">{{ $guest->nomor_hp }}</td>
                    <td class="text-center">{{ $label }}</td>
                    <td>{{ $guest->instansi ?: $guest->nama_opd }}</td>
                    <td>{{ $guest->nama_pejabat ?: '-' }}</td>
                    <td class="no-cap">{{ Str::limit($guest->keperluan, 150) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    
    <div class="footer">
        <p><em>Laporan ini dicetak secara otomatis dari Sistem Buku Tamu e-Government</em></p>
        <p>© {{ date('Y') }} Dinas Komunikasi dan Informatika Kota Padang</p>
    </div>
</body>
</html>
