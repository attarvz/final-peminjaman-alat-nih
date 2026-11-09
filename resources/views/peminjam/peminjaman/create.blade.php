
@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="main-container">

    <div class="form-container">

        <h2>Ajukan Peminjaman Alat</h2>

        <p class="text-secondary mb-4">
            Isi formulir berikut untuk mengajukan peminjaman alat.
        </p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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

        <form action="/peminjam/peminjaman" method="POST">
            @csrf

            {{-- Tanggal Pinjam --}}
            <div class="mb-3">
                <label for="tanggal_pinjam" class="form-label">
                    Tanggal Pinjam
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="tanggal_pinjam"
                    name="tanggal_pinjam"
                    value="{{ old('tanggal_pinjam', date('Y-m-d')) }}"
                    min="{{ date('Y-m-d') }}"
                    required
                >
            </div>

            {{-- Tanggal Pengembalian --}}
            <div class="mb-3">
                <label for="tanggal_batas_kembali" class="form-label">
                    Tanggal Pengembalian
                </label>

                <input
                    type="date"
                    class="form-control"
                    id="tanggal_batas_kembali"
                    name="tanggal_batas_kembali"
                    value="{{ old('tanggal_batas_kembali') }}"
                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                    required
                >
            </div>

            {{-- Pilih Alat --}}
            <div class="mb-3">
                <label for="id_alat" class="form-label">
                    Pilih Alat
                </label>

                <select
                    class="form-select"
                    id="id_alat"
                    name="id_alat"
                    required
                >
                    <option value="">-- Pilih Alat --</option>

                    @foreach ($alat as $item)
                        <option
                            value="{{ $item->id_alat }}"
                            {{ old('id_alat') == $item->id_alat ? 'selected' : '' }}
                        >
                            {{ $item->nama_alat }}
                            (Stok: {{ $item->stok }})
                        </option>
                    @endforeach
                </select>

                @if ($alat->isEmpty())
                    <small class="text-danger d-block mt-2">
                        Belum ada alat yang tersedia untuk dipinjam.
                    </small>
                @endif
            </div>

            {{-- Jumlah --}}
            <div class="mb-4">
                <label for="jumlah" class="form-label">
                    Jumlah Pinjam
                </label>

                <input
                    type="number"
                    class="form-control"
                    id="jumlah"
                    name="jumlah"
                    value="{{ old('jumlah', 1) }}"
                    min="1"
                    required
                >
            </div>

            {{-- Tombol --}}
            <div class="d-flex flex-wrap gap-2 mt-4">

                <button
                    type="submit"
                    class="btn btn-primary"
                    {{ $alat->isEmpty() ? 'disabled' : '' }}
                >
                    Ajukan Peminjaman
                </button>

                <a href="/peminjam/dashboard" class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </form>

    </div>

</div>
@endsection
