@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Data Pemeliharaan</h1>
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route(auth()->user()->role . '.pemeliharaan.update', $pemeliharaan->id) }}" method="POST" class="bg-white shadow rounded-lg p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Penanaman</label>
            <select name="penanaman_id" class="w-full border rounded px-3 py-2" required>
                @foreach($penanamans as $p)
                    <option value="{{ $p->id }}" {{ $p->id == $pemeliharaan->penanaman_id ? 'selected' : '' }}>
                        {{ $p->jenis_tanaman }} - {{ $p->siswa->name ?? 'Tidak diketahui' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tanggal Catat</label>
            <input type="date" name="tanggal_catat" class="w-full border rounded px-3 py-2" value="{{ $pemeliharaan->tanggal_catat->format('Y-m-d') }}" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Minggu Ke</label>
            <input type="number" name="minggu_ke" class="w-full border rounded px-3 py-2" value="{{ $pemeliharaan->minggu_ke }}" required min="1">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Kegiatan (opsional)</label>
            <input type="text" name="kegiatan" class="w-full border rounded px-3 py-2" value="{{ $pemeliharaan->kegiatan }}">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tinggi Tanaman (cm)</label>
            <input type="number" step="0.01" name="tinggi_tanaman" class="w-full border rounded px-3 py-2" value="{{ $pemeliharaan->tinggi_tanaman }}" required>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700">Jumlah Hidup</label>
                <input type="number" name="jml_hidup" class="w-full border rounded px-3 py-2" value="{{ $pemeliharaan->jml_hidup }}" required min="0">
            </div>
            <div>
                <label class="block text-gray-700">Jumlah Mati</label>
                <input type="number" name="jml_mati" class="w-full border rounded px-3 py-2" value="{{ $pemeliharaan->jml_mati }}" required min="0">
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Kondisi Daun</label>
            <select name="kondisi_daun" class="w-full border rounded px-3 py-2" required>
                <option value="Sehat" {{ $pemeliharaan->kondisi_daun == 'Sehat' ? 'selected' : '' }}>Sehat</option>
                <option value="Menguning" {{ $pemeliharaan->kondisi_daun == 'Menguning' ? 'selected' : '' }}>Menguning</option>
                <option value="Layu" {{ $pemeliharaan->kondisi_daun == 'Layu' ? 'selected' : '' }}>Layu</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Tingkat Hama</label>
            <select name="tingkat_hama" class="w-full border rounded px-3 py-2" required>
                <option value="Tidak Ada" {{ $pemeliharaan->tingkat_hama == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                <option value="Ringan" {{ $pemeliharaan->tingkat_hama == 'Ringan' ? 'selected' : '' }}>Ringan</option>
                <option value="Sedang" {{ $pemeliharaan->tingkat_hama == 'Sedang' ? 'selected' : '' }}>Sedang</option>
                <option value="Berat" {{ $pemeliharaan->tingkat_hama == 'Berat' ? 'selected' : '' }}>Berat</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Catatan Lain (opsional)</label>
            <input type="text" name="info_hama" class="w-full border rounded px-3 py-2" value="{{ $pemeliharaan->info_hama }}">
        </div>
        <div class="flex justify-end">
            <a href="{{ route(auth()->user()->role . '.pemeliharaan.index') }}" class="mr-4 text-gray-600 hover:underline">Batal</a>
            <button type="submit" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold py-2 px-4 rounded shadow-lg transition transform hover:scale-105">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
