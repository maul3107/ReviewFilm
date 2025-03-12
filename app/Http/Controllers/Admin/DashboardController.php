<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Genre;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalFilms = Film::count();
        $totalGenres = Genre::count();
        $totalPengguna = User::count(); // Pastikan model User sudah ada

        return view('admin.dashboard', compact('totalFilms', 'totalGenres', 'totalPengguna'));
    }
}
    



