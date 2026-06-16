@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Data Pemeliharaan</h1>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route(auth()->user()->role . '.pemeliharaan.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700">Penanaman</label>
            <select name="penanaman_id" class="w-full border rounded px-3 py-2" required>
                <option value="" disabled selected>Pilih Penanaman</option>
                @foreach($penanamans as $p)
                    <option value="{{ $p->id }}">{{ $p->jenis_tanaman }} - {{ $p->siswa->name ?? 'Tidak diketahui' }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tanggal Catat</label>
            <input type="date" name="tanggal_catat" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Minggu Ke</label>
            <input type="number" name="minggu_ke" class="w-full border rounded px-3 py-2" required min="1" value="1">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Kegiatan (opsional)</label>
            <input type="text" name="kegiatan" class="w-full border rounded px-3 py-2" placeholder="Contoh: Penyiraman">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tinggi Tanaman (cm)</label>
            <input type="number" step="0.01" name="tinggi_tanaman" class="w-full border rounded px-3 py-2" required>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700">Jumlah Hidup</label>
                <input type="number" name="jml_hidup" class="w-full border rounded px-3 py-2" required min="0" value="{{ old('jml_hidup') }}">
            </div>
            <div>
                <label class="block text-gray-700">Jumlah Mati</label>
                <input type="number" name="jml_mati" class="w-full border rounded px-3 py-2" required min="0" value="{{ old('jml_mati', 0) }}">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Kondisi Daun</label>
            <select name="kondisi_daun" class="w-full border rounded px-3 py-2" required>
                <option value="Sehat">Sehat</option>
                <option value="Menguning">Menguning</option>
                <option value="Layu">Layu</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tingkat Hama</label>
            <select name="tingkat_hama" class="w-full border rounded px-3 py-2" required>
                <option value="Tidak Ada">Tidak Ada</option>
                <option value="Ringan">Ringan</option>
                <option value="Sedang">Sedang</option>
                <option value="Berat">Berat</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Catatan Lain (opsional)</label>
            <input type="text" name="info_hama" class="w-full border rounded px-3 py-2" placeholder="Contoh: Ada bercak hitam di daun">
        </div>
        <div class="flex justify-end">
            <a href="{{ route(auth()->user()->role . '.pemeliharaan.index') }}" class="mr-4 text-gray-600 hover:underline">Batal</a>
            <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold py-2 px-4 rounded shadow-lg transition transform hover:scale-105">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
