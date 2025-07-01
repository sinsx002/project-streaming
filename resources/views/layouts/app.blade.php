<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Streaming App')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #111, #1a1a1a);
            color: #fff;
            min-height: 100vh;
        }
        .navbar {
            background-color: #1f1f1f;
            box-shadow: 0 2px 5px rgba(255, 0, 0, 0.3);
        }
        .navbar-brand {
            color: #ff4d4d;
            font-weight: bold;
        }
        .navbar-brand:hover {
            color: #ff1a1a;
        }
        .container {
            margin-top: 40px;
        }
        footer {
            margin-top: 60px;
            padding: 20px;
            text-align: center;
            background-color: #111;
            color: #999;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg px-4">
        <a class="navbar-brand" href="/dashboard/movies">🎬 Streaming App</a>
        <div class="ms-auto d-flex align-items-center">
            @if (session('user'))
                @if (session('role') === 'admin')
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-warning me-2">Kelola Users</a>
                @else
                    <a href="{{ route('account.show') }}" class="btn btn-outline-primary me-2">Profil Saya</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">Logout</button>
                </form>
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container">
        @yield('content')
    </main>

    <!-- Footer (optional) -->
    <footer>
        &copy; {{ date('Y') }} Streaming App. All rights reserved.
    </footer>

</body>
</html>
