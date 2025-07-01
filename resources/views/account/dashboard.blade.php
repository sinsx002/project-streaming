<!DOCTYPE html>
<html>
<head>
    <title>Profil Akun</title>
    <style>
        body {
            background-color: #141414;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            padding-top: 90px;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            padding: 20px;
            background-color: #000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.7);
        }

        .header h1 {
            color: red;
            margin: 0;
        }

        .header-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #1e1e1e;
            border-radius: 10px;
        }

        h2 {
            color: red;
            margin-bottom: 20px;
        }

        .info p {
            font-size: 16px;
            margin: 8px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: red;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: darkred;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MyFlix</h1>
        <div class="header-buttons">
            <a href="{{ url('/dashboard') }}"><button>Dashboard</button></a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button>Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h2>Profil Akun</h2>
        <div class="info">
            <p><strong>Nama:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Tanggal Daftar:</strong> {{ $user->created_at->format('d M Y') }}</p>
        </div>
        <a href="{{ route('account.edit') }}" class="btn">Edit Akun</a>
    </div>
</body>
</html>