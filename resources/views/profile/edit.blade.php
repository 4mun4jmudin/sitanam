<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Profil Akun') }}
                </h2>
                <!-- Breadcrumbs -->
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-gray-700 font-medium">Profil</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Kelola informasi akun dan tingkatkan keamanan akses sistem Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-8 fade-in-content">
        
        <!-- HERO PROFILE CARD -->
        <div class="bg-gradient-to-r from-emerald-600 to-green-500 rounded-3xl p-8 text-white shadow-lg shadow-emerald-500/20 relative overflow-hidden">
            <!-- Decorative Accent -->
            <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-1/2 w-48 h-48 bg-emerald-400/20 rounded-full blur-2xl"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center md:justify-between gap-6">
                <!-- Avatar & Identity -->
                <div class="flex flex-col md:flex-row items-center text-center md:text-left gap-6">
                    <div class="relative group">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10b981&color=fff&size=128&bold=true" alt="Avatar" class="w-24 h-24 md:w-32 md:h-32 rounded-full border-4 border-white/30 shadow-xl object-cover transition-transform group-hover:scale-105">
                        <button class="absolute bottom-1 right-1 bg-white text-emerald-600 p-2 rounded-full shadow-lg hover:bg-emerald-50 transition-colors" title="Ubah Foto (Fitur Mendatang)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </button>
                    </div>
                    <div>
                        <h3 class="text-3xl font-extrabold tracking-tight">{{ $user->name }}</h3>
                        <p class="text-emerald-100 font-medium text-lg mt-1 block">{{ $user->email }}</p>
                        <div class="flex flex-wrap items-center justify-center md:justify-start gap-2 mt-3">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-lg text-sm font-semibold capitalize border border-white/20">
                                <svg class="w-4 h-4 inline mr-1 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                Role: {{ $user->role }}
                            </span>
                            <span class="px-3 py-1 bg-emerald-800/40 backdrop-blur-md rounded-lg text-sm font-medium border border-white/10">
                                <span class="inline-block w-2.5 h-2.5 rounded-full bg-green-400 mr-1 animate-pulse"></span>
                                Akun Aktif
                            </span>
                        </div>
                    </div>
                </div>
                <!-- Action / Info block -->
                <div class="hidden lg:block text-right bg-white/10 backdrop-blur-sm p-4 rounded-2xl border border-white/20">
                    <p class="text-xs text-emerald-100 uppercase tracking-widest font-bold mb-1">Tanggal Bergabung</p>
                    <p class="text-lg font-semibold">{{ $user->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>

        <!-- GRID LAYOUT CONTENT -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-10">
            
            <!-- LEFT COLUMN (Main Forms) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- 1. Profile Information Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
                    <div class="p-6 sm:p-8 border-b border-gray-50 flex items-center bg-gray-50/50">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Informasi Dasar Akun</h3>
                            <p class="text-sm text-gray-500">Perbarui identitas dan alamat email aktif Anda di sini.</p>
                        </div>
                    </div>
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- 2. Security Password Form -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative">
                    <div class="p-6 sm:p-8 border-b border-gray-50 flex items-center bg-gray-50/50">
                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center mr-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Keamanan & Sandi</h3>
                            <p class="text-sm text-gray-500">Ganti kata sandi secara berkala untuk menjaga keamanan akun.</p>
                        </div>
                    </div>
                    <div class="p-6 sm:p-8">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN (Metadata Info Sidebar) -->
            <div class="space-y-8">
                <!-- Info Status Card -->
                <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 text-white relative overflow-hidden shadow-lg">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-emerald-500 rounded-full blur-3xl opacity-20"></div>
                    <h3 class="text-sm font-medium text-gray-400 mb-6 uppercase tracking-widest flex items-center">
                        <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Sistem Validasi
                    </h3>
                    
                    <div class="space-y-5 relative z-10">
                        <div class="flex justify-between items-end border-b border-gray-800 pb-3">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">Status Verifikasi Email</p>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 mr-2"></span>
                                    <span class="font-semibold text-sm">Terverifikasi Otomatis</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-end border-b border-gray-800 pb-3">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">Otentikasi Login</p>
                                <p class="font-medium text-sm text-gray-200">Sesi Aktif (Laravel Auth)</p>
                            </div>
                        </div>

                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-xs text-gray-400 mb-1">Tipe Enkripsi</p>
                                <p class="font-medium text-sm text-gray-200">Bcrypt Hash Secure</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Danger Zone / Delete Account -->
                <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                    <div class="p-6 border-b border-red-50 bg-red-50/30">
                        <h3 class="text-lg font-bold text-red-600 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            Zona Berbahaya
                        </h3>
                    </div>
                    <div class="p-6">
                        <p class="text-sm text-gray-600 mb-4">Setelah akun Anda dihapus, semua sumber daya dan data akan dihapus secara permanen.</p>
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
