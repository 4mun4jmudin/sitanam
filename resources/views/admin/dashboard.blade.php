<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('Dashboard Admin') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Sistem Pendataan & Evaluasi Panen Pertanian</p>
            </div>
            <div class="text-right hidden sm:block">
                <p class="text-sm font-medium text-gray-600" id="current-date">{{ now()->translatedFormat('l, d F Y') }}</p>
                <p class="text-xs text-gray-400">Jam Server: <span class="font-mono text-emerald-600" id="current-time">{{ now()->format('H:i:s') }}</span></p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-[#F8FAFC] min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <!-- Welcome Header -->
            <div class="bg-gradient-to-r from-emerald-600 to-green-500 rounded-3xl p-8 text-white shadow-lg shadow-emerald-600/20 flex flex-col md:flex-row justify-between items-center transform transition-all duration-300 hover:scale-[1.01]">
                <div>
                    <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Selamat Datang, {{ $user->name }} 👋</h1>
                    <p class="text-emerald-100 text-sm md:text-base font-medium">Anda memiliki akses penuh untuk mengelola pengguna dan memantau keseluruhan aktivitas pelaporan panen di SMK IT Al-Hawari.</p>
                </div>
                <div class="mt-6 md:mt-0 p-4 bg-white/10 rounded-2xl backdrop-blur-sm border border-white/20">
                    <div class="flex items-center space-x-3">
                        <div class="p-3 bg-white rounded-full text-emerald-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-emerald-100 uppercase tracking-widest font-semibold">Tipe Akses</p>
                            <p class="text-lg font-bold capitalize">{{ $user->role }} Sistem</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Guru</p>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $total_guru }}</h3>
                        </div>
                        <div class="p-3 rounded-xl bg-blue-50 text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Siswa</p>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $total_siswa }}</h3>
                        </div>
                        <div class="p-3 rounded-xl bg-emerald-50 text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 14l9-5-9-5-9 5 9 5z"></path><path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"></path></svg>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Pengguna</p>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $total_user }}</h3>
                        </div>
                        <div class="p-3 rounded-xl bg-purple-50 text-purple-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 hover:-translate-y-1 transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Aktivitas Data</p>
                            <h3 class="text-3xl font-bold text-gray-800">{{ $total_aktivitas }}</h3>
                        </div>
                        <div class="p-3 rounded-xl bg-orange-50 text-orange-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Features Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left: Chart & Quick Actions -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Quick Actions -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="{{ route('admin.pengguna.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-emerald-300 hover:bg-emerald-50 transition group">
                                <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-2 group-hover:bg-emerald-600 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">Tambah User</span>
                            </a>
                            <a href="{{ route('admin.pengguna.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-blue-300 hover:bg-blue-50 transition group">
                                <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mb-2 group-hover:bg-blue-600 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">Kelola Akses</span>
                            </a>
                            <a href="{{ route('guru.evaluasi.index') }}" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-orange-300 hover:bg-orange-50 transition group">
                                <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center mb-2 group-hover:bg-orange-600 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">Lihat Laporan</span>
                            </a>
                            <a href="#" class="flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 hover:border-purple-300 hover:bg-purple-50 transition group">
                                <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mb-2 group-hover:bg-purple-600 group-hover:text-white transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </div>
                                <span class="text-sm font-semibold text-gray-700">Pengaturan</span>
                            </a>
                        </div>
                    </div>

                    <!-- Chart JS Container -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold text-gray-800">Distribusi Role Pengguna</h3>
                        </div>
                        <div class="relative h-64 w-full">
                            <canvas id="roleChart"></canvas>
                        </div>
                    </div>
                    
                    <!-- Recent Activities (Proyek Penanaman Terakhir) -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="text-lg font-bold text-gray-800">Proyek Penanaman Terbaru</h3>
                            <span class="text-xs font-semibold bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full">Live Data</span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-white border-b border-gray-100">
                                        <th class="p-4 font-semibold text-gray-500 text-xs uppercase tracking-wider">Siswa</th>
                                        <th class="p-4 font-semibold text-gray-500 text-xs uppercase tracking-wider">Tanaman</th>
                                        <th class="p-4 font-semibold text-gray-500 text-xs uppercase tracking-wider">Tanggal</th>
                                        <th class="p-4 font-semibold text-gray-500 text-xs uppercase tracking-wider text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($recent_penanaman as $p)
                                    <tr class="hover:bg-gray-50 transition-colors group">
                                        <td class="p-4">
                                            <div class="flex items-center">
                                                <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center font-bold text-xs mr-3">
                                                    {{ substr(data_get($p->siswa, 'name', 'U'), 0, 1) }}
                                                </div>
                                                <span class="font-medium text-gray-800">{{ data_get($p->siswa, 'name', 'Tidak Diketahui') }}</span>
                                            </div>
                                        </td>
                                        <td class="p-4 text-gray-600 font-medium">{{ $p->jenis_tanaman }}</td>
                                        <td class="p-4 text-sm text-gray-500">{{ \Carbon\Carbon::parse($p->tgl_tanam)->format('d/m/Y') }}</td>
                                        <td class="p-4 text-right">
                                            <span class="px-2 py-1 text-xs font-medium rounded-md bg-blue-50 text-blue-600 border border-blue-100">Aktif</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @if(count($recent_penanaman) === 0)
                                    <tr><td colspan="4" class="p-4 text-center text-sm text-gray-500">Belum ada aktivitas penanaman.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Information Panel & Recent Users -->
                <div class="space-y-8">
                    
                    <!-- System Status Card -->
                    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 text-white relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-emerald-500 rounded-full blur-3xl opacity-20"></div>
                        <h3 class="text-sm font-medium text-gray-400 mb-4 uppercase tracking-widest">Informasi Server</h3>
                        
                        <div class="space-y-4 relative z-10">
                            <div class="flex justify-between items-end border-b border-gray-800 pb-3">
                                <div>
                                    <p class="text-xs text-gray-400 mb-1">Status Database</p>
                                    <div class="flex items-center">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-2 animate-pulse"></span>
                                        <span class="font-semibold text-sm">Connected (MySQL)</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-end border-b border-gray-800 pb-3">
                                <div>
                                    <p class="text-xs text-gray-400 mb-1">Versi Algoritma</p>
                                    <p class="font-medium text-sm text-gray-200 cursor-pointer hover:text-emerald-400 transition" title="Rule-based Decision Tree (Skripsi Mode)">Decision Tree v1.0</p>
                                </div>
                            </div>

                            <div class="pt-2">
                                <p class="text-xs text-gray-400 mb-1 text-center font-semibold">WAKTU SISTEM SAAT INI</p>
                                <div class="text-3xl font-mono text-center font-bold text-emerald-400 tracking-wider clock-display">
                                    {{ now()->format('H:i:s') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Registration Target/Growth -->
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            Pendaftar Terbaru
                        </h3>
                        <div class="space-y-4">
                            @foreach($recent_users as $ru)
                            <div class="flex items-center justify-between p-3 rounded-xl hover:bg-gray-50 transition border border-transparent hover:border-gray-100">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center font-bold text-gray-600 text-sm">
                                        {{ substr($ru->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">{{ $ru->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $ru->email }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold capitalize px-2.5 py-1 rounded-md border 
                                    {{ $ru->role === 'admin' ? 'bg-red-50 text-red-600 border-red-100' : ($ru->role === 'guru' ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-emerald-50 text-emerald-600 border-emerald-100') }}">
                                    {{ $ru->role }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                            <a href="{{ route('admin.pengguna.index') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition">Lihat Seluruh Pengguna &rarr;</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- ChartJS Instance -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Clock Logic
            setInterval(() => {
                const now = new Date();
                const timeString = now.toLocaleTimeString('en-US', { hour12: false });
                document.querySelectorAll('.clock-display, #current-time').forEach(el => {
                    el.textContent = timeString;
                });
            }, 1000);

            // Chart Configuration
            const ctx = document.getElementById('roleChart').getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Guru', 'Siswa', 'Admin'],
                    datasets: [{
                        label: 'Total Pengguna',
                        data: [{{ $chart_roles['Guru'] }}, {{ $chart_roles['Siswa'] }}, {{ $chart_roles['Admin'] }}],
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.8)', // blue-500
                            'rgba(16, 185, 129, 0.8)', // emerald-500
                            'rgba(239, 68, 68, 0.8)'   // red-500
                        ],
                        borderColor: [
                            'rgba(255, 255, 255, 1)'
                        ],
                        borderWidth: 4,
                        borderRadius: 5,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                font: {
                                    family: "'Inter', 'Figtree', sans-serif",
                                    weight: '600'
                                }
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        });
    </script>
</x-app-layout>
