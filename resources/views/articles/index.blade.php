@extends('layouts.app')

@section('title', request('category') ? 'Artikel ' . request('category') : 'Semua Artikel')

@section('content')
@php
    $colorMap = [
        'orange' => 'bg-orange-500',
        'blue' => 'bg-blue-500',
        'green' => 'bg-green-500',
        'red' => 'bg-red-500',
        'purple' => 'bg-purple-500',
        'yellow' => 'bg-yellow-500',
    ];
@endphp

<div class="bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <div class="mb-6 text-sm text-gray-600">
            <a href="/" class="hover:text-blue-600">Beranda</a>
            <span class="mx-2">›</span>
            @if(request('category'))
                <span class="text-gray-900 font-medium">{{ request('category') }}</span>
            @else
                <span class="text-gray-900 font-medium">Semua Artikel</span>
            @endif
        </div>

        <!-- Category Tabs -->
        <div class="flex gap-3 mb-8 overflow-x-auto pb-2">
            @php
                $categories = \App\Models\Article::where('is_published', true)
                    ->select('category')
                    ->distinct()
                    ->pluck('category');
            @endphp
            <a href="/artikel" class="px-4 py-2 {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' }} rounded-full whitespace-nowrap hover:bg-blue-500 hover:text-white transition shadow-sm">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="/artikel?category={{ $cat }}" class="px-4 py-2 {{ request('category') == $cat ? 'bg-blue-600 text-white' : 'bg-white text-gray-700' }} rounded-full whitespace-nowrap hover:bg-blue-500 hover:text-white transition shadow-sm">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        @if($topArticle || $recentArticles->isNotEmpty() || $articles->isNotEmpty())
            <!-- Top Artikel Section -->
            <div class="mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    <span class="inline-flex items-center gap-2">
                        🔥 Trending
                        <span class="text-sm font-normal text-gray-500">(Paling banyak dibaca 30 hari terakhir)</span>
                    </span>
                </h2>
                
                <div class="flex flex-col lg:flex-row gap-6">
                    <!-- Featured Article (Kiri - Besar) -->
                    @if($topArticle)
                        <div class="lg:w-1/2">
                            <a href="/artikel/{{ $topArticle->slug }}" class="block group">
                                <div class="bg-white rounded-lg overflow-hidden hover:shadow-xl transition">
                                    <div class="relative">
                                        @if($topArticle->image_path)
                                            <img src="{{ asset('storage/' . $topArticle->image_path) }}" alt="{{ $topArticle->title }}" class="w-full h-64 lg:h-80 object-cover">
                                        @else
                                            <div class="w-full h-64 lg:h-80 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                                <span class="text-blue-400 text-6xl">📄</span>
                                            </div>
                                        @endif
                                        
                                        @php
                                            $bgColor = $colorMap[$topArticle->category_color] ?? 'bg-blue-500';
                                        @endphp
                                        <span class="absolute top-4 left-4 px-3 py-1 {{ $bgColor }} text-white text-xs font-bold rounded-full shadow-lg">
                                            {{ strtoupper($topArticle->category) }}
                                        </span>
                                    </div>
                                    
                                    <div class="p-6">
                                        <h3 class="text-xl lg:text-2xl font-bold text-gray-900 group-hover:text-blue-600 mb-3 line-clamp-2">
                                            {{ $topArticle->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                                            {{ Str::limit(strip_tags($topArticle->content ?? $topArticle->abstract), 180) }}
                                        </p>
                                        <span class="text-sm text-blue-600 font-medium">Baca Selengkapnya</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif

                    <!-- Side Articles (Kanan - List) -->
                    <div class="lg:w-1/2">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">📰 Artikel Terbaru</h3>
                        <div class="space-y-4">
                        @foreach($recentArticles as $article)
                            <a href="/artikel/{{ $article->slug }}" class="flex gap-4 bg-white rounded-lg overflow-hidden hover:shadow-lg transition p-4 group">
                                <div class="relative flex-shrink-0">
                                    @if($article->image_path)
                                        <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-32 h-24 object-cover rounded">
                                    @else
                                        <div class="w-32 h-24 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center rounded">
                                            <span class="text-gray-400 text-2xl">📄</span>
                                        </div>
                                    @endif
                                    
                                    @php
                                        $bgColor = $colorMap[$article->category_color] ?? 'bg-blue-500';
                                    @endphp
                                    <span class="absolute top-2 left-2 px-2 py-0.5 {{ $bgColor }} text-white text-xs font-bold rounded">
                                        {{ strtoupper($article->category) }}
                                    </span>
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-base font-bold text-gray-900 group-hover:text-blue-600 mb-2 line-clamp-2">
                                        {{ $article->title }}
                                    </h3>
                                    <p class="text-xs text-gray-600 line-clamp-2 mb-2">
                                        {{ Str::limit(strip_tags($article->content ?? $article->abstract), 100) }}
                                    </p>
                                    <span class="text-xs text-blue-600 font-medium">Baca Selengkapnya</span>
                                </div>
                            </a>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Artikel Terkait Section -->
            @if($articles->isNotEmpty())
                <div class="mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">
                        Artikel Terkait {{ request('category') ? request('category') : '' }}
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($articles as $article)
                            <a href="/artikel/{{ $article->slug }}" class="block group">
                                <div class="bg-white rounded-lg overflow-hidden hover:shadow-xl transition h-full">
                                    <div class="relative">
                                        @if($article->image_path)
                                            <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <span class="text-gray-400 text-4xl">📄</span>
                                            </div>
                                        @endif
                                        
                                        @php
                                            $bgColor = $colorMap[$article->category_color] ?? 'bg-blue-500';
                                        @endphp
                                        <span class="absolute top-3 left-3 px-3 py-1 {{ $bgColor }} text-white text-xs font-bold rounded-full shadow-md">
                                            {{ strtoupper($article->category) }}
                                        </span>
                                    </div>
                                    
                                    <div class="p-5">
                                        <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 mb-2 line-clamp-2">
                                            {{ $article->title }}
                                        </h3>
                                        <p class="text-sm text-gray-600 line-clamp-3 mb-3">
                                            {{ Str::limit(strip_tags($article->content ?? $article->abstract), 120) }}
                                        </p>
                                        <span class="text-sm text-blue-600 font-medium">Baca Selengkapnya</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Pagination -->
            <div class="mt-8">
                {{ $articles->links() }}
            </div>
        @else
            <div class="text-center py-12 bg-white rounded-lg">
                <p class="text-gray-500 text-lg">Belum ada artikel untuk kategori ini.</p>
                <a href="/artikel" class="inline-block mt-4 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Lihat Semua Artikel
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
