<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 leading-tight flex items-center">
                    <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    {{ __('Buku Panduan Siswa') }}
                </h2>
                <div class="flex items-center text-sm text-gray-500 mt-1">
                    <span class="text-gray-700 font-medium">Pelajari alur kerja dan cara sistem menilai hasil panenmu.</span>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-5xl mx-auto space-y-8 pb-12 pt-6">

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute right-0 top-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl transform translate-x-1/2 -translate-y-1/4"></div>
            <h3 class="text-2xl font-black mb-2 relative z-10">Selamat Datang di Si Tanam! 🌱</h3>
            <p class="text-blue-100 max-w-2xl relative z-10">
                Aplikasi ini membantumu mencatat setiap tahapan budidaya tanaman, mulai dari menyemai bibit hingga memanen hasil. Di akhir periode, sistem cerdas kami (Decision Tree) akan mengevaluasi seberapa berhasil proyek pertanianmu berdasarkan data yang kamu catat.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- ALUR KERJA (Timeline) -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h4 class="text-lg font-bold text-gray-900 border-b border-gray-100 pb-4 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        3 Langkah Mudah Menggunakan Aplikasi
                    </h4>
                    
                    <div class="relative pl-8 border-l-2 border-indigo-100 space-y-10">
                        
                        <!-- Step 1 -->
                        <div class="relative">
                            <div class="absolute -left-[41px] bg-white p-1 rounded-full">
                                <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center font-bold text-sm ring-4 ring-white shadow-sm">1</div>
                            </div>
                            <h5 class="text-base font-bold text-gray-800">Mendaftarkan Proyek Penanaman</h5>
                            <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                                Buka menu <strong>Rekap Penanaman</strong> dan klik Tambah Data. Di sini kamu wajib memasukkan:
                            </p>
                            <ul class="mt-3 grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                                <li class="flex items-center text-gray-600 bg-gray-50 p-2 rounded-lg border border-gray-100">
                                    <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Jenis Tanaman (misal: Tomat)
                                </li>
                                <li class="flex items-center text-gray-600 bg-gray-50 p-2 rounded-lg border border-gray-100">
                                    <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Jumlah Bibit Awal
                                </li>
                                <li class="flex items-center text-gray-600 bg-gray-50 p-2 rounded-lg border border-gray-100">
                                    <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Target Panen (dalam Kg)
                                </li>
                            </ul>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative">
                            <div class="absolute -left-[41px] bg-white p-1 rounded-full">
                                <div class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm ring-4 ring-white shadow-sm">2</div>
                            </div>
                            <h5 class="text-base font-bold text-gray-800">Catat Pemeliharaan Rutin</h5>
                            <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                                Setiap minggu, buka menu <strong>Pemeliharaan</strong>. Catat aktivitas yang kamu lakukan (menyiram, memupuk, dll). 
                                <br><span class="text-amber-600 font-semibold text-xs bg-amber-50 px-2 py-0.5 rounded mt-2 inline-block">Penting:</span> Jujurlah saat mengisi <strong>Kondisi Daun</strong> dan <strong>Tingkat Hama</strong> karena ini mempengaruhi nilai evaluasimu!
                            </p>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative">
                            <div class="absolute -left-[41px] bg-white p-1 rounded-full">
                                <div class="w-8 h-8 bg-orange-100 text-orange-600 rounded-full flex items-center justify-center font-bold text-sm ring-4 ring-white shadow-sm">3</div>
                            </div>
                            <h5 class="text-base font-bold text-gray-800">Laporkan Hasil Panen</h5>
                            <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                                Jika masa tanam selesai, buka menu <strong>Catat Panen</strong>. Masukkan total bobot panen aktual dan hitung berapa tanaman yang bertahan hidup dan mati dari total bibit awalmu.
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- BAGAIMANA SISTEM MENILAI -->
            <div class="md:col-span-1 space-y-6">
                
                <div class="bg-slate-900 rounded-2xl shadow-lg border border-slate-800 p-6 text-white relative overflow-hidden">
                    <div class="absolute -right-4 -top-4 w-32 h-32 bg-indigo-500 rounded-full opacity-20 blur-2xl"></div>
                    
                    <h4 class="text-sm font-bold text-indigo-300 uppercase tracking-widest mb-4 flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                        Rahasia Penilaian
                    </h4>
                    
                    <p class="text-sm text-slate-300 mb-5 leading-relaxed">
                        Nilai kelulusan panen <strong>bukan dinilai manual oleh Guru</strong>, melainkan dihitung otomatis oleh AI sistem (Algoritma Decision Tree) menggunakan rapormu:
                    </p>
                    
                    <ul class="space-y-3 text-sm font-medium">
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-emerald-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Target Tercapai (Bobot aktual mendekati target Kg awal).</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-emerald-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Tanaman Hidup Maksimal.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-5 h-5 text-emerald-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Bebas hama berat / Daun layu kronis.</span>
                        </li>
                    </ul>
                </div>

                <!-- Box Hasil -->
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Tingkat Evaluasi</h4>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 rounded-lg bg-emerald-50 border border-emerald-100">
                            <span class="font-bold text-emerald-700 text-sm">BERHASIL</span>
                            <span class="text-xs text-emerald-600 bg-white px-2 py-1 rounded shadow-sm">Target >80%</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-yellow-50 border border-yellow-100">
                            <span class="font-bold text-yellow-700 text-sm">CUKUP</span>
                            <span class="text-xs text-yellow-600 bg-white px-2 py-1 rounded shadow-sm">Sedang</span>
                        </div>
                        <div class="flex items-center justify-between p-3 rounded-lg bg-red-50 border border-red-100">
                            <span class="font-bold text-red-700 text-sm">GAGAL</span>
                            <span class="text-xs text-red-600 bg-white px-2 py-1 rounded shadow-sm">Hama/Mati</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
