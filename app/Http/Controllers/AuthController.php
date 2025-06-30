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
            ->shuffle() // agar random
            ->map(fn($file) => asset('images/' . $file->getFilename()))
            ->values();

        return view('login', ['sliderImages' => $imagePaths]);
    }

    public function login(Request $request)
    {
        $email = $request->email;
        $password = $request->password;

        // Cek ke users.php
        $responseUser = Http::get('http://localhost/project-streamingg/users.php');
        $users = $responseUser->json();
        $user = collect($users)->firstWhere('email', $email);

        if ($user) {
            if ($this->checkPassword($password, $user['password'])) {
                session(['user' => $user, 'role' => 'user']);
                return redirect('/dashboard/movies');
            }
        }

        // Jika tidak ditemukan di users, coba di admin.php
        $responseAdmin = Http::get('http://localhost/project-streamingg/admin.php');
        $admins = $responseAdmin->json();
        $admin = collect($admins)->firstWhere('email', $email);

        if ($admin) {
            if ($this->checkPassword($password, $admin['password'])) {
                session(['user' => $admin, 'role' => 'admin']);
                return redirect('/dashboard/movies');
            }
        }

        // Jika tidak cocok semua
        return back()->with('error', 'Email atau password salah.');
    }

    // Fungsi bantu untuk validasi password
    private function checkPassword($inputPassword, $storedPassword)
    {
        // bcrypt
        if (str_starts_with($storedPassword, '$2y$') && strlen($storedPassword) === 60) {
            return Hash::check($inputPassword, $storedPassword);
        }

        // md5
        if (strlen($storedPassword) === 32 && md5($inputPassword) === $storedPassword) {
            return true;
        }

        // plaintext
        return $inputPassword === $storedPassword;
    }

    // Tambahkan method logout di sini
    public function logout()
    {
        session()->forget('user');
        session()->forget('role');
        return redirect('/login')->with('error', 'Anda telah logout.');
    }
}