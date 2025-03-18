<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Support\Facades\Auth;

class DetailFilmController extends Controller
{
    public function detailFilm($slug)
    {
        $film = Film::with('comments.user')->where('slug', $slug)->firstOrFail();
        $userId = Auth::id();

        // Ambil komentar user yang sedang login (jika ada)
        $userComment = $film->comments()->where('user_id', $userId)->first();

        // Ambil 3 komentar terbaru lainnya, kecuali komentar user sendiri
        $otherComments = $film->comments()
            ->where('user_id', '!=', $userId)
            ->latest()
            ->take(3)
            ->get();

        // Gabungkan komentar user (jika ada) dengan komentar lainnya
        $commentsNew = $userComment ? $otherComments->prepend($userComment) : $otherComments;

        // Ambil hanya komentar dari user biasa (bukan admin atau author)
        $validComments = $film->comments()
            ->whereHas('user', function ($query) {
                $query->whereNotIn('role', ['admin', 'author']);
            })
            ->get();

        $filteredNumberOfComments = $validComments->count();
        $filteredAverage = $filteredNumberOfComments ? round($validComments->avg('rating'), 1) : 0;

        // Cek apakah user sudah memberikan komentar
        $userHasCommented = !is_null($userComment);

        $randomFilms = Film::where('id', '!=', $film->id) // Pakai id asli dari film yang ditemukan
        ->with(['comments'])
        ->inRandomOrder()
        ->limit(10)
        ->get();

        return view('film.detail-film', compact('film', 'filteredAverage', 'filteredNumberOfComments', 'userHasCommented', 'commentsNew', 'randomFilms'));
    }
}
