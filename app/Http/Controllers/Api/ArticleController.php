<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::with('user')
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(12);
    }

    public function show($slug)
    {
        $article = Article::with(['user', 'references', 'comments.user', 'comments.replies.user'])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return response()->json($article);
    }

    public function comments($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        return $article->comments()
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();
    }
}
