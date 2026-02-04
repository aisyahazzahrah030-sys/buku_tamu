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
        \Log::info('GuestBook submission started', $request->all());

        // Normalize phone number: 08xx -> 628xx
        if (isset($request->nomor_hp) && str_starts_with($request->nomor_hp, '0')) {
            $request->merge(['nomor_hp' => preg_replace('/^0/', '62', $request->nomor_hp)]);
        }

<<<<<<< HEAD
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'nomor_hp' => 'required|string|regex:/^62[0-9]{9,13}$/',
            'kategori_tamu' => 'required|string',
            'keperluan' => 'required|string',
            'nama_opd' => 'required|string',
            'foto_tamu' => 'nullable|image|max:2048',
            'nama_pejabat' => 'nullable|string|max:100',
            'persetujuan' => 'accepted'
        ], [
            'nomor_hp.regex' => 'Format nomor HP tidak valid! Gunakan format 62xxxxxxxxxx',
            'persetujuan.accepted' => 'Anda harus menyetujui penggunaan data!'
        ]);
=======
        try {
            $validated = $request->validate([
                'nama_lengkap' => 'required|string|max:100',
                'nomor_hp' => 'required|string|regex:/^62[0-9]{9,13}$/',
                'kategori_tamu' => 'required|string',
                'keperluan' => 'required|string',
                'nama_opd' => 'required|string',
                'instansi' => 'nullable|string|max:255',
                'foto_tamu' => 'nullable|image|max:2048',
                'nama_pejabat' => 'nullable|string|max:100',
                'persetujuan' => 'accepted'
            ], [
                'nomor_hp.regex' => 'Format nomor HP tidak valid! Gunakan format 62xxxxxxxxxx',
                'persetujuan.accepted' => 'Anda harus menyetujui penggunaan data!'
            ]);
>>>>>>> 20b6771db46c37f4e65b72021514a667ea17d813

            $data = $request->except(['foto_tamu']);
            $data['persetujuan'] = 1;
            $data['tanggal_kunjungan'] = now()->toDateString();
            $data['jam_kunjungan'] = now()->toTimeString();

            $guest = GuestBook::create($data);
            
            \Log::info('GuestBook saved successfully', ['id' => $guest->id]);

            return redirect()->route('guest.form')->with('success', 'Data buku tamu berhasil disimpan! Terima kasih atas kunjungan Anda.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('GuestBook validation failed', $e->errors());
            throw $e;
        } catch (\Exception $e) {
            \Log::error('GuestBook save failed', ['message' => $e->getMessage()]);
            return back()->withInput()->with('error', 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.');
        }
    }
}
