@extends('layouts.app')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Detail Evaluasi Panen</h2>
            <p class="text-sm text-gray-500 mt-1">Siswa: {{ $penanaman->siswa->name }}</p>
        </div>
        <a href="{{ url()->previous() }}" class="px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50">
            Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Kolom Kiri: Info Data -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Informasi Penanaman -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Proyek Tanam</h3>
            <div class="grid grid-cols-2 gap-4">
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
                    <p class="text-sm text-gray-500">Jumlah Bibit Awal</p>
                    <p class="font-semibold text-gray-900">{{ $penanaman->jml_bibit }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Target Panen (Kg)</p>
                    <p class="font-semibold text-gray-900">{{ $penanaman->target_panen_kg ?? '-' }}</p>
                </div>
            </div>
        </div>

        @if($penanaman->evaluasi)
        <!-- Hasil Evaluasi Decision Tree -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 p-6 text-white">
                <h3 class="text-xl font-bold mb-1">Hasil Evaluasi Klasifikasi</h3>
                <p class="text-emerald-100 text-sm">Algoritma: {{ $penanaman->evaluasi->metode_algoritma }} ({{ $penanaman->evaluasi->versi_algoritma }})</p>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between mb-8 pb-6 border-b border-gray-100">
                    <div>
                        <p class="text-sm text-gray-500 font-medium mb-1">Keputusan Akhir</p>
                        @php
                            $hasil = $penanaman->evaluasi->hasil_klasifikasi;
                            $colorClass = match($hasil) {
                                'Berhasil' => 'text-emerald-600 bg-emerald-50 border-emerald-200',
                                'Cukup' => 'text-yellow-600 bg-yellow-50 border-yellow-200',
                                'Gagal' => 'text-red-600 bg-red-50 border-red-200',
                                default => 'text-gray-600 bg-gray-50 border-gray-200'
                            };
                        @endphp
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-lg font-bold border {{ $colorClass }}">
                            {{ $hasil }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500 font-medium mb-1">Skor Kinerja</p>
                        <span class="text-3xl font-black text-gray-900">{{ $penanaman->evaluasi->skor }}</span><span class="text-gray-400">/100</span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6 mb-8">
                    <!-- Metrik Kunci -->
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100">
                        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Metrik Kunci</h4>
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Persentase Tanaman Hidup</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $penanaman->evaluasi->persentase_hidup }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min($penanaman->evaluasi->persentase_hidup, 100) }}%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">Persentase Hasil Target</span>
                                    <span class="text-sm font-bold text-gray-900">{{ $penanaman->evaluasi->persentase_hasil }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-purple-500 h-2 rounded-full" style="width: {{ min($penanaman->evaluasi->persentase_hasil, 100) }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Jalur Aturan -->
                    <div class="bg-orange-50 rounded-xl p-5 border border-orange-100">
                        <h4 class="text-xs font-bold text-orange-400 uppercase tracking-wider mb-3">Jalur Aturan Keputusan</h4>
                        <p class="text-sm text-orange-900 italic font-medium">
                            "{{ $penanaman->evaluasi->rincian_aturan['rule_terpakai'] ?? $penanaman->evaluasi->rincian_aturan['rule'] ?? 'Aturan tidak tercatat' }}"
                        </p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Faktor Utama -->
                    <div>
                        <h4 class="flex items-center text-sm font-bold text-gray-800 mb-3">
                            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Faktor Utama Penentu
                        </h4>
                        <ul class="space-y-2">
                            @foreach($penanaman->evaluasi->faktor_utama ?? [] as $faktor)
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 w-1.5 h-1.5 rounded-full bg-blue-500 mt-2 mr-2"></span>
                                    <span class="text-sm text-gray-700">{{ $faktor }}</span>
                                </li>
                            @endforeach
                            @empty($penanaman->evaluasi->faktor_utama)
                                <li class="text-sm text-gray-500 italic">Belum ada faktor utama yang tercatat.</li>
                            @endempty
                        </ul>
                    </div>

                    <!-- Rekomendasi -->
                    <div>
                        <h4 class="flex items-center text-sm font-bold text-gray-800 mb-3">
                            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Rekomendasi Tindakan
                        </h4>
                        <ul class="space-y-2">
                            @foreach($penanaman->evaluasi->rekomendasi ?? [] as $rek)
                                <li class="flex items-start">
                                    <span class="flex-shrink-0 w-1.5 h-1.5 rounded-full bg-emerald-500 mt-2 mr-2"></span>
                                    <span class="text-sm text-gray-700">{{ $rek }}</span>
                                </li>
                            @endforeach
                            @empty($penanaman->evaluasi->rekomendasi)
                                <li class="text-sm text-gray-500 italic">Belum ada rekomendasi yang diberikan.</li>
                            @endempty
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="bg-gray-50 border border-dashed border-gray-300 rounded-xl p-10 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Evaluasi Belum Diproses</h3>
            <p class="text-sm text-gray-500 max-w-sm mx-auto">
                @if($role === 'guru')
                    Data ini belum dievaluasi. Silakan penuhi checklist kesiapan di samping, lalu klik tombol "Proses Evaluasi Panen".
                @else
                    Guru belum memproses evaluasi untuk proyek tanam ini.
                @endif
            </p>
        </div>
        @endif

    </div>

    <!-- Kolom Kanan: Checklist & Action -->
    <div class="space-y-6">
        
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-6 sticky top-24">
            <h3 class="text-base font-bold text-gray-800 mb-4 border-b pb-2">Checklist Kesiapan Evaluasi</h3>
            
            <ul class="space-y-3 mb-6">
                <li class="flex items-center text-sm {{ $checklist['data_penanaman'] ? 'text-emerald-700' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 mr-2 {{ $checklist['data_penanaman'] ? 'text-emerald-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Data penanaman tersedia
                </li>
                <li class="flex items-center text-sm {{ $checklist['jml_bibit'] ? 'text-emerald-700' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 mr-2 {{ $checklist['jml_bibit'] ? 'text-emerald-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Jumlah bibit > 0
                </li>
                <li class="flex items-center text-sm {{ $checklist['target_panen'] ? 'text-emerald-700' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 mr-2 {{ $checklist['target_panen'] ? 'text-emerald-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Target panen > 0
                </li>
                <li class="flex items-center text-sm {{ $checklist['pemeliharaan'] ? 'text-emerald-700' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 mr-2 {{ $checklist['pemeliharaan'] ? 'text-emerald-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Minimal 1 data pemeliharaan
                </li>
                <li class="flex items-center text-sm {{ $checklist['kondisi_daun'] ? 'text-emerald-700' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 mr-2 {{ $checklist['kondisi_daun'] ? 'text-emerald-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Kondisi daun tersedia
                </li>
                <li class="flex items-center text-sm {{ $checklist['tingkat_hama'] ? 'text-emerald-700' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 mr-2 {{ $checklist['tingkat_hama'] ? 'text-emerald-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Tingkat hama tersedia
                </li>
                <li class="flex items-center text-sm {{ $checklist['bobot_panen'] ? 'text-emerald-700' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 mr-2 {{ $checklist['bobot_panen'] ? 'text-emerald-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Bobot panen tersedia
                </li>
                <li class="flex items-center text-sm {{ $checklist['data_panen'] ? 'text-emerald-700' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 mr-2 {{ $checklist['data_panen'] ? 'text-emerald-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Data panen tercatat
                </li>
                <li class="flex items-center text-sm {{ $checklist['panen_valid'] ? 'text-emerald-700' : 'text-gray-500' }}">
                    <svg class="w-5 h-5 mr-2 {{ $checklist['panen_valid'] ? 'text-emerald-500' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    Tanaman hidup + mati valid
                </li>
            </ul>

            @if($role === 'guru')
                <div class="mt-6 border-t pt-4">
                    <form action="{{ route('guru.evaluasi.proses') }}" method="POST">
                        @csrf
                        <input type="hidden" name="penanaman_id" value="{{ $penanaman->id }}">
                        
                        <button type="submit" 
                                class="w-full py-3 px-4 rounded-xl font-bold text-white transition-all shadow-md 
                                {{ $isReady ? 'bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700' : 'bg-gray-400 cursor-not-allowed shadow-none' }}"
                                {{ !$isReady ? 'disabled' : '' }}>
                            Proses Evaluasi Panen
                        </button>
                        
                        @if(!$isReady)
                            <p class="text-xs text-red-500 text-center mt-3">Silakan lengkapi data (checklist) sebelum memproses evaluasi.</p>
                        @elseif($penanaman->evaluasi)
                            <p class="text-xs text-gray-500 text-center mt-3">Tombol ini akan memproses ulang data evaluasi jika terdapat perubahan pada data pemeliharaan atau panen.</p>
                        @endif
                    </form>
                </div>
            @else
                <div class="mt-4 p-3 bg-blue-50 rounded-lg border border-blue-100 text-sm text-blue-800 text-center">
                    Hanya Guru yang memiliki hak untuk memproses atau mengubah evaluasi.
                </div>
            @endif

        </div>
        
    </div>
</div>
@endsection
