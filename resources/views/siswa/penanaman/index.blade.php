<x-app-layout>
    @php
        $role = strtolower(auth()->user()->role);
    @endphp

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Data Penanaman') }}
                </h2>

                <p class="text-sm text-gray-500 mt-1 max-w-3xl">
                    Catat data awal budidaya tanaman. Data ini menjadi dasar perhitungan persentase hidup dan capaian hasil panen pada evaluasi Rule-Based Decision Tree oleh guru.
                </p>
            </div>

            <div class="hidden md:flex items-center gap-2 rounded-2xl bg-emerald-50 border border-emerald-100 px-4 py-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold">
                    1
                </div>
                <div>
                    <p class="text-xs font-bold text-emerald-600 uppercase tracking-widest">
                        Tahap Awal
                    </p>
                    <p class="text-sm font-bold text-gray-800">
                        Penanaman
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"></path>
                    </svg>

                    <div>
                        <h3 class="text-sm font-bold">Berhasil!</h3>
                        <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- ALERT ERROR --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>

                    <div>
                        <h3 class="text-sm font-bold">Data belum valid</h3>
                        <ul class="list-disc ml-5 mt-1 text-sm text-red-700">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- HERO --}}
            <div class="relative overflow-hidden bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 rounded-3xl shadow-lg shadow-emerald-500/20">
                <div class="absolute -right-20 -top-20 w-72 h-72 bg-white/10 rounded-full blur-3xl"></div>
                <div class="absolute -left-20 -bottom-20 w-72 h-72 bg-lime-300/20 rounded-full blur-3xl"></div>

                <div class="relative z-10 p-7 md:p-9">
                    <p class="text-xs font-black text-emerald-100 uppercase tracking-widest mb-3">
                        Langkah 1 dari 4
                    </p>

                    <h3 class="text-3xl md:text-4xl font-black text-white leading-tight">
                        Mulai dari data penanaman 🌱
                    </h3>

                    <p class="text-emerald-50 mt-3 leading-7 max-w-3xl">
                        Isi jenis tanaman, tanggal tanam, jumlah bibit, kondisi tanah, lokasi lahan, dan target panen. Data ini akan digunakan sebagai dasar evaluasi setelah pemeliharaan dan panen selesai.
                    </p>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-4 gap-3 max-w-4xl">
                        <div class="rounded-2xl bg-white/10 border border-white/20 p-4 backdrop-blur">
                            <p class="text-xs font-bold text-emerald-100 uppercase">Tahap 1</p>
                            <p class="text-sm font-black text-white mt-1">Penanaman</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/20 p-4 backdrop-blur">
                            <p class="text-xs font-bold text-emerald-100 uppercase">Tahap 2</p>
                            <p class="text-sm font-black text-white mt-1">Pemeliharaan</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/20 p-4 backdrop-blur">
                            <p class="text-xs font-bold text-emerald-100 uppercase">Tahap 3</p>
                            <p class="text-sm font-black text-white mt-1">Panen</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 border border-white/20 p-4 backdrop-blur">
                            <p class="text-xs font-bold text-emerald-100 uppercase">Tahap 4</p>
                            <p class="text-sm font-black text-white mt-1">Evaluasi Guru</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- STATISTIK --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <p class="text-sm font-semibold text-gray-500">Total Penanaman</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">{{ $totalPenanaman }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Data awal budidaya yang sudah dicatat.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-emerald-100">
                    <p class="text-sm font-semibold text-emerald-600">Tanaman Aktif</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">{{ $totalAktif }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Belum masuk tahap panen.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-orange-100">
                    <p class="text-sm font-semibold text-orange-600">Sudah Panen</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">{{ $totalSudahPanen }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Data panen sudah tersedia.</p>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-purple-100">
                    <p class="text-sm font-semibold text-purple-600">Sudah Dievaluasi</p>
                    <h3 class="text-3xl font-black text-gray-900 mt-1">{{ $totalSudahEvaluasi }}</h3>
                    <p class="text-xs text-gray-400 mt-2">Hasil evaluasi sudah diproses guru.</p>
                </div>
            </div>

            {{-- FORM INPUT PENANAMAN --}}
            @if($role === 'siswa')
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50/70">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <h3 class="font-black text-lg text-gray-900">
                                    Form Data Penanaman
                                </h3>

                                <p class="text-sm text-gray-500 mt-1 max-w-3xl">
                                    Pastikan data awal benar, karena jumlah bibit dan target panen akan dipakai guru untuk menghitung persentase hidup dan persentase hasil panen.
                                </p>
                            </div>

                            <span class="inline-flex w-fit rounded-full bg-emerald-50 border border-emerald-100 px-3 py-1 text-xs font-bold text-emerald-700">
                                Siswa sebagai penginput data
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('siswa.penanaman.store') }}" method="POST" class="p-6"
                          x-data="{
                              satuanLabel: 'Satuan',
                              kategoriLabel: '-',
                              estimasiBobot: '-',
                              satuanOptions: [],
                              satuanTarget: '',
                              oldSatuanTarget: '{{ old('target_panen_satuan') }}',
                              updateTanaman() {
                                  const select = this.$refs.jenisSelect;
                                  if (select.selectedIndex > 0) {
                                      this.satuanLabel = select.options[select.selectedIndex].dataset.satuan || 'Satuan';
                                      this.kategoriLabel = select.options[select.selectedIndex].dataset.kategori || '-';
                                      this.estimasiBobot = select.options[select.selectedIndex].dataset.bobot || '-';
                                      
                                      let opsArray = [];
                                      try {
                                          let ops = select.options[select.selectedIndex].dataset.opsional;
                                          opsArray = ops ? JSON.parse(ops) : [];
                                          if (!Array.isArray(opsArray)) {
                                              opsArray = [opsArray];
                                          }
                                      } catch (e) {
                                          opsArray = [];
                                      }

                                      this.satuanOptions = [...new Set([this.satuanLabel, ...opsArray].filter(Boolean))];
                                      
                                      this.satuanTarget = this.oldSatuanTarget && this.satuanOptions.includes(this.oldSatuanTarget)
                                          ? this.oldSatuanTarget
                                          : (this.satuanOptions[0] || '');
                                  } else {
                                      this.satuanLabel = 'Satuan';
                                      this.kategoriLabel = '-';
                                      this.estimasiBobot = '-';
                                      this.satuanOptions = [];
                                      this.satuanTarget = '';
                                  }
                              }
                          }"
                          x-init="updateTanaman()">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    Jenis Tanaman
                                </label>
                                <select
                                    name="jenis_tanaman_id"
                                    x-ref="jenisSelect"
                                    @change="updateTanaman()"
                                    class="w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl text-sm"
                                    required
                                >
                                    <option value="">Pilih Tanaman</option>
                                    @foreach(($jenisTanamans ?? collect()) as $jt)
                                        <option value="{{ $jt->id }}" 
                                                data-satuan="{{ $jt->satuan_default }}"
                                                data-kategori="{{ $jt->kategori_tanaman }}"
                                                data-bobot="{{ $jt->estimasi_bobot_per_satuan_kg }}"
                                                data-opsional="{{ json_encode($jt->satuan_opsional ?? []) }}"
                                                {{ old('jenis_tanaman_id') == $jt->id ? 'selected' : '' }}>
                                            {{ $jt->nama_tanaman }} - {{ $jt->kategori_tanaman }} - {{ $jt->satuan_default }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenis_tanaman_id')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    Tanggal Tanam
                                </label>
                                <input
                                    type="date"
                                    name="tgl_tanam"
                                    value="{{ old('tgl_tanam') }}"
                                    class="w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl text-sm"
                                    required
                                >
                                @error('tgl_tanam')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    Jumlah Bibit
                                </label>
                                <input
                                    type="number"
                                    name="jml_bibit"
                                    value="{{ old('jml_bibit') }}"
                                    min="1"
                                    placeholder="Contoh: 50"
                                    class="w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl text-sm"
                                    required
                                >
                                @error('jml_bibit')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1 md:col-span-2 lg:col-span-3">
                                <div class="rounded-xl bg-emerald-50 border border-emerald-100 p-4">
                                    <p class="text-xs font-bold text-emerald-700 uppercase">Informasi Tanaman</p>
                                    <p class="text-sm text-gray-700 mt-1">
                                        Kategori: <span class="font-bold" x-text="kategoriLabel"></span>
                                    </p>
                                    <p class="text-sm text-gray-700">
                                        Satuan Target: <span class="font-bold" x-text="satuanLabel"></span>
                                    </p>
                                    <p class="text-sm text-gray-700">
                                        Estimasi Bobot: <span class="font-bold" x-text="estimasiBobot"></span> Kg per satuan
                                    </p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">
                                        Target Hasil Panen
                                    </label>
                                    <input
                                        type="number"
                                        step="0.01"
                                        min="0.01"
                                        name="target_panen_jumlah"
                                        value="{{ old('target_panen_jumlah') }}"
                                        placeholder="Contoh: 25"
                                        class="w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl text-sm"
                                        required
                                    >
                                    @error('target_panen_jumlah')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">
                                        Satuan Target
                                    </label>
                                    <select
                                        name="target_panen_satuan"
                                        x-model="satuanTarget"
                                        class="w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl text-sm bg-gray-50"
                                        required
                                    >
                                        <template x-for="opt in satuanOptions" :key="opt">
                                            <option :value="opt" x-text="opt"></option>
                                        </template>
                                    </select>
                                    @error('target_panen_satuan')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    Kondisi Tanah
                                </label>
                                <select
                                    name="kondisi_tanah"
                                    class="w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl text-sm"
                                    required
                                >
                                    <option value="">Pilih kondisi tanah</option>
                                    <option value="Subur" {{ old('kondisi_tanah') === 'Subur' ? 'selected' : '' }}>Subur</option>
                                    <option value="Standar" {{ old('kondisi_tanah', 'Standar') === 'Standar' ? 'selected' : '' }}>Standar</option>
                                    <option value="Kering" {{ old('kondisi_tanah') === 'Kering' ? 'selected' : '' }}>Kering</option>
                                    <option value="Terlalu Basah" {{ old('kondisi_tanah') === 'Terlalu Basah' ? 'selected' : '' }}>Terlalu Basah</option>
                                </select>
                                @error('kondisi_tanah')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">
                                    Lokasi Lahan
                                </label>
                                <input
                                    type="text"
                                    name="lokasi_lahan"
                                    value="{{ old('lokasi_lahan') }}"
                                    placeholder="Contoh: Greenhouse A"
                                    class="w-full border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 rounded-xl text-sm"
                                    required
                                >
                                @error('lokasi_lahan')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <p class="text-xs text-gray-500 leading-5 max-w-2xl">
                                Data yang sudah dievaluasi guru tidak boleh diubah sembarangan karena dapat memengaruhi hasil akhir Decision Tree.
                            </p>

                            <button
                                type="submit"
                                class="inline-flex items-center justify-center bg-emerald-600 text-white px-5 py-3 rounded-xl hover:bg-emerald-700 font-bold transition shadow-sm"
                            >
                                Simpan Penanaman
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            {{-- TABEL PENANAMAN --}}
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/70 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-black text-gray-900">
                            Riwayat Penanaman Saya
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Pantau status setiap tanaman dari penanaman sampai evaluasi.
                        </p>
                    </div>

                    <div class="inline-flex w-fit rounded-full bg-gray-100 border border-gray-200 px-3 py-1 text-xs font-bold text-gray-600">
                        Total: {{ $totalPenanaman }} Data
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-white border-b border-gray-100 text-gray-400 text-xs uppercase tracking-widest font-black">
                                <th class="p-4 pl-6 text-center w-12">No</th>
                                <th class="p-4">Tanaman</th>
                                <th class="p-4">Tanggal Tanam</th>
                                <th class="p-4 text-center">Bibit</th>
                                <th class="p-4 text-center">Target Panen</th>
                                <th class="p-4">Lokasi / Tanah</th>
                                <th class="p-4 text-center">Status Proses</th>
                                <th class="p-4 text-center pr-6">Aksi Lanjut</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-50">
                            @forelse($penanamans as $idx => $p)
                                @php
                                    $hasPemeliharaan = ($p->pemeliharaans ?? collect())->count() > 0;
                                    $hasPanen = $p->panen !== null;
                                    $hasEvaluasi = $p->evaluasi !== null;

                                    if ($hasEvaluasi) {
                                        $statusLabel = 'Sudah Dievaluasi';
                                        $statusClass = 'bg-purple-50 text-purple-700 border-purple-100';
                                        $statusDesc = 'Hasil sudah diproses guru';
                                    } elseif ($hasPanen) {
                                        $panenLengkap = $p->panen->tgl_panen
                                            && $p->panen->tanaman_hidup !== null
                                            && $p->panen->tanaman_mati !== null
                                            && (
                                                $p->panen->jumlah_hasil_panen !== null
                                                || $p->panen->bobot_panen_kg !== null
                                                || $p->panen->bobot_panen !== null
                                            );
                                        
                                        if ($panenLengkap) {
                                            $statusLabel = 'Menunggu Evaluasi Guru';
                                            $statusClass = 'bg-blue-50 text-blue-700 border-blue-100';
                                            $statusDesc = 'Data panen sudah tersedia';
                                        } else {
                                            $statusLabel = 'Data Panen Perlu Dilengkapi';
                                            $statusClass = 'bg-amber-50 text-amber-700 border-amber-100';
                                            $statusDesc = 'Lengkapi detail panen';
                                        }
                                    } elseif ($hasPemeliharaan) {
                                        $statusLabel = 'Dalam Pemeliharaan';
                                        $statusClass = 'bg-emerald-50 text-emerald-700 border-emerald-100';
                                        $statusDesc = 'Lanjutkan sampai panen';
                                    } else {
                                        $statusLabel = 'Belum Pemeliharaan';
                                        $statusClass = 'bg-gray-50 text-gray-600 border-gray-100';
                                        $statusDesc = 'Catat pemeliharaan pertama';
                                    }

                                    $rowNumber = method_exists($penanamans, 'firstItem')
                                        ? $penanamans->firstItem() + $idx
                                        : $idx + 1;
                                @endphp

                                <tr class="hover:bg-emerald-50/30 transition">
                                    <td class="p-4 pl-6 text-center text-gray-400 font-medium text-sm">
                                        {{ $rowNumber }}
                                    </td>

                                    <td class="p-4">
                                        <div>
                                            <p class="font-black text-gray-900">
                                                {{ $p->jenisTanaman->nama_tanaman ?? $p->jenis_tanaman ?? '-' }}
                                            </p>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                {{ $p->kategori_tanaman ?? $p->jenisTanaman->kategori_tanaman ?? '-' }}
                                                •
                                                {{ $p->target_panen_satuan ?? $p->jenisTanaman->satuan_default ?? 'Kg' }}
                                            </p>
                                            <p class="text-[10px] text-gray-400 mt-0.5">
                                                ID Proyek: #{{ $p->id }}
                                            </p>
                                        </div>
                                    </td>

                                    <td class="p-4 text-sm text-gray-600">
                                        {{ $p->tgl_tanam ? \Carbon\Carbon::parse($p->tgl_tanam)->translatedFormat('d M Y') : '-' }}
                                    </td>

                                    <td class="p-4 text-center">
                                        <span class="inline-flex rounded-lg bg-gray-50 border border-gray-100 px-2.5 py-1 text-sm font-bold text-gray-700">
                                            {{ $p->jml_bibit }} Bibit
                                        </span>
                                    </td>

                                    <td class="p-4 text-center">
                                        <span class="inline-flex rounded-lg bg-emerald-50 border border-emerald-100 px-2.5 py-1 text-sm font-bold text-emerald-700">
                                            {{ $p->target_panen_jumlah ?? $p->target_panen_kg ?? '-' }} {{ $p->target_panen_satuan ?? 'Kg' }}
                                        </span>
                                    </td>

                                    <td class="p-4">
                                        <p class="text-sm font-semibold text-gray-700">
                                            {{ $p->lokasi_lahan }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-0.5">
                                            Tanah: {{ $p->kondisi_tanah ?? '-' }}
                                        </p>
                                    </td>

                                    <td class="p-4 text-center">
                                        <div class="flex flex-col items-center">
                                            <span class="inline-flex rounded-lg border px-2.5 py-1 text-xs font-black {{ $statusClass }}">
                                                {{ $statusLabel }}
                                            </span>
                                            <span class="text-[10px] text-gray-400 mt-1">
                                                {{ $statusDesc }}
                                            </span>
                                        </div>
                                    </td>

                                    <td class="p-4 pr-6 text-center">
                                        @if($hasEvaluasi)
                                            <a href="{{ route('siswa.evaluasi.show', $p->id) }}"
                                               class="inline-flex items-center justify-center rounded-xl bg-purple-50 border border-purple-100 px-3 py-2 text-xs font-black text-purple-700 hover:bg-purple-100 transition">
                                                Lihat Evaluasi
                                            </a>
                                        @elseif($hasPanen)
                                            <a href="{{ route('siswa.evaluasi.show', $p->id) }}"
                                               class="inline-flex items-center justify-center rounded-xl bg-blue-50 border border-blue-100 px-3 py-2 text-xs font-black text-blue-700 hover:bg-blue-100 transition">
                                                Cek Status Evaluasi
                                            </a>
                                        @elseif($hasPemeliharaan)
                                            <a href="{{ route('siswa.panen.index', ['penanaman_id' => $p->id]) }}"
                                               class="inline-flex items-center justify-center rounded-xl bg-orange-50 border border-orange-100 px-3 py-2 text-xs font-black text-orange-700 hover:bg-orange-100 transition">
                                                Catat Panen
                                            </a>
                                        @else
                                            <a href="{{ route('siswa.pemeliharaan.index', ['penanaman_id' => $p->id]) }}"
                                               class="inline-flex items-center justify-center rounded-xl bg-emerald-50 border border-emerald-100 px-3 py-2 text-xs font-black text-emerald-700 hover:bg-emerald-100 transition">
                                                Catat Pemeliharaan
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-14 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div class="w-20 h-20 rounded-full bg-emerald-50 flex items-center justify-center mb-4">
                                                <span class="text-3xl">🌱</span>
                                            </div>

                                            <h3 class="text-base font-black text-gray-800">
                                                Belum Ada Data Penanaman
                                            </h3>

                                            <p class="text-sm text-gray-500 mt-1 max-w-md">
                                                Mulai catat penanaman pertama agar proses pemeliharaan, panen, dan evaluasi dapat berjalan.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if(method_exists($penanamans, 'hasPages') && $penanamans->hasPages())
                    <div class="p-5 border-t border-gray-100 bg-gray-50/70">
                        {{ $penanamans->links() }}
                    </div>
                @endif
            </div>

            {{-- CATATAN SISTEM --}}
            <div class="bg-amber-50 border border-amber-100 rounded-3xl p-6">
                <h3 class="font-black text-amber-800">
                    Catatan Penting & Penjelasan Status
                </h3>

                <ul class="list-disc ml-5 mt-3 space-y-2 text-sm text-amber-700 leading-6">
                    <li><strong class="font-bold">Penanaman</strong> adalah data awal. Setelah data ini dibuat, siswa perlu melanjutkan ke pencatatan pemeliharaan dan panen.</li>
                    <li><strong class="font-bold">Menunggu Evaluasi Guru:</strong> Jika data panen sudah lengkap, siswa tinggal menunggu guru untuk memproses hasil akhir menggunakan algoritma.</li>
                    <li><strong class="font-bold">Sudah Dievaluasi:</strong> Status ini berarti data penanaman telah selesai diproses oleh Guru melalui modul Evaluasi (Rule-Based Decision Tree), dan skor serta rekomendasi telah diterbitkan. Status ini <b>bukan</b> hasil input otomatis dari siswa, melainkan hasil perhitungan validasi sistem oleh guru.</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>