<table border='1'>
    <tr>
        <td colspan="15" style="text-align: center; font-weight: bold; font-size: 14pt;">LAPORAN BUKU TAMU</td>
    </tr>
    <tr>
        <td colspan="15" style="text-align: center;">
            Periode: 
            @if(request('tanggal_awal') && request('tanggal_akhir'))
                {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }} - {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}
            @elseif(request('tanggal_awal'))
                Dari {{ \Carbon\Carbon::parse(request('tanggal_awal'))->format('d/m/Y') }}
            @elseif(request('tanggal_akhir'))
                Sampai {{ \Carbon\Carbon::parse(request('tanggal_akhir'))->format('d/m/Y') }}
            @else
                Semua Data
            @endif
        </td>
    </tr>
    <tr>
        <th>No</th>
        <th>Nama Lengkap</th>
        <th>Nomor HP</th>
        <th>Email</th>
        <th>Instansi</th>
        <th>Kategori Tamu</th>
        <th>Keperluan</th>
        <th>Instansi/OPD</th>
        <th>Pejabat Dituju</th>
        <th>Tanggal Kunjungan</th>
        <th>Jam Kunjungan</th>
        <th>Persetujuan</th>
        <th>Dibuat</th>
    </tr>
    @foreach($guests as $guest)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $guest->nama_lengkap }}</td>
        <td>{{ $guest->nomor_hp }}</td>
        <td>{{ $guest->email }}</td>
        <td>{{ $guest->instansi }}</td>
        <td>{{ $guest->kategori_tamu }}</td>
        <td>{{ $guest->keperluan }}</td>
        <td>{{ $guest->nama_opd }}</td>
        <td>{{ $guest->nama_pejabat }}</td>
        <td>{{ $guest->tanggal_kunjungan->format('d/m/Y') }}</td>
        <td>{{ \Carbon\Carbon::parse($guest->jam_kunjungan)->format('H:i') }}</td>
        <td>{{ $guest->persetujuan ? 'Ya' : 'Tidak' }}</td>
        <td>{{ $guest->created_at->format('d/m/Y H:i:s') }}</td>
    </tr>
    @endforeach
</table>
