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
            position: relative;
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
        .rating-stars .star {
            display: inline-block;
            transition: color 0.2s;
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

            @php
                $userId = session('user_id');
                $movieId = $movie['id_movie'];
            @endphp

            @csrf
                <input type="hidden" name="id_user" value="0"> <!-- atau kosongkan saja jika tidak digunakan -->
                <input type="hidden" name="id_movie" value="{{ $movie['id_movie'] }}">

                <div class="rating-stars" style="margin-bottom: 15px;">
                    <input type="hidden" name="rating" id="ratingInput" value="0">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="star" data-value="{{ $i }}">&#9733;</span>
                    @endfor
                </div>

                <div style="margin-bottom: 15px;">
                    <textarea name="comment" rows="4" placeholder="Tulis komentar Anda..." style="width: 100%; padding: 10px; border-radius: 6px; border: none;"></textarea>
                </div>

                <button type="submit" class="btn-back" style="margin-top: 0;">Kirim Review</button>
            </form>

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

            <a href="{{ url('/dashboard/movies') }}" class="btn-back">Back to Dashboard</a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star');
            const ratingInput = document.getElementById('ratingInput');

            stars.forEach(star => {
                star.addEventListener('mouseover', function () {
                    const value = parseInt(this.dataset.value);
                    highlightStars(value);
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

    <h2>Review Anda</h2>
    <div id="review-container" style="margin-bottom: 30px;">
        <p style="color: #aaa;">Memuat review Anda...</p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('review-container');

            fetch(`/review/check/{{ $userId }}/{{ $movieId }}`)
                .then(res => res.json())
                .then(data => {
                    container.innerHTML = '';

                    if (data && data.rating && data.comment) {
                        container.innerHTML = `
                            <div class="rating-stars">
                                ${[1,2,3,4,5].map(i => 
                                    `<span class="star ${i <= data.rating ? 'selected' : ''}">&#9733;</span>`
                                ).join('')}
                            </div>
                            <p>${data.comment}</p>
                            <small><em>${new Date(data.created_at).toLocaleString()}</em></small>
                        `;
                    } else {
                        container.innerHTML = `
                            <form method="POST" action="{{ route('reviews.store') }}">
                                @csrf
                                <input type="hidden" name="id_user" value="{{ $userId }}">
                                <input type="hidden" name="id_movie" value="{{ $movieId }}">
                                <input type="hidden" name="rating" id="ratingInput" value="0">

                                <div class="rating-stars" style="margin-bottom: 15px;">
                                    ${[1,2,3,4,5].map(i => 
                                        `<span class="star" data-value="${i}">&#9733;</span>`
                                    ).join('')}
                                </div>

                                <textarea name="comment" rows="4" placeholder="Tulis komentar Anda..." style="width: 100%; padding: 10px; border-radius: 6px; border: none;"></textarea>
                                <button type="submit" class="btn-back" style="margin-top: 15px;">Kirim Review</button>
                            </form>
                        `;

                        // Aktifkan bintang
                        setupStars();
                    }
                });

            function setupStars() {
                const stars = document.querySelectorAll('.rating-stars .star');
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
            }
        });
    </script>
</body>
</html>