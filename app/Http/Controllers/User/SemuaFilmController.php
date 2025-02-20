<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;

class SemuaFilmController extends Controller
{
    public function pencarianFilm()
    {
        $films = Film::all();
        $genres = Genre::all();
        return view('film.semua-film', compact('films', 'genres'));
    }

    public function apiSearch(Request $request)
    {
        $query = $request->input('q');

        if (!$query || strlen($query) < 1) {
            return response()->json([]);
        }

        $films = Film::where('title', 'like', '%' . $query . '%')
                     ->get(['id', 'title', 'poster']);

        return response()->json($films);
    }

}
