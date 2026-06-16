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
        'faktor_utama',
        'rekomendasi',
        'rincian_aturan',
        'evaluated_by',
        'evaluated_at',
    ];

    protected $casts = [
        'skor' => 'float',
        'persentase_hidup' => 'float',
        'persentase_hasil' => 'float',
        'faktor_utama' => 'array',
        'rekomendasi' => 'array',
        'rincian_aturan' => 'array',
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