<!DOCTYPE html>
<html>
<head>
    <title>Register - MyFlix</title>
    <style>
        body {
            background-color: #121212;
            font-family: Arial, sans-serif;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-box {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: red;
        }
        label {
            display: block;
            margin-top: 15px;
            font-size: 14px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            background: #333;
            border: 1px solid #555;
            border-radius: 6px;
            color: white;
        }
        button {
            margin-top: 20px;
            width: 100%;
            padding: 12px;
            background-color: red;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }
        .error {
            color: #ff4d4d;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Register</h2>

        @if (session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        <form action="/register" method="POST">
            @csrf
            <label>Username</label>
            <input type="text" name="username" required>

            <label>First Name</label>
            <input type="text" name="first_name" required>

            <label>Last Name</label>
            <input type="text" name="last_name" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Daftar</button>
        </form>
    </div>
</body>
</html>