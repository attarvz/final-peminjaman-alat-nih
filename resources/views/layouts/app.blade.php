
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Peminjaman Alat Olahraga')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: #1e293b;
            background: #f1f5f9;
            font-size: 14px;
        }

        body, button, input, select, textarea, table,
        .navbar, .btn, .form-control, .form-select {
            font-family: Arial, sans-serif;
        }

        /* NAVBAR SEMUA ROLE */
        .admin-navbar {
            background: #1e3a8a;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, .12);
        }

        .admin-navbar h2 {
            margin: 0;
            font-size: 20px;
            font-weight: 400;
            color: white;
        }

        .admin-menu {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .admin-menu a {
            color: #e5edff;
            text-decoration: none;
            font-size: 14px;
            padding: 9px 12px;
            border-radius: 7px;
            transition: background .2s;
        }

        .admin-menu a:hover,
        .admin-menu a.active {
            background: #2563eb;
            color: white;
        }

        .admin-logout {
            background: white;
            color: #1e3a8a;
            border: none;
            padding: 9px 13px;
            border-radius: 7px;
            font-size: 13px;
            cursor: pointer;
            transition: background .2s;
        }

        .admin-logout:hover {
            background: #dbeafe;
        }

        /* AREA KONTEN */
        main.container-fluid {
            min-height: calc(100vh - 65px);
        }

        /* DASHBOARD */
        .welcome {
            background: white;
            padding: 30px;
            border-radius: 14px;
            margin: 24px 0;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .03);
        }

        .welcome h1 {
            margin: 0 0 12px;
            font-size: 26px;
            font-weight: 400;
            color: #1e3a8a;
        }

        .welcome p {
            color: #64748b;
            margin-bottom: 8px;
            line-height: 1.7;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .dashboard-card {
            background: white;
            padding: 26px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 14px rgba(15, 23, 42, .04);
            transition: transform .2s, box-shadow .2s;
        }

        .dashboard-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(15, 23, 42, .07);
        }

        .dashboard-card h3 {
            font-size: 18px;
            font-weight: 400;
            color: #1e293b;
            margin: 0 0 12px;
        }

        .dashboard-card p {
            font-size: 14px;
            line-height: 1.7;
            color: #64748b;
            margin-bottom: 16px;
        }

        .dashboard-card a {
            display: inline-block;
            margin-top: 4px;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 7px;
            font-size: 14px;
            font-weight: 400;
            transition: background .2s;
        }

        .dashboard-card a:hover {
            background: #1d4ed8;
        }

        .dashboard-footer {
            text-align: center;
            color: #64748b;
            font-size: 13px;
            padding: 25px;
        }

        /* HALAMAN DATA */
        .main-container {
            max-width: 1150px;
            margin: 24px auto;
            padding: 25px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
        }

        .main-container h2,
        .form-container h2 {
            font-size: 24px;
            font-weight: 400;
            color: #1e3a8a;
            margin-bottom: 22px;
        }

        /* TABEL */
        .table {
            font-size: 14px;
            color: #334155;
        }

        .table thead th {
            background-color: #dbeafe;
            color: #1e3a8a;
            font-weight: 400;
            vertical-align: middle;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
        }

        .table tbody tr:hover {
            background-color: #f8fafc;
        }

        /* FORM */
        .form-container {
            max-width: 550px;
            margin: 24px auto;
            padding: 25px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
        }

        .form-label {
            font-size: 14px;
            font-weight: 400;
            color: #334155;
        }

        .form-control,
        .form-select {
            font-size: 14px;
            border-color: #cbd5e1;
            border-radius: 7px;
            padding: 10px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #60a5fa;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
        }

        /* TOMBOL */
        .btn {
            font-size: 14px;
            font-weight: 400;
            border-radius: 7px;
            padding: 9px 14px;
        }

        .btn-primary {
            background: #2563eb;
            border-color: #2563eb;
        }

        .btn-primary:hover {
            background: #1d4ed8;
            border-color: #1d4ed8;
        }

        .aksi {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
        }

        .aksi form {
            margin: 0;
        }

        .alert {
            border-radius: 8px;
            font-size: 14px;
        }

        /* RESPONSIF */
        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
            }

            .admin-navbar {
                padding: 16px 20px;
            }

            .admin-menu {
                gap: 5px;
            }

            .main-container {
                padding: 18px;
            }

            .welcome {
                padding: 22px;
            }

            .dashboard-card {
                padding: 22px;
            }
        }

        @media (max-width: 480px) {
            .admin-navbar {
                padding: 15px;
            }

            .admin-navbar h2 {
                font-size: 18px;
            }

            .admin-menu {
                width: 100%;
                gap: 5px;
            }

            .admin-menu a {
                padding: 8px;
                font-size: 13px;
            }

            .main-container {
                margin: 15px auto;
                padding: 15px;
            }

            .form-container {
                margin: 15px auto;
                padding: 18px;
            }

            .welcome {
                padding: 20px;
                margin-top: 15px;
            }

            .welcome h1 {
                font-size: 22px;
            }

            .dashboard-card {
                padding: 20px;
            }

            .aksi {
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body>

    {{-- NAVBAR ADMIN --}}
    @if (auth()->check() && auth()->user()->role === 'admin')
        <nav class="admin-navbar">
            <h2>Peminjaman Alat</h2>

            <div class="admin-menu">
                <a href="/admin/dashboard"
                   class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="/admin/alat"
                   class="{{ request()->is('admin/alat*') ? 'active' : '' }}">
                    Data Alat
                </a>

                <a href="/admin/kategori"
                   class="{{ request()->is('admin/kategori*') ? 'active' : '' }}">
                    Kategori
                </a>

                <a href="/admin/user"
                   class="{{ request()->is('admin/user*') ? 'active' : '' }}">
                    User
                </a>

                <a href="/admin/peminjaman"
                   class="{{ request()->is('admin/peminjaman*') ? 'active' : '' }}">
                    Peminjaman
                </a>

                <a href="/admin/pengembalian"
                   class="{{ request()->is('admin/pengembalian*') ? 'active' : '' }}">
                    Pengembalian
                </a>

             <form action="/logout" method="POST" class="m-0"
      onsubmit="return confirm('Apakah kamu yakin ingin logout?');">
    @csrf
    <button type="submit" class="admin-logout">Logout</button>
</form>
                </form>
            </div>
        </nav>
    @endif

    {{-- NAVBAR PETUGAS --}}
    @if (auth()->check() && auth()->user()->role === 'petugas')
        <nav class="admin-navbar">
            <h2>Peminjaman Alat</h2>

            <div class="admin-menu">
                <a href="/petugas/dashboard"
                   class="{{ request()->is('petugas/dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>

                <a href="/petugas/peminjaman"
                   class="{{ request()->is('petugas/peminjaman*') ? 'active' : '' }}">
                    Peminjaman
                </a>

                <a href="/petugas/pengembalian"
                   class="{{ request()->is('petugas/pengembalian*') ? 'active' : '' }}">
                    Pengembalian
                </a>

               <form action="/logout" method="POST" class="m-0"
      onsubmit="return confirm('Apakah kamu yakin ingin logout?');">
    @csrf
    <button type="submit" class="admin-logout">Logout</button>
</form>
                </form>
            </div>
        </nav>
    @endif

    
{{-- NAVBAR PEMINJAM --}}
@if (auth()->check() && auth()->user()->role === 'peminjam')
    <nav class="admin-navbar">
        <h2>Peminjaman Alat</h2>

        <div class="admin-menu">
            <a href="/peminjam/dashboard"
               class="{{ request()->is('peminjam/dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

           
            <a href="/peminjam/peminjaman"
               class="{{ request()->is('peminjam/peminjaman') ? 'active' : '' }}">
                Pinjaman Saya
            </a>

             <a href="/peminjam/peminjaman/create"
               class="{{ request()->is('peminjam/peminjaman/create') ? 'active' : '' }}">
                Ajukan Pinjaman
            </a>


           <form action="/logout" method="POST" class="m-0"
      onsubmit="return confirm('Apakah kamu yakin ingin logout?');">
    @csrf
    <button type="submit" class="admin-logout">Logout</button>
</form>
            </form>
        </div>
    </nav>
@endif


    {{-- KONTEN HALAMAN --}}
    <main class="container-fluid px-3 px-md-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>