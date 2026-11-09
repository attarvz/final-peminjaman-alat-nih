<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with([
            'user',
            'detailPeminjaman.alat',
            'pengembalian',
        ])
        ->whereHas('pengembalian')
        ->latest()
        ->get();

        if (auth()->user()->role === 'admin') {
            return view(
                'admin.pengembalian.index',
                compact('peminjaman')
            );
        }

        return view(
            'petugas.pengembalian.index',
            compact('peminjaman')
        );
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'tanggal_pengembalian' => 'required|date',
            'denda' => 'required|integer|min:0',
        ]);

        $peminjaman = Peminjaman::with('detailPeminjaman')
            ->findOrFail($id);

        if ($peminjaman->status !== 'disetujui') {
            return back()->with(
                'error',
                'Peminjaman ini tidak dapat dikembalikan.'
            );
        }

        if (Pengembalian::where('id_peminjaman', $id)->exists()) {
            return back()->with(
                'error',
                'Peminjaman ini sudah dikembalikan.'
            );
        }

        DB::transaction(function () use ($request, $peminjaman) {
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $alat = Alat::where('id_alat', $detail->id_alat)
                    ->lockForUpdate()
                    ->firstOrFail();

                $alat->increment('stok', $detail->jumlah);
            }

            Pengembalian::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'tanggal_pengembalian' => $request->tanggal_pengembalian,
                'denda' => $request->denda,
            ]);

            $peminjaman->update([
                'status' => 'dikembalikan',
            ]);
        });

        return redirect('/petugas/pengembalian')
            ->with('success', 'Pengembalian berhasil dicatat.');
    }
}