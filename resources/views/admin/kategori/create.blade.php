@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="container py-4">
    <div class="form-container">
        <h2 class="mb-4">Tambah Kategori</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="/admin/kategori" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nama_kategori" class="form-label">Nama Kategori</label>
                <input
                    type="text"
                    class="form-control"
                    id="nama_kategori"
                    name="nama_kategori"
                    value="{{ old('nama_kategori') }}"
                    
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">Simpan Kategori</button>
            <a href="/admin/kategori" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
@endsection`