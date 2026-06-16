@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Proyek Tanam</h2>
            <p class="text-sm text-gray-500 mt-1">Siswa: {{ $penanaman->siswa->name }}</p>
        </div>
        <a href="{{ route($role.'.penanaman.index') }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
            Kembali
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden" x-data="{ tab: 'penanaman' }">
    <!-- Tab Navigation -->
    <div class="border-b border-gray-200 bg-gray-50">
        <nav class="flex -mb-px px-6" aria-label="Tabs">
            <button @click="tab = 'penanaman'"
                :class="{'border-blue-500 text-blue-600': tab === 'penanaman', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'penanaman'}"
                class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors">
                Data Penanaman
            </button>
            <button @click="tab = 'pemeliharaan'"
                :class="{'border-blue-500 text-blue-600': tab === 'pemeliharaan', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'pemeliharaan'}"
                class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors">
                Pemeliharaan <span class="ml-1 bg-gray-100 text-gray-600 py-0.5 px-2 rounded-full text-xs">{{ $penanaman->pemeliharaans->count() }}</span>
            </button>
            <button @click="tab = 'panen'"
                :class="{'border-blue-500 text-blue-600': tab === 'panen', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'panen'}"
                class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors">
                Data Panen
            </button>
            <button @click="tab = 'evaluasi'"
                :class="{'border-blue-500 text-blue-600': tab === 'evaluasi', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'evaluasi'}"
                class="w-1/4 py-4 px-1 text-center border-b-2 font-medium text-sm transition-colors">
                Hasil Evaluasi
            </button>
        </nav>
    </div>

    <!-- Tab Contents -->
    <div class="p-6">
        
        <!-- Tab: Data Penanaman -->
        <div x-show="tab === 'penanaman'" class="space-y-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-2">Informasi Penanaman Awal</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Jenis Tanaman</p>
                    <p class="font-semibold text-gray-900">{{ $penanaman->jenis_tanaman }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Lokasi Lahan</p>
                    <p class="font-semibold text-gray-900">{{ $penanaman->lokasi_lahan }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Tanam</p>
                    <p class="font-semibold text-gray-900">{{ $penanaman->tgl_tanam->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Kondisi Tanah</p>
                    <p class="font-semibold text-gray-900">{{ $penanaman->kondisi_tanah ?? '-' }}</p>
                </div>
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-600 font-medium">Jumlah Bibit Awal</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $penanaman->jml_bibit }}</p>
                </div>
                <div class="bg-purple-50 p-4 rounded-lg">
                    <p class="text-sm text-purple-600 font-medium">Target Panen (Kg)</p>
                    <p class="text-2xl font-bold text-purple-900">{{ $penanaman->target_panen_kg ?? '-' }} <span class="text-lg font-normal">kg</span></p>
                </div>
            </div>
        </div>

        <!-- Tab: Pemeliharaan -->
        <div x-show="tab === 'pemeliharaan'" style="display: none;">
            <div class="flex justify-between items-center border-b pb-2 mb-4">
                <h3 class="text-lg font-bold text-gray-800">Catatan Pemeliharaan Mingguan</h3>
            </div>
            
            @if($penanaman->pemeliharaans->isEmpty())
                <div class="text-center py-8 text-gray-500 italic">Belum ada data pemeliharaan yang dicatat.</div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3">Minggu Ke</th>
                                <th class="px-4 py-3">Tanggal Catat</th>
                                <th class="px-4 py-3">Tinggi (cm)</th>
                                <th class="px-4 py-3 text-center">Hidup/Mati</th>
                                <th class="px-4 py-3">Kondisi Daun</th>
                                <th class="px-4 py-3">Tingkat Hama</th>
                                <th class="px-4 py-3">Kegiatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penanaman->pemeliharaans as $p)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-bold text-gray-900">{{ $p->minggu_ke }}</td>
                                <td class="px-4 py-3">{{ $p->tanggal_catat->format('d M Y') }}</td>
                                <td class="px-4 py-3">{{ $p->tinggi_tanaman }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="text-emerald-600 font-bold">{{ $p->jml_hidup }}</span> / 
                                    <span class="text-red-600 font-bold">{{ $p->jml_mati }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $p->kondisi_daun === 'Sehat' ? 'bg-emerald-100 text-emerald-800' : ($p->kondisi_daun === 'Menguning' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ $p->kondisi_daun }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-xs font-medium 
                                        {{ $p->tingkat_hama === 'Tidak Ada' ? 'bg-emerald-100 text-emerald-800' : ($p->tingkat_hama === 'Ringan' ? 'bg-yellow-100 text-yellow-800' : ($p->tingkat_hama === 'Sedang' ? 'bg-orange-100 text-orange-800' : 'bg-red-100 text-red-800')) }}">
                                        {{ $p->tingkat_hama }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 max-w-xs truncate">{{ $p->kegiatan }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Tab: Panen -->
        <div x-show="tab === 'panen'" style="display: none;" class="space-y-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-2">Laporan Hasil Panen</h3>
            
            @if($penanaman->panen)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Panen</p>
                        <p class="font-semibold text-gray-900">{{ $penanaman->panen->tgl_panen->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Durasi Tanam</p>
                        <p class="font-semibold text-gray-900">{{ $penanaman->panen->tgl_panen->diffInDays($penanaman->tgl_tanam) }} Hari</p>
                    </div>
                    <div class="bg-emerald-50 p-4 rounded-lg">
                        <p class="text-sm text-emerald-600 font-medium">Tanaman Hidup (Dipanen)</p>
                        <p class="text-2xl font-bold text-emerald-900">{{ $penanaman->panen->tanaman_hidup }} <span class="text-lg font-normal text-emerald-700">/ {{ $penanaman->jml_bibit }}</span></p>
                    </div>
                    <div class="bg-red-50 p-4 rounded-lg">
                        <p class="text-sm text-red-600 font-medium">Tanaman Mati</p>
                        <p class="text-2xl font-bold text-red-900">{{ $penanaman->panen->tanaman_mati }} <span class="text-lg font-normal text-red-700">/ {{ $penanaman->jml_bibit }}</span></p>
                    </div>
                    <div class="md:col-span-2 bg-gradient-to-br from-yellow-50 to-orange-50 p-6 rounded-xl border border-yellow-100 text-center">
                        <p class="text-sm text-yellow-800 font-medium mb-1">Total Bobot Panen</p>
                        <p class="text-4xl font-black text-yellow-600">{{ $penanaman->panen->bobot_panen }} <span class="text-xl font-bold">Kg</span></p>
                        @if($penanaman->target_panen_kg)
                            <p class="text-sm mt-2 font-medium {{ $penanaman->panen->bobot_panen >= $penanaman->target_panen_kg ? 'text-emerald-600' : 'text-red-500' }}">
                                Target: {{ $penanaman->target_panen_kg }} Kg 
                                ({{ number_format(($penanaman->panen->bobot_panen / $penanaman->target_panen_kg) * 100, 1) }}%)
                            </p>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <p class="text-gray-500 mb-2">Tanaman ini belum dipanen.</p>
                </div>
            @endif
        </div>

        <!-- Tab: Evaluasi -->
        <div x-show="tab === 'evaluasi'" style="display: none;" class="space-y-6">
            
            @if($penanaman->evaluasi)
                <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6 rounded-xl text-white shadow-md mb-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-emerald-100 text-sm mb-1">Hasil Keputusan Sistem</p>
                            <h3 class="text-3xl font-black">{{ $penanaman->evaluasi->hasil_klasifikasi }}</h3>
                        </div>
                        <div class="text-right">
                            <p class="text-emerald-100 text-sm mb-1">Skor Kinerja</p>
                            <span class="text-3xl font-black">{{ $penanaman->evaluasi->skor }}</span><span class="text-emerald-200">/100</span>
                        </div>
                    </div>
                </div>
                
                <div class="text-center">
                    <a href="{{ route($role.'.evaluasi.show', $penanaman->id) }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-all">
                        Lihat Rincian Analisa Decision Tree & Rekomendasi
                        <svg class="w-5 h-5 ml-2 -mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </a>
                </div>
            @else
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Evaluasi Belum Diproses</h3>
                    <p class="text-gray-500 mb-4">Proses evaluasi baru bisa dilakukan setelah masa panen selesai.</p>
                    <a href="{{ route($role.'.evaluasi.show', $penanaman->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                        Cek Kesiapan Evaluasi
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>

<!-- Add AlpineJS for simple tabs if not already included -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
