<!DOCTYPE html>
<html>
<head>
    <title>Edit Pengguna</title>
    <style>
        body {
            background-color: #141414;
            color: white;
            padding: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            font-size: 32px;
            color: red;
            margin-bottom: 20px;
        }

        form {
            background-color: #1f1f1f;
            padding: 20px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
            max-width: 600px;
            width: 100%;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: none;
            border-radius: 5px;
            background-color: #2a2a2a;
            color: white;
        }

        .form-buttons {
            display: flex;
            justify-content: space-between;
        }

        button, .cancel-button {
            background-color: red;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        button:hover, .cancel-button:hover {
            background-color: #e60000;
        }

        .success-message {
            color: limegreen;
            margin-bottom: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Edit Pengguna</h2>

    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="success-message" style="color: yellow;">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form action="{{ route('account.update') }}" method="POST">
        @csrf
        @method('PUT')

        <label for="username">Username</label>
        <input type="text" id="username" name="username" value="{{ old('username', $user['username']) }}" required>

        <label for="first_name">Nama Depan</label>
        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $user['first_name']) }}">

        <label for="last_name">Nama Belakang</label>
        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $user['last_name']) }}">

        <label for="email">Email</label>
        <input type="text" id="email" name="email" value="{{ old('email', $user['email']) }}">

        <hr style="border: none; border-top: 1px solid #444; margin: 30px 0;">

        <h3 style="color: #e50914; margin-bottom: 10px;">Ubah Password</h3>

        <label for="current_password">Password Lama</label>
        <input type="password" id="current_password" name="current_password" required>

        <label for="new_password">Password Baru</label>
        <input type="password" id="new_password" name="new_password" required>

        <label for="new_password_confirmation">Konfirmasi Password Baru</label>
        <input type="password" id="new_password_confirmation" name="new_password_confirmation" required>

        <div class="form-buttons">
            <button type="submit">Simpan Perubahan</button>
            <a href="{{ url('/account') }}" class="cancel-button">Cancel</a>
        </div>
    </form>
</body>
</html>