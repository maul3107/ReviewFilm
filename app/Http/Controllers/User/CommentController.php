<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Film; // Tambahkan model Film
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melanjutkan.');
        }

        $request->validate([
            'comment' => 'required|string|max:255',
            'film_id' => 'required|exists:films,id',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        // Ambil slug berdasarkan film_id
        $film = Film::findOrFail($request->film_id);

        // Cek apakah user sudah memiliki komentar pada film ini
        $existingComment = Comment::where('film_id', $request->film_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingComment) {
            return redirect()->route('detail-film', ['slug' => $film->slug])
                ->with('error', 'Anda sudah memberikan komentar pada film ini. Silakan edit komentar Anda.');
        }

        // Simpan komentar baru
        Comment::create([
            'comment' => $request->comment,
            'film_id' => $request->film_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
        ]);

        return redirect()->route('detail-film', ['slug' => $film->slug])
            ->with('success', 'Komentar dan rating berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

        $request->validate([
            'comment' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $comment->update([
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        // Ambil slug berdasarkan film_id
        $film = Film::findOrFail($comment->film_id);

        return redirect()->route('detail-film', ['slug' => $film->slug])
            ->with('success', 'Komentar dan rating berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

        // Ambil slug sebelum menghapus
        $film = Film::findOrFail($comment->film_id);
        $comment->delete();

        return redirect()->route('detail-film', ['slug' => $film->slug])
            ->with('success', 'Komentar berhasil dihapus!');
    }
}
