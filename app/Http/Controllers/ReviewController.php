<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ReviewController extends Controller
{
    public function checkReview($userId, $movieId)
    {
        // Ambil semua review dari API
        $response = Http::get('http://localhost/project-streamingg/reviews.php');
        $allReviews = $response->json();

        // Cari review spesifik
        $review = null;
        if (is_array($allReviews)) {
            foreach ($allReviews as $item) {
                if ($item['id_user'] == $userId && $item['id_movie'] == $movieId) {
                    $review = $item;
                    break;
                }
            }
        }

        return response()->json($review);
    }

    public function store(Request $request)
    {
        $reviewData = [
            'id_review' => time(), // atau gunakan uniqid()
            'id_user' => (int) $request->input('id_user'),
            'id_movie' => (int) $request->input('id_movie'),
            'rating' => (int) $request->input('rating'),
            'comment' => $request->input('comment'),
            'created_at' => now()->format('Y-m-d H:i:s'),
        ];

        $response = Http::post('http://localhost/project-streamingg/reviews.php', $reviewData);

        if ($response->successful()) {
            return redirect()->back()->with('success', 'Review berhasil dikirim!');
        }

        return redirect()->back()->with('error', 'Gagal mengirim review.');
    }
}