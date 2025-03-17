<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $films = Film::latest()->paginate(10);

        return view('index', compact('films'));
    }
}
