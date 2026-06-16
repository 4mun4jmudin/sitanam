<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Kelola Pengguna') }}
                </h2>
                <!-- Breadcrumbs -->
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-gray-700 font-medium">Pengguna</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Manajemen akun Admin, Guru, dan Siswa dalam satu panel cerdas.</p>
            </div>
        </div>
    </x-slot>

    <!-- Alpine Data Scope -->
    <div x-data="userManagement()" class="max-w-7xl mx-auto space-y-8">
        
        <!-- Alerts & Notifications -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl flex items-start shadow-sm fade-in-content mb-6">
                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex-1">
                    <h3 class="text-sm font-bold">Berhasil!</h3>
                    <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error') || $errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl flex items-start shadow-sm fade-in-content mb-6">
                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex-1">
                    <h3 class="text-sm font-bold">Terjadi Kesalahan!</h3>
                    @if(session('error'))
                        <p class="text-sm text-red-700 mt-1">{{ session('error') }}</p>
                    @endif
                    @foreach($errors->all() as $err)
                        <p class="text-sm text-red-700 mt-1">{{ $err }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Card Statistik User -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1 leading-none">Total Semua User</p>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-purple-50 text-purple-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1 leading-none">Admin Sistem</p>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['admin'] }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-red-50 text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1 leading-none">Total Guru</p>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['guru'] }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 hover:shadow-md transition-shadow duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1 leading-none">Total Siswa</p>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['siswa'] }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-emerald-50 text-emerald-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Tambah User Premium -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-50 rounded-bl-full -z-10 opacity-50"></div>
            
            <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                <span class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </span>
                Registrasi Pengguna Baru
            </h3>
            
            <form action="{{ route('admin.pengguna.store') }}" method="POST" @submit="isSubmitting = true">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name Input -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="name" placeholder="Contoh: Budi Santoso" class="w-full border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" required>
                    </div>
                    <!-- Email / Username Input -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email / Username <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </span>
                            <input type="email" name="email" placeholder="email@sekolah.com" class="w-full pl-10 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" required>
                        </div>
                    </div>
                    
                    <!-- Password Input with Toggle -->
                    <div x-data="{ showPw: false }">
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input :type="showPw ? 'text' : 'password'" name="password" placeholder="Minimal 6 karakter" class="w-full pr-10 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" required minlength="4">
                            <button type="button" @click="showPw = !showPw" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <svg x-show="!showPw" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.29 3.29m0 0a10.05 10.05 0 015.188-1.579c4.478 0 8.268 2.943 9.542 7a10.02 10.02 0 01-4.132 5.411m0 0l-3.29-3.29"></path></svg>
                                <svg x-show="showPw" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Role Dropdown -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Akses Role <span class="text-red-500">*</span></label>
                        <select name="role" class="w-full border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition-all" required>
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru</option>
                            <option value="admin">Admin Siber</option>
                        </select>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end space-x-3">
                    <button type="reset" class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-medium hover:bg-gray-50 focus:outline-none transition">
                        Reset Form
                    </button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 hover:bg-emerald-700 transition flex items-center">
                        <span x-show="!isSubmitting">Simpan Pengguna</span>
                        <span x-show="isSubmitting" x-cloak class="flex items-center">
                            Memproses <svg class="animate-spin ml-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Toolbar: Search & Filter Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <h3 class="text-lg font-bold text-gray-900">Direktori Pengguna</h3>
                
                <!-- Search & Filters -->
                <form action="{{ route('admin.pengguna.index') }}" method="GET" class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3" x-data="{ debounce() { this.$root.submit() } }">
                    <!-- Search Input -->
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." 
                               class="w-full pl-9 py-2 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm shadow-sm"
                               @input.debounce.500ms="debounce()">
                    </div>
                    
                    <!-- Role Filter -->
                    <select name="role_filter" class="w-full sm:w-auto py-2 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm shadow-sm" @change="debounce()">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role_filter') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="guru" {{ request('role_filter') === 'guru' ? 'selected' : '' }}>Guru</option>
                        <option value="siswa" {{ request('role_filter') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>

                    <!-- Reset Filters Button -->
                    @if(request()->has('search') || request()->has('role_filter'))
                    <a href="{{ route('admin.pengguna.index') }}" class="p-2 text-gray-400 hover:text-red-500 transition" title="Clear Filters">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </a>
                    @endif
                </form>
            </div>

            <!-- Table Data -->
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="p-4 pl-6">Pengguna</th>
                            <th class="p-4">Alamat Email</th>
                            <th class="p-4">Akses Role</th>
                            <th class="p-4">Status</th>
                            <th class="p-4">Didaftarkan</th>
                            <th class="p-4 text-center pr-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($users as $u)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <!-- Name & Avatar -->
                            <td class="p-4 pl-6">
                                <div class="flex items-center space-x-3">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background={{ $u->role === 'admin' ? 'FEE2E2&color=EF4444' : ($u->role === 'guru' ? 'DBEAFE&color=3B82F6' : 'D1FAE5&color=10B981') }}&bold=true" class="w-9 h-9 rounded-full shadow-sm" alt="Avatar">
                                    <span class="font-bold text-gray-900 group-hover:text-emerald-600 transition">{{ $u->name }}</span>
                                </div>
                            </td>
                            <!-- Email -->
                            <td class="p-4 text-sm text-gray-600">{{ $u->email }}</td>
                            <!-- Role Badge -->
                            <td class="p-4">
                                <span class="px-2.5 py-1 text-xs font-bold rounded-lg border 
                                        {{ $u->role === 'admin' ? 'bg-red-50 text-red-600 border-red-100' : 
                                        ($u->role === 'guru' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100') }}">
                                    {{ ucfirst($u->role) }}
                                </span>
                            </td>
                            <!-- Fake Status -->
                            <td class="p-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                    <svg class="mr-1.5 h-2 w-2 text-emerald-500" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                    Aktif
                                </span>
                            </td>
                            <!-- Created At -->
                            <td class="p-4 text-sm text-gray-500">{{ $u->created_at->translatedFormat('d M Y') }}</td>
                            
                            <!-- Action Dropdown Menu -->
                            <td class="p-4 pr-6 text-center">
                                <div class="relative inline-block text-left" x-data="{ openMenu: false }" @click.outside="openMenu = false">
                                    <button @click="openMenu = !openMenu" type="button" class="p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>

                                    <!-- Dropdown Dropout -->
                                    <div x-show="openMenu" x-cloak
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         class="origin-top-right absolute right-0 mt-2 w-40 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-10">
                                        
                                        <div class="py-1">
                                            <button @click="openEditModal({{ $u->toJson() }}); openMenu = false;" class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition">
                                                <svg class="mr-3 w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                Edit Akun
                                            </button>
                                        </div>
                                        
                                        @if($u->id !== auth()->id())
                                        <div class="py-1">
                                            <!-- Modal Trigger Delete using form -->
                                            <form action="{{ route('admin.pengguna.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus sistem pengguna permanen ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                                                    <svg class="mr-3 w-4 h-4 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <!-- Empty State Component -->
                @if($users->isEmpty())
                <div class="flex flex-col items-center justify-center p-12 text-center">
                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Tidak ada pengguna ditemukan.</h3>
                    <p class="text-sm text-gray-500 mt-1 max-w-sm">Coba sesuaikan kata kunci pencarian atau bersihkan filter role untuk memunculkan hasil.</p>
                </div>
                @endif
            </div>

            <!-- Tailwind Pagination Container -->
            @if($users->hasPages())
                <div class="p-6 border-t border-gray-100 bg-gray-50/30">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL EDIT USER (Alpine JS) -->
        <div x-show="modalOpen" x-cloak class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="modalOpen"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200"
                         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         @click.outside="closeModal()"
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100">
                        
                        <!-- Modal Content -->
                        <form :action="editUrl" method="POST" @submit="isUpdating = true">
                            @csrf
                            @method('PUT')
                            <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4 border-b border-gray-50">
                                <div class="flex justify-between items-start mb-5">
                                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                        <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit Pengguna
                                    </h3>
                                    <button type="button" @click="closeModal()" class="text-gray-400 hover:text-gray-600 p-1">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                                
                                <div class="space-y-5">
                                    <!-- Edit Name -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                                        <input type="text" name="name" x-model="editData.name" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                    <!-- Edit Email -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Email Pengguna</label>
                                        <input type="email" name="email" x-model="editData.email" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500" required>
                                    </div>
                                    <!-- Edit Role -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Akses Role</label>
                                        <select name="role" x-model="editData.role" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500" required>
                                            <option value="siswa">Siswa</option>
                                            <option value="guru">Guru</option>
                                            <option value="admin">Admin Siber</option>
                                        </select>
                                    </div>
                                    <!-- Edit Status (UI fake) -->
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Status Akun</label>
                                        <select disabled class="w-full bg-gray-50 border-gray-200 rounded-xl text-gray-500" title="Status cannot be changed currently">
                                            <option value="aktif">Aktif</option>
                                        </select>
                                        <p class="text-[10px] text-gray-400 mt-1">Status dikunci aktif oleh sistem pusat.</p>
                                    </div>
                                    
                                    <div class="border-t border-gray-100 pt-3">
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Reset Kata Sandi <span class="text-xs text-gray-400 font-normal grayscale">(Opsional)</span></label>
                                        <input type="password" name="password" placeholder="Biarkan kosong jika tidak ingin mengubah sandi" class="w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="px-4 py-4 sm:flex sm:flex-row-reverse sm:px-6 bg-gray-50">
                                <button type="submit" class="inline-flex w-full justify-center items-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 sm:ml-3 sm:w-auto transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <span x-show="!isUpdating">Simpan Perubahan</span>
                                    <span x-show="isUpdating" x-cloak class="flex items-center">
                                        Menyimpan <svg class="animate-spin ml-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    </span>
                                </button>
                                <button type="button" @click="closeModal()" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('userManagement', () => ({
                isSubmitting: false,
                isUpdating: false,
                modalOpen: false,
                editUrl: '',
                editData: {
                    id: '',
                    name: '',
                    email: '',
                    role: ''
                },
                openEditModal(userData) {
                    this.editData = {
                        id: userData.id,
                        name: userData.name,
                        email: userData.email,
                        role: userData.role
                    };
                    // Assume route generation dynamically replacing ID
                    let baseUrl = "{{ route('admin.pengguna.update', 'REPLACE_ID') }}";
                    this.editUrl = baseUrl.replace('REPLACE_ID', userData.id);
                    
                    this.modalOpen = true;
                    // Prevent background scrolling
                    document.body.style.overflow = 'hidden';
                },
                closeModal() {
                    this.modalOpen = false;
                    this.isUpdating = false;
                    document.body.style.overflow = '';
                }
            }));
        });
    </script>
    @endpush
    
    <!-- Alpine needs to execute external pushes if applicable. In Breeze Vite it is implicitly pushed if injected or we just write it inline outside component -->
    <script>
        // Fallback for script placement without blade stacking
        if (typeof Alpine === 'undefined') {
            document.addEventListener('alpine:init', () => {
                Alpine.data('userManagement', () => ({
                    isSubmitting: false,
                    isUpdating: false,
                    modalOpen: false,
                    editUrl: '',
                    editData: { name: '', email: '', role: '' },
                    openEditModal(userData) {
                        this.editData = { id: userData.id, name: userData.name, email: userData.email, role: userData.role };
                        let baseUrl = "{{ route('admin.pengguna.update', 'X') }}".replace('X', userData.id);
                        this.editUrl = baseUrl;
                        this.modalOpen = true;
                        document.body.style.overflow = 'hidden';
                    },
                    closeModal() {
                        this.modalOpen = false;
                        this.isUpdating = false;
                        document.body.style.overflow = '';
                    }
                }));
            });
        }
    </script>
</x-app-layout>
