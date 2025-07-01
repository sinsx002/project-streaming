<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Streaming App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #111, #1a1a1a);
            color: white;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .main-card {
            background-color: #222;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(255, 0, 0, 0.3);
            width: 100%;
            max-width: 700px;
        }

        .footer-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 30px;
        }

        .btn-red {
            background-color: #ff0000;
            color: white;
            border: none;
        }

        .btn-outline-red {
            color: #ff0000;
            border: 1px solid #ff0000;
            background: transparent;
        }

        .btn-outline-red:hover {
            background-color: #ff0000;
            color: white;
        }
    </style>
</head>
<body>

    <div class="content-container">
        <div class="main-card">
            @yield('content')

            @if (session('user'))
                <div class="footer-buttons">
                    <a href="/dashboard/movies" class="btn btn-outline-red">🎬 Back to Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-red">Logout</button>
                    </form>
                </div>
            @endif
        </div>
    </div>

</body>
</html>
