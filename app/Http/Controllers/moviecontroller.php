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
            'release_date' => 'required|date',
            'id_genre' => 'required|integer',
            'description' => 'required|string',
            'thumbnail' => 'nullable|string',
            'duration' => 'nullable|integer',
        ]);

        $data['thumbnail'] = $request->input('thumbnail');

        // Ambil semua data film dulu untuk mencari ID terakhir
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
        $data = $request->validate([
            'title' => 'required|string',
            'release_date' => 'required|date',
            'id_genre' => 'required|integer',
            'description' => 'required|string',
            'thumbnail' => 'nullable|string',
            'duration' => 'nullable|integer',
        ]);

        $data['id_movie'] = (int) $id;

        // Kirim data update ke API (PUT atau POST tergantung backend kamu)
        $response = Http::withBody(json_encode($data), 'application/json')
            ->put('http://localhost/project-streamingg/movies.php');

        if ($response->successful()) {
            return redirect('/dashboard/movies/edit')->with('success', 'Film berhasil diperbarui!');
        } else {
            return back()->withErrors(['message' => 'Gagal memperbarui film.']);
        }
    }

}