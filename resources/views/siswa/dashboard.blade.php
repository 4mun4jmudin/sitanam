<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Dashboard Siswa') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Catat proses budidaya tanamanmu dari penanaman, pemeliharaan, panen, hingga melihat hasil evaluasi guru.
                </p>
            </div>

            <div class="hidden md:flex items-center gap-2 rounded-2xl bg-emerald-50 border border-emerald-100 px-4 py-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold">
                    🌿
                </div>
                <div>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Status Siswa</p>
                    <p class="text-sm font-bold text-gray-800">Penginput Data Budidaya</p>
                </div>
            </div>
        </div>
    </x-slot>

    @php
        $totalPenanaman = $totalPenanaman ?? 0;
        $totalPemeliharaan = $totalPemeliharaan ?? 0;
        $totalPanen = $totalPanen ?? 0;
        $totalEvaluasi = $totalEvaluasi ?? 0;

        $penanamans = $penanamans ?? collect();
    @endphp

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- HERO --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 rounded-3xl shadow-lg shadow-emerald-500/20">
                <div class="absolute -right-20 -top-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-72 h-72 bg-lime-300/20 rounded-full blur-3xl"></div>

                <div class="relative z-10 p-8 md:p-10">
                    <div class="max-w-3xl">
                        <p class="text-xs font-black text-emerald-100 uppercase tracking-widest mb-3">
                            HawariFarm Student Panel
                        </p>

                        <h3 class="text-3xl md:text-4xl font-black text-white leading-tight">
                            Halo, {{ Auth::user()->name }} 🌱
                        </h3>

                        <p class="text-emerald-50 mt-3 leading-7 max-w-2xl">
                            Lengkapi data praktik pertanianmu secara bertahap. Data yang kamu isi akan dipantau guru dan diproses menggunakan Rule-Based Decision Tree setelah data panen lengkap.
                        </p>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('siswa.penanaman.index') }}"
                               class="inline-flex items-center justify-center rounded-xl bg-white text-emerald-700 px-5 py-3 text-sm font-bold hover:bg-emerald-50 transition">
                                Mulai Catat Penanaman
                            </a>

                            <a href="{{ route('siswa.evaluasi.index') }}"
                               class="inline-flex items-center justify-center rounded-xl bg-emerald-900/30 border border-white/30 text-white px-5 py-3 text-sm font-bold hover:bg-emerald-900/50 transition">
                                Lihat Status Evaluasi
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STATISTIK --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500">Total Penanaman</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">{{ $totalPenanaman }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Data awal tanaman yang sudah kamu catat.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-blue-100">
                    <p class="text-sm font-semibold text-blue-600">Catatan Pemeliharaan</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">{{ $totalPemeliharaan }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Riwayat monitoring tanaman mingguan.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
                    <p class="text-sm font-semibold text-orange-600">Catatan Panen</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">{{ $totalPanen }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Data hasil akhir panen yang sudah dicatat.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-purple-100">
                    <p class="text-sm font-semibold text-purple-600">Hasil Evaluasi</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">{{ $totalEvaluasi }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Hasil evaluasi yang sudah diproses guru.</p>
                </div>
            </div>

            {{-- ALUR SISTEM --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-7">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">
                            Alur Praktik Budidaya
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Ikuti urutan data agar evaluasi guru dapat diproses dengan benar.
                        </p>
                    </div>

                    <span class="inline-flex w-fit rounded-full bg-emerald-50 border border-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                        Siswa input data, guru proses evaluasi
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <a href="{{ route('siswa.penanaman.index') }}"
                       class="group rounded-2xl border border-emerald-100 bg-emerald-50/50 p-5 hover:bg-emerald-50 hover:-translate-y-1 transition">
                        <div class="w-11 h-11 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-black mb-4">
                            1
                        </div>
                        <h4 class="font-black text-gray-900">Penanaman</h4>
                        <p class="text-sm text-gray-500 mt-2">
                            Catat jenis tanaman, jumlah bibit, target panen, dan lokasi lahan.
                        </p>
                    </a>

                    <a href="{{ route('siswa.pemeliharaan.index') }}"
                       class="group rounded-2xl border border-blue-100 bg-blue-50/50 p-5 hover:bg-blue-50 hover:-translate-y-1 transition">
                        <div class="w-11 h-11 rounded-xl bg-blue-500 text-white flex items-center justify-center font-black mb-4">
                            2
                        </div>
                        <h4 class="font-black text-gray-900">Pemeliharaan</h4>
                        <p class="text-sm text-gray-500 mt-2">
                            Catat tinggi tanaman, jumlah hidup/mati, kondisi daun, hama, dan kegiatan perawatan.
                        </p>
                    </a>

                    <a href="{{ route('siswa.panen.index') }}"
                       class="group rounded-2xl border border-orange-100 bg-orange-50/50 p-5 hover:bg-orange-50 hover:-translate-y-1 transition">
                        <div class="w-11 h-11 rounded-xl bg-orange-500 text-white flex items-center justify-center font-black mb-4">
                            3
                        </div>
                        <h4 class="font-black text-gray-900">Panen</h4>
                        <p class="text-sm text-gray-500 mt-2">
                            Catat bobot panen akhir, tanaman hidup, dan tanaman mati.
                        </p>
                    </a>

                    <a href="{{ route('siswa.evaluasi.index') }}"
                       class="group rounded-2xl border border-purple-100 bg-purple-50/50 p-5 hover:bg-purple-50 hover:-translate-y-1 transition">
                        <div class="w-11 h-11 rounded-xl bg-purple-500 text-white flex items-center justify-center font-black mb-4">
                            4
                        </div>
                        <h4 class="font-black text-gray-900">Evaluasi</h4>
                        <p class="text-sm text-gray-500 mt-2">
                            Lihat hasil evaluasi setelah guru memproses Rule-Based Decision Tree.
                        </p>
                    </a>
                </div>
            </div>

            {{-- AKSI CEPAT --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-green-100 rounded-2xl flex items-center justify-center text-green-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-black text-gray-800 mb-2">Catat Penanaman</h4>
                    <p class="text-gray-500 text-sm mb-4">
                        Tambahkan data awal budidaya tanaman yang kamu tanam.
                    </p>
                    <a href="{{ route('siswa.penanaman.index') }}"
                       class="inline-flex items-center text-green-600 font-bold hover:text-green-700">
                        Buka Penanaman
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-black text-gray-800 mb-2">Catat Pemeliharaan</h4>
                    <p class="text-gray-500 text-sm mb-4">
                        Lengkapi perkembangan tanaman secara berkala.
                    </p>
                    <a href="{{ route('siswa.pemeliharaan.index') }}"
                       class="inline-flex items-center text-blue-600 font-bold hover:text-blue-700">
                        Buka Pemeliharaan
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-12 h-12 bg-orange-100 rounded-2xl flex items-center justify-center text-orange-600 mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-black text-gray-800 mb-2">Catat Panen</h4>
                    <p class="text-gray-500 text-sm mb-4">
                        Masukkan data panen akhir sebagai bahan evaluasi guru.
                    </p>
                    <a href="{{ route('siswa.panen.index') }}"
                       class="inline-flex items-center text-orange-600 font-bold hover:text-orange-700">
                        Buka Panen
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- STATUS EVALUASI --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3 bg-gray-50/60">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">
                            Status Evaluasi Tanaman Saya
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Evaluasi hanya dapat diproses oleh guru. Siswa hanya dapat melihat hasil.
                        </p>
                    </div>

                    <a href="{{ route('siswa.evaluasi.index') }}"
                       class="inline-flex items-center justify-center rounded-xl bg-purple-600 text-white px-4 py-2.5 text-sm font-bold hover:bg-purple-700 transition">
                        Lihat Evaluasi
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-white border-b border-gray-100 text-gray-400 text-xs uppercase tracking-widest font-black">
                                <th class="p-4 pl-6">Tanaman</th>
                                <th class="p-4">Tanggal Tanam</th>
                                <th class="p-4 text-center">Panen</th>
                                <th class="p-4 text-center">Status Evaluasi</th>
                                <th class="p-4 text-center pr-6">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-50">
                            @forelse($penanamans as $item)
                                @php
                                    $hasPanen = $item->panen !== null;
                                    $hasEvaluasi = $item->evaluasi !== null;
                                @endphp

                                <tr class="hover:bg-gray-50 transition">
                                    <td class="p-4 pl-6">
                                        <p class="font-bold text-gray-900">{{ $item->jenis_tanaman }}</p>
                                        <p class="text-xs text-gray-500">
                                            {{ $item->lokasi_lahan ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="p-4 text-sm text-gray-600">
                                        {{ $item->tgl_tanam ? \Carbon\Carbon::parse($item->tgl_tanam)->translatedFormat('d M Y') : '-' }}
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($hasPanen)
                                            <span class="inline-flex rounded-lg bg-orange-50 border border-orange-100 px-2 py-1 text-xs font-bold text-orange-700">
                                                Sudah Panen
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-lg bg-gray-50 border border-gray-100 px-2 py-1 text-xs font-bold text-gray-500">
                                                Belum Panen
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4 text-center">
                                        @if($hasEvaluasi)
                                            <span class="inline-flex rounded-lg bg-purple-50 border border-purple-100 px-2 py-1 text-xs font-bold text-purple-700">
                                                Sudah Dievaluasi
                                            </span>
                                        @elseif($hasPanen)
                                            <span class="inline-flex rounded-lg bg-blue-50 border border-blue-100 px-2 py-1 text-xs font-bold text-blue-700">
                                                Menunggu Evaluasi Guru
                                            </span>
                                        @else
                                            <span class="inline-flex rounded-lg bg-gray-50 border border-gray-100 px-2 py-1 text-xs font-bold text-gray-500">
                                                Belum Siap Evaluasi
                                            </span>
                                        @endif
                                    </td>

                                    <td class="p-4 pr-6 text-center">
                                        <a href="{{ route('siswa.evaluasi.show', $item->id) }}"
                                           class="inline-flex items-center justify-center rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 transition">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center mb-4">
                                                <span class="text-2xl">🌱</span>
                                            </div>
                                            <h4 class="font-bold text-gray-800">
                                                Belum Ada Data Penanaman
                                            </h4>
                                            <p class="text-sm text-gray-500 mt-1 max-w-md">
                                                Mulai catat penanaman pertama agar proses pemeliharaan, panen, dan evaluasi dapat berjalan.
                                            </p>
                                            <a href="{{ route('siswa.penanaman.index') }}"
                                               class="mt-4 inline-flex items-center justify-center rounded-xl bg-emerald-600 text-white px-4 py-2.5 text-sm font-bold hover:bg-emerald-700 transition">
                                                Catat Penanaman
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- CATATAN PENTING --}}
            <div class="bg-amber-50 border border-amber-100 rounded-3xl p-6">
                <h3 class="font-black text-amber-800">
                    Catatan Penting
                </h3>
                <p class="text-sm text-amber-700 mt-2 leading-6">
                    Siswa bertugas mengisi data praktik pertanian. Hasil akhir evaluasi tidak dihitung oleh siswa, tetapi diproses oleh guru melalui modul Evaluasi Panen menggunakan Rule-Based Decision Tree.
                </p>
            </div>

        </div>
    </div>
</x-app-layout>