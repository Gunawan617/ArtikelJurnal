@extends('layouts.app')

@section('title', 'Tentang Kami')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative isolate px-6 pt-14 lg:px-8">
        <div class="mx-auto max-w-2xl py-16 sm:py-24 lg:py-32 text-center">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl mb-6">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">ScholarHub</span>
            </h1>
            <p class="text-xl font-semibold text-gray-900 mb-4">
                Platform publikasi ilmiah era baru.
            </p>
            <p class="mt-6 text-lg leading-8 text-gray-600">
                Kami percaya bahwa penelitian berkualitas harus mudah ditemukan. ScholarHub hadir sebagai platform modern yang membantu akademisi mempublikasikan karya ilmiah dengan mudah dan memastikan konten Anda terindeks oleh Google Scholar tanpa ribet.
            </p>
        </div>
    </div>

    <!-- Features Section -->
    <div class="bg-gray-50 py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-blue-600">Keunggulan Kami</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Apa yang Anda dapatkan?</p>
            </div>
            <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                    <!-- Feature 1 -->
                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                <span class="text-xl">📝</span>
                            </div>
                            Publikasi artikel dengan metadata otomatis
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">Sistem kami secara otomatis mengelola metadata agar artikel Anda siap terindeks dengan sempurna.</dd>
                    </div>

                    <!-- Feature 2 -->
                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                <span class="text-xl">📚</span>
                            </div>
                            Manajemen PDF dan referensi yang rapi
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">Kelola file PDF dan daftar pustaka Anda dengan antarmuka yang intuitif dan terstruktur.</dd>
                    </div>

                    <!-- Feature 3 -->
                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                <span class="text-xl">💬</span>
                            </div>
                            Ruang diskusi untuk mendorong kolaborasi
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">Bangun koneksi dan diskusikan temuan penelitian dengan sesama akademisi di platform kami.</dd>
                    </div>

                    <!-- Feature 4 -->
                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                <span class="text-xl">✨</span>
                            </div>
                            UI/UX modern dan ringan
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">Nikmati pengalaman pengguna yang mulus dengan desain antarmuka yang bersih dan responsif.</dd>
                    </div>

                    <!-- Feature 5 -->
                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                <span class="text-xl">🚀</span>
                            </div>
                            SEO bawaan untuk visibilitas maksimal
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">Optimasi mesin pencari sudah terintegrasi untuk memastikan karya Anda mudah ditemukan oleh dunia.</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl mb-8">Hubungi Kami</h2>
                <div class="bg-blue-50 rounded-2xl p-8 md:p-12 border border-blue-100">
                    <div class="flex flex-col md:flex-row justify-center items-center gap-8 md:gap-16">
                        <div class="flex items-center gap-4">
                            <div class="bg-white p-3 rounded-full shadow-sm">
                                <span class="text-2xl">📧</span>
                            </div>
                            <div class="text-left">
                                <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide">Email</p>
                                <a href="mailto:admin@scholarhub.com" class="text-lg font-medium text-gray-900 hover:text-blue-600 transition">admin@scholarhub.com</a>
                            </div>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="bg-white p-3 rounded-full shadow-sm">
                                <span class="text-2xl">🌐</span>
                            </div>
                            <div class="text-left">
                                <p class="text-sm text-gray-500 font-semibold uppercase tracking-wide">Website</p>
                                <a href="https://scholarhub.com" class="text-lg font-medium text-gray-900 hover:text-blue-600 transition">scholarhub.com</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
