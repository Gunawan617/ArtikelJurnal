@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-16">
    <h1 class="text-4xl font-bold text-gray-900 mb-6">Tentang ScholarHub</h1>
    
    <div class="prose prose-lg max-w-none">
        <p class="text-gray-700 leading-relaxed mb-4">
            ScholarHub adalah platform publikasi artikel ilmiah yang dirancang khusus 
            untuk memudahkan dosen dan peneliti dalam mempublikasikan karya ilmiah mereka 
            agar dapat terindeks di Google Scholar.
        </p>
        
        <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Fitur Utama</h2>
        <ul class="space-y-2 text-gray-700">
            <li>✅ Publikasi artikel dengan metadata lengkap untuk Google Scholar</li>
            <li>✅ Upload PDF artikel dengan referensi ilmiah</li>
            <li>✅ Sistem komentar dan diskusi interaktif</li>
            <li>✅ Tampilan responsif dan modern</li>
            <li>✅ SEO-optimized untuk mesin pencari</li>
        </ul>
        
        <h2 class="text-2xl font-semibold text-gray-900 mt-8 mb-4">Kontak</h2>
        <p class="text-gray-700">
            Email: admin@scholarhub.com<br>
            Website: https://scholarhub.com
        </p>
    </div>
</div>
@endsection
