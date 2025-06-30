<!DOCTYPE html>
<html>
<head>
    <title>Edit Film</title>
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
        }
        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
            font-weight: bold;
            color: #ccc;
        }
        input,
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
        }
        button {
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
    <h2>Edit Film</h2>

    @if ($errors->any())
        <div class="alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ url('/dashboard/movies/' . $movie['id_movie']) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="title">Judul:</label>
        <input type="text" name="title" id="title" value="{{ $movie['title'] }}" required>

        <label for="release_date">Tanggal Rilis:</label>
        <input type="date" name="release_date" id="release_date" value="{{ $movie['release_date'] }}" required>

        <label for="id_genre">ID Genre:</label>
        <input type="number" name="id_genre" id="id_genre" value="{{ $movie['id_genre'] }}" required>

        <label for="duration">Durasi (menit):</label>
        <input type="number" name="duration" id="duration" value="{{ $movie['duration'] }}">

        <label for="description">Deskripsi:</label>
        <textarea name="description" id="description" rows="5" required>{{ $movie['description'] }}</textarea>

        <label for="thumbnail">Thumbnail Saat Ini: <strong>{{ $movie['thumbnail'] }}</strong></label>
        <select name="thumbnail" id="thumbnail">
            @foreach ($imageFiles as $image)
                <option value="{{ $image }}" {{ $image == $movie['thumbnail'] ? 'selected' : '' }}>{{ $image }}</option>
            @endforeach
        </select>

        <button type="submit">Simpan Perubahan</button>
    </form>

    <a class="back-link" href="{{ url('/dashboard/movies') }}">&larr; Kembali ke Daftar Film</a>
</body>
</html>