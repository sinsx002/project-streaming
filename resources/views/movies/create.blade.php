<!DOCTYPE html>
<html>
<head>
    <title>Tambah Film</title>
    <style>
        body {
            background-color: #141414;
            color: white;
            padding: 50px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h2 {
            font-size: 32px;
            color: red;
            margin-bottom: 30px;
        }
        form {
            max-width: 600px;
            width: 100%;
            background-color: #1f1f1f;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
            display: grid;
            grid-template-columns: 150px 1fr;
            grid-gap: 15px;
            align-items: center;
        }
        label {
            font-weight: bold;
            color: #ccc;
            margin-bottom: 0;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        input[type="file"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            background: #2a2a2a;
            border: 1px solid #444;
            color: white;
            border-radius: 6px;
            font-size: 15px;
        }
        textarea {
            resize: vertical;
            grid-column: span 1;
        }
        button {
            grid-column: span 2;
            margin-top: 25px;
            padding: 12px 25px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #e60000;
        }
        .alert-danger {
            background: #722;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            grid-column: span 2;
        }
        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }
        .back-link {
            margin-top: 20px;
            color: white;
            text-decoration: none;
            font-weight: bold;
            background-color: #444;
            padding: 10px 20px;
            border-radius: 6px;
        }
        .back-link:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
    <h2>Tambah Film Baru</h2>

    @if ($errors->any())
        <div class="alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ url('/dashboard/movies') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <label for="title">Judul:</label>
        <input type="text" name="title" id="title" required>

        <label for="release_date">Tanggal Rilis:</label>
        <input type="date" name="release_date" id="release_date" required>

        <label for="id_genre">ID Genre:</label>
        <input type="number" name="id_genre" id="id_genre" required>

        <label for="duration">Durasi (menit):</label>
        <input type="number" name="duration" id="duration">

        <label for="description">Deskripsi:</label>
        <textarea name="description" id="description" rows="5" required></textarea>

        <label for="thumbnail">Pilih Thumbnail:</label>
        <select name="thumbnail">
            <option value="">-- Pilih Thumbnail --</option>
            @foreach ($imageFiles as $image)
                <option value="{{ $image }}">{{ $image }}</option>
            @endforeach
        </select>

        <button type="submit">Simpan</button>
    </form>

    <a class="back-link" href="{{ url('/dashboard/movies') }}">&larr; Kembali ke Dashboard</a>
</body>
</html>