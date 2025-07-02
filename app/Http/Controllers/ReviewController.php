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
}