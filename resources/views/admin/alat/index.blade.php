
@extends('layouts.app')

@section('title', 'Data Alat')

@section('content')
<div class="main-container">

    <div class="mb-4">
    <h2 class="mb-3">Data Alat</h2>

    <div class="d-flex justify-content-end align-items-center gap-2" style="margin-top: -55px; margin-bottom: 20px;">
    <a href="/admin/dashboard" class="btn btn-secondary">Kembali</a>
        <a href="/admin/alat/create" class="btn btn-primary">+ Tambah Alat</a>
    </div>
</div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle mb-0">
            <thead>
                <tr>
                    <th style="width: 8%;">No.</th>
                    <th>Nama Alat</th>
                    <th>Kategori</th>
                    <th style="width: 12%;">Stok</th>
                    <th style="width: 25%;" class="text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($alat as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_alat }}</td>
                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $item->stok }}</td>
                        <td>
                            <div class="aksi">
                                <a href="/admin/alat/{{ $item->id_alat }}/edit"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="/admin/alat/{{ $item->id_alat }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-secondary py-4">
                            Belum ada data alat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection