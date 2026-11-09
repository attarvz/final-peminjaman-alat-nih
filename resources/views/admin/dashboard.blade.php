@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="container py-4">

    {{-- SAMBUTAN ADMIN --}}
    <div class="welcome">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang, Admin! Kamu login sebagai admin.</p>
    </div>

    {{-- MENU DASHBOARD --}}
    <div class="dashboard-cards">

        <div class="dashboard-card">
            <h3>Data User</h3>
            <p>Kelola akun admin, petugas, dan peminjam.</p>
            <a href="/admin/user">Kelola User →</a>
        </div>

        <div class="dashboard-card">
            <h3>Kategori</h3>
            <p>Kelola kategori alat olahraga.</p>
            <a href="/admin/kategori">Kelola Kategori →</a>
        </div>

        <div class="dashboard-card">
            <h3>Data Alat</h3>
            <p>Kelola daftar alat dan jumlah stok.</p>
            <a href="/admin/alat">Kelola Alat →</a>
        </div>

        <div class="dashboard-card">
            <h3>Peminjaman</h3>
            <p>Lihat dan kelola data peminjaman alat.</p>
            <a href="/admin/peminjaman">Kelola Peminjaman →</a>
        </div>

        <div class="dashboard-card">
            <h3>Pengembalian</h3>
            <p>Kelola pengembalian alat dan denda.</p>
            <a href="/admin/pengembalian">Kelola Pengembalian →</a>
        </div>

        <div class="dashboard-card">
            <h3>Log Aktivitas</h3>
            <p>Lihat catatan aktivitas pengguna sistem.</p>
            <a href="/admin/log-aktivitas">Lihat Aktivitas →</a>
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