
@extends('layouts.app')

@section('title', 'Dashboard Peminjam')

@section('content')
<div class="container py-4">
    <div class="welcome">
        <h1>Dashboard Peminjam</h1>
        <p>Selamat datang, {{ auth()->user()->name }}!</p>
        <p>Ajukan peminjaman alat olahraga dan pantau status pengajuanmu di sini.</p>
    </div>

    <div class="dashboard-cards">
        <div class="dashboard-card">
            <h3>Peminjaman Saya</h3>
            <p>Lihat daftar dan status pengajuan peminjaman.</p>
            <a href="/peminjam/peminjaman" class="btn btn-primary">
                Lihat Peminjaman
            </a>
        </div>

        <div class="dashboard-card">
            <h3>Ajukan Peminjaman</h3>
            <p>Pilih alat olahraga yang ingin dipinjam.</p>
            <a href="/peminjam/peminjaman/create" class="btn btn-primary">
                Ajukan Sekarang
            </a>
        </div>
    </div>
</div>
@endsection