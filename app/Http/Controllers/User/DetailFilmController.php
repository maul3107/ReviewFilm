<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class DetailFilmController extends Controller
{
    public function detailFilm($id)
    {
        $film = Film::with('comments.user')->findOrFail($id);

        // Filter hanya komentar dari user biasa (bukan admin atau author)
        $validComments = $film->comments->filter(function ($comment) {
            return !in_array($comment->user->role, ['admin', 'author']);
        });

        $filteredNumberOfComments = $validComments->count();
        $filteredAverage = $filteredNumberOfComments ? round($validComments->avg('rating'), 1) : 0;

        // Cek apakah user sudah memberikan komentar
        $userHasCommented = $film->comments->where('user_id', Auth::id())->isNotEmpty();

        return view('film.detail-film', compact('film', 'filteredAverage', 'filteredNumberOfComments', 'userHasCommented'));
    }
}
