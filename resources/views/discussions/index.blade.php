@extends('layouts.app')

@section('title', 'Tanya Ahli')

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Tanya Ahli</h1>
            <p class="text-gray-600">Punya pertanyaan seputar penelitian atau artikel ilmiah?</p>
        </div>

        <!-- Search & Action Buttons -->
        <div class="mb-8">
            <div class="flex gap-4 mb-6">
                <!-- Search Form -->
                <form id="searchForm" action="{{ route('discussions.index') }}" method="GET" class="flex-1 flex gap-2">
                    <div class="flex-1 relative">
                        <input 
                            type="text" 
                            name="search" 
                            id="searchInput"
                            placeholder="Pencarian Topik" 
                            value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            autocomplete="off"
                        >
                        <svg class="w-5 h-5 text-gray-400 absolute left-3 top-1/2 transform -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                        </svg>
                        @if(request('search'))
                            <button type="button" onclick="clearSearch()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                    <button type="submit" class="px-8 py-3 bg-orange-500 text-white rounded-lg hover:bg-orange-600 font-semibold transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4">
                <a href="{{ route('discussions.create') }}" class="px-6 py-3 border-2 border-blue-600 text-blue-600 rounded-lg hover:bg-blue-50 font-semibold transition">
                    ✏️ Buat Pertanyaan
                </a>
                <button onclick="toggleTopicFilter()" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                    Cari Pertanyaan Berdasarkan Topik
                </button>
            </div>
        </div>

        <!-- Topic Filter (Show if search has results or filter active) -->
        <div id="topicFilter" class="{{ (request('search') || request('letter')) ? '' : 'hidden' }} mb-8">
            <h3 class="text-xl font-bold text-gray-900 mb-4">Cari berdasarkan abjad</h3>
            <div class="flex flex-wrap gap-2 mb-6">
                @foreach(range('A', 'Z') as $letter)
                    <a href="{{ route('discussions.index', array_merge(request()->except('letter'), ['letter' => $letter])) }}" 
                       class="w-10 h-10 flex items-center justify-center border border-gray-300 rounded hover:bg-blue-600 hover:text-white transition {{ request('letter') == $letter ? 'bg-blue-600 text-white' : 'bg-gray-100 text-gray-700' }}">
                        {{ $letter }}
                    </a>
                @endforeach
            </div>

            @if(request('letter') || request('search'))
                <div class="mb-4">
                    @if(request('search'))
                        <span class="text-sm text-gray-600">Pencarian: <strong>"{{ request('search') }}"</strong></span>
                    @endif
                    @if(request('letter'))
                        <span class="text-sm text-gray-600 ml-2">Filter: Abjad <strong>{{ request('letter') }}</strong></span>
                    @endif
                    <a href="{{ route('discussions.index') }}" class="ml-2 text-blue-600 hover:underline text-sm">Reset Semua</a>
                </div>
            @endif
        </div>

        <!-- Discussions List -->
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Diskusi Terbaru</h2>
        
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
                            <div class="flex items-center gap-2 mb-2">
                                <h3 class="text-lg font-bold text-gray-900">{{ $discussion->title }}</h3>
                                @if($discussion->is_closed)
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">🔒 DITUTUP</span>
                                @endif
                            </div>
                            <p class="text-sm text-gray-600 mb-2">Oleh: {{ $discussion->user->name }}</p>
                            
                            @if($discussion->related_keywords)
                                <p class="text-xs text-gray-500 mb-2">
                                    Topik: {{ $discussion->related_keywords }}
                                </p>
                            @endif
                            
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
                    @if(request('search') || request('letter'))
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Pencarian Tidak Ditemukan</h3>
                        <p class="text-gray-600 mb-4">
                            Maaf, diskusi yang Anda cari tidak ditemukan. 
                            @if(request('search'))
                                Silakan coba kata kunci lain.
                            @endif
                        </p>
                        <div class="flex gap-3 justify-center">
                            <a href="{{ route('discussions.index') }}" class="text-blue-600 hover:underline font-semibold">
                                Lihat Semua Diskusi
                            </a>
                            <span class="text-gray-400">|</span>
                            <a href="{{ route('discussions.create') }}" class="text-blue-600 hover:underline font-semibold">
                                Buat Pertanyaan Baru
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 mb-4">Belum ada diskusi.</p>
                        <a href="{{ route('discussions.create') }}" class="text-blue-600 hover:underline font-semibold">
                            Jadilah yang pertama bertanya!
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($discussions->hasPages())
            <div class="mt-8">
                {{ $discussions->links() }}
            </div>
        @endif
    </div>
</div>

<script>
function toggleTopicFilter() {
    const filter = document.getElementById('topicFilter');
    if (filter.classList.contains('hidden')) {
        filter.classList.remove('hidden');
    } else {
        filter.classList.add('hidden');
    }
}

function clearSearch() {
    document.getElementById('searchInput').value = '';
    document.getElementById('searchForm').submit();
}

// Auto show filter if search or letter parameter exists
document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const hasSearch = urlParams.has('search');
    const hasLetter = urlParams.has('letter');
    
    if (hasSearch || hasLetter) {
        const filter = document.getElementById('topicFilter');
        if (filter && filter.classList.contains('hidden')) {
            filter.classList.remove('hidden');
        }
    }

    // Live search - auto submit when typing stops
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    const searchForm = document.getElementById('searchForm');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            // If input is empty, submit immediately
            if (this.value.trim() === '') {
                searchForm.submit();
                return;
            }
            
            // Wait 500ms after user stops typing before searching
            searchTimeout = setTimeout(function() {
                searchForm.submit();
            }, 500);
        });
    }
});
</script>
@endsection
