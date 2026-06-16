CATATAN PEMBARUAN SISTEM HAWARIFARM / SI TANAM

Fokus pembaruan:
Menyesuaikan sistem agar lebih fleksibel, realistis, dan sesuai dengan alur kerja penanaman, pemeliharaan, panen, serta evaluasi menggunakan Rule-Based Decision Tree.

Tujuan utama:
Sistem tidak hanya cocok untuk satu jenis tanaman atau satuan kilogram saja, tetapi dapat digunakan untuk berbagai jenis tanaman seperti sayuran daun, sayuran buah, umbi, buah, tanaman bumbu, dan tanaman lainnya.

==================================================

1. KONSEP UTAMA SISTEM
   ===================

Sistem menggunakan alur:

Penanaman → Pemeliharaan → Panen → Evaluasi Decision Tree

Pembagian peran:

Siswa:

* Menginput data penanaman.
* Menginput data pemeliharaan.
* Menginput data panen.
* Melihat hasil evaluasi setelah diproses guru.
* Tidak boleh menjalankan proses Decision Tree.

Guru:

* Memantau data siswa.
* Mengecek kelengkapan data.
* Memvalidasi kesiapan data.
* Menjalankan Generate Evaluasi.
* Melihat hasil klasifikasi, skor, faktor utama, rule, dan rekomendasi.

Admin:

* Mengelola pengguna.
* Mengelola data master.
* Monitoring data dan hasil evaluasi.
* Tidak menjadi pemeran utama proses evaluasi.

Sistem:

* Menghitung hasil evaluasi menggunakan Rule-Based Decision Tree.
* Menentukan klasifikasi akhir: Berhasil, Cukup, atau Gagal.
* Menyimpan hasil ke tabel evaluasis.

# ==================================================

2. PEMBARUAN KONSEP TANAMAN

Masalah sebelumnya:
Jenis tanaman diketik manual oleh siswa. Hal ini berisiko menyebabkan data tidak konsisten, misalnya:

* Pakcoy
* Pak coy
* Pakcoy Hijau
* Sawi Pakcoy
* Pakcoyh

Solusi:
Jenis tanaman tidak boleh diketik bebas oleh siswa. Jenis tanaman harus berasal dari data master tanaman yang dibuat oleh guru atau admin.

Tambahkan fitur:
Master Jenis Tanaman

Pengelola:

* Admin boleh mengelola semua master tanaman.
* Guru boleh menentukan tanaman praktik yang aktif.
* Siswa hanya memilih tanaman dari dropdown/searchable dropdown.

Tujuan:
Agar data tanaman konsisten, grafik akurat, dan Decision Tree lebih rapi.

# ==================================================

3. MASTER JENIS TANAMAN

Buat tabel baru:

jenis_tanamans

Kolom yang disarankan:

* id
* nama_tanaman
* kategori_tanaman
* satuan_default
* estimasi_bobot_per_satuan_kg
* umur_panen_hari
* keterangan
* status
* created_at
* updated_at

Contoh isi:

1. Kangkung

* kategori_tanaman: Sayuran Daun
* satuan_default: Ikat
* estimasi_bobot_per_satuan_kg: 0.2
* umur_panen_hari: 25
* status: Aktif

2. Bayam

* kategori_tanaman: Sayuran Daun
* satuan_default: Ikat
* estimasi_bobot_per_satuan_kg: 0.15
* umur_panen_hari: 25
* status: Aktif

3. Pakcoy

* kategori_tanaman: Sayuran Daun
* satuan_default: Buah
* estimasi_bobot_per_satuan_kg: 0.25
* umur_panen_hari: 35
* status: Aktif

4. Cabai

* kategori_tanaman: Sayuran Buah
* satuan_default: Kg
* estimasi_bobot_per_satuan_kg: 1
* umur_panen_hari: 75
* status: Aktif

5. Kentang

* kategori_tanaman: Umbi
* satuan_default: Kg
* estimasi_bobot_per_satuan_kg: 1
* umur_panen_hari: 90
* status: Aktif

# ==================================================

4. KLASIFIKASI TANAMAN

Tambahkan klasifikasi/kategori tanaman agar sistem lebih fleksibel.

Kategori tanaman yang disarankan:

* Sayuran Daun
* Sayuran Buah
* Umbi
* Buah
* Tanaman Bumbu / Herbal
* Lainnya

Contoh:

* Kangkung: Sayuran Daun
* Bayam: Sayuran Daun
* Sawi: Sayuran Daun
* Pakcoy: Sayuran Daun
* Cabai: Sayuran Buah
* Tomat: Sayuran Buah
* Terong: Sayuran Buah
* Timun: Sayuran Buah
* Kentang: Umbi
* Wortel: Umbi
* Singkong: Umbi
* Ubi: Umbi
* Melon: Buah
* Semangka: Buah
* Daun Bawang: Tanaman Bumbu
* Seledri: Tanaman Bumbu

Catatan:
Klasifikasi tanaman berbeda dengan klasifikasi evaluasi.

Klasifikasi tanaman:
Digunakan untuk mengatur jenis tanaman, satuan panen, dan karakteristik budidaya.

Klasifikasi evaluasi:
Hasil akhir Decision Tree, yaitu Berhasil, Cukup, atau Gagal.

# ==================================================

5. PEMBARUAN FORM PENANAMAN SISWA

Form lama:

* Jenis Tanaman
* Tanggal Tanam
* Jumlah Bibit
* Target Panen (Kg)
* Kondisi Tanah
* Lokasi Lahan

Form baru yang disarankan:

* Jenis Tanaman: dropdown dari master tanaman
* Kategori Tanaman: otomatis dari master tanaman
* Tanggal Tanam
* Jumlah Bibit / Populasi Awal
* Target Hasil Panen
* Satuan Target Panen
* Estimasi Bobot per Satuan
* Kondisi Tanah
* Lokasi Lahan

Jenis tanaman tidak diketik manual, tetapi dipilih dari dropdown.

Contoh:
Jenis Tanaman: Kangkung
Kategori: Sayuran Daun
Target Hasil Panen: 50
Satuan Target: Ikat
Estimasi Bobot per Ikat: 0.2 kg

Contoh lain:
Jenis Tanaman: Kentang
Kategori: Umbi
Target Hasil Panen: 20
Satuan Target: Kg
Estimasi Bobot per Satuan: 1 kg

# ==================================================

6. DROPDOWN / SEARCHABLE DROPDOWN TANAMAN

Pada form siswa, gunakan dropdown atau searchable dropdown.

Data pilihan berasal dari tabel jenis_tanamans.

Contoh opsi:

* Kangkung - Sayuran Daun - Ikat
* Bayam - Sayuran Daun - Ikat
* Pakcoy - Sayuran Daun - Buah
* Cabai - Sayuran Buah - Kg
* Tomat - Sayuran Buah - Kg
* Kentang - Umbi - Kg
* Wortel - Umbi - Kg / Ikat

Saat siswa memilih tanaman:

* kategori_tanaman otomatis terisi
* satuan_default otomatis terisi
* estimasi_bobot_per_satuan_kg otomatis terisi
* umur_panen_hari bisa ditampilkan sebagai informasi

# ==================================================

7. PEMBARUAN TABEL PENANAMAN

Pada tabel penanaman, jangan hanya menampilkan:

* tanaman
* tanggal
* bibit
* target
* lokasi

Tambahkan status proses:

* Belum Pemeliharaan
* Dalam Pemeliharaan
* Sudah Panen
* Menunggu Evaluasi Guru
* Sudah Dievaluasi

Tambahkan aksi lanjut:

* Catat Pemeliharaan
* Catat Panen
* Cek Status Evaluasi
* Lihat Evaluasi

Konsep status:

1. Belum Pemeliharaan
   Jika data penanaman sudah dibuat, tetapi belum ada pemeliharaan.
2. Dalam Pemeliharaan
   Jika sudah ada data pemeliharaan, tetapi belum panen.
3. Sudah Panen / Menunggu Evaluasi Guru
   Jika data panen sudah tersedia, tetapi guru belum memproses evaluasi.
4. Sudah Dievaluasi
   Jika data evaluasi sudah ada di tabel evaluasis.

# ==================================================

8. PEMBARUAN SATUAN TARGET PANEN

Masalah sebelumnya:
Target panen hanya menggunakan kilogram.

Padahal tidak semua tanaman dinilai dengan kg.
Contoh:

* Kangkung sering dinilai ikat.
* Bayam sering dinilai ikat.
* Pakcoy bisa buah atau kg.
* Kentang cocok kg.
* Wortel bisa kg atau ikat.
* Cabai cocok kg.
* Tomat cocok kg.

Solusi:
Target panen harus fleksibel.

Tambahkan field:

* target_panen_jumlah
* target_panen_satuan
* estimasi_bobot_per_satuan_kg

Contoh:
Kangkung:

* target_panen_jumlah: 50
* target_panen_satuan: Ikat
* estimasi_bobot_per_satuan_kg: 0.2

Kentang:

* target_panen_jumlah: 20
* target_panen_satuan: Kg
* estimasi_bobot_per_satuan_kg: 1

# ==================================================

9. PEMBARUAN DATA PANEN

Pada modul panen, jangan hanya mengandalkan bobot_panen.

Tambahkan field:

* jumlah_hasil_panen
* satuan_hasil_panen
* bobot_panen_kg

Contoh untuk sayuran daun:

* hasil panen: 45
* satuan: Ikat
* bobot panen kg: opsional atau hasil konversi

Contoh untuk umbi:

* hasil panen: 18
* satuan: Kg
* bobot panen kg: 18

Catatan:
bobot_panen_kg tetap boleh digunakan, tetapi tidak semua komoditas wajib memakai bobot sebagai ukuran utama.

# ==================================================

10. RUMUS HASIL PANEN FLEKSIBEL

Rumus lama:
persentase_hasil = bobot_panen / target_panen_kg × 100

Rumus baru:
Jika satuan target = Kg:
persentase_hasil = bobot_panen_kg / target_panen_jumlah × 100

Jika satuan target = Ikat / Buah / Karung / Tray:
persentase_hasil = jumlah_hasil_panen / target_panen_jumlah × 100

Contoh Kangkung:
Target: 50 ikat
Hasil: 45 ikat
Persentase hasil = 45 / 50 × 100 = 90%

Contoh Kentang:
Target: 20 kg
Hasil: 18 kg
Persentase hasil = 18 / 20 × 100 = 90%

Kesimpulan:
Yang penting bukan satuannya harus kg, tetapi target dan hasil aktual harus dibandingkan menggunakan satuan yang sama.

# ==================================================

11. PEMBARUAN DECISION TREE

Decision Tree tetap menggunakan output akhir:

* Berhasil
* Cukup
* Gagal

Parameter utama:

* persentase_hidup
* persentase_hasil
* tingkat_hama_dominan
* kondisi_daun_dominan

Rumus persentase hidup:
persentase_hidup = tanaman_hidup / jml_bibit × 100

Rumus persentase hasil:
Disesuaikan dengan satuan target panen.

Jika satuan Kg:
persentase_hasil = bobot_panen_kg / target_panen_jumlah × 100

Jika satuan non-Kg:
persentase_hasil = jumlah_hasil_panen / target_panen_jumlah × 100

Rule yang disarankan:

1. Gagal jika:

* persentase_hidup < 50
* atau persentase_hasil < 50
* atau tingkat_hama_dominan = Berat
* atau kondisi_daun_dominan = Layu dan persentase_hasil < 60

2. Berhasil jika:

* persentase_hidup >= 80
* persentase_hasil >= 80
* tingkat_hama_dominan bukan Berat
* kondisi_daun_dominan bukan Layu

3. Selain itu:

* Cukup

Skor:

* persentase_hidup: 40%
* persentase_hasil: 40%
* tingkat_hama: 10%
* kondisi_daun: 10%

Nilai hama:

* Tidak Ada: 100
* Ringan: 85
* Sedang: 60
* Berat: 0

Nilai daun:

* Sehat: 100
* Menguning: 70
* Layu: 30

# ==================================================

12. PEMBARUAN PEMELIHARAAN

Agar Decision Tree lebih kuat, modul pemeliharaan perlu mencatat data yang relevan.

Field penting:

* penanaman_id
* minggu_ke
* tanggal_catat
* tinggi_tanaman
* jml_hidup
* jml_mati
* kondisi_daun
* tingkat_hama
* kegiatan

Jangan hanya memakai info_hama satu kolom jika ingin Decision Tree lebih akademik.

Lebih baik pisahkan:

* kondisi_daun: Sehat, Menguning, Layu
* tingkat_hama: Tidak Ada, Ringan, Sedang, Berat

Dengan pemisahan ini, sistem bisa menentukan:

* kondisi_daun_dominan
* tingkat_hama_dominan

Untuk tingkat hama dominan, gunakan tingkat paling berat yang pernah muncul, bukan yang paling sering muncul.

Urutan berat:
Tidak Ada < Ringan < Sedang < Berat

# ==================================================

13. PEMBARUAN STATUS “SUDAH DIEVALUASI”

Status “Sudah Dievaluasi” berarti data penanaman sudah memiliki record di tabel evaluasis.

Status ini muncul setelah:

1. Siswa mengisi data penanaman.
2. Siswa mengisi data pemeliharaan.
3. Siswa mengisi data panen.
4. Guru membuka modul Evaluasi Panen.
5. Guru menekan Generate Evaluasi.
6. Sistem menjalankan Rule-Based Decision Tree.
7. Sistem menyimpan hasil ke tabel evaluasis.
8. Halaman lain membaca relasi evaluasi dan menampilkan “Sudah Dievaluasi”.

Catatan:
Status “Sudah Dievaluasi” bukan ACC manual.
Guru tidak menentukan hasil secara manual.
Guru hanya menjalankan proses.
Sistem yang menghitung hasil.

Tambahkan field pada evaluasis:

* evaluated_by
* evaluated_at

evaluated_by:
Menyimpan ID guru yang menjalankan evaluasi.

evaluated_at:
Menyimpan waktu proses evaluasi.

Tampilan yang disarankan:
Sudah Dievaluasi
oleh Guru Praktik
14 Jun 2026 14:44

# ==================================================

14. PEMBARUAN MODUL GURU

Modul guru tidak wajib CRUD penuh.

Konsep modul guru:

* Monitoring
* Validasi
* Proses evaluasi
* Melihat hasil
* Memberikan tindak lanjut/rekomendasi

Guru sebaiknya tidak menjadi penginput utama data mentah.

Guru boleh:

* melihat rekap penanaman siswa
* melihat pemeliharaan siswa
* melihat catatan panen siswa
* mengecek data lengkap atau belum
* menekan Generate Evaluasi
* melihat hasil Decision Tree

Guru tidak perlu:

* menginput penanaman siswa
* menginput pemeliharaan siswa
* menginput panen siswa
  kecuali sistem memang menyediakan fitur koreksi/validasi khusus.

Fitur tambahan yang bisa dibuat:

* Validasi Data
* Tolak Data
* Minta Revisi
* Kunci Data
* Catatan Guru

# ==================================================

15. PEMBARUAN MODUL SISWA

Modul siswa menjadi pusat input data praktik.

Siswa boleh:

* membuat data penanaman
* mencatat pemeliharaan
* mencatat panen
* melihat status evaluasi
* melihat hasil evaluasi miliknya sendiri

Siswa tidak boleh:

* memproses Decision Tree
* melihat data siswa lain
* mengubah hasil evaluasi
* mengubah data yang sudah dievaluasi tanpa izin

Halaman siswa harus menampilkan alur:
Penanaman → Pemeliharaan → Panen → Evaluasi Guru

Pada halaman evaluasi siswa:
Jika belum diproses guru:
“Menunggu Evaluasi Guru”

Jika sudah diproses:
Tampilkan:

* hasil klasifikasi
* skor
* persentase hidup
* persentase hasil
* faktor utama
* rekomendasi
* rule terpakai
* waktu evaluasi
* guru yang memproses

# ==================================================

16. PEMBARUAN DATABASE PENANAMAN

Pada tabel penanamen, tambahkan:

* jenis_tanaman_id
* kategori_tanaman
* target_panen_jumlah
* target_panen_satuan
* estimasi_bobot_per_satuan_kg

Kolom lama yang boleh dipertahankan sementara:

* jenis_tanaman
* target_panen_kg

Catatan:
jenis_tanaman dan target_panen_kg boleh dipertahankan sebagai legacy agar sistem lama tidak langsung rusak.

Namun sistem baru sebaiknya memakai:

* jenis_tanaman_id
* target_panen_jumlah
* target_panen_satuan

# ==================================================

17. PEMBARUAN DATABASE PANEN

Pada tabel panens, tambahkan:

* jumlah_hasil_panen
* satuan_hasil_panen
* bobot_panen_kg

Kolom lama:

* bobot_panen

Boleh tetap dipertahankan sementara.

Konsep:

* jumlah_hasil_panen digunakan untuk satuan non-kg seperti ikat, buah, karung, tray.
* bobot_panen_kg digunakan untuk tanaman yang dinilai dengan berat.
* satuan_hasil_panen harus mengikuti satuan target dari penanaman.

# ==================================================

18. PEMBARUAN DATABASE EVALUASI

Pada tabel evaluasis, pastikan ada:

* hasil_klasifikasi
* skor
* persentase_hidup
* persentase_hasil
* faktor_utama
* rekomendasi
* rincian_aturan
* metode_algoritma
* versi_algoritma
* evaluated_by
* evaluated_at

Tujuan:
Agar hasil evaluasi tidak hanya berupa label, tetapi memiliki detail proses dan bukti perhitungan.

# ==================================================

19. PEMBARUAN UI PENANAMAN SISWA

Form penanaman siswa harus diperbarui:

Dari:
Jenis Tanaman: input text

Menjadi:
Jenis Tanaman: dropdown/searchable dropdown dari master tanaman.

Tambahkan:

* kategori tanaman otomatis
* satuan target otomatis
* estimasi bobot per satuan otomatis
* target hasil panen fleksibel

Label yang disarankan:

* Pilih Tanaman
* Kategori Tanaman
* Tanggal Tanam
* Jumlah Bibit / Populasi Awal
* Target Hasil Panen
* Satuan Target
* Estimasi Bobot per Satuan
* Kondisi Tanah
* Lokasi Lahan

Jangan gunakan label:
Target Panen (Kg)
untuk semua tanaman, karena tidak semua tanaman cocok dinilai dengan kg.

Gunakan:
Target Hasil Panen

# ==================================================

20. PEMBARUAN UI PANEN SISWA

Form panen siswa harus mengikuti satuan target dari penanaman.

Jika satuan target Kg:
Tampilkan:

* Bobot Panen (Kg)

Jika satuan target Ikat:
Tampilkan:

* Jumlah Hasil Panen (Ikat)
* Bobot Panen (Kg) opsional

Jika satuan target Buah:
Tampilkan:

* Jumlah Hasil Panen (Buah)
* Bobot Panen (Kg) opsional

Jika satuan target Karung:
Tampilkan:

* Jumlah Hasil Panen (Karung)
* Bobot Panen (Kg) opsional

Tambahkan validasi:

* hasil panen tidak boleh negatif
* tanaman hidup + tanaman mati tidak boleh melebihi jumlah bibit awal
* satuan hasil panen harus sama dengan satuan target

# ==================================================

21. PEMBARUAN UI EVALUASI

Halaman Evaluasi Guru:

* Menampilkan data yang sudah panen.
* Menampilkan status data lengkap atau belum.
* Menampilkan tombol Generate Evaluasi hanya untuk guru.
* Tombol aktif hanya jika data lengkap.
* Setelah diproses, tampilkan hasil Decision Tree.

Halaman Evaluasi Siswa:

* Read-only.
* Tidak ada tombol Generate.
* Jika belum diproses guru, tampilkan Menunggu Evaluasi Guru.
* Jika sudah diproses, tampilkan hasil evaluasi.

Istilah yang harus digunakan:

* Rule-Based Decision Tree
* Hasil Evaluasi Decision Tree
* Jalur Aturan Decision Tree
* Rekomendasi Sistem
* Keputusan Akhir Algoritma

Istilah yang harus dihindari:

* AI
* Prediksi AI
* Mock
* Simulasi
* Uji AI oleh siswa

# ==================================================

22. PEMBARUAN VALIDASI

Validasi penanaman:

* jenis_tanaman_id wajib
* tanggal_tanam wajib
* jumlah bibit minimal 1
* target hasil panen minimal 0.01
* satuan target wajib
* kondisi tanah wajib
* lokasi lahan wajib

Validasi pemeliharaan:

* penanaman_id wajib
* minggu_ke wajib
* tanggal catat wajib
* jumlah hidup tidak boleh negatif
* jumlah mati tidak boleh negatif
* kondisi daun wajib
* tingkat hama wajib

Validasi panen:

* penanaman_id wajib
* tanggal panen wajib
* tanaman hidup wajib
* tanaman mati wajib
* tanaman hidup + tanaman mati tidak boleh melebihi jumlah bibit
* jumlah hasil panen wajib
* satuan hasil panen wajib
* bobot panen kg wajib jika satuan hasil adalah Kg
* bobot panen kg opsional jika satuan hasil bukan Kg

Validasi evaluasi:

* hanya guru yang boleh memproses
* data penanaman harus lengkap
* data pemeliharaan harus tersedia
* data panen harus tersedia
* kondisi daun harus tersedia
* tingkat hama harus tersedia
* target hasil dan hasil aktual harus valid

# ==================================================

23. PEMBARUAN ALUR AKHIR SISTEM

Alur final yang diinginkan:

1. Admin/Guru membuat master tanaman.
2. Siswa memilih tanaman dari dropdown.
3. Sistem otomatis membaca kategori dan satuan default.
4. Siswa menginput data penanaman.
5. Siswa menginput data pemeliharaan secara berkala.
6. Siswa menginput data panen sesuai satuan tanaman.
7. Guru mengecek data.
8. Guru menekan Generate Evaluasi.
9. Sistem menjalankan Rule-Based Decision Tree.
10. Sistem menyimpan hasil evaluasi.
11. Guru melihat hasil dan rekomendasi.
12. Siswa melihat hasil evaluasi miliknya.
13. Admin monitoring data keseluruhan.

# ==================================================

24. TUJUAN AKHIR PEMBARUAN

Sistem harus terlihat realistis, fleksibel, dan tidak kaku.

Sistem tidak boleh hanya cocok untuk tanaman berbasis kilogram.

Sistem harus mendukung:

* sayuran daun berbasis ikat,
* umbi berbasis kg,
* buah berbasis buah atau kg,
* tanaman bumbu berbasis ikat atau gram,
* komoditas lain dengan satuan fleksibel.

Namun hasil akhir Decision Tree tetap sederhana dan jelas:

* Berhasil
* Cukup
* Gagal

Parameter Decision Tree tetap:

* persentase hidup
* persentase hasil
* tingkat hama
* kondisi daun

Dengan pembaruan ini, sistem lebih siap untuk diuji, dijelaskan dalam skripsi, dan dipertanggungjawabkan saat ditanya mengenai fleksibilitas jenis tanaman, satuan panen, status evaluasi, dan alur siswa-guru.
