<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenanamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = auth()->user()->role;
        
        if ($role === 'guru' || $role === 'admin') {
            $query = \App\Models\Penanaman::with(['siswa', 'pemeliharaans', 'panen', 'evaluasi']);

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->whereHas('siswa', function ($siswaQuery) use ($search) {
                        $siswaQuery->where('name', 'like', "%{$search}%");
                    })->orWhere('jenis_tanaman', 'like', "%{$search}%");
                });
            }

            if ($request->filled('status_filter')) {
                // If status_filter == 'panen', check relation panen exists
                if ($request->status_filter === 'panen') {
                    $query->has('panen');
                } elseif ($request->status_filter === 'aktif') {
                    $query->doesntHave('panen');
                }
            }

            $perPage = $request->input('per_page', 10);
            
            if ($perPage === 'all') {
                $total = $query->count();
                $penanamans = $query->orderBy('created_at', 'desc')->paginate($total > 0 ? $total : 1)->withQueryString();
            } else {
                $penanamans = $query->orderBy('created_at', 'desc')->paginate((int)$perPage)->withQueryString();
            }
            
            $siswas = \App\Models\User::where('role', 'siswa')->get();

            // Stats
            $stats = [
                'total' => \App\Models\Penanaman::count(),
                'aktif' => \App\Models\Penanaman::doesntHave('panen')->count(),
                'panen' => \App\Models\Penanaman::has('panen')->count(),
                'bermasalah' => 0 // Dummy or use specific logic
            ];

            // Chart Data
            $trenTanaman = \App\Models\Penanaman::query()
                ->selectRaw('jenis_tanaman, COUNT(*) as total')
                ->groupBy('jenis_tanaman')
                ->orderByDesc('total')
                ->get();

            $labels = $trenTanaman->pluck('jenis_tanaman')->toArray();
            $counts = $trenTanaman->pluck('total')->toArray();

            return view('guru.penanaman.index', compact('penanamans', 'stats', 'siswas', 'labels', 'counts'));

        } else {
            $penanamans = \App\Models\Penanaman::with(['pemeliharaans', 'panen', 'evaluasi', 'jenisTanaman'])
                ->where('siswa_id', auth()->id())
                ->latest()
                ->paginate(10);
            
            $jenisTanamans = \App\Models\JenisTanaman::where('status', 'Aktif')->orderBy('nama_tanaman')->get();

            $totalPenanaman = \App\Models\Penanaman::where('siswa_id', auth()->id())->count();
            $totalSudahPanen = \App\Models\Penanaman::where('siswa_id', auth()->id())->has('panen')->count();
            $totalSudahEvaluasi = \App\Models\Penanaman::where('siswa_id', auth()->id())->has('evaluasi')->count();
            $totalAktif = \App\Models\Penanaman::where('siswa_id', auth()->id())->doesntHave('panen')->count();

            return view('siswa.penanaman.index', compact('penanamans', 'jenisTanamans', 'totalPenanaman', 'totalSudahPanen', 'totalSudahEvaluasi', 'totalAktif'));
        }
    }

    public function create()
    {
        $jenisTanamans = \App\Models\JenisTanaman::where('status', 'Aktif')->orderBy('nama_tanaman')->get();
        return view('siswa.penanaman.create', compact('jenisTanamans'));
    }

    public function store(Request $request)
    {
        $role = auth()->user()->role;
        $rules = [
            'jenis_tanaman_id' => 'required|exists:jenis_tanamans,id',
            'tgl_tanam' => 'required|date',
            'jml_bibit' => 'required|integer|min:1',
            'lokasi_lahan' => 'required|string|max:255',
            'target_panen_jumlah' => 'required|numeric|min:0.01',
            'target_panen_satuan' => 'required|string',
            'kondisi_tanah' => 'required|in:Subur,Standar,Kering,Terlalu Basah',
        ];

        if ($role === 'guru' || $role === 'admin') {
            $rules['siswa_id'] = 'required|exists:users,id';
        }

        $request->validate($rules);

        // Fetch master tanaman for snapshots
        $jenisTanaman = \App\Models\JenisTanaman::findOrFail($request->jenis_tanaman_id);

        // Calculate fallback target_panen_kg
        $target_kg = null;
        if ($request->target_panen_satuan === 'Kg') {
            $target_kg = $request->target_panen_jumlah;
        } else {
            $estimasi = $jenisTanaman->estimasi_bobot_per_satuan_kg ?? 0;
            $target_kg = $request->target_panen_jumlah * $estimasi;
        }

        \App\Models\Penanaman::create([
            'siswa_id' => ($role === 'guru' || $role === 'admin') ? $request->siswa_id : auth()->id(),
            // New snapshot columns
            'jenis_tanaman_id' => $jenisTanaman->id,
            'kategori_tanaman' => $jenisTanaman->kategori_tanaman,
            'target_panen_jumlah' => $request->target_panen_jumlah,
            'target_panen_satuan' => $request->target_panen_satuan,
            'estimasi_bobot_per_satuan_kg' => $jenisTanaman->estimasi_bobot_per_satuan_kg,
            
            // Legacy fallbacks
            'jenis_tanaman' => $jenisTanaman->nama_tanaman,
            'target_panen_kg' => $target_kg,
            
            'lokasi_lahan' => $request->lokasi_lahan,
            'tgl_tanam' => $request->tgl_tanam,
            'jml_bibit' => $request->jml_bibit,
            'kondisi_tanah' => $request->kondisi_tanah,
        ]);

        return back()->with('success', 'Data Penanaman Berhasil Ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penanaman = \App\Models\Penanaman::with(['pemeliharaans', 'panen', 'evaluasi', 'siswa'])->findOrFail($id);
        $role = auth()->user()->role;
        return view('penanaman.show', compact('penanaman', 'role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
