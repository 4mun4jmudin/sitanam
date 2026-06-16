<?php

namespace App\Http\Controllers;

use App\Models\JenisTanaman;
use Illuminate\Http\Request;

class JenisTanamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = auth()->user()->role;
        // Hanya Guru dan Admin yang boleh melihat Master Tanaman
        if (!in_array($role, ['guru', 'admin'])) {
            abort(403, 'Unauthorized action.');
        }

        $jenisTanamans = JenisTanaman::orderBy('nama_tanaman', 'asc')->get();
        return view('guru.jenis_tanaman.index', compact('jenisTanamans', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // View can be handled via modal in index
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = auth()->user()->role;
        if (!in_array($role, ['guru', 'admin'])) abort(403);

        $request->validate([
            'nama_tanaman' => 'required|string|max:100',
            'kategori_tanaman' => 'required|string|max:50',
            'satuan_default' => 'required|string|max:20',
            'satuan_opsional' => 'nullable|string',
            'estimasi_bobot_per_satuan_kg' => 'required|numeric|min:0',
            'umur_panen_hari' => 'nullable|integer|min:1',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $data = $request->all();
        if ($request->filled('satuan_opsional')) {
            $data['satuan_opsional'] = array_map('trim', explode(',', $request->satuan_opsional));
        } else {
            $data['satuan_opsional'] = [];
        }

        JenisTanaman::create($data);

        return back()->with('success', 'Master Tanaman berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisTanaman $jenisTanaman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisTanaman $jenisTanaman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisTanaman $jenisTanaman)
    {
        $role = auth()->user()->role;
        if (!in_array($role, ['guru', 'admin'])) abort(403);

        $request->validate([
            'nama_tanaman' => 'required|string|max:100',
            'kategori_tanaman' => 'required|string|max:50',
            'satuan_default' => 'required|string|max:20',
            'satuan_opsional' => 'nullable|string',
            'estimasi_bobot_per_satuan_kg' => 'required|numeric|min:0',
            'umur_panen_hari' => 'nullable|integer|min:1',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Aktif,Tidak Aktif',
        ]);

        $data = $request->all();
        if ($request->filled('satuan_opsional')) {
            $data['satuan_opsional'] = array_map('trim', explode(',', $request->satuan_opsional));
        } else {
            $data['satuan_opsional'] = [];
        }

        $jenisTanaman->update($data);

        return back()->with('success', 'Master Tanaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisTanaman $jenisTanaman)
    {
        $role = auth()->user()->role;
        if (!in_array($role, ['guru', 'admin'])) abort(403);

        $jenisTanaman->delete();

        return back()->with('success', 'Master Tanaman berhasil dihapus.');
    }
}
