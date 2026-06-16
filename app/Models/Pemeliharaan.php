<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemeliharaan extends Model
{
    protected $guarded = [];

    protected $casts = [
        'tanggal_catat' => 'date',
        'kegiatan_json' => 'array',
        'indikator_tambahan_json' => 'array',
    ];

    public function penanaman() { return $this->belongsTo(Penanaman::class, 'penanaman_id'); }
}
