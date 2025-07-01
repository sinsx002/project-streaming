<!DOCTYPE html>
<html>
<head>
    <title>Edit Daftar Film</title>
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
        a, button {
            background-color: red;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            margin: 2px;
        }
        a:hover, button:hover {
            background-color: #e60000;
        }
        .success-message {
            color: limegreen;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .delete-form {
            display: inline-block;
        }
    </style>
</head>
<body>
    <h2>Daftar Film</h2>

    <a class="back-button" href="{{ url('/dashboard/movies') }}">&larr; Kembali ke Dashboard</a>

    @if (session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Genre</th>
                <th>Rilis</th>
                <th>Durasi</th>
                <th>Thumbnail</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($movies as $movie)
                <tr>
                    <td>{{ $movie['id_movie'] }}</td>
                    <td>{{ $movie['title'] }}</td>
                    <td>{{ $movie['genre'] }}</td>
                    <td>{{ $movie['release_date'] }}</td>
                    <td>{{ isset($movie['duration']) ? $movie['duration'] . 'm' : '-' }}</td>
                    <td>{{ $movie['thumbnail'] ?? '-' }}</td>
                    <td>
                        <a href="{{ url('/dashboard/movies/' . $movie['id_movie'] . '/edit') }}">Edit</a>
                        <form action="{{ url('/dashboard/movies/' . $movie['id_movie']) }}" method="POST" class="delete-form" onsubmit="return confirm('Apakah Anda yakin ingin menghapus film ini?');">
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