<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penanaman extends Model
{
    protected $table = 'penanamen';

    protected $fillable = [
        'siswa_id',
        'jenis_tanaman_id',
        'kategori_tanaman',
        'target_panen_jumlah',
        'target_panen_satuan',
        'estimasi_bobot_per_satuan_kg',
        'jenis_tanaman',
        'lokasi_lahan',
        'tgl_tanam',
        'jml_bibit',
        'target_panen_kg',
        'kondisi_tanah',
    ];

    protected $casts = [
        'tgl_tanam' => 'date',
        'jml_bibit' => 'integer',
        'target_panen_kg' => 'decimal:2',
        'target_panen_jumlah' => 'decimal:2',
        'estimasi_bobot_per_satuan_kg' => 'decimal:2',
    ];

    public function jenisTanaman()
    {
        return $this->belongsTo(JenisTanaman::class, 'jenis_tanaman_id');
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function pemeliharaans()
    {
        return $this->hasMany(Pemeliharaan::class, 'penanaman_id');
    }

    public function panen()
    {
        return $this->hasOne(Panen::class, 'penanaman_id');
    }

    public function evaluasi()
    {
        return $this->hasOne(Evaluasi::class, 'penanaman_id');
    }

    public function getStatusEvaluasiAttribute()
    {
        if ($this->evaluasi) {
            return 'Sudah Dievaluasi';
        }

        $jmlBibit = (int) $this->jml_bibit;
        $targetPanen = (float) ($this->target_panen_jumlah ?? $this->target_panen_kg ?? 0);

        if ($jmlBibit <= 0 || $targetPanen <= 0) {
            return 'Data Awal Kurang';
        }

        if ($this->pemeliharaans->isEmpty()) {
            return 'Menunggu Pemeliharaan';
        }

        if (!$this->panen) {
            return 'Menunggu Panen';
        }

        $bobot = $this->panen->jumlah_hasil_panen ?? $this->panen->bobot_panen;
        $hidup = $this->panen->tanaman_hidup;
        $mati = $this->panen->tanaman_mati;

        if ($bobot === null || $bobot < 0 || $hidup === null || $mati === null || ($hidup + $mati > $jmlBibit)) {
            return 'Data Panen Tidak Valid';
        }

        return 'Siap Evaluasi';
    }
}
