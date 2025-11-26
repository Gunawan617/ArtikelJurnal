<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Article;
use App\Http\Controllers\SitemapController;

Route::get('/', function (Request $request) {
    // Smart Algorithm untuk Homepage

    // 1. Featured Article (Manual atau berdasarkan score tertinggi)
    $featuredArticle = Article::where('is_published', true)
        ->where('is_featured', true)
        ->latest('published_at')
        ->first();

    // Jika tidak ada featured manual, pilih artikel dengan score tertinggi
    if (!$featuredArticle) {
        $featuredArticle = Article::where('is_published', true)
            ->orderByRaw('(views_count * 0.1) + (DATEDIFF(NOW(), published_at) * -0.1) DESC')
            ->first();
    }

    // 2. Artikel lainnya (Smart Ranking)
    $articles = Article::where('is_published', true)
        ->where('id', '!=', $featuredArticle?->id)
        ->select('articles.*')
        // Score = (views * 0.1) + (freshness)
        ->selectRaw('(
            views_count * 0.1 +
            (CASE 
                WHEN DATEDIFF(NOW(), updated_at) < 7 THEN 10
                WHEN DATEDIFF(NOW(), updated_at) < 30 THEN 5
                ELSE 0
            END)
        ) as popularity_score')
        ->orderBy('popularity_score', 'desc')
        ->orderBy('published_at', 'desc')
        ->take(4)
        ->get();

    return view('home', compact('featuredArticle', 'articles'));
});

Route::get('/artikel', function (Request $request) {
    $baseQuery = Article::where('is_published', true);

    // Filter by category if provided
    if ($request->has('category') && $request->category) {
        $baseQuery->where('category', $request->category);
    }

    // Search functionality
    $searchQuery = $request->input('search');
    if ($searchQuery && strlen($searchQuery) >= 3) {
        $baseQuery->where(function ($query) use ($searchQuery) {
            $query->where('title', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('abstract', 'LIKE', '%' . $searchQuery . '%')
                ->orWhere('content', 'LIKE', '%' . $searchQuery . '%');
        });
    }

    // 1. Top Article (Trending/Hot) - Artikel dengan views tertinggi dalam 30 hari terakhir
    $topArticle = (clone $baseQuery)
        ->where('updated_at', '>=', now()->subDays(30))
        ->selectRaw('articles.*, (
            views_count * 0.2 +
            (CASE 
                WHEN DATEDIFF(NOW(), updated_at) < 7 THEN 15
                WHEN DATEDIFF(NOW(), updated_at) < 14 THEN 10
                WHEN DATEDIFF(NOW(), updated_at) < 30 THEN 5
                ELSE 0
            END)
        ) as engagement_score')
        ->orderBy('engagement_score', 'desc')
        ->first();

    // 2. Recent Articles (3 artikel terbaru) - untuk sidebar
    $recentArticles = (clone $baseQuery)
        ->when($topArticle, function ($query) use ($topArticle) {
            return $query->where('id', '!=', $topArticle->id);
        })
        ->latest('published_at')
        ->take(3)
        ->get();

    // 3. All Articles untuk pagination (exclude top & recent)
    $excludeIds = collect([$topArticle?->id])
        ->merge($recentArticles->pluck('id'))
        ->filter()
        ->toArray();

    $articles = (clone $baseQuery)
        ->whereNotIn('id', $excludeIds)
        ->latest('published_at')
        ->paginate(9) // 9 artikel untuk grid (3x3)
        ->appends($request->only(['search', 'category'])); // Preserve search & category in pagination

    // Count total results for search
    $totalResults = null;
    if ($searchQuery && strlen($searchQuery) >= 3) {
        $totalResults = (clone $baseQuery)->count();
    }

    return view('articles.index', compact('topArticle', 'recentArticles', 'articles', 'searchQuery', 'totalResults'));
});

Route::get('/artikel/{slug}', function ($slug) {
    $article = Article::with(['references'])
        ->where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    return view('articles.show', compact('article'));
})->middleware(\App\Http\Middleware\TrackArticleView::class);

// Route::post('/artikel/{slug}/comment', function (Request $request, $slug) {
//     $article = Article::where('slug', $slug)->firstOrFail();

//     $article->allComments()->create([
//         'user_id' => auth()->id(),
//         'content' => $request->content,
//         'approved' => false,
//     ]);

//     return back()->with('success', 'Komentar berhasil dikirim dan menunggu persetujuan admin');
// })->middleware('auth');

Route::get('/tentang', function () {
    return view('about');
});

// Auth routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ]);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'pembaca',
    ]);

    Auth::login($user);
    return redirect('/');
});

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

// Discussion routes
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\UserReportController;

Route::get('/diskusi', [DiscussionController::class, 'index'])->name('discussions.index');
Route::get('/diskusi/buat', [DiscussionController::class, 'create'])->name('discussions.create')->middleware('auth');
Route::post('/diskusi', [DiscussionController::class, 'store'])->name('discussions.store')->middleware('auth');
Route::get('/diskusi/{id}', [DiscussionController::class, 'show'])->name('discussions.show');
Route::post('/diskusi/{id}/balas', [DiscussionController::class, 'reply'])->name('discussions.reply')->middleware('auth');
Route::post('/diskusi/{id}/toggle-close', [DiscussionController::class, 'toggleClose'])->name('discussions.toggle-close')->middleware('auth');
Route::delete('/diskusi/{id}', [DiscussionController::class, 'destroy'])->name('discussions.destroy')->middleware('auth');
Route::delete('/diskusi/balasan/{id}', [DiscussionController::class, 'destroyReply'])->name('discussions.reply.destroy')->middleware('auth');

// Report routes
Route::post('/report', [UserReportController::class, 'store'])->name('report.store')->middleware('auth');

// Diskusi terkait artikel
Route::get('/artikel/{slug}/diskusi', [DiscussionController::class, 'articleDiscussions'])->name('articles.discussions');
