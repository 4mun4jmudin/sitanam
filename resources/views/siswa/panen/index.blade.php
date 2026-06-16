<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Data Panen') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl shadow-sm">
                    <div class="font-bold mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Terdapat Kesalahan:
                    </div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                $role = strtolower(auth()->user()->role);
            @endphp

            @if($role === 'siswa')
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100"
                     x-data="{
                        satuan: 'Kg',
                        target: '',
                        selected: false,
                        updateSatuan() {
                            const select = this.$refs.penanamanSelect;

                            if (select.selectedIndex > 0) {
                                this.satuan = select.options[select.selectedIndex].dataset.satuan || 'Kg';
                                this.target = select.options[select.selectedIndex].dataset.target || '';
                                this.selected = true;
                            } else {
                                this.satuan = 'Kg';
                                this.target = '';
                                this.selected = false;
                            }
                        }
                     }"
                     x-init="updateSatuan()">

                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="font-semibold text-gray-800">Catat Hasil Panen</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Pilih tanaman yang sudah melalui pemeliharaan, lalu isi hasil panen akhir.
                            </p>
                        </div>
                    </div>

                    @if($penanamans->count() === 0)
                        <div class="bg-amber-50 border border-amber-200 text-amber-700 p-4 rounded-xl text-sm">
                            Belum ada tanaman yang siap dipanen. Tanaman akan muncul di sini jika sudah memiliki catatan pemeliharaan dan belum pernah dipanen.
                        </div>
                    @else
                        <form action="{{ route('siswa.panen.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @csrf

                            <div class="md:col-span-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Data Tanaman</label>
                                <select name="penanaman_id"
                                        x-ref="penanamanSelect"
                                        @change="updateSatuan()"
                                        class="border-gray-300 focus:ring-green-500 rounded-lg w-full text-sm"
                                        required>
                                    <option value="">-- Pilih Data Tanaman --</option>
                                    @foreach($penanamans as $p)
                                        @php
                                            $namaTanaman = $p->jenisTanaman->nama_tanaman ?? $p->jenis_tanaman ?? '-';
                                            $targetJumlah = $p->target_panen_jumlah ?? $p->target_panen_kg ?? '-';
                                            $targetSatuan = $p->target_panen_satuan ?? 'Kg';
                                        @endphp
                                        <option value="{{ $p->id }}"
                                                data-satuan="{{ $targetSatuan }}"
                                                data-target="{{ $targetJumlah }}"
                                                {{ (old('penanaman_id') ?? request('penanaman_id')) == $p->id ? 'selected' : '' }}>
                                            {{ $namaTanaman }}
                                            - Bibit: {{ $p->jml_bibit }}
                                            - Target: {{ $targetJumlah }} {{ $targetSatuan }}
                                            - Tanam: {{ \Carbon\Carbon::parse($p->tgl_tanam)->format('d M Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Panen</label>
                                <input type="date"
                                       name="tgl_panen"
                                       value="{{ old('tgl_panen', date('Y-m-d')) }}"
                                       class="border-gray-300 focus:ring-green-500 rounded-lg w-full text-sm"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanaman Hidup</label>
                                <input type="number"
                                       name="tanaman_hidup"
                                       value="{{ old('tanaman_hidup') }}"
                                       min="0"
                                       placeholder="Jumlah hidup"
                                       class="border-gray-300 focus:ring-green-500 rounded-lg w-full text-sm"
                                       required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanaman Mati</label>
                                <input type="number"
                                       name="tanaman_mati"
                                       value="{{ old('tanaman_mati', 0) }}"
                                       min="0"
                                       placeholder="Jumlah mati"
                                       class="border-gray-300 focus:ring-green-500 rounded-lg w-full text-sm"
                                       required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Hasil Panen
                                    <span class="text-xs text-gray-400" x-show="target">
                                        Target: <span x-text="target"></span> <span x-text="satuan"></span>
                                    </span>
                                </label>
                                <div class="flex items-center">
                                    <input type="number"
                                           step="0.01"
                                           name="jumlah_hasil_panen"
                                           value="{{ old('jumlah_hasil_panen') }}"
                                           min="0"
                                           placeholder="Masukkan hasil panen"
                                           class="border-gray-300 focus:ring-green-500 rounded-l-lg w-full text-sm"
                                           required>
                                    <span class="bg-gray-100 border border-gray-300 border-l-0 text-gray-600 px-3 py-2 rounded-r-lg text-sm min-w-[70px] text-center"
                                          x-text="satuan"></span>
                                </div>
                                <p class="text-xs text-gray-400 mt-1">
                                    Satuan mengikuti target panen pada data penanaman.
                                </p>
                            </div>

                            <div class="md:col-span-1 flex items-end justify-end">
                                <button type="submit"
                                        class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 font-medium transition w-full md:w-auto">
                                    Simpan Panen
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 border-b border-gray-100">
                    <h3 class="font-semibold text-gray-800">Riwayat Panen</h3>
                    <p class="text-sm text-gray-500 mt-1">
                        Data hasil panen akhir yang akan digunakan pada proses evaluasi Decision Tree.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 font-medium text-gray-600 text-sm">Tanaman</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Tanggal Panen</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Hidup / Total Bibit</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Mati</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Hasil / Target</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Capaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($panens as $d)
                                @php
                                    $namaTanaman = $d->penanaman->jenisTanaman->nama_tanaman ?? $d->penanaman->jenis_tanaman ?? '-';

                                    $jumlahHasil = $d->jumlah_hasil_panen ?? $d->bobot_panen ?? 0;
                                    $satuanHasil = $d->satuan_hasil_panen ?? $d->penanaman->target_panen_satuan ?? 'Kg';

                                    $targetJumlah = $d->penanaman->target_panen_jumlah ?? $d->penanaman->target_panen_kg ?? 0;
                                    $persenHasil = $targetJumlah > 0 ? round(($jumlahHasil / $targetJumlah) * 100, 1) : null;

                                    $totalBibit = $d->penanaman->jml_bibit ?? 0;
                                    $persenHidup = $totalBibit > 0 ? round(($d->tanaman_hidup / $totalBibit) * 100, 1) : null;
                                @endphp

                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="p-4">
                                        <div class="font-bold text-gray-800">{{ $namaTanaman }}</div>
                                        <div class="text-[10px] text-gray-500 font-mono">ID Tanam: #{{ $d->penanaman_id }}</div>
                                    </td>

                                    <td class="p-4 text-gray-600">
                                        {{ \Carbon\Carbon::parse($d->tgl_panen)->format('d/m/Y') }}
                                    </td>

                                    <td class="p-4">
                                        <div class="text-green-600 font-semibold">
                                            {{ $d->tanaman_hidup }} / {{ $totalBibit }}
                                        </div>
                                        @if($persenHidup !== null)
                                            <div class="text-xs text-gray-400">{{ $persenHidup }}% hidup</div>
                                        @endif
                                    </td>

                                    <td class="p-4 text-red-600 font-semibold">
                                        {{ $d->tanaman_mati }}
                                    </td>

                                    <td class="p-4 text-gray-800 font-bold">
                                        {{ $jumlahHasil }} / {{ $targetJumlah }}
                                        <span class="text-xs text-gray-500">{{ $satuanHasil }}</span>

                                        @if($d->bobot_panen_kg || $d->bobot_panen)
                                            <div class="text-[10px] text-gray-400 font-normal">
                                                Konversi: {{ $d->bobot_panen_kg ?? $d->bobot_panen }} Kg
                                            </div>
                                        @endif
                                    </td>

                                    <td class="p-4">
                                        @if($persenHasil !== null)
                                            <span class="inline-flex px-2 py-1 rounded text-xs font-bold
                                                {{ $persenHasil >= 80 ? 'bg-green-100 text-green-700' : ($persenHasil >= 50 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                                {{ $persenHasil }}%
                                            </span>
                                        @else
                                            <span class="text-xs text-gray-400">Target belum ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                            @if(count($panens) === 0)
                                <tr>
                                    <td colspan="6" class="p-6 text-center text-gray-500 font-medium">
                                        Belum ada data panen
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                @if(method_exists($panens, 'hasPages') && $panens->hasPages())
                    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $panens->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>