<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTanaman extends Model
{
    use HasFactory;

    protected $table = 'jenis_tanamans';

    protected $fillable = [
        'nama_tanaman',
        'kategori_tanaman',
        'satuan_default',
        'satuan_opsional',
        'estimasi_bobot_per_satuan_kg',
        'umur_panen_hari',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'satuan_opsional' => 'array',
    ];
}
