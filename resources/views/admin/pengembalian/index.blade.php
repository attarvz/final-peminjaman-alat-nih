
@extends('layouts.app')

@section('title', 'Data Pengembalian')

@section('content')
<div class="main-container">
    <h2>Data Pengembalian</h2>
    <p class="text-muted">
        Daftar pengembalian alat yang telah dicatat petugas.
    </p>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>No.</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Tanggal Kembali</th>
                    <th>Denda</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($peminjaman as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>
                            {{ $item->tanggal_pinjam
                                ? $item->tanggal_pinjam->format('d-m-Y')
                                : '-' }}
                        </td>
                        <td>
                            @forelse ($item->detailPeminjaman as $detail)
                                <div>{{ $detail->alat->nama_alat ?? '-' }}</div>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>
                            @forelse ($item->detailPeminjaman as $detail)
                                <div>{{ $detail->jumlah }}</div>
                            @empty
                                -
                            @endforelse
                        </td>
                        <td>
                            {{ $item->pengembalian?->tanggal_pengembalian
                                ? $item->pengembalian->tanggal_pengembalian->format('d-m-Y')
                                : '-' }}
                        </td>
                        <td>
                            Rp{{ number_format(
                                $item->pengembalian?->denda ?? 0,
                                0,
                                ',',
                                '.'
                            ) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            Belum ada data pengembalian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection