<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
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

        .search-form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-grow: 1;
            margin: 0 20px;
        }

        .search-bar {
            background-color: #333;
            border: none;
            border-radius: 4px 0 0 4px;
            padding: 10px 16px;
            color: white;
            font-size: 16px;
            width: 300px;
        }

        .search-button {
            background-color: red;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
        }

        .swiper {
            width: 100%;
            max-height: 400px;
            overflow: hidden;
            border-bottom: 4px solid red;
            position: relative;
        }

        .swiper-slide {
            position: relative;
        }

        .swiper-slide img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        .slide-caption {
            position: absolute;
            bottom: 30px;
            left: 50px;
            background: rgba(0,0,0,0.6);
            padding: 20px;
            border-radius: 10px;
            max-width: 600px;
        }

        .slide-caption h2 {
            font-size: 28px;
            margin: 0 0 10px;
        }

        .slide-caption p {
            font-size: 16px;
            color: #ccc;
            margin: 0;
        }

        .section {
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .section h2 {
            margin-bottom: 30px;
            font-size: 28px;
            border-bottom: 2px solid red;
            padding-bottom: 5px;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 24px;
            width: 100%;
            max-width: 1100px;
        }

        .movie-card {
            background-color: #222;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
        }

        .movie-card:hover {
            transform: scale(1.03);
        }

        .movie-card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            display: block;
        }

        .movie-card .info {
            padding: 14px;
        }

        .movie-card .title {
            font-size: 16px;
            font-weight: bold;
            color: white;
        }

        .movie-card .release {
            font-size: 13px;
            color: #aaa;
            margin-top: 4px;
        }

        .movie-card .genre {
            font-size: 13px;
            color: #ff6961;
            margin-top: 4px;
        }

        .movie-card .duration {
            font-size: 13px;
            color: #ffd700;
            margin-top: 4px;
        }

        .movie-card .description {
            font-size: 13px;
            color: #ccc;
            margin-top: 6px;
            line-height: 1.4;
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
    </style>
</head>
<body>
    <div class="header">
        <h1>MyFlix</h1>
        <form method="GET" action="{{ url('/dashboard/movies') }}" class="search-form">
            <input type="text" name="search" class="search-bar" placeholder="Search movies..." value="{{ request('search') }}">
            <button type="submit" class="search-button">Search</button>
        </form>
        <div class="header-buttons">
            @if(session('role') === 'admin')
                <a href="{{ url('/dashboard/movies/create') }}"><button>Tambah Film</button></a>
                <a href="{{ url('/dashboard/movies/edit') }}"><button>Edit Film</button></a>
            @endif
            <a href="{{ url('/account') }}"><button>Account</button></a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button>Logout</button>
            </form>
        </div>
    </div>

    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach(collect($movies)->shuffle()->take(5) as $movie)
                <div class="swiper-slide">
                    <img src="{{ $movie['slider_image'] ?? asset('images/' . basename($movie['thumbnail'])) }}" alt="{{ $movie['title'] }}">
                    <div class="slide-caption">
                        <h2>{{ $movie['title'] }}</h2>
                        <p>{{ $movie['description'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>

    <div class="section">
        <h2>Semua Film</h2>
        <div class="movie-grid">
            @foreach ($movies as $movie)
                <div class="movie-card">
                    <img src="{{ asset('images/' . basename($movie['thumbnail'])) }}" alt="{{ $movie['title'] }}">
                    <div class="info">
                        <div class="title">{{ $movie['title'] }}</div>
                        <div class="release">Rilis: {{ $movie['release_date'] }}</div>
                        <div class="genre">Genre ID: {{ $movie['id_genre'] }}</div>
                        <div class="duration">Durasi: {{ isset($movie['duration']) ? $movie['duration'] . 'm' : 'N/A' }}</div>
                        <div class="description">{{ $movie['description'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: { delay: 3000 },
            slidesPerView: 1,
            pagination: { el: '.swiper-pagination' },
        });
    </script>
</body>
</html>
