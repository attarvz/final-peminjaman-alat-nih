@extends('layouts.app')

@section('title', 'Data Kategori')

@section('content')
<div class="container ">
    <!-- Bungkus konten utama dengan class form-container -->
    <div class="form-container" style="max-width: 100%;"> <!-- Sesuaikan max-width jika ingin lebih lebar -->
        <h2 class="mb-3">Data Kategori Alat</h2>

            <div class="d-flex justify-content-end align-items-center gap-2" style="margin-top: -55px; margin-bottom: 20px;">
            <a href="/admin/dashboard" class="btn btn-secondary">Kembali</a>
            <a href="/admin/kategori/create" class="btn btn-primary">+ Tambah Kategori</a>
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

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th style="width: 15%;">No.</th>
                        <th>Nama Kategori</th>
                        <th class="text-end" style="width: 35%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kategori as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_kategori }}</td>
                            <td>
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <a href="/admin/kategori/{{ $item->id_kategori }}/edit"
                                       class="btn btn-warning btn-sm">
                                        Edit
                                    </a>

                                    <form action="/admin/kategori/{{ $item->id_kategori }}"
                                          method="POST"
                                          class="m-0"
                                          onsubmit="return window.confirm('Yakin ingin menghapus kategori ini?');">
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
                                Belum ada kategori.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection