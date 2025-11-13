<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ScholarHub') - Platform Artikel Ilmiah</title>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('description', 'Platform publikasi dan diskusi artikel ilmiah terindeks Google Scholar')">
    <meta name="robots" content="index, follow">
    
    @stack('head')
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Prose styling untuk konten artikel */
        .prose { max-width: 65ch; }
        .prose p { margin-bottom: 1.25em; line-height: 1.75; color: #374151; }
        .prose h1 { font-size: 2.25em; font-weight: 800; margin-top: 0; margin-bottom: 0.8888889em; line-height: 1.1111111; color: #111827; }
        .prose h2 { font-size: 1.5em; font-weight: 700; margin-top: 2em; margin-bottom: 1em; line-height: 1.3333333; color: #111827; }
        .prose h3 { font-size: 1.25em; font-weight: 600; margin-top: 1.6em; margin-bottom: 0.6em; line-height: 1.6; color: #111827; }
        .prose strong { font-weight: 600; color: #111827; }
        .prose em { font-style: italic; }
        .prose ul, .prose ol { margin-top: 1.25em; margin-bottom: 1.25em; padding-left: 1.625em; }
        .prose li { margin-top: 0.5em; margin-bottom: 0.5em; }
        .prose blockquote { font-style: italic; border-left: 4px solid #3b82f6; padding-left: 1em; margin: 1.6em 0; color: #4b5563; }
        .prose a { color: #3b82f6; text-decoration: underline; }
        .prose a:hover { color: #2563eb; }
        .prose img { margin-top: 2em; margin-bottom: 2em; border-radius: 0.5rem; }
        .prose code { background-color: #f3f4f6; padding: 0.2em 0.4em; border-radius: 0.25rem; font-size: 0.875em; }
        .prose pre { background-color: #1f2937; color: #f9fafb; padding: 1em; border-radius: 0.5rem; overflow-x: auto; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <a href="/" class="text-2xl font-bold text-blue-600">ScholarHub</a>
                
                <div class="flex items-center space-x-6">
                    <a href="/" class="text-gray-700 hover:text-blue-600">Home</a>
                    <a href="/artikel" class="text-gray-700 hover:text-blue-600">Artikel</a>
                    <a href="/tentang" class="text-gray-700 hover:text-blue-600">Tentang</a>
                    
                    @auth
                        <span class="text-gray-600">Halo, {{ auth()->user()->name }}</span>
                        @if(auth()->user()->role === 'admin')
                            <a href="/admin" class="text-gray-700 hover:text-blue-600">Admin</a>
                        @endif
                        <form action="/logout" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-gray-700 hover:text-blue-600">Logout</button>
                        </form>
                    @else
                        <a href="/login" class="text-gray-700 hover:text-blue-600">Login</a>
                        <a href="/register" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Daftar</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-16">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p>&copy; 2024 ScholarHub. Platform Artikel Ilmiah Terindeks Google Scholar.</p>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
