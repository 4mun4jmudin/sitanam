# Dokumentasi Halaman Guru

## Evaluasi Keberhasilan Panen Menggunakan Decision Tree

## 1. Gambaran Umum

Halaman Guru pada sistem HawariFarm / Si Tanam digunakan untuk memantau seluruh proses praktik pertanian siswa, mulai dari pendataan penanaman, pemeliharaan, pencatatan panen, sampai evaluasi keberhasilan panen.

Fokus utama halaman guru adalah membantu guru melihat perkembangan proyek tanam siswa dan melakukan evaluasi hasil panen menggunakan algoritma  **Rule-Based Decision Tree** . Algoritma ini membantu sistem menentukan apakah hasil panen siswa masuk kategori  **Berhasil** ,  **Cukup** , atau **Gagal** berdasarkan data yang sudah dicatat oleh siswa.

Decision Tree tidak berdiri sendiri sebagai menu terpisah, tetapi diterapkan pada menu:

**Evaluasi Panen**

Pada menu ini guru dapat melihat data proyek tanam siswa, mengecek kelengkapan data, memproses evaluasi panen, dan melihat hasil klasifikasi beserta skor, faktor utama, rekomendasi, dan rincian aturan keputusan.

---

# 2. Maksud dan Tujuan

## 2.1 Maksud Sistem

Sistem ini dibuat untuk mendata kegiatan praktik pertanian siswa secara terstruktur, mulai dari proses penanaman hingga panen. Data yang dikumpulkan kemudian digunakan untuk mengevaluasi keberhasilan panen menggunakan algoritma Decision Tree.

Dengan sistem ini, guru tidak hanya melihat data panen secara manual, tetapi juga mendapatkan bantuan analisis dari sistem berdasarkan parameter-parameter yang sudah ditentukan.

## 2.2 Tujuan Sistem

Tujuan utama sistem adalah:

1. Membantu guru memantau perkembangan proyek tanam siswa.
2. Membantu siswa mencatat data penanaman, pemeliharaan, dan panen secara rapi.
3. Membantu guru mengevaluasi keberhasilan panen secara lebih objektif.
4. Mengurangi penilaian yang hanya berdasarkan perkiraan.
5. Menampilkan hasil evaluasi berupa kategori Berhasil, Cukup, atau Gagal.
6. Menampilkan skor evaluasi agar hasil lebih terukur.
7. Menampilkan faktor utama penyebab keberhasilan atau kegagalan panen.
8. Memberikan rekomendasi perbaikan untuk siklus tanam berikutnya.
9. Menyediakan rincian aturan Decision Tree agar proses keputusan sistem dapat dipahami.

---

# 3. Konsep Role pada Sistem

## 3.1 Siswa

Siswa bertugas menginput data.

Data yang diinput siswa meliputi:

* Data penanaman.
* Data pemeliharaan.
* Data panen.

Siswa tidak memproses Decision Tree. Siswa hanya dapat melihat hasil evaluasi setelah guru memprosesnya.

## 3.2 Guru

Guru bertugas memantau dan mengevaluasi data siswa.

Guru dapat:

* Melihat data penanaman siswa.
* Melihat data pemeliharaan siswa.
* Melihat data panen siswa.
* Mengecek kelengkapan data.
* Memproses evaluasi panen.
* Melihat hasil Decision Tree.
* Meninjau faktor utama dan rekomendasi hasil evaluasi.

## 3.3 Admin

Admin bertugas mengelola akun pengguna.

Admin dapat:

* Menambah akun siswa.
* Menambah akun guru.
* Mengedit data pengguna.
* Menghapus atau menonaktifkan akun pengguna.
* Melihat profil akun.

Admin tidak difokuskan untuk memproses evaluasi panen agar tetap sesuai dengan use case sistem.

---

# 4. Menu pada Halaman Guru

Halaman guru terdiri dari beberapa menu utama:

## 4.1 Dashboard

Dashboard menampilkan ringkasan informasi praktik pertanian siswa.

Informasi yang dapat ditampilkan:

* Jumlah siswa bimbingan.
* Jumlah proyek penanaman aktif.
* Jumlah laporan panen.
* Jumlah evaluasi yang sudah selesai.
* Ringkasan hasil evaluasi Decision Tree.

Dashboard berfungsi sebagai halaman pemantauan awal bagi guru.

## 4.2 Rekap Penanaman

Menu ini digunakan untuk melihat data penanaman siswa.

Data yang ditampilkan:

* Nama siswa.
* Jenis tanaman.
* Lokasi lahan.
* Tanggal tanam.
* Jumlah bibit.
* Target panen.
* Kondisi tanah.
* Status proyek.

Data dari menu ini menjadi salah satu sumber input Decision Tree, terutama:

* Jumlah bibit.
* Target panen.

## 4.3 Pemeliharaan

Menu ini digunakan untuk melihat data perkembangan tanaman selama proses budidaya.

Data yang ditampilkan:

* Minggu ke.
* Tanggal pencatatan.
* Tinggi tanaman.
* Jumlah tanaman hidup.
* Jumlah tanaman mati.
* Kondisi daun.
* Tingkat hama.
* Kegiatan pemeliharaan.
* Catatan hama.

Data dari menu ini digunakan untuk melihat kondisi pertumbuhan tanaman sebelum panen.

## 4.4 Catat Panen

Menu ini digunakan untuk melihat atau mencatat data hasil akhir panen.

Data yang digunakan:

* Tanggal panen.
* Bobot panen.
* Jumlah tanaman hidup.
* Jumlah tanaman mati.

Data dari menu ini menjadi dasar utama untuk menghitung:

* Persentase tanaman hidup.
* Persentase hasil panen terhadap target.

## 4.5 Evaluasi Panen

Menu ini merupakan pusat implementasi Decision Tree.

Pada menu ini guru dapat:

* Melihat daftar proyek yang sudah memiliki data panen.
* Melihat status evaluasi.
* Mengecek apakah data sudah siap dievaluasi.
* Membuka detail evaluasi.
* Memproses evaluasi panen.
* Melihat hasil klasifikasi.
* Melihat skor.
* Melihat faktor utama.
* Melihat rekomendasi.
* Melihat rincian aturan Decision Tree.

---

# 5. Alur Sistem dari Awal Sampai Evaluasi

Alur sistem berjalan sebagai berikut:

1. Siswa menginput data penanaman.
2. Siswa menginput data pemeliharaan secara berkala.
3. Siswa menginput data panen setelah kegiatan panen selesai.
4. Guru membuka menu Evaluasi Panen.
5. Sistem mengecek kelengkapan data.
6. Jika data lengkap, tombol Proses Evaluasi Panen akan aktif.
7. Guru menekan tombol Proses Evaluasi Panen.
8. Sistem menjalankan algoritma Decision Tree.
9. Sistem menyimpan hasil evaluasi.
10. Guru dan siswa dapat melihat hasil evaluasi.

Alur ringkas:

Penanaman → Pemeliharaan → Panen → Evaluasi Decision Tree → Hasil Evaluasi

---

# 6. Data yang Digunakan dalam Decision Tree

Decision Tree menggunakan data dari tiga tahap utama.

## 6.1 Data Penanaman

Data yang digunakan:

* Jumlah bibit.
* Target panen.
* Jenis tanaman.

Jumlah bibit digunakan untuk menghitung persentase tanaman hidup.

Target panen digunakan untuk menghitung persentase hasil panen.

## 6.2 Data Pemeliharaan

Data yang digunakan:

* Tinggi tanaman.
* Kondisi daun.
* Tingkat hama.
* Jumlah hidup.
* Jumlah mati.

Kondisi daun digunakan untuk mengetahui kesehatan tanaman.

Tingkat hama digunakan untuk mengetahui tingkat gangguan yang memengaruhi keberhasilan panen.

## 6.3 Data Panen

Data yang digunakan:

* Bobot panen.
* Tanaman hidup.
* Tanaman mati.

Bobot panen digunakan untuk membandingkan hasil panen dengan target panen.

Tanaman hidup digunakan untuk menghitung tingkat keberhasilan tanaman bertahan sampai panen.

---

# 7. Checklist Kesiapan Evaluasi

Sebelum guru memproses evaluasi panen, sistem harus memastikan data sudah lengkap.

Checklist yang harus terpenuhi:

1. Data penanaman tersedia.
2. Jumlah bibit lebih dari 0.
3. Target panen lebih dari 0.
4. Minimal terdapat 1 data pemeliharaan.
5. Kondisi daun tersedia.
6. Tingkat hama tersedia.
7. Data panen tersedia.
8. Bobot panen tersedia.
9. Jumlah tanaman hidup + tanaman mati tidak melebihi jumlah bibit awal.

Jika semua checklist terpenuhi, tombol **Proses Evaluasi Panen** aktif.

Jika ada checklist yang belum terpenuhi, tombol tidak aktif dan guru harus melengkapi data terlebih dahulu.

Checklist ini penting agar Decision Tree tidak memproses data kosong, tidak lengkap, atau tidak valid.

---

# 8. Konsep Perhitungan Decision Tree

Decision Tree menggunakan beberapa nilai hasil perhitungan dari data yang sudah diinput.

## 8.1 Persentase Tanaman Hidup

Rumus:

persentase_hidup = tanaman_hidup / jumlah_bibit × 100

Contoh:

Jumlah bibit = 100
Tanaman hidup = 90

Maka:

persentase_hidup = 90 / 100 × 100 = 90%

Artinya, 90% tanaman berhasil hidup sampai panen.

## 8.2 Persentase Hasil Panen

Rumus:

persentase_hasil = bobot_panen / target_panen × 100

Contoh:

Bobot panen = 22 kg
Target panen = 25 kg

Maka:

persentase_hasil = 22 / 25 × 100 = 88%

Artinya, hasil panen mencapai 88% dari target.

## 8.3 Kondisi Daun Dominan

Sistem melihat data pemeliharaan untuk menentukan kondisi daun yang paling dominan.

Kategori kondisi daun:

* Sehat.
* Menguning.
* Layu.

Kondisi daun menunjukkan kesehatan tanaman selama proses pemeliharaan.

## 8.4 Tingkat Hama Dominan

Sistem melihat tingkat hama dari data pemeliharaan.

Kategori tingkat hama:

* Tidak Ada.
* Ringan.
* Sedang.
* Berat.

Jika pernah terdapat tingkat hama berat, sistem dapat menjadikannya faktor penting dalam evaluasi karena hama berat berpengaruh besar terhadap kegagalan panen.

---

# 9. Aturan Algoritma Decision Tree

Sistem menggunakan  **Rule-Based Decision Tree** , yaitu pohon keputusan berbasis aturan.

## 9.1 Rule Gagal

Jika salah satu kondisi berikut terjadi:

* Persentase tanaman hidup kurang dari 50%.
* Persentase hasil panen kurang dari 50%.
* Tingkat hama dominan adalah Berat.
* Kondisi daun dominan Layu dan hasil panen rendah.

Maka hasil klasifikasi adalah:

**Gagal**

Contoh:

Persentase hidup = 40%
Persentase hasil = 70%
Hama = Ringan

Keputusan:

Karena persentase hidup kurang dari 50%, maka hasilnya  **Gagal** .

## 9.2 Rule Berhasil

Jika semua kondisi berikut terpenuhi:

* Persentase tanaman hidup minimal 80%.
* Persentase hasil panen minimal 80%.
* Tingkat hama bukan Berat.
* Kondisi daun bukan Layu.

Maka hasil klasifikasi adalah:

**Berhasil**

Contoh:

Persentase hidup = 90%
Persentase hasil = 88%
Hama = Ringan
Daun = Sehat

Keputusan:

Karena semua syarat terpenuhi, maka hasilnya  **Berhasil** .

## 9.3 Rule Cukup

Jika data tidak memenuhi kondisi Berhasil, tetapi juga tidak masuk kondisi Gagal, maka hasil klasifikasi adalah:

**Cukup**

Contoh:

Persentase hidup = 70%
Persentase hasil = 65%
Hama = Sedang
Daun = Menguning

Keputusan:

Karena hasil tidak terlalu buruk tetapi belum mencapai standar berhasil, maka hasilnya  **Cukup** .

---

# 10. Perhitungan Skor Evaluasi

Selain menghasilkan kategori, sistem juga menghasilkan skor.

Skor digunakan untuk memberi nilai numerik dari hasil evaluasi.

Bobot skor:

* Persentase tanaman hidup: 40%.
* Persentase hasil panen: 40%.
* Tingkat hama: 10%.
* Kondisi daun: 10%.

Nilai hama:

* Tidak Ada = 100.
* Ringan = 85.
* Sedang = 60.
* Berat = 0.

Nilai daun:

* Sehat = 100.
* Menguning = 70.
* Layu = 30.

Rumus skor:

skor = persentase_hidup × 0.40 + persentase_hasil × 0.40 + nilai_hama × 0.10 + nilai_daun × 0.10

Contoh:

Persentase hidup = 90
Persentase hasil = 88
Hama ringan = 85
Daun sehat = 100

Maka:

skor = 90×0.40 + 88×0.40 + 85×0.10 + 100×0.10
skor = 36 + 35.2 + 8.5 + 10
skor = 89.7

Hasil skor = 89.70 dari 100.

---

# 11. Hasil Evaluasi yang Ditampilkan

Setelah guru memproses evaluasi, sistem menampilkan hasil berikut:

## 11.1 Hasil Klasifikasi

Kategori hasil:

* Berhasil.
* Cukup.
* Gagal.

## 11.2 Skor Evaluasi

Skor ditampilkan dalam angka 0 sampai 100.

Skor menunjukkan tingkat keberhasilan berdasarkan hasil perhitungan sistem.

## 11.3 Persentase Tanaman Hidup

Menampilkan perbandingan jumlah tanaman hidup terhadap jumlah bibit awal.

## 11.4 Persentase Hasil Panen

Menampilkan perbandingan bobot panen terhadap target panen.

## 11.5 Faktor Utama

Faktor utama adalah penyebab paling berpengaruh terhadap hasil evaluasi.

Contoh faktor utama:

* Persentase tanaman hidup tinggi.
* Bobot panen jauh di bawah target.
* Serangan hama berat.
* Kondisi daun dominan layu.
* Persentase tanaman hidup belum maksimal.

## 11.6 Rekomendasi

Rekomendasi adalah saran dari sistem untuk membantu perbaikan pada siklus tanam berikutnya.

Contoh rekomendasi:

* Perbaiki proses penyemaian.
* Tingkatkan pemupukan.
* Lakukan monitoring hama lebih rutin.
* Periksa kebutuhan air dan kualitas media tanam.
* Pertahankan pola pemeliharaan yang sudah baik.

## 11.7 Rincian Aturan

Rincian aturan menampilkan jalur keputusan yang digunakan sistem.

Contoh:

Persentase hidup = 90% → memenuhi syarat >= 80%
Persentase hasil = 88% → memenuhi syarat >= 80%
Tingkat hama = Ringan → bukan Berat
Kondisi daun = Sehat → bukan Layu

Keputusan = Berhasil

Bagian ini penting karena menunjukkan bahwa hasil sistem bukan dipilih manual, tetapi berasal dari aturan Decision Tree.

---

# 12. Penjelasan 5W + 1H

## 12.1 What — Apa yang dilakukan sistem?

Sistem melakukan pendataan kegiatan pertanian siswa dari penanaman hingga panen, lalu melakukan evaluasi keberhasilan panen menggunakan algoritma Decision Tree.

Sistem dapat:

* Mencatat data penanaman.
* Mencatat data pemeliharaan.
* Mencatat data panen.
* Menghitung persentase hidup.
* Menghitung persentase hasil panen.
* Menentukan hasil Berhasil, Cukup, atau Gagal.
* Menampilkan skor.
* Menampilkan faktor utama.
* Memberikan rekomendasi.

## 12.2 Why — Mengapa sistem ini dibuat?

Sistem dibuat agar proses penilaian hasil praktik pertanian siswa lebih terstruktur, objektif, dan mudah dipantau.

Tanpa sistem, guru harus memeriksa data secara manual. Dengan sistem, data dapat dihitung dan dievaluasi secara otomatis berdasarkan aturan yang jelas.

## 12.3 Who — Siapa yang menggunakan sistem?

Pengguna sistem terdiri dari:

* Siswa.
* Guru.
* Admin.

Siswa menginput data.

Guru memantau dan mengevaluasi.

Admin mengelola akun pengguna.

## 12.4 When — Kapan sistem digunakan?

Sistem digunakan selama proses praktik pertanian berlangsung.

Tahap penggunaan:

1. Saat awal penanaman.
2. Saat pemeliharaan mingguan.
3. Saat panen selesai.
4. Saat guru melakukan evaluasi panen.
5. Saat siswa melihat hasil evaluasi.

## 12.5 Where — Di mana Decision Tree diterapkan?

Decision Tree diterapkan pada menu:

**Guru → Evaluasi Panen**

Data yang digunakan berasal dari:

* Penanaman.
* Pemeliharaan.
* Panen.

Hasilnya dapat dilihat oleh guru dan siswa.

## 12.6 How — Bagaimana sistem bekerja?

Sistem bekerja dengan cara:

1. Mengambil data penanaman.
2. Mengambil data pemeliharaan.
3. Mengambil data panen.
4. Mengecek kelengkapan data.
5. Menghitung persentase hidup.
6. Menghitung persentase hasil panen.
7. Menentukan kondisi daun dan tingkat hama.
8. Memproses data menggunakan aturan Decision Tree.
9. Menentukan hasil klasifikasi.
10. Menyimpan hasil evaluasi.
11. Menampilkan hasil kepada guru dan siswa.

---

# 13. Pertanyaan Umum dan Jawaban

## 13.1 Sistem ini bisa apa?

Sistem ini bisa mendata proses praktik pertanian siswa, memantau perkembangan tanaman, mencatat hasil panen, dan mengevaluasi keberhasilan panen menggunakan Decision Tree.

## 13.2 Mengapa menggunakan Decision Tree?

Decision Tree digunakan karena bentuk keputusannya mudah dipahami. Sistem dapat menjelaskan alasan mengapa suatu panen dikategorikan Berhasil, Cukup, atau Gagal.

Decision Tree cocok karena evaluasi panen berbentuk klasifikasi.

## 13.3 Kenapa hasilnya Berhasil?

Hasil dikatakan Berhasil jika tanaman hidup tinggi, hasil panen mencapai target, hama tidak berat, dan kondisi daun tidak buruk.

Contoh:

* Hidup ≥ 80%.
* Hasil ≥ 80%.
* Hama bukan Berat.
* Daun bukan Layu.

## 13.4 Kenapa hasilnya Cukup?

Hasil dikatakan Cukup jika panen belum memenuhi standar Berhasil, tetapi juga tidak masuk kondisi Gagal.

Contoh:

* Hidup 60% sampai 79%.
* Hasil panen sedang.
* Hama ringan atau sedang.
* Kondisi daun tidak terlalu buruk.

## 13.5 Kenapa hasilnya Gagal?

Hasil dikatakan Gagal jika salah satu faktor utama menunjukkan kondisi buruk.

Contoh:

* Hidup kurang dari 50%.
* Hasil panen kurang dari 50%.
* Hama berat.
* Daun layu dan hasil rendah.

## 13.6 Bagaimana skor dihitung?

Skor dihitung dari empat komponen:

* Tanaman hidup.
* Hasil panen.
* Hama.
* Daun.

Persentase tanaman hidup dan hasil panen memiliki bobot terbesar karena keduanya menjadi indikator utama keberhasilan panen.

## 13.7 Apakah hasil evaluasi bisa berubah?

Bisa. Jika data panen atau pemeliharaan diperbarui, guru dapat memproses ulang evaluasi. Sistem akan menghitung ulang berdasarkan data terbaru.

## 13.8 Apakah siswa bisa memproses evaluasi?

Tidak. Siswa hanya menginput data dan melihat hasil. Proses evaluasi dilakukan oleh guru.

## 13.9 Apakah admin bisa memproses evaluasi?

Dalam konsep sistem ini, admin tidak difokuskan untuk memproses evaluasi. Admin hanya mengelola akun pengguna.

## 13.10 Apakah ini machine learning?

Pada tahap ini, sistem menggunakan Rule-Based Decision Tree. Artinya, sistem menggunakan aturan pohon keputusan yang sudah ditentukan berdasarkan indikator keberhasilan panen.

Sistem belum menggunakan training dataset seperti machine learning penuh. Namun, konsep Decision Tree tetap diterapkan dalam bentuk aturan bercabang yang menghasilkan klasifikasi.

---

# 14. Standar Hasil Pencapaian

Sistem dapat dikatakan berhasil jika:

1. Guru dapat melihat data penanaman siswa.
2. Guru dapat melihat data pemeliharaan siswa.
3. Guru dapat melihat data panen siswa.
4. Sistem dapat mengecek kelengkapan data.
5. Tombol evaluasi hanya aktif jika data lengkap.
6. Sistem dapat menghitung persentase hidup.
7. Sistem dapat menghitung persentase hasil panen.
8. Sistem dapat menjalankan aturan Decision Tree.
9. Sistem menghasilkan klasifikasi Berhasil, Cukup, atau Gagal.
10. Sistem menghasilkan skor evaluasi.
11. Sistem menampilkan faktor utama.
12. Sistem menampilkan rekomendasi.
13. Sistem menampilkan rincian aturan.
14. Siswa dapat melihat hasil evaluasi.
15. Guru dapat memproses ulang evaluasi jika data berubah.

---

# 15. Contoh Kasus Evaluasi

## 15.1 Contoh Kasus Berhasil

Data:

* Jumlah bibit = 100.
* Tanaman hidup = 90.
* Bobot panen = 22 kg.
* Target panen = 25 kg.
* Hama = Ringan.
* Daun = Sehat.

Perhitungan:

* Persentase hidup = 90%.
* Persentase hasil = 88%.

Aturan:

* Hidup >= 80%.
* Hasil >= 80%.
* Hama bukan Berat.
* Daun bukan Layu.

Hasil:

**Berhasil**

## 15.2 Contoh Kasus Cukup

Data:

* Jumlah bibit = 100.
* Tanaman hidup = 70.
* Bobot panen = 17 kg.
* Target panen = 25 kg.
* Hama = Sedang.
* Daun = Menguning.

Perhitungan:

* Persentase hidup = 70%.
* Persentase hasil = 68%.

Aturan:

* Tidak memenuhi kategori Berhasil.
* Tidak masuk kategori Gagal.

Hasil:

**Cukup**

## 15.3 Contoh Kasus Gagal

Data:

* Jumlah bibit = 100.
* Tanaman hidup = 40.
* Bobot panen = 20 kg.
* Target panen = 25 kg.
* Hama = Ringan.
* Daun = Sehat.

Perhitungan:

* Persentase hidup = 40%.
* Persentase hasil = 80%.

Aturan:

* Persentase hidup kurang dari 50%.

Hasil:

**Gagal**

---

# 16. Kesimpulan

Halaman Guru menjadi pusat pemantauan dan evaluasi praktik pertanian siswa. Decision Tree diterapkan pada menu Evaluasi Panen untuk membantu guru menentukan keberhasilan panen secara lebih objektif.

Data yang digunakan berasal dari proses penanaman, pemeliharaan, dan panen. Sistem menghitung persentase tanaman hidup, persentase hasil panen, kondisi daun, dan tingkat hama. Kemudian sistem memproses data tersebut menggunakan aturan Decision Tree untuk menghasilkan klasifikasi Berhasil, Cukup, atau Gagal.

Dengan adanya skor, faktor utama, rekomendasi, dan rincian aturan, guru dapat memahami alasan dari setiap hasil evaluasi. Siswa juga dapat mengetahui kekurangan dan perbaikan yang perlu dilakukan pada siklus tanam berikutnya.

Sistem ini tidak hanya berfungsi sebagai media pendataan, tetapi juga sebagai alat bantu evaluasi keberhasilan panen berbasis data.
