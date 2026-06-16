<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Pemeliharaan Tanaman') }}
                </h2>

                <div class="flex flex-wrap items-center text-sm text-gray-500 mt-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition">
                        Dashboard Guru
                    </a>

                    <svg class="w-4 h-4 mx-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>

                    @if(request()->has('search') || request()->has('status_filter') || request()->has('penanaman_id'))
                        <a href="{{ route('guru.pemeliharaan.index') }}"
                            class="mr-2 text-red-500 hover:text-red-700 transition" title="Bersihkan Filter">
                            <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </a>
                    @endif

                    <span class="text-gray-700 font-medium">Pemeliharaan</span>
                </div>

                <p class="text-sm text-gray-500 mt-2 max-w-3xl">
                    Pantau riwayat pemeliharaan tanaman siswa sebagai data pendukung evaluasi keberhasilan panen
                    menggunakan Rule-Based Decision Tree.
                </p>
            </div>

            <div class="hidden md:block rounded-2xl border border-blue-100 bg-blue-50 px-4 py-3 text-right">
                <p class="text-xs font-black uppercase tracking-widest text-blue-600">
                    Tahap Alur
                </p>
                <p class="text-sm font-bold text-gray-800">
                    Penanaman → Pemeliharaan → Panen → Evaluasi
                </p>
            </div>
        </div>
    </x-slot>

    @php
        $cntSehat = $cntSehat ?? data_get($stats ?? [], 'sehat', 0);
        $cntPerluPantauan = $cntPerluPantauan ?? data_get($stats ?? [], 'perlu_pantauan', 0);
        $cntRisikoTinggi = $cntRisikoTinggi ?? data_get($stats ?? [], 'risiko_tinggi', 0);
        $totalTrend = (int) $cntSehat + (int) $cntPerluPantauan + (int) $cntRisikoTinggi;
    @endphp

    <div x-data="pemeliharaanGuruComponent()" @keydown.escape.window="modalOpen = false"
        class="max-w-7xl mx-auto space-y-8 pb-10">

        {{-- ALERT SUCCESS --}}
        @if(session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-start shadow-sm">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>

                <div class="flex-1">
                    <h3 class="text-sm font-bold">Berhasil!</h3>
                    <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- ALERT ERROR --}}
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl flex items-start shadow-sm">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>

                <div class="flex-1">
                    <h3 class="text-sm font-bold">Terjadi Kesalahan!</h3>
                    <ul class="list-disc ml-5 mt-1 text-sm text-red-700">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        {{-- STATISTIK --}}
        <div id="stats-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 group hover:-translate-y-1 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-gray-500 mb-1">Total Monitoring</p>
                        <h3 class="text-3xl font-black text-gray-900">{{ data_get($stats, 'total', 0) }}</h3>
                        <p class="text-xs text-gray-400 mt-2">Jumlah catatan pemeliharaan.</p>
                    </div>

                    <div
                        class="p-3 rounded-xl bg-blue-50 text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100 group hover:-translate-y-1 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-emerald-600 mb-1">Tanaman Sehat</p>
                        <h3 class="text-3xl font-black text-gray-900">{{ data_get($stats, 'sehat', 0) }}</h3>
                        <p class="text-xs text-gray-400 mt-2">Kondisi laporan sehat.</p>
                    </div>

                    <div
                        class="p-3 rounded-xl bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-red-100 group hover:-translate-y-1 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-red-600 mb-1">Tanaman Bermasalah</p>
                        <h3 class="text-3xl font-black text-red-600">{{ data_get($stats, 'bermasalah', 0) }}</h3>
                        <p class="text-xs text-gray-400 mt-2">Perlu pantauan atau risiko tinggi.</p>
                    </div>

                    <div
                        class="p-3 rounded-xl bg-red-50 text-red-500 group-hover:bg-red-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            <div
                class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100 group hover:-translate-y-1 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-semibold text-orange-600 mb-1">Mendekati Panen</p>
                        <h3 class="text-3xl font-black text-orange-500">{{ data_get($stats, 'panen', 0) }}</h3>
                        <p class="text-xs text-gray-400 mt-2">Perlu ditinjau menuju panen.</p>
                    </div>

                    <div
                        class="p-3 rounded-xl bg-orange-50 text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- PERAN DATA PEMELIHARAAN --}}
        <div
            class="bg-gradient-to-r from-blue-700 via-blue-600 to-emerald-600 rounded-3xl p-6 sm:p-7 text-white shadow-lg shadow-blue-500/20 relative overflow-hidden">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute -left-16 -bottom-16 h-48 w-48 rounded-full bg-emerald-300/20 blur-3xl"></div>

            <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-blue-100 mb-2">
                        Peran Data Pemeliharaan
                    </p>

                    <h3 class="text-xl sm:text-2xl font-black">
                        Data utama untuk membaca kondisi tanaman sebelum panen
                    </h3>

                    <p class="text-sm text-blue-50 mt-2 max-w-3xl leading-6">
                        Riwayat pemeliharaan digunakan sistem untuk membaca kondisi laporan, pertumbuhan tanaman, jumlah
                        tanaman hidup, dan jumlah tanaman mati.
                        Data ini menjadi faktor pendukung dalam proses evaluasi keberhasilan panen menggunakan
                        Rule-Based Decision Tree.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('guru.evaluasi.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-white text-blue-700 text-sm font-bold hover:bg-blue-50 transition whitespace-nowrap">
                        Lihat Evaluasi Panen
                    </a>

                    <a href="{{ route('guru.panen.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-blue-900/30 border border-white/30 text-white text-sm font-bold hover:bg-blue-900/50 transition whitespace-nowrap">
                        Lihat Data Panen
                    </a>
                </div>
            </div>

            <div class="relative z-10 mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="rounded-2xl bg-white/10 border border-white/20 p-4 backdrop-blur">
                    <p class="text-xs font-black uppercase tracking-widest text-blue-100">Faktor 1</p>
                    <p class="mt-1 font-bold">Jumlah Hidup / Mati</p>
                </div>

                <div class="rounded-2xl bg-white/10 border border-white/20 p-4 backdrop-blur">
                    <p class="text-xs font-black uppercase tracking-widest text-blue-100">Faktor 2</p>
                    <p class="mt-1 font-bold">Kondisi Laporan</p>
                </div>

                <div class="rounded-2xl bg-white/10 border border-white/20 p-4 backdrop-blur">
                    <p class="text-xs font-black uppercase tracking-widest text-blue-100">Faktor 3</p>
                    <p class="mt-1 font-bold">Risiko Evaluasi</p>
                </div>
            </div>
        </div>

        {{-- CHART --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">
            <div class="flex flex-col gap-2 text-center mb-5">
                <h3 class="text-base font-black text-gray-900 uppercase tracking-wide">
                    Tren Kesehatan Tanaman
                </h3>
                <p class="text-xs text-gray-500">
                    Grafik ini menampilkan rekap kondisi laporan pemeliharaan sebagai bahan pantauan guru sebelum
                    evaluasi panen.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_320px] gap-6 items-center">
                <div
                    class="relative w-full h-56 md:h-64 flex justify-center items-center rounded-2xl bg-gray-50 border border-gray-100">
                    @if($totalTrend > 0)
                        <canvas id="healthTrendChart"></canvas>
                    @else
                        <div class="text-center px-5">
                            <p class="text-sm font-bold text-gray-700">Belum ada data tren</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Grafik akan muncul setelah siswa mencatat pemeliharaan.
                            </p>
                        </div>
                    @endif
                </div>

                <div id="chart-stats-container" class="w-full bg-gray-50 rounded-2xl p-4 text-xs text-gray-600 space-y-3 border border-gray-100">
                    <div class="flex justify-between items-center rounded-xl bg-white p-3 border border-gray-100">
                        <span class="flex items-center font-semibold">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 mr-2"></span>
                            Aman
                        </span>
                        <span class="font-black text-gray-900">{{ $cntSehat }} Data</span>
                    </div>

                    <div class="flex justify-between items-center rounded-xl bg-white p-3 border border-gray-100">
                        <span class="flex items-center font-semibold">
                            <span class="w-2.5 h-2.5 rounded-full bg-purple-500 mr-2"></span>
                            Perlu Pantauan
                        </span>
                        <span class="font-black text-gray-900">{{ $cntPerluPantauan }} Data</span>
                    </div>

                    <div class="flex justify-between items-center rounded-xl bg-white p-3 border border-gray-100">
                        <span class="flex items-center font-semibold">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-500 mr-2"></span>
                            Risiko Tinggi
                        </span>
                        <span class="font-black text-gray-900">{{ $cntRisikoTinggi }} Data</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABEL --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div
                class="p-6 border-b border-gray-100 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-gray-50/60">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Riwayat Monitoring Pemeliharaan
                    </h3>
                    <p class="text-xs text-gray-500 mt-1">
                        Data monitoring mingguan sebagai dasar pembacaan risiko sebelum panen.
                    </p>
                </div>

                <form id="filter-form" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                    @if(request('penanaman_id'))
                        <input type="hidden" name="penanaman_id" value="{{ request('penanaman_id') }}">
                    @endif

                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </span>

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama atau tanaman"
                            class="w-full pl-9 py-2 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm shadow-sm"
                            @input.debounce.500ms="debounceFilter()">
                    </div>

                    <select name="status_filter"
                        class="w-full sm:w-auto py-2 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm shadow-sm"
                        @change="debounceFilter()">
                        <option value="">Semua Kondisi Laporan</option>
                        <option value="Aman" {{ request('status_filter') === 'Aman' ? 'selected' : '' }}>Aman</option>
                        <option value="Perlu Pantauan" {{ request('status_filter') === 'Perlu Pantauan' ? 'selected' : '' }}>Perlu Pantauan</option>
                        <option value="Risiko Tinggi" {{ request('status_filter') === 'Risiko Tinggi' ? 'selected' : '' }}>Risiko Tinggi</option>
                    </select>

                    <select name="per_page"
                        class="w-full sm:w-auto py-2 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm shadow-sm"
                        @change="debounceFilter()">
                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 Data</option>
                        <option value="25" {{ request('per_page') == '25' ? 'selected' : '' }}>25 Data</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 Data</option>
                        <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>Semua Data</option>
                    </select>

                    <div id="clear-filter-wrapper">
                    @if(request()->has('search') || request()->has('status_filter') || request()->has('penanaman_id'))
                        <a href="{{ route('guru.pemeliharaan.index') }}"
                            class="inline-flex items-center justify-center rounded-xl border border-red-100 bg-red-50 px-3 py-2 text-sm font-bold text-red-600 hover:bg-red-100 transition">
                            Reset
                        </a>
                    @endif
                    </div>
                </form>
            </div>

            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr
                            class="bg-slate-50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider font-black">
                            <th class="p-4 pl-6 text-center w-12">No</th>
                            <th class="p-4">Identitas Siswa & Tanaman</th>
                            <th class="p-4">Tanggal Monitoring</th>
                            <th class="p-4 text-center">Tinggi</th>
                            <th class="p-4 text-center">Hidup / Mati</th>
                            <th class="p-4 text-left">Kondisi Laporan</th>
                            <th class="p-4 text-left">Risiko Evaluasi</th>
                            <th class="p-4 text-center pr-6">Aksi</th>
                        </tr>
                    </thead>

                    <tbody id="table-body" class="divide-y divide-gray-50">
                        @forelse($pemeliharaans as $idx => $item)
                            @php
                                $condition = $item->info_hama ?? 'Belum Diisi';

                                if ($condition === 'Sehat') {
                                    $conditionClass = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                    $riskLabel = 'Aman';
                                    $riskClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                } elseif ($condition === 'Terserang Hama') {
                                    $conditionClass = 'bg-purple-100 text-purple-700 border-purple-200';
                                    $riskLabel = 'Perlu Pantauan';
                                    $riskClass = 'bg-purple-50 text-purple-700 border-purple-200';
                                } elseif ($condition === 'Layu') {
                                    $conditionClass = 'bg-red-100 text-red-700 border-red-200';
                                    $riskLabel = 'Risiko Tinggi';
                                    $riskClass = 'bg-red-50 text-red-700 border-red-200';
                                } else {
                                    $conditionClass = 'bg-gray-100 text-gray-700 border-gray-200';
                                    $riskLabel = 'Belum Jelas';
                                    $riskClass = 'bg-gray-50 text-gray-700 border-gray-200';
                                }
                            @endphp

                            <tr class="hover:bg-blue-50/40 transition-colors group">
                                <td class="p-4 pl-6 text-center text-gray-400 font-medium text-sm">
                                    {{ $pemeliharaans->firstItem() + $idx }}
                                </td>

                                <td class="p-4">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-black text-sm ring-2 ring-white uppercase">
                                            {{ substr(data_get($item->penanaman->siswa ?? [], 'name', 'U'), 0, 1) }}
                                        </div>

                                        <div>
                                            <p class="font-bold text-gray-900 leading-tight">
                                                {{ data_get($item->penanaman->siswa ?? [], 'name', 'Siswa Tidak Ditemukan') }}
                                            </p>
                                            <p class="text-xs text-gray-500 font-medium mt-0.5">
                                                {{ data_get($item->penanaman ?? [], 'jenis_tanaman', '?') }}
                                                @if(!empty($item->minggu_ke))
                                                    <span class="mx-1 text-gray-300">•</span>
                                                    Minggu ke-{{ $item->minggu_ke }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 text-sm text-gray-600 font-medium">
                                    {{ \Carbon\Carbon::parse($item->tanggal_catat)->translatedFormat('d M Y') }}
                                </td>

                                <td class="p-4 text-center">
                                    <span
                                        class="bg-gray-100 px-2.5 py-1 rounded-lg text-sm font-bold text-gray-700 border border-gray-200">
                                        {{ $item->tinggi_tanaman ?? '-' }} cm
                                    </span>
                                </td>

                                <td class="p-4 text-center">
                                    <div
                                        class="inline-flex items-center gap-2 rounded-xl bg-gray-50 px-3 py-1.5 border border-gray-100">
                                        <span class="text-xs font-black text-emerald-600">
                                            H: {{ $item->jml_hidup ?? '-' }}
                                        </span>
                                        <span class="text-gray-300">/</span>
                                        <span class="text-xs font-black text-red-600">
                                            M: {{ $item->jml_mati ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="p-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-black border uppercase tracking-widest {{ $conditionClass }}">
                                        {{ $condition }}
                                    </span>
                                </td>

                                <td class="p-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-lg border text-xs font-black {{ $riskClass }}">
                                        {{ $riskLabel }}
                                    </span>
                                </td>

                                <td class="p-4 pr-6 text-center">
                                    <button type="button" @click="openDetailModal({{ $item->id }})"
                                        class="inline-flex items-center justify-center p-2 rounded-xl bg-gray-100 text-gray-500 hover:text-blue-600 hover:bg-blue-50 transition"
                                        title="Lihat detail pemeliharaan">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                                </path>
                                            </svg>
                                        </div>

                                        <h3 class="text-sm font-bold text-gray-800">
                                            Belum Ada Rekaman Pemeliharaan
                                        </h3>

                                        <p class="text-sm text-gray-500 mt-1 max-w-md">
                                            Data pemeliharaan akan muncul setelah siswa mencatat perkembangan tanaman,
                                            seperti tinggi tanaman, jumlah hidup, jumlah mati, dan kondisi laporan.
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pemeliharaans->hasPages())
                <div id="pagination-wrapper" class="p-6 border-t border-gray-100 bg-gray-50/50" @click.prevent="handlePagination($event)">
                    {{ $pemeliharaans->links() }}
                </div>
            @else
                <div id="pagination-wrapper"></div>
            @endif
        </div>

        {{-- MODAL DETAIL --}}
        <template x-teleport="body">
            <div x-show="modalOpen" x-cloak class="relative z-[100]">
                <div x-show="modalOpen" x-transition.opacity
                    class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="modalOpen" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        @click.outside="modalOpen = false"
                        class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-100">

                        <div class="bg-white">
                            <div
                                class="bg-gradient-to-r from-blue-700 to-emerald-600 px-6 py-5 flex justify-between items-center text-white">
                                <div>
                                    <h3 class="text-lg font-black flex items-center">
                                        <svg class="w-5 h-5 mr-2 opacity-90" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                        Detail Pemeliharaan Tanaman
                                    </h3>
                                    <p class="text-xs text-blue-100 mt-1">
                                        Log monitoring yang menjadi data pendukung evaluasi.
                                    </p>
                                </div>

                                <button type="button" @click="modalOpen = false"
                                    class="text-white/70 hover:text-white transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <div class="px-6 py-6 border-b border-gray-100 text-sm">
                                <div
                                    class="bg-blue-50 p-4 rounded-2xl mb-6 flex flex-col md:flex-row md:justify-between md:items-center border border-blue-100 gap-4">
                                    <div>
                                        <p
                                            class="text-xs text-blue-600 font-black uppercase tracking-widest leading-none mb-1">
                                            Identitas Siswa
                                        </p>
                                        <p class="font-black text-gray-900 text-base"
                                            x-text="detailData.penanaman?.siswa?.name || 'Siswa Tidak Ditemukan'"></p>
                                        <p class="text-xs text-gray-500 font-medium mt-0.5"
                                            x-text="'Tanaman: ' + (detailData.penanaman?.jenis_tanaman || '?')"></p>
                                    </div>

                                    <div class="md:text-right">
                                        <p
                                            class="text-xs text-blue-600 font-black uppercase tracking-widest leading-none mb-1">
                                            Tanggal & Minggu
                                        </p>
                                        <p class="font-black text-gray-900"
                                            x-text="formatTanggal(detailData.tanggal_catat)"></p>
                                        <p class="text-xs text-gray-500 font-medium mt-0.5"
                                            x-text="detailData.minggu_ke ? 'Minggu Ke-' + detailData.minggu_ke : 'Minggu belum diisi'">
                                        </p>
                                    </div>
                                </div>

                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-5">
                                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-4">
                                        <dt class="font-black text-gray-500 uppercase text-[10px] tracking-wider mb-1">
                                            Jumlah Hidup / Mati
                                        </dt>
                                        <dd class="font-black text-gray-900 text-base">
                                            <span class="text-emerald-600"
                                                x-text="(detailData.jml_hidup ?? '-') + ' Hidup'"></span>
                                            <span class="text-gray-300 mx-1">/</span>
                                            <span class="text-red-500"
                                                x-text="(detailData.jml_mati ?? '-') + ' Mati'"></span>
                                        </dd>
                                    </div>

                                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-4">
                                        <dt class="font-black text-gray-500 uppercase text-[10px] tracking-wider mb-1">
                                            Tinggi Tanaman
                                        </dt>
                                        <dd class="font-black text-gray-900 text-base"
                                            x-text="(detailData.tinggi_tanaman ?? '-') + ' cm'"></dd>
                                    </div>

                                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-4">
                                        <dt class="font-black text-gray-500 uppercase text-[10px] tracking-wider mb-1">
                                            Kondisi Laporan
                                        </dt>
                                        <dd>
                                            <span
                                                class="inline-flex rounded-lg border px-2.5 py-1 text-[11px] font-black uppercase tracking-widest"
                                                :class="conditionBadgeClass(detailData.info_hama)"
                                                x-text="detailData.info_hama || 'Belum Diisi'"></span>
                                        </dd>
                                    </div>

                                    <div class="rounded-2xl bg-gray-50 border border-gray-100 p-4">
                                        <dt class="font-black text-gray-500 uppercase text-[10px] tracking-wider mb-1">
                                            Risiko Evaluasi
                                        </dt>
                                        <dd>
                                            <span
                                                class="inline-flex rounded-lg border px-2.5 py-1 text-[11px] font-black uppercase tracking-widest"
                                                :class="riskBadgeClass(detailData.info_hama)"
                                                x-text="riskLabel(detailData.info_hama)"></span>
                                        </dd>
                                    </div>

                                    <div class="sm:col-span-2 rounded-2xl bg-gray-50 border border-gray-100 p-4">
                                        <dt class="font-black text-gray-500 uppercase text-[10px] tracking-wider mb-2">
                                            Detail Kegiatan & Perawatan
                                        </dt>
                                        <dd class="p-3 bg-white rounded-xl border border-gray-200 text-gray-700 italic border-l-4 border-l-blue-400 leading-6"
                                            x-text="detailData.kegiatan || 'Tidak ada catatan tambahan yang dilaporkan.'">
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse rounded-b-3xl">
                                <button type="button" @click="modalOpen = false"
                                    class="inline-flex justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-colors focus:outline-none">
                                    Tutup Detail
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </div>

    {{-- SCRIPT --}}
    <!-- Data Storage for AJAX Chart Updating -->
    <div id="chart-data-storage" data-sehat="{{ (int)$cntSehat }}" data-hama="{{ (int)$cntHama }}" data-layu="{{ (int)$cntLayu }}" style="display:none;"></div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        window.guruPemeliharaanItems = @json($pemeliharaans->items());
        
        let healthTrendChart = null;

        function updatePemeliharaanChart(sehat, hama, layu) {
            if (!healthTrendChart) return;
            healthTrendChart.data.datasets[0].data = [sehat, hama, layu];
            healthTrendChart.update();
        }

        window.pemeliharaanGuruComponent = function() {
            return {
                modalOpen: false,
                detailData: {},

                openDetailModal(id) {
                    if (window.guruPemeliharaanItems) {
                        this.detailData = window.guruPemeliharaanItems.find(i => i.id === id) || {};
                    }
                    this.modalOpen = true;
                },

                debounceFilter() {
                    const form = document.getElementById('filter-form');
                    const params = new URLSearchParams(new FormData(form)).toString();
                    this.fetchData(params);
                },

                fetchData(queryString) {
                    const url = `{{ route('guru.pemeliharaan.index') }}${queryString ? '?' + queryString : ''}`;
                    window.history.pushState({}, '', url);
                    
                    const tb = document.getElementById('table-body');
                    if(tb) tb.style.opacity = '0.5';
                    
                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            
                            // Re-assign global array for modal
                            // Extract JSON from script tags or wait, easier is to just do a quick regex, 
                            // but actually Turbo Drive might do this better. For now we fetch the whole HTML,
                            // we just replace inner HTMLs. Modal data will be a bit stale until full refresh,
                            // or we can parse it. But let's just keep it simple: we update the table and chart.
                            
                            document.getElementById('table-body').innerHTML = doc.getElementById('table-body').innerHTML;
                            document.getElementById('table-body').style.opacity = '1';
                            
                            const newPagination = doc.getElementById('pagination-wrapper');
                            if (newPagination) {
                                document.getElementById('pagination-wrapper').innerHTML = newPagination.innerHTML;
                            }

                            const newClearFilter = doc.getElementById('clear-filter-wrapper');
                            if (newClearFilter) {
                                document.getElementById('clear-filter-wrapper').innerHTML = newClearFilter.innerHTML;
                            }

                            const newStats = doc.getElementById('stats-container');
                            if (newStats) {
                                document.getElementById('stats-container').innerHTML = newStats.innerHTML;
                            }

                            const newChartStats = doc.getElementById('chart-stats-container');
                            if (newChartStats) {
                                document.getElementById('chart-stats-container').innerHTML = newChartStats.innerHTML;
                            }
                            
                            // Update Chart Data
                            const chartScript = doc.getElementById('chart-data-storage');
                            if(chartScript) {
                                const sehat = parseInt(chartScript.dataset.sehat) || 0;
                                const hama = parseInt(chartScript.dataset.hama) || 0;
                                const layu = parseInt(chartScript.dataset.layu) || 0;
                                updatePemeliharaanChart(sehat, hama, layu);
                            }

                            // Update Modal Global Variable
                            // We can extract it by looking for window.guruPemeliharaanItems = [...] in the text
                            const match = html.match(/window\.guruPemeliharaanItems\s*=\s*(\[.*?\]);/s);
                            if (match && match[1]) {
                                try {
                                    window.guruPemeliharaanItems = JSON.parse(match[1]);
                                } catch(e) {}
                            }
                        });
                },

                handlePagination(e) {
                    const link = e.target.closest('a');
                    if (link) {
                        const qs = link.href.split('?')[1] || '';
                        this.fetchData(qs);
                    }
                },

                formatTanggal(value) {
                    if (!value) return '-';
                    try {
                        return new Date(value).toLocaleDateString('id-ID', {
                            day: '2-digit', month: 'long', year: 'numeric'
                        });
                    } catch (e) {
                        return value;
                    }
                },

                riskLabel(condition) {
                    if (condition === 'Sehat') return 'Aman';
                    if (condition === 'Terserang Hama') return 'Perlu Pantauan';
                    if (condition === 'Layu') return 'Risiko Tinggi';
                    return 'Belum Jelas';
                },

                riskBadgeClass(condition) {
                    if (condition === 'Aman' || condition === 'Sehat') return 'bg-emerald-50 text-emerald-700 border-emerald-200';
                    if (condition === 'Perlu Pantauan') return 'bg-purple-50 text-purple-700 border-purple-200';
                    if (condition === 'Risiko Tinggi') return 'bg-red-50 text-red-700 border-red-200';
                    return 'bg-gray-50 text-gray-700 border-gray-200';
                },

                conditionBadgeClass(condition) {
                    if (condition === 'Aman' || condition === 'Sehat') return 'bg-emerald-100 text-emerald-700 border-emerald-200';
                    if (condition === 'Perlu Pantauan') return 'bg-purple-100 text-purple-700 border-purple-200';
                    if (condition === 'Risiko Tinggi') return 'bg-red-100 text-red-700 border-red-200';
                    return 'bg-gray-100 text-gray-700 border-gray-200';
                }
            };
        };

        function initPemeliharaanChart() {
            const ctxTrend = document.getElementById('healthTrendChart');
            if (!ctxTrend) return;
            if (healthTrendChart) healthTrendChart.destroy();

            healthTrendChart = new Chart(ctxTrend.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Aman', 'Perlu Pantauan', 'Risiko Tinggi'],
                    datasets: [{
                        data: [
                            @json((int) $cntSehat),
                            @json((int) $cntPerluPantauan),
                            @json((int) $cntRisikoTinggi)
                        ],
                        backgroundColor: ['#10B981', '#A855F7', '#EF4444'],
                        borderWidth: 3,
                        borderColor: '#ffffff',
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '74%',
                    plugins: { legend: { display: false } },
                    animation: { animateScale: true, animateRotate: true }
                }
            });
        }

        document.addEventListener("DOMContentLoaded", initPemeliharaanChart);
        document.addEventListener("turbo:load", initPemeliharaanChart);
    </script>
</x-app-layout>