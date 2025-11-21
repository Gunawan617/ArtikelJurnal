<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ScholarHub') - Platform Artikel Ilmiah</title>

    <!-- SEO Meta Tags -->
    <meta name="description"
        content="@yield('description', 'Platform publikasi dan diskusi artikel ilmiah terindeks Google Scholar')">
    <meta name="robots" content="index, follow">

    @stack('head')

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        /* Prose styling untuk konten artikel */
        .prose {
            max-width: 65ch;
        }

        .prose p {
            margin-bottom: 1.25em;
            line-height: 1.75;
            color: #374151;
        }

        .prose h1 {
            font-size: 2.25em;
            font-weight: 800;
            margin-top: 0;
            margin-bottom: 0.8888889em;
            line-height: 1.1111111;
            color: #111827;
        }

        .prose h2 {
            font-size: 1.5em;
            font-weight: 700;
            margin-top: 2em;
            margin-bottom: 1em;
            line-height: 1.3333333;
            color: #111827;
        }

        .prose h3 {
            font-size: 1.25em;
            font-weight: 600;
            margin-top: 1.6em;
            margin-bottom: 0.6em;
            line-height: 1.6;
            color: #111827;
        }

        .prose strong {
            font-weight: 600;
            color: #111827;
        }

        .prose em {
            font-style: italic;
        }

        .prose ul,
        .prose ol {
            margin-top: 1.25em;
            margin-bottom: 1.25em;
            padding-left: 1.625em;
        }

        .prose li {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }

        .prose blockquote {
            font-style: italic;
            border-left: 4px solid #3b82f6;
            padding-left: 1em;
            margin: 1.6em 0;
            color: #4b5563;
        }

        .prose a {
            color: #3b82f6;
            text-decoration: underline;
        }

        .prose a:hover {
            color: #2563eb;
        }

        .prose img {
            margin-top: 2em;
            margin-bottom: 2em;
            border-radius: 0.5rem;
        }

        .prose code {
            background-color: #f3f4f6;
            padding: 0.2em 0.4em;
            border-radius: 0.25rem;
            font-size: 0.875em;
        }

        .prose pre {
            background-color: #1f2937;
            color: #f9fafb;
            padding: 1em;
            border-radius: 0.5rem;
            overflow-x: auto;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-gray-50">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <a href="/" class="text-xl md:text-2xl font-bold text-blue-600">ScholarHub</a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="text-gray-700 hover:text-blue-600 transition">Home</a>
                    <a href="/artikel" class="text-gray-700 hover:text-blue-600 transition">Artikel</a>
                    <a href="/diskusi" class="text-gray-700 hover:text-blue-600 transition">Diskusi</a>
                    <a href="/tentang" class="text-gray-700 hover:text-blue-600 transition">Tentang</a>

                    @auth
                        <div class="relative">
                            <button id="user-menu-button"
                                class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 transition py-2 px-3 rounded-lg hover:bg-gray-50">
                                <span class="hidden lg:inline">{{ Str::limit(auth()->user()->name, 15) }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div id="user-menu-dropdown"
                                class="hidden absolute right-0 top-full mt-1 w-48 bg-white rounded-lg shadow-lg py-2 border border-gray-100 z-50">
                                @if(auth()->user()->role === 'admin')
                                    <a href="/admin" class="block px-4 py-2 text-gray-700 hover:bg-blue-50 transition">Admin
                                        Panel</a>
                                @endif
                                <form action="/logout" method="POST">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-gray-700 hover:bg-blue-50 transition">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="/login" class="text-gray-700 hover:text-blue-600 transition">Login</a>
                        <a href="/register"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden text-gray-700 hover:text-blue-600 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path id="close-icon" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="/" class="text-gray-700 hover:text-blue-600 py-2 border-b border-gray-100">Home</a>
                    <a href="/artikel"
                        class="text-gray-700 hover:text-blue-600 py-2 border-b border-gray-100">Artikel</a>
                    <a href="/diskusi"
                        class="text-gray-700 hover:text-blue-600 py-2 border-b border-gray-100">Diskusi</a>
                    <a href="/tentang"
                        class="text-gray-700 hover:text-blue-600 py-2 border-b border-gray-100">Tentang</a>

                    @auth
                        <div class="pt-2 border-t border-gray-200">
                            <p class="text-sm text-gray-600 mb-2">{{ auth()->user()->name }}</p>
                            @if(auth()->user()->role === 'admin')
                                <a href="/admin" class="block text-gray-700 hover:text-blue-600 py-2">Admin Panel</a>
                            @endif
                            <form action="/logout" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left text-gray-700 hover:text-blue-600 py-2">Logout</button>
                            </form>
                        </div>
                    @else
                        <div class="pt-2 border-t border-gray-200 space-y-2">
                            <a href="/login"
                                class="block text-center py-2 text-gray-700 hover:text-blue-600 border border-gray-300 rounded-lg">Login</a>
                            <a href="/register"
                                class="block text-center py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Daftar</a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');
        const closeIcon = document.getElementById('close-icon');

        if (mobileMenuButton) {
            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
                menuIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
            });
        }

        // User menu dropdown toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenuDropdown = document.getElementById('user-menu-dropdown');

        if (userMenuButton && userMenuDropdown) {
            userMenuButton.addEventListener('click', (e) => {
                e.stopPropagation();
                userMenuDropdown.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!userMenuButton.contains(e.target) && !userMenuDropdown.contains(e.target)) {
                    userMenuDropdown.classList.add('hidden');
                }
            });
        }

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (mobileMenuButton && !mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
                menuIcon.classList.remove('hidden');
                closeIcon.classList.add('hidden');
            }
        });
    </script>

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