<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center">
                    {{ __('Catatan Panen Akhir') }}
                </h2>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition">Dashboard Guru</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    @if(request()->has('search') || request()->has('status_filter'))
                        <a href="{{ route('guru.panen.index') }}" class="p-2 text-gray-400 hover:text-red-500 transition" title="Bersihkan Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                    <span class="text-gray-700 font-medium">Panen & Evaluasi Awal</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Pantau data panen siswa sebagai data akhir siklus tanam sebelum diproses pada evaluasi Rule-Based Decision Tree.</p>
            </div>
        </div>
    </x-slot>

    <!-- Alpine Wrapper -->
    <div x-data="panenGuruManager()" class="max-w-7xl mx-auto space-y-8 pb-12">
        
        <!-- Alerts Notification -->
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-xl flex items-start shadow-sm fade-in-content">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex-1">
                    <h3 class="text-sm font-bold">Laporan Diarsipkan!</h3>
                    <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl flex items-start shadow-sm fade-in-content mb-6">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="flex-1">
                    <h3 class="text-sm font-bold">Peringatan Validasi!</h3>
                    <ul class="list-disc ml-5 mt-1 text-sm text-red-700">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- 4 Card Statistik (KPIs) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-indigo-100/50 border border-indigo-50 relative group hover:-translate-y-1 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] font-bold text-indigo-400 uppercase tracking-wider mb-1">Total Entri Panen</p>
                        <h3 class="text-3xl font-extrabold text-indigo-900">{{ $stats['total'] }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-indigo-50 text-indigo-500 group-hover:bg-indigo-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-emerald-100/50 border border-emerald-50 relative group hover:-translate-y-1 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] font-bold text-emerald-500 uppercase tracking-wider mb-1">Panen Dominan Hidup</p>
                        <h3 class="text-3xl font-extrabold text-emerald-700">{{ $stats['dominan_hidup'] ?? 0 }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-emerald-50 text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-red-100/50 border border-red-50 relative group hover:-translate-y-1 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] font-bold text-red-400 uppercase tracking-wider mb-1">Panen Dominan Mati</p>
                        <h3 class="text-3xl font-extrabold text-red-600">{{ $stats['dominan_mati'] ?? 0 }}</h3>
                    </div>
                    <div class="p-3 rounded-xl bg-red-50 text-red-500 group-hover:bg-red-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm shadow-amber-100/50 border border-amber-50 relative group hover:-translate-y-1 hover:shadow-md transition duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[11px] font-bold text-amber-500 uppercase tracking-wider mb-1">Akumulasi Bobot Lahan</p>
                        <div class="flex items-baseline space-x-1">
                            <h3 class="text-3xl font-extrabold text-amber-700">{{ $stats['berat_total'] }}</h3>
                            <span class="text-sm font-semibold text-amber-600">Kg</span>
                        </div>
                    </div>
                    <div class="p-3 rounded-xl bg-amber-50 text-amber-500 group-hover:bg-amber-500 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel Ringkasan Panen -->
        <div class="space-y-6">
            <!-- Doughnut AI Prediksi Chart Full Width -->
            <div class="bg-indigo-900 rounded-2xl shadow-lg border border-indigo-800 p-8 flex flex-col md:flex-row items-center justify-between relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-48 h-48 bg-orange-500 rounded-full blur-3xl opacity-20 pointer-events-none"></div>
                <div class="absolute -bottom-10 -left-10 w-48 h-48 bg-emerald-500 rounded-full blur-3xl opacity-20 pointer-events-none"></div>
                
                <div class="md:w-1/2 md:pr-8 z-10 mb-6 md:mb-0">
                    <h3 class="text-sm font-bold text-white w-full mb-4 py-2 px-4 bg-white/10 rounded-lg shadow-sm border border-white/10 uppercase tracking-widest flex items-center inline-block">
                        <svg class="w-5 h-5 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>
                        Rekap Indikasi Data Panen
                    </h3>
                    <p class="text-indigo-200 text-sm mb-6 leading-relaxed">
                        Visualisasi di samping menampilkan perbandingan indikasi data panen berdasarkan jumlah tanaman hidup dan tanaman mati. Hasil ini masih bersifat indikasi awal dan akan diproses lebih lanjut pada evaluasi Rule-Based Decision Tree. 
                    </p>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between bg-white/5 p-3 rounded-xl border border-white/10">
                            <span class="text-xs font-semibold text-emerald-200 uppercase tracking-wider">Dominan Hidup</span>
                            <span class="text-sm font-bold text-white bg-emerald-500/20 px-3 py-1 rounded-md border border-emerald-500/30">{{ $stats['dominan_hidup'] ?? 0 }} Siswa</span>
                        </div>
                        <div class="flex items-center justify-between bg-white/5 p-3 rounded-xl border border-white/10">
                            <span class="text-xs font-semibold text-red-200 uppercase tracking-wider">Dominan Mati</span>
                            <span class="text-sm font-bold text-white bg-red-500/20 px-3 py-1 rounded-md border border-red-500/30">{{ $stats['dominan_mati'] ?? 0 }} Siswa</span>
                        </div>
                    </div>
                </div>

                <div class="md:w-1/2 relative flex justify-center items-center z-10 min-h-[250px]">
                    <div class="w-full max-w-[250px] aspect-square">
                        <canvas id="ratioChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABEL DATA PANEN TERPADU -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-2">
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 bg-gray-50/50">
                <h3 class="text-lg font-bold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    Inventaris Panen Terekam
                </h3>
                
                <form action="{{ route('guru.panen.index') }}" method="GET" class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-3" x-data="{ debounce() { this.$root.submit() } }">
                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kepemilikan..." 
                               class="w-full pl-9 py-2 border-gray-200 rounded-xl focus:ring-orange-500 focus:border-orange-500 text-sm shadow-sm transition"
                               @input.debounce.500ms="debounce()">
                    </div>
                </form>
            </div>

            <!-- Table View -->
            <div class="overflow-x-auto w-full">
                <table class="w-full text-left border-collapse whitespace-nowrap">
                    <thead>
                        <tr class="bg-white border-b border-gray-100 text-gray-400 text-[10px] uppercase tracking-widest font-extrabold">
                            <th class="p-4 pl-6 text-center w-12 border-r border-gray-50">No</th>
                            <th class="p-4">Identitas Proyek Siswa</th>
                            <th class="p-4">Tanggal Panen</th>
                            <th class="p-4 text-center bg-emerald-50/40">Bobot / Target</th>
                            <th class="p-4 text-center">Hidup / Mati</th>
                            <th class="p-4 text-center border-l border-gray-50">Kesiapan Evaluasi</th>
                            <th class="p-4 text-center pr-6">Alat</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($panens as $idx => $item)
                        <tr class="hover:bg-orange-50/30 transition-colors group">
                            <td class="p-4 pl-6 text-center text-gray-400 font-medium text-sm border-r border-gray-50">
                                {{ $panens->firstItem() + $idx }}
                            </td>
                            <td class="p-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-700 flex items-center justify-center font-bold text-sm border border-orange-200">
                                        {{ substr(data_get($item->penanaman->siswa ?? [], 'name', 'U'), 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-900">{{ data_get($item->penanaman->siswa ?? [], 'name', 'Siswa Tidak Valid') }}</p>
                                        <p class="text-xs text-orange-600 font-semibold bg-orange-50 inline-block px-1.5 rounded mt-0.5 border border-orange-100">
                                            {{ data_get($item->penanaman ?? [], 'jenis_tanaman', '?') }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4 text-sm text-gray-600 font-semibold">
                                {{ \Carbon\Carbon::parse($item->tgl_panen)->translatedFormat('d F Y') }}
                            </td>
                            @php
                                $targetPanen = data_get($item->penanaman, 'target_panen_kg', 0);
                                $jmlBibit = data_get($item->penanaman, 'jml_bibit', 0);
                                
                                $persentaseHasil = $targetPanen > 0 ? round(($item->bobot_panen / $targetPanen) * 100) . '%' : '-';
                                $persentaseHidup = $jmlBibit > 0 ? round(($item->tanaman_hidup / $jmlBibit) * 100) . '%' : '-';

                                $dataPanenLengkap = $item->bobot_panen !== null && $item->tanaman_hidup !== null && $item->tanaman_mati !== null;
                                $targetAda = $targetPanen > 0;
                                $bibitAda = $jmlBibit > 0;
                                $totalTidakMelebihiBibit = ($item->tanaman_hidup + $item->tanaman_mati) <= $jmlBibit;
                                
                                $isSiap = $dataPanenLengkap && $targetAda && $bibitAda && $totalTidakMelebihiBibit;
                            @endphp
                            <td class="p-4 text-center bg-emerald-50/20">
                                <div class="flex flex-col items-center">
                                    <span class="bg-emerald-100 border border-emerald-200 text-emerald-800 px-2 py-0.5 rounded-md text-xs font-black">{{ $item->bobot_panen }} / {{ data_get($item->penanaman, 'target_panen_kg', '-') }} Kg</span>
                                    <span class="text-[10px] font-bold text-gray-500 mt-1">Capaian: {{ $persentaseHasil }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="flex items-center justify-center space-x-1">
                                        <span class="text-xs font-bold px-1.5 py-0.5 rounded bg-emerald-50 text-emerald-600 border border-emerald-200" title="Hidup">🌱 {{ $item->tanaman_hidup }}</span>
                                        <span class="text-xs font-bold px-1.5 py-0.5 rounded bg-red-50 text-red-600 border border-red-200" title="Mati">🥀 {{ $item->tanaman_mati }}</span>
                                    </div>
                                    <span class="text-[10px] font-bold text-gray-500 mt-1">Sisa Hidup: {{ $persentaseHidup }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center border-l border-gray-50">
                                @if(isset($item->penanaman->evaluasi) && $item->penanaman->evaluasi)
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="inline-flex items-center text-purple-600 bg-purple-50 border border-purple-200 px-2 py-1 rounded-lg font-bold text-[10px] uppercase tracking-wider">
                                            Sudah Dievaluasi
                                        </span>
                                        <div class="text-[9px] text-gray-500 mt-1 leading-tight text-center">
                                            @if($item->penanaman->evaluasi->evaluator)
                                                oleh {{ $item->penanaman->evaluasi->evaluator->name }}<br>
                                                {{ $item->penanaman->evaluasi->evaluated_at ? \Carbon\Carbon::parse($item->penanaman->evaluasi->evaluated_at)->format('d M Y H:i') : '' }}
                                            @else
                                                melalui modul<br>Evaluasi Panen
                                            @endif
                                        </div>
                                    </div>
                                @elseif($isSiap)
                                    <span class="inline-flex items-center text-blue-600 bg-blue-50 border border-blue-200 px-2 py-1 rounded-lg font-bold text-[10px] uppercase tracking-wider" title="Data sudah lengkap dan dapat diproses oleh guru">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Siap Evaluasi
                                    </span>
                                @else
                                    <span class="inline-flex items-center text-amber-600 bg-amber-50 border border-amber-200 px-2 py-1 rounded-lg font-bold text-[10px] uppercase tracking-wider" title="Data pemeliharaan kurang lengkap">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Data Belum Lengkap
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 pr-6 text-center">
                                <div class="flex justify-center space-x-2">
                                    <button type="button" @click="openDetailModal(@js($item))" class="p-1.5 rounded-lg bg-gray-50 text-gray-500 border border-gray-200 hover:text-orange-600 hover:border-orange-300 hover:bg-orange-50 transition" title="Lihat Rekap">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    <a href="{{ route('guru.evaluasi.index', ['penanaman_id' => $item->penanaman_id]) }}" class="p-1.5 rounded-lg bg-purple-50 text-purple-600 border border-purple-200 hover:text-white hover:bg-purple-600 transition group" title="Lanjut Evaluasi Decision Tree">
                                        <svg class="w-4 h-4 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="p-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-20 h-20 bg-orange-50 rounded-full flex items-center justify-center mb-4 ring-8 ring-orange-50/50">
                                        <svg class="w-10 h-10 text-orange-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                    </div>
                                    <h3 class="text-base font-bold text-gray-800">Gudang Penyimpanan Masih Kosong.</h3>
                                    <p class="text-sm text-gray-500 mt-1 max-w-sm">Belum ada data panen akhir siswa. Data akan muncul setelah siswa mencatat hasil panen dari siklus tanam.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($panens->hasPages())
                <div class="p-5 border-t border-gray-100 bg-gray-50/80">
                    {{ $panens->links() }}
                </div>
            @endif
        </div>

        <!-- MODAL DETAIL LAYOUT (Alpine JS) -->
        <template x-teleport="body">
            <div x-show="modalOpen" x-cloak class="relative z-[100]">
                <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity"></div>
            
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="modalOpen"
                         x-transition:enter="ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         @click.outside="modalOpen = false"
                         class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-gray-100">
                        
                        <div class="bg-white">
                            <!-- Header Modal Berkualitas Tinggi -->
                            <div class="bg-gradient-to-r from-orange-600 to-amber-500 px-6 py-5 flex justify-between items-center text-white relative overflow-hidden">
                                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/20 rounded-full blur-2xl"></div>
                                <h3 class="text-xl font-black tracking-tight flex items-center relative z-10">
                                    <svg class="w-6 h-6 mr-2 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    Berita Acara Panen
                                </h3>
                                <button type="button" @click="modalOpen = false" class="text-white/70 hover:text-white transition bg-black/10 hover:bg-black/20 p-1.5 rounded-xl z-10">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>
                            </div>
                            
                            <div class="px-8 py-8">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <!-- Identitas Section -->
                                    <div class="bg-orange-50/50 p-5 rounded-2xl border border-orange-100">
                                        <div class="flex items-center mb-4">
                                            <div class="w-12 h-12 rounded-xl bg-orange-600 text-white flex items-center justify-center font-black text-xl mr-4 shadow-orange-500/30 shadow-lg uppercase" x-text="detailData.penanaman && detailData.penanaman.siswa ? detailData.penanaman.siswa.name.substring(0,1) : 'U'"></div>
                                            <div>
                                                <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest leading-none">Petani / Siswa</p>
                                                <p class="font-bold text-lg text-gray-900 leading-tight mt-1" x-text="detailData.penanaman && detailData.penanaman.siswa ? detailData.penanaman.siswa.name : '-'"></p>
                                            </div>
                                        </div>
                                        <div class="space-y-3 border-t border-orange-200/50 pt-4">
                                            <div class="flex justify-between">
                                                <span class="text-xs font-semibold text-gray-500">Komoditas</span>
                                                <span class="text-sm font-bold text-gray-800" x-text="detailData.penanaman ? detailData.penanaman.jenis_tanaman : '-'"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-xs font-semibold text-gray-500">Pemanenan</span>
                                                <span class="text-sm font-bold text-gray-800" x-text="detailData.tgl_panen ? new Date(detailData.tgl_panen).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : '-'"></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-xs font-semibold text-gray-500">Target Panen</span>
                                                <span class="text-sm font-bold text-gray-800" x-text="(detailData.penanaman ? detailData.penanaman.target_panen_kg : '-') + ' Kg'"></span>
                                            </div>
                                            <div class="flex justify-between bg-white p-2 rounded-lg border border-orange-100 shadow-sm mt-2">
                                                <span class="text-xs font-extrabold text-orange-800 uppercase flex items-center"><svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg> Bobot Bersih</span>
                                                <span class="text-base font-black text-orange-600" x-text="detailData.bobot_panen + ' Kg'"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Kinerja Section -->
                                    <div class="border border-gray-100 rounded-2xl p-5 shadow-sm">
                                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4 border-b border-gray-100 pb-2">Rasio Kelangsungan Hidup</h4>
                                        
                                        <div class="space-y-4">
                                            <div>
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="text-sm font-bold text-emerald-600 flex items-center">🌱 Tanaman Hidup</span>
                                                    <span class="text-sm font-black text-emerald-700" x-text="detailData.tanaman_hidup + ' Pcs'"></span>
                                                </div>
                                                <div class="w-full bg-gray-100 rounded-full h-2">
                                                    <div class="bg-emerald-500 h-2 rounded-full" style="width: 70%" :style="'width: ' + ((detailData.tanaman_hidup / ((detailData.tanaman_hidup + detailData.tanaman_mati) || 1)) * 100) + '%'"></div>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <div class="flex justify-between items-center mb-1">
                                                    <span class="text-sm font-bold text-red-500 flex items-center">🥀 Tanaman Mati</span>
                                                    <span class="text-sm font-black text-red-600" x-text="detailData.tanaman_mati + ' Pcs'"></span>
                                                </div>
                                                <div class="w-full bg-gray-100 rounded-full h-2">
                                                    <div class="bg-red-500 h-2 rounded-full" style="width: 30%" :style="'width: ' + ((detailData.tanaman_mati / ((detailData.tanaman_hidup + detailData.tanaman_mati) || 1)) * 100) + '%'"></div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6 mx-auto w-full text-center p-3 rounded-xl border bg-gray-50 border-gray-200">
                                            <p class="text-[10px] uppercase font-bold text-gray-500 mb-0.5">Indikasi Awal Panen</p>
                                            <span class="text-sm font-black text-gray-700" x-text="(detailData.tanaman_hidup + detailData.tanaman_mati) > (detailData.penanaman?.jml_bibit || Infinity) ? 'Perlu Validasi' : (detailData.tanaman_hidup >= detailData.tanaman_mati ? 'Dominan Hidup' : 'Dominan Mati')"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 border-t border-gray-100 px-6 py-4 flex flex-row-reverse rounded-b-2xl items-center">
                                <button type="button" @click="modalOpen = false" class="inline-flex justify-center items-center rounded-xl bg-orange-600 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-orange-700 transition focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-1">
                                    Tutup Keterangan
                                </button>
                                <a :href="'{{ route('guru.evaluasi.index') }}?penanaman_id=' + detailData.penanaman_id" class="text-sm font-bold text-blue-600 hover:text-blue-800 px-4 mr-auto underline underline-offset-4">Proses Rule-Based Decision Tree</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

    </div>

    <!-- Script Injection -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('panenGuruManager', () => ({
                modalOpen: false,
                detailData: {},
                openDetailModal(itemProps) {
                    this.detailData = itemProps;
                    this.modalOpen = true;
                }
            }));
        });
        
        // ChartJS Initializer
        document.addEventListener("DOMContentLoaded", function() {
            const ctxRatio = document.getElementById('ratioChart');
            if (ctxRatio) {
                // Determine responsive text styling for donut center 
                Chart.pluginService ? '' : Chart.register({
                    id: 'centerText',
                    beforeDraw: function(chart) {
                        if(chart.config.type !== 'doughnut') return;
                        var width = chart.width, height = chart.height, ctx = chart.ctx;
                        ctx.restore();
                        var fontSize = (height / 114).toFixed(2);
                        ctx.font = 'bold ' + fontSize + "em Inter";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#ffffff";
                        // Get total value
                        var sum = chart.config.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        var text = sum + " Proyek", textX = Math.round((width - ctx.measureText(text).width) / 2), textY = height / 2;
                        ctx.fillText(text, textX, textY);
                        ctx.save();
                    }
                });

                new Chart(ctxRatio.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Dominan Hidup', 'Dominan Mati'],
                        datasets: [{
                            data: [{{ $stats['dominan_hidup'] ?? 0 }}, {{ $stats['dominan_mati'] ?? 0 }}],
                            backgroundColor: ['rgba(16, 185, 129, 0.9)', 'rgba(239, 68, 68, 0.9)'],
                            borderWidth: 2,
                            borderColor: '#312e81', // indigo bg match
                            hoverOffset: 6
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '75%',
                        plugins: {
                            legend: { display: false }
                        }
                    }
                });
            }
        });
    </script>
</x-app-layout>
