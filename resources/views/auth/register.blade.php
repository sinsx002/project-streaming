<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Form Registrasi</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <label>Nama</label><br>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div>
            <label>Email</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div>

        <div>
            <label>Konfirmasi Password</label><br>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Daftar Sekarang</button>
    </form>

    <p>Sudah punya akun? <a href="{{ route('login') }}">Login di sini</a></p>
</body>
</html>
