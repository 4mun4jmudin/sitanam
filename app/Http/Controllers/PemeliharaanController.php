<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemeliharaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $role = strtolower(auth()->user()->role);

        if ($role === 'guru' || $role === 'admin') {
            $baseQuery = \App\Models\Pemeliharaan::with([
                'penanaman.siswa',
                'penanaman.jenisTanaman'
            ]);

            // Apply search filter (by siswa name or tanaman)
            if ($request->filled('search')) {
                $search = $request->search;
                $baseQuery->where(function ($q) use ($search) {
                    $q->whereHas('penanaman.siswa', function ($siswaQuery) use ($search) {
                        $siswaQuery->where('name', 'like', "%{$search}%");
                    })->orWhereHas('penanaman', function ($tanamanQuery) use ($search) {
                        $tanamanQuery->where('jenis_tanaman', 'like', "%{$search}%");
                    })->orWhereHas('penanaman.jenisTanaman', function ($q) use ($search) {
                        $q->where('nama_tanaman', 'like', "%{$search}%")
                          ->orWhere('kategori_tanaman', 'like', "%{$search}%");
                    });
                });
            }

            // Calculate exact counts for the chart (after search, before status filter)
            $cntSehat = (clone $baseQuery)
                ->where(function ($q) {
                    $q->where('status_pertumbuhan', 'Aman')
                      ->orWhere(function ($q2) {
                          $q2->whereNull('status_pertumbuhan')
                             ->where('kondisi_daun', 'Sehat')
                             ->where('tingkat_hama', 'Tidak Ada');
                      });
                })
                ->count();

            $cntPerluPantauan = (clone $baseQuery)
                ->where(function ($q) {
                    $q->where('status_pertumbuhan', 'Perlu Pantauan')
                      ->orWhere(function ($q2) {
                          $q2->whereNull('status_pertumbuhan')
                             ->where(function ($q3) {
                                 $q3->where('kondisi_daun', 'Menguning')
                                    ->orWhereIn('tingkat_hama', ['Ringan', 'Sedang']);
                             });
                      });
                })
                ->count();

            $cntRisikoTinggi = (clone $baseQuery)
                ->where(function ($q) {
                    $q->where('status_pertumbuhan', 'Risiko Tinggi')
                      ->orWhere(function ($q2) {
                          $q2->whereNull('status_pertumbuhan')
                             ->where(function ($q3) {
                                 $q3->where('kondisi_daun', 'Layu')
                                    ->orWhere('tingkat_hama', 'Berat');
                             });
                      });
                })
                ->count();

            $query = clone $baseQuery;

            // Apply status filter
            if ($request->filled('status_filter')) {
                $query->where(function ($q) use ($request) {
                    $q->where('status_pertumbuhan', $request->status_filter)
                      ->orWhere(function ($sub) use ($request) {
                          $sub->whereNull('status_pertumbuhan');
                          if ($request->status_filter === 'Aman') {
                              $sub->where('kondisi_daun', 'Sehat')
                                  ->where('tingkat_hama', 'Tidak Ada');
                          } elseif ($request->status_filter === 'Perlu Pantauan') {
                              $sub->where(function ($q2) {
                                  $q2->where('kondisi_daun', 'Menguning')
                                     ->orWhereIn('tingkat_hama', ['Ringan', 'Sedang']);
                              });
                          } elseif ($request->status_filter === 'Risiko Tinggi') {
                              $sub->where(function ($q2) {
                                  $q2->where('kondisi_daun', 'Layu')
                                     ->orWhere('tingkat_hama', 'Berat');
                              });
                          }
                      });
                });
            }

            $perPage = $request->input('per_page', 10);
            if ($perPage === 'all') {
                $pemeliharaans = $query->orderBy('tanggal_catat', 'desc')->paginate($query->count() > 0 ? $query->count() : 1)->withQueryString();
            } else {
                $pemeliharaans = $query->orderBy('tanggal_catat', 'desc')->paginate((int) $perPage)->withQueryString();
            }

            // All penanaman for dropdown input
            $penanamans = \App\Models\Penanaman::with('siswa')->whereDoesntHave('panen')->get();

            // Stats
            $stats = [
                'total' => (clone $baseQuery)->count(),
                'sehat' => $cntSehat,
                'bermasalah' => $cntPerluPantauan + $cntRisikoTinggi,
                'panen' => \App\Models\Penanaman::has('panen')->count()
            ];

            $cntHama = $cntPerluPantauan;
            $cntLayu = $cntRisikoTinggi;

            $viewName = $role === 'guru' ? 'guru.pemeliharaan.index' : 'pemeliharaan.index';
            return view($viewName, compact('pemeliharaans', 'penanamans', 'stats', 'cntSehat', 'cntPerluPantauan', 'cntRisikoTinggi', 'cntHama', 'cntLayu'));
        } else {
            $penanamans = \App\Models\Penanaman::with(['jenisTanaman', 'pemeliharaans', 'panen', 'evaluasi'])
                ->where('siswa_id', auth()->id())
                ->whereDoesntHave('panen')
                ->whereDoesntHave('evaluasi')
                ->latest()
                ->get();

            $pemeliharaans = \App\Models\Pemeliharaan::with(['penanaman.jenisTanaman'])
                ->whereHas('penanaman', function($q) {
                    $q->where('siswa_id', auth()->id());
                })->orderBy('tanggal_catat', 'desc')->paginate(10);

            return view('siswa.pemeliharaan.index', compact('penanamans', 'pemeliharaans'));
        }
    }

    /** Show form to create a new record */
    public function create()
    {
        $role = strtolower(auth()->user()->role);
        if (!in_array($role, ['admin', 'guru'])) abort(403);
        $penanamans = \App\Models\Penanaman::with('siswa')->whereDoesntHave('panen')->get();
        return view('pemeliharaan.create', compact('penanamans'));
    }

    /** Store newly created record */
    public function store(Request $request)
    {
        $request->validate([
            'penanaman_id' => 'required|exists:penanamen,id',
            'minggu_ke' => 'required|integer|min:1',
            'tanggal_catat' => 'required|date',
            'kegiatan_raw' => 'nullable|string',
            'kegiatan' => 'nullable|string',
            'tinggi_tanaman' => 'nullable|numeric|min:0',
            'jml_hidup' => 'required|integer|min:0',
            'jml_mati' => 'required|integer|min:0',
            'kondisi_daun' => 'nullable|in:Sehat,Menguning,Layu',
            'kondisi_visual' => 'nullable|string|max:100',
            'tingkat_hama' => 'required|in:Tidak Ada,Ringan,Sedang,Berat',
            'kegiatan_json' => 'nullable|array',
            'kegiatan_json.*' => 'string|max:100',
            'indikator_tambahan_json' => 'nullable|array',
            'status_pertumbuhan' => 'nullable|in:Aman,Perlu Pantauan,Risiko Tinggi',
            'catatan_pemeliharaan' => 'nullable|string',
            'info_hama' => 'nullable|string'
        ]);

        $role = strtolower(auth()->user()->role);

        $penanaman = \App\Models\Penanaman::with(['panen', 'evaluasi'])
            ->findOrFail($request->penanaman_id);

        if ($role === 'siswa' && (int) $penanaman->siswa_id !== (int) auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke data penanaman ini.');
        }

        if ($penanaman->panen) {
            return back()->withErrors([
                'penanaman_id' => 'Tanaman ini sudah masuk tahap panen, pemeliharaan tidak dapat ditambahkan.'
            ])->withInput();
        }

        $exists = \App\Models\Pemeliharaan::where('penanaman_id', $request->penanaman_id)
            ->where('minggu_ke', $request->minggu_ke)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'minggu_ke' => 'Minggu ke-' . $request->minggu_ke . ' untuk tanaman ini sudah pernah dicatat.'
            ])->withInput();
        }

        if ($penanaman->evaluasi) {
            return back()->withErrors([
                'penanaman_id' => 'Tanaman ini sudah dievaluasi guru, data pemeliharaan tidak dapat ditambahkan.'
            ])->withInput();
        }

        $kategori = $penanaman->kategori_tanaman
            ?? optional($penanaman->jenisTanaman)->kategori_tanaman
            ?? 'Default';

        if ($kategori === 'Sayuran Daun') {
            if (!$request->kondisi_daun && !$request->kondisi_visual) {
                return back()->withErrors(['kondisi_daun' => 'Kondisi daun wajib diisi.'])->withInput();
            }
        } else {
            if (!$request->kondisi_visual) {
                return back()->withErrors(['kondisi_visual' => 'Kondisi visual wajib diisi.'])->withInput();
            }
        }

        if ($kategori === 'Umbi') {
            $kelembapan = $request->input('indikator_tambahan_json.kelembapan_tanah');
            if (!$kelembapan) {
                return back()->withErrors([
                    'indikator_tambahan_json.kelembapan_tanah' => 'Kelembapan tanah wajib diisi untuk kategori Umbi.'
                ])->withInput();
            }
        }

        if (((int) $request->jml_hidup + (int) $request->jml_mati) > (int) $penanaman->jml_bibit) {
            return back()->withErrors(['jml_hidup' => 'Total tanaman hidup dan mati tidak boleh melebihi jumlah bibit awal (' . $penanaman->jml_bibit . ').'])->withInput();
        }

        $kegiatanList = $request->input('kegiatan_json', []);
        $kegiatanRaw = $request->input('kegiatan_raw') ?? $request->input('kegiatan');
        
        $allKegiatanList = $kegiatanList;
        if ($kegiatanRaw) {
            $allKegiatanList[] = $kegiatanRaw;
        }

        $kegiatan = count($allKegiatanList) > 0 ? implode(', ', $allKegiatanList) : 'Pemeliharaan Rutin';

        $indikatorTambahan = $request->input('indikator_tambahan_json', []);

        // Override status_pertumbuhan from backend
        $kondisiVisual = $request->kondisi_visual ?? $request->kondisi_daun;
        $statusPertumbuhan = $this->hitungStatusPertumbuhan($kondisiVisual, $request->tingkat_hama, $indikatorTambahan);

        $info_hama = $request->info_hama;
        if (!$info_hama) {
            if ($statusPertumbuhan === 'Aman') {
                $info_hama = 'Sehat';
            } elseif ($statusPertumbuhan === 'Risiko Tinggi') {
                $info_hama = 'Layu';
            } else {
                $info_hama = 'Terserang Hama';
            }
        }

        \App\Models\Pemeliharaan::create([
            'penanaman_id' => $request->penanaman_id,
            'minggu_ke' => $request->minggu_ke,
            'tanggal_catat' => $request->tanggal_catat,
            'kegiatan' => $kegiatan ?? 'Pemeliharaan Rutin',
            'kegiatan_json' => $allKegiatanList,
            'tinggi_tanaman' => $request->tinggi_tanaman,
            'jml_hidup' => $request->jml_hidup,
            'jml_mati' => $request->jml_mati,
            'kondisi_daun' => $request->kondisi_daun,
            'kondisi_visual' => $request->kondisi_visual ?? $request->kondisi_daun,
            'indikator_tambahan_json' => $indikatorTambahan,
            'status_pertumbuhan' => $statusPertumbuhan,
            'catatan_pemeliharaan' => $request->catatan_pemeliharaan,
            'tingkat_hama' => $request->tingkat_hama,
            'info_hama' => $info_hama,
        ]);

        return back()->with('success', 'Data Pemeliharaan Berhasil Disimpan.');
    }

    /** Show form to edit an existing record */
    public function edit($id)
    {
        $role = strtolower(auth()->user()->role);
        if (!in_array($role, ['admin', 'guru'])) abort(403);
        $pemeliharaan = \App\Models\Pemeliharaan::findOrFail($id);
        $penanamans = \App\Models\Penanaman::with('siswa')->get();
        return view('pemeliharaan.edit', compact('pemeliharaan', 'penanamans'));
    }

    /** Update a record */
    public function update(Request $request, $id)
    {
        $role = strtolower(auth()->user()->role);
        if (!in_array($role, ['admin', 'guru'])) abort(403);
        $request->validate([
            'penanaman_id' => 'required|exists:penanamen,id',
            'minggu_ke' => 'required|integer|min:1',
            'tanggal_catat' => 'required|date',
            'kegiatan' => 'nullable|string',
            'tinggi_tanaman' => 'nullable|numeric|min:0',
            'jml_hidup' => 'required|integer|min:0',
            'jml_mati' => 'required|integer|min:0',
            'kondisi_daun' => 'nullable|in:Sehat,Menguning,Layu',
            'kondisi_visual' => 'nullable|string|max:100',
            'tingkat_hama' => 'required|in:Tidak Ada,Ringan,Sedang,Berat',
            'kegiatan_json' => 'nullable|array',
            'kegiatan_json.*' => 'string|max:100',
            'indikator_tambahan_json' => 'nullable|array',
            'status_pertumbuhan' => 'nullable|in:Aman,Perlu Pantauan,Risiko Tinggi',
            'catatan_pemeliharaan' => 'nullable|string',
            'info_hama' => 'nullable|string'
        ]);

        $penanaman = \App\Models\Penanaman::findOrFail($request->penanaman_id);

        $exists = \App\Models\Pemeliharaan::where('penanaman_id', $request->penanaman_id)
            ->where('minggu_ke', $request->minggu_ke)
            ->where('id', '!=', $id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'minggu_ke' => 'Minggu ke-' . $request->minggu_ke . ' untuk tanaman ini sudah pernah dicatat.'
            ])->withInput();
        }

        $kategori = $penanaman->kategori_tanaman
            ?? optional($penanaman->jenisTanaman)->kategori_tanaman
            ?? 'Default';

        if ($kategori === 'Sayuran Daun') {
            if (!$request->kondisi_daun && !$request->kondisi_visual) {
                return back()->withErrors(['kondisi_daun' => 'Kondisi daun wajib diisi.'])->withInput();
            }
        } else {
            if (!$request->kondisi_visual) {
                return back()->withErrors(['kondisi_visual' => 'Kondisi visual wajib diisi.'])->withInput();
            }
        }

        if ($kategori === 'Umbi') {
            $kelembapan = $request->input('indikator_tambahan_json.kelembapan_tanah');
            if (!$kelembapan) {
                return back()->withErrors([
                    'indikator_tambahan_json.kelembapan_tanah' => 'Kelembapan tanah wajib diisi untuk kategori Umbi.'
                ])->withInput();
            }
        }

        if (((int) $request->jml_hidup + (int) $request->jml_mati) > $penanaman->jml_bibit) {
            return back()->withErrors(['jml_hidup' => 'Total tanaman hidup dan mati tidak boleh melebihi jumlah bibit awal (' . $penanaman->jml_bibit . ').'])->withInput();
        }

        $kegiatanList = $request->input('kegiatan_json', []);
        $kegiatanRaw = $request->input('kegiatan_raw') ?? $request->input('kegiatan');
        
        $allKegiatanList = $kegiatanList;
        if ($kegiatanRaw) {
            $allKegiatanList[] = $kegiatanRaw;
        }

        $kegiatan = count($allKegiatanList) > 0 ? implode(', ', $allKegiatanList) : 'Pemeliharaan Rutin';

        $indikatorTambahan = $request->input('indikator_tambahan_json', []);

        // Override status_pertumbuhan from backend
        $kondisiVisual = $request->kondisi_visual ?? $request->kondisi_daun;
        $statusPertumbuhan = $this->hitungStatusPertumbuhan($kondisiVisual, $request->tingkat_hama, $indikatorTambahan);
        $info_hama = $request->info_hama;
        if (!$info_hama) {
            if ($statusPertumbuhan === 'Aman') {
                $info_hama = 'Sehat';
            } elseif ($statusPertumbuhan === 'Risiko Tinggi') {
                $info_hama = 'Layu';
            } else {
                $info_hama = 'Terserang Hama';
            }
        }

        $pemeliharaan = \App\Models\Pemeliharaan::findOrFail($id);
        $pemeliharaan->update([
            'penanaman_id' => $request->penanaman_id,
            'minggu_ke' => $request->minggu_ke,
            'tanggal_catat' => $request->tanggal_catat,
            'kegiatan' => $kegiatan ?? 'Pemeliharaan Rutin',
            'kegiatan_json' => $allKegiatanList,
            'tinggi_tanaman' => $request->tinggi_tanaman,
            'jml_hidup' => $request->jml_hidup,
            'jml_mati' => $request->jml_mati,
            'kondisi_daun' => $request->kondisi_daun,
            'kondisi_visual' => $request->kondisi_visual ?? $request->kondisi_daun,
            'indikator_tambahan_json' => $indikatorTambahan,
            'status_pertumbuhan' => $statusPertumbuhan,
            'catatan_pemeliharaan' => $request->catatan_pemeliharaan,
            'tingkat_hama' => $request->tingkat_hama,
            'info_hama' => $info_hama,
        ]);
        return redirect()->route(strtolower(auth()->user()->role) . '.pemeliharaan.index')->with('success', 'Data pemeliharaan berhasil diperbarui.');
    }

    /** Delete a record */
    public function destroy($id)
    {
        $role = strtolower(auth()->user()->role);
        if (!in_array($role, ['admin', 'guru'])) abort(403);
        $pemeliharaan = \App\Models\Pemeliharaan::findOrFail($id);
        $pemeliharaan->delete();
        return back()->with('success', 'Data pemeliharaan berhasil dihapus.');
    }

    private function hitungStatusPertumbuhan(?string $kondisiVisual, ?string $tingkatHama, array $indikatorTambahan = []): string
    {
        $aman = ['Sehat', 'Normal', 'Tidak Ada Gejala', 'Buah Normal', 'Tajuk Sehat'];
        $pantau = ['Menguning', 'Tajuk Menguning', 'Pertumbuhan Terhambat', 'Kelembapan Tanah Kering', 'Kelembapan Tanah Terlalu Basah', 'Bunga Rontok'];
        $risiko = ['Layu', 'Gejala Busuk', 'Buah Busuk', 'Mati Banyak'];

        $statusVisual = 'Aman';

        if (in_array($kondisiVisual, $risiko, true)) {
            $statusVisual = 'Risiko Tinggi';
        } elseif (in_array($kondisiVisual, $pantau, true)) {
            $statusVisual = 'Perlu Pantauan';
        }

        $statusHama = 'Aman';

        if ($tingkatHama === 'Berat') {
            $statusHama = 'Risiko Tinggi';
        } elseif (in_array($tingkatHama, ['Ringan', 'Sedang'], true)) {
            $statusHama = 'Perlu Pantauan';
        }
        
        $statusKelembapan = 'Aman';
        if (in_array($indikatorTambahan['kelembapan_tanah'] ?? '', ['Kering', 'Terlalu Basah'])) {
            $statusKelembapan = 'Perlu Pantauan';
        }

        if ($statusVisual === 'Risiko Tinggi' || $statusHama === 'Risiko Tinggi') {
            return 'Risiko Tinggi';
        }

        if ($statusVisual === 'Perlu Pantauan' || $statusHama === 'Perlu Pantauan' || $statusKelembapan === 'Perlu Pantauan') {
            return 'Perlu Pantauan';
        }

        return 'Aman';
    }
}
