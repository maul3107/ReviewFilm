<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
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

        // Cek apakah user sudah memiliki komentar pada film ini
        $existingComment = Comment::where('film_id', $request->film_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingComment) {
            return redirect()->route('detail-film', ['id' => $request->film_id])
                ->with('error', 'Anda sudah memberikan komentar pada film ini. Silakan edit komentar Anda.');
        }

        // Simpan komentar baru
        Comment::create([
            'comment' => $request->comment,
            'film_id' => $request->film_id,
            'user_id' => Auth::id(),
            'rating' => $request->rating,
        ]);

        return redirect()->route('detail-film', ['id' => $request->film_id])
            ->with('success', 'Komentar dan rating berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        // Pastikan user hanya bisa mengedit komentarnya sendiri
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

        return redirect()->route('detail-film', ['id' => $comment->film_id])
            ->with('success', 'Komentar dan rating berhasil diperbarui!');
    }

    public function destroy(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        // Pastikan user hanya bisa menghapus komentarnya sendiri
        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Aksi tidak diizinkan.');
        }

        $filmId = $comment->film_id;
        $comment->delete();

        return redirect()->route('detail-film', ['id' => $filmId])
            ->with('success', 'Komentar berhasil dihapus!');
    }
}
