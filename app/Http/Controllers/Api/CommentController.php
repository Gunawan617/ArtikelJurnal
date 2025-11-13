<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment = $article->comments()->create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'approved' => false, // Moderasi admin
        ]);

        return response()->json($comment->load('user'), 201);
    }

    public function reply(Request $request, $id)
    {
        $parent = Comment::findOrFail($id);
        
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $reply = Comment::create([
            'article_id' => $parent->article_id,
            'user_id' => auth()->id(),
            'parent_id' => $parent->id,
            'content' => $validated['content'],
            'approved' => false,
        ]);

        return response()->json($reply->load('user'), 201);
    }
}
