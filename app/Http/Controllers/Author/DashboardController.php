<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Film;
use App\Models\GenreRelation;
use App\Models\Casting;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id(); // Ambil ID pengguna yang sedang login

        // Menghitung jumlah total film yang diposting oleh user
        $totalFilms = Film::where('user_id', $userId)->count();

        // Menghitung jumlah total film yang memiliki genre relations
        $totalGenres = Film::where('user_id', $userId)
            ->whereHas('genreRelations') // Cek apakah film punya genre relations
            ->count();

        // Menghitung jumlah total casting hanya untuk film yang dibuat oleh user sendiri
        $totalCastings = Casting::whereIn('film_id', function ($query) use ($userId) {
            $query->select('id')->from('films')->where('user_id', $userId);
        })->count();

        return view('author.dashboard', compact('totalFilms', 'totalGenres', 'totalCastings'));
    }
}



