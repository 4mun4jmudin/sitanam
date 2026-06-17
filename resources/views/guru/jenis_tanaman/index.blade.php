<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Master Jenis Tanaman') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1 max-w-2xl">
                    Kelola data referensi tanaman yang dapat dipilih oleh siswa saat mencatat penanaman. Atur kategori, satuan hasil panen, dan estimasi bobot.
                </p>
            </div>
            
            <button x-data @click="$dispatch('open-modal', 'tambah-tanaman')" class="inline-flex items-center justify-center rounded-xl bg-emerald-600 text-white px-4 py-2 text-sm font-bold hover:bg-emerald-700 transition">
                + Tambah Tanaman
            </button>
        </div>
    </x-slot>

    <div class="py-10 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    <div>
                        <h3 class="text-sm font-bold">Berhasil!</h3>
                        <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl flex items-start shadow-sm">
                    <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <div>
                        <h3 class="text-sm font-bold">Gagal Menyimpan Data</h3>
                        <ul class="list-disc ml-5 mt-1 text-sm text-red-700">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 bg-gray-50/70">
                    <h3 class="text-lg font-black text-gray-900">Daftar Komoditas</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-white border-b border-gray-100 text-gray-400 text-xs uppercase tracking-widest font-black">
                                <th class="p-4 pl-6">Nama Tanaman</th>
                                <th class="p-4">Kategori</th>
                                <th class="p-4 text-center">Satuan Default</th>
                                <th class="p-4 text-center">Estimasi (Kg/Satuan)</th>
                                <th class="p-4 text-center">Status</th>
                                <th class="p-4 text-center pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($jenisTanamans as $tanaman)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 pl-6">
                                    <p class="font-bold text-gray-900">{{ $tanaman->nama_tanaman }}</p>
                                    <p class="text-xs text-gray-500">Panen: {{ $tanaman->umur_panen_hari ?? '-' }} Hari</p>
                                </td>
                                <td class="p-4 text-sm text-gray-600 font-medium">
                                    {{ $tanaman->kategori_tanaman }}
                                </td>
                                <td class="p-4 text-center">
                                    <span class="inline-flex rounded-lg bg-gray-100 px-2 py-1 text-xs font-bold text-gray-700">
                                        {{ $tanaman->satuan_default }}
                                    </span>
                                </td>
                                <td class="p-4 text-center text-sm font-medium text-gray-600">
                                    {{ $tanaman->estimasi_bobot_per_satuan_kg ? (float) $tanaman->estimasi_bobot_per_satuan_kg : '-' }} Kg
                                </td>
                                <td class="p-4 text-center">
                                    @if($tanaman->status === 'Aktif')
                                        <span class="inline-flex rounded-lg bg-emerald-50 border border-emerald-100 px-2 py-1 text-xs font-bold text-emerald-700">Aktif</span>
                                    @else
                                        <span class="inline-flex rounded-lg bg-red-50 border border-red-100 px-2 py-1 text-xs font-bold text-red-700">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="p-4 pr-6 text-center">
                                    <button x-data @click="$dispatch('open-modal', 'edit-tanaman-{{ $tanaman->id }}')" class="text-indigo-600 hover:text-indigo-900 text-sm font-bold mr-3">Edit</button>
                                    
                                    <form action="{{ route($role.'.jenis_tanaman.destroy', $tanaman->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komoditas ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 text-sm font-bold">Hapus</button>
                                    </form>
                                </td>
                            </tr>


                            @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                            <span class="text-2xl">🌱</span>
                                        </div>
                                        <h4 class="font-bold text-gray-800">Belum Ada Master Tanaman</h4>
                                        <p class="text-sm text-gray-500 mt-1">Tambahkan data referensi tanaman yang bisa dipilih oleh siswa.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <!-- Tambah Modal -->
    <x-modal name="tambah-tanaman" focusable>
        <form method="post" action="{{ route($role.'.jenis_tanaman.store') }}" class="p-6"
            x-data="{
                nama: '',
                satuan: 'Ikat',
                estimasi: '',
                updateEstimasi() {
                    let n = this.nama.toLowerCase();
                    if (this.satuan === 'Kg') {
                        this.estimasi = '1';
                    } else if (this.satuan === 'Ikat') {
                        if (n.includes('kangkung') || n.includes('bayam')) this.estimasi = '0.2';
                        else if (n.includes('sawi') || n.includes('pakcoy')) this.estimasi = '0.25';
                        else this.estimasi = '0.25';
                    } else if (this.satuan === 'Karung') {
                        this.estimasi = '50';
                    } else if (this.satuan === 'Gram') {
                        this.estimasi = '0.001';
                    } else if (this.satuan === 'Buah') {
                        if (n.includes('melon')) this.estimasi = '1.5';
                        else if (n.includes('semangka')) this.estimasi = '3';
                        else this.estimasi = '0.5';
                    }
                }
            }">
            @csrf
            <h2 class="text-lg font-bold text-gray-900 mb-4">Tambah Master Tanaman Baru</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Tanaman</label>
                    <input type="text" name="nama_tanaman" x-model="nama" @input="updateEstimasi" class="w-full border-gray-300 rounded-xl" placeholder="Misal: Sawi Hijau" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                    <select name="kategori_tanaman" class="w-full border-gray-300 rounded-xl" required>
                        <option value="Sayuran Daun">Sayuran Daun</option>
                        <option value="Sayuran Buah">Sayuran Buah</option>
                        <option value="Umbi">Umbi</option>
                        <option value="Buah">Buah</option>
                        <option value="Tanaman Bumbu">Tanaman Bumbu</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Satuan Default (Target/Panen)</label>
                    <select name="satuan_default" x-model="satuan" @change="updateEstimasi" class="w-full border-gray-300 rounded-xl" required>
                        <option value="Ikat">Ikat</option>
                        <option value="Kg">Kg</option>
                        <option value="Buah">Buah</option>
                        <option value="Gram">Gram</option>
                        <option value="Karung">Karung</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Satuan Opsional</label>
                    <input type="text" name="satuan_opsional" class="w-full border-gray-300 rounded-xl" placeholder="Misal: Kg, Karung">
                    <p class="text-[10px] text-gray-500 mt-1">Pisahkan dengan koma jika lebih dari satu.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Estimasi Bobot (Kg / 1 Satuan)</label>
                    <input type="number" step="0.001" name="estimasi_bobot_per_satuan_kg" x-model="estimasi" class="w-full border-gray-300 rounded-xl" placeholder="Misal: 0.25" required>
                    <p class="text-[10px] text-gray-500 mt-1">Isi 1 jika satuan default adalah Kg.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Umur Panen (Hari)</label>
                    <input type="number" name="umur_panen_hari" class="w-full border-gray-300 rounded-xl" placeholder="Opsional">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-xl" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-xl font-bold">Simpan Tanaman</button>
            </div>
        </form>
    </x-modal>
    <!-- Loop Modal Edit di Luar Tabel -->
    @foreach($jenisTanamans as $tanaman)
    <x-modal name="edit-tanaman-{{ $tanaman->id }}" focusable>
        <form method="post" action="{{ route($role.'.jenis_tanaman.update', $tanaman->id) }}" class="p-6">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-bold text-gray-900 mb-4">Edit Tanaman: {{ $tanaman->nama_tanaman }}</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Nama Tanaman</label>
                    <input type="text" name="nama_tanaman" value="{{ $tanaman->nama_tanaman }}" class="w-full border-gray-300 rounded-xl" required>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Kategori</label>
                    <select name="kategori_tanaman" class="w-full border-gray-300 rounded-xl" required>
                        <option value="Sayuran Daun" {{ $tanaman->kategori_tanaman == 'Sayuran Daun' ? 'selected' : '' }}>Sayuran Daun</option>
                        <option value="Sayuran Buah" {{ $tanaman->kategori_tanaman == 'Sayuran Buah' ? 'selected' : '' }}>Sayuran Buah</option>
                        <option value="Umbi" {{ $tanaman->kategori_tanaman == 'Umbi' ? 'selected' : '' }}>Umbi</option>
                        <option value="Buah" {{ $tanaman->kategori_tanaman == 'Buah' ? 'selected' : '' }}>Buah</option>
                        <option value="Tanaman Bumbu" {{ $tanaman->kategori_tanaman == 'Tanaman Bumbu' ? 'selected' : '' }}>Tanaman Bumbu</option>
                        <option value="Lainnya" {{ $tanaman->kategori_tanaman == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Satuan Default (Target/Panen)</label>
                    <select name="satuan_default" class="w-full border-gray-300 rounded-xl" required>
                        <option value="Ikat" {{ $tanaman->satuan_default == 'Ikat' ? 'selected' : '' }}>Ikat</option>
                        <option value="Kg" {{ $tanaman->satuan_default == 'Kg' ? 'selected' : '' }}>Kg</option>
                        <option value="Buah" {{ $tanaman->satuan_default == 'Buah' ? 'selected' : '' }}>Buah</option>
                        <option value="Gram" {{ $tanaman->satuan_default == 'Gram' ? 'selected' : '' }}>Gram</option>
                        <option value="Karung" {{ $tanaman->satuan_default == 'Karung' ? 'selected' : '' }}>Karung</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Satuan Opsional</label>
                    <input type="text" name="satuan_opsional" value="{{ is_array($tanaman->satuan_opsional) ? implode(', ', $tanaman->satuan_opsional) : '' }}" class="w-full border-gray-300 rounded-xl" placeholder="Misal: Kg, Karung">
                    <p class="text-[10px] text-gray-500 mt-1">Pisahkan dengan koma jika lebih dari satu.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Estimasi Bobot (Kg / 1 Satuan)</label>
                    <input type="number" step="0.001" name="estimasi_bobot_per_satuan_kg" value="{{ (float) $tanaman->estimasi_bobot_per_satuan_kg }}" class="w-full border-gray-300 rounded-xl" required>
                    <p class="text-[10px] text-gray-500 mt-1">Isi 1 jika satuan default adalah Kg.</p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Umur Panen (Hari)</label>
                    <input type="number" name="umur_panen_hari" value="{{ $tanaman->umur_panen_hari }}" class="w-full border-gray-300 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border-gray-300 rounded-xl" required>
                        <option value="Aktif" {{ $tanaman->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ $tanaman->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl font-bold">Batal</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold">Simpan Perubahan</button>
            </div>
        </form>
    </x-modal>
    @endforeach

</x-app-layout>
