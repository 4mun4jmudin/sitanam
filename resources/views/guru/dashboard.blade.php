<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Dashboard Guru') }}
                </h2>

                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <span class="text-gray-700 font-medium">Platform Akademik</span>
                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-gray-500">Pemantauan Praktik Siswa</span>
                </div>

                <p class="text-sm text-gray-500 mt-2">
                    Pantau aktivitas praktik pertanian siswa dan evaluasi hasil panen secara terpusat.
                </p>
            </div>

            <div class="hidden md:block text-right bg-white py-2 px-4 rounded-xl border border-gray-100 shadow-sm">
                <p class="text-xs text-emerald-600 font-bold uppercase tracking-widest">
                    {{ now()->translatedFormat('l') }}
                </p>
                <p class="text-base font-semibold text-gray-800">
                    {{ now()->translatedFormat('d F Y') }}
                </p>
            </div>
        </div>
    </x-slot>

    @php
        $chartBerhasil = data_get($chart_evaluasi ?? [], 'Berhasil', 0);
        $chartCukup = data_get($chart_evaluasi ?? [], 'Cukup', 0);
        $chartGagal = data_get($chart_evaluasi ?? [], 'Gagal', 0);
        $chartProses = data_get($chart_evaluasi ?? [], 'Proses', data_get($chart_evaluasi ?? [], 'Belum Dievaluasi', 0));

        $totalChart = $chartBerhasil + $chartCukup + $chartGagal + $chartProses;
    @endphp

    <div class="max-w-7xl mx-auto space-y-8 fade-in-content pb-10">

        {{-- HERO BANNER --}}
        <div
            class="bg-gradient-to-br from-emerald-700 via-emerald-600 to-green-500 rounded-3xl p-8 sm:p-10 text-white shadow-xl shadow-emerald-500/20 relative overflow-hidden flex flex-col md:flex-row items-center justify-between">
            <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none">
            </div>
            <div class="absolute bottom-0 left-10 w-64 h-64 bg-green-400/20 rounded-full blur-3xl pointer-events-none">
            </div>

            <div class="relative z-10 w-full md:w-2/3">
                <div
                    class="inline-flex items-center px-3 py-1 rounded-full bg-white/20 backdrop-blur border border-white/30 text-xs font-bold uppercase tracking-widest mb-4">
                    <span class="w-2 h-2 rounded-full bg-green-300 mr-2 animate-pulse"></span>
                    Role Akses: Guru Pembimbing
                </div>

                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight mb-3">
                    Selamat Datang, {{ $user->name }} 👋
                </h1>

                <p class="text-emerald-50 text-base sm:text-lg mb-6 max-w-xl leading-relaxed">
                    Ringkasan tugas hari ini: terdapat
                    <span class="font-bold text-white">{{ $penanaman_aktif }} proyek penanaman aktif</span>
                    yang membutuhkan pengawasan Anda, serta
                    <span class="font-bold text-white">{{ $evaluasi_selesai }} evaluasi</span>
                    telah diproses menggunakan Rule-Based Decision Tree.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('guru.penanaman.index') }}"
                        class="px-6 py-2.5 bg-white text-emerald-700 font-bold rounded-xl shadow-sm hover:bg-emerald-50 hover:shadow transition-all group flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500 group-hover:-translate-y-0.5 transition-transform"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                        Lihat Proyek Siswa
                    </a>

                    <a href="{{ route('guru.evaluasi.index') }}"
                        class="px-6 py-2.5 bg-emerald-800/40 backdrop-blur-sm border border-emerald-400/50 text-white font-bold rounded-xl shadow-sm hover:bg-emerald-800/60 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Tinjau Evaluasi
                    </a>

                    <a href="#alur-kerja-guru"
                        class="px-6 py-2.5 bg-white/10 backdrop-blur-sm border border-white/30 text-white font-bold rounded-xl shadow-sm hover:bg-white/20 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Lihat Alur Guru
                    </a>
                </div>
            </div>

            <div class="hidden md:flex relative z-10 w-1/3 justify-end items-center opacity-90 pr-4">
                <div
                    class="p-4 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 transform rotate-3 hover:rotate-0 hover:scale-105 transition-all duration-300">
                    <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- STATISTIK UTAMA --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 group hover:-translate-y-1 transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Total Siswa Bimbingan</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $total_siswa }}</h3>
                    </div>
                    <div
                        class="p-3 rounded-xl bg-blue-50 text-blue-500 group-hover:scale-110 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 group hover:-translate-y-1 transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Penanaman Aktif</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $penanaman_aktif }}</h3>
                    </div>
                    <div
                        class="p-3 rounded-xl bg-emerald-50 text-emerald-500 group-hover:scale-110 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 group hover:-translate-y-1 transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Laporan Panen Bulan Ini</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $panen_bulan_ini }}</h3>
                    </div>
                    <div
                        class="p-3 rounded-xl bg-orange-50 text-orange-500 group-hover:scale-110 group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 group hover:-translate-y-1 transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Evaluasi Selesai</p>
                        <h3 class="text-3xl font-black text-gray-800 tracking-tight">{{ $evaluasi_selesai }}</h3>
                    </div>
                    <div
                        class="p-3 rounded-xl bg-purple-50 text-purple-600 group-hover:scale-110 group-hover:bg-purple-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- ALUR KERJA GURU --}}
        <div id="alur-kerja-guru" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-emerald-500 mr-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        Alur Kerja Guru
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Tahapan penggunaan sistem dari pemantauan proyek sampai evaluasi keberhasilan panen.
                    </p>
                </div>

                <a href="{{ route('guru.evaluasi.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-emerald-600 text-white text-sm font-bold hover:bg-emerald-700 transition">
                    Mulai Evaluasi
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div class="rounded-2xl border border-emerald-100 bg-emerald-50 p-4">
                    <div
                        class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black mb-3">
                        1</div>
                    <h4 class="font-bold text-gray-900">Penanaman</h4>
                    <p class="text-xs text-gray-600 mt-1 leading-5">Guru melihat data awal proyek siswa.</p>
                </div>

                <div class="rounded-2xl border border-blue-100 bg-blue-50 p-4">
                    <div
                        class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center font-black mb-3">
                        2</div>
                    <h4 class="font-bold text-gray-900">Pemeliharaan</h4>
                    <p class="text-xs text-gray-600 mt-1 leading-5">Guru memantau perkembangan dan kondisi tanaman.</p>
                </div>

                <div class="rounded-2xl border border-orange-100 bg-orange-50 p-4">
                    <div
                        class="w-9 h-9 rounded-xl bg-orange-500 text-white flex items-center justify-center font-black mb-3">
                        3</div>
                    <h4 class="font-bold text-gray-900">Panen</h4>
                    <p class="text-xs text-gray-600 mt-1 leading-5">Guru melihat hasil akhir panen siswa.</p>
                </div>

                <div class="rounded-2xl border border-purple-100 bg-purple-50 p-4">
                    <div
                        class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center font-black mb-3">
                        4</div>
                    <h4 class="font-bold text-gray-900">Decision Tree</h4>
                    <p class="text-xs text-gray-600 mt-1 leading-5">Guru memproses evaluasi berbasis aturan.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                    <div
                        class="w-9 h-9 rounded-xl bg-slate-800 text-white flex items-center justify-center font-black mb-3">
                        5</div>
                    <h4 class="font-bold text-gray-900">Hasil</h4>
                    <p class="text-xs text-gray-600 mt-1 leading-5">Sistem menampilkan klasifikasi dan rekomendasi.</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- AKSI CEPAT --}}
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 text-indigo-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Aksi Cepat Menu
                    </h3>

                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                        <a href="{{ route('guru.penanaman.index') }}"
                            class="flex flex-col items-center justify-center p-5 rounded-2xl border border-gray-100 hover:border-emerald-300 hover:bg-emerald-50 hover:shadow-md transition-all group">
                            <div
                                class="w-12 h-12 bg-gray-50 text-gray-400 group-hover:bg-emerald-100 group-hover:text-emerald-600 rounded-full flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center">Rekap Penanaman</span>
                        </a>

                        <a href="{{ route('guru.pemeliharaan.index') }}"
                            class="flex flex-col items-center justify-center p-5 rounded-2xl border border-gray-100 hover:border-blue-300 hover:bg-blue-50 hover:shadow-md transition-all group">
                            <div
                                class="w-12 h-12 bg-gray-50 text-gray-400 group-hover:bg-blue-100 group-hover:text-blue-600 rounded-full flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center">Pemeliharaan</span>
                        </a>

                        <a href="{{ route('guru.panen.index') }}"
                            class="flex flex-col items-center justify-center p-5 rounded-2xl border border-gray-100 hover:border-orange-300 hover:bg-orange-50 hover:shadow-md transition-all group">
                            <div
                                class="w-12 h-12 bg-gray-50 text-gray-400 group-hover:bg-orange-100 group-hover:text-orange-600 rounded-full flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center">Catat Panen</span>
                        </a>

                        <a href="{{ route('guru.evaluasi.index') }}"
                            class="flex flex-col items-center justify-center p-5 rounded-2xl border border-gray-100 hover:border-purple-300 hover:bg-purple-50 hover:shadow-md transition-all group">
                            <div
                                class="w-12 h-12 bg-gray-50 text-gray-400 group-hover:bg-purple-100 group-hover:text-purple-600 rounded-full flex items-center justify-center mb-3 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                    </path>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-gray-700 text-center">Evaluasi Panen</span>
                        </a>
                    </div>
                </div>

                {{-- MONITOR PROYEK --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-900 flex items-center">
                            <svg class="w-5 h-5 text-gray-500 mr-2" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                            Monitor Proyek Siswa Terkini
                        </h3>

                        <a href="{{ route('guru.penanaman.index') }}"
                            class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                            Lihat Semua
                        </a>
                    </div>

                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr
                                    class="bg-white border-b border-gray-100 text-gray-400 text-[11px] uppercase tracking-wider font-bold">
                                    <th class="p-4 pl-6">Nama Siswa</th>
                                    <th class="p-4">Jenis Tanaman</th>
                                    <th class="p-4">Ditanam Sejak</th>
                                    <th class="p-4 text-center">Progress Laporan</th>
                                    <th class="p-4 text-right pr-6">Status Lahan</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-50">
                                @forelse($recent_penanaman as $rp)
                                    @php
                                        $prog = $rp->pemeliharaans ? $rp->pemeliharaans->count() : 0;
                                        $prog_percent = min($prog * 20, 100);
                                    @endphp

                                    <tr class="hover:bg-gray-50 transition-colors group">
                                        <td class="p-4 pl-6">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs ring-2 ring-white">
                                                    {{ substr(data_get($rp->siswa, 'name', 'U'), 0, 1) }}
                                                </div>
                                                <span class="font-bold text-gray-800">
                                                    {{ data_get($rp->siswa, 'name', 'Siswa Tidak Ditemukan') }}
                                                </span>
                                            </div>
                                        </td>

                                        <td class="p-4">
                                            <span class="font-semibold text-gray-700 bg-gray-100 px-2 py-1 rounded-md">
                                                {{ $rp->jenis_tanaman }}
                                            </span>
                                        </td>

                                        <td class="p-4 text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($rp->tgl_tanam)->format('d/m/Y') }}
                                        </td>

                                        <td class="p-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <div class="w-20 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-emerald-500 h-2 rounded-full"
                                                        style="width: {{ $prog_percent }}%"></div>
                                                </div>
                                                <span class="text-xs font-semibold text-gray-600">{{ $prog }}x</span>
                                            </div>
                                        </td>

                                        <td class="p-4 pr-6 text-right">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold {{ $rp->panen ? 'bg-orange-50 text-orange-600' : 'bg-emerald-50 text-emerald-600' }}">
                                                @if($rp->panen)
                                                    Terpanen ✓
                                                @else
                                                    Masa Tanam 🌱
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="p-8 text-center text-sm text-gray-500">
                                            Belum ada rekaman penanaman siswa yang didaftarkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="space-y-8">

                {{-- CHART EVALUASI --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-auto">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">
                                Rekap Evaluasi Panen
                            </h3>
                            <p class="text-xs text-gray-500 mt-1">
                                Hasil klasifikasi Rule-Based Decision Tree.
                            </p>
                        </div>
                    </div>

                    @if($totalChart > 0)
                        <div class="relative w-full h-56 flex-1">
                            <canvas id="evaluasiChart"></canvas>
                        </div>
                    @else
                        <div
                            class="h-56 flex items-center justify-center rounded-2xl bg-gray-50 border border-dashed border-gray-200">
                            <div class="text-center">
                                <p class="text-sm font-bold text-gray-700">Belum ada data evaluasi</p>
                                <p class="text-xs text-gray-500 mt-1">Data akan muncul setelah evaluasi panen diproses.</p>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4 pt-4 border-t border-gray-100 grid grid-cols-2 gap-4">
                        <div class="text-center p-3 rounded-xl bg-emerald-50 border border-emerald-100">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Berhasil</p>
                            <span class="text-xl font-bold text-emerald-600">{{ $chartBerhasil }}</span>
                        </div>

                        <div class="text-center p-3 rounded-xl bg-yellow-50 border border-yellow-100">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Cukup</p>
                            <span class="text-xl font-bold text-yellow-600">{{ $chartCukup }}</span>
                        </div>

                        <div class="text-center p-3 rounded-xl bg-red-50 border border-red-100">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Gagal</p>
                            <span class="text-xl font-bold text-red-600">{{ $chartGagal }}</span>
                        </div>

                        <div class="text-center p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <p class="text-xs font-semibold text-gray-500 mb-1">Belum Evaluasi</p>
                            <span class="text-xl font-bold text-slate-600">{{ $chartProses }}</span>
                        </div>
                    </div>
                </div>

                {{-- STATUS PANEL --}}
                <div
                    class="bg-slate-900 border border-slate-800 rounded-2xl p-6 text-white relative overflow-hidden shadow-lg group">
                    <div
                        class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 bg-emerald-500 rounded-full blur-3xl opacity-20 group-hover:opacity-30 transition-opacity">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 bg-blue-500 rounded-full blur-2xl opacity-20">
                    </div>

                    <div class="relative z-10 space-y-6">
                        <div class="flex justify-between items-start border-b border-slate-800 pb-4">
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">
                                    Waktu Pembelajaran
                                </p>
                                <div
                                    class="text-3xl font-mono font-bold text-emerald-400 tracking-wider flex items-center">
                                    <span id="realtime-hour-guru">--:--</span>
                                    <span class="text-sm ml-1 text-slate-500" id="realtime-second-guru">:--</span>
                                </div>
                            </div>

                            <div class="p-2 bg-slate-800 rounded-lg text-emerald-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-2">
                                Status Akun Guru
                            </p>

                            <div class="flex items-center bg-slate-800/50 p-3 rounded-xl border border-slate-700/50">
                                <div
                                    class="w-10 h-10 rounded-full bg-emerald-900/50 flex items-center justify-center mr-3">
                                    <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>

                                <div class="flex-1">
                                    <p class="text-sm font-semibold text-slate-200">Aktif Terhubung</p>
                                    <p class="text-xs text-slate-400">Sinkronisasi database berjalan</p>
                                </div>

                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- CHARTJS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let guruDashboardInterval = null;
        let guruEvaluasiChart = null;

        function initGuruDashboard() {
            if (guruDashboardInterval) clearInterval(guruDashboardInterval);
            if (guruEvaluasiChart) guruEvaluasiChart.destroy();

            guruDashboardInterval = setInterval(() => {
                const now = new Date();
                const hhmm = now.toLocaleTimeString('id-ID', {
                    hour12: false,
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const ss = now.toLocaleTimeString('id-ID', {
                    hour12: false,
                    second: '2-digit'
                });

                const elHour = document.getElementById('realtime-hour-guru');
                const elSec = document.getElementById('realtime-second-guru');

                if (elHour && elSec) {
                    elHour.textContent = hhmm;
                    elSec.textContent = `:${ss}`;
                }
            }, 1000);

            const ctx = document.getElementById('evaluasiChart');

            if (ctx) {
                guruEvaluasiChart = new Chart(ctx.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Berhasil', 'Cukup', 'Gagal', 'Belum Evaluasi'],
                        datasets: [{
                            label: 'Total Klasifikasi',
                            data: [
                                {{ $chartBerhasil }},
                                {{ $chartCukup }},
                                {{ $chartGagal }},
                                {{ $chartProses }}
                            ],
                            backgroundColor: [
                                'rgba(16, 185, 129, 0.9)',
                                'rgba(234, 179, 8, 0.9)',
                                'rgba(239, 68, 68, 0.9)',
                                'rgba(100, 116, 139, 0.75)'
                            ],
                            borderColor: [
                                '#ffffff',
                                '#ffffff',
                                '#ffffff',
                                '#ffffff'
                            ],
                            borderWidth: 3,
                            borderRadius: 4,
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '70%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 10,
                                    padding: 15,
                                    usePointStyle: true,
                                    font: {
                                        family: "'Inter', sans-serif",
                                        size: 11,
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
            }
        }

        document.addEventListener("turbo:load", initGuruDashboard);
        document.addEventListener("DOMContentLoaded", initGuruDashboard);
    </script>
</x-app-layout>