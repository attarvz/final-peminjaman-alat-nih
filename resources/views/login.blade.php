
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peminjaman Alat Olahraga</title>
    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #eef3f9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            background: white;
            width: 360px;
            max-width: 92%;
            padding: 30px;
            border-radius: 14px;
            box-shadow: 0 8px 25px #00000015;
        }

        h2 { text-align: center; color: #1d4ed8; }
        p { text-align: center; color: #64748b; }

        label {
            display: block;
            margin-top: 18px;
            margin-bottom: 7px;
        }

        input {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 22px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 7px;
            cursor: pointer;
        }

        button:hover { background: #1d4ed8; }
        .error { color: #dc2626; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <p>Sistem Peminjaman Alat Olahraga</p>

        

        <form action="{{ route('login.proses') }}" method="POST">
            @csrf

            <label for="email">Email</label>
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}" required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Masuk</button>
        </form>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($errors->any())
<script>
    Swal.fire({
        icon: 'error',
        title: 'Login Gagal!',
        text: '{{ $errors->first() }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#2563eb'
    });
</script>
@endif

</body>
</html>