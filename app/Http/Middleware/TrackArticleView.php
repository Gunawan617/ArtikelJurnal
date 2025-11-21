<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackArticleView
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Get the article from the route parameter
        $slug = $request->route('slug');

        if ($slug) {
            $article = \App\Models\Article::where('slug', $slug)
                ->where('is_published', true)
                ->first();

            if ($article) {
                // Create a unique cache key based on IP and article ID
                $cacheKey = 'article_view_' . $article->id . '_' . $request->ip();

                // Check if this IP has already viewed this article in the last 24 hours
                if (!\Cache::has($cacheKey)) {
                    // Increment view count
                    $article->incrementViews();

                    // Store in cache for 24 hours (1440 minutes)
                    \Cache::put($cacheKey, true, now()->addDay());
                }
            }
        }

        return $response;
    }
}
