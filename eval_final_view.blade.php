
 
 namespace  App\Http\Controllers; 
 
 use  App\Models\Evaluasi; 
 use  App\Models\Panen; 
 use  App\Models\Penanaman; 
 use  App\Services\DecisionTreeService; 
 use  Illuminate\Http\Request; 
 use  Illuminate\Support\Facades\Route; 
 
 class EvaluasiController extends  Controller 
 { 
 public function index ( Request $request ) 
     { 
 $role = strtolower ( auth ()->user()->role); 
 
 $query =  Penanaman::with([ 
 'siswa' , 
 'jenisTanaman' , 
 'pemeliharaans' , 
 'panen' , 
 'evaluasi.evaluator' , 
         ]); 
 
 if  ( $role === 'siswa' ) { 
             $query->where( 'siswa_id' ,  auth ()->id()); 
         } 
 
 if  ($request->filled( 'search' )) { 
 $search =  $request->search; 
 
             $query->where( function  ( $q )  use  ( $search ) { 
                 $q->whereHas( 'siswa' ,  function  ( $siswaQuery )  use  ( $search ) { 
                     $siswaQuery->where( 'name' ,  'like' ,  "% { $search } %" ); 
                 }) 
                 ->orWhere( 'jenis_tanaman' ,  'like' ,  "% { $search } %" ) 
                 ->orWhereHas( 'jenisTanaman' ,  function  ( $jenisQuery )  use  ( $search ) { 
                     $jenisQuery->where( 'nama_tanaman' ,  'like' ,  "% { $search } %" ) 
                         ->orWhere( 'kategori_tanaman' ,  'like' ,  "% { $search } %" ); 
                 }); 
             }); 
         } 
 
 if  ($request->filled( 'status_filter' )) { 
             $query->whereHas( 'evaluasi' ,  function  ( $q )  use  ( $request ) { 
                 $q->where( 'hasil_klasifikasi' , $request->status_filter); 
             }); 
         } 
 
 $perPage =  $request->input( 'per_page' ,  10 ); 
 
 if  ( $perPage === 'all' ) { 
 $count =  ( clone $query )->count(); 
 $penanamans =  $query->latest()->paginate( $count > 0 ? $count  :  1 )->withQueryString(); 
         }  else  { 
 $penanamans =  $query->latest()->paginate(( int )  $perPage )->withQueryString(); 
         } 
 
         $penanamans->getCollection()->transform( function  ( $item ) { 
             $item->status_evaluasi  =  $this->resolveStatusEvaluasi( $item ); 
 return $item ; 
         }); 
 
 $stats = null ; 
 
 if  ( $role !== 'siswa' ) { 
 $totalEvaluasi =  Evaluasi::count(); 
 $berhasil =  Evaluasi::where( 'hasil_klasifikasi' ,  'Berhasil' )->count(); 
 $cukup =  Evaluasi::where( 'hasil_klasifikasi' ,  'Cukup' )->count(); 
 $gagal =  Evaluasi::where( 'hasil_klasifikasi' ,  'Gagal' )->count(); 
 
 $rekorPanen =  Panen::with([ 'penanaman.jenisTanaman' ]) 
                 ->orderByRaw( 'COALESCE(bobot_panen_kg, bobot_panen, 0) DESC' ) 
                 ->first(); 
 
 $evaluasiTerbaik =  Evaluasi::with([ 'penanaman.jenisTanaman' ]) 
                 ->where( 'hasil_klasifikasi' ,  'Berhasil' ) 
                 ->orderByDesc( 'skor' ) 
                 ->first(); 
 
 $stats =  [ 
 'total'  =>  $totalEvaluasi , 
 'berhasil'  =>  $berhasil , 
 'cukup'  =>  $cukup , 
 'gagal'  =>  $gagal , 
 'persentase'  =>  $totalEvaluasi > 0 ? round (( $berhasil / $totalEvaluasi )  * 100 ,  1 ) :  0 , 
 'tanaman_terbaik'  => $evaluasiTerbaik ?-> penanaman ?-> jenisTanaman ?-> nama_tanaman 
 ??  $evaluasiTerbaik ?-> penanaman ?-> jenis_tanaman 
 ?? '-' , 
 'rekor_panen'  =>  $rekorPanen 
 ?  ($rekorPanen->bobot_panen_kg  ??  $rekorPanen->bobot_panen  ?? 0 ) 
                     :  0 , 
             ]; 
         } 
 
 if  ( $role === 'siswa' ) { 
 $viewName = 'siswa.evaluasi.index' ; 
         }  elseif  ( $role === 'admin' && view ()->exists( 'admin.evaluasi.index' )) { 
 $viewName = 'admin.evaluasi.index' ; 
         }  else  { 
 $viewName = 'guru.evaluasi.index' ; 
         } 
 
 return view ( $viewName ,  compact ( 'penanamans' ,  'stats' )); 
     } 
 
 public function proses ( Request $request ,  DecisionTreeService $service ) 
     { 
         $request->validate([ 
 'penanaman_id'  =>  'required|exists:penanamen,id' , 
         ]); 
 
 $role = strtolower ( auth ()->user()->role); 
 
 if  ( $role !== 'guru' ) { 
 abort ( 403 ,  'Hanya guru yang dapat memproses evaluasi.' ); 
         } 
 
 $penanaman =  Penanaman::with([ 
 'siswa' , 
 'jenisTanaman' , 
 'pemeliharaans' , 
 'panen' , 
 'evaluasi' , 
         ])->findOrFail($request->penanaman_id); 
 
 $status =  $this->resolveStatusEvaluasi( $penanaman ); 
 
 if  ( $status !== 'Siap Evaluasi' ) { 
 return back ()->with( 'error' ,  'Data belum siap dievaluasi. Status saat ini: ' . $status ); 
         } 
 
 if  ($penanaman->evaluasi) { 
 return back ()->with( 'error' ,  'Data ini sudah pernah dievaluasi.' ); 
         } 
 
 try  { 
 $hasil =  $service->evaluate( $penanaman ); 
 
             Evaluasi::create([ 
 'penanaman_id'  => $penanaman->id, 
 'hasil_klasifikasi'  =>  $hasil [ 'hasil_klasifikasi' ], 
 'skor'  =>  $hasil [ 'skor' ], 
 'persentase_hidup'  =>  $hasil [ 'persentase_hidup' ], 
 'persentase_hasil'  =>  $hasil [ 'persentase_hasil' ], 
 'tingkat_hama_terberat'  =>  $hasil [ 'tingkat_hama_terberat' ], 
 'kondisi_risiko_terburuk'  =>  $hasil [ 'kondisi_risiko_terburuk' ], 
 'faktor_utama'  =>  $hasil [ 'faktor_utama' ], 
 'rekomendasi'  =>  $hasil [ 'rekomendasi' ], 
 'rincian_aturan'  =>  $hasil [ 'rincian_aturan' ], 
 'evaluated_by'  =>  auth ()->id(), 
 'evaluated_at'  =>  now (), 
             ]); 
 
 return redirect () 
                 ->route( 'guru.evaluasi.index' ) 
                 ->with( 'success' ,  'Evaluasi Rule-Based Decision Tree berhasil diproses.' ); 
         }  catch  ( \Throwable $e ) { 
 return back ()->with( 'error' , $e->getMessage()); 
         } 
     } 
 
 private function resolveStatusEvaluasi ( $penanaman ):  string 
     { 
 $target =  $penanaman->target_panen_jumlah 
 ??  $penanaman->target_panen_kg 
 ?? 0 ; 
 
 $dataAwalLengkap =  ( int ) $penanaman->jml_bibit  > 0 &&  ( float )  $target > 0 ; 
 $hasPemeliharaan =  $penanaman->pemeliharaans  &&  $penanaman->pemeliharaans->count()  > 0 ; 
 $hasPanen =  $penanaman->panen  !== null ; 
 $hasEvaluasi =  $penanaman->evaluasi  !== null ; 
 
 if  ( $hasEvaluasi ) { 
 return 'Sudah Dievaluasi' ; 
         } 
 
 if  ( ! $dataAwalLengkap ) { 
 return 'Data Awal Kurang' ; 
         } 
 
 if  ( ! $hasPemeliharaan ) { 
 return 'Menunggu Pemeliharaan' ; 
         } 
 
 if  ( ! $hasPanen ) { 
 return 'Menunggu Panen' ; 
         } 
 
 $totalTanamanPanen =  ( int ) $penanaman->panen->tanaman_hidup  +  ( int ) $penanaman->panen->tanaman_mati; 
 
 if  ( $totalTanamanPanen >  ( int ) $penanaman->jml_bibit) { 
 return 'Data Awal Kurang' ; 
         } 
 
 return 'Siap Evaluasi' ; 
     } 
 }