<!DOCTYPE html>
<html>
<head>
    <title>My Account</title>
</head>
<body style="background:#111; color:white; padding:20px; font-family:sans-serif;">
    <h1>Profil Pengguna</h1>
    <p><strong>ID:</strong> {{ session('user')['id_user'] }}</p>
    <p><strong>Username:</strong> {{ session('user')['username'] }}</p>
    <p><strong>Nama:</strong> {{ session('user')['first_name'] }} {{ session('user')['last_name'] }}</p>
    <p><strong>Email:</strong> {{ session('user')['email'] }}</p>
    <a href="{{ route('account.edit') }}">
        <button style="padding:10px; margin-top:20px;">Edit Profil</button>
    </a>
</body>
</html>
