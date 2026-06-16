<x-app-layout>
    @php
        $role = strtolower(auth()->user()->role);
        $routeName = $role . '.evaluasi.index';
        $indexRoute = \Illuminate\Support\Facades\Route::has($routeName)
            ? route($routeName)
            : route('guru.evaluasi.index');
    @endphp

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight">
                    {{ __('Evaluasi Keputusan Panen Akhir') }}
                </h2>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <a href="{{ route('dashboard') }}" class="hover:text-emerald-600 transition">Dashboard</a>
                    <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-gray-700 font-medium">Evaluasi Panen Akhir</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">
                    Proses evaluasi panen menggunakan metode Rule-Based Decision Tree berdasarkan data penanaman, pemeliharaan, dan panen.
                </p>
            </div>
        </div>
    </x-slot>

    <div x-data="evaluasiSistem()" class="max-w-7xl mx-auto space-y-8 pb-12">

        @if(session('success'))
            <div class="bg-indigo-50 border-l-4 border-indigo-500 text-indigo-800 p-4 rounded-r-xl flex items-start shadow-sm">
                <svg class="w-5 h-5 mr-3 flex-shrink-0 mt-0.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="
<truncated 45215 bytes>
urn $item;
        });

        $stats = null;

        if ($role !== 'siswa') {
            $totalEvaluasi = Evaluasi::count();
            $berhasil = Evaluasi::where('hasil_klasifikasi', 'Berhasil')->count();
            $cukup = Evaluasi::where('hasil_klasifikasi', 'Cukup')->count();
            $gagal = Evaluasi::where('hasil_klasifikasi', 'Gagal')->count();

            $rekorPanen = Panen::with(['penanaman.jenisTanaman'])
                ->orderByRaw('COALESCE(bobot_panen_kg, bobot_panen, 0) DESC')
                ->first();

            $evaluasiTerbaik = Evaluasi::with(['penanaman.jenisTanaman'])
                ->where('hasil_klasifikasi', 'Berhasil')
                ->orderByDesc('skor')
                ->first();

            $stats = [
                'total' => $totalEvaluasi,
                'berhasil' => $berhasil,
                'cukup' => $cukup,
                'gagal' => $gagal,
                'persentase' => $totalEvaluasi > 0 ? round(($berhasil / $totalEvaluasi) * 100, 1) : 0,
                'tanaman_terbaik' => $evaluasiTerbaik?->penanaman?->jenisTanaman?->nama_tanaman
                    ?? $evaluasiTerbaik?->penanaman?->jenis_tanaman
                    ?? '-',
                'rekor_panen' => $rekorPanen
                    ? ($rekorPanen->bobot_panen_kg ?? $rekorPanen->bobot_panen ?? 0)
                    : 0,
            ];
        }

        if ($role === 'siswa') {
            $viewName = 'siswa.evaluasi.index';
        } elseif ($role === 'admin' && view()->exists('admin.evaluasi.index')) {
            $viewName = 'admin.evaluasi.index';
        } else {
            $viewName = 'guru.evaluasi.index';
        }

        return view($viewName, compact('penanamans', 'stats'));
    }

    public function proses(Request $request, DecisionTreeService $service)
    {
        $request->validate([
            'penanaman_id' => 'req
<truncated 16981 bytes>

NOTE: The output was truncated because it was too long. Use a more targeted query or a smaller range to get the information you need.