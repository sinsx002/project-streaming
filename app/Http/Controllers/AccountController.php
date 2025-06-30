<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    public function show()
    {
        return view('account');
    }

    public function edit()
    {
        return view('account_edit');
    }

    public function update(Request $request)
    {
        $user = session('user');

        // Simpan ke API (users.php)
        $response = Http::put('http://localhost/project-streamingg/users.php?id_user=' . $user['id_user'], [
            'username'   => $request->username,
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
        ]);

        // Update session
        $updatedUser = $user;
        $updatedUser['username'] = $request->username;
        $updatedUser['first_name'] = $request->first_name;
        $updatedUser['last_name'] = $request->last_name;
        $updatedUser['email'] = $request->email;

        session(['user' => $updatedUser]);

        return redirect()->route('account.show')->with('success', 'Profil berhasil diperbarui.');
    }
}
