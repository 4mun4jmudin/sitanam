<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class PanenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = strtolower(auth()->user()->role);

        if ($role === 'guru' || $role === 'admin') {
            $baseQuery = \App\Models\Panen::with([
                'penanaman.siswa',
                'penanaman.jenisTanaman',
            ]);

            if ($request->filled('search')) {
                $search = $request->search;

                $baseQuery->where(function ($q) use ($search) {
                    $q->whereHas('penanaman.siswa', function ($siswaQuery) use ($search) {
                        $siswaQuery->where('name', 'like', "%{$search}%");
                    })
                        ->orWhereHas('penanaman', function ($tanamanQuery) use ($search) {
                            $tanamanQuery->where('jenis_tanaman', 'like', "%{$search}%");
                        })
                        ->orWhereHas('penanaman.jenisTanaman', function ($jenisQuery) use ($search) {
                            $jenisQuery->where('nama_tanaman', 'like', "%{$search}%")
                                ->orWhere('kategori_tanaman', 'like', "%{$search}%");
                        });
                });
            }

            $panens = (clone $baseQuery)
                ->orderBy('tgl_panen', 'desc')
                ->paginate(10)
                ->withQueryString();

            // Data penanaman yang siap panen:
            // belum panen, belum evaluasi, dan sudah punya pemeliharaan.
            $penanamans = \App\Models\Penanaman::with([
                'siswa',
                'jenisTanaman',
                'pemeliharaans',
                'panen',
                'evaluasi',
            ])
                ->whereDoesntHave('panen')
                ->whereDoesntHave('evaluasi')
                ->whereHas('pemeliharaans')
                ->latest()
                ->get();

            $beratTotal = (clone $baseQuery)
                ->selectRaw('COALESCE(SUM(COALESCE(bobot_panen_kg, bobot_panen, 0)), 0) as total')
                ->value('total');

            $stats = [
                'total' => (clone $baseQuery)->count(),
                'dominan_hidup' => (clone $baseQuery)
                    ->whereColumn('tanaman_hidup', '>=', 'tanaman_mati')
                    ->count(),
                'dominan_mati' => (clone $baseQuery)
                    ->whereColumn('tanaman_hidup', '<', 'tanaman_mati')
                    ->count(),
                'berat_total' => $beratTotal,
            ];

            $viewName = $role === 'admin' && view()->exists('admin.panen.index') 
                ? 'admin.panen.index' 
                : 'guru.panen.index';

            return view($viewName, compact('panens', 'penanamans', 'stats'));
        }

        // Role siswa
        $penanamans = \App\Models\Penanaman::with([
            'jenisTanaman',
            'pemeliharaans',
            'panen',
            'evaluasi',
        ])
            ->where('siswa_id', auth()->id())
            ->whereDoesntHave('panen')
            ->whereDoesntHave('evaluasi')
            ->whereHas('pemeliharaans')
            ->latest()
            ->get();

        $panens = \App\Models\Panen::with([
            'penanaman.jenisTanaman',
        ])
            ->whereHas('penanaman', function ($q) {
                $q->where('siswa_id', auth()->id());
            })
            ->orderBy('tgl_panen', 'desc')
            ->paginate(10);

        return view('siswa.panen.index', compact('penanamans', 'panens'));
    }

    /**
     * Store newly created harvest record.
     */
    public function store(Request $request)
    {
        $request->validate([
            'penanaman_id' => 'required|exists:penanamen,id',
            'tgl_panen' => 'required|date',
            'tanaman_hidup' => 'required|integer|min:0',
            'tanaman_mati' => 'required|integer|min:0',
            'jumlah_hasil_panen' => 'required|numeric|min:0',
        ]);

        $role = strtolower(auth()->user()->role);

        if ($role !== 'siswa') {
            abort(403, 'Hanya siswa yang dapat mencatat data panen.');
        }

        $penanaman = \App\Models\Penanaman::with([
            'jenisTanaman',
            'pemeliharaans',
            'panen',
            'evaluasi',
        ])
            ->findOrFail($request->penanaman_id);

        // Siswa hanya boleh input panen tanaman miliknya sendiri.
        if ($role === 'siswa' && (int) $penanaman->siswa_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data penanaman ini.');
        }

        // Cegah panen dobel.
        if ($penanaman->panen) {
            return back()->withErrors([
                'penanaman_id' => 'Data tanaman ini sudah memiliki catatan panen.'
            ])->withInput();
        }

        // Jika sudah dievaluasi, data panen tidak boleh ditambah.
        if ($penanaman->evaluasi) {
            return back()->withErrors([
                'penanaman_id' => 'Tanaman ini sudah dievaluasi guru, data panen tidak dapat ditambahkan.'
            ])->withInput();
        }

        // Wajib ada pemeliharaan sebelum panen.
        if ($penanaman->pemeliharaans->count() === 0) {
            return back()->withErrors([
                'penanaman_id' => 'Tanaman belum memiliki catatan pemeliharaan, belum bisa dicatat panen.'
            ])->withInput();
        }

        // Tanggal panen tidak boleh sebelum tanggal tanam.
        if (Carbon::parse($request->tgl_panen)->lt(Carbon::parse($penanaman->tgl_tanam))) {
            return back()->withErrors([
                'tgl_panen' => 'Tanggal panen tidak boleh lebih awal dari tanggal tanam.'
            ])->withInput();
        }

        // Jumlah hidup + mati tidak boleh melebihi bibit awal.
        if (((int) $request->tanaman_hidup + (int) $request->tanaman_mati) > (int) $penanaman->jml_bibit) {
            return back()->withErrors([
                'tanaman_hidup' => 'Total tanaman hidup dan mati tidak boleh melebihi jumlah bibit awal (' . $penanaman->jml_bibit . ').'
            ])->withInput();
        }

        $satuan = $penanaman->target_panen_satuan ?? 'Kg';
        $jumlahHasil = (float) $request->jumlah_hasil_panen;

        $estimasiBobot = $penanaman->estimasi_bobot_per_satuan_kg;

        // Jika satuannya bukan Kg, wajib punya konversi estimasi bobot.
        if ($satuan !== 'Kg' && (!$estimasiBobot || (float) $estimasiBobot <= 0)) {
            return back()->withErrors([
                'jumlah_hasil_panen' => 'Estimasi bobot per satuan belum tersedia untuk tanaman ini. Silakan lengkapi data master tanaman terlebih dahulu.'
            ])->withInput();
        }

        $bobotKg = $satuan === 'Kg'
            ? $jumlahHasil
            : ($jumlahHasil * (float) $estimasiBobot);

        \App\Models\Panen::create([
            'penanaman_id' => $request->penanaman_id,
            'tgl_panen' => $request->tgl_panen,
            'tanaman_hidup' => $request->tanaman_hidup,
            'tanaman_mati' => $request->tanaman_mati,

            // Flexible harvest result
            'jumlah_hasil_panen' => $jumlahHasil,
            'satuan_hasil_panen' => $satuan,
            'bobot_panen_kg' => $bobotKg,

            // Legacy fallback
            'bobot_panen' => $bobotKg,
        ]);

        return back()->with('success', 'Data Hasil Panen Berhasil Disimpan.');
    }
}