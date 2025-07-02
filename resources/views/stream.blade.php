<!-- resources/views/stream.blade.php -->
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
            padding: 30px;
            background-color: #1a1a1a;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .movie-details {
            flex-grow: 1;
        }

        .info-section h2 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #ffffff;
        }

        .info-section p {
            font-size: 16px;
            color: #cccccc;
            margin-bottom: 12px;
            line-height: 1.6;
        }

        .tag {
            color: #ff4c4c;
        }

        .btn-back {
            display: inline-block;
            margin-top: 30px;
            background-color: #e50914;
            color: white;
            padding: 12px 24px;
            text-align: center;
            text-decoration: none;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-back:hover {
            background-color: #b0060e;
        }

        .rating-stars {
            font-size: 32px;
            color: #666;
            cursor: pointer;
            margin-bottom: 10px;
        }


        .star {
            display: inline-block;
        }

        .rating-stars .star.selected,
        .rating-stars .star:hover,
        .rating-stars .star.hover {
            color: #ffcc00;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .video-section {
                height: 50vh;
            }
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

                    <div style="margin-bottom: 15px;">
                        <textarea name="comment" rows="4" placeholder="Tulis komentar Anda..." style="width: 100%; padding: 10px; border-radius: 6px; border: none;"></textarea>
                    </div>

                    <button type="submit" class="btn-back" style="margin-top: 0;">Kirim Review</button>
                </form>
            </div>

            <!-- Review Pengguna -->
            @if($reviews ?? false)
                <div style="margin-top: 40px;">
                    <h3>Review Pengguna:</h3>
                    @forelse ($reviews as $review)
                        <div style="margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px;">
                            <div class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $review['rating'] ? 'selected' : '' }}">&#9733;</span>
                                @endfor
                            </div>
                            <p>{{ $review['comment'] }}</p>
                            <small><em>{{ \Carbon\Carbon::parse($review['created_at'])->format('d M Y H:i') }}</em></small>
                        </div>
                    @empty
                        <p>Belum ada review.</p>
                    @endforelse
                </div>
            @endif

            <a href="{{ url('/dashboard/movies') }}" class="btn-back" style="margin-top: 20px;">Back to Dashboard</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('ratingInput');

            stars.forEach(star => {
                star.addEventListener('mouseover', function () {
                    highlightStars(parseInt(this.dataset.value));
                });

                star.addEventListener('mouseout', function () {
                    highlightStars(parseInt(ratingInput.value));
                });

                star.addEventListener('click', function () {
                    const value = parseInt(this.dataset.value);
                    ratingInput.value = value;
                    highlightStars(value);
                });
            });

            function highlightStars(count) {
                stars.forEach((star, index) => {
                    if (index < count) {
                        star.classList.add('selected');
                    } else {
                        star.classList.remove('selected');
                    }
                });
            }
        });
    </script>
</body>
</html>