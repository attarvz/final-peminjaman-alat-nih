
@extends('layouts.app')

@section('title', 'Pengembalian Alat')

@section('content')
<div class="main-container">

    <h2>Pengembalian Alat</h2>
    <p class="text-muted">
        Kelola pengembalian alat dari peminjam.
    </p>

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

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">

            <thead class="table-primary">
                <tr>
                    <th>No.</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Denda</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pengembalian as $data)

                    @php
                        $item = $data->peminjaman;
                    @endphp

                    @if ($item)
                    <tr>

                        {{-- NO --}}
                        <td>{{ $loop->iteration }}</td>

                        {{-- NAMA PEMINJAM --}}
                        <td>{{ $item->user->name ?? '-' }}</td>

                        {{-- TANGGAL PINJAM --}}
                        <td>
                            {{ $item->tanggal_pinjam
                                ? $item->tanggal_pinjam->format('d-m-Y')
                                : '-' }}
                        </td>

                        {{-- TANGGAL KEMBALI PILIHAN PEMINJAM --}}
                        <td>
                            @if ($item->tanggal_batas_kembali)
                                {{ $item->tanggal_batas_kembali->format('d-m-Y') }}
                            @else
                                <span class="text-muted">
                                    Belum ditentukan
                                </span>
                            @endif
                        </td>

                        {{-- NAMA ALAT --}}
                        <td>
                            @forelse ($item->detailPeminjaman as $detail)
                                <div>
                                    {{ $detail->alat->nama_alat ?? '-' }}
                                </div>
                            @empty
                                -
                            @endforelse
                        </td>

                        {{-- JUMLAH --}}
                        <td>
                            @forelse ($item->detailPeminjaman as $detail)
                                <div>{{ $detail->jumlah }}</div>
                            @empty
                                -
                            @endforelse
                        </td>

                        {{-- STATUS --}}
                        <td>
                            @if ($item->status === 'menunggu_pengembalian')
                                <span class="badge bg-warning text-dark">
                                    Menunggu Konfirmasi
                                </span>
                            @elseif ($item->status === 'dikembalikan')
                                <span class="badge bg-success">
                                    Dikembalikan
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst($item->status) }}
                                </span>
                            @endif
                        </td>

                        {{-- TANGGAL AKTUAL PENGEMBALIAN --}}
                        <td>
                            @if ($data->tanggal_pengembalian)
                                {{ $data->tanggal_pengembalian->format('d-m-Y') }}
                            @else
                                <span class="text-muted">
                                    Belum dikembalikan
                                </span>
                            @endif
                        </td>

                        {{-- DENDA --}}
                        <td>
                            Rp{{ number_format($data->denda, 0, ',', '.') }}
                        </td>

                        {{-- AKSI --}}
                        <td style="min-width: 180px;">

                            @if ($item->status === 'menunggu_pengembalian' && !$data->tanggal_pengembalian)

                                <form
                                    action="{{ route('petugas.pengembalian.konfirmasi', $item->id_peminjaman) }}"
                                    method="POST"
                                    onsubmit="return confirm('Pastikan alat sudah diterima dan diperiksa. Konfirmasi pengembalian?')"
                                >
                                    @csrf

                                    <label class="form-label fw-semibold">
                                        Masukkan Denda (Rp)
                                    </label>

                                    <input
                                        type="number"
                                        name="denda"
                                        class="form-control form-control-sm mb-2"
                                        min="0"
                                        step="1"
                                        value="{{ old('denda', 0) }}"
                                        placeholder="Contoh: 5000"
                                        required
                                    >

                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-sm w-100"
                                    >
                                        Konfirmasi Pengembalian
                                    </button>
                                </form>

                            @elseif ($item->status === 'dikembalikan')

                                <span class="badge bg-success">
                                    Selesai
                                </span>

                            @else

                                <span class="text-muted">-</span>

                            @endif

                        </td>

                    </tr>
                    @endif

                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4">
                            Belum ada pengajuan pengembalian.
                        </td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>

</div>
@endsection
