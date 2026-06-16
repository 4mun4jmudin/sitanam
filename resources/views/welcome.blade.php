<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HawariFarm - Sistem Pendataan Panen</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900 bg-gray-50 overflow-hidden selection:bg-emerald-500 selection:text-white">
    
    <!-- Background Decor -->
    <div class="fixed inset-0 z-[-1] bg-gradient-to-br from-emerald-50 to-teal-100"></div>
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden z-[-1] pointer-events-none">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full bg-emerald-400/20 blur-3xl mix-blend-multiply"></div>
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] rounded-full bg-teal-400/20 blur-3xl mix-blend-multiply"></div>
    </div>

    <!-- Navigation -->
    <nav class="relative z-10 w-full px-6 py-6 lg:px-12 flex justify-between items-center">
        <div class="flex items-center gap-3 group cursor-pointer">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 shadow-lg shadow-emerald-500/30 flex items-center justify-center transform group-hover:rotate-6 transition-all duration-300">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M7 20h10" />
                    <path d="M10 20c5.5-2.5 6-10 6-10" />
                    <path d="M18 8c0 4.5-4.5 6-9 6H5V9c0-4.5 4.5-6 9-6h4v5Z" />
                </svg>
            </div>
            <span class="font-extrabold text-2xl tracking-tight text-gray-800">Hawari<span class="text-emerald-600">Farm</span></span>
        </div>
        
        <div>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-full bg-white text-emerald-600 font-bold border border-emerald-100 shadow-sm hover:shadow-md hover:bg-emerald-50 transition-all duration-300">Dashboard Utama</a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-full bg-white text-emerald-600 font-bold border border-emerald-100 shadow-sm hover:shadow-md hover:bg-emerald-50 transition-all duration-300 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                        Log in
                    </a>
                @endauth
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    <main class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-12 h-[calc(100vh-100px)] flex flex-col justify-center items-center text-center">
        
        <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/60 backdrop-blur-md border border-emerald-100/50 text-emerald-700 text-sm font-semibold mb-8 shadow-sm animate-fade-in-up">
            <span class="flex w-2 h-2 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
            Platform Manajemen Pertanian Digital
        </div>

        <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 tracking-tight mb-6 max-w-4xl animate-fade-in-up" style="animation-delay: 100ms;">
            Cerdaskan Panenmu dengan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">HawariFarm</span>
        </h1>
        
        <p class="text-lg md:text-xl text-gray-600 mb-10 max-w-2xl font-medium animate-fade-in-up" style="animation-delay: 200ms;">
            Sistem informasi pendataan terpadu SMK IT Al-Hawari untuk mengelola kegiatan penanaman, pemeliharaan, hingga evaluasi panen secara profesional.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up" style="animation-delay: 300ms;">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/dashboard') }}" class="group relative px-8 py-4 bg-emerald-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-emerald-500/30 hover:bg-emerald-700 hover:-translate-y-1 transition-all duration-300 overflow-hidden flex items-center justify-center">
                        <span class="relative z-10 flex items-center">
                            Akses Dashboard Saya
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="group relative px-8 py-4 bg-emerald-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-emerald-500/30 hover:bg-emerald-700 hover:-translate-y-1 transition-all duration-300 overflow-hidden flex items-center justify-center">
                        <span class="relative z-10 flex items-center">
                            Masuk ke Sistem
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-500 to-teal-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                @endauth
            @endif
        </div>
        
    </main>

    <style>
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(20px);
        }
        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>
</html>
