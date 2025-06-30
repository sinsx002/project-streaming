<!DOCTYPE html>
<html>
<head>
    <title>Login - MyFlix</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .swiper {
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .swiper-slide {
            position: relative;
            overflow: hidden;
        }

        .swiper-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.4);
            animation: zoomIn 10s ease-in-out infinite;
        }

        @keyframes zoomIn {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            position: relative;
            z-index: 1;
        }

        .login-box {
            background-color: rgba(34, 34, 34, 0.85);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 400px;
            transition: opacity 0.8s, transform 0.8s;
        }

        .login-box.fade-out {
            animation: fadeOut 0.8s forwards;
        }

        @keyframes fadeOut {
            to {
                opacity: 0;
                transform: scale(0.9);
            }
        }

        .login-box h2 {
            margin-bottom: 30px;
            color: red;
            text-align: center;
            font-size: 28px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #ccc;
        }

        input[type="email"], input[type="password"], button {
            width: 100%;
            padding: 12px;
            background: #333;
            border: 1px solid #555;
            border-radius: 6px;
            color: white;
            margin-bottom: 20px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: red;
            border: none;
            transition: background 0.3s;
        }

        button:hover {
            background-color: #cc0000;
        }

        .error {
            color: #ff4d4d;
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
        }

        .footer-link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #aaa;
        }

        .footer-link a {
            color: red;
            text-decoration: none;
        }

        .footer-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <!-- Swiper Background -->
    <div class="swiper">
        <div class="swiper-wrapper">
            @foreach($sliderImages as $img)
                <div class="swiper-slide">
                    <img src="{{ $img }}" alt="Background">
                </div>
            @endforeach
        </div>
    </div>

    <!-- Login Form -->
    <div class="login-container">
        <div class="login-box">
            <h2>Login to MyFlix</h2>

            @if(session('error'))
                <p class="error">{{ session('error') }}</p>
            @endif

            <form method="POST" action="/login" id="login-form">
                @csrf
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>

                <label for="password">Password</label>
                <input type="password" name="password" id="password" required>

                <button type="submit">Login</button>
            </form>

            <div class="footer-link">
                Belum punya akun? <a href="{{ url('/register') }}">Daftar sekarang</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper', {
            loop: true,
            autoplay: {
                delay: 10000,
                disableOnInteraction: false,
            },
            speed: 10000,
            slidesPerView: 1,
            allowTouchMove: false,
            effect: 'slide',
        });

        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();
            const box = document.querySelector('.login-box');
            box.classList.add('fade-out');
            setTimeout(() => {
                e.target.submit();
            }, 800);
        });
    </script>
</body>
</html>