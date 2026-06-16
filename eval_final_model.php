
 
 namespace  App\Services; 
 
 class DecisionTreeService 
 { 
 public function evaluate ( $penanaman ):  array 
     { 
         $penanaman->load([ 
 'jenisTanaman' , 
 'pemeliharaans' , 
 'panen' , 
         ]); 
 
 $panen =  $penanaman->panen; 
 $pemeliharaans =  $penanaman->pemeliharaans; 
 
 if  ( ! $panen ) { 
 throw new  \Exception( 'Data panen belum tersedia.' ); 
         } 
 
 if  ( ! $pemeliharaans ||  $pemeliharaans->count()  === 0 ) { 
 throw new  \Exception( 'Data pemeliharaan belum tersedia.' ); 
         } 
 
 $jumlahBibit =  ( int ) $penanaman->jml_bibit; 
 
 if  ( $jumlahBibit <= 0 ) { 
 throw new  \Exception( 'Jumlah bibit tidak valid.' ); 
         } 
 
 $totalTanamanPanen =  ( int ) $panen->tanaman_hidup  +  ( int ) $panen->tanaman_mati; 
 
 if  ( $totalTanamanPanen > $jumlahBibit ) { 
 throw new  \Exception( 'Total tanaman hidup dan mati melebihi jumlah bibit awal.' ); 
         } 
 
 $persentaseHidup = round ((( int ) $panen->tanaman_hidup  / $jumlahBibit )  * 100 ,  2 ); 
 
         [ $targetPanen ,  $hasilPanen ]  =  $this->getTargetDanHasil( $penanaman ,  $panen ); 
 
 if  ( $targetPanen <= 0 ) { 
 throw new  \Exception( 'Target panen belum tersedia.' ); 
         } 
 
 $persentaseHasil = round (( $hasilPanen / $targetPanen )  * 100 ,  2 ); 
 
 $tingkatHamaTerberat =  $this->getHamaTerberat( $pemeliharaans ); 
 $kondisiRisikoTerburuk =  $this->getRisikoTerburuk( $pemeliharaans ); 
 
 $nilaiHama =  $this->nilaiHama( $tingkatHamaTerberat ); 
 $nilaiPertumbuhan =  $this->nilaiPertumbuhan( $kondisiRisikoTerburuk ); 
 
 $skor = min ( 100 ,  round ( 
             ( min ( $persentaseHidup ,  100 )  * 0.4 )  + 
             ( min ( $persentaseHasil ,  100 )  * 0.4 )  + 
             ( $nilaiHama * 0.1 )  + 
             ( $nilaiPertumbuhan * 0.1 ), 
 2 
         )); 
 
 if  ( 
 $persentaseHidup < 50 || 
 $persentaseHasil < 50 || 
 $tingkatHamaTerberat === 'Berat' || 
 $kondisiRisikoTerburuk === 'Risiko Tinggi' 
         ) { 
 $hasilKlasifikasi = 'Gagal' ; 
 $ruleTerpakai = 'Rule Gagal' ; 
         }  elseif  ( 
 $persentaseHidup >= 80 && 
 $persentaseHasil >= 80 && 
 $tingkatHamaTerberat !== 'Berat' && 
 $kondisiRisikoTerburuk !== 'Risiko Tinggi' 
         ) { 
 $hasilKlasifikasi = 'Berhasil' ; 
 $ruleTerpakai = 'Rule Berhasil' ; 
         }  else  { 
 $hasilKlasifikasi = 'Cukup' ; 
 $ruleTerpakai = 'Rule Cukup' ; 
         } 
 
 return  [ 
 'hasil_klasifikasi'  =>  $hasilKlasifikasi , 
 'skor'  =>  $skor , 
 'persentase_hidup'  =>  $persentaseHidup , 
 'persentase_hasil'  =>  $persentaseHasil , 
 'tingkat_hama_terberat'  =>  $tingkatHamaTerberat , 
 'kondisi_risiko_terburuk'  =>  $kondisiRisikoTerburuk , 
 'faktor_utama'  => $this->getFaktorUtama( 
 $persentaseHidup , 
 $persentaseHasil , 
 $tingkatHamaTerberat , 
 $kondisiRisikoTerburuk 
             ), 
 'rekomendasi'  => $this->getRekomendasi( $hasilKlasifikasi ), 
 'rincian_aturan'  => [ 
 'metode'  =>  'Rule-Based Decision Tree' , 
 'rule_terpakai'  =>  $ruleTerpakai , 
 'hasil_klasifikasi'  =>  $hasilKlasifikasi , 
 'skor'  =>  $skor , 
 'persentase_hidup'  =>  $persentaseHidup , 
 'persentase_hasil'  =>  $persentaseHasil , 
 'tingkat_hama_terberat'  =>  $tingkatHamaTerberat , 
 'kondisi_risiko_terburuk'  =>  $kondisiRisikoTerburuk , 
 'target_panen'  =>  $targetPanen , 
 'hasil_panen'  =>  $hasilPanen , 
 'bobot_penilaian'  => [ 
 'tanaman_hidup'  =>  '40%' , 
 'hasil_panen'  =>  '40%' , 
 'hama'  =>  '10%' , 
 'pertumbuhan'  =>  '10%' , 
                 ], 
 'aturan'  => [ 
 'Gagal jika persentase hidup < 50%' , 
 'Gagal jika persentase hasil < 50%' , 
 'Gagal jika hama terberat = Berat' , 
 'Gagal jika risiko pertumbuhan = Risiko Tinggi' , 
 'Berhasil jika persentase hidup >= 80% dan persentase hasil >= 80% tanpa hama berat dan tanpa risiko tinggi' , 
 'Selain kondisi tersebut diklasifikasikan Cukup' , 
                 ], 
             ], 
         ]; 
     } 
 
 private function getTargetDanHasil ( $penanaman ,  $panen ):  array 
     { 
 $satuanTarget =  $penanaman->target_panen_satuan  ??  $panen->satuan_hasil_panen  ?? 'Kg' ; 
 
 if  ( $satuanTarget === 'Kg' ) { 
 $target =  ( float ) ($penanaman->target_panen_jumlah  ??  $penanaman->target_panen_kg  ?? 0 ); 
 $hasil =  ( float ) ($panen->jumlah_hasil_panen  ??  $panen->bobot_panen_kg  ??  $panen->bobot_panen  ?? 0 ); 
 
 return  [ $target ,  $hasil ]; 
         } 
 
 $target =  ( float ) ($penanaman->target_panen_jumlah  ?? 0 ); 
 $hasil =  ( float ) ($panen->jumlah_hasil_panen  ?? 0 ); 
 
 if  ( $target <= 0 || $hasil <= 0 ) { 
 $target =  ( float ) ($penanaman->target_panen_kg  ?? 0 ); 
 $hasil =  ( float ) ($panen->bobot_panen_kg  ??  $panen->bobot_panen  ?? 0 ); 
         } 
 
 return  [ $target ,  $hasil ]; 
     } 
 
 private function getHamaTerberat ( $pemeliharaans ):  string 
     { 
 $level =  [ 
 'Tidak Ada'  =>  0 , 
 'Ringan'  =>  1 , 
 'Sedang'  =>  2 , 
 'Berat'  =>  3 , 
         ]; 
 
 $terberat = 'Tidak Ada' ; 
 
 foreach  ( $pemeliharaans as $pm ) { 
 $hama =  $pm->tingkat_hama  ?? 'Tidak Ada' ; 
 
 if  (( $level [ $hama ]  ?? 0 )  >  ( $level [ $terberat ]  ?? 0 )) { 
 $terberat = $hama ; 
             } 
         } 
 
 return $terberat ; 
     } 
 
 private function getRisikoTerburuk ( $pemeliharaans ):  string 
     { 
 $level =  [ 
 'Aman'  =>  0 , 
 'Perlu Pantauan'  =>  1 , 
 'Risiko Tinggi'  =>  2 , 
         ]; 
 
 $terburuk = 'Aman' ; 
 
 foreach  ( $pemeliharaans as $pm ) { 
 $status =  $pm->status_pertumbuhan; 
 
 if  ( ! $status ) { 
 $status =  $this->fallbackRisiko( $pm ); 
             } 
 
 if  (( $level [ $status ]  ?? 0 )  >  ( $level [ $terburuk ]  ?? 0 )) { 
 $terburuk = $status ; 
             } 
         } 
 
 return $terburuk ; 
     } 
 
 private function fallbackRisiko ( $pm ):  string 
     { 
 $visual =  $pm->kondisi_visual  ??  $pm->kondisi_daun; 
 
 if  ( in_array ( $visual , [ 'Layu' ,  'Gejala Busuk' ,  'Buah Busuk' ,  'Mati Banyak' ],  true )) { 
 return 'Risiko Tinggi' ; 
         } 
 
 if  ( in_array ( $visual , [ 'Menguning' ,  'Tajuk Menguning' ,  'Pertumbuhan Terhambat' ,  'Bunga Rontok' ],  true )) { 
 return 'Perlu Pantauan' ; 
         } 
 
 $indikator =  $pm->indikator_tambahan_json  ??  []; 
 
 if  ( is_string ( $indikator )) { 
 $indikator = json_decode ( $indikator ,  true )  ? : []; 
         } 
 
 if  ( in_array ( $indikator [ 'kelembapan_tanah' ]  ?? null , [ 'Kering' ,  'Terlalu Basah' ],  true )) { 
 return 'Perlu Pantauan' ; 
         } 
 
 return 'Aman' ; 
     } 
 
 private function nilaiHama ( string $hama ):  int 
     { 
 return match  ( $hama ) { 
 'Tidak Ada'  =>  100 , 
 'Ringan'  =>  85 , 
 'Sedang'  =>  60 , 
 'Berat'  =>  0 , 
 default  =>  100 , 
         }; 
     } 
 
 private function nilaiPertumbuhan ( string $status ):  int 
     { 
 return match  ( $status ) { 
 'Aman'  =>  100 , 
 'Perlu Pantauan'  =>  70 , 
 'Risiko Tinggi'  =>  30 , 
 default  =>  100 , 
         }; 
     } 
 
 private function getFaktorUtama ( $hidup ,  $hasil ,  $hama ,  $risiko ):  array 
     { 
 $faktor =  []; 
 
 if  ( $hidup < 50 ) { 
 $faktor []  = 'Persentase tanaman hidup rendah' ; 
         } 
 
 if  ( $hasil < 50 ) { 
 $faktor []  = 'Hasil panen jauh di bawah target' ; 
         } 
 
 if  ( $hama === 'Berat' ) { 
 $faktor []  = 'Serangan hama berat' ; 
         } 
 
 if  ( $risiko === 'Risiko Tinggi' ) { 
 $faktor []  = 'Kondisi pertumbuhan berisiko tinggi' ; 
         } 
 
 if  ( empty ( $faktor )) { 
 $faktor []  = 'Kondisi tanaman dan hasil panen masih dalam batas evaluasi' ; 
         } 
 
 return $faktor ; 
     } 
 
 private function getRekomendasi ( string $hasil ):  array 
     { 
 return match  ( $hasil ) { 
 'Berhasil'  => [ 
 'Pertahankan pola pemeliharaan yang sudah dilakukan.' , 
 'Gunakan data budidaya ini sebagai contoh untuk periode berikutnya.' , 
 'Lanjutkan pemantauan hama dan kondisi pertumbuhan secara rutin.' , 
             ], 
 'Cukup'  => [ 
 'Tingkatkan konsistensi pemeliharaan tanaman.' , 
 'Perbaiki pengendalian hama dan pantau kondisi pertumbuhan lebih sering.' , 
 'Evaluasi target panen agar sesuai dengan kondisi lahan dan jenis tanaman.' , 
             ], 
 'Gagal'  => [ 
 'Lakukan evaluasi menyeluruh terhadap bibit, media tanam, pemeliharaan, dan pengendalian hama.' , 
 'Perbaiki jadwal pemeliharaan dan deteksi risiko sejak fase awal.' , 
 'Gunakan data kegagalan ini sebagai dasar perbaikan siklus tanam berikutnya.' , 
             ], 
 default  => [ 
 'Lakukan pemantauan lanjutan terhadap proses budidaya.' , 
             ], 
         }; 
     } 
 }