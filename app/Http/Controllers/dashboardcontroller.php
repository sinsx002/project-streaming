<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
   public function dashboard()
    {
        $user = session('user');

        if (!$user) {
            return redirect('/login')->with('error', 'Silakan login dulu.');
        }

        $response = Http::get('http://localhost/project-streamingg/movies.php');
        $movies = $response->json();

        return view('dashboard', compact('user', 'movies'));
    }
}