<!DOCTYPE html>
<html>
<head>
    <title>Profil Saya</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #141414;
            color: #fff;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .header {
            background-color: #000;
            padding: 20px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.7);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
        }

        .header h1 {
            margin: 0;
            font-size: 32px;
            color: #e50914;
        }

        .header-buttons {
            display: flex;
            gap: 14px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            transition: 0.3s ease;
        }

        .btn-danger {
            background-color: #e50914;
            color: white;
        }

        .btn-danger:hover {
            background-color: #ff1f2e;
        }

        .btn-secondary {
            background-color: #333;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #555;
        }

        .container {
            max-width: 700px;
            margin: 160px auto 50px;
            background-color: #1f1f1f;
            padding: 50px 40px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.3), 0 0 12px rgba(0, 255, 255, 0.15);
        }

        .avatar {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: linear-gradient(135deg, #e50914, #ff0033);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 48px;
            font-weight: bold;
            color: white;
            margin: 0 auto 24px;
            box-shadow: 0 0 12px rgba(255, 0, 0, 0.5);
        }

        .name {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .email {
            font-size: 16px;
            color: #bbb;
            margin-bottom: 6px;
        }

        .username {
            font-size: 14px;
            color: #888;
            margin-bottom: 20px;
        }

        .badge {
            background: #0ff;
            color: #000;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            margin-top: 12px;
            display: inline-block;
            box-shadow: 0 0 8px rgba(0, 255, 255, 0.5);
        }

        .buttons {
            margin-top: 40px;
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MyFlix Account</h1>
    </div>

    <div class="container">
        @php
            $user = session('user');
            $initials = strtoupper(substr($user['first_name'] ?? 'U', 0, 1));
        @endphp

        @if (session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 12px; border-radius: 6px; text-align: center; margin-bottom: 16px;">
                {{ session('success') }}
            </div>
        @endif

        <div class="avatar">{{ $initials }}</div>
        <div class="name">{{ $user['first_name'] ?? '' }} {{ $user['last_name'] ?? '' }}</div>
        <div class="email">{{ $user['email'] ?? '' }}</div>
        <div class="username">Username: {{ $user['username'] ?? '' }}</div>
        <div class="badge">User Aktif</div>

        <div class="buttons">
            <a href="{{ route('account.edit') }}" class="btn btn-danger">Edit Profil</a>
            <a href="/dashboard/movies" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</body>
</html>