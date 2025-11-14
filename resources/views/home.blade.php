@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-500 to-blue-600 py-12 md:py-16">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center text-white">
            <h1 class="text-3xl md:text-4xl font-bold mb-4">
                Portal Artikel Ilmiah Terindeks Google Scholar
            </h1>
            <p class="text-lg md:text-xl mb-6 text-blue-100">
                Layanan Publikasi dan Diskusi Artikel Ilmiah Terbaik di Indonesia
            </p>
            
            <!-- Feature Icons -->
            <div class="flex justify-center gap-8 mt-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                        </svg>
                    </div>
                    <p class="text-sm">Baca Artikel</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-sm">Tanya Dosen</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-2">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <p class="text-sm">Publikasi</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Articles Section -->
<div class="bg-white py-8 md:py-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Artikel Kesehatan Terkini untuk Anda</h2>
            <a href="/artikel" class="text-blue-600 hover:underline font-semibold hidden md:block">Lihat Semua →</a>
        </div>

        <!-- Category Tabs -->
        <div class="flex gap-4 mb-6 overflow-x-auto pb-2">
            @php
                $categories = \App\Models\Article::where('is_published', true)
                    ->select('category')
                    ->distinct()
                    ->pluck('category');
            @endphp
            <a href="/" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-full whitespace-nowrap hover:bg-gray-300 transition">
                Semua
            </a>
            @foreach($categories as $cat)
                <a href="/artikel?category={{ $cat }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-full whitespace-nowrap hover:bg-gray-200 transition">
                    {{ $cat }}
                </a>
            @endforeach
        </div>

        <!-- Articles Layout -->
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

        <!-- Desktop: Featured Left + Grid Right | Mobile: Stack -->
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Featured Article (Besar di Kiri) -->
            @if($featuredArticle)
                <div class="lg:w-1/2">
                    <a href="/artikel/{{ $featuredArticle->slug }}" class="block group h-full">
                        <div class="bg-white rounded-lg overflow-hidden hover:shadow-xl transition h-full flex flex-col">
                            <!-- Image -->
                            <div class="relative flex-shrink-0">
                                @if($featuredArticle->image_path)
                                    <img src="{{ asset('storage/' . $featuredArticle->image_path) }}" alt="{{ $featuredArticle->title }}" class="w-full h-64 lg:h-80 object-cover">
                                @else
                                    <div class="w-full h-64 lg:h-80 bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                        <span class="text-blue-400 text-6xl">📄</span>
                                    </div>
                                @endif
                                
                                <!-- Category Badge -->
                                @php
                                    $bgColor = $colorMap[$featuredArticle->category_color] ?? 'bg-green-500';
                                @endphp
                                <span class="absolute top-4 left-4 px-3 py-1 {{ $bgColor }} text-white text-sm font-bold rounded-full shadow-lg">
                                    {{ strtoupper($featuredArticle->category) }}
                                </span>
                            </div>

                            <!-- Content -->
                            <div class="p-6 flex-grow flex flex-col">
                                <h3 class="text-xl lg:text-2xl font-bold text-gray-900 group-hover:text-blue-600 line-clamp-2 mb-3 leading-tight">
                                    {{ $featuredArticle->title }}
                                </h3>
                                <p class="text-sm text-gray-600 line-clamp-3 mb-4 leading-relaxed flex-grow">
                                    {{ Str::limit(strip_tags($featuredArticle->content), 180) }}
                                </p>
                                
                                <!-- Credibility Badges -->
                                <div class="space-y-2 mb-3">
                                    <div class="flex items-center text-xs text-gray-600">
                                        <svg class="w-4 h-4 mr-1.5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span><strong>Ditinjau oleh:</strong> {{ $featuredArticle->author }}@if($featuredArticle->author_title), {{ $featuredArticle->author_title }}@endif</span>
                                    </div>
                                    <div class="flex items-center text-xs text-gray-600">
                                        <svg class="w-4 h-4 mr-1.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                        </svg>
                                        <span><strong>Diperbarui:</strong> {{ $featuredArticle->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm text-gray-500 pt-3 border-t border-gray-100">
                                    <span class="font-medium">{{ $featuredArticle->author_institution ?? 'Scholar System' }}</span>
                                    <span>{{ $featuredArticle->published_at ? $featuredArticle->published_at->format('d M Y') : $featuredArticle->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endif

            <!-- Small Articles Grid (Kanan - 2x2) -->
            <div class="lg:w-1/2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 h-full">
                    @foreach($articles as $article)
                        <a href="/artikel/{{ $article->slug }}" class="block group">
                            <div class="bg-white rounded-lg overflow-hidden hover:shadow-xl transition h-full flex flex-col">
                                <!-- Image -->
                                <div class="relative flex-shrink-0">
                                    @if($article->image_path)
                                        <img src="{{ asset('storage/' . $article->image_path) }}" alt="{{ $article->title }}" class="w-full h-40 lg:h-44 object-cover">
                                    @else
                                        <div class="w-full h-40 lg:h-44 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                            <span class="text-gray-400 text-3xl">📄</span>
                                        </div>
                                    @endif
                                    
                                    <!-- Category Badge -->
                                    @php
                                        $bgColor = $colorMap[$article->category_color] ?? 'bg-green-500';
                                    @endphp
                                    <span class="absolute top-3 left-3 px-2.5 py-1 {{ $bgColor }} text-white text-xs font-bold rounded-full shadow-md">
                                        {{ strtoupper($article->category) }}
                                    </span>
                                </div>

                                <!-- Content -->
                                <div class="p-4 flex-grow flex flex-col">
                                    <h3 class="text-sm lg:text-base font-bold text-gray-900 group-hover:text-blue-600 line-clamp-2 mb-2 leading-snug">
                                        {{ $article->title }}
                                    </h3>
                                    
                                    <!-- Credibility Badge (Compact) -->
                                    <div class="flex items-center text-xs text-gray-600 mb-2">
                                        <svg class="w-3 h-3 mr-1 text-green-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="truncate">Ditinjau oleh {{ Str::limit($article->author, 20) }}</span>
                                    </div>
                                    
                                    <div class="flex items-center justify-between text-xs text-gray-500 pt-2 border-t border-gray-100 mt-auto">
                                        <span class="truncate">{{ $article->author_institution ?? 'Scholar System' }}</span>
                                        <span class="text-xs whitespace-nowrap ml-2">{{ $article->updated_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- View All Button (Mobile) -->
        <div class="text-center mt-8 md:hidden">
            <a href="/artikel" class="inline-block px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                Lihat Semua Artikel
            </a>
        </div>
    </div>
</div>

<!-- Trust Indicators Section -->
<div class="bg-white py-12 border-y border-gray-200">
    <div class="max-w-6xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-center text-gray-900 mb-8">Mengapa Percaya Kami?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Ditinjau oleh Ahli</h3>
                <p class="text-sm text-gray-600">Semua artikel ditinjau oleh dosen dan peneliti berpengalaman dari universitas terkemuka</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Selalu Diperbarui</h3>
                <p class="text-sm text-gray-600">Konten kami diperbarui secara berkala mengikuti perkembangan penelitian terbaru</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Terindeks Google Scholar</h3>
                <p class="text-sm text-gray-600">Artikel kami terindeks di Google Scholar dan dapat disitasi untuk penelitian akademik</p>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Tanya Dosen -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Punya Pertanyaan?</h3>
                        <p class="text-sm text-gray-600">Tanya Ahli dan dapatkan jawaban</p>
                    </div>
                </div>
                <a href="/diskusi" class="block w-full text-center px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                    Tanya Sekarang
                </a>
            </div>

            <!-- Publikasi -->
            <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                            <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Dosen/Peneliti?</h3>
                        <p class="text-sm text-gray-600">Publikasikan artikel ilmiah Anda</p>
                    </div>
                </div>
                <a href="/login" class="block w-full text-center px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-lg font-semibold hover:bg-blue-50 transition">
                    Mulai Publikasi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
