<!DOCTYPE html>
<html>

<head>
    <title>{{ $movie['title'] }}</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0d0d0d;
            color: #f1f1f1;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            display: flex;
            flex-direction: row;
            height: 100vh;
        }

        .video-section {
            flex: 2;
            background-color: #000;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .info-section {
            flex: 1;
            padding: 40px 30px;
            background-color: #1a1a1a;
            overflow-y: auto;
        }

        .movie-details h2 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .movie-details p {
            font-size: 16px;
            color: #cccccc;
            margin-bottom: 12px;
        }

        .tag {
            color: #ff4c4c;
        }

        .btn-back {
            display: inline-block;
            background-color: #e50914;
            color: white;
            padding: 10px 20px;
            text-align: center;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-back:hover {
            background-color: #b0060e;
        }

        .rating-stars {
            font-size: 26px;
            color: #666;
            cursor: pointer;
        }

        .star {
            display: inline-block;
            transition: color 0.2s;
        }

        .star.selected {
            color: #ffcc00;
        }

        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: none;
            resize: vertical;
        }

        hr {
            border-color: #333;
            margin: 25px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="video-section">
            <iframe src="https://www.youtube.com/embed/{{ $movie['yt_link'] }}" allowfullscreen></iframe>
        </div>

        <div class="info-section">
            <div class="movie-details">
                <h2>{{ $movie['title'] }} ({{ \Carbon\Carbon::parse($movie['release_date'])->year }})</h2>
                <p><strong class="tag">Genre:</strong> {{ $movie['genre'] }}</p>
                <p><strong class="tag">Durasi:</strong> {{ $movie['duration'] }} menit</p>
                <p>{{ $movie['description'] }}</p>
            </div>

            <hr>

            {{-- Form Review --}}
            <form method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <input type="hidden" name="id_user" value="{{ session('user_id', 0) }}">
                <input type="hidden" name="id_movie" value="{{ $movie['id_movie'] }}">
                <input type="hidden" name="rating" id="ratingInput" value="0">

                <div class="rating-stars" id="starRating">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                </div>

                <textarea name="comment" rows="4" placeholder="Tulis komentar Anda..."></textarea>
                <button type="submit" class="btn-back" style="margin-top: 10px;">Kirim Review</button>
            </form>

            {{-- Review Pengguna --}}
            <div style="margin-top: 30px;">
                <h3>Review Pengguna:</h3>
                @forelse ($reviews as $review)
                    <div style="margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px;">
                        <strong>{{ $review['user_name'] ?? 'User' }}</strong>
                        <div class="rating-stars">
                            @for ($i = 1; $i <= 5; $i++)
                                @php $selected = $i <= (int) $review['rating'] ? 'selected' : ''; @endphp
                                <span class="star {{ $selected }}">&#9733;</span>
                            @endfor
                        </div>
                        <p>{{ $review['comment'] }}</p>
                        <small><em>{{ \Carbon\Carbon::parse($review['created_at'])->format('d M Y H:i') }}</em></small>
                    </div>
                @empty
                    <p>Belum ada review.</p>
                @endforelse

            </div>

            <a href="{{ url('/dashboard/movies') }}" class="btn-back" style="margin-top: 20px;">Back to Dashboard</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('#starRating .star');
            const ratingInput = document.getElementById('ratingInput');

            function highlightStars(count) {
                stars.forEach((star, index) => {
                    star.classList.toggle('selected', index < count);
                });
            }

            stars.forEach(star => {
                star.addEventListener('click', function () {
                    const value = parseInt(this.dataset.value);
                    ratingInput.value = value;
                    highlightStars(value);
                    console.log("Rating dipilih:", value);
                });

                star.addEventListener('mouseover', function () {
                    const value = parseInt(this.dataset.value);
                    highlightStars(value);
                });

                star.addEventListener('mouseout', function () {
                    highlightStars(parseInt(ratingInput.value));
                });
            });
        });
    </script>
</body>

</html>