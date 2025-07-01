<!DOCTYPE html>
<html>
<head>
    <title>Daftar Pengguna</title>
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
        .back-button {
            background-color: gray;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .back-button:hover {
            background-color: #555;
        }
        table {
            width: 100%;
            max-width: 1000px;
            background-color: #1f1f1f;
            border-collapse: collapse;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px 16px;
            border: 1px solid #444;
            text-align: left;
            font-size: 14px;
        }
        th {
            background-color: #333;
            font-size: 15px;
            color: #f0f0f0;
        }
        td {
            background-color: #2a2a2a;
        }
        button {
            background-color: red;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e60000;
        }
        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            max-width: 1000px;
        }
        .alert-success {
            background-color: #223322;
            border: 1px solid #0f0;
            color: #0f0;
        }
        .alert-danger {
            background-color: #331111;
            border: 1px solid #f00;
            color: #f00;
        }
        .header-buttons {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .header-buttons a, .header-buttons form button {
            background-color: gray;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }
        .header-buttons a:hover, .header-buttons form button:hover {
            background-color: #555;
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