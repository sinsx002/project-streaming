<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function show()
    {
        $user = session('user');

        if (!$user) {
            return redirect('/login')->withErrors(['msg' => 'Silakan login terlebih dahulu.']);
        }

        return view('account.profile', compact('user'));
    }

    public function edit()
    {
        $user = session('user');

        if (!$user) {
            return redirect('/login')->withErrors(['msg' => 'Silakan login terlebih dahulu.']);
        }

        return view('account.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = session('user');

        if (!$user) {
            return redirect('/login')->withErrors(['msg' => 'User tidak ditemukan.']);
        }

        $request->validate([
            'username' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email',
            'current_password' => 'required_with:new_password,new_password_confirmation',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        // Jika user ingin mengubah password
        $newPassword = null;
        if ($request->filled('new_password')) {
            // Verifikasi password lama
            if (!Hash::check($request->current_password, $user['password'])) {
                return redirect()->back()->withErrors(['current_password' => 'Password lama tidak cocok'])->withInput();
            }

            // Enkripsi password baru
            $newPassword = password_hash($request->new_password, PASSWORD_DEFAULT);
        }

        $response = Http::put("http://localhost/project-streamingg/users.php?id_user=" . $user['id_user'], [
            'id_user'    => $user['id_user'],
            'username'   => $request->username,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => $newPassword ?? $user['password'],
        ]);

        if (!$response->ok()) {
            return redirect()->back()->withErrors(['msg' => 'Gagal mengupdate data.'])->withInput();
        }

        // Perbarui session
        $user['username']   = $request->username;
        $user['first_name'] = $request->first_name;
        $user['last_name']  = $request->last_name;
        $user['email']      = $request->email;
        if ($newPassword) {
            $user['password'] = $newPassword;
        }
        session(['user' => $user]);

        return redirect()->route('account.profile')->with('success', 'Profil berhasil diperbarui.');
    }

    public function destroy(Request $request)
    {
        $user = session('user');

        if (!$user) {
            return redirect('/login')->withErrors(['msg' => 'User tidak ditemukan.']);
        }

        $response = Http::delete("http://localhost/project-streamingg/users.php?id_user=" . $user['id_user']);

        if (!$response->ok()) {
            return redirect()->back()->withErrors(['msg' => 'Gagal menghapus akun.']);
        }

        $request->session()->flush();

        return redirect('/login')->with('success', 'Akun berhasil dihapus.');
    }

    public function adminIndex()
    {
        if (session('role') !== 'admin') {
            return redirect('/dashboard/movies');
        }

        $response = Http::get('http://localhost/project-streamingg/users.php');
        $users = $response->json();

        return view('admin.users.index', compact('users'));
    }

    public function adminDestroy($id_user)
    {
        if (session('role') !== 'admin') {
            return redirect('/dashboard/movies');
        }

        $response = Http::withBody(json_encode(['id_user' => $id_user]), 'application/json')
                ->delete("http://localhost/project-streamingg/users.php");

        if ($response->ok()) {
            return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
        } else {
            return redirect()->route('admin.users')->withErrors(['Gagal menghapus user.']);
        }
    }
}