@extends('layouts.app')

@section('title', $article->title)

@push('head')
<!-- Robots Meta for Google Scholar -->
<meta name="robots" content="index, follow">
<meta name="googlebot" content="index, follow">

<!-- Google Scholar Meta Tags -->
<meta name="citation_title" content="{{ $article->title }}">
<meta name="citation_author" content="{{ $article->author }}">
<meta name="citation_publication_date" content="{{ $article->published_at ? $article->published_at->format('Y/m/d') : $article->created_at->format('Y/m/d') }}">
<meta name="citation_journal_title" content="ScholarHub - Portal Artikel Ilmiah">
@if($article->author_institution)
<meta name="citation_author_institution" content="{{ $article->author_institution }}">
@endif
@if($article->abstract)
<meta name="citation_abstract" content="{{ strip_tags($article->abstract) }}">
@endif
@if($article->keywords)
<meta name="citation_keywords" content="{{ $article->keywords }}">
@endif
@if($article->pdf_path)
<meta name="citation_pdf_url" content="{{ asset('storage/' . $article->pdf_path) }}">
@endif
<meta name="citation_fulltext_html_url" content="{{ url('/artikel/' . $article->slug) }}">
<meta name="citation_language" content="id">

<!-- Dublin Core Meta Tags -->
<meta name="DC.title" content="{{ $article->title }}">
<meta name="DC.creator" content="{{ $article->author }}">
<meta name="DC.date" content="{{ $article->published_at ? $article->published_at->format('Y-m-d') : $article->created_at->format('Y-m-d') }}">
<meta name="DC.identifier" content="{{ url('/artikel/' . $article->slug) }}">
@if($article->abstract)
<meta name="DC.description" content="{{ strip_tags($article->abstract) }}">
@endif
<meta name="DC.language" content="id">
<meta name="DC.type" content="Text">
<meta name="DC.format" content="text/html">

<!-- Open Graph Meta Tags -->
<meta property="og:title" content="{{ $article->title }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url('/artikel/' . $article->slug) }}">
@if($article->image_path)
<meta property="og:image" content="{{ asset('storage/' . $article->image_path) }}">
@endif
@if($article->abstract)
<meta property="og:description" content="{{ strip_tags($article->abstract) }}">
@endif
<meta property="article:published_time" content="{{ $article->published_at ? $article->published_at->format('c') : $article->created_at->format('c') }}">
<meta property="article:author" content="{{ $article->author }}">

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $article->title }}">
@if($article->abstract)
<meta name="twitter:description" content="{{ strip_tags($article->abstract) }}">
@endif
@if($article->image_path)
<meta name="twitter:image" content="{{ asset('storage/' . $article->image_path) }}">
@endif

<!-- Schema.org JSON-LD -->
@php
$schemaData = [
    '@context' => 'https://schema.org',
    '@type' => 'ScholarlyArticle',
    'headline' => $article->title,
    'author' => [
        '@type' => 'Person',
        'name' => $article->author,
    ],
    'datePublished' => $article->published_at ? $article->published_at->format('c') : $article->created_at->format('c'),
    'url' => url('/artikel/' . $article->slug),
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'ScholarHub',
        'url' => url('/')
    ],
    'inLanguage' => 'id'
];

if ($article->author_institution) {
    $schemaData['author']['affiliation'] = [
        '@type' => 'Organization',
        'name' => $article->author_institution
    ];
}

if ($article->abstract) {
    $schemaData['abstract'] = strip_tags($article->abstract);
}

if ($article->keywords) {
    $schemaData['keywords'] = $article->keywords;
}

if ($article->image_path) {
    $schemaData['image'] = asset('storage/' . $article->image_path);
}
@endphp
<script type="application/ld+json">
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
@endpush

@section('content')
<div class="bg-white min-h-screen">
    <!-- Container Utama -->
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col lg:flex-row gap-0 items-start">
            <!-- Main Content (2 kolom) -->
            <div class="w-full lg:flex-1 lg:max-w-[667px]">
                <article class="bg-white">
                    <div class="p-4 md:p-6 lg:p-8 pt-6 md:pt-8 lg:pt-12">
                        <!-- Category Badge -->
                        @php
                            $colorMap = [
                                'orange' => 'bg-orange-500',
                                'blue' => 'bg-blue-500',
                                'green' => 'bg-green-500',
                                'red' => 'bg-red-500',
                                'purple' => 'bg-purple-500',
                                'yellow' => 'bg-yellow-500',
                            ];
                            $bgColor = $colorMap[$article->category_color] ?? 'bg-green-500';
                        @endphp
                        <div class="mb-3">
                            <span class="inline-block px-3 py-1 {{ $bgColor }} text-white text-xs font-bold rounded-full">
                                {{ strtoupper($article->category) }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-4 leading-tight">
                            {{ $article->title }}
                        </h1>

                        <!-- Meta Info -->
                        <div class="flex flex-wrap items-center gap-4 pb-4 mb-6 border-b border-gray-200 text-sm text-gray-600">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-medium">{{ $article->author }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ $article->published_at ? $article->published_at->format('d M Y') : $article->created_at->format('d M Y') }}</span>
                            </div>
                        </div>

                        <!-- Featured Image -->
                        @if($article->image_path)
                            <div class="mb-6">
                                <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full rounded-lg">
                            </div>
                        @endif

                        <!-- Article Content -->
                        <div class="prose prose-lg max-w-none mb-8 text-gray-800 leading-relaxed article-content">
                            @if($article->author_photo)
                                <img src="{{ asset('storage/' . $article->author_photo) }}" alt="{{ $article->author }}" class="author-photo-wrap">
                            @endif
                            {!! $article->content !!}
                        </div>

                        <!-- Keywords -->
                        @if($article->keywords)
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-700 mb-2">Kata Kunci:</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $article->keywords) as $keyword)
                                        <span class="px-3 py-1 bg-blue-50 text-blue-700 text-sm rounded-full">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Author Info -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <div class="text-sm text-gray-600 mb-1">Ditinjau oleh:</div>
                            <h3 class="font-bold text-base text-gray-900">
                                {{ $article->author }}
                            </h3>
                        </div>

                        <!-- References (Collapsible) -->
                        @if($article->references->count() > 0)
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <button onclick="toggleReferences()" class="flex items-center gap-2 text-gray-700 hover:text-blue-600 transition group">
                                    <span class="font-semibold text-base">Referensi</span>
                                    <svg id="referenceIcon" class="w-5 h-5 transform transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                
                                <div id="referenceContent" class="hidden mt-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <ol class="list-decimal list-inside space-y-2 text-sm text-gray-700">
                                        @foreach($article->references as $ref)
                                            <li class="leading-relaxed">
                                                {{ $ref->author }} ({{ $ref->year }}). {{ $ref->title }}.
                                                @if($ref->journal) <em>{{ $ref->journal }}</em>.@endif
                                                @if($ref->doi)
                                                    <a href="https://doi.org/{{ $ref->doi }}" class="text-blue-600 hover:underline" target="_blank">DOI: {{ $ref->doi }}</a>
                                                @elseif($ref->url)
                                                    <a href="{{ $ref->url }}" class="text-blue-600 hover:underline" target="_blank">Link</a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            </div>
                        @endif

                        <!-- PDF Download -->
                        @if($article->pdf_path)
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white p-5 rounded-lg mb-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="font-bold text-lg mb-1">Download Artikel Lengkap</h3>
                                        <p class="text-blue-100 text-sm">Baca artikel dalam format PDF</p>
                                    </div>
                                    <a href="{{ asset('storage/' . $article->pdf_path) }}" target="_blank" class="px-5 py-2.5 bg-white text-blue-600 rounded-lg font-bold hover:bg-blue-50 transition whitespace-nowrap">
                                        Download PDF
                                    </a>
                                </div>
                            </div>
                        @endif

                        <!-- Diskusi Terkait -->
                        <div class="mb-6">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-bold text-gray-900">Diskusi Terkait</h2>
                                <a href="{{ route('articles.discussions', $article->slug) }}" class="text-blue-600 hover:underline text-sm font-semibold">
                                    Lihat Semua →
                                </a>
                            </div>

                            @php
                                // Ambil 3 diskusi terkait
                                $keywords = explode(',', $article->keywords);
                                $relatedDiscussions = \App\Models\Discussion::with(['user'])
                                    ->where(function($query) use ($keywords, $article) {
                                        foreach ($keywords as $keyword) {
                                            $keyword = trim($keyword);
                                            if (!empty($keyword)) {
                                                $query->orWhere('title', 'like', "%{$keyword}%")
                                                      ->orWhere('content', 'like', "%{$keyword}%")
                                                      ->orWhere('related_keywords', 'like', "%{$keyword}%");
                                            }
                                        }
                                        $query->orWhere('title', 'like', "%{$article->title}%");
                                    })
                                    ->latest('last_reply_at')
                                    ->take(3)
                                    ->get();
                            @endphp

                            @if($relatedDiscussions->count() > 0)
                                <div class="space-y-4">
                                    @foreach($relatedDiscussions as $discussion)
                                        <a href="{{ route('discussions.show', $discussion->id) }}" class="block border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition">
                                            <div class="flex items-start gap-3">
                                                <!-- Avatar -->
                                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                                                    <span class="text-white font-bold text-sm">{{ substr($discussion->user->name, 0, 1) }}</span>
                                                </div>

                                                <!-- Content -->
                                                <div class="flex-1 min-w-0">
                                                    <h3 class="font-bold text-gray-900 mb-1 line-clamp-2">{{ $discussion->title }}</h3>
                                                    <p class="text-xs text-gray-600 mb-1">Oleh: {{ $discussion->user->name }}</p>
                                                    <p class="text-sm text-gray-700 line-clamp-2">{{ Str::limit($discussion->content, 100) }}</p>
                                                </div>

                                                <!-- Stats -->
                                                <div class="text-right flex-shrink-0">
                                                    <div class="text-blue-600 font-semibold text-sm">{{ $discussion->replies_count }} Balasan</div>
                                                    <div class="text-xs text-gray-500 mt-1">{{ $discussion->created_at->diffForHumans() }}</div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>

                                <!-- Button Lihat Semua -->
                                <div class="text-center mt-4">
                                    <a href="{{ route('articles.discussions', $article->slug) }}" class="inline-block px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                                        Selanjutnya >>
                                    </a>
                                </div>
                            @else
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 text-center">
                                    <div class="flex items-center justify-center gap-3 mb-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <h3 class="font-bold text-base mb-1">Punya Pertanyaan?</h3>
                                    <p class="text-gray-600 text-sm mb-4">Belum ada diskusi terkait artikel ini</p>
                                    <a href="{{ route('discussions.create') }}" class="inline-block px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                                        Buat Pertanyaan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </article>


            </div>

            <!-- Sidebar (1 kolom) -->
            <div class="w-full lg:w-[300px] lg:ml-8 pt-6 lg:pt-12 px-4 lg:px-0">
                <div class="space-y-6">
                    <!-- Artikel Terkait -->
                    <div class="bg-white">
                        <div class="mb-6">
                            <h3 class="font-bold text-2xl text-gray-900 mb-5">Artikel Terkait</h3>
                            <div class="space-y-5">
                                @php
                                    $relatedArticles = \App\Models\Article::where('is_published', true)
                                        ->where('id', '!=', $article->id)
                                        ->latest('published_at')
                                        ->take(5)
                                        ->get();
                                    
                                    $colorMap = [
                                        'orange' => 'bg-orange-500',
                                        'blue' => 'bg-blue-500',
                                        'green' => 'bg-green-500',
                                        'red' => 'bg-red-500',
                                        'purple' => 'bg-purple-500',
                                        'yellow' => 'bg-yellow-500',
                                    ];
                                @endphp
                                
                                @forelse($relatedArticles as $related)
                                    <a href="/artikel/{{ $related->slug }}" class="block group mb-5">
                                        <div class="relative mb-3">
                                            @if($related->image_path)
                                                <img src="{{ asset('storage/' . $related->image_path) }}" alt="{{ $related->title }}" class="w-full h-[166px] object-cover rounded">
                                            @else
                                                <div class="w-full h-[166px] bg-gradient-to-br from-gray-100 to-gray-200 rounded flex items-center justify-center">
                                                    <span class="text-gray-400 text-4xl">📄</span>
                                                </div>
                                            @endif
                                            
                                            <!-- Category Badge on Image -->
                                            @php
                                                $bgColor = $colorMap[$related->category_color] ?? 'bg-green-500';
                                            @endphp
                                            <span class="absolute top-2 left-2 inline-block px-2.5 py-0.5 {{ $bgColor }} text-white text-xs font-bold rounded-full">
                                                {{ strtoupper($related->category) }}
                                            </span>
                                        </div>
                                        
                                        <h4 class="text-base font-semibold text-gray-900 group-hover:text-blue-600 line-clamp-2 leading-snug">
                                            {{ $related->title }}
                                        </h4>
                                    </a>
                                @empty
                                    <p class="text-sm text-gray-500 text-center py-8">Belum ada artikel lain</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleReferences() {
    const content = document.getElementById('referenceContent');
    const icon = document.getElementById('referenceIcon');
    
    if (content.classList.contains('hidden')) {
        content.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
    } else {
        content.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
    }
}
</script>

<style>
.article-content h2 {
    font-size: 1.5rem;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    color: #1f2937;
}

.article-content h3 {
    font-size: 1.25rem;
    font-weight: 700;
    margin-top: 1.5rem;
    margin-bottom: 0.75rem;
    color: #1f2937;
}

.article-content p {
    margin-bottom: 1rem;
    line-height: 1.75;
}

.article-content ul, .article-content ol {
    margin-bottom: 1rem;
    padding-left: 1.5rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content a {
    color: #3b82f6;
    text-decoration: underline;
}

.article-content a:hover {
    color: #2563eb;
}

.article-content blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #4b5563;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.5rem;
    margin: 1.5rem 0;
}

.article-content .author-photo-wrap {
    float: left;
    width: 150px;
    height: 150px;
    margin-right: 1rem;
    margin-bottom: 0.75rem;
    object-fit: cover;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

@media (max-width: 640px) {
    .article-content .author-photo-wrap {
        width: 100px;
        height: 100px;
        margin-right: 0.75rem;
        margin-bottom: 0.5rem;
    }
}
</style>
@endsection
