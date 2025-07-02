<!DOCTYPE html>
<html>
<head>
    <title>Watch History</title>
    <style>
        body { background-color: #121212; color: white; font-family: sans-serif; padding: 30px; }
        h1 { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #444; text-align: left; }
        a { color: #ff4c4c; text-decoration: none; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Riwayat Tontonan Anda</h1>

    @if ($historyWithMovie->isEmpty())
        <p>Belum ada riwayat tontonan.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Judul Film</th>
                    <th>Waktu Ditonton</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($historyWithMovie as $item)
                    <tr>
                        <td>{{ $item['title'] }}</td>
                        <td>{{ \Carbon\Carbon::parse($item['watched_at'])->format('d M Y H:i') }}</td>
                        <td><a href="{{ url('/dashboard/movies/stream/' . $item['movie_id']) }}">Tonton Lagi</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <br>
    <a href="{{ url('/dashboard/movies') }}">← Kembali ke Dashboard</a>
</body>
</html>
