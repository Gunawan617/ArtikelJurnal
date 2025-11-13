<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
        $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        
        // Homepage
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . url('/') . '</loc>';
        $sitemap .= '<changefreq>daily</changefreq>';
        $sitemap .= '<priority>1.0</priority>';
        $sitemap .= '</url>';
        
        // Articles page
        $sitemap .= '<url>';
        $sitemap .= '<loc>' . url('/artikel') . '</loc>';
        $sitemap .= '<changefreq>daily</changefreq>';
        $sitemap .= '<priority>0.9</priority>';
        $sitemap .= '</url>';
        
        // Individual articles
        foreach ($articles as $article) {
            $sitemap .= '<url>';
            $sitemap .= '<loc>' . url('/artikel/' . $article->slug) . '</loc>';
            $sitemap .= '<lastmod>' . $article->updated_at->toAtomString() . '</lastmod>';
            $sitemap .= '<changefreq>weekly</changefreq>';
            $sitemap .= '<priority>0.8</priority>';
            $sitemap .= '</url>';
        }
        
        $sitemap .= '</urlset>';

        return response($sitemap, 200)
            ->header('Content-Type', 'application/xml');
    }
}
