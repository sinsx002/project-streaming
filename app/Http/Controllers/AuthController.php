<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;


class AuthController extends Controller
{
    public function showLogin()
    {
        $imageFiles = File::files(public_path('images'));

        $imagePaths = collect($imageFiles)
            ->filter(fn($file) => in_array($file->getExtension(), ['jpg', 'jpeg', 'png', 'webp']))
            ->shuffle()
            ->map(fn($file) => asset('images/' . $file->getFilename()))
            ->values();

        return view('login', ['sliderImages' => $imagePaths]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Cek ke users.php
        $responseUser = Http::get('http://localhost/project-streamingg/users.php');
        $users = $responseUser->json();
        $user = collect($users)->firstWhere('email', $credentials['email']);

        if ($user && $this->checkPassword($credentials['password'], $user['password'])) {
            session(['user' => $user, 'role' => 'user']);
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/movies');
        }

        // Cek ke admin.php
        $responseAdmin = Http::get('http://localhost/project-streamingg/admin.php');
        $admins = $responseAdmin->json();
        $admin = collect($admins)->firstWhere('email', $credentials['email']);

        if ($admin && $this->checkPassword($credentials['password'], $admin['password'])) {
            session(['user' => $admin, 'role' => 'admin']);
            session(['user_id' => $user->id_user]); // atau id_admin jika admin
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/movies');
        }

        return back()->with('error', 'Email atau password salah.');
    }

    private function checkPassword($inputPassword, $storedPassword)
    {
        if (str_starts_with($storedPassword, '$2y$') && strlen($storedPassword) === 60) {
            return Hash::check($inputPassword, $storedPassword);
        }

        if (strlen($storedPassword) === 32 && md5($inputPassword) === $storedPassword) {
            return true;
        }

        return $inputPassword === $storedPassword;
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        session()->forget('user');
        session()->forget('role');

        return redirect('/login')->with('error', 'Anda telah logout.');
    }

    public function showRegister()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $response = Http::get('http://localhost/project-streamingg/users.php');
        $users = $response->json();

        $lastId = collect($users)->max('id_user') ?? 0;
        $newId = $lastId + 1;

        $response = Http::post('http://localhost/project-streamingg/users.php', [
            'id_user'    => $newId,
            'username'   => $request->username,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => $request->password,
        ]);

        $result = $response->json();

        if (isset($result['message']) && $result['message'] === 'User added') {
            return redirect('/login')->with('success', 'Berhasil mendaftar. Silakan login.');
        } else {
            return back()->with('error', $result['message'] ?? 'Gagal mendaftar');
        }
    }
}