<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $postId){
        $validated = $request->validate([
            'body'=>'required|string|max:500',
        ]);

        Comment::create([
            'body' => $validated['body'],
            'post_id' => $postId,
            'user_id' => Auth::user()->id,
        ]);

        return redirect('/posts/'. $postId) -> with('success', 'Comment added successfully');
    }
}
