<?php

namespace App\Http\Controllers;

use App\Models\movies;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;

class MovieController extends Controller
{
    public function index()
    {
        $response = Http::get('http://localhost/project-streamingg/movies.php');
        $movies = $response->json();

        return view('movies.index', compact('movies'));
    }

    public function create()
    {
        $imageFiles = [];

        $imageDir = public_path('images');
        if (is_dir($imageDir)) {
            $files = scandir($imageDir);
            foreach ($files as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) {
                    $imageFiles[] = $file;
                }
            }
        }

        return view('movies.create', compact('imageFiles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'genre' => 'required|string',
            'release_date' => 'required|date',
            'description' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'duration' => 'nullable|integer',
        ]);

        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $extension = $request->file('image')->getClientOriginalExtension();
            $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;

            $request->file('image')->move(public_path('images'), $filename);

            // Masukkan nama file sebagai thumbnail
            $data['thumbnail'] = $filename;
        } else {
            $data['thumbnail'] = null;
        }

        // Ambil ID terakhir dari API untuk generate ID baru
        $getResponse = Http::get('http://localhost/project-streamingg/movies.php');
        if ($getResponse->successful()) {
            $movies = $getResponse->json();
            $lastId = 0;
            foreach ($movies as $movie) {
                if (isset($movie['id_movie']) && $movie['id_movie'] > $lastId) {
                    $lastId = $movie['id_movie'];
                }
            }
            $data['id_movie'] = $lastId + 1;
        } else {
            return back()->withErrors(['message' => 'Gagal mengambil ID terakhir film.']);
        }

        // Kirim data ke API
        $postResponse = Http::post('http://localhost/project-streamingg/movies.php', $data);

        if ($postResponse->successful()) {
            return redirect('/dashboard/movies')->with('success', 'Film berhasil ditambahkan!');
        } else {
            return back()->withErrors(['message' => 'Gagal menambahkan film.']);
        }
    }

        public function edit()
    {
        $response = Http::get('http://localhost/project-streamingg/movies.php');
        $movies = $response->json();
        return view('movies.edit', compact('movies'));
    }

    public function destroy($id)
    {
        $response = Http::withBody(json_encode(['id_movie' => (int) $id]), 'application/json')
            ->delete('http://localhost/project-streamingg/movies.php');

        if ($response->successful()) {
            return redirect('/dashboard/movies/edit')->with('success', 'Film berhasil dihapus!');
        } else {
            return back()->withErrors(['message' => 'Gagal menghapus film.']);
        }
    }

    public function editFilm($id)
    {
        // Ambil semua film dari API
        $response = Http::get('http://localhost/project-streamingg/movies.php');
        if (!$response->successful()) {
            return back()->withErrors(['message' => 'Gagal mengambil data film.']);
        }

        $movies = $response->json();
        $movie = collect($movies)->firstWhere('id_movie', (int) $id);

        if (!$movie) {
            return back()->withErrors(['message' => 'Film tidak ditemukan.']);
        }

        // Ambil semua gambar dari direktori /public/images
        $imageFiles = [];
        $imageDir = public_path('images');
        if (is_dir($imageDir)) {
            $files = scandir($imageDir);
            foreach ($files as $file) {
                if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png'])) {
                    $imageFiles[] = $file;
                }
            }
        }

        return view('movies.editfilm', compact('movie', 'imageFiles'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'genre' => 'required|string',
            'release_date' => 'required|date',
            'description' => 'required|string',
            'images' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'duration' => 'nullable|integer',
            'yt_link' => 'required|string',
        ]);

        $data = $validated;
        $data['id_movie'] = (int) $id;

        if ($request->hasFile('images')) {
            $originalName = $request->file('images')->getClientOriginalName();
            $extension = $request->file('images')->getClientOriginalExtension();
            $filename = time() . '_' . Str::slug(pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
            $request->file('images')->move(public_path('images'), $filename);
            $data['thumbnail'] = $filename;
        } else {
            $data['thumbnail'] = $request->input('existing_thumbnail');
        }

        $response = Http::withBody(json_encode($data), 'application/json')
            ->put('http://localhost/project-streamingg/movies.php');

        if ($response->successful()) {
            return redirect('/dashboard/movies/edit')->with('success', 'Film berhasil diperbarui!');
        } else {
            return back()->withErrors(['message' => 'Gagal memperbarui film.']);
        }
    }

    public function searchSuggestions(Request $request)
    {
        $keyword = $request->get('search');

        $response = Http::get('http://localhost/project-streamingg/movies.php');
        if (!$response->successful()) {
            return response()->json([]);
        }

        $movies = collect($response->json());

        $filtered = $movies->filter(function ($movie) use ($keyword) {
            return stripos($movie['title'], $keyword) !== false;
        })->take(5)->map(function ($movie) {
            return [
                'id' => $movie['id_movie'],
                'title' => $movie['title'],
                'thumbnail' => $movie['thumbnail'],
            ];
        })->values();

        return response()->json($filtered);
    }

    public function stream($id)
    {
        $response = Http::get('http://localhost/project-streamingg/movies.php');
        if (!$response->successful()) {
            return back()->withErrors(['message' => 'Gagal mengambil data film.']);
        }

        $movies = $response->json();
        $movie = collect($movies)->firstWhere('id_movie', (int) $id);
        if (!$movie) {
            return back()->withErrors(['message' => 'Film tidak ditemukan.']);
        }

        $reviewResponse = Http::get('http://localhost/project-streamingg/reviews.php');
        $allReviews = $reviewResponse->json();

        // Validasi agar tidak error saat $allReviews bukan array
        $filteredReviews = [];
        if (is_array($allReviews)) {
            $filteredReviews = array_filter($allReviews, function ($review) use ($id) {
                return $review['id_movie'] == $id;
            });
        }

        return view('stream', [
            'movie' => $movie,
            'reviews' => $filteredReviews
        ]);
    }

    public function storeReview(Request $request)
    {
        $validated = $request->validate([
            'id_movie' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string',
        ]);

        // Jika id_user tetap diperlukan, kamu bisa pakai default:
        $reviewData = $validated;
        $reviewData['id_user'] = $request->input('id_user', 0); // default ke 0 jika tidak ada
        $reviewData['created_at'] = now()->toDateTimeString();

        // Ambil ID terakhir review
        $response = Http::get('http://localhost/project-streamingg/reviews.php');
        if (!$response->successful()) {
            return back()->withErrors(['message' => 'Gagal mengambil review.']);
        }

        $allReviews = $response->json();
        $lastId = 0;

        if (is_array($allReviews)) {
            foreach ($allReviews as $review) {
                if (isset($review['id_review']) && $review['id_review'] > $lastId) {
                    $lastId = $review['id_review'];
                }
            }
        } else {
            return back()->withErrors(['message' => 'Data review tidak valid dari API.']);
        }

        $reviewData['id_review'] = $lastId + 1;

        // Kirim ke API native
        $post = Http::post('http://localhost/project-streamingg/reviews.php', $reviewData);

        if ($post->successful()) {
            return back()->with('success', 'Review berhasil dikirim!');
        } else {
            return back()->withErrors(['message' => 'Gagal mengirim review.']);
        }
    }

}