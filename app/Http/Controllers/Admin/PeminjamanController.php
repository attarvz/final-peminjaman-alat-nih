<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Alat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class PeminjamanController extends Controller
{
    // DAFTAR PEMINJAMAN
    public function index()
    {
        $role = auth()->user()->role;

        $query = Peminjaman::with([
            'user',
            'detailPeminjaman.alat'
        ])->latest();

        if ($role === 'peminjam') {
            $query->where('user_id', auth()->id());
        }

        $peminjaman = $query->get();

        if ($role === 'admin') {
            return view('admin.peminjaman.index', compact('peminjaman'));
        }

        if ($role === 'petugas') {
            return view('petugas.peminjaman.index', compact('peminjaman'));
        }

        return view('peminjam.peminjaman.index', compact('peminjaman'));
    }


    // HAPUS SEMUA RIWAYAT PEMINJAMAN
public function destroyAll()
{
    DB::transaction(function () {
        // Hapus data pengembalian terlebih dahulu
        \App\Models\Pengembalian::query()->delete();

        // Hapus detail setiap peminjaman
        DetailPeminjaman::query()->delete();

        // Hapus semua data peminjaman
        Peminjaman::query()->delete();
    });

    return redirect('/admin/peminjaman')
        ->with('success', 'Semua riwayat peminjaman berhasil dihapus.');
}


    // FORM PENGAJUAN
public function create()
{
    $alat = Alat::where('stok', '>', 0)->get();

    return view('peminjam.peminjaman.create', compact('alat'));
}


// SIMPAN PENGAJUAN PEMINJAM
public function store(Request $request)
{
    $request->validate([
        'tanggal_pinjam' => 'required|date|after_or_equal:today',
        'tanggal_batas_kembali' => 'required|date|after:tanggal_pinjam',
        'id_alat' => 'required|exists:alat,id_alat',
        'jumlah' => 'required|integer|min:1',
    ]);

    try {
        DB::transaction(function () use ($request) {

            $alat = Alat::where('id_alat', $request->id_alat)
                ->lockForUpdate()
                ->firstOrFail();

            if ($alat->stok < $request->jumlah) {
                throw new RuntimeException(
                    'Jumlah alat melebihi stok yang tersedia.'
                );
            }

            $peminjaman = Peminjaman::create([
                'user_id' => auth()->id(),
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_batas_kembali' => $request->tanggal_batas_kembali,
                'status' => 'menunggu',
            ]);

            DetailPeminjaman::create([
                'id_peminjaman' => $peminjaman->id_peminjaman,
                'id_alat' => $alat->id_alat,
                'jumlah' => $request->jumlah,
            ]);
        });

    } catch (RuntimeException $e) {
        return back()->withInput()->with('error', $e->getMessage());
    }

    return redirect('/peminjam/peminjaman')
        ->with('success', 'Pengajuan peminjaman berhasil dikirim!');
}
    // DETAIL PENGAJUAN UNTUK PETUGAS
    public function show($id)
    {
        $peminjaman = Peminjaman::with([
            'user',
            'detailPeminjaman.alat'
        ])->findOrFail($id);

        return view('petugas.peminjaman.show', compact('peminjaman'));
    }

    // SETUJUI ATAU TOLAK PENGAJUAN
    public function proses(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                // Kunci pengajuan agar tidak diproses bersamaan
                $peminjaman = Peminjaman::where(
                    'id_peminjaman',
                    $id
                )->lockForUpdate()->firstOrFail();

                if ($peminjaman->status !== 'menunggu') {
                    throw new RuntimeException(
                        'Pengajuan ini sudah diproses.'
                    );
                }

                if ($request->status === 'disetujui') {
                    $detailPeminjaman = DetailPeminjaman::where(
                        'id_peminjaman',
                        $peminjaman->id_peminjaman
                    )->get();

                    foreach ($detailPeminjaman as $detail) {
                        $alat = Alat::where(
                            'id_alat',
                            $detail->id_alat
                        )->lockForUpdate()->firstOrFail();

                        if ($alat->stok < $detail->jumlah) {
                            throw new RuntimeException(
                                'Stok alat ' . $alat->nama_alat .
                                ' tidak mencukupi. Stok saat ini: ' .
                                $alat->stok
                            );
                        }

                        $alat->decrement('stok', $detail->jumlah);
                    }
                }

                $peminjaman->update([
                    'status' => $request->status,
                ]);
            });

        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        return redirect('/petugas/peminjaman')
            ->with(
                'success',
                $request->status === 'disetujui'
                    ? 'Pengajuan berhasil disetujui dan stok telah diperbarui.'
                    : 'Pengajuan berhasil ditolak.'
            );
    }
}