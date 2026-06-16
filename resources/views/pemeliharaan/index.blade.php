@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Pemeliharaan</h1>
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(auth()->user()->role !== 'siswa')
        <a href="{{ route(auth()->user()->role . '.pemeliharaan.create') }}" class="inline-block mb-4 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold py-2 px-4 rounded shadow-lg transition transform hover:scale-105">
            + Tambah Pemeliharaan
        </a>
    @endif
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Penanaman</th>
                    <th class="px-4 py-2">Tanggal</th>
                    <th class="px-4 py-2">Kegiatan</th>
                    <th class="px-4 py-2">Tinggi Tanaman</th>
                    <th class="px-4 py-2">Daun</th>
                    <th class="px-4 py-2">Hama</th>
                    <th class="px-4 py-2">Info</th>
                    @if(auth()->user()->role !== 'siswa')
                        <th class="px-4 py-2">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($pemeliharaans as $index => $item)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="px-4 py-2 text-center">{{ $pemeliharaans->firstItem() + $index }}</td>
                        <td class="px-4 py-2">{{ $item->penanaman->jenis_tanaman ?? '-' }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_catat)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">{{ $item->kegiatan }}</td>
                        <td class="px-4 py-2 text-center">{{ $item->tinggi_tanaman }} cm</td>
                        <td class="px-4 py-2">{{ $item->kondisi_daun }}</td>
                        <td class="px-4 py-2">{{ $item->tingkat_hama }}</td>
                        <td class="px-4 py-2">{{ $item->info_hama }}</td>
                        @if(auth()->user()->role !== 'siswa')
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route(auth()->user()->role . '.pemeliharaan.edit', $item->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route(auth()->user()->role . '.pemeliharaan.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $pemeliharaans->links() }}</div>
</div>
@endsection
