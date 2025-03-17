<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\Film;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 film dengan komentar terbanyak
        $heroFilms = Film::withCount('comments')
            ->orderByDesc('comments_count')
            ->limit(4)
            ->get();

        // Ambil semua film terbaru
        $films = Film::latest()->select('id', 'title', 'poster', 'release_year')->get();

        // Ambil 6 film yang memiliki trailer
        $trailers = Film::whereNotNull('trailer')
            ->where('trailer', '!=', '') // Hindari trailer kosong
            ->limit(6)
            ->select('id', 'title', 'trailer')
            ->get();

        // Menggunakan query langsung agar lebih efisien
        $genreCount = Genre::query()->count();
        $filmCount = Film::query()->count();
        $userCount = User::query()->count();

        return view('index', compact('heroFilms', 'films', 'trailers', 'genreCount', 'filmCount', 'userCount'));
    }
}
