
@extends('layouts.app')

@section('title', 'Dashboard Petugas')

@section('content')

<div class="container py-4">

    {{-- SAMBUTAN PETUGAS --}}
    <div class="welcome">
        <h1>Dashboard Petugas</h1>
        <p>Selamat datang, {{ Auth::user()->name }}! Kamu login sebagai petugas.</p>
    </div>

    {{-- MENU DASHBOARD --}}
    <div class="dashboard-cards">

        <div class="dashboard-card">
            <h3>Peminjaman</h3>
            <p>Lihat pengajuan dan proses peminjaman alat olahraga.</p>
            <a href="/petugas/peminjaman">Kelola Peminjaman →</a>
        </div>

        <div class="dashboard-card">
            <h3>Pengembalian</h3>
            <p>Catat pengembalian alat olahraga dan kelola denda.</p>
            <a href="/petugas/pengembalian">Kelola Pengembalian →</a>
        </div>

    </div>

</div>

{{-- FOOTER --}}
<div class="dashboard-footer">
    Sistem Peminjaman Alat Olahraga &copy; {{ date('Y') }}
</div>

{{-- SWEETALERT2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const logoutForm = document.getElementById('logoutForm');

        if (logoutForm) {
            logoutForm.addEventListener('submit', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Yakin ingin logout?',
                    text: 'Kamu akan keluar dari aplikasi.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#2563eb',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Ya, Logout',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        logoutForm.submit();
                    }
                });
            });
        }
    });
</script>

@endsection