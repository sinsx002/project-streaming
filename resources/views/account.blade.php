<!DOCTYPE html>
<html>
<head>
    <title>My Account</title>
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
            gap: 10px;
        }

        button {
            background-color: red;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #222;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
        }

        h2 {
            border-bottom: 2px solid red;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .profile-item {
            margin-bottom: 15px;
        }

        .profile-item strong {
            display: inline-block;
            width: 120px;
            color: #ff6961;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>MyFlix</h1>
        <div class="header-buttons">
            <a href="{{ url('/dashboard/movies') }}"><button>Dashboard</button></a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button>Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h2>Profil Pengguna</h2>
        <div class="profile-item"><strong>ID:</strong> {{ session('user')['id_user'] }}</div>
        <div class="profile-item"><strong>Username:</strong> {{ session('user')['username'] }}</div>
        <div class="profile-item"><strong>Nama:</strong> {{ session('user')['first_name'] }} {{ session('user')['last_name'] }}</div>
        <div class="profile-item"><strong>Email:</strong> {{ session('user')['email'] }}</div>

        <a href="{{ route('account.edit') }}">
            <button style="margin-top: 20px;">Edit Profil</button>
        </a>
    </div>
</body>
</html>