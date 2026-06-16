
    @php
        $role = strtolower(auth()->user()->role);
        $routeName = $role . '.evaluasi.index';
        $indexRoute = \Illuminate\Support\Facades\Route::has($routeName)
            ? route($routeName)
            : route('guru.evaluasi.index');
    @endphp

    
        
            
                
                    {{ __('Evaluasi Keputusan Panen Akhir') }}
                
                
                    Dashboard
                    
                        
                    
                    Evaluasi Panen Akhir
                
                
                    Proses evaluasi panen menggunakan metode Rule-Based Decision Tree berdasarkan data penanaman, pemeliharaan, dan panen.
                
            
        
    

    

        @if(session('success'))
            
                
                    
                
                
                    Evaluasi Berhasil!
                    {{ session('success') }}
                
            
        @endif

        @if(session('error'))
            
                
                    
                
                
                    Gagal Memproses Evaluasi
                    {{ session('error') }}
                
            
        @endif

        @if($errors->any())
            
                Terdapat Kesalahan:
                
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                
            
        @endif

        @if(isset($stats))
            
                
                    Total Evaluasi
                    {{ $stats['total'] ?? 0 }}
                

                
                    Berhasil
                    {{ $stats['berhasil'] ?? 0 }}
                

                
                    Cukup
                    {{ $stats['cukup'] ?? 0 }}
                

                
                    Gagal
                    {{ $stats['gagal'] ?? 0 }}
                
            
        @endif

        
            
                
                    
                        
                            Monitoring Evaluasi Decision Tree
                        

                        
                            
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari siswa/tanaman..."
                                   class="w-full sm:w-64 py-2 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">

                            
                                    class="w-full sm:w-auto py-2 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                Semua Hasil
                                Berhasil
                                Cukup
                                Gagal
                            

                            
                                    class="w-full sm:w-auto py-2 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm shadow-sm">
                                10 Data
                                20 Data
                                50 Data
                                100 Data
                                Semua Data
                            

                            
                                    class="px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-bold hover:bg-indigo-700 transition">
                                Filter
                            
                        
                    

                    
                        
                            
                                
                                    No
                                    Identitas Proyek
                                    Data Panen
                                    @if($role === 'guru')
                                        Faktor Utama
                                    @endif
                                    Status / Hasil
                                    Aksi
                                
                            

                            
                                @forelse($penanamans as $idx => $item)
                                    @php
                                        $namaSiswa = $item->siswa->name ?? 'N/A';
                                        $namaTanaman = $item->jenisTanaman->nama_tanaman ?? $item->jenis_tanaman ?? '-';

                                        $hasilPanen = $item->panen->jumlah_hasil_panen ?? $item->panen->bobot_panen ?? null;
                                        $satuanPanen = $item->panen->satuan_hasil_panen ?? $item->target_panen_satuan ?? 'Kg';
                                        $bobotKg = $item->panen->bobot_panen_kg ?? $item->panen->bobot_panen ?? null;

                                        $status = $item->status_evaluasi ?? 'Data Awal Kurang';

                                        $statusClass = 'bg-gray-100 text-gray-600 border-gray-200';
                                        if($status === 'Siap Evaluasi') $statusClass = 'bg-blue-100 text-blue-700 border-blue-300';
                                        elseif($status === 'Menunggu Panen') $statusClass = 'bg-orange-100 text-orange-700 border-orange-300';
                                        elseif($status === 'Menunggu Pemeliharaan') $statusClass = 'bg-yellow-100 text-yellow-700 border-yellow-300';
                                        elseif($status === 'Data Awal Kurang') $statusClass = 'bg-red-100 text-red-700 border-red-300';
                                        elseif($status === 'Sudah Dievaluasi') $statusClass = 'bg-emerald-100 text-emerald-700 border-emerald-300';

                                        $faktor = [];
                                        $rekomendasi = [];
                                        $rincian = [];

                                        if($item->evaluasi) {
                                            $faktor = $item->evaluasi->faktor_utama ?? [];
                                            $rekomendasi = $item->evaluasi->rekomendasi ?? [];
                                            $rincian = $item->evaluasi->rincian_aturan ?? [];

                                            if(is_string($faktor)) $faktor = json_decode($faktor, true) ?: [$faktor];
                                            if(is_string($rekomendasi)) $rekomendasi = json_decode($rekomendasi, true) ?: [$rekomendasi];
                                            if(is_string($rincian)) $rincian = json_decode($rincian, true) ?: [];
                                        }

                                        $modalPayload = [
                                            'siswa' => $namaSiswa,
                                            'tanaman' => $namaTanaman,
                                            'jml_bibit' => $item->jml_bibit,
                                            'target' => $item->target_panen_jumlah ?? $item->target_panen_kg ?? 0,
                                            'satuan_target' => $item->target_panen_satuan ?? 'Kg',
                                            'panen' => [
                                                'hasil' => $hasilPanen,
                                                'satuan' => $satuanPanen,
                                                'bobot_kg' => $bobotKg,
                                                'tanaman_hidup' => $item->panen->tanaman_hidup ?? 0,
                                                'tanaman_mati' => $item->panen->tanaman_mati ?? 0,
                                                'tgl_panen' => $item->panen->tgl_panen ?? null,
                                            ],
                                            'evaluasi' => $item->evaluasi ? [
                                                'hasil_klasifikasi' => $item->evaluasi->hasil_klasifikasi,
                                                'skor' => $item->evaluasi->skor,
                                                'persentase_hidup' => $item->evaluasi->persentase_hidup,
                                                'persentase_hasil' => $item->evaluasi->persentase_hasil,
                                                'tingkat_hama_terberat' => $item->evaluasi->tingkat_hama_terberat,
                                                'kondisi_risiko_terburuk' => $item->evaluasi->kondisi_risiko_terburuk,
                                                'faktor_utama' => $faktor,
                                                'rekomendasi' => $rekomendasi,
                                                'rincian_aturan' => $rincian,
                                                'evaluated_by' => $item->evaluasi->evaluator->name ?? 'Guru',
                                                'evaluated_at' => optional($item->evaluasi->evaluated_at)->format('Y-m-d H:i:s'),
                                            ] : null,
                                        ];
                                    @endphp

                                    
                                        
                                            {{ method_exists($penanamans, 'firstItem') ? $penanamans->firstItem() + $idx : $idx + 1 }}
                                        

                                        
                                            
                                                
                                                    {{ substr($namaSiswa, 0, 1) }}
                                                
                                                
                                                    {{ $namaSiswa }}
                                                    {{ $namaTanaman }}
                                                    
                                                        Bibit: {{ $item->jml_bibit }} |
                                                        Target: {{ $item->target_panen_jumlah ?? $item->target_panen_kg ?? '-' }} {{ $item->target_panen_satuan ?? 'Kg' }}
                                                    
                                                
                                            
                                        

                                        
                                            @if($item->panen)
                                                
                                                    {{ $hasilPanen }} {{ $satuanPanen }}
                                                
                                                @if($satuanPanen !== 'Kg')
                                                    
                                                        Konversi: {{ $bobotKg }} Kg
                                                    
                                                @endif
                                                
                                                    {{ \Carbon\Carbon::parse($item->panen->tgl_panen)->translatedFormat('d F Y') }}
                                                
                                            @else
                                                Belum panen
                                            @endif
                                        

                                        @if($role === 'guru')
                                            
                                                @if($item->evaluasi && count($faktor))
                                                    
                                                          title="{{ implode(', ', $faktor) }}">
                                                        {{ $faktor[0] ?? '-' }}
                                                    
                                                @else
                                                    Belum dievaluasi
                                                @endif
                                            
                                        @endif

                                        
                                            @if(!$item->evaluasi)
                                                
                                                    {{ $status }}
                                                
                                                Belum ada hasil evaluasi
                                            @else
                                                @php
                                                    $klas = $item->evaluasi->hasil_klasifikasi;
                                                    $badge = 'bg-gray-100 text-gray-600 border-gray-200';

                                                    if($klas === 'Berhasil') $badge = 'bg-emerald-100 text-emerald-700 border-emerald-300';
                                                    elseif($klas === 'Cukup') $badge = 'bg-yellow-100 text-yellow-700 border-yellow-300';
                                                    elseif($klas === 'Gagal') $badge = 'bg-red-100 text-red-700 border-red-300';
                                                @endphp

                                                
                                                    
                                                        {{ $klas }}
                                                    
                                                    
                                                        Skor: {{ $item->evaluasi->skor ?? 0 }}
                                                    
                                                
                                            @endif
                                        

                                        
                                            @if(!$item->evaluasi && $role === 'guru' && $status === 'Siap Evaluasi')
                                                
                                                      onsubmit="return confirm('Proses evaluasi Rule-Based Decision Tree untuk data ini?')">
                                                    @csrf
                                                    id }}">
                                                    
                                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700 transition">
                                                        Proses Decision Tree
                                                    
                                                
                                            @elseif(!$item->evaluasi)
                                                
                                                    {{ $status }}
                                                
                                            @else
                                                
                                                        type="button"
                                                        class="inline-flex items-center px-3 py-1.5 rounded-lg border border-indigo-200 text-indigo-600 bg-indigo-50 hover:bg-indigo-100 text-xs font-bold transition">
                                                    Detail Evaluasi
                                                
                                            @endif
                                        
                                    
                                @empty
                                    
                                        
                                            
                                                
                                                    
                                                        
                                                    
                                                
                                                Data evaluasi kosong.
                                                
                                                    Belum ada data penanaman yang tersedia untuk proses evaluasi.
                                                
                                            
                                        
                                    
                                @endforelse
                            
                        
                    

                    @if(method_exists($penanamans, 'hasPages') && $penanamans->hasPages())
                        
                            {{ $penanamans->links() }}
                        
                    @endif
                
            

            @if(isset($stats))
                
                    
                        
                            Rule-Based Decision Tree
                        

                        
                            
                        

                        
                            Komparasi hasil klasifikasi Berhasil, Cukup, dan Gagal.
                        
                    

                    
                        
                            Ringkasan
                        

                        
                            
                                
                                    Tanaman Terbaik
                                    
                                        {{ $stats['tanaman_terbaik'] ?? '-' }}
                                    
                                
                            

                            
                                
                                    Rekor Panen Tertinggi
                                    
                                        {{ $stats['rekor_panen'] ?? 0 }} Kg
                                    
                                
                            

                            
                                
                                    Success Rate
                                    
                                        {{ $stats['persentase'] ?? 0 }}%
                                    
                                
                            
                        
                    
                
            @endif
        

        
            
                

                
                    
                        
                             x-transition
                             @click.outside="modalOpen = false"
                             class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-4xl border border-gray-100">

                            
                                
                                    
                                        
                                            Detail Evaluasi Decision Tree
                                        
                                        
                                            Jalur Aturan Keputusan
                                        
                                    

                                    
                                            @click="modalOpen = false"
                                            class="text-slate-400 hover:text-white transition bg-slate-800 p-2 rounded-xl border border-slate-700 hover:bg-slate-700">
                                        
                                            
                                        
                                    
                                

                                
                                    
                                        
                                            
                                                 x-text="activeData.siswa ? activeData.siswa[0] : 'U'">
                                            
                                            
                                                  x-text="activeData.tanaman">
                                        

                                        
                                            Ringkasan Data
                                            
                                                
                                                    Bibit Awal
                                                    
                                                
                                                
                                                    Target
                                                    
                                                        
                                                        
                                                    
                                                
                                                
                                                    Hasil Panen
                                                    
                                                        
                                                        
                                                    
                                                
                                                
                                                    Konversi Kg
                                                    
                                                
                                                
                                                    Hidup / Mati
                                                    
                                                        
                                                        /
                                                        
                                                    
                                                
                                            
                                        
                                    

                                    
                                        
                                            
                                                Keputusan Akhir
                                                
                                                    :class="aiData.hasil_klasifikasi === 'Berhasil' ? 'text-emerald-600' : (aiData.hasil_klasifikasi === 'Cukup' ? 'text-yellow-600' : 'text-red-600')"
                                                    x-text="aiData.hasil_klasifikasi">

                                                
                                                    
                                                        Dievaluasi Oleh:
                                                        
                                                    
                                                    
                                                        Waktu:
                                                        
                                                    
                                                
                                            

                                            
                                                 :class="aiData.hasil_klasifikasi === 'Berhasil' ? 'border-emerald-50 bg-emerald-500' : (aiData.hasil_klasifikasi === 'Cukup' ? 'border-yellow-50 bg-yellow-500' : 'border-red-50 bg-red-500')">
                                                
                                            
                                        

                                        
                                            
                                                Jalur Aturan Decision Tree
                                            

                                            
                                                
                                                    Persentase Hidup
                                                    
                                                

                                                
                                                    Persentase Hasil
                                                    
                                                

                                                
                                                    Hama Terberat
                                                    
                                                

                                                
                                                    Risiko Pertumbuhan
                                                    
                                                

                                                
                                                    Rule Terpakai
                                                    
                                                

                                                
                                                    Keputusan
                                                    
                                                
                                            
                                        

                                        
                                            
                                                Faktor Utama
                                            
                                            
                                                
                                                    • 
                                                
                                            
                                        

                                        
                                            
                                                Rekomendasi Sistem
                                            
                                            
                                                
                                                    • 
                                                
                                            
                                        
                                    
                                

                                
                                    
                                            @click="modalOpen = false"
                                            class="rounded-xl bg-slate-800 px-6 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-slate-900 transition">
                                        Tutup Detail
                                    
                                
                            
                        
                    
                
            
        
    

    
    
        document.addEventListener('alpine:init', () => {
            Alpine.data('evaluasiSistem', () => ({
                modalOpen: false,
                activeData: {},
                aiData: {
                    hasil_klasifikasi: '-',
                    skor: 0,
                    persentase_hidup: 0,
                    persentase_hasil: 0,
                    tingkat_hama_terberat: '-',
                    kondisi_risiko_terburuk: '-',
                    faktor_utama: [],
                    rekomendasi: [],
                    rincian_aturan: {},
                    evaluated_by: '-',
                    evaluated_at: '-',
                },

                openDetailModal(payload) {
                    this.activeData = payload || {};

                    const evaluasi = payload.evaluasi || {};

                    this.aiData = {
                        hasil_klasifikasi: evaluasi.hasil_klasifikasi || '-',
                        skor: evaluasi.skor || 0,
                        persentase_hidup: evaluasi.persentase_hidup || 0,
                        persentase_hasil: evaluasi.persentase_hasil || 0,
                        tingkat_hama_terberat: evaluasi.tingkat_hama_terberat || '-',
                        kondisi_risiko_terburuk: evaluasi.kondisi_risiko_terburuk || '-',
                        faktor_utama: Array.isArray(evaluasi.faktor_utama) ? evaluasi.faktor_utama : [],
                        rekomendasi: Array.isArray(evaluasi.rekomendasi) ? evaluasi.rekomendasi : [],
                        rincian_aturan: evaluasi.rincian_aturan || {},
                        evaluated_by: evaluasi.evaluated_by || '-',
                        evaluated_at: evaluasi.evaluated_at || '-',
                    };

                    this.modalOpen = true;
                },
            }));
        });

        document.addEventListener("DOMContentLoaded", function() {
            @if(isset($stats))
                const ctxEval = document.getElementById('evalChart');

                if (ctxEval) {
                    new Chart(ctxEval.getContext('2d'), {
                        type: 'pie',
                        data: {
                            labels: ['Berhasil', 'Cukup', 'Gagal'],
                            datasets: [{
                                data: [
                                    {{ $stats['berhasil'] ?? 0 }},
                                    {{ $stats['cukup'] ?? 0 }},
                                    {{ $stats['gagal'] ?? 0 }}
                                ],
                                backgroundColor: ['#10B981', '#EAB308', '#F43F5E'],
                                borderWidth: 2,
                                borderColor: '#4f46e5',
                                hoverOffset: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        color: '#e0e7ff',
                                        boxWidth: 10,
                                        font: { family: 'Inter', size: 10 }
                                    }
                                }
                            }
                        }
                    });
                }
            @endif
        });
    
