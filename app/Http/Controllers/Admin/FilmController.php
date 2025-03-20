<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Casting;
use App\Models\Film;
use App\Models\Genre;
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

    public function create(){
        $genres = Genre::all();
        return view('film.form-tambah-film', compact('genres'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melanjutkan.');
        }

        $request->validate([
            'title' => 'required|string|max:80',
            'slug' => 'required|string|max:80|unique:films,slug',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'release_year' => 'required|integer|min:1800|max:' . date('Y'),
            'duration' => 'required|integer|min:1',
            'creator' => 'required|string|max:255',
            'trailer' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'stage_name' => 'required|array',
            'stage_name.*' => 'required|string|max:255',
            'real_name' => 'required|array',
            'real_name.*' => 'required|string|max:255',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $imageName = null;
        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('storage/assets'), $imageName);
        }

        $film = Film::create([
            'id' => Str::uuid(),
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('slug')),
            'poster' => $imageName,
            'description' => $request->input('description'),
            'release_year' => $request->input('release_year'),
            'duration' => $request->input('duration'),
            'creator' => $request->input('creator'),
            'trailer' => $request->input('trailer'),
            'age' => $request->input('age'),
            'user_id' => Auth::id(),
        ]);

        $film->genres()->sync($request->input('genres'));

        // Simpan data casting
        $castingStageNames = $request->input('stage_name');
        $castingRealNames = $request->input('real_name');
        $castingPhotos = $request->file('photo');

        for ($i = 0; $i < count($castingStageNames); $i++) {
            if (!empty($castingStageNames[$i]) && !empty($castingRealNames[$i])) {

                $photoName = null;
                if ($castingPhotos && isset($castingPhotos[$i])) {
                    $photoName = time() . '_' . $i . '.' . $castingPhotos[$i]->extension();
                    $castingPhotos[$i]->move(public_path('storage/assets'), $photoName);
                }

                Casting::create([
                    'film_id' => $film->id,
                    'stage_name' => $castingStageNames[$i],
                    'real_name' => $castingRealNames[$i],
                    'photo' => $photoName,
                    'user_id' => Auth::id(),
                ]);
            }
        }

        $redirectRoute = Auth::user()->role == 'author' ? 'author.film.index' : 'admin.film.index';
        return redirect()->route($redirectRoute)->with('success', 'Film berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $film = Film::findOrFail($id);
        $genres = Genre::all();
        $selectedGenres = $film->genres->pluck('id')->toArray();
        $castings = $film->castings; // Retrieve film castings

        return view('film.form-edit-film', compact('film', 'genres', 'selectedGenres', 'castings'));
    }


    public function update(Request $request, $id)
    {
        $film = Film::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:80',
            'slug' => 'required|string|max:80|unique:films,slug,' . $film->id,
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable|string|max:255',
            'release_year' => 'required|integer|min:1800|max:' . date('Y'),
            'duration' => 'required|integer|min:1',
            'creator' => 'required|string|max:255',
            'trailer' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'genres' => 'required|array',
            'genres.*' => 'exists:genres,id',
            'stage_name' => 'required|array',
            'stage_name.*' => 'required|string|max:255',
            'real_name' => 'required|array',
            'real_name.*' => 'required|string|max:255',
            'photo.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'slug' => Str::slug($request->input('slug')),
            'poster' => $film->poster,
            'description' => $request->input('description'),
            'release_year' => $request->input('release_year'),
            'duration' => $request->input('duration'),
            'creator' => $request->input('creator'),
            'trailer' => $request->input('trailer'),
            'age' => $request->input('age'),
        ]);

        // Update genre yang dipilih
        $film->genres()->sync($request->input('genres'));

        // Update castings
        $castingIds = $request->input('casting_id', []);
        $castingStageNames = $request->input('stage_name', []);
        $castingRealNames = $request->input('real_name', []);
        $castingPhotos = $request->file('photo', []);
        $existingPhotos = $request->input('existing_photo', []);

        // Get existing castings from the database
        $existingCastings = $film->castings;

        // Delete castings that were removed in the form
        foreach ($existingCastings as $existingCasting) {
            if (!in_array($existingCasting->id, $castingIds)) {
                // Delete the casting photo if it exists
                if ($existingCasting->photo) {
                    $photoPath = public_path('storage/assets/' . $existingCasting->photo);
                    if (file_exists($photoPath) && is_file($photoPath)) {
                        unlink($photoPath);
                    }
                }
                $existingCasting->delete();
            }
        }

        // Update or create castings
        for ($i = 0; $i < count($castingStageNames); $i++) {
            if (!empty($castingStageNames[$i]) && !empty($castingRealNames[$i])) {
                $castingId = isset($castingIds[$i]) ? $castingIds[$i] : null;
                $photoName = isset($existingPhotos[$i]) ? $existingPhotos[$i] : null;

                // Check if a new photo was uploaded
                if (isset($castingPhotos[$i])) {
                    // Delete the old photo if it exists
                    if ($photoName) {
                        $oldPhotoPath = public_path('storage/assets/' . $photoName);
                        if (file_exists($oldPhotoPath) && is_file($oldPhotoPath)) {
                            unlink($oldPhotoPath);
                        }
                    }

                    // Save the new photo
                    $photoName = time() . '_' . $i . '.' . $castingPhotos[$i]->extension();
                    $castingPhotos[$i]->move(public_path('storage/assets'), $photoName);
                }

                // Update or create the casting
                Casting::updateOrCreate(
                    ['id' => $castingId],
                    [
                        'film_id' => $film->id,
                        'stage_name' => $castingStageNames[$i],
                        'real_name' => $castingRealNames[$i],
                        'photo' => $photoName,
                        'user_id' => Auth::id(),
                    ]
                );
            }
        }

        $redirectRoute = Auth::user()->role == 'author' ? 'author.film.index' : 'admin.film.index';
        return redirect()->route($redirectRoute)->with('success', 'Film berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $film = Film::findOrFail($id);

        $film->castings()->delete();
        $film->comments()->delete();
        $film->genres()->detach();

        if ($film->poster) {
            $posterPath = public_path('storage/assets/' . $film->poster);
            if (file_exists($posterPath) && is_file($posterPath)) {
                unlink($posterPath);
            }
        }

        $film->delete();

        return redirect()
            ->route('admin.film.index')
            ->with('success', 'Film berhasil dihapus!');
    }
}
