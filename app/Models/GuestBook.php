<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestBook extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lengkap',
        'nomor_hp',
        'email',
        'instansi',
        'kategori_tamu',
        'keperluan',
        'nama_opd',
        'nama_pejabat',
        'tanggal_kunjungan',
        'jam_kunjungan',
        'persetujuan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'persetujuan' => 'boolean',
    ];
}
