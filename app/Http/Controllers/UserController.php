<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost/project-streamingg/users.php');
        $users = $response->json();

        return view('admin.users.index', compact('users'));
    }

    public function destroy($id)
    {
        $response = Http::delete("http://localhost/project-streamingg/users.php?id_user={$id}");

        if ($response->ok()) {
            return redirect()->route('admin.users')->with('success', 'User berhasil dihapus.');
        } else {
            return redirect()->route('admin.users')->withErrors(['Gagal menghapus user.']);
        }
    }
}
