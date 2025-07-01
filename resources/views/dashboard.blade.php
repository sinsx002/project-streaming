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
            align-items: flex-start;
            justify-content: center;
            flex-grow: 1;
            margin: 0 20px;
            position: relative;
        }

        .search-container {
            position: relative;
            width: 300px;
        }

        .search-bar {
            background-color: #333;
            border: 2px solid red;
            border-radius: 4px 4px 4px 4px;
            padding: 10px 16px;
            color: white;
            font-size: 16px;
            width: 350px;
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

        #suggestions-box {
            position: absolute;
            top: 100%;
            left: 0;
            width: 127%;
            background: #1c1c1c;
            border: 1px solid #444;
            border-top: none;
            border-radius: 0 0 6px 6px;
            max-height: 250px;
            overflow-y: auto;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            display: none;
        }

        #suggestions-box a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px;
            color: white;
            text-decoration: none;
            border-bottom: 1px solid #333;
            transition: background 0.2s;
        }

        #suggestions-box a:last-child {
            border-bottom: none;
        }

        #suggestions-box a:hover {
            background-color: #333;
        }

        #suggestions-box img {
            width: 40px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
            flex-shrink: 0;
        }
    </style>
</head>
<body>
   <div class="header">
    <div style="display: flex; align-items: center; gap: 30px;">
        <h1>MyFlix</h1>
        <form method="GET" action="{{ url('/dashboard/movies') }}" class="search-form" id="search-form">
            <div class="search-container">
                <input type="text" name="search" class="search-bar" id="search-input" placeholder="Search movies..." autocomplete="off" value="{{ request('search') }}">
                <div id="suggestions-box"></div>
            </div>
        </form>
    </div>
    
    <div class="header-buttons">
        @if(session('role') === 'admin')
            <a href="{{ url('/dashboard/movies/create') }}"><button>Tambah Film</button></a>
            <a href="{{ url('/dashboard/movies/edit') }}"><button>Edit Film</button></a>
            <a href="{{ route('admin.users') }}"><button>Kelola user</button></a>
        @endif

        <a href="{{ url('/account') }}"><button>Account</button></a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
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
                        <div class="genre">Genre: {{ $movie['genre'] }}</div>
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById("search-input");
        const suggestionsBox = document.getElementById("suggestions-box");

        searchInput.addEventListener("input", function () {
            const query = this.value;
            if (query.length < 2) {
                suggestionsBox.style.display = "none";
                return;
            }

            fetch(`/dashboard/movies/search-suggestions?search=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length === 0) {
                        suggestionsBox.innerHTML = "<div style='padding:10px; color:#ccc;'>No results</div>";
                    } else {
                        suggestionsBox.innerHTML = data.map(movie =>
                            `<a href="/dashboard/movies/${movie.id}" style="display:flex; align-items:center; gap:10px; padding:10px; color:white; text-decoration:none; border-bottom:1px solid #333;">
                                <img src="/images/${movie.thumbnail.split('/').pop()}" style="width:40px; height:60px; object-fit:cover; border-radius:4px;">
                                <span>${movie.title}</span>
                            </a>`
                        ).join('');
                    }
                    suggestionsBox.style.display = "block";
                });
        });

        document.addEventListener("click", function (e) {
            if (!document.getElementById("search-form").contains(e.target)) {
                suggestionsBox.style.display = "none";
            }
        });
    });
    </script>
</body>
</html>
