
@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="form-container">
    <h2 class="mb-4">Tambah User</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="/admin/user" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text"
                   id="name"
                   name="name"
                   class="form-control"
                   value="{{ old('name') }}"
                   placeholder="Masukkan nama lengkap"
                   required>
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email"
                   id="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email') }}"
                   placeholder="contoh@email.com"
                   required>
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password"
                   id="password"
                   name="password"
                   class="form-control"
                   placeholder="Minimal 8 karakter"
                   minlength="8"
                   required>
            @error('password')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                    Admin
                </option>
                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>
                    Petugas
                </option>
                <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>
                    Peminjam
                </option>
            </select>
            @error('role')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                Simpan User
            </button>

            <a href="/admin/user" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection