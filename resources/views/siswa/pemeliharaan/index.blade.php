<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Data Pemeliharaan') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-xl flex items-center shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl shadow-sm">
                    <div class="font-bold mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
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
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100" x-data="{
                kategori: '',
                kegiatan: @js(old('kegiatan_json', [])),
                kondisiVisual: @js(old('kondisi_visual', old('kondisi_daun', ''))),
                tingkatHama: @js(old('tingkat_hama', '')),
                kelembapanTanah: @js(old('indikator_tambahan_json.kelembapan_tanah', '')),
                statusPertumbuhan: @js(old('status_pertumbuhan', '')),
                updateTanaman() {
                    const select = this.$refs.penanamanSelect;
                    const kategoriBaru = select.selectedIndex > 0
                        ? (select.options[select.selectedIndex].dataset.kategori || 'Default')
                        : '';

                    if (this.kategori && this.kategori !== kategoriBaru) {
                        this.kondisiVisual = '';
                        this.tingkatHama = '';
                        this.kelembapanTanah = '';
                        this.statusPertumbuhan = '';
                    }

                    this.kategori = kategoriBaru;
                    this.calculateStatus();
                },
                calculateStatus() {
                    if (!this.tingkatHama || !this.kondisiVisual) {
                        this.statusPertumbuhan = '';
                        return;
                    }

                    const aman = ['Sehat', 'Normal', 'Tidak Ada Gejala', 'Buah Normal', 'Tajuk Sehat'];
                    const pantau = ['Menguning', 'Tajuk Menguning', 'Pertumbuhan Terhambat', 'Kelembapan Tanah Kering', 'Kelembapan Tanah Terlalu Basah', 'Bunga Rontok'];
                    const risiko = ['Layu', 'Gejala Busuk', 'Buah Busuk', 'Mati Banyak'];
                    
                    let statusVisual = 'Aman';
                    if (risiko.includes(this.kondisiVisual)) statusVisual = 'Risiko Tinggi';
                    else if (pantau.includes(this.kondisiVisual)) statusVisual = 'Perlu Pantauan';
                    else if (aman.includes(this.kondisiVisual)) statusVisual = 'Aman';

                    let statusHama = 'Aman';
                    if (this.tingkatHama === 'Berat') statusHama = 'Risiko Tinggi';
                    else if (this.tingkatHama === 'Sedang' || this.tingkatHama === 'Ringan') statusHama = 'Perlu Pantauan';

                    let statusKelembapan = 'Aman';
                    if (this.kelembapanTanah === 'Kering' || this.kelembapanTanah === 'Terlalu Basah') {
                        statusKelembapan = 'Perlu Pantauan';
                    }

                    if (statusVisual === 'Risiko Tinggi' || statusHama === 'Risiko Tinggi') {
                        this.statusPertumbuhan = 'Risiko Tinggi';
                    } else if (statusVisual === 'Perlu Pantauan' || statusHama === 'Perlu Pantauan' || statusKelembapan === 'Perlu Pantauan') {
                        this.statusPertumbuhan = 'Perlu Pantauan';
                    } else {
                        this.statusPertumbuhan = 'Aman';
                    }
                }
            }" x-init="updateTanaman()">
                <h3 class="font-semibold text-gray-800 mb-4">Catat Pemeliharaan Mingguan</h3>
                <form action="{{ route('siswa.pemeliharaan.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @csrf
                    
                    <input type="hidden" name="status_pertumbuhan" :value="statusPertumbuhan">

                    <div class="lg:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanaman</label>
                        <select name="penanaman_id" x-ref="penanamanSelect" @change="updateTanaman()" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm" required>
                            <option value="">-- Pilih Data Tanaman --</option>
                            @foreach($penanamans as $p)
                                <option value="{{ $p->id }}" data-kategori="{{ $p->kategori_tanaman ?? $p->jenisTanaman->kategori_tanaman ?? 'Default' }}" {{ (old('penanaman_id') ?? request('penanaman_id')) == $p->id ? 'selected' : '' }}>
                                    {{ $p->jenisTanaman->nama_tanaman ?? $p->jenis_tanaman ?? '-' }} (Bibit: {{ $p->jml_bibit }}) - {{ $p->kategori_tanaman ?? $p->jenisTanaman->kategori_tanaman ?? '-' }} - Target: {{ $p->target_panen_jumlah ?? $p->target_panen_kg ?? '-' }} {{ $p->target_panen_satuan ?? 'Kg' }} - Mulai: {{ \Carbon\Carbon::parse($p->tgl_tanam)->format('d M Y') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Minggu Ke-</label>
                        <input type="number" name="minggu_ke" placeholder="Cth: 1" min="1" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm" value="{{ old('minggu_ke') }}" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Catat</label>
                        <input type="date" name="tanggal_catat" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm" required value="{{ old('tanggal_catat', date('Y-m-d')) }}">
                    </div>

                    <div class="lg:col-span-4" x-show="kategori !== ''">
                        <label class="block text-sm font-bold text-gray-800 mb-2">Kegiatan Pemeliharaan</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <label class="flex items-center space-x-2 text-sm text-gray-700"><input type="checkbox" name="kegiatan_json[]" value="Penyiraman" x-model="kegiatan" class="text-green-600 rounded focus:ring-green-500"><span>Penyiraman</span></label>
                            <label class="flex items-center space-x-2 text-sm text-gray-700"><input type="checkbox" name="kegiatan_json[]" value="Pemupukan" x-model="kegiatan" class="text-green-600 rounded focus:ring-green-500"><span>Pemupukan</span></label>
                            <label class="flex items-center space-x-2 text-sm text-gray-700"><input type="checkbox" name="kegiatan_json[]" value="Penyiangan Gulma" x-model="kegiatan" class="text-green-600 rounded focus:ring-green-500"><span>Penyiangan Gulma</span></label>
                            <label class="flex items-center space-x-2 text-sm text-gray-700"><input type="checkbox" name="kegiatan_json[]" value="Pengendalian Hama" x-model="kegiatan" class="text-green-600 rounded focus:ring-green-500"><span>Pengendalian Hama</span></label>
                            <label class="flex items-center space-x-2 text-sm text-gray-700"><input type="checkbox" name="kegiatan_json[]" value="Pembersihan Area" x-model="kegiatan" class="text-green-600 rounded focus:ring-green-500"><span>Pembersihan Area</span></label>
                            <label class="flex items-center space-x-2 text-sm text-gray-700"><input type="checkbox" name="kegiatan_json[]" value="Penyulaman" x-model="kegiatan" class="text-green-600 rounded focus:ring-green-500"><span>Penyulaman</span></label>
                            <label class="flex items-center space-x-2 text-sm text-gray-700"><input type="checkbox" name="kegiatan_json[]" value="Pemangkasan" x-model="kegiatan" class="text-green-600 rounded focus:ring-green-500"><span>Pemangkasan</span></label>
                            <label class="flex items-center space-x-2 text-sm text-gray-700"><input type="checkbox" name="kegiatan_json[]" value="Pengecekan Pertumbuhan" x-model="kegiatan" class="text-green-600 rounded focus:ring-green-500"><span>Cek Pertumbuhan</span></label>
                        </div>
                        <div class="mt-3">
                            <input type="text" name="kegiatan_raw" placeholder="Kegiatan Lainnya (Ketik jika tidak ada di atas...)" value="{{ old('kegiatan_raw') }}" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm">
                        </div>
                    </div>

                    <div class="lg:col-span-4" x-show="kategori !== ''">
                        <label class="block text-sm font-bold text-gray-800 mb-2 border-t pt-4">Indikator Pertumbuhan (Kategori: <span x-text="kategori" class="text-green-600"></span>)</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Tanaman Hidup</label>
                                    <input type="number" name="jml_hidup" placeholder="0" min="0" value="{{ old('jml_hidup') }}" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm" :disabled="kategori === ''" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Tanaman Mati</label>
                                    <input type="number" name="jml_mati" placeholder="0" min="0" value="{{ old('jml_mati', 0) }}" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm" :disabled="kategori === ''" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tingkat Serangan Hama</label>
                                <select name="tingkat_hama" x-model="tingkatHama" @change="calculateStatus()" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm" :disabled="kategori === ''" required>
                                    <option value="">-- Pilih --</option>
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    <option value="Ringan">Ringan</option>
                                    <option value="Sedang">Sedang</option>
                                    <option value="Berat">Berat</option>
                                </select>
                            </div>

                            <!-- Indikator Sayuran Daun -->
                            <div x-show="kategori === 'Sayuran Daun'">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Daun / Visual</label>
                                <select name="kondisi_daun" x-model="kondisiVisual" @change="calculateStatus()" :disabled="kategori !== 'Sayuran Daun'" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="Sehat">Sehat</option>
                                    <option value="Menguning">Menguning</option>
                                    <option value="Layu">Layu</option>
                                </select>
                            </div>

                            <!-- Indikator Sayuran Buah -->
                            <div x-show="kategori === 'Sayuran Buah'">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Visual (Tanaman & Buah)</label>
                                <select name="kondisi_visual" x-model="kondisiVisual" @change="calculateStatus()" :disabled="kategori !== 'Sayuran Buah'" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="Sehat">Sehat</option>
                                    <option value="Menguning">Menguning</option>
                                    <option value="Bunga Rontok">Bunga Rontok</option>
                                    <option value="Buah Busuk">Buah Busuk</option>
                                    <option value="Pertumbuhan Terhambat">Pertumbuhan Terhambat</option>
                                    <option value="Layu">Layu</option>
                                </select>
                            </div>
                            <input type="hidden" name="kondisi_visual" :value="kondisiVisual" :disabled="kategori !== 'Sayuran Daun'">

                            <!-- Tinggi Tanaman (Opsional) -->
                            <div x-show="kategori === 'Sayuran Daun' || kategori === 'Sayuran Buah' || kategori === 'Umbi'">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tinggi Tanaman (cm)</label>
                                <input type="number" step="0.1" name="tinggi_tanaman" value="{{ old('tinggi_tanaman') }}" placeholder="Opsional" :disabled="kategori !== 'Sayuran Daun' && kategori !== 'Sayuran Buah' && kategori !== 'Umbi'" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm">
                            </div>

                            <!-- Indikator Umbi -->
                            <div x-show="kategori === 'Umbi'">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kelembapan Tanah</label>
                                <select name="indikator_tambahan_json[kelembapan_tanah]" x-model="kelembapanTanah" @change="calculateStatus()" :disabled="kategori !== 'Umbi'" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="Kering">Kering</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Terlalu Basah">Terlalu Basah</option>
                                </select>
                            </div>
                            <div x-show="kategori === 'Umbi'">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Tajuk / Visual</label>
                                <select name="kondisi_visual" x-model="kondisiVisual" @change="calculateStatus()" :disabled="kategori !== 'Umbi'" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm">
                                    <option value="">-- Pilih --</option>
                                    <option value="Tajuk Sehat">Tajuk Sehat</option>
                                    <option value="Tajuk Menguning">Tajuk Menguning</option>
                                    <option value="Gejala Busuk">Gejala Busuk</option>
                                </select>
                            </div>

                            <!-- Indikator Buah / Sayuran Buah -->
                            <div x-show="kategori === 'Buah' || kategori === 'Sayuran Buah'">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Estimasi Jml Bunga/Buah</label>
                                <input type="number" name="indikator_tambahan_json[jumlah_bunga_buah]" value="{{ old('indikator_tambahan_json.jumlah_bunga_buah') }}" placeholder="Opsional" :disabled="kategori !== 'Buah' && kategori !== 'Sayuran Buah'" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm">
                            </div>
                            <div x-show="kategori === 'Buah'">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Buah / Visual</label>
                                <select name="kondisi_visual" x-model="kondisiVisual" @change="calculateStatus()" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm" :disabled="kategori !== 'Buah'">
                                    <option value="">-- Pilih --</option>
                                    <option value="Buah Normal">Buah Normal</option>
                                    <option value="Pertumbuhan Terhambat">Pertumbuhan Terhambat</option>
                                    <option value="Buah Busuk">Buah Busuk</option>
                                </select>
                            </div>


                            <!-- Indikator Default / Lainnya -->
                            <div x-show="kategori !== '' && kategori !== 'Sayuran Daun' && kategori !== 'Sayuran Buah' && kategori !== 'Umbi' && kategori !== 'Buah'">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kondisi Visual Umum</label>
                                <select name="kondisi_visual" x-model="kondisiVisual" @change="calculateStatus()" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm" :disabled="['Sayuran Daun', 'Sayuran Buah', 'Umbi', 'Buah'].includes(kategori)">
                                    <option value="">-- Pilih --</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Pertumbuhan Terhambat">Pertumbuhan Terhambat</option>
                                    <option value="Mati Banyak">Mati Banyak / Layu</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="lg:col-span-4" x-show="kategori !== ''">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                        <input type="text" name="catatan_pemeliharaan" value="{{ old('catatan_pemeliharaan') }}" placeholder="Cth: Pupuk cair diberikan setelah penyiraman sore" class="w-full border-gray-300 focus:ring-green-500 rounded-lg text-sm">
                    </div>

                    <div class="lg:col-span-4 mt-2 flex items-center justify-between" x-show="kategori !== ''">
                        <div class="text-sm font-medium">
                            <span class="text-gray-500">Estimasi Risiko: </span>
                            <span class="font-bold px-2 py-1 rounded" 
                                :class="{
                                    'bg-green-100 text-green-700': statusPertumbuhan === 'Aman',
                                    'bg-amber-100 text-amber-700': statusPertumbuhan === 'Perlu Pantauan',
                                    'bg-red-100 text-red-700': statusPertumbuhan === 'Risiko Tinggi',
                                    'bg-gray-100 text-gray-500': statusPertumbuhan === ''
                                }" x-text="statusPertumbuhan || 'Belum dihitung'"></span>
                        </div>
                        <button type="submit" class="bg-green-600 text-white px-6 py-2.5 rounded-xl hover:bg-green-700 font-bold shadow-sm transition">Simpan Laporan Mingguan</button>
                    </div>
                </form>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="p-4 font-medium text-gray-600 text-sm">Tanaman</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Minggu & Tanggal</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Kegiatan</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Tinggi</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Hidup / Mati</th>
                                <th class="p-4 font-medium text-gray-600 text-sm">Kondisi & Hama</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pemeliharaans as $pm)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4">
                                    <div class="font-bold text-gray-800">{{ $pm->penanaman->jenisTanaman->nama_tanaman ?? $pm->penanaman->jenis_tanaman ?? '-' }}</div>
                                    <div class="text-[10px] text-gray-500 font-mono">ID: #{{ $pm->penanaman_id }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-indigo-600">Minggu Ke-{{ $pm->minggu_ke }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($pm->tanggal_catat)->format('d M Y') }}</div>
                                </td>
                                <td class="p-4 text-sm text-gray-700 max-w-xs" title="{{ $pm->kegiatan }}">
                                    @if(!empty($pm->kegiatan_json))
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($pm->kegiatan_json as $kg)
                                                <span class="inline-flex px-2 py-0.5 rounded bg-emerald-50 text-emerald-700 text-[10px] font-bold border border-emerald-100">
                                                    {{ $kg }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-600 truncate block">{{ $pm->kegiatan ?? '-' }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm font-semibold text-gray-800">
                                    @if($pm->tinggi_tanaman)
                                        {{ $pm->tinggi_tanaman }} <span class="text-xs font-normal text-gray-500">cm</span>
                                    @else
                                        <span class="text-xs font-normal text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">{{ $pm->jml_hidup }} H</span>
                                    <span class="inline-flex text-xs font-bold text-red-600 bg-red-50 px-2 py-0.5 rounded ml-1">{{ $pm->jml_mati }} M</span>
                                </td>
                                <td class="p-4">
                                    <div class="text-xs">Visual: <span class="font-semibold text-gray-700">{{ $pm->kondisi_visual ?? $pm->kondisi_daun ?? '-' }}</span></div>
                                    <div class="text-xs mt-0.5">Hama: <span class="font-semibold {{ $pm->tingkat_hama == 'Tidak Ada' ? 'text-green-600' : 'text-amber-600' }}">{{ $pm->tingkat_hama }}</span></div>
                                    @if($pm->status_pertumbuhan)
                                    <div class="text-[10px] mt-1 px-1.5 py-0.5 inline-block rounded {{ $pm->status_pertumbuhan == 'Aman' ? 'bg-green-100 text-green-700' : ($pm->status_pertumbuhan == 'Perlu Pantauan' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                        {{ $pm->status_pertumbuhan }}
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            @if(count($pemeliharaans) === 0)
                            <tr><td colspan="6" class="p-6 text-center text-gray-500 font-medium">Belum ada catatan pemeliharaan</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if($pemeliharaans->hasPages())
                <div class="p-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $pemeliharaans->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
