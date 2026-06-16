<x-guest-layout>
    <!-- Header/Logo Area -->
    <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-emerald-100 mb-4 shadow-inner">
            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                <path d="M7 20h10" />
                <path d="M10 20c5.5-2.5 6-10 6-10" />
                <path d="M18 8c0 4.5-4.5 6-9 6H5V9c0-4.5 4.5-6 9-6h4v5Z" />
            </svg>
        </div>
        <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Sistem Pendataan Panen</h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">SMK IT Al-Hawari</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Pengguna</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email Anda" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-medium text-emerald-600 hover:text-emerald-500 transition-colors" href="{{ route('password.request') }}">
                        Lupa sandi?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm transition-colors"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 transition" name="remember">
                <span class="ms-2 text-sm text-gray-500 group-hover:text-gray-700 transition-colors">{{ __('Ingat Saya') }}</span>
            </label>
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm shadow-emerald-200 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all transform active:scale-95">
                {{ __('Masuk ke Sistem') }}
            </button>
        </div>
    </form>

    <div class="mt-8 pt-6 border-t border-gray-100">
        <div class="bg-blue-50/50 rounded-xl p-4 border border-blue-100">
            <p class="text-xs text-blue-800 font-semibold mb-2 flex items-center">
                <svg class="w-4 h-4 mr-1 pb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Informasi Akses Prototype
            </p>
            <div class="space-y-1 text-xs text-blue-600">
                <div class="flex justify-between"><span>Admin</span> <span class="font-mono">admin@sitanam.com</span></div>
                <div class="flex justify-between"><span>Siswa</span> <span class="font-mono">siswa@sitanam.com</span></div>
                <div class="flex justify-between"><span>Guru</span> <span class="font-mono">guru@sitanam.com</span></div>
                <div class="mt-2 text-gray-500 italic text-center">Password untuk semua akun: <span class="font-bold text-emerald-600">password</span></div>
            </div>
        </div>
    </div>
</x-guest-layout>
