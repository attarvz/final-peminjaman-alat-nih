
@extends('layouts.app')

@section('title', 'Tambah Alat')

@section('content')
<div class="form-container">

    <h2 class="mb-4">Tambah Alat Olahraga</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/alat" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama_alat" class="form-label">Nama Alat</label>
            <input
                type="text"
                class="form-control"
                id="nama_alat"
                name="nama_alat"
                value="{{ old('nama_alat') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select class="form-select" id="id_kategori" name="id_kategori" required>
                <option value="">-- Pilih Kategori --</option>

                @foreach ($kategori as $item)
                    <option
                        value="{{ $item->id_kategori }}"
                        {{ old('id_kategori') == $item->id_kategori ? 'selected' : '' }}
                    >
                        {{ $item->nama_kategori }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="stok" class="form-label">Stok</label>
            <input
                type="number"
                class="form-control"
                id="stok"
                name="stok"
                value="{{ old('stok') }}"
                min="0"
                required
            >
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="/admin/alat" class="btn btn-secondary">Kembali</a>
        </div>
    </form>

</div>
@endsection