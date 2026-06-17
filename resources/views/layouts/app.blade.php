<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>HawariFarm - Dashboard Premium</title>
        
        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Hotwire Turbo Drive for SPA-like Navigation -->
        <script type="module">
            import * as Turbo from 'https://cdn.jsdelivr.net/npm/@hotwired/turbo@8.0.4/+esm';
        </script>
        
        <style>
            .turbo-progress-bar {
                height: 4px;
                background-color: #10B981; /* emerald-500 */
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.5);
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-900 bg-[#F4F7F6] overflow-x-hidden" x-data="{ sidebarExpanded: localStorage.getItem('sb') !== null ? localStorage.getItem('sb') === 'true' : window.innerWidth > 1024, mobileSidebarOpen: false }" x-init="$watch('sidebarExpanded', val => localStorage.setItem('sb', val))">
        
        <!-- Mobile Sidebar Overlay overlay with smooth fade zoom -->
        <div x-show="mobileSidebarOpen" class="fixed inset-0 z-40 bg-gray-900/60 backdrop-blur-sm lg:hidden" @click="mobileSidebarOpen = false" x-transition.opacity></div>

        <!-- SIDEBAR (Left Panel) -->
        <aside class="fixed inset-y-0 left-0 z-50 flex flex-col bg-white border-r border-gray-100 shadow-xl shadow-emerald-900/5 transition-all duration-300 transform lg:translate-x-0" 
               :class="[sidebarExpanded ? 'w-64' : 'w-20', mobileSidebarOpen ? 'translate-x-0' : '-translate-x-full']">
            
            <!-- Logo Section -->
            <div class="h-16 flex items-center justify-between px-4 border-b border-gray-50 flex-shrink-0 relative">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 overflow-hidden group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 shadow-md flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M7 20h10" />
                            <path d="M10 20c5.5-2.5 6-10 6-10" />
                            <path d="M18 8c0 4.5-4.5 6-9 6H5V9c0-4.5 4.5-6 9-6h4v5Z" />
                        </svg>
                    </div>
                    <span x-show="sidebarExpanded" x-transition.opacity.duration.300ms class="font-extrabold text-lg tracking-tight text-gray-800 whitespace-nowrap">Hawari<span class="text-emerald-500">Farm</span></span>
                </a>
                <!-- Mobile Close Btn -->
                <button type="button" @click="mobileSidebarOpen = false" class="lg:hidden text-gray-400 hover:text-gray-600 p-2 focus:outline-none relative z-50 cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Scrollable Nav Links -->
            <div class="flex-1 overflow-y-auto py-4 scrollbar-hide space-y-1 px-3">
                
                @php
                    $role = auth()->user()->role ?? 'siswa';
                @endphp

                <!-- 1. Menu Dashboard -->
                <a href="{{ route('dashboard') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 font-semibold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}" title="Dashboard Utama">
                    <svg class="flex-shrink-0 w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    <span x-show="sidebarExpanded" x-transition.opacity class="ml-3 truncate">Dashboard</span>
                </a>

                @if($role === 'admin')
                <!-- Menu Admin -->
                <div x-show="sidebarExpanded" class="mt-8 mb-3 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-4">Manajemen Pengguna</div>
                <a href="{{ route('admin.pengguna.index') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.pengguna.*') ? 'bg-emerald-50 text-emerald-600 font-semibold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}" title="Kelola Admin, Guru, Siswa">
                    <svg class="flex-shrink-0 w-5 h-5 {{ request()->routeIs('admin.pengguna.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <span x-show="sidebarExpanded" x-transition.opacity class="ml-3 truncate">Semua Pengguna</span>
                </a>
                
                <div x-show="sidebarExpanded" class="mt-8 mb-3 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-4">Master Data</div>
                <a href="{{ route('admin.jenis_tanaman.index') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.jenis_tanaman.*') ? 'bg-emerald-50 text-emerald-600 font-semibold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}" title="Master Tanaman">
                    <svg class="flex-shrink-0 w-5 h-5 {{ request()->routeIs('admin.jenis_tanaman.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span x-show="sidebarExpanded" x-transition.opacity class="ml-3 truncate">Master Tanaman</span>
                </a>
                @endif

                @if(in_array($role, ['guru', 'siswa']))
                
                @if($role === 'guru')
                <div x-show="sidebarExpanded" class="mt-8 mb-3 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-4">Master Data</div>
                <a href="{{ route('guru.jenis_tanaman.index') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs('guru.jenis_tanaman.*') ? 'bg-emerald-50 text-emerald-600 font-semibold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}" title="Master Tanaman">
                    <svg class="flex-shrink-0 w-5 h-5 {{ request()->routeIs('guru.jenis_tanaman.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500 transition-colors' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span x-show="sidebarExpanded" x-transition.opacity class="ml-3 truncate">Master Tanaman</span>
                </a>
                @endif

                <!-- Menu Data Pertanian (Guru & Siswa) -->
                <div x-show="sidebarExpanded" class="mt-8 mb-3 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-4">Data Pertanian</div>
                
                <a href="{{ route($role.'.penanaman.index') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs($role.'.penanaman.*') ? 'bg-emerald-50 text-emerald-600 font-semibold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}" title="Penanaman">
                    <svg class="flex-shrink-0 w-5 h-5 {{ request()->routeIs($role.'.penanaman.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span x-show="sidebarExpanded" class="ml-3 truncate">Rekap Penanaman</span>
                </a>
                
                <a href="{{ route($role.'.pemeliharaan.index') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs($role.'.pemeliharaan.*') ? 'bg-emerald-50 text-emerald-600 font-semibold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}" title="Pemeliharaan Mingguan">
                    <svg class="flex-shrink-0 w-5 h-5 {{ request()->routeIs($role.'.pemeliharaan.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                    <span x-show="sidebarExpanded" class="ml-3 truncate">Pemeliharaan</span>
                </a>
                
                <a href="{{ route($role.'.panen.index') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs($role.'.panen.*') ? 'bg-emerald-50 text-emerald-600 font-semibold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-900' }}" title="Catat Panen">
                    <svg class="flex-shrink-0 w-5 h-5 {{ request()->routeIs($role.'.panen.*') ? 'text-emerald-500' : 'text-gray-400 group-hover:text-emerald-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    <span x-show="sidebarExpanded" class="ml-3 truncate">Catat Panen</span>
                </a>
                @endif

                <!-- Evaluasi Logika -->
                <div x-show="sidebarExpanded" class="mt-8 mb-3 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-4">Evaluasi Lanjutan</div>
                <a href="{{ route($role.'.evaluasi.index') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs($role.'.evaluasi.*') ? 'bg-orange-50 text-orange-600 font-semibold shadow-sm' : 'text-gray-500 hover:bg-orange-50 hover:text-orange-700' }}" title="Evaluasi Keputusan (Decision Tree)">
                    <svg class="flex-shrink-0 w-5 h-5 {{ request()->routeIs($role.'.evaluasi.*') ? 'text-orange-500' : 'text-gray-400 group-hover:text-orange-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    <span x-show="sidebarExpanded" class="ml-3 truncate">Evaluasi Panen</span>
                </a>

                <!-- Bantuan & Dokumentasi -->
                <div x-show="sidebarExpanded" class="mt-8 mb-3 px-3 text-[10px] font-bold text-gray-400 uppercase tracking-widest leading-4">Pusat Bantuan</div>
                <a href="{{ route($role.'.dokumentasi') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 {{ request()->routeIs($role.'.dokumentasi') ? 'bg-blue-50 text-blue-600 font-semibold shadow-sm' : 'text-gray-500 hover:bg-blue-50 hover:text-blue-700' }}" title="Buku Panduan Sistem">
                    <svg class="flex-shrink-0 w-5 h-5 {{ request()->routeIs($role.'.dokumentasi') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    <span x-show="sidebarExpanded" class="ml-3 truncate">Panduan Sistem</span>
                </a>

            </div>

            <!-- Sidebar Footer: Settings & Logout -->
            <div class="p-4 border-t border-gray-50 space-y-1 flex-shrink-0">
                <!-- Setting Profile Route Option -->
                <a href="{{ route('profile.edit') }}" class="group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 text-gray-500 hover:bg-gray-50 hover:text-gray-900" title="Profil & Pengaturan">
                    <svg class="flex-shrink-0 w-5 h-5 text-gray-400 group-hover:text-emerald-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span x-show="sidebarExpanded" class="ml-3 truncate">Profil Akun</span>
                </a>
                
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full group flex items-center px-3 py-2.5 rounded-xl transition-all duration-200 text-red-500 hover:bg-red-50 focus:outline-none" title="Keluar">
                        <svg class="flex-shrink-0 w-5 h-5 text-red-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span x-show="sidebarExpanded" class="ml-3 truncate font-medium">Logout Sing out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- CONTENT AREA (Right Panel) -->
        <div class="flex flex-col flex-1 min-h-screen transition-all duration-300" :class="sidebarExpanded ? 'lg:pl-64' : 'lg:pl-20'">
            
            <!-- Elegan Topbar -->
            <header class="sticky top-0 z-30 bg-white/70 backdrop-blur-lg border-b border-gray-100 flex items-center justify-between h-16 px-4 md:px-8">
                
                <!-- Kiri: Hamburger Toggle Sidebar -->
                <div class="flex items-center">
                    <button @click="window.innerWidth >= 1024 ? sidebarExpanded = !sidebarExpanded : mobileSidebarOpen = true" class="flex items-center justify-center w-10 h-10 rounded-xl text-gray-600 bg-white border border-gray-200 hover:text-emerald-600 hover:bg-emerald-50 hover:border-emerald-200 transition-all focus:outline-none shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    </button>
                </div>

                <!-- Kanan: Jam realtime & Profile Dropdown -->
                <div class="flex items-center space-x-3 md:space-x-5">
                    
                    <!-- Digital Clock -->
                    <div class="hidden md:flex items-center px-3 py-1.5 rounded-lg bg-gray-50/80 border border-gray-200">
                        <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span id="topbar-clock" class="text-xs font-semibold text-gray-700 tracking-wider">--:--:--</span>
                    </div>

                    <!-- Profile Dropdown Component (Alpine JS) -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                        <button @click="open = ! open" class="flex items-center gap-3 p-1 pr-3 rounded-full hover:bg-gray-50 border border-transparent hover:border-gray-100 transition focus:outline-none">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=E0F2FE&color=0284C7&bold=true" class="w-8 h-8 rounded-full border border-gray-200 shadow-sm" alt="User Avatar">
                            <div class="hidden sm:block text-left mr-1">
                                <p class="text-sm font-bold text-gray-800 leading-tight">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] font-semibold text-gray-500 uppercase tracking-widest">{{ auth()->user()->role }}</p>
                            </div>
                            <svg class="hidden sm:block w-4 h-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                        </button>

                        <div x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-56 rounded-2xl shadow-xl bg-white border border-gray-100 ring-1 ring-black ring-opacity-5 py-1 z-50 focus:outline-none"
                                style="display: none;">
                            
                            <!-- Dropdown Content -->
                            <div class="px-4 py-3 border-b border-gray-50 mb-1">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 font-medium transition-colors">
                                Pengaturan Akun
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700 font-medium transition-colors">
                                    Logout Session
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </header>

            <!-- Dynamic Slot Injector -->
            <main class="flex-1 bg-gray-50/50 relative">

                <!-- Content Area SPA Loading Overlay -->
                <div id="spa-loader" class="absolute inset-0 z-[60] bg-gray-50/60 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-200">
                    <div class="sticky top-[40vh] flex flex-col items-center justify-center">
                        <svg class="animate-spin h-10 w-10 text-emerald-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-xs font-bold text-emerald-700 tracking-widest animate-pulse">MEMUAT...</span>
                    </div>
                </div>
                
                <!-- Inner Page Header Rendering -->
                @isset($header)
                    <div class="bg-white/50 backdrop-blur border-b border-gray-100 mb-6">
                        <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </div>
                @endisset
                
                <!-- Magic Slot - View content injected here with smooth fading -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 {{ isset($header) ? '' : 'pt-8' }}">
                    <div class="page-content-fade">
                        @if (isset($slot))
                            {{ $slot }}
                        @else
                            @yield('content')
                        @endif
                    </div>
                </div>
            </main>

        </div>

        <!-- Utility Scripts & Styles -->
        <script>
            // 1. Smart Loader: Only show if request takes more than 150ms
            document.addEventListener("turbo:click", function() {
                window.spaLoaderTimeout = setTimeout(() => {
                    const loader = document.getElementById('spa-loader');
                    if(loader) {
                        loader.classList.remove('opacity-0', 'pointer-events-none');
                        loader.classList.add('opacity-100');
                    }
                }, 150);
            });

            document.addEventListener("turbo:load", function() {
                if(spaLoaderTimeout) clearTimeout(spaLoaderTimeout);
            });

            // 2. Initialize Clock
            let globalClockInterval = null;
            function initGlobalClock() {
                if (globalClockInterval) clearInterval(globalClockInterval);
                const el = document.getElementById('topbar-clock');
                if (!el) return;
                
                function update() {
                    const now = new Date();
                    el.textContent = now.toLocaleTimeString('id-ID', { hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit' });
                }
                update();
                globalClockInterval = setInterval(update, 1000);
            }
            
            document.addEventListener("turbo:load", initGlobalClock);
            document.addEventListener("DOMContentLoaded", initGlobalClock);
        </script>
        
        <style>
            /* Custom Scrollbar override for clean SAAS feel */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f5f9; 
            }
            ::-webkit-scrollbar-thumb {
                background: #cbd5e1; 
                border-radius: 10px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8; 
            }

            /* Hiding scrollbar specifically for sidebar */
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            /* Smooth Content Entry */
            .page-content-fade {
                animation: slideFadeUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            @keyframes slideFadeUp {
                from { opacity: 0; transform: translateY(15px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>
    </body>
</html>
