<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    protected $fillable = [
        'penanaman_id',
        'tgl_panen',
        'tanaman_hidup',
        'tanaman_mati',
        'bobot_panen',
        'jumlah_hasil_panen',
        'satuan_hasil_panen',
        'bobot_panen_kg',
    ];

    protected $casts = [
        'tgl_panen' => 'date',
        'tanaman_hidup' => 'integer',
        'tanaman_mati' => 'integer',
        'bobot_panen' => 'float',
        'jumlah_hasil_panen' => 'float',
        'bobot_panen_kg' => 'float',
    ];

    public function penanaman() { return $this->belongsTo(Penanaman::class, 'penanaman_id'); }
}
