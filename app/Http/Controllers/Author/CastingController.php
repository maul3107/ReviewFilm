<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Casting;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CastingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');
        $userId = Auth::id(); // Dapatkan ID user yang login

        $castings = Casting::where('user_id', $userId) // Hanya tampilkan casting milik user
            ->when($search, function ($query, $search) {
                return $query->where('stage_name', 'like', "%{$search}%");
            })
            ->paginate(7);

        return view('author.casting', compact('castings'));
    }

    public function detail($id)
    {
        $userId = Auth::id();
        $casting = Casting::where('id', $id)->where('user_id', $userId)->firstOrFail(); // Pastikan hanya user terkait yang bisa melihat

        return view('casting.detail-casting', compact('casting'));
    }

    public function create()
    {
        $userId = Auth::id();
        $films = Film::where('user_id', $userId)->get(); // Hanya film milik user yang bisa dipilih

        return view('casting.form-tambah-casting', compact('films'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melanjutkan.');
        }

        $userId = Auth::id();

        $request->validate([
            'stage_name' => 'required|string|max:80',
            'real_name' => 'nullable|string|max:80',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'film_id' => 'required|exists:films,id',
        ]);

        // Pastikan user hanya bisa menambahkan casting ke film yang ia buat sendiri
        $film = Film::where('id', $request->film_id)->where('user_id', $userId)->first();
        if (!$film) {
            return redirect()->route('author.casting.index')->with('error', 'Anda tidak memiliki akses untuk menambahkan casting ke film ini.');
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('assets', 'public');
        }

        Casting::create([
            'id' => Str::uuid(),
            'stage_name' => $request->input('stage_name'),
            'real_name' => $request->input('real_name'),
            'photo' => $photoPath,
            'film_id' => $request->input('film_id'),
            'user_id' => $userId,
        ]);

        return redirect()->route('author.casting.index')->with('success', 'Casting berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $userId = Auth::id();
        $casting = Casting::where('id', $id)->where('user_id', $userId)->firstOrFail(); // Pastikan hanya user terkait yang bisa mengedit

        return view('casting.form-edit-casting', compact('casting'));
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $casting = Casting::where('id', $id)->where('user_id', $userId)->firstOrFail(); // Pastikan hanya user terkait yang bisa mengupdate

        $request->validate([
            'stage_name' => 'required|string|max:80',
            'real_name' => 'nullable|string|max:80',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'film_id' => 'required|exists:films,id',
        ]);

        // Pastikan user hanya bisa mengupdate casting yang terkait dengan film miliknya sendiri
        $film = Film::where('id', $request->film_id)->where('user_id', $userId)->first();
        if (!$film) {
            return redirect()->route('author.casting.index')->with('error', 'Anda tidak memiliki akses untuk mengubah casting ini.');
        }

        if ($request->hasFile('photo')) {
            if ($casting->photo) {
                Storage::disk('public')->delete($casting->photo);
            }

            $photoPath = $request->file('photo')->store('assets', 'public');
        } else {
            $photoPath = $casting->photo;
        }

        $casting->update([
            'stage_name' => $request->input('stage_name'),
            'real_name' => $request->input('real_name'),
            'photo' => $photoPath,
            'film_id' => $request->input('film_id'),
        ]);

        return redirect()->route('author.casting.index')->with('success', 'Casting berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $userId = Auth::id();
        $casting = Casting::where('id', $id)->where('user_id', $userId)->firstOrFail(); // Pastikan hanya user terkait yang bisa menghapus

        if ($casting->photo) {
            Storage::disk('public')->delete($casting->photo);
        }

        $casting->delete();

        return redirect()->route('author.casting.index')->with('success', 'Casting berhasil dihapus!');
    }
}
