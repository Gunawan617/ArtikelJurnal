@extends('layouts.app')

@section('title', 'Buat Pertanyaan Baru')

@section('content')
<div class="bg-white min-h-screen">
    <div class="max-w-3xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Buat Pertanyaan Baru</h1>
        <p class="text-gray-600 mb-8">Ajukan pertanyaan Anda dan dapatkan jawaban dari komunitas</p>

        <form action="{{ route('discussions.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Judul Pertanyaan</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Contoh: Bagaimana cara mengatasi..."
                    required
                    maxlength="255"
                    value="{{ old('title') }}"
                >
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-2">Detail Pertanyaan</label>
                <textarea 
                    name="content" 
                    id="content" 
                    rows="8" 
                    class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none" 
                    placeholder="Jelaskan pertanyaan Anda secara detail..."
                    required
                >{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keywords (Optional) -->
            <div>
                <label for="related_keywords" class="block text-sm font-semibold text-gray-700 mb-2">Topik Terkait (Opsional)</label>
                <input 
                    type="text" 
                    name="related_keywords" 
                    id="related_keywords" 
                    class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" 
                    placeholder="Contoh: penelitian, metodologi, statistik"
                    value="{{ old('related_keywords') }}"
                >
                <p class="text-xs text-gray-500 mt-1">Pisahkan dengan koma untuk membantu orang lain menemukan diskusi Anda</p>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold transition">
                    Kirim Pertanyaan
                </button>
                <a href="{{ route('discussions.index') }}" class="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
