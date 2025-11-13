@extends('layouts.app')

@section('title', 'Diskusi Terkait - ' . $article->title)

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Diskusi Terkait</h1>
            <p class="text-gray-600">Punya pertanyaan seputar {{ $article->category }}?</p>
        </div>

        <!-- Action Buttons -->
        <div class="flex gap-4 mb-8">
            <a href="{{ route('discussions.create') }}" class="px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 font-semibold transition">
                ✏️ Buat Pertanyaan
            </a>
            <a href="{{ route('discussions.index') }}" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                Lihat Semua Diskusi
            </a>
        </div>

        <!-- Discussions List -->
        <div class="space-y-6">
            @forelse($discussions as $discussion)
                <a href="{{ route('discussions.show', $discussion->id) }}" class="block border-b border-gray-200 pb-6 hover:bg-gray-50 p-4 rounded-lg transition">
                    <div class="flex items-start gap-4">
                        <!-- Avatar -->
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-lg">{{ substr($discussion->user->name, 0, 1) }}</span>
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $discussion->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">Oleh: {{ $discussion->user->name }}</p>
                            <p class="text-gray-700 line-clamp-2">{{ Str::limit($discussion->content, 150) }}</p>
                        </div>

                        <!-- Stats -->
                        <div class="text-right flex-shrink-0">
                            <div class="text-blue-600 font-semibold">{{ $discussion->replies_count }} Balasan</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $discussion->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="text-center py-12 bg-gray-50 rounded-lg">
                    <p class="text-gray-500 mb-4">Belum ada diskusi terkait artikel ini.</p>
                    <a href="{{ route('discussions.create') }}" class="text-blue-600 hover:underline font-semibold">
                        Buat pertanyaan baru di forum diskusi
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($discussions->hasPages())
            <div class="mt-8">
                {{ $discussions->links() }}
            </div>
        @endif

        <!-- Back to Article -->
        <div class="mt-8 text-center">
            <a href="/artikel/{{ $article->slug }}" class="text-blue-600 hover:underline">
                ← Kembali ke Artikel
            </a>
        </div>
    </div>
</div>
@endsection
