<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JenisTanaman;

class JenisTanamanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'nama_tanaman' => 'Kangkung',
                'kategori_tanaman' => 'Sayuran Daun',
                'satuan_default' => 'Ikat',
                'estimasi_bobot_per_satuan_kg' => 0.2,
                'umur_panen_hari' => 25,
            ],
            [
                'nama_tanaman' => 'Bayam',
                'kategori_tanaman' => 'Sayuran Daun',
                'satuan_default' => 'Ikat',
                'estimasi_bobot_per_satuan_kg' => 0.15,
                'umur_panen_hari' => 25,
            ],
            [
                'nama_tanaman' => 'Pakcoy',
                'kategori_tanaman' => 'Sayuran Daun',
                'satuan_default' => 'Buah',
                'estimasi_bobot_per_satuan_kg' => 0.25,
                'umur_panen_hari' => 35,
            ],
            [
                'nama_tanaman' => 'Cabai',
                'kategori_tanaman' => 'Sayuran Buah',
                'satuan_default' => 'Kg',
                'estimasi_bobot_per_satuan_kg' => 1,
                'umur_panen_hari' => 75,
            ],
            [
                'nama_tanaman' => 'Kentang',
                'kategori_tanaman' => 'Umbi',
                'satuan_default' => 'Kg',
                'estimasi_bobot_per_satuan_kg' => 1,
                'umur_panen_hari' => 90,
            ]
        ];

        foreach ($data as $item) {
            JenisTanaman::updateOrCreate(
                ['nama_tanaman' => $item['nama_tanaman']],
                $item
            );
        }
    }
}
