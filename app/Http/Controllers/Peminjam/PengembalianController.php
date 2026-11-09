<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PengembalianController extends Controller
{
    // PEMINJAM MENGAJUKAN PENGEMBALIAN
    public function ajukan($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $peminjaman = Peminjaman::where(
                    'id_peminjaman',
                    $id
                )->where('user_id', auth()->id())
                 ->lockForUpdate()
                 ->firstOrFail();

                if ($peminjaman->status !== 'disetujui') {
                    throw new RuntimeException(
                        'Peminjaman ini belum bisa dikembalikan.'
                    );
                }

                Pengembalian::create([
                    'id_peminjaman' => $peminjaman->id_peminjaman,
                    'tanggal_pengembalian' => null,
                    'denda' => 0,
                ]);

                $peminjaman->update([
                    'status' => 'menunggu_pengembalian',
                ]);
            });

        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return back()->with(
            'success',
            'Pengajuan pengembalian berhasil dikirim. Silakan serahkan alat kepada Petugas.'
        );
    }
}
