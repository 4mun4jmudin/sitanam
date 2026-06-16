<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="space-y-6" x-data="{ isSubmitting: false }" @submit="isSubmitting = true">
    @csrf
    @method('patch')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nama Field -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap Lengkap</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </span>
                <input id="name" name="name" type="text" class="w-full pl-10 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Email Field -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email / Surel</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </span>
                <input id="email" name="email" type="email" class="w-full pl-10 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" value="{{ old('email', $user->email) }}" required autocomplete="username" />
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 text-sm bg-yellow-50 p-3 rounded-lg border border-yellow-100 flex items-center">
                    <svg class="w-5 h-5 text-yellow-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <p class="text-yellow-800 font-medium">{{ __('Email Anda belum diverifikasi.') }}</p>
                        <button form="send-verification" class="text-emerald-600 hover:text-emerald-800 font-bold underline transition-colors">
                            {{ __('Klik di sini untuk mengirim ulang.') }}
                        </button>
                    </div>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-xs text-green-600 bg-green-50 p-2 rounded border border-green-100">
                        {{ __('Link verifikasi baru telah dikirimkan.') }}
                    </p>
                @endif
            @endif
        </div>
        
        <!-- Optional Aesthetic Mock Fields -->
        <div>
            <label class="block text-sm font-semibold text-gray-400 mb-1.5">Nomor Handphone <span class="font-normal text-xs">(Opsional)</span></label>
            <input type="text" placeholder="Belum disetel" class="w-full bg-gray-50 border-gray-200 text-gray-500 rounded-xl cursor-not-allowed" disabled>
        </div>
        <div>
            <label class="block text-sm font-semibold text-gray-400 mb-1.5">Divisi / Instansi</label>
            <input type="text" value="SMK IT Al-Hawari" class="w-full bg-gray-50 border-gray-200 text-gray-500 rounded-xl cursor-not-allowed" disabled>
        </div>
    </div>

    <div class="flex items-center justify-between pt-6 border-t border-gray-50 mt-8">
        @if (session('status') === 'profile-updated')
            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="text-sm font-bold text-emerald-600 flex items-center bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Perubahan tersimpan!
            </p>
        @else
            <div></div> <!-- Spacer -->
        @endif
        
        <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition-all shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 ml-auto">
            <span x-show="!isSubmitting">Simpan Informasi</span>
            <span x-show="isSubmitting" x-cloak class="flex items-center">
                Memproses... <svg class="animate-spin ml-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </span>
        </button>
    </div>
</form>
