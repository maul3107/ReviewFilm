<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $heroFilms = Film::withCount('comments') // Menghitung jumlah komentar
        ->orderByDesc('comments_count') // Urutkan berdasarkan jumlah komentar terbanyak
        ->limit(4) // Ambil hanya 5
        ->get();    

        $films = Film::latest()->get();
        return view('index', compact('heroFilms','films'));

    }
}
