<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Rekap Penanaman') }}
                </h2>
                <!-- Breadcrumbs -->
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition">Dashboard Guru</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-gray-700 font-medium">Rekap Penanaman</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Pantau data penanaman siswa sebagai dasar awal evaluasi keberhasilan panen menggunakan Rule-Based Decision Tree.</p>
            </div>
        </div>
    </x-slot>

    <!-- Alpine State Wrapper -->
    <div x-data="penanamanSistemComponent()" class="max-w-7xl mx-auto space-y-8 pb-10">
        
        <!-- Alerts -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl flex items-start shadow-sm fade-in-content">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex-1">
                    <h3 class="text-sm font-bold">Berhasil!</h3>
                    <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl flex items-start shadow-sm fade-in-content mb-6">
                <svg class="w-5 h-5 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex-1">
                    <h3 class="text-sm font-bold">Formulir Tidak Valid!</h3>
                    <ul class="list-disc ml-5 mt-1 text-sm text-red-700">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Card Statistik -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Total Penanaman</p>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-50 text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Penanaman Aktif</p>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['aktif'] }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Selesai Panen</p>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['panen'] }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-orange-50 text-orange-500 group-hover:bg-orange-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-gray-200/50 border border-gray-100 group hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500 mb-1">Tanaman Bermasalah</p>
                        <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['bermasalah'] }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-red-50 text-red-500 group-hover:bg-red-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Penjelasan Alur Decision Tree -->
        <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100 flex items-start shadow-sm mb-8">
            <div class="p-3 bg-blue-100 rounded-xl text-blue-600 mr-4">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-blue-900">Alur Evaluasi Decision Tree</h3>
                <p class="text-sm text-blue-700 mt-1">Data penanaman (jumlah bibit, target panen, jenis tanaman) ini merupakan parameter krusial untuk algoritma Decision Tree. Pastikan data siswa lengkap dan masuk akal sebelum berlanjut ke tahap Pemeliharaan dan Panen agar sistem evaluasi dapat berjalan optimal dan akurat.</p>
            </div>
        </div>

        <!-- Ringkasan Tren (Full Width for Read-Only Mode) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center">
            <h3 class="text-sm font-bold text-gray-900 w-full mb-4 text-center border-b border-gray-100 pb-2 uppercase tracking-wide">Tren Komoditas Tanaman (View Only)</h3>
            <div class="relative w-full h-48 md:h-64 flex justify-center items-center">
                <canvas id="cropTrenChart"></canvas>
            </div>
            <p class="text-[10px] text-gray-400 mt-4 px-2 text-center">Bagan diatas merepresentasikan distribusi jenis tanaman terbanyak keseluruhan yang dicatat oleh siswa Anda.</p>
        </div>

        <!-- TABEL DATA PENANAMAN SECARA KESELURUHAN -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0">
                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Rekap Penanaman Siswa
                </h3>
                
                <!-- Search & Filters -->
                <form id="filter-form" action="{{ route('guru.penanaman.index') }}" method="GET" class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3" @submit.prevent="debounceFilter()">
                    <div class="relative w-full sm:w-56">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau tanaman..." 
                               class="w-full pl-9 py-2 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm shadow-sm"
                               @input.debounce.500ms="debounceFilter()">
                    </div>
                    
                    <select name="status_filter" class="w-full sm:w-auto py-2 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm shadow-sm" @change="debounceFilter()">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status_filter') === 'aktif' ? 'selected' : '' }}>Masih Aktif (Proses)</option>
                        <option value="panen" {{ request('status_filter') === 'panen' ? 'selected' : '' }}>Sudah Dipanen</option>
                    </select>

                    <select name="per_page" class="w-full sm:w-auto py-2 border-gray-200 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm shadow-sm" @change="debounceFilter()">
                        <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 Data</option>
                        <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20 Data</option>
                        <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 Data</option>
                        <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 Data</option>
                        <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>Semua Data</option>
                    </select>

                    <div id="clear-filter-wrapper">
                        @if(request()->has('search') || request()->has('status_filter') || (request()->has('per_page') && request('per_page') != '10'))
                        <a href="{{ route('guru.penanaman.index') }}" @click.prevent="fetchData('')" class="p-2 text-gray-400 hover:text-red-500 transition" title="Bersihkan Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Info Dokumentasi Kesiapan Evaluasi -->
            <div class="px-6 py-4 bg-indigo-50/50 border-b border-gray-100 flex items-start space-x-3">
                <svg class="w-5 h-5 text-indigo-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-xs text-gray-600 leading-relaxed">
                    <span class="font-bold text-indigo-900">Catatan Sistem:</span> 
                    Kolom <b>Status Evaluasi</b> di tabel ini membaca jejak rekam *real-time*. Jika status menunjukkan label <span class="font-bold text-purple-600 bg-purple-50 border border-purple-100 px-1.5 py-0.5 rounded">Sudah Dievaluasi</span>, berarti data tersebut telah dipanen dan Anda (atau guru lain) telah mengeksekusi penilaian akhirnya menggunakan <b>Algoritma Decision Tree</b> di menu <b>Evaluasi Panen</b>.
                </div>
            </div>

            <!-- Table Block -->
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                            <th class="p-4 pl-6 text-center w-12">No</th>
                            <th class="p-4">Siswa & Detail Tanaman</th>
                            <th class="p-4">Info Lahan & Target</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4">Catatan Pemeliharaan</th>
                            <th class="p-4 text-center">Status Evaluasi</th>
                            <th class="p-4 text-center pr-6">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="table-body" class="divide-y divide-gray-100 relative transition-opacity duration-300">
                        @forelse($penanamans as $idx => $item)
                        <tr class="hover:bg-gray-50/70 transition-colors group">
                            <td class="p-4 pl-6 text-center text-gray-400 font-medium text-sm">
                                {{ $penanamans->firstItem() + $idx }}
                            </td>
                            <td class="p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-sm ring-2 ring-white uppercase">
                                        {{ substr(data_get($item->siswa, 'name', 'U'), 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900 leading-tight">{{ data_get($item->siswa, 'name', 'Siswa Tidak Ditemukan') }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            <span class="font-semibold text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded">{{ $item->jenis_tanaman }}</span> • 
                                            {{ \Carbon\Carbon::parse($item->tgl_tanam)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <p class="text-sm font-semibold text-gray-700">{{ $item->jml_bibit }} Bibit <span class="text-gray-400 font-normal ml-1">| Target: {{ $item->target_panen_kg }} kg</span></p>
                                <p class="text-xs text-gray-500 truncate max-w-xs" title="{{ $item->lokasi_lahan }}"><svg class="w-3 h-3 inline text-gray-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>{{ $item->lokasi_lahan }}</p>
                            </td>
                            <td class="p-4 text-center">
                                @if($item->panen)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded border border-orange-200 text-xs font-bold bg-orange-50 text-orange-600">
                                        Selesai / Panen
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded border border-emerald-200 text-xs font-bold bg-emerald-50 text-emerald-600">
                                        Fase Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4">
                                @php
                                    $prog = count($item->pemeliharaans ?? []);
                                @endphp
                                <div class="flex items-center space-x-2">
                                    <div class="flex -space-x-2">
                                        @for($i = 0; $i < min($prog, 3); $i++)
                                            <div class="w-6 h-6 rounded-full bg-blue-100 border-2 border-white flex items-center justify-center text-[10px] font-bold text-blue-600 z-{{30-$i*10}}">✓</div>
                                        @endfor
                                    </div>
                                    <span class="text-xs font-medium text-gray-600">{{ $prog }} Catatan</span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                @php
                                    $panenValid = $item->panen && 
                                                  $item->panen->bobot_panen !== null && $item->panen->bobot_panen >= 0 && 
                                                  $item->panen->tanaman_hidup !== null && 
                                                  $item->panen->tanaman_mati !== null &&
                                                  ($item->panen->tanaman_hidup + $item->panen->tanaman_mati <= $item->jml_bibit);
                                    
                                    $ready = $item->jml_bibit > 0 && 
                                             $item->target_panen_kg > 0 && 
                                             count($item->pemeliharaans ?? []) > 0 && 
                                             $panenValid;
                                             
                                    $evalStatus = $item->evaluasi ? 'Sudah Dievaluasi' : ($ready ? 'Siap Evaluasi' : 'Data Belum Lengkap');
                                    $modalData = $item->toArray();
                                    $modalData['status_evaluasi'] = $evalStatus;
                                    $modalData['namaSiswa'] = data_get($item->siswa, 'name', 'U');
                                @endphp
                                @if($item->evaluasi)
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-purple-50 text-purple-600 text-[10px] font-bold border border-purple-200" title="Diproses melalui Rule-Based Decision Tree">
                                            Sudah Dievaluasi
                                        </span>
                                        <div class="text-[9px] text-gray-500 mt-1 leading-tight text-center">
                                            @if($item->evaluasi->evaluator)
                                                oleh {{ $item->evaluasi->evaluator->name }}<br>
                                                {{ $item->evaluasi->evaluated_at ? \Carbon\Carbon::parse($item->evaluasi->evaluated_at)->format('d M Y H:i') : '' }}
                                            @else
                                                melalui modul<br>Evaluasi Panen
                                            @endif
                                        </div>
                                    </div>
                                @elseif($ready)
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-blue-50 text-blue-600 text-[10px] font-bold border border-blue-200" title="Data sudah lengkap dan dapat diproses oleh guru">
                                            Siap Evaluasi
                                        </span>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="inline-flex items-center px-2 py-1 rounded bg-amber-50 text-amber-600 text-[10px] font-bold border border-amber-200" title="Lengkapi data penanaman, pemeliharaan, dan panen.">
                                            Data Belum Lengkap
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-center">
                                <div class="relative inline-block text-left" x-data="{ openMenu: false }" @click.outside="openMenu = false">
                                    <button @click="openMenu = !openMenu" type="button" class="p-1 rounded-md text-gray-400 hover:text-gray-600 hover:bg-gray-100 focus:outline-none transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path></svg>
                                    </button>

                                    <!-- Dropdown Action Modern -->
                                    <div x-show="openMenu" x-cloak
                                         x-transition:enter="transition ease-out duration-100"
                                         x-transition:enter-start="transform opacity-0 scale-95"
                                         x-transition:enter-end="transform opacity-100 scale-100"
                                         class="origin-top-right absolute right-0 mt-2 w-48 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-10">
                                        
                                        <div class="py-1">
                                            <button @click="openDetailModal({{ $item->id }}); openMenu = false;" class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-emerald-600 transition">
                                                <svg class="mr-3 w-4 h-4 text-gray-400 group-hover:text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                Tinjau Detail
                                            </button>
                                            <a href="{{ route('guru.pemeliharaan.index', ['penanaman_id' => $item->id]) }}" class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600 transition">
                                                <svg class="mr-3 w-4 h-4 text-gray-400 group-hover:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path></svg>
                                                Lanjut Pemeliharaan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <!-- Empty State Global Data -->
                        <tr>
                            <td colspan="7" class="p-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                        <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800">Belum Ada Rekaman Penanaman</h3>
                                    <p class="text-sm text-gray-500 mt-1 max-w-sm">Menunggu siswa mencatat data penanaman awal mereka.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Server Pagination -->
            <div id="pagination-wrapper">
                @if($penanamans->hasPages())
                    <div class="p-6 border-t border-gray-100 bg-gray-50/50" @click.prevent="handlePagination($event)">
                        {{ $penanamans->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- MODAL DETAIL PENANAMAN (Alpine JS) -->
        <template x-teleport="body">
            <div x-show="modalOpen" x-cloak class="relative z-[100]">
                <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
            
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="modalOpen"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         @click.outside="modalOpen = false"
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl border border-gray-100">
                        
                        <div class="bg-white">
                            <!-- Modal Header -->
                            <div class="bg-emerald-600 px-6 py-4 flex justify-between items-center text-white">
                                <h3 class="text-lg font-bold flex items-center">
                                    <svg class="w-5 h-5 mr-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                    Detail Data Penanaman
                                </h3>
                                <button type="button" @click="modalOpen = false" class="text-white/70 hover:text-white transition">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            
                            <!-- Modal Body -->
                            <div class="px-6 py-6 border-b border-gray-100">
                                <div class="flex items-center mb-6 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                    <div class="w-12 h-12 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg mr-4 uppercase" x-text="detailData.namaSiswa ? detailData.namaSiswa.substring(0,1) : 'U'"></div>
                                    <div>
                                        <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest leading-none">Kepemilikan Proyek</p>
                                        <p class="font-bold text-lg text-gray-800 leading-tight mt-0.5" x-text="detailData.namaSiswa"></p>
                                    </div>
                                </div>
                                
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                                    <div>
                                        <dt class="text-xs font-semibold text-gray-500 uppercase">Jenis Tanaman</dt>
                                        <dd class="mt-1 text-sm font-bold text-gray-900" x-text="detailData.jenis_tanaman"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-gray-500 uppercase">Tanggal Tanam</dt>
                                        <dd class="mt-1 text-sm font-bold text-gray-900" x-text="detailData.tgl_tanam"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-gray-500 uppercase">Jumlah Bibit Awal</dt>
                                        <dd class="mt-1 text-sm font-bold text-gray-900" x-text="detailData.jml_bibit + ' Bibit'"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-gray-500 uppercase">Target Panen</dt>
                                        <dd class="mt-1 text-sm font-bold text-gray-900" x-text="(detailData.target_panen_kg || '-') + ' Kg'"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-gray-500 uppercase">Kondisi / Media Tanam</dt>
                                        <dd class="mt-1 text-sm font-bold text-gray-900" x-text="detailData.kondisi_tanah"></dd>
                                    </div>
                                    <div>
                                        <dt class="text-xs font-semibold text-gray-500 uppercase">Status Evaluasi</dt>
                                        <dd class="mt-1 text-sm font-bold text-gray-900">
                                            <span x-text="detailData.status_evaluasi || 'Belum dicek'" class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-gray-100 text-gray-700"></span>
                                        </dd>
                                    </div>
                                    <div class="sm:col-span-2">
                                        <dt class="text-xs font-semibold text-gray-500 uppercase">Lokasi Lahan</dt>
                                        <dd class="mt-1 text-sm font-bold text-gray-900" x-text="detailData.lokasi_lahan"></dd>
                                    </div>
                                </dl>
                            </div>
                            
                            <!-- Action / Modal Footer -->
                            <div class="bg-gray-50 px-6 py-4 sm:flex sm:flex-row-reverse rounded-b-2xl">
                                <button type="button" @click="modalOpen = false" class="inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto transition-colors focus:outline-none">Tutup Detail</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </div>

    <!-- Data Storage for AJAX Chart Updating -->
    <div id="chart-data-storage" data-labels="{{ json_encode($labels ?? []) }}" data-counts="{{ json_encode($counts ?? []) }}" style="display:none;"></div>

    <!-- Alpine Data Logic & ChartJS Injection -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @php
            $modalDataArray = [];
            foreach($penanamans->items() as $item) {
                $ready = $item->jml_bibit > 0 && $item->target_panen_kg > 0 && count($item->pemeliharaans ?? []) > 0 && $item->panen;
                $evalStatus = $item->evaluasi ? 'Sudah Dievaluasi' : ($ready ? 'Siap Dievaluasi' : 'Belum Siap');
                $arr = $item->toArray();
                $arr['status_evaluasi'] = $evalStatus;
                $arr['namaSiswa'] = data_get($item->siswa, 'name', 'U');
                $modalDataArray[$item->id] = $arr;
            }
        @endphp
        window.guruPenanamanModalData = @json($modalDataArray);

        let cropChartInstance = null;
        
        function updateChart(newLabels, newCounts) {
            if (!cropChartInstance) return;
            if (newLabels.length === 0) {
                newLabels.push('Belum Ada Data');
                newCounts.push(1);
            }
            cropChartInstance.data.labels = newLabels;
            cropChartInstance.data.datasets[0].data = newCounts;
            cropChartInstance.update();
        }

        window.penanamanSistemComponent = function() {
            return {
                isSubmitting: false,
                modalOpen: false,
                detailData: {},
                openDetailModal(id) {
                    if (window.guruPenanamanModalData) {
                        this.detailData = window.guruPenanamanModalData[id] || {};
                    }
                    this.modalOpen = true;
                },
                debounceFilter() {
                    const form = document.getElementById('filter-form');
                    const params = new URLSearchParams(new FormData(form)).toString();
                    this.fetchData(params);
                },
                fetchData(queryString) {
                    // Update URL silently
                    const url = `{{ route('guru.penanaman.index') }}${queryString ? '?' + queryString : ''}`;
                    window.history.pushState({}, '', url);
                    
                    // Show a loading indicator on table body if desired, or just fade it
                    const tb = document.getElementById('table-body');
                    if(tb) tb.style.opacity = '0.5';
                    
                    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                        .then(res => res.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            
                            document.getElementById('table-body').innerHTML = doc.getElementById('table-body').innerHTML;
                            document.getElementById('table-body').style.opacity = '1';
                            document.getElementById('pagination-wrapper').innerHTML = doc.getElementById('pagination-wrapper').innerHTML;
                            document.getElementById('clear-filter-wrapper').innerHTML = doc.getElementById('clear-filter-wrapper').innerHTML;
                            
                            // Extract chart data
                            const chartScript = doc.getElementById('chart-data-storage');
                            if(chartScript) {
                                const newLabels = JSON.parse(chartScript.dataset.labels);
                                const newCounts = JSON.parse(chartScript.dataset.counts);
                                updateChart(newLabels, newCounts);
                            }
                        });
                },
                handlePagination(e) {
                    const link = e.target.closest('a');
                    if (link) {
                        const qs = link.href.split('?')[1] || '';
                        this.fetchData(qs);
                    }
                }
            };
        };
        
        // Setup Chart Data globally from Controller
        function initPenanamanChart() {
            if (cropChartInstance) {
                cropChartInstance.destroy();
                cropChartInstance = null;
            }
            const labels = @js($labels ?? []);
            const counts = @js($counts ?? []);
            
            if (labels.length === 0) {
                labels.push('Belum Ada Data');
                counts.push(1);
            }
            
            const ctxCrop = document.getElementById('cropTrenChart');
            if (ctxCrop) {
                cropChartInstance = new Chart(ctxCrop.getContext('2d'), {
                    type: 'pie',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
                            backgroundColor: [
                                '#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            hoverOffset: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { boxWidth: 12, font: { family: 'Inter', size: 10 } }
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

        document.addEventListener("turbo:load", initPenanamanChart);
        document.addEventListener("DOMContentLoaded", initPenanamanChart);
    </script>
</x-app-layout>
