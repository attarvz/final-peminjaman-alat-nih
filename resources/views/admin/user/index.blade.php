
@extends('layouts.app')

@section('title', 'Data User')

@section('content')
<div class="main-container">
    
<div class="d-flex justify-content-between align-items-center mb-4">
  <!-- Elemen 1 (Kiri) -->
  <h2 class="m-0">Data User</h2>

  <!-- Elemen 2 (Kanan) -> Bungkus kedua tombol di sini -->
  <div class="d-flex align-items-center gap-2">
    <a href="/admin/dashboard" class="btn btn-secondary">Kembali</a>
    <a href="/admin/user/create" class="btn btn-primary">+ Tambah User</a>
  </div>
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
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-primary">
                <tr>
                    <th>No.</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th class="text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>
                            <div class="aksi">
                                <a href="/admin/user/{{ $user->id }}/edit"
                                   class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <form action="/admin/user/{{ $user->id }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus user ini?')">
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
                        <td colspan="5" class="text-center text-muted">
                            Belum ada data user.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
       
    </div>
</div>
@endsection