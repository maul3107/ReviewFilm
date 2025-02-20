<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $comments = Comment::when($search, function ($query, $search) {
            return $query->where('comment', 'like', "%{$search}%");
        })->paginate(7);

        return view('admin.comment', compact('comments'));
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();

        return redirect()->route('admin.comment.index')->with('success', 'Komentar berhasil dihapus!');
    }
}
