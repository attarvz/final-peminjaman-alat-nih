
@extends('layouts.app')

@section('title', 'Data Peminjaman')

@section('content')
<div class="main-container">
    <h2>Data Peminjaman</h2>
    <p class="text-muted">Daftar seluruh pengajuan peminjaman alat.</p>

    <form action="{{ route('admin.peminjaman.destroyAll') }}"
      method="POST"
      class="mb-3"
      onsubmit="return confirm('PERINGATAN! Semua riwayat peminjaman, detail, dan pengembalian akan dihapus permanen. Yakin ingin melanjutkan?')">
    @csrf
    @method('DELETE')
     <div class="d-flex justify-content-end align-items-center gap-2" style="margin-top: -55px; margin-bottom: 20px;">
    <button type="submit" class="btn btn-danger">
        Hapus Semua Riwayat
    </button>
</div>
</form>

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>No.</th>
                    <th>Nama Peminjam</th>
                    <th>Tanggal Pinjam</th>
                    <th>Alat</th>
                    <th>Jumlah</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjaman as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->user->name ?? '-' }}</td>
                        <td>{{ $item->tanggal_pinjam?->format('d-m-Y') ?? '-' }}</td>
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
                            @if ($item->status === 'menunggu')
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            @elseif ($item->status === 'disetujui')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif ($item->status === 'ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @elseif ($item->status === 'dikembalikan')
                                <span class="badge bg-primary">Dikembalikan</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($item->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">
                            Belum ada data peminjaman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection