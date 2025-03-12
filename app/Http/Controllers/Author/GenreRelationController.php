<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\GenreRelation;
use App\Models\Genre;
use App\Models\Film;

class GenreRelationController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id(); // Mendapatkan ID user yang sedang login

        $genreRelations = DB::table('genres_relations')
            ->join('films', 'genres_relations.film_id', '=', 'films.id')
            ->join('genres', 'genres_relations.genre_id', '=', 'genres.id')
            ->where('films.user_id', $userId) // Menampilkan hanya film milik user yang login
            ->select(
                'films.id as film_id',
                'films.title as film_title',
                DB::raw('GROUP_CONCAT(genres.title SEPARATOR ", ") as genres')
            )
            ->when($request->search, function ($query) use ($request) {
                $query->where('films.id', 'like', '%' . $request->search . '%')
                      ->orWhere('films.title', 'like', '%' . $request->search . '%')
                      ->orWhere('genres.title', 'like', '%' . $request->search . '%');
            })
            ->groupBy('films.id', 'films.title')
            ->paginate(7);

        return view('author.genre-relation', compact('genreRelations'));
    }

    public function create()
    {
        $userId = auth()->id();

        // Menampilkan hanya film yang dibuat oleh user
        $films = Film::where('user_id', $userId)->get();
        $genres = Genre::all();

        return view('genre-relation.form-tambah-genre-relation', compact('genres', 'films'));
    }

    public function store(Request $request)
    {
        $userId = auth()->id();

        $request->validate([
            'film_id' => 'required|string|exists:films,id',
            'genre_id' => 'required|array',
            'genre_id.*' => 'integer|exists:genres,id',
        ]);

        $film = Film::where('id', $request->film_id)->where('user_id', $userId)->first();

        if (!$film) {
            return redirect()->route('author.genre-relation.index')->with('error', 'Anda tidak memiliki akses untuk menambahkan genre ke film ini.');
        }

        foreach ($request->genre_id as $genreId) {
            GenreRelation::create([
                'film_id' => $request->film_id,
                'genre_id' => $genreId,
            ]);
        }

        return redirect()->route('author.genre-relation.index')->with('success', 'Genre berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $userId = auth()->id();

        $film = Film::where('id', $id)->where('user_id', $userId)->first();
        if (!$film) {
            return redirect()->route('author.genre-relation.index')->with('error', 'Film tidak ditemukan atau bukan milik Anda.');
        }

        $selectedGenres = GenreRelation::where('film_id', $id)->pluck('genre_id')->toArray();
        $genres = Genre::all();

        return view('genre-relation.form-edit-genre-relation', compact('film', 'selectedGenres', 'genres'));
    }

    public function update(Request $request, $id)
    {
        $userId = auth()->id();

        $request->validate([
            'film_id' => 'required|exists:films,id',
            'genre_id' => 'required|array',
            'genre_id.*' => 'integer|exists:genres,id',
        ]);

        $film = Film::where('id', $id)->where('user_id', $userId)->first();
        if (!$film) {
            return redirect()->route('author.genre-relation.index')->with('error', 'Anda tidak memiliki akses untuk mengubah genre film ini.');
        }

        GenreRelation::where('film_id', $id)->delete();

        foreach ($request->genre_id as $genreId) {
            GenreRelation::create([
                'film_id'  => $request->film_id,
                'genre_id' => $genreId,
            ]);
        }

        return redirect()->route('author.genre-relation.index')
                         ->with('success', 'Data Genre Relation berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $userId = auth()->id();

        $film = Film::where('id', $id)->where('user_id', $userId)->first();
        if (!$film) {
            return redirect()->route('author.genre-relation.index')->with('error', 'Anda tidak memiliki izin untuk menghapus film ini.');
        }

        GenreRelation::where('film_id', $id)->delete();

        return redirect()
            ->route('author.genre-relation.index')
            ->with('success', 'Genre relation berhasil dihapus!');
    }
}
