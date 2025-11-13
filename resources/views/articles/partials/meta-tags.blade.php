{{-- Google Scholar Meta Tags --}}
<meta name="citation_title" content="{{ $article->title }}">
<meta name="citation_author" content="{{ $article->author }}">
<meta name="citation_publication_date" content="{{ $article->published_at ? $article->published_at->format('Y/m/d') : $article->created_at->format('Y/m/d') }}">
<meta name="citation_journal_title" content="Scholar System - Portal Artikel Ilmiah">
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

{{-- Dublin Core Meta Tags --}}
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

{{-- Open Graph Meta Tags --}}
<meta property="og:title" content="{{ $article->title }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url('/artikel/' . $article->slug) }}">
@if($article->image_path)
<meta property="og:image" content="{{ asset('storage/' . $article->image_path) }}">
@endif
@if($article->abstract)
<meta property="og:description" content="{{ strip_tags($article->abstract) }}">
@endif
<meta property="article:published_time" content="{{ $article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String() }}">
<meta property="article:author" content="{{ $article->author }}">

{{-- Twitter Card Meta Tags --}}
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $article->title }}">
@if($article->abstract)
<meta name="twitter:description" content="{{ strip_tags($article->abstract) }}">
@endif
@if($article->image_path)
<meta name="twitter:image" content="{{ asset('storage/' . $article->image_path) }}">
@endif

{{-- Schema.org JSON-LD --}}
@php
$schemaData = [
    '@context' => 'https://schema.org',
    '@type' => 'ScholarlyArticle',
    'headline' => $article->title,
    'author' => [
        '@type' => 'Person',
        'name' => $article->author,
    ],
    'datePublished' => $article->published_at ? $article->published_at->toIso8601String() : $article->created_at->toIso8601String(),
    'url' => url('/artikel/' . $article->slug),
    'publisher' => [
        '@type' => 'Organization',
        'name' => 'Scholar System',
        'url' => url('/'),
    ],
    'inLanguage' => 'id',
];

if ($article->author_institution) {
    $schemaData['author']['affiliation'] = [
        '@type' => 'Organization',
        'name' => $article->author_institution,
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
{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
