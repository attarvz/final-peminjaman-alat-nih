
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Alat</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }

        h2 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 11px;
            margin-bottom: 18px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 15px;
        }

        button, a {
            display: inline-block;
            padding: 11px 16px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
        }

        button {
            background: #2563eb;
            color: white;
        }

        a {
            background: #64748b;
            color: white;
        }

        .error {
            margin-bottom: 18px;
            padding: 12px;
            border-radius: 6px;
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Alat Olahraga</h2>

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="/admin/alat/{{ $alat->id_alat }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nama_alat">Nama Alat</label>
        <input
            type="text"
            id="nama_alat"
            name="nama_alat"
            value="{{ old('nama_alat', $alat->nama_alat) }}"
            required
        >

        <label for="id_kategori">Kategori</label>
        <select id="id_kategori" name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>

            @foreach ($kategori as $item)
                <option
                    value="{{ $item->id_kategori }}"
                    {{ old('id_kategori', $alat->id_kategori) == $item->id_kategori ? 'selected' : '' }}
                >
                    {{ $item->nama_kategori }}
                </option>
            @endforeach
        </select>

        <label for="stok">Stok</label>
        <input
            type="number"
            id="stok"
            name="stok"
            value="{{ old('stok', $alat->stok) }}"
            min="0"
            required
        >

        <button type="submit">Simpan Perubahan</button>
        <a href="/admin/alat">Kembali</a>
    </form>
</div>

</body>
</html>