
@extends('layouts.app')

@section('content')
<div class="main-container">
    <h2>Detail Peminjaman</h2>

    <p class="text-muted">
        Informasi lengkap pengajuan peminjaman alat.
    </p>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4 fw-semibold">Nama Peminjam</div>
                <div class="col-md-8">
                    {{ $peminjaman->user->name ?? '-' }}
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4 fw-semibold">Tanggal Pinjam</div>
                <div class="col-md-8">
                    {{ $peminjaman->tanggal_pinjam
                        ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d-m-Y')
                        : '-' }}
                </div>
            </div>
            <div class="row mb-3">
    <div class="col-md-4 fw-semibold">Tanggal Batas Kembali</div>
    <div class="col-md-8">
        {{ $peminjaman->tanggal_batas_kembali
            ? \Carbon\Carbon::parse($peminjaman->tanggal_batas_kembali)->format('d-m-Y')
            : '-' }}
    </div>
</div>

            <div class="row mb-3">
                <div class="col-md-4 fw-semibold">Status Pengajuan</div>
                <div class="col-md-8">
                    @if ($peminjaman->status === 'menunggu')
                        <span class="badge bg-warning text-dark">Menunggu</span>
                    @elseif ($peminjaman->status === 'disetujui')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif ($peminjaman->status === 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>
                    @else
                        <span class="badge bg-secondary">
                            {{ ucfirst($peminjaman->status) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <h5 class="mb-3">Daftar Alat yang Dipinjam</h5>

    <div class="table-responsive mb-4">
        <table class="table table-bordered align-middle">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Alat</th>
                    <th>Jumlah</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($peminjaman->detailPeminjaman as $detail)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $detail->alat->nama_alat ?? '-' }}</td>
                        <td>{{ $detail->jumlah }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            Tidak ada detail alat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($peminjaman->status === 'menunggu')
        <div class="d-flex flex-wrap gap-2">
            <form
                action="{{ url('/petugas/peminjaman/' . $peminjaman->id_peminjaman . '/proses') }}"
                method="POST"
                onsubmit="return confirm('Setujui pengajuan ini?')"
            >
                @csrf
                @method('PUT')

                <input type="hidden" name="status" value="disetujui">

                <button type="submit" class="btn btn-success">
                    Setujui Pengajuan
                </button>
            </form>

            <form
                action="{{ url('/petugas/peminjaman/' . $peminjaman->id_peminjaman . '/proses') }}"
                method="POST"
                onsubmit="return confirm('Tolak pengajuan ini?')"
            >
                @csrf
                @method('PUT')

                <input type="hidden" name="status" value="ditolak">

                <button type="submit" class="btn btn-danger">
                    Tolak Pengajuan
                </button>
            </form>
        </div>
    @endif

    <a href="{{ url('/petugas/peminjaman') }}"
       class="btn btn-secondary mt-3">
        Kembali ke Daftar
    </a>
</div>
@endsection