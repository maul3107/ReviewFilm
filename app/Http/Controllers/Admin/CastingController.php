<?php

namespace App\Http\Controllers\Admin;

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

        $castings = Casting::when($search, function ($query, $search) {
            return $query->where('stage_name', 'like', "%{$search}%");
        })->paginate(7);

        return view('admin.casting', compact('castings'));
    }

    public function detail($id)
    {
        $casting = Casting::findOrFail($id);
        return view('casting.detail-casting', compact('casting'));
    }

    public function create()
    {
        $films = Film::all();
        return view('casting.form-tambah-casting',compact('films'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melanjutkan.');
        }

        $request->validate([
            'stage_name' => 'required|string|max:80',
            'real_name' => 'nullable|string|max:80',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'film_id' => 'required|exists:films,id',
        ]);

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
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.casting.index')->with('success', 'Casting berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $casting = Casting::findOrFail($id);
        return view('casting.form-edit-casting', compact('casting'));
    }

    public function update(Request $request, $id)
    {
        $casting = Casting::findOrFail($id);

        $request->validate([
            'stage_name' => 'required|string|max:80',
            'real_name' => 'nullable|string|max:80',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'film_id' => 'required|exists:films,id',
        ]);

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

        session()->flash('success', 'Casting berhasil diperbarui!');
        return redirect()->route('admin.casting.index');
    }

    public function destroy($id)
    {
        $casting = Casting::findOrFail($id);

        if ($casting->photo) {
            Storage::disk('public')->delete($casting->photo);
        }

        $casting->delete();

        return redirect()->route('admin.casting.index')->with('success', 'Casting berhasil dihapus!');
    }
}
