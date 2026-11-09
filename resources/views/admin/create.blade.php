
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
</head>
<body style="font-family: Arial; background: #f1f5f9; padding: 30px;">
    <div style="max-width: 500px; margin: auto; background: white; padding: 25px; border-radius: 12px;">
        <h2>Tambah Kategori</h2>

        <form action="/admin/kategori" method="POST">
            @csrf

            <label for="nama_kategori">Nama Kategori</label>
            <br><br>

            <input
                type="text"
                id="nama_kategori"
                name="nama_kategori"
                value="{{ old('nama_kategori') }}"
                placeholder="Contoh: Bola"
                required
                style="width: 95%; padding: 10px;"
            >

            @error('nama_kategori')
                <p style="color: red;">{{ $message }}</p>
            @enderror

            <br><br>
            <button type="submit">Simpan</button>
            <a href="/admin/kategori">Batal</a>
        </form>
    </div>
</body>
</html>