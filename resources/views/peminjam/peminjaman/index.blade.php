
@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
<div class="main-container">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <h2 class="mb-0">Peminjaman Saya</h2>

        <a href="/peminjam/peminjaman/create" class="btn btn-primary">
            + Ajukan Peminjaman
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">

            <thead class="table-primary">
                <tr>
                    <th>No.</th>
                    <th>Tanggal Pinjam</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal Kembali</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($peminjaman as $item)

                    <tr>
                        {{-- Nomor --}}
                        <td>{{ $loop->iteration }}</td>

                        {{-- Tanggal Pinjam --}}
                        <td>
                            {{ $item->tanggal_pinjam
                                ? $item->tanggal_pinjam->format('d-m-Y')
                                : '-' }}
                        </td>

                        {{-- Nama Alat --}}
                        <td>
                            @forelse ($item->detailPeminjaman as $detail)
                                <div>
                                    {{ $detail->alat->nama_alat ?? 'Alat tidak ditemukan' }}
                                </div>
                            @empty
                                <span class="text-muted">
                                    Belum ada detail alat
                                </span>
                            @endforelse
                        </td>

                        {{-- Jumlah --}}
                        <td>
                            @forelse ($item->detailPeminjaman as $detail)
                                <div>{{ $detail->jumlah }}</div>
                            @empty
                                -
                            @endforelse
                        </td>

                        {{-- Status --}}
                        <td>
                            @if ($item->status === 'menunggu')
                                <span class="badge bg-warning text-dark">
                                    Menunggu
                                </span>

                            @elseif ($item->status === 'disetujui')
                                <span class="badge bg-success">
                                    Disetujui
                                </span>

                            @elseif ($item->status === 'ditolak')
                                <span class="badge bg-danger">
                                    Ditolak
                                </span>

                            @elseif ($item->status === 'menunggu_pengembalian')
                                <span class="badge bg-warning text-dark">
                                    Menunggu Konfirmasi Pengembalian
                                </span>

                            @elseif ($item->status === 'dikembalikan')
                                <span class="badge bg-primary">
                                    Dikembalikan
                                </span>

                            @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst($item->status) }}
                                </span>
                            @endif
                        </td>

                        {{-- Tanggal Kembali Pilihan Peminjam --}}
                        <td>
                            @if ($item->tanggal_batas_kembali)
                                {{ $item->tanggal_batas_kembali->format('d-m-Y') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- Denda --}}
                        <td>
                            @if ($item->pengembalian && $item->status === 'dikembalikan')
                                Rp{{ number_format($item->pengembalian->denda, 0, ',', '.') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td>
                            @if ($item->status === 'disetujui')

                                <form
                                    action="{{ route('peminjam.pengembalian.ajukan', $item->id_peminjaman) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin mengajukan pengembalian alat ini?')"
                                >
                                    @csrf

                                    <button type="submit" class="btn btn-sm btn-primary">
                                        Ajukan Pengembalian
                                    </button>
                                </form>

                            @elseif ($item->status === 'menunggu_pengembalian')

                                <span class="badge bg-warning text-dark">
                                    Menunggu Petugas
                                </span>

                            @elseif ($item->status === 'dikembalikan')

                                <span class="badge bg-success">
                                    Selesai
                                </span>

                            @else

                                <span class="text-muted">-</span>

                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            Kamu belum pernah mengajukan peminjaman.
                        </td>
                    </tr>

                @endforelse
            </tbody>

        </table>
    </div>

    <a href="/peminjam/dashboard" class="btn btn-secondary">
        Kembali ke Dashboard
    </a>

</div>
@endsection
