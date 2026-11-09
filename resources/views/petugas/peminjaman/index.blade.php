
@extends('layouts.app')

@section('content')
<div class="main-container">
    <h2>Pengajuan Peminjaman</h2>
    <p class="text-muted">
        Kelola pengajuan peminjaman alat dari peminjam.
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
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($peminjaman as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $item->user->name ?? '-' }}
                        </td>

                        <td>
                            {{ $item->tanggal_pinjam
                                ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d-m-Y')
                                : '-' }}
                        </td>

                        {{-- TANGGAL YANG DITENTUKAN PEMINJAM --}}
                        <td>
                            {{ $item->tanggal_batas_kembali
                                ? \Carbon\Carbon::parse($item->tanggal_batas_kembali)->format('d-m-Y')
                                : '-' }}
                        </td>

                        <td>
                            @forelse ($item->detailPeminjaman as $detail)
                                <div>
                                    {{ $detail->alat->nama_alat ?? '-' }}
                                </div>
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
                            @else
                                <span class="badge bg-secondary">
                                    {{ ucfirst($item->status) }}
                                </span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ url('/petugas/peminjaman/' . $item->id_peminjaman) }}"
                               class="btn btn-info btn-sm mb-1">
                                Detail
                            </a>

                            @if ($item->status === 'menunggu')
                                <form
                                    action="{{ url('/petugas/peminjaman/' . $item->id_peminjaman . '/proses') }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Setujui pengajuan ini?')"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden"
                                           name="status"
                                           value="disetujui">

                                    <button type="submit"
                                            class="btn btn-success btn-sm mb-1">
                                        Setujui
                                    </button>
                                </form>

                                <form
                                    action="{{ url('/petugas/peminjaman/' . $item->id_peminjaman . '/proses') }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Tolak pengajuan ini?')"
                                >
                                    @csrf
                                    @method('PUT')

                                    <input type="hidden"
                                           name="status"
                                           value="ditolak">

                                    <button type="submit"
                                            class="btn btn-danger btn-sm mb-1">
                                        Tolak
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            Belum ada pengajuan peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
