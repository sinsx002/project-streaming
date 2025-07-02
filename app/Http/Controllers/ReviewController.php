<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReviewController extends Controller
{
    // Menyimpan review baru
    public function store(Request $request)
    {
        $request->validate([
            'id_movie' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        // Ambil ID user dari session
        $id_user = session('user.id_user');

        // Kirim ke API PHP native
        $response = Http::post('http://localhost/project-streamingg/reviews.php', [
            'id_user' => $id_user,
            'id_movie' => $request->input('id_movie'),
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
            'created_at' => now()->toDateTimeString(),
        ]);

        if ($response->successful()) {
            return back()->with('success', 'Review berhasil dikirim.');
        } else {
            return back()->with('error', 'Gagal mengirim review.');
        }
    }

    // Mengecek apakah user sudah review film ini
    public function checkReview($userId, $movieId)
    {
        $response = Http::get("http://localhost/project-streamingg/reviews.php", [
            'id_user' => $userId,
            'id_movie' => $movieId,
        ]);

        if ($response->successful()) {
            $reviews = $response->json();
            return response()->json(['exists' => count($reviews) > 0]);
        }

        return response()->json(['exists' => false], 500);
    }
}