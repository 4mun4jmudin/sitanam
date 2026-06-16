<x-app-layout>
    @php
        $role = strtolower(auth()->user()->role);
        $routeName = $role . '.evaluasi.index';
        $indexRoute = \Illuminate\Support\Facades\Route::has($routeName)
            ? route($routeName)
            : route('guru.evaluasi.index');
    @endphp

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Evaluasi Keputusan Panen Akhir') }}
                </h2>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Evaluasi Panen Akhir
                </div>
                <p class="text-sm text-gray-500 mt-2">
                    Proses evaluasi panen menggunakan metode Rule-Based Decision Tree berdasarkan data penanaman, pemeliharaan, dan panen.
                </p>
            </div>
        </div>
    </x-slot>

    <div x-data="evaluasiSistem()" class="max-w-7xl mx-auto space-y-8 pb-12">

        @if(session('success'))
            <div class="bg-indigo-50 border-l-4 border-indigo-500 text-indigo-800 p-4 rounded-r-xl flex items-start shadow-sm">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-bold">Evaluasi Berhasil!</h3>
                    <p class="text-sm text-indigo-700 mt-1 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-xl flex items-start shadow-sm">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-bold">Gagal Memproses Evaluasi</h3>
                    <p class="text-sm text-red-700 mt-1 font-medium">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-r-xl shadow-sm">
                <h3 class="text-sm font-bold mb-2">Terdapat Kesalahan:</h3>
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(isset($stats))
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-200">
                    <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-1">Total Evaluasi</p>
                    <h3 class="text-3xl font-extrabold text-gray-900">{{ $stats['total'] ?? 0 }}</h3>
                </div>

                <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl p-6 shadow-md border border-emerald-400">
                    <p class="text-[11px] font-bold text-emerald-100 uppercase tracking-wider mb-1">Berhasil</p>
                    <h3 class="text-3xl font-extrabold text-white">{{ $stats['berhasil'] ?? 0 }}</h3>
                </div>

                <div class="bg-gradient-to-br from-yellow-500 to-amber-500 rounded-2xl p-6 shadow-md border border-yellow-400">
                    <p class="text-[11px] font-bold text-yellow-100 uppercase tracking-wider mb-1">Cukup</p>
                    <h3 class="text-3xl font-extrabold text-white">{{ $stats['cukup'] ?? 0 }}</h3>
                </div>

                <div class="bg-gradient-to-br from-rose-500 to-rose-600 rounded-2xl p-6 shadow-md border border-rose-400">
                    <p class="text-[11px] font-bold text-rose-100 uppercase tracking-wider mb-1">Gagal</p>
                    <h3 class="text-3xl font-extrabold text-white">{{ $stats['gagal'] ?? 0 }}</h3>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 {{ isset($stats) ? 'xl:grid-cols-4' : '' }} gap-8">
            <div class="{{ isset($stats) ? 'xl:col-span-3' : 'w-full' }} space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-gray-50/50">
                        <h3 class="text-lg font-bold text-gray-900">
                            Monitoring Evaluasi Decision Tree
                        </h3>

                        <form action="{{ $indexRoute }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari siswa/tanaman..."
                                   class="w-full sm:w-64 py-2 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">

                            <select name="status_filter"
                                    class="w-full sm:w-auto py-2 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                <option value="">Semua Hasil</option>
                                <option value="Berhasil" {{ request('status_filter') === 'Berhasil' ? 'selected' : '' }}>Berhasil</option>
                                <option value="Cukup" {{ request('status_filter') === 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                <option value="Gagal" {{ request('status_filter') === 'Gagal' ? 'selected' : '' }}>Gagal</option>
                            </select>

                            <select name="per_page"
                                    class="w-full sm:w-auto py-2 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                <option value="10" {{ request('per_page') == '10' ? 'selected' : '' }}>10 Data</option>
                                <option value="20" {{ request('per_page') == '20' ? 'selected' : '' }}>20 Data</option>
                                <option value="50" {{ request('per_page') == '50' ? 'selected' : '' }}>50 Data</option>
                                <option value="100" {{ request('per_page') == '100' ? 'selected' : '' }}>100 Data</option>
                                <option value="all" {{ request('per_page') === 'all' ? 'selected' : '' }}>Semua Data</option>
                            </select>

                            <button type="submit"
                                    class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition">
                                Filter
                            </button>
                        </form>
                    </div>

                    <div class="overflow-x-auto w-full">
                        <table class="w-full text-left border-collapse whitespace-nowrap">
                            <thead>
                                <tr class="bg-white border-b border-gray-100 text-gray-400 text-[10px] uppercase tracking-widest font-extrabold">
                                    <th class="p-4 pl-6 text-center w-12 border-r border-gray-50">No</th>
                                    <th class="p-4">Identitas Proyek</th>
                                    <th class="p-4">Data Panen</th>
                                    @if($role === 'guru')
                                        <th class="p-4">Faktor Utama</th>
                                    @endif
                                    <th class="p-4 text-center border-l border-gray-50">Status / Hasil</th>
                                    <th class="p-4 text-center pr-6 bg-indigo-50/20">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-50">
                                @forelse($penanamans as $idx => $item)
                                    @php
                                        $namaSiswa = $item->siswa->name ?? 'N/A';
                                        $namaTanaman = $item->jenisTanaman->nama_tanaman ?? $item->jenis_tanaman ?? '-';

                                        $hasilPanen = $item->panen->jumlah_hasil_panen ?? $item->panen->bobot_panen ?? null;
                                        $satuanPanen = $item->panen->satuan_hasil_panen ?? $item->target_panen_satuan ?? 'Kg';
                                        $bobotKg = $item->panen->bobot_panen_kg ?? $item->panen->bobot_panen ?? null;

                                        $status = $item->status_evaluasi ?? 'Data Awal Kurang';

                                        $statusClass = 'bg-gray-100 text-gray-600 border-gray-200';
                                        if($status === 'Siap Evaluasi') $statusClass = 'bg-blue-100 text-blue-700 border-blue-300';
                                        elseif($status === 'Menunggu Panen') $statusClass = 'bg-orange-100 text-orange-700 border-orange-300';
                                        elseif($status === 'Menunggu Pemeliharaan') $statusClass = 'bg-yellow-100 text-yellow-700 border-yellow-300';
                                        elseif($status === 'Data Awal Kurang') $statusClass = 'bg-red-100 text-red-700 border-red-300';
                                        elseif($status === 'Sudah Dievaluasi') $statusClass = 'bg-emerald-100 text-emerald-700 border-emerald-300';

                                        $faktor = [];
                                        $rekomendasi = [];
                                        $rincian = [];

                                        if($item->evaluasi) {
                                            $faktor = $item->evaluasi->faktor_utama ?? [];
                                            $rekomendasi = $item->evaluasi->rekomendasi ?? [];
                                            $rincian = $item->evaluasi->rincian_aturan ?? [];

                                            if(is_string($faktor)) $faktor = json_decode($faktor, true) ?: [$faktor];
                                            if(is_string($rekomendasi)) $rekomendasi = json_decode($rekomendasi, true) ?: [$rekomendasi];
                                            if(is_string($rincian)) $rincian = json_decode($rincian, true) ?: [];
                                        }

                                        $modalPayload = [
                                            'siswa' => $namaSiswa,
                                            'tanaman' => $namaTanaman,
                                            'jml_bibit' => $item->jml_bibit,
                                            'target' => $item->target_panen_jumlah ?? $item->target_panen_kg ?? 0,
                                            'satuan_target' => $item->target_panen_satuan ?? 'Kg',
                                            'panen' => [
                                                'hasil' => $hasilPanen,
                                                'satuan' => $satuanPanen,
                                                'bobot_kg' => $bobotKg,
                                                'tanaman_hidup' => $item->panen->tanaman_hidup ?? 0,
                                                'tanaman_mati' => $item->panen->tanaman_mati ?? 0,
                                                'tgl_panen' => $item->panen->tgl_panen ?? null,
                                            ],
                                            'evaluasi' => $item->evaluasi ? [
                                                'hasil_klasifikasi' => $item->evaluasi->hasil_klasifikasi,
                                                'skor' => $item->evaluasi->skor,
                                                'persentase_hidup' => $item->evaluasi->persentase_hidup,
                                                'persentase_hasil' => $item->evaluasi->persentase_hasil,
                                                'tingkat_hama_terberat' => $item->evaluasi->tingkat_hama_terberat,
                                                'kondisi_risiko_terburuk' => $item->evaluasi->kondisi_risiko_terburuk,
                                                'faktor_utama' => $faktor,
                                                'rekomendasi' => $rekomendasi,
                                                'rincian_aturan' => $rincian,
                                                'evaluated_by' => $item->evaluasi->evaluator->name ?? 'Guru',
                                                'evaluated_at' => optional($item->evaluasi->evaluated_at)->format('Y-m-d H:i:s'),
                                            ] : null,
                                        ];
                                    @endphp

                                    <tr class="hover:bg-indigo-50/20 transition-colors group">
                                        <td class="p-4 pl-6 text-center text-gray-400 font-medium text-sm border-r border-gray-50">
                                            {{ method_exists($penanamans, 'firstItem') ? $penanamans->firstItem() + $idx : $idx + 1 }}
                                        </td>

                                        <td class="p-4">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-9 h-9 rounded-full bg-gray-100 text-gray-700 flex items-center justify-center font-bold text-sm border border-gray-200">
                                                    {{ substr($namaSiswa, 0, 1) }}
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $namaSiswa }}</p>
                                                    <p class="text-xs text-indigo-600 font-semibold mt-0.5">{{ $namaTanaman }}</p>
                                                    <p class="text-[10px] text-gray-400">
                                                        Bibit: {{ $item->jml_bibit }} |
                                                        Target: {{ $item->target_panen_jumlah ?? $item->target_panen_kg ?? '-' }} {{ $item->target_panen_satuan ?? 'Kg' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="p-4">
                                            @if($item->panen)
                                                <p class="font-bold text-gray-700 text-sm border border-gray-200 inline-flex items-center px-2 py-0.5 rounded shadow-sm">
                                                    {{ $hasilPanen }} {{ $satuanPanen }}
                                                </p>
                                                @if($satuanPanen !== 'Kg')
                                                    <p class="text-[10px] text-gray-400 mt-1">
                                                        Konversi: {{ $bobotKg }} Kg
                                                    </p>
                                                @endif
                                                <p class="text-xs text-gray-400 mt-1 font-medium">
                                                    {{ \Carbon\Carbon::parse($item->panen->tgl_panen)->translatedFormat('d F Y') }}
                                                </p>
                                            @else
                                                Belum panen
                                            @endif
                                        </td>

                                        @if($role === 'guru')
                                            <td class="p-4">
                                                @if($item->evaluasi && count($faktor))
                                                    
                                                          title="{{ implode(', ', $faktor) }}">
                                                        {{ $faktor[0] ?? '-' }}
                                                    
                                                @else
                                                    Belum dievaluasi
                                                @endif
                                            </td>
                                        @endif

                                        <td class="p-4 text-center border-l border-gray-50">
                                            @if(!$item->evaluasi)
                                                
                                                    {{ $status }}
                                                
                                                <div class="text-[9px] text-gray-400 mt-1">Belum ada hasil evaluasi</div>
                                            @else
                                                @php
                                                    $klas = $item->evaluasi->hasil_klasifikasi;
                                                    $badge = 'bg-gray-100 text-gray-600 border-gray-200';

                                                    if($klas === 'Berhasil') $badge = 'bg-emerald-100 text-emerald-700 border-emerald-300';
                                                    elseif($klas === 'Cukup') $badge = 'bg-yellow-100 text-yellow-700 border-yellow-300';
                                                    elseif($klas === 'Gagal') $badge = 'bg-red-100 text-red-700 border-red-300';
                                                @endphp

                                                <div class="flex flex-col items-center justify-center">
                                                    
                                                        {{ $klas }}
                                                    
                                                    
                                                        Skor: {{ $item->evaluasi->skor ?? 0 }}
                                                    
                                                </div>
                                            @endif
                                        </td>

                                        <td class="p-4 pr-6 text-center bg-indigo-50/10">
                                            @if(!$item->evaluasi && $role === 'guru' && $status === 'Siap Evaluasi')
                                                <form action="{{ route('guru.evaluasi.proses') }}" method="POST"
                                                      onsubmit="return confirm('Proses evaluasi Rule-Based Decision Tree untuk data ini?')">
                                                    @csrf
                                                    <input type="hidden" name="penanaman_id" value="{{ $item->id }}">
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700 transition">
                                                        Proses Decision Tree
                                                    </button>
                                                </form>
                                            @elseif(!$item->evaluasi)
                                                
                                                    {{ $status }}
                                                
                                            @else
                                                <button @click='openDetailModal(@js($modalPayload))'
                                                        type="button"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg border border-indigo-200 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 text-xs font-bold transition">
                                                    Detail Evaluasi
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ $role === 'guru' ? 6 : 5 }}" class="p-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mb-4">
                                                    <svg class="w-10 h-10 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                </div>
                                                <h3 class="text-base font-bold text-gray-800">Data evaluasi kosong.</h3>
                                                <p class="text-sm text-gray-500 mt-1 max-w-sm">
                                                    Belum ada data penanaman yang tersedia untuk proses evaluasi.
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if(method_exists($penanamans, 'hasPages') && $penanamans->hasPages())
                        <div class="p-5 border-t border-gray-100 bg-gray-50/80">
                            {{ $penanamans->links() }}
                        </div>
                    @endif
                </div>
            </div>

            @if(isset($stats))
                <div class="xl:col-span-1 space-y-6">
                    <div class="bg-indigo-600 rounded-2xl shadow-lg border border-indigo-700 p-6 flex flex-col items-center relative overflow-hidden">
                        <h3 class="text-xs font-bold text-indigo-200 w-full mb-6 border-b border-indigo-500/50 pb-2 uppercase tracking-wide">
                            Rule-Based Decision Tree
                        </h3>

                        <div class="relative w-full aspect-square max-h-48 mb-4">
                            <canvas id="evalChart"></canvas>
                        </div>

                        <p class="text-xs text-indigo-200 text-center">
                            Komparasi hasil klasifikasi Berhasil, Cukup, dan Gagal.
                        </p>
                    </div>

                    <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
                        <h4 class="text-xs font-extrabold text-gray-500 uppercase tracking-widest mb-4">
                            Ringkasan
                        </h4>

                        <div class="space-y-4">
                            <div class="flex items-center space-x-3 bg-emerald-50 rounded-xl p-3 border border-emerald-100">
                                <div>
                                    <p class="text-[10px] font-bold text-emerald-600 uppercase">Tanaman Terbaik</p>
                                    <p class="text-sm font-bold text-gray-900 leading-tight">
                                        {{ $stats['tanaman_terbaik'] ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 bg-amber-50 rounded-xl p-3 border border-amber-100">
                                <div>
                                    <p class="text-[10px] font-bold text-amber-600 uppercase">Rekor Panen Tertinggi</p>
                                    <p class="text-sm font-bold text-gray-900 leading-tight">
                                        {{ $stats['rekor_panen'] ?? 0 }} Kg
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 bg-indigo-50 rounded-xl p-3 border border-indigo-100">
                                <div>
                                    <p class="text-[10px] font-bold text-indigo-600 uppercase">Success Rate</p>
                                    <p class="text-sm font-bold text-gray-900 leading-tight">
                                        {{ $stats['persentase'] ?? 0 }}%
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <template x-teleport="body">
            <div x-show="modalOpen" x-cloak class="relative z-[100]">
                <div x-show="modalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm"></div>

                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                        <div x-show="modalOpen"
                             x-transition
                             @click.outside="modalOpen = false"
                             class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-100">

                            <div class="bg-gray-50 flex flex-col h-full">
                                <div class="bg-slate-900 px-6 py-5 flex justify-between items-center text-white border-b-4 border-indigo-500">
                                    <div>
                                        <h3 class="text-xl font-black tracking-tight text-white leading-none">
                                            Detail Evaluasi Decision Tree
                                        </h3>
                                        <p class="text-indigo-300 text-xs mt-1 font-mono uppercase tracking-widest">
                                            Jalur Aturan Keputusan
                                        </p>
                                    </div>

                                    <button type="button"
                                            @click="modalOpen = false"
                                            class="text-slate-400 hover:text-white transition bg-slate-800 p-2 rounded-xl border border-slate-700 hover:bg-slate-700">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6 bg-gray-50">
                                    <div class="col-span-1 space-y-4">
                                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 text-center">
                                            <div class="w-16 h-16 rounded-full bg-slate-100 border-2 border-slate-200 flex items-center justify-center text-2xl font-bold text-slate-700 mx-auto mb-2"
                                                 x-text="activeData.siswa ? activeData.siswa[0] : 'U'"></div>
                                            <h4 class="font-bold text-gray-900" x-text="activeData.siswa"></h4>
                                            
                                                  x-text="activeData.tanaman">
                                        </div>

                                        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                            <h5 class="text-xs font-bold text-gray-800 uppercase mb-3">Ringkasan Data</h5>
                                            <div class="space-y-2 text-sm">
                                                <div class="flex justify-between">
                                                    Bibit Awal
                                                    
                                                </div>
                                                <div class="flex justify-between">
                                                    Target
                                                    
                                                        
                                                        
                                                    
                                                </div>
                                                <div class="flex justify-between">
                                                    Hasil Panen
                                                    
                                                        
                                                        
                                                    
                                                </div>
                                                <div class="flex justify-between">
                                                    Konversi Kg
                                                    
                                                </div>
                                                <div class="flex justify-between">
                                                    Hidup / Mati
                                                    
                                                        
                                                        /
                                                        
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-1 md:col-span-2 space-y-4">
                                        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between">
                                            <div>
                                                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Keputusan Akhir</p>
                                                <h2 class="text-2xl font-black"
                                                    :class="aiData.hasil_klasifikasi === 'Berhasil' ? 'text-emerald-600' : (aiData.hasil_klasifikasi === 'Cukup' ? 'text-yellow-600' : 'text-red-600')"
                                                    x-text="aiData.hasil_klasifikasi"></h2>

                                                <div class="mt-3 text-xs text-gray-500 bg-gray-50 border border-gray-100 rounded-lg p-2 inline-block">
                                                    <div>
                                                        Dievaluasi Oleh:
                                                        
                                                    </div>
                                                    <div>
                                                        Waktu:
                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="w-20 h-20 rounded-full border-[5px] flex items-center justify-center shadow-inner"
                                                 :class="aiData.hasil_klasifikasi === 'Berhasil' ? 'border-emerald-50 bg-emerald-500' : (aiData.hasil_klasifikasi === 'Cukup' ? 'border-yellow-50 bg-yellow-500' : 'border-red-50 bg-red-500')">
                                                
                                            </div>
                                        </div>

                                        <div class="bg-slate-900 rounded-xl shadow-sm border border-slate-800 p-5">
                                            <h4 class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-4">
                                                Jalur Aturan Decision Tree
                                            </h4>

                                            <div class="bg-white/5 border border-white/10 rounded-lg p-4 space-y-3">
                                                <div class="flex justify-between border-b border-white/10 pb-2">
                                                    Persentase Hidup
                                                    
                                                </div>

                                                <div class="flex justify-between border-b border-white/10 pb-2">
                                                    Persentase Hasil
                                                    
                                                </div>

                                                <div class="flex justify-between border-b border-white/10 pb-2">
                                                    Hama Terberat
                                                    
                                                </div>

                                                <div class="flex justify-between border-b border-white/10 pb-2">
                                                    Risiko Pertumbuhan
                                                    
                                                </div>

                                                <div class="flex flex-col border-b border-white/10 pb-2">
                                                    Rule Terpakai
                                                    
                                                </div>

                                                <div class="flex justify-between pt-1">
                                                    Keputusan
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <div class="bg-white p-4 rounded-xl shadow-sm border border-indigo-100">
                                            <h4 class="text-xs font-bold text-gray-800 uppercase tracking-widest mb-3">
                                                Faktor Utama
                                            </h4>
                                            <div class="space-y-2">
                                                <template x-for="faktor in aiData.faktor_utama">
                                                    <p class="text-sm text-gray-600 font-medium">• </p>
                                                </template>
                                            </div>
                                        </div>

                                        <div class="bg-white p-4 rounded-xl shadow-sm border border-indigo-100">
                                            <h4 class="text-xs font-bold text-gray-800 uppercase tracking-widest mb-3">
                                                Rekomendasi Sistem
                                            </h4>
                                            <div class="space-y-2">
                                                <template x-for="rec in aiData.rekomendasi">
                                                    <p class="text-sm text-gray-600 font-medium">• </p>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-gray-100 border-t border-gray-200 px-6 py-4 flex justify-end rounded-b-2xl">
                                    <button type="button"
                                            @click="modalOpen = false"
                                            class="rounded-xl bg-slate-800 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-slate-900 transition">
                                        Tutup Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('evaluasiSistem', () => ({
                modalOpen: false,
                activeData: {},
                aiData: {
                    hasil_klasifikasi: '-',
                    skor: 0,
                    persentase_hidup: 0,
                    persentase_hasil: 0,
                    tingkat_hama_terberat: '-',
                    kondisi_risiko_terburuk: '-',
                    faktor_utama: [],
                    rekomendasi: [],
                    rincian_aturan: {},
                    evaluated_by: '-',
                    evaluated_at: '-',
                },

                openDetailModal(payload) {
                    this.activeData = payload || {};

                    const evaluasi = payload.evaluasi || {};

                    this.aiData = {
                        hasil_klasifikasi: evaluasi.hasil_klasifikasi || '-',
                        skor: evaluasi.skor || 0,
                        persentase_hidup: evaluasi.persentase_hidup || 0,
                        persentase_hasil: evaluasi.persentase_hasil || 0,
                        tingkat_hama_terberat: evaluasi.tingkat_hama_terberat || '-',
                        kondisi_risiko_terburuk: evaluasi.kondisi_risiko_terburuk || '-',
                        faktor_utama: Array.isArray(evaluasi.faktor_utama) ? evaluasi.faktor_utama : [],
                        rekomendasi: Array.isArray(evaluasi.rekomendasi) ? evaluasi.rekomendasi : [],
                        rincian_aturan: evaluasi.rincian_aturan || {},
                        evaluated_by: evaluasi.evaluated_by || '-',
                        evaluated_at: evaluasi.evaluated_at || '-',
                    };

                    this.modalOpen = true;
                },
            }));
        });

        document.addEventListener("DOMContentLoaded", function() {
            @if(isset($stats))
                const ctxEval = document.getElementById('evalChart');

                if (ctxEval) {
                    new Chart(ctxEval.getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: ['Berhasil', 'Cukup', 'Gagal'],
                            datasets: [{
                                data: [
                                    {{ $stats['berhasil'] ?? 0 }},
                                    {{ $stats['cukup'] ?? 0 }},
                                    {{ $stats['gagal'] ?? 0 }}
                                ],
                                backgroundColor: ['#10B981', '#EAB308', '#F43F5E'],
                                borderWidth: 2,
                                borderColor: '#4f46e5',
                                hoverOffset: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: '#e0e7ff',
                                        boxWidth: 10,
                                        font: { family: 'Inter', size: 10 }
                                    }
                                }
                            }
                        }
                    });
                }
            @endif
        });
    </script>
</x-app-layout>