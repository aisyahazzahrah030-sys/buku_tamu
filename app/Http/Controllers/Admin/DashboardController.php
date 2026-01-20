<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestBook;

class DashboardController extends Controller
{
    public function index()
    {
        $total_records = GuestBook::count();
        $today_count = GuestBook::whereDate('tanggal_kunjungan', now()->toDateString())->count();
        $guests = GuestBook::latest()->get();

        return view('admin.dashboard.index', compact('total_records', 'today_count', 'guests'));
    }

    public function show($id)
    {
        $guest = GuestBook::findOrFail($id);
        return view('admin.dashboard.detail', compact('guest'));
    }

    public function edit($id)
    {
        $guest = GuestBook::findOrFail($id);
        return view('admin.dashboard.edit', compact('guest'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'nomor_hp' => 'required',
            'instansi' => 'required',
            'kategori_tamu' => 'required',
            'jenis_layanan' => 'required',
            'tanggal_kunjungan' => 'required|date',
            'jam_kunjungan' => 'required',
            'keperluan' => 'required',
        ]);

        $guest = GuestBook::findOrFail($id);
        $guest->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Data tamu berhasil diperbarui');
    }

    public function destroy($id)
    {
        GuestBook::findOrFail($id)->delete();
        return back()->with('success', 'Data berhasil dihapus');
    }

    public function export(Request $request)
    {
        $query = GuestBook::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('instansi', 'like', "%{$request->search}%");
            });
        }
        if ($request->kategori) {
            $query->where('kategori_tamu', $request->kategori);
        }
        if ($request->jenis_layanan) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }
        if ($request->tanggal_awal) {
            $query->whereDate('tanggal_kunjungan', '>=', $request->tanggal_awal);
        }
        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal_kunjungan', '<=', $request->tanggal_akhir);
        }

        $guests = $query->latest()->get();

        $headers = [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="buku_tamu_' . date('Y-m-d') . '.xls"',
        ];

        return response()->stream(function() use ($guests) {
            echo view('admin.dashboard.export', compact('guests'));
        }, 200, $headers);
    }
    public function printReport(Request $request)
    {
        $query = GuestBook::query();

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('instansi', 'like', "%{$request->search}%");
            });
        }
        if ($request->kategori) {
            $query->where('kategori_tamu', $request->kategori);
        }
        if ($request->jenis_layanan) {
            $query->where('jenis_layanan', $request->jenis_layanan);
        }
        if ($request->tanggal_awal) {
            $query->whereDate('tanggal_kunjungan', '>=', $request->tanggal_awal);
        }
        if ($request->tanggal_akhir) {
            $query->whereDate('tanggal_kunjungan', '<=', $request->tanggal_akhir);
        }

        $guests = $query->latest()->get();

        return view('admin.dashboard.print', compact('guests'));
    }
}
