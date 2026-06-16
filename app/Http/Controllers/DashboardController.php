<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $total_guru = \App\Models\User::where('role', 'guru')->count();
            $total_siswa = \App\Models\User::where('role', 'siswa')->count();
            $total_user = \App\Models\User::count();
            $total_aktivitas = \App\Models\Penanaman::count() + \App\Models\Pemeliharaan::count() + \App\Models\Panen::count(); // Proxy for aktivitas
            
            $recent_users = \App\Models\User::orderBy('created_at', 'desc')->take(5)->get();
            $recent_penanaman = \App\Models\Penanaman::with('siswa')->orderBy('created_at', 'desc')->take(5)->get();
            
            // Data Grafik: Jumlah User per Role
            $chart_roles = ['Guru' => $total_guru, 'Siswa' => $total_siswa, 'Admin' => \App\Models\User::where('role', 'admin')->count()];
            
            return view('admin.dashboard', compact(
                'user', 'total_guru', 'total_siswa', 'total_user', 'total_aktivitas', 
                'recent_users', 'recent_penanaman', 'chart_roles'
            ));
        } elseif ($user->role === 'guru') {
            $total_siswa = \App\Models\User::where('role', 'siswa')->count();
            $penanaman_aktif = \App\Models\Penanaman::doesntHave('panen')->count();
            $panen_bulan_ini = \App\Models\Panen::whereMonth('created_at', now()->month)->count();
            $evaluasi_selesai = \App\Models\Evaluasi::count();

            $recent_penanaman = \App\Models\Penanaman::with(['siswa', 'pemeliharaans'])->orderBy('updated_at', 'desc')->take(5)->get();

            // Coba ambil klasifikasi dari semua evaluasi untuk grafiknya
            $evaluasi_all = \App\Models\Evaluasi::all();
            $chart_evaluasi = [
                'Berhasil' => $evaluasi_all->filter(fn($e) => str_contains($e->hasil_klasifikasi, 'Baik') || str_contains($e->hasil_klasifikasi, 'Cukup'))->count(),
                'Gagal' => $evaluasi_all->filter(fn($e) => str_contains($e->hasil_klasifikasi, 'Gagal'))->count(),
                'Proses' => $penanaman_aktif // Asumsi yang belum panen = proses
            ];

            return view('guru.dashboard', compact(
                'user', 'total_siswa', 'penanaman_aktif', 'panen_bulan_ini', 'evaluasi_selesai',
                'recent_penanaman', 'chart_evaluasi'
            ));
        } else {
            $userId = $user->id;
            
            $totalPenanaman = \App\Models\Penanaman::where('siswa_id', $userId)->count();
            $totalPemeliharaan = \App\Models\Pemeliharaan::whereHas('penanaman', function($q) use ($userId) {
                $q->where('siswa_id', $userId);
            })->count();
            $totalPanen = \App\Models\Panen::whereHas('penanaman', function($q) use ($userId) {
                $q->where('siswa_id', $userId);
            })->count();
            $totalEvaluasi = \App\Models\Evaluasi::whereHas('penanaman', function($q) use ($userId) {
                $q->where('siswa_id', $userId);
            })->count();

            $penanamans = \App\Models\Penanaman::with(['panen', 'evaluasi'])
                            ->where('siswa_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->take(5)
                            ->get();

            return view('siswa.dashboard', compact(
                'user', 'totalPenanaman', 'totalPemeliharaan', 'totalPanen', 'totalEvaluasi', 'penanamans'
            ));
        }
    }
}
