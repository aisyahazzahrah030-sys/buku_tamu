<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kunjungan - Buku Tamu Diskominfo</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm;
        }
        @media print {
            body { 
                font-size: 11px;
                margin: 0;
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
            color: #000;
            margin: 0;
            padding: 0;
        }

        .no-print-container {
            margin-bottom: 20px;
            text-align: left;
            padding: 20px;
        }
        
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
            width: 100%;
        }
        
        .header-logo {
            height: 95px;
            width: auto;
            flex-shrink: 0;
        }

        .header-text {
            text-align: center;
            flex-grow: 1;
            padding: 0 15px;
        }
        
        .header-text h1 {
            font-size: 21px;
            margin: 0;
            color: #000;
            text-transform: uppercase;
            line-height: 1.1;
            font-weight: bold;
            letter-spacing: 1px;
            white-space: nowrap;
        }
        
        .header-text h2 {
            font-size: 16px;
            margin: 5px 0;
            color: #000;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .double-line {
            border-top: 2px solid #000;
            border-bottom: 0.5px solid #000;
            height: 2px;
            margin-bottom: 20px;
        }
        
        .info-box {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 20px;
            font-size: 11px;
        }
        
        .info-box strong {
            display: inline-block;
            width: 130px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            table-layout: fixed;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 6px 4px;
            text-align: left;
            vertical-align: top;
            font-size: 10px;
            word-wrap: break-word;
        }
        
        th {
            background: #f2f2f2;
            color: #000;
            font-weight: bold;
            text-align: center;
            text-transform: uppercase;
        }
        
        .text-center {
            text-align: center;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-print { background: #28a745; }
        .btn-close { background: #dc3545; margin-left: 10px; }
    </style>
</head>
<body>
    <div class="no-print no-print-container">
        <button onclick="window.print()" class="btn btn-print">🖨️ Cetak Laporan</button>
        <button onclick="window.close()" class="btn btn-close">Tutup</button>
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
        @php
            $start = request('tanggal_awal') ? \Carbon\Carbon::parse(request('tanggal_awal')) : null;
            $end = request('tanggal_akhir') ? \Carbon\Carbon::parse(request('tanggal_akhir')) : null;
            
            $period = 'Semua data';
            if ($start && $end) {
                if ($start->isSameDay($end)) {
                    $period = $start->translatedFormat('d F Y');
                } elseif ($start->isSameMonth($end) && $start->isSameYear($end)) {
                    $period = $start->format('d') . ' - ' . $end->translatedFormat('d F Y');
                } elseif ($start->isSameYear($end)) {
                    $period = $start->translatedFormat('d F') . ' - ' . $end->translatedFormat('d F Y');
                } else {
                    $period = $start->translatedFormat('d F Y') . ' - ' . $end->translatedFormat('d F Y');
                }
            } elseif ($start) {
                $period = 'Dari ' . $start->translatedFormat('d F Y');
            } elseif ($end) {
                $period = 'Hingga ' . $end->translatedFormat('d F Y');
            }
        @endphp
        {{ $period }}
        <br>
        <strong>Tanggal Cetak:</strong> {{ now()->translatedFormat('d F Y') }}
        <br>
        <strong>Waktu Cetak:</strong> {{ now()->format('H:i') }}
        <br>
        <strong>Total Tamu:</strong> {{ $guests->count() }} orang
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 80px;">Waktu</th>
                <th style="width: 120px;">Nama Tamu</th>
                <th style="width: 90px;">No. HP</th>
                <th style="width: 90px;">Kategori</th>
                <th style="width: 120px;">Instansi / OPD</th>
                <th style="width: 100px;">Tujuan</th>
                <th>Keperluan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($guests as $guest)
                @php
                    $kategoriLabels = [
                        'opd-padang' => 'OPD Padang',
                        'pemerintah-lain' => 'Pem. Lain',
                        'umum' => 'Umum'
                    ];
                    $label = $kategoriLabels[$guest->kategori_tamu] ?? $guest->kategori_tamu;
                @endphp
                <tr class="print-break">
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">
                        {{ $guest->tanggal_kunjungan->format('d/m/Y') }}<br>
                        {{ \Carbon\Carbon::parse($guest->jam_kunjungan)->format('H:i') }}
                    </td>
                    <td><strong>{{ $guest->nama_lengkap }}</strong></td>
                    <td class="text-center">{{ $guest->nomor_hp }}</td>
                    <td class="text-center">{{ $label }}</td>
                    <td>{{ $guest->instansi ?: $guest->nama_opd }}</td>
                    <td>{{ $guest->nama_pejabat ?: '-' }}</td>
                    <td>{{ Str::limit($guest->keperluan, 150) }}</td>
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
</body>
</html>
