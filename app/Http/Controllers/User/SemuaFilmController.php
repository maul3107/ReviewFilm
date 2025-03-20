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
        $query = trim($request->input('q', ''));
        $age = $request->input('age');
        $year = $request->input('year');

        // Buat query builder
        $filmsQuery = Film::query();

        // Terapkan filter judul hanya jika query tidak kosong
        if (!empty($query)) {
            $filmsQuery->where('title', 'like', '%' . $query . '%');
        }

        // Terapkan filter umur jika ada
        if (!empty($age)) {
            $filmsQuery->where('age', $age);
        }

        // Terapkan filter tahun jika ada   
        if (!empty($year)) {
            $filmsQuery->where('release_year', $year);
        }

        // Jika tidak ada filter yang aktif, kembalikan array kosong
        if (empty($query) && empty($age) && empty($year)) {
            return response()->json([]);
        }

        // Ambil hasil dan kembalikan sebagai JSON
        $films = $filmsQuery->get(['id', 'title', 'slug', 'poster']);

        return response()->json($films);
    }
}
