<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class FilmController extends Controller
{
    public function index(Request $request){
        $search = $request->get('search', '');

        $films = Film::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        })
        ->paginate(7);

        return view('admin.film',compact('films'));
    }


    public function detailFilm($id){
        $film = Film::findOrFail($id);
        $relatedFilms = Film::where('id', '!=', $id)->limit(3)->get();
        return view('film.detail-film',compact('film'));
    }

    public function create(){
        return view('film.form-tambah-film');
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melanjutkan.');
        }

        $request->validate([
            'title' => 'required|string|max:80',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'release_year' => 'required|integer|min:1800|max:' . date('Y'),
            'duration' => 'required|integer|min:1',
            'creator' => 'required|string|max:255',
            'trailer' => 'nullable|string|max:255',
        ]);

        $imageName = null;
        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('storage/assets'), $imageName);
        }

        Film::create([
            'id' => Str::uuid(), // Gunakan UUID jika bukan auto-increment
            'title' => $request->input('title'),
            'poster' => $imageName,
            'description' => $request->input('description'),
            'release_year' => $request->input('release_year'),
            'duration' => $request->input('duration'),
            'creator' => $request->input('creator'),
            'trailer' => $request->input('trailer'),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.film.index')->with('success', 'Film berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $film = Film::findOrFail($id);
        return view('film.form-edit-film', compact('film'));
    }

    public function update(Request $request, $id)
    {
        $film = Film::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:80',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'release_year' => 'required|integer|min:1800|max:' . date('Y'),
            'duration' => 'required|integer|min:1',
            'creator' => 'required|string|max:255',
            'trailer' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('poster')) {
            if ($film->poster) {
                $oldPosterPath = public_path('storage/assets/' . $film->poster);

                if (file_exists($oldPosterPath) && is_file($oldPosterPath)) {
                    unlink($oldPosterPath);
                }
            }
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('storage/assets'), $imageName);
            $film->poster = $imageName;
        }

        $film->update([
            'title' => $request->input('title'),
            'poster' => $film->poster,
            'description' => $request->input('description'),
            'release_year' => $request->input('release_year'),
            'duration' => $request->input('duration'),
            'creator' => $request->input('creator'),
            'trailer' => $request->input('trailer'),
        ]);

        session()->flash('success', 'Film berhasil diperbarui!');
        return redirect()->route('admin.film.index');
    }

    public function destroy($id)
    {
        $film = Film::findOrFail($id);

        $film->delete();

        return redirect()
            ->route('admin.film.index')
            ->with('success', 'Film berhasil dihapus!');
    }
}
