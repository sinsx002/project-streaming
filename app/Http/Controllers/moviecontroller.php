<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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
            foreach (scandir($imageDir) as $file) {
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
            'yt_link' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $filename = time() . '_' . Str::slug(pathinfo($request->image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('images'), $filename);
            $data['thumbnail'] = $filename;
        } else {
            $data['thumbnail'] = null;
        }

        $response = Http::get('http://localhost/project-streamingg/movies.php');
        $lastId = collect($response->json())->max('id_movie') ?? 0;
        $data['id_movie'] = $lastId + 1;

        $post = Http::post('http://localhost/project-streamingg/movies.php', $data);
        return $post->successful()
            ? redirect('/dashboard/movies')->with('success', 'Film berhasil ditambahkan!')
            : back()->withErrors(['message' => 'Gagal menambahkan film.']);
    }

    public function edit()
    {
        $response = Http::get('http://localhost/project-streamingg/movies.php');
        $movies = $response->json();
        return view('movies.edit', compact('movies'));
    }

    public function destroy($id)
    {
        $delete = Http::withBody(json_encode(['id_movie' => (int)$id]), 'application/json')
            ->delete('http://localhost/project-streamingg/movies.php');

        return $delete->successful()
            ? redirect('/dashboard/movies/edit')->with('success', 'Film berhasil dihapus!')
            : back()->withErrors(['message' => 'Gagal menghapus film.']);
    }

    public function editFilm($id)
    {
        $response = Http::get('http://localhost/project-streamingg/movies.php');
        $movies = $response->json();
        $movie = collect($movies)->firstWhere('id_movie', (int)$id);

        $imageFiles = [];
        $imageDir = public_path('images');
        if (is_dir($imageDir)) {
            foreach (scandir($imageDir) as $file) {
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

        $validated['id_movie'] = (int)$id;

        if ($request->hasFile('images')) {
            $filename = time() . '_' . Str::slug(pathinfo($request->images->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $request->images->getClientOriginalExtension();
            $request->images->move(public_path('images'), $filename);
            $validated['thumbnail'] = $filename;
        } else {
            $validated['thumbnail'] = $request->input('existing_thumbnail');
        }

        $update = Http::withBody(json_encode($validated), 'application/json')
            ->put('http://localhost/project-streamingg/movies.php');

        return $update->successful()
            ? redirect('/dashboard/movies/edit')->with('success', 'Film berhasil diperbarui!')
            : back()->withErrors(['message' => 'Gagal memperbarui film.']);
    }

    public function stream($id)
    {
        $movieRes = Http::get('http://localhost/project-streamingg/movies.php');
        $movie = collect($movieRes->json())->firstWhere('id_movie', (int)$id);

        if (!$movie) {
            return back()->withErrors(['message' => 'Film tidak ditemukan.']);
        }

        $reviews = [];
        $reviewRes = Http::get('http://localhost/project-streamingg/reviews.php');
        if ($reviewRes->successful()) {
            $json = $reviewRes->json();
            if (is_array($json)) {
                $reviews = collect($json)
                    ->where('id_movie', (int) $movie['id_movie'])
                    ->values()
                    ->all();
            }
        }

        return view('stream', compact('movie', 'reviews'));
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

        $reviewData = $validated;
        $reviewData['id_user'] = $request->input('id_user', 0);
        $reviewData['created_at'] = now()->toDateTimeString();

        $res = Http::get('http://localhost/project-streamingg/reviews.php');
        $all = $res->successful() ? $res->json() : [];
        $reviewData['id_review'] = collect($all)->max('id_review') + 1;

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
        return $post->successful()
            ? back()->with('success', 'Review berhasil dikirim!')
            : back()->withErrors(['message' => 'Gagal mengirim review.']);
    }
}
