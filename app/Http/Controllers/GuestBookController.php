<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestBook;

class GuestBookController extends Controller
{
    public function index()
    {
        return view('guest.form');
    }

    public function store(Request $request)
    {
        // Normalize phone number: 08xx -> 628xx
        if (isset($request->nomor_hp) && str_starts_with($request->nomor_hp, '0')) {
            $request->merge(['nomor_hp' => preg_replace('/^0/', '62', $request->nomor_hp)]);
        }

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nomor_hp' => 'required|string|regex:/^62[0-9]{9,13}$/',
            'email' => 'nullable|email|max:100',
            'instansi' => 'required|string|max:100',
            'kategori_tamu' => 'required|string',
            'keperluan' => 'required|string',
            'nama_opd' => 'required|string',
            'nama_pejabat' => 'nullable|string|max:100',
            'foto_tamu' => 'nullable|image|max:2048',
            'persetujuan' => 'accepted'
        ], [
            'nomor_hp.regex' => 'Format nomor HP tidak valid! Gunakan format 62xxxxxxxxxx',
            'persetujuan.accepted' => 'Anda harus menyetujui penggunaan data!'
        ]);

        $data = $request->except(['foto_tamu']);
        $data['persetujuan'] = 1;
        $data['tanggal_kunjungan'] = now()->toDateString();
        $data['jam_kunjungan'] = now()->toTimeString();

        GuestBook::create($data);

        return redirect()->route('guest.form')->with('success', 'Data buku tamu berhasil disimpan! Terima kasih atas kunjungan Anda.');
    }
}
