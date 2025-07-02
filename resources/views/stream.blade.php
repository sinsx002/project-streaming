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
        }

        .movie-details {
            margin-bottom: 30px;
        }

        .info-section h2 {
            font-size: 24px;
            margin-bottom: 12px;
        }

        .info-section p {
            font-size: 15px;
            margin-bottom: 10px;
        }

        .tag {
            color: #ff4c4c;
        }

        .btn-back {
            background-color: #e50914;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            margin-top: 30px;
            width: fit-content;
        }

        .btn-back:hover {
            background-color: #b0060e;
        }

        .rating-stars {
            font-size: 28px;
            color: #666;
            cursor: pointer;
            margin-bottom: 12px;
        }


        .rating-stars .star {
            display: inline-block;
        }

        .rating-stars .star.selected,
        .rating-stars .star:hover,
        .rating-stars .star.hover {

        .rating-stars .star.selected {
            color: #ffcc00;
        }


        textarea {
            width: 100%;
            padding: 10px;
            border-radius: 6px;
            border: none;
            resize: vertical;
            margin-bottom: 15px;
        }
        .rating-stars .star:hover {
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
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="video-section">
            <iframe src="https://www.youtube.com/embed/{{ $movie['yt_link'] }}?autoplay=1" allowfullscreen></iframe>
        </div>
        <div class="info-section">
            <div class="movie-details">
                <h2>{{ $movie['title'] }} ({{ \Carbon\Carbon::parse($movie['release_date'])->year }})</h2>
                <p><strong class="tag">Genre:</strong> {{ $movie['genre'] }}</p>
                <p><strong class="tag">Durasi:</strong> {{ $movie['duration'] }} menit</p>
                <p>{{ $movie['description'] }}</p>
            </div>

            <hr style="margin: 30px 0; border-color: #333;">

            <!-- Form Review -->
            <div>
                <h3>Tulis Review:</h3>
                <form method="POST" action="{{ route('reviews.store') }}">
                    @csrf
                    <input type="hidden" name="id_user" value="{{ session('user_id') ?? 0 }}">
                    <input type="hidden" name="id_movie" value="{{ $movie['id_movie'] }}">
                    <input type="hidden" name="rating" id="ratingInput" value="0">

                    <div class="rating-stars" style="margin-bottom: 15px;">
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
            <hr style="margin: 20px 0; border-color: #444;">

            <hr class="my-4">

<h3 class="text-xl font-semibold mb-3">Ulasan Pengguna</h3>

        @if (count($reviews) > 0)
            <div class="space-y-4">
                @foreach ($reviews as $review)
                    <div class="border p-3 rounded shadow-sm">
                        <div class="flex justify-between items-center mb-1">
                            <strong>User ID: {{ $review['id_user'] }}</strong>
                            <span class="text-sm text-gray-500">{{ $review['created_at'] ?? 'Waktu tidak tersedia' }}</span>
                        </div>
                        <div class="text-yellow-500">
                            Rating:
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review['rating'])
                                    ★
                                @else
                                    ☆
                                @endif
                            @endfor
                        </div>
                        <p class="mt-1">{{ $review['comment'] }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-600">Belum ada ulasan untuk film ini.</p>
        @endif

            <!-- Review Form -->
            <form method="POST" action="{{ route('storeReview') }}">
                @csrf
                <input type="hidden" name="id_movie" value="{{ $movie['id_movie'] }}">
                <div id="rating-stars" class="rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating" required>
                <textarea name="comment" required></textarea>
                <button type="submit">Kirim Review</button>
            </form>

            <hr style="margin: 20px 0; border-color: #444;">

            <!-- Review Pengguna -->
            @if($reviews ?? false)
                <div>
                    <h3>Review Pengguna Lain:</h3>
                    @forelse ($reviews as $review)
                        <div style="margin-bottom: 20px; border-bottom: 1px solid #444; padding-bottom: 10px;">
                            <strong style="color: #ff4c4c;">
                                {{ $review['username'] ?? 'Pengguna Anonim' }}
                            </strong>
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

            <a href="{{ url('/dashboard/movies') }}" class="btn-back">Back to Dashboard</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Rating Stars for Review Form
            const starElements = document.querySelectorAll('#rating-stars .star');
            const ratingInput = document.getElementById('rating');
            let selectedRating = 0;

            starElements.forEach(star => {
                star.addEventListener('click', function () {
                    selectedRating = parseInt(this.dataset.value);
                    ratingInput.value = selectedRating;
                    updateFormStars();
                });

                star.addEventListener('mouseover', function () {
                    highlightStars(parseInt(this.dataset.value));
                    highlightFormStars(parseInt(this.dataset.value));
                });

                star.addEventListener('mouseout', function () {
                    highlightFormStars(selectedRating);
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
            function updateFormStars() {
                starElements.forEach(star => {
                    star.classList.toggle('selected', parseInt(star.dataset.value) <= selectedRating);
                });
            }

            function highlightFormStars(value) {
                starElements.forEach(star => {
                    star.classList.toggle('selected', parseInt(star.dataset.value) <= value);
                });
            }
        });
    </script>
    </body>
</html>
