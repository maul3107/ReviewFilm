<?php

namespace App\Http\Controllers\Admin;

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
        $genreRelations = DB::table('genres_relations')
            ->join('films', 'genres_relations.film_id', '=', 'films.id')
            ->join('genres', 'genres_relations.genre_id', '=', 'genres.id')
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

        return view('admin.genre-relation', compact('genreRelations'));
    }

    public function detailGenreRelation($id)
    {
        $genreRelation = GenreRelation::findOrFail($id);
        $genre = $genreRelation->genre;
        $film = $genreRelation->film;

        $relatedGenres = Genre::where('id', '!=', $genre->id)->limit(3)->get();

        return view('genre.detail-genre', compact('genre', 'film', 'relatedGenres'));
    }

    public function pencarianGenreRelation()
    {
        return view('genre.pencarian-genre');
    }

    public function create()
    {
        $genres = Genre::all();
        $films = Film::whereDoesntHave('genres')->get();
        return view('genre-relation.form-tambah-genre-relation', compact('genres', 'films'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'film_id' => 'required|string|exists:films,id',
            'genre_id' => 'required|array',
            'genre_id.*' => 'integer|exists:genres,id',
        ]);

        foreach ($request->genre_id as $genres_id) {
            $filmGenre = new GenreRelation();
            $filmGenre->film_id = $request->film_id;
            $filmGenre->genre_id = $genres_id;
            $filmGenre->save();
        }

        return redirect()->route('admin.genre-relation.index')->with('success', 'Genre berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $film = Film::find($id);
        if (!$film) {
            return redirect()->route('admin.genre-relation.index')->with('error', 'Film tidak ditemukan.');
        }

        $selectedGenres = GenreRelation::where('film_id', $id)
            ->pluck('genre_id')
            ->toArray();

        $genres = Genre::all();

        return view('genre-relation.form-edit-genre-relation', compact('film', 'selectedGenres', 'genres'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'film_id'   => 'required|exists:films,id',
            'genre_id'  => 'required|array',
            'genre_id.*'=> 'integer|exists:genres,id',
        ]);

        GenreRelation::where('film_id', $id)->delete();

        foreach ($request->genre_id as $genreId) {
            GenreRelation::create([
                'film_id'  => $request->film_id,
                'genre_id' => $genreId,
            ]);
        }

        return redirect()->route('admin.genre-relation.index')
                         ->with('success', 'Data Genre Relation berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $film = Film::find($id);
        if (!$film) {
            return redirect()->route('admin.genre-relation.index')->with('error', 'Film tidak ditemukan.');
        }

        $selectedGenres = GenreRelation::where('film_id', $id);
        $selectedGenres->delete();

        return redirect()
            ->route('admin.genre-relation.index')
            ->with('success', 'Genre relation berhasil dihapus!');
    }

}

