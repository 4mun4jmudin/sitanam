<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Penanaman;
use App\Models\Pemeliharaan;
use App\Models\Panen;
use App\Models\Evaluasi;
use App\Services\DecisionTreeService;
use Faker\Factory as Faker;
use Carbon\Carbon;

class RealisticDummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $decisionTree = new DecisionTreeService();

        // 1. Ensure we have 30 Siswa
        $siswas = User::where('role', 'siswa')->get();
        if ($siswas->count() < 30) {
            for ($i = 0; $i < (30 - $siswas->count()); $i++) {
                User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'password' => bcrypt('password'),
                    'role' => 'siswa',
                ]);
            }
        }
        $siswas = User::where('role', 'siswa')->get();

        // Configuration for realistic crops
        $crops = [
            ['name' => 'Tomat Ceri', 'days_to_harvest' => 70, 'target_per_plant' => 0.5],
            ['name' => 'Cabai Rawit', 'days_to_harvest' => 90, 'target_per_plant' => 0.4],
            ['name' => 'Sawi Hijau', 'days_to_harvest' => 30, 'target_per_plant' => 0.15],
            ['name' => 'Kangkung Cabut', 'days_to_harvest' => 25, 'target_per_plant' => 0.1],
            ['name' => 'Pakcoy', 'days_to_harvest' => 45, 'target_per_plant' => 0.2],
            ['name' => 'Selada Air', 'days_to_harvest' => 40, 'target_per_plant' => 0.15],
            ['name' => 'Bayam Merah', 'days_to_harvest' => 25, 'target_per_plant' => 0.1],
            ['name' => 'Terong Ungu', 'days_to_harvest' => 80, 'target_per_plant' => 0.8],
        ];

        $soilTypes = ['Tanah Gembur', 'Humus', 'Tanah Liat Berpasir', 'Campuran Kompos', 'Tanah Merah'];

        // Scenarios weighting (out of 100): 
        // 40% Sangat Baik/Berhasil
        // 30% Cukup
        // 30% Kurang/Gagal
        
        $this->command->info('Membangun 100 data simulasi proyek budidaya tanaman...');

        for ($i = 1; $i <= 100; $i++) {
            $siswa = $siswas->random();
            $crop = $faker->randomElement($crops);
            
            // Random start date between 6 months ago and 3 months ago
            $startDate = Carbon::now()->subDays(rand(90, 180));
            
            $jmlBibit = rand(10, 50);
            $targetPanen = round($jmlBibit * $crop['target_per_plant'], 2);

            // Determine scenario
            $scenarioRand = rand(1, 100);
            if ($scenarioRand <= 40) {
                $scenario = 'berhasil';
            } elseif ($scenarioRand <= 70) {
                $scenario = 'cukup';
            } else {
                $scenario = 'gagal';
            }

            // 2. Create Penanaman
            $penanaman = Penanaman::create([
                'siswa_id' => $siswa->id,
                'jenis_tanaman' => $crop['name'],
                'lokasi_lahan' => 'Lahan Praktek Blok ' . $faker->randomElement(['A', 'B', 'C', 'D']) . ' No. ' . rand(1, 20),
                'tgl_tanam' => $startDate->format('Y-m-d'),
                'jml_bibit' => $jmlBibit,
                'target_panen_kg' => $targetPanen,
                'kondisi_tanah' => $faker->randomElement($soilTypes),
            ]);

            // 3. Create Pemeliharaan
            $weeks = floor($crop['days_to_harvest'] / 7);
            $currentLive = $jmlBibit;
            $currentDead = 0;
            $height = rand(3, 5); // starting height cm

            for ($w = 1; $w <= $weeks; $w++) {
                $recordDate = $startDate->copy()->addWeeks($w);
                
                // Adjust params based on scenario
                if ($scenario == 'berhasil') {
                    $daun = $faker->randomElement(['Sehat', 'Sehat', 'Sehat', 'Menguning']);
                    $hama = $faker->randomElement(['Tidak Ada', 'Tidak Ada', 'Ringan']);
                    $growth = rand(4, 8);
                    $deathRate = rand(0, 100) > 90 ? 1 : 0; // 10% chance 1 dies
                } elseif ($scenario == 'cukup') {
                    $daun = $faker->randomElement(['Sehat', 'Menguning', 'Layu']);
                    $hama = $faker->randomElement(['Ringan', 'Sedang', 'Tidak Ada']);
                    $growth = rand(2, 6);
                    $deathRate = rand(0, 2);
                } else {
                    $daun = $faker->randomElement(['Menguning', 'Layu', 'Layu']);
                    $hama = $faker->randomElement(['Sedang', 'Berat', 'Berat']);
                    $growth = rand(1, 4);
                    $deathRate = rand(1, 4);
                }

                if ($currentLive - $deathRate >= 0) {
                    $currentLive -= $deathRate;
                    $currentDead += $deathRate;
                }
                
                $height += $growth;

                Pemeliharaan::create([
                    'penanaman_id' => $penanaman->id,
                    'tanggal_catat' => $recordDate->format('Y-m-d'),
                    'minggu_ke' => $w,
                    'kegiatan' => 'Penyiraman & ' . $faker->randomElement(['Pemupukan', 'Penyiangan Gulma', 'Pengecekan Hama', 'Pemberian Nutrisi']),
                    'tinggi_tanaman' => $height,
                    'jml_hidup' => $currentLive,
                    'jml_mati' => $currentDead,
                    'kondisi_daun' => $daun,
                    'tingkat_hama' => $hama,
                    'info_hama' => $hama != 'Tidak Ada' ? 'Terdapat indikasi ' . strtolower($hama) : 'Aman',
                ]);
            }

            // 4. Create Panen
            $harvestDate = $startDate->copy()->addDays($crop['days_to_harvest']);
            
            // Calculate final harvest weight based on scenario and alive plants
            if ($scenario == 'berhasil') {
                $harvestWeight = round($currentLive * $crop['target_per_plant'] * (rand(90, 110) / 100), 2);
            } elseif ($scenario == 'cukup') {
                $harvestWeight = round($currentLive * $crop['target_per_plant'] * (rand(60, 85) / 100), 2);
            } else {
                $harvestWeight = round($currentLive * $crop['target_per_plant'] * (rand(10, 40) / 100), 2);
            }

            $panen = Panen::create([
                'penanaman_id' => $penanaman->id,
                'tgl_panen' => $harvestDate->format('Y-m-d'),
                'tanaman_hidup' => $currentLive,
                'tanaman_mati' => $currentDead,
                'bobot_panen' => $harvestWeight,
            ]);

            // Refresh penanaman to include relations
            $penanaman->load(['pemeliharaans', 'panen', 'siswa']);

            // 5. Evaluate Decision Tree!
            $hasil = $decisionTree->evaluate($penanaman);

            Evaluasi::updateOrCreate(
                ['penanaman_id' => $penanaman->id],
                [
                    'hasil_klasifikasi' => $hasil['hasil_klasifikasi'],
                    'skor' => $hasil['skor'],
                    'persentase_hidup' => $hasil['persentase_hidup'],
                    'persentase_hasil' => $hasil['persentase_hasil'],
                    'faktor_utama' => $hasil['faktor_utama'],
                    'rekomendasi' => $hasil['rekomendasi'],
                    'rincian_aturan' => $hasil['rincian_aturan'],
                    'metode_algoritma' => $hasil['metode_algoritma'],
                    'versi_algoritma' => $hasil['versi_algoritma'],
                    'evaluated_at' => Carbon::now(),
                ]
            );

        }

        $this->command->info('100 Data Simulasi Berhasil Ditambahkan beserta Evaluasi AI!');
    }
}
