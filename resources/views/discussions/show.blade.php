@extends('layouts.app')

@section('title', $discussion->title)

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Discussion Question -->
        <div class="bg-white border-2 border-gray-200 rounded-lg p-6 mb-6">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0">
                    <span class="text-white font-bold text-2xl">{{ substr($discussion->user->name, 0, 1) }}</span>
                </div>
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $discussion->title }}</h1>
                    <p class="text-sm text-gray-600">Oleh: <span class="font-semibold">{{ $discussion->user->name }}</span></p>
                    <p class="text-xs text-gray-500">{{ $discussion->created_at->diffForHumans() }}</p>
                </div>
                
                @if(auth()->check() && auth()->id() === $discussion->user_id)
                    <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus diskusi ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                    </form>
                @endif
            </div>

            <div class="prose max-w-none text-gray-700 leading-relaxed">
                {{ $discussion->content }}
            </div>

            @if($discussion->related_keywords)
                <div class="mt-4 pt-4 border-t border-gray-200">
                    <p class="text-sm text-gray-600">Topik: 
                        <span class="font-semibold">{{ $discussion->related_keywords }}</span>
                    </p>
                </div>
            @endif
        </div>

        <!-- Reply Form -->
        @auth
            <div class="bg-blue-50 border-2 border-blue-200 rounded-lg p-6 mb-6">
                <h3 class="font-bold text-lg mb-4">Balas Diskusi</h3>
                <form action="{{ route('discussions.reply', $discussion->id) }}" method="POST">
                    @csrf
                    <textarea name="content" rows="4" class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none" placeholder="Tulis balasan Anda..." required></textarea>
                    <button type="submit" class="mt-3 px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                        Kirim Balasan
                    </button>
                </form>
            </div>
        @else
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 mb-6 text-center">
                <p class="text-gray-700">
                    <a href="/login" class="text-blue-600 hover:underline font-semibold">Login</a> untuk membalas diskusi ini.
                </p>
            </div>
        @endauth

        <!-- Replies -->
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $discussion->replies_count }} Balasan</h2>
            
            <div class="space-y-6">
                @forelse($discussion->replies as $reply)
                    <div class="border-l-4 border-blue-400 pl-6 py-4">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold">{{ substr($reply->user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <span class="font-bold text-gray-900">{{ $reply->user->name }}</span>
                                        <span class="text-xs text-gray-500 ml-2">{{ $reply->created_at->diffForHumans() }}</span>
                                    </div>
                                    @if(auth()->check() && auth()->id() === $reply->user_id)
                                        <form action="{{ route('discussions.reply.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus balasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                                <p class="text-gray-700 leading-relaxed">{{ $reply->content }}</p>

                                <!-- Nested Replies -->
                                @if($reply->replies->count() > 0)
                                    <div class="mt-4 ml-8 space-y-4">
                                        @foreach($reply->replies as $nestedReply)
                                            <div class="border-l-2 border-gray-300 pl-4">
                                                <div class="flex items-start gap-3">
                                                    <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                                                        <span class="text-gray-700 font-semibold text-sm">{{ substr($nestedReply->user->name, 0, 1) }}</span>
                                                    </div>
                                                    <div class="flex-1">
                                                        <div class="flex items-center justify-between mb-1">
                                                            <div>
                                                                <span class="font-semibold text-gray-900 text-sm">{{ $nestedReply->user->name }}</span>
                                                                <span class="text-xs text-gray-500 ml-2">{{ $nestedReply->created_at->diffForHumans() }}</span>
                                                            </div>
                                                            @if(auth()->check() && auth()->id() === $nestedReply->user_id)
                                                                <form action="{{ route('discussions.reply.destroy', $nestedReply->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus balasan ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="text-red-600 hover:text-red-800 text-xs">Hapus</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                        <p class="text-gray-700 text-sm leading-relaxed">{{ $nestedReply->content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">Belum ada balasan. Jadilah yang pertama membalas!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center">
            <a href="{{ route('discussions.index') }}" class="text-blue-600 hover:underline">
                ← Kembali ke Semua Diskusi
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
        {{ session('success') }}
    </div>
@endif
@endsection
