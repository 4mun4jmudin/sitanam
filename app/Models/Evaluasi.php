<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluasi extends Model
{
    protected $fillable = [
        'penanaman_id',
        'hasil_klasifikasi',
        'skor',
        'persentase_hidup',
        'persentase_hasil',
        'tingkat_hama_terberat',
        'kondisi_risiko_terburuk',
        'rincian_aturan',
        'faktor_utama',
        'rekomendasi',
        'metode_algoritma',
        'versi_algoritma',
        'evaluated_by',
        'evaluated_at',
    ];

    protected $casts = [
        'skor' => 'decimal:2',
        'persentase_hidup' => 'decimal:2',
        'persentase_hasil' => 'decimal:2',
        'rincian_aturan' => 'array',
        'faktor_utama' => 'array',
        'rekomendasi' => 'array',
        'evaluated_at' => 'datetime',
    ];

    public function penanaman()
    {
        return $this->belongsTo(Penanaman::class, 'penanaman_id');
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluated_by');
    }
}
