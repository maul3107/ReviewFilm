<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $userId = Auth::id();

        $films = Film::where('user_id', $userId)
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(7);

        return view('author.film', compact('films'));
    }

    public function create(){
        $genres = Genre::all();
        return view('film.form-tambah-film', compact('genres'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melanjutkan.');
        }

        $request->validate([
            'title' => 'required|string|max:80',
            'slug' => 'required|string|max:80|unique:films,slug',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'release_year' => 'required|integer|min:1800|max:' . date('Y'),
            'duration' => 'required|integer|min:1',
            'creator' => 'required|string|max:255',
            'trailer' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
        ]);

        $imageName = null;
        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('storage/assets'), $imageName);
        }

        $film = Film::create([
            'id' => Str::uuid(),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('slug')),
            'poster' => $imageName,
            'description' => $request->input('description'),
            'release_year' => $request->input('release_year'),
            'duration' => $request->input('duration'),
            'creator' => $request->input('creator'),
            'trailer' => $request->input('trailer'),
            'age' => $request->input('age'),
            'user_id' => Auth::id(),
        ]);

        $film->genres()->sync($request->input('genres'));

        return redirect()->route('author.film.index')->with('success', 'Film berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $film = Film::findOrFail($id);
        $genres = Genre::all(); // Ambil semua genre
        $selectedGenres = $film->genres->pluck('id')->toArray(); // Ambil ID genre yang sudah dipilih

        return view('film.form-edit-film', compact('film', 'genres', 'selectedGenres'));
    }


    public function update(Request $request, $id)
    {
        $film = Film::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:80',
            'slug' => 'required|string|max:80|unique:films,slug,' . $film->id,
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'release_year' => 'required|integer|min:1800|max:' . date('Y'),
            'duration' => 'required|integer|min:1',
            'creator' => 'required|string|max:255',
            'trailer' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'genres' => 'required|array', // Pastikan genre wajib dipilih
            'genres.*' => 'exists:genres,id' // Validasi setiap genre harus ada di tabel genres
        ]);

        if ($request->hasFile('poster')) {
            if ($film->poster) {
                $oldPosterPath = public_path('storage/assets/' . $film->poster);
                if (file_exists($oldPosterPath) && is_file($oldPosterPath)) {
                    unlink($oldPosterPath);
                }
            }
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('storage/assets'), $imageName);
            $film->poster = $imageName;
        }

        $film->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('slug')),
            'poster' => $film->poster,
            'description' => $request->input('description'),
            'release_year' => $request->input('release_year'),
            'duration' => $request->input('duration'),
            'creator' => $request->input('creator'),
            'trailer' => $request->input('trailer'),
            'age' => $request->input('age'),
        ]);

        // Update genre yang dipilih
        $film->genres()->sync($request->input('genres'));

        session()->flash('success', 'Film berhasil diperbarui!');
        return redirect()->route('author.film.index');
    }

    public function destroy($id)
    {
        $film = Film::findOrFail($id);

        $film->castings()->delete();
        $film->comments()->delete();
        $film->genres()->detach();

        if ($film->poster) {
            $posterPath = public_path('storage/assets/' . $film->poster);
            if (file_exists($posterPath) && is_file($posterPath)) {
                unlink($posterPath);
            }
        }

        $film->delete();

        return redirect()
            ->route('author.film.index')
            ->with('success', 'Film berhasil dihapus!');
    }
}
