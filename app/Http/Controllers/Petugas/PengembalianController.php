<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PengembalianController extends Controller
{
    // DAFTAR PENGEMBALIAN
    public function index()
    {
        $pengembalian = \App\Models\Pengembalian::with([
            'peminjaman.user',
            'peminjaman.detailPeminjaman.alat'
        ])->latest()->get();

        return view(
            'petugas.pengembalian.index',
            compact('pengembalian')
        );
    }

    // PETUGAS MENGONFIRMASI PENGEMBALIAN
    public function konfirmasi(Request $request, $id)
    {
        // Validasi denda yang dimasukkan Petugas
        $request->validate([
            'denda' => 'required|integer|min:0',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {

                $peminjaman = Peminjaman::where(
                    'id_peminjaman',
                    $id
                )->lockForUpdate()->firstOrFail();

                if ($peminjaman->status !== 'menunggu_pengembalian') {
                    throw new RuntimeException(
                        'Pengembalian ini sudah diproses atau belum diajukan.'
                    );
                }

                $pengembalian = $peminjaman->pengembalian;

                if (!$pengembalian || $pengembalian->tanggal_pengembalian !== null) {
                    throw new RuntimeException(
                        'Data pengembalian tidak valid.'
                    );
                }

                // Tanggal pengembalian menggunakan tanggal konfirmasi
                $tanggalKembali = now()->toDateString();

                // Kembalikan stok alat
                foreach ($peminjaman->detailPeminjaman as $detail) {

                    $alat = $detail->alat()
                        ->lockForUpdate()
                        ->firstOrFail();

                    $alat->increment('stok', $detail->jumlah);
                }

                // Simpan tanggal dan denda dari Petugas
               $pengembalian->update([
    'tanggal_pengembalian' => $peminjaman->tanggal_batas_kembali,
    'denda' => $request->denda,
]);

                // Ubah status peminjaman
                $peminjaman->update([
                    'status' => 'dikembalikan',
                ]);
            });

        } catch (RuntimeException $e) {

            return back()->with('error', $e->getMessage());

        }

        return back()->with(
            'success',
            'Pengembalian berhasil dikonfirmasi. Stok dan denda berhasil diperbarui.'
        );
    }
}
