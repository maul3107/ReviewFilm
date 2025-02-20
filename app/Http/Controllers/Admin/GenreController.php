<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Str;

class GenreController extends Controller
{
    public function index(Request $request){
        $search = $request->get('search', '');

        $genres = Genre::when($search, function ($query, $search) {
            return $query->where('title', 'like', "%{$search}%");
        })
        ->paginate(7);

        return view('admin.genre',compact('genres'));
    }

    public function detailGenre($slug)
    {
        $genre = Genre::where('slug', $slug)->firstOrFail();
        $films = $genre->films;

        return view('genre.detail-genre', compact('genre', 'films'));
    }

    public function create(){
        return view('genre.form-tambah-genre');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:80',
            'slug' => 'required|string|max:80|unique:genres',
        ]);

        $genre = Genre::create([
            'id' => Str::uuid(),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
        ]);

        session()->flash('success', 'Genre berhasil ditambahkan!');
        return redirect()->route('admin.genre.index');
    }

    public function edit($id)
    {
        $genre = Genre::findOrFail($id);
        return view('genre.form-edit-genre', compact('genre'));
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:80',
            'slug' => 'required|string|max:80|unique:genres,slug,' . $id,
        ]);

        $genre->update([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
        ]);

        session()->flash('success', 'Genre berhasil diperbarui!');
        return redirect()->route('admin.genre.index');
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);

        $genre->delete();

        return redirect()
            ->route('admin.genre.index')
            ->with('success', 'Genre berhasil dihapus!');
    }
}
