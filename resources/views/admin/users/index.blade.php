<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
    <style>
        body {
            background-color: #121212;
            color: #e0e0e0;
            padding: 40px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            font-size: 36px;
            color: #ff3c3c;
            margin-bottom: 25px;
        }

        .header-buttons {
            margin-bottom: 25px;
            display: flex;
            gap: 12px;
        }

        .header-buttons a, .header-buttons form button {
            background: linear-gradient(to right, #555, #444);
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 15px;
            border: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .header-buttons a:hover, .header-buttons form button:hover {
            background: linear-gradient(to right, #777, #555);
            transform: scale(1.05);
        }

        .alert {
            padding: 14px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            max-width: 1000px;
            font-size: 15px;
        }

        .alert-success {
            background-color: #1e3322;
            border: 1px solid #0f0;
            color: #90ee90;
        }

        .alert-danger {
            background-color: #3a1a1a;
            border: 1px solid #f00;
            color: #ff6b6b;
        }

        table {
            width: 100%;
            max-width: 1000px;
            background-color: #1a1a1a;
            border-collapse: collapse;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.8);
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 18px;
            border-bottom: 1px solid #333;
            text-align: left;
            font-size: 15px;
        }

        th {
            background-color: #222;
            color: #f8f8f8;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        td {
            background-color: #1e1e1e;
        }

        tr:hover td {
            background-color: #262626;
        }

        button {
            background-color: #e50914;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        button:hover {
            background-color: #ff1f1f;
        }
    </style>
</head>
<body>
    <h2>Daftar Pengguna</h2>

    <div class="header-buttons">
        <a href="/dashboard/movies">Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $err)
                <div>{{ $err }}</div>
            @endforeach
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $u)
                <tr>
                    <td>{{ $u['id_user'] }}</td>
                    <td>{{ $u['username'] }}</td>
                    <td>{{ $u['first_name'] ?? '' }} {{ $u['last_name'] ?? '' }}</td>
                    <td>{{ $u['email'] }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.users.destroy', $u['id_user']) }}" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>