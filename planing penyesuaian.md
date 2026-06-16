# Si Tanam: Executable Implementation Plan Decision Tree

## Judul Penelitian

**Sistem pendataan penanaman hingga panen menggunakan algoritma Decision Tree untuk evaluasi keberhasilan panen**

## Tujuan Implementasi

Implementasikan fitur evaluasi keberhasilan panen menggunakan **Rule-Based Decision Tree** tanpa mengubah struktur use case utama yang sudah ada.

Decision Tree tidak dibuat sebagai use case baru, tetapi dimasukkan sebagai proses internal pada use case:

**Melihat Hasil Evaluasi Panen**

Dengan demikian, alur sistem tetap sesuai dengan use case:

1. Login
2. Akses Data Penanaman
3. Akses Data Pemeliharaan
4. Akses Data Panen
5. Melihat Hasil Evaluasi Panen
6. Kelola Akun Pengguna
7. Melihat Profil Pengguna

---

# 1. Role dan Hak Akses

## Siswa

Siswa bertugas menginput dan melihat data miliknya sendiri.

Fitur siswa:

* Login
* Akses Data Penanaman
* Akses Data Pemeliharaan
* Akses Data Panen
* Melihat Hasil Evaluasi Panen
* Melihat Profil Pengguna

Siswa tidak boleh memproses Decision Tree.

## Guru

Guru bertugas memantau data siswa dan memproses evaluasi panen.

Fitur guru:

* Login
* Akses Data Penanaman siswa
* Akses Data Pemeliharaan siswa
* Akses Data Panen siswa
* Melihat dan memproses Hasil Evaluasi Panen
* Melihat Profil Pengguna

Guru adalah aktor utama yang menjalankan proses evaluasi panen.

## Admin

Admin hanya mengelola akun dan profil sesuai use case.

Fitur admin:

* Login
* Kelola Akun Pengguna
* Melihat Profil Pengguna

Admin tidak perlu diberi tombol proses evaluasi panen agar tetap sinkron dengan use case diagram.

---

# 2. Prinsip Implementasi Decision Tree

Implementasi tahap ini menggunakan:

**Rule-Based Decision Tree**

Artinya sistem menggunakan aturan pohon keputusan berbasis kondisi, bukan library machine learning seperti PHP-ML atau Rubix ML.

Alasan:

* Data historis belum tentu cukup banyak.
* Sistem dapat langsung digunakan.
* Cocok untuk penelitian tahap implementasi sistem.
* Mudah dijelaskan dalam laporan skripsi.
* Tetap sesuai dengan judul karena sistem menggunakan alur Decision Tree untuk evaluasi keberhasilan panen.

Catatan penting:

Jangan klaim sistem sebagai Decision Tree Machine Learning penuh jika belum ada proses training dataset, testing, akurasi, dan confusion matrix.

Gunakan istilah:

**Rule-Based Decision Tree untuk evaluasi keberhasilan panen**

---

# 3. Struktur Database yang Sudah Ada

Gunakan tabel yang sudah ada:

* `penanamen`
* `pemeliharaans`
* `panens`
* `evaluasis`
* `users`

Jangan mengubah nama tabel `penanamen`, karena struktur database saat ini memang menggunakan nama tersebut.

---

# 4. Database Migration

Buat migration baru:

```bash
php artisan make:migration enhance_decision_tree_columns_for_si_tanam
```

## 4.1 Tabel `penanamen`

Tambahkan kolom jika belum ada:

```php
$table->decimal('target_panen_kg', 8, 2)->nullable()->after('jml_bibit');
```

Kolom ini digunakan untuk menghitung:

```text
persentase_hasil = bobot_panen / target_panen_kg * 100
```

## 4.2 Tabel `pemeliharaans`

Tambahkan kolom jika belum ada:

```php
$table->enum('kondisi_daun', ['Sehat', 'Menguning', 'Layu'])
    ->nullable()
    ->after('tinggi_tanaman');

$table->enum('tingkat_hama', ['Tidak Ada', 'Ringan', 'Sedang', 'Berat'])
    ->nullable()
    ->after('info_hama');
```

Kolom `info_hama` tetap dipakai sebagai catatan tambahan.

## 4.3 Tabel `evaluasis`

Tabel `evaluasis` sudah memiliki:

* `hasil_klasifikasi`
* `rincian_aturan`

Jangan buat ulang dua kolom tersebut.

Tambahkan kolom jika belum ada:

```php
$table->decimal('skor', 5, 2)->nullable()->after('hasil_klasifikasi');

$table->decimal('persentase_hidup', 5, 2)->nullable()->after('skor');

$table->decimal('persentase_hasil', 5, 2)->nullable()->after('persentase_hidup');

$table->json('faktor_utama')->nullable()->after('rincian_aturan');

$table->json('rekomendasi')->nullable()->after('faktor_utama');

$table->string('metode_algoritma')
    ->default('rule_based_decision_tree')
    ->after('rekomendasi');

$table->string('versi_algoritma')
    ->default('v1.0')
    ->after('metode_algoritma');

$table->timestamp('evaluated_at')->nullable()->after('versi_algoritma');
```

Gunakan `Schema::hasColumn()` agar migration aman dijalankan dan tidak membuat duplicate column.

---

# 5. Model yang Perlu Disesuaikan

## 5.1 Model `Penanaman`

Pastikan model memakai tabel:

```php
protected $table = 'penanamen';
```

Tambahkan fillable:

```php
protected $fillable = [
    'siswa_id',
    'jenis_tanaman',
    'lokasi_lahan',
    'tgl_tanam',
    'jml_bibit',
    'target_panen_kg',
    'kondisi_tanah',
];
```

Tambahkan casts:

```php
protected $casts = [
    'tgl_tanam' => 'date',
    'jml_bibit' => 'integer',
    'target_panen_kg' => 'decimal:2',
];
```

Pastikan relasi:

```php
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
```

## 5.2 Model `Evaluasi`

Tambahkan fillable:

```php
protected $fillable = [
    'penanaman_id',
    'hasil_klasifikasi',
    'skor',
    'persentase_hidup',
    'persentase_hasil',
    'rincian_aturan',
    'faktor_utama',
    'rekomendasi',
    'metode_algoritma',
    'versi_algoritma',
    'evaluated_at',
];
```

Tambahkan casts:

```php
protected $casts = [
    'skor' => 'decimal:2',
    'persentase_hidup' => 'decimal:2',
    'persentase_hasil' => 'decimal:2',
    'rincian_aturan' => 'array',
    'faktor_utama' => 'array',
    'rekomendasi' => 'array',
    'evaluated_at' => 'datetime',
];
```

Relasi:

```php
public function penanaman()
{
    return $this->belongsTo(Penanaman::class, 'penanaman_id');
}
```

---

# 6. Decision Tree Service

Buat file:

```text
app/Services/DecisionTreeService.php
```

Service ini bertugas mengambil data dari:

* `penanamen`
* `pemeliharaans`
* `panens`

Lalu menghitung fitur Decision Tree:

* `persentase_hidup`
* `persentase_hasil`
* `tinggi_rata_rata`
* `kondisi_daun_dominan`
* `tingkat_hama_dominan`

## Rumus

```text
persentase_hidup = tanaman_hidup / jml_bibit * 100
```

```text
persentase_hasil = bobot_panen / target_panen_kg * 100
```

## Aturan Decision Tree

### Rule Gagal

Jika salah satu kondisi berikut terpenuhi:

* `persentase_hidup < 50`
* `persentase_hasil < 50`
* `tingkat_hama_dominan = Berat`
* `kondisi_daun_dominan = Layu` dan `persentase_hasil < 60`

Maka:

```text
hasil_klasifikasi = Gagal
```

### Rule Berhasil

Jika semua kondisi berikut terpenuhi:

* `persentase_hidup >= 80`
* `persentase_hasil >= 80`
* `tingkat_hama_dominan != Berat`
* `kondisi_daun_dominan != Layu`

Maka:

```text
hasil_klasifikasi = Berhasil
```

### Rule Cukup

Jika tidak masuk kategori Gagal dan tidak memenuhi kategori Berhasil, maka:

```text
hasil_klasifikasi = Cukup
```

## Output Service

Service wajib mengembalikan array:

```php
[
    'hasil_klasifikasi' => 'Berhasil/Cukup/Gagal',
    'skor' => 85.50,
    'persentase_hidup' => 90.00,
    'persentase_hasil' => 82.00,
    'faktor_utama' => [],
    'rekomendasi' => [],
    'rincian_aturan' => [],
    'metode_algoritma' => 'rule_based_decision_tree',
    'versi_algoritma' => 'v1.0',
]
```

## Perhitungan Skor

Gunakan bobot:

```text
persentase_hidup  = 40%
persentase_hasil  = 40%
tingkat_hama      = 10%
kondisi_daun      = 10%
```

Nilai hama:

```text
Tidak Ada = 100
Ringan    = 85
Sedang    = 60
Berat     = 0
```

Nilai daun:

```text
Sehat     = 100
Menguning = 70
Layu      = 30
```

Skor akhir:

```text
skor = hidup*0.40 + hasil*0.40 + hama*0.10 + daun*0.10
```

Skor dibatasi 0 sampai 100.

---

# 7. Controller Evaluasi

Update `EvaluasiController`.

## Method `index`

Untuk guru:

* Tampilkan semua data penanaman yang sudah memiliki panen.
* Include relasi:
  * `pemeliharaans`
  * `panen`
  * `evaluasi`
  * `siswa`
* Search berdasarkan nama siswa atau jenis tanaman.
* Filter berdasarkan hasil klasifikasi.
* Tampilkan statistik:
  * total evaluasi
  * berhasil
  * cukup
  * gagal
  * persentase berhasil

Untuk siswa:

* Tampilkan hanya data milik siswa login.
* Siswa hanya boleh melihat hasil evaluasi.

## Method `proses`

Ketentuan:

* Hanya role `guru` yang boleh memproses evaluasi.
* Admin tidak perlu diberi akses proses agar tetap sesuai use case.
* Siswa tidak boleh memproses evaluasi.

Validasi:

```php
'penanaman_id' => 'required|exists:penanamen,id'
```

Sebelum proses Decision Tree, cek:

* Data panen tersedia.
* Data pemeliharaan tersedia.
* `jml_bibit > 0`.
* `target_panen_kg > 0`.
* `tanaman_hidup + tanaman_mati <= jml_bibit`.

Jika tidak lengkap, kembalikan error yang jelas.

Setelah valid:

* Panggil `DecisionTreeService`.
* Simpan hasil ke tabel `evaluasis` dengan `updateOrCreate`.
* Simpan array langsung, jangan `json_encode`, karena model sudah memakai casts array.

Data yang disimpan:

```php
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
    'evaluated_at' => now(),
]
```

---

# 8. Frontend dan Halaman yang Harus Dibuat

Frontend harus tetap mengikuti use case diagram.

## 8.1 Halaman Login

Route:

```text
/login
```

Aktor:

* Siswa
* Guru
* Admin

Setelah login arahkan berdasarkan role:

```text
siswa → dashboard siswa
guru  → dashboard guru
admin → dashboard admin
```

---

# 9. Halaman Siswa

## 9.1 Dashboard Siswa

Tampilkan ringkasan:

* Total penanaman
* Dalam pemeliharaan
* Sudah panen
* Sudah dievaluasi
* Hasil evaluasi terakhir

## 9.2 Akses Data Penanaman

Halaman:

```text
/siswa/penanaman
/siswa/penanaman/create
/siswa/penanaman/{id}
```

Field form:

* `jenis_tanaman`
* `lokasi_lahan`
* `tgl_tanam`
* `jml_bibit`
* `target_panen_kg`
* `kondisi_tanah`

Tabel list menampilkan:

* jenis tanaman
* lokasi lahan
* tanggal tanam
* jumlah bibit
* target panen
* status proses
* aksi detail/edit

## 9.3 Detail Penanaman

Buat halaman detail dengan tab:

```text
Data Penanaman
Pemeliharaan
Panen
Hasil Evaluasi
```

Halaman detail ini menjadi pusat alur satu proyek tanam.

## 9.4 Akses Data Pemeliharaan

Halaman:

```text
/siswa/pemeliharaan
/siswa/penanaman/{id}/pemeliharaan/create
```

Field form:

* `minggu_ke`
* `tanggal_catat`
* `tinggi_tanaman`
* `jml_hidup`
* `jml_mati`
* `kondisi_daun`
* `tingkat_hama`
* `info_hama`
* `kegiatan`

Gunakan dropdown:

```text
kondisi_daun:
- Sehat
- Menguning
- Layu

tingkat_hama:
- Tidak Ada
- Ringan
- Sedang
- Berat
```

Validasi:

```text
jml_hidup + jml_mati <= jml_bibit
```

## 9.5 Akses Data Panen

Halaman:

```text
/siswa/panen
/siswa/penanaman/{id}/panen/create
```

Field form:

* `tgl_panen`
* `bobot_panen`
* `tanaman_hidup`
* `tanaman_mati`

Tampilkan pembanding di form:

* jumlah bibit awal
* target panen

Validasi:

```text
tanaman_hidup + tanaman_mati <= jml_bibit
bobot_panen >= 0
```

## 9.6 Melihat Hasil Evaluasi Panen

Halaman:

```text
/siswa/evaluasi
/siswa/evaluasi/{id}
```

Siswa hanya melihat hasil.

Tampilkan:

* hasil klasifikasi
* skor
* persentase hidup
* persentase hasil
* faktor utama
* rekomendasi
* rincian aturan Decision Tree

Siswa tidak boleh melihat tombol proses evaluasi.

---

# 10. Halaman Guru

## 10.1 Dashboard Guru

Tampilkan:

* Total proyek tanam siswa
* Belum panen
* Siap evaluasi
* Sudah dievaluasi
* Berhasil
* Cukup
* Gagal

## 10.2 Akses Data Penanaman

Halaman:

```text
/guru/penanaman
/guru/penanaman/{id}
```

Guru melihat semua data penanaman siswa.

Fitur:

* search nama siswa
* filter jenis tanaman
* filter status proses
* detail proyek

## 10.3 Akses Data Pemeliharaan

Halaman:

```text
/guru/pemeliharaan
/guru/penanaman/{id}
```

Guru melihat semua data pemeliharaan siswa.

Tampilkan indikator:

* daun layu
* hama berat
* jumlah mati meningkat
* tanaman tidak berkembang

## 10.4 Akses Data Panen

Halaman:

```text
/guru/panen
/guru/penanaman/{id}
```

Guru melihat data panen siswa.

Tampilkan:

* jumlah bibit awal
* target panen
* bobot panen
* tanaman hidup
* tanaman mati
* status siap evaluasi

## 10.5 Melihat Hasil Evaluasi Panen

Halaman:

```text
/guru/evaluasi
/guru/evaluasi/{id}
```

Halaman ini menjadi tempat implementasi Decision Tree.

Fitur:

* daftar proyek yang sudah panen
* checklist kelengkapan data
* tombol proses evaluasi panen
* detail hasil evaluasi
* proses ulang jika data berubah

Tombol:

```text
Proses Evaluasi Panen
```

Jangan gunakan label tombol terlalu teknis seperti:

```text
Run AI Decision Tree
```

Agar tetap sinkron dengan use case dan laporan.

## 10.6 Detail Evaluasi Guru

Tampilkan:

* identitas siswa
* data penanaman
* data pemeliharaan ringkas
* data panen
* data input Decision Tree
* jalur aturan Decision Tree
* hasil klasifikasi
* skor
* faktor utama
* rekomendasi

Contoh jalur aturan:

```text
Persentase hidup = 90% → >= 80
Persentase hasil = 85% → >= 80
Tingkat hama = Ringan → bukan Berat
Kondisi daun = Sehat → bukan Layu
Keputusan = Berhasil
```

---

# 11. Halaman Admin

## 11.1 Dashboard Admin

Tampilkan ringkasan:

* jumlah pengguna
* jumlah siswa
* jumlah guru
* jumlah admin

## 11.2 Kelola Akun Pengguna

Halaman:

```text
/admin/pengguna
/admin/pengguna/create
/admin/pengguna/{id}/edit
```

Fitur:

* tambah akun
* edit akun
* hapus/nonaktifkan akun
* reset password
* atur role

Role:

* siswa
* guru
* admin

## 11.3 Melihat Profil Pengguna

Halaman:

```text
/profil
```

Aktor:

* siswa
* guru
* admin

---

# 12. Checklist Kesiapan Evaluasi di Frontend

Pada halaman guru detail proyek dan halaman guru evaluasi, tampilkan checklist:

```text
✓ Data penanaman tersedia
✓ Jumlah bibit tersedia
✓ Target panen tersedia
✓ Minimal 1 data pemeliharaan tersedia
✓ Data panen tersedia
✓ Tanaman hidup + mati valid
```

Jika semua terpenuhi:

```text
Status: Siap Evaluasi
Tombol: Proses Evaluasi Panen aktif
```

Jika belum:

```text
Status: Belum Siap Evaluasi
Tombol: Proses Evaluasi Panen nonaktif
Tampilkan data apa yang belum lengkap
```

---

# 13. Mapping Use Case ke Route

| Use Case                     | Route                                          | Aktor              |
| ---------------------------- | ---------------------------------------------- | ------------------ |
| Login                        | `/login`                                     | Siswa, Guru, Admin |
| Akses Data Penanaman         | `/siswa/penanaman`,`/guru/penanaman`       | Siswa, Guru        |
| Akses Data Pemeliharaan      | `/siswa/pemeliharaan`,`/guru/pemeliharaan` | Siswa, Guru        |
| Akses Data Panen             | `/siswa/panen`,`/guru/panen`               | Siswa, Guru        |
| Melihat Hasil Evaluasi Panen | `/siswa/evaluasi`,`/guru/evaluasi`         | Siswa, Guru        |
| Kelola Akun Pengguna         | `/admin/pengguna`                            | Admin              |
| Melihat Profil Pengguna      | `/profil`                                    | Siswa, Guru, Admin |

---

# 14. Route yang Disarankan

Gunakan middleware auth dan role sesuai project.

Contoh:

```php
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    Route::resource('/penanaman', SiswaPenanamanController::class);
    Route::resource('/pemeliharaan', SiswaPemeliharaanController::class);
    Route::resource('/panen', SiswaPanenController::class);

    Route::get('/evaluasi', [EvaluasiController::class, 'index'])->name('evaluasi.index');
    Route::get('/evaluasi/{evaluasi}', [EvaluasiController::class, 'show'])->name('evaluasi.show');
});

Route::middleware(['auth', 'role:guru'])->prefix('guru')->name('guru.')->group(function () {
    Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

    Route::get('/penanaman', [GuruPenanamanController::class, 'index'])->name('penanaman.index');
    Route::get('/penanaman/{penanaman}', [GuruPenanamanController::class, 'show'])->name('penanaman.show');

    Route::get('/pemeliharaan', [GuruPemeliharaanController::class, 'index'])->name('pemeliharaan.index');
    Route::get('/panen', [GuruPanenController::class, 'index'])->name('panen.index');

    Route::get('/evaluasi', [EvaluasiController::class, 'index'])->name('evaluasi.index');
    Route::get('/evaluasi/{evaluasi}', [EvaluasiController::class, 'show'])->name('evaluasi.show');
    Route::post('/evaluasi/proses', [EvaluasiController::class, 'proses'])->name('evaluasi.proses');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('/pengguna', UserController::class);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
});
```

Sesuaikan nama middleware dan controller dengan project yang sudah ada.

---

# 15. Struktur View Blade

Gunakan struktur:

```text
resources/views/
├── layouts/
│   ├── siswa.blade.php
│   ├── guru.blade.php
│   └── admin.blade.php
│
├── siswa/
│   ├── dashboard.blade.php
│   ├── penanaman/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   ├── edit.blade.php
│   │   └── show.blade.php
│   ├── pemeliharaan/
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── panen/
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   └── evaluasi/
│       ├── index.blade.php
│       └── show.blade.php
│
├── guru/
│   ├── dashboard.blade.php
│   ├── penanaman/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── pemeliharaan/
│   │   └── index.blade.php
│   ├── panen/
│   │   └── index.blade.php
│   └── evaluasi/
│       ├── index.blade.php
│       └── show.blade.php
│
├── admin/
│   ├── dashboard.blade.php
│   └── pengguna/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
│
└── profile/
    └── show.blade.php
```

---

# 16. UI Detail Evaluasi yang Wajib Ditampilkan

Pada halaman detail evaluasi, tampilkan format seperti berikut:

```text
Detail Evaluasi Panen

Nama Siswa      : ...
Jenis Tanaman   : ...
Tanggal Tanam   : ...
Tanggal Panen   : ...

Data Input Decision Tree:
- Jumlah Bibit
- Tanaman Hidup
- Tanaman Mati
- Bobot Panen
- Target Panen
- Persentase Hidup
- Persentase Hasil
- Kondisi Daun Dominan
- Tingkat Hama Dominan

Jalur Aturan:
- Persentase hidup ...
- Persentase hasil ...
- Tingkat hama ...
- Kondisi daun ...
- Keputusan ...

Hasil Klasifikasi:
Berhasil / Cukup / Gagal

Skor:
0 - 100

Faktor Utama:
- ...

Rekomendasi:
- ...
```

---

# 17. Validasi Form

## Penanaman

```php
'jenis_tanaman' => 'required|string|max:255',
'lokasi_lahan' => 'required|string|max:255',
'tgl_tanam' => 'required|date',
'jml_bibit' => 'required|integer|min:1',
'target_panen_kg' => 'required|numeric|min:0.1',
'kondisi_tanah' => 'nullable|string',
```

## Pemeliharaan

```php
'penanaman_id' => 'required|exists:penanamen,id',
'minggu_ke' => 'required|integer|min:1',
'tanggal_catat' => 'required|date',
'tinggi_tanaman' => 'required|numeric|min:0',
'jml_hidup' => 'required|integer|min:0',
'jml_mati' => 'required|integer|min:0',
'kondisi_daun' => 'required|in:Sehat,Menguning,Layu',
'tingkat_hama' => 'required|in:Tidak Ada,Ringan,Sedang,Berat',
'info_hama' => 'nullable|string',
'kegiatan' => 'nullable|string',
```

Tambahkan validasi custom:

```text
jml_hidup + jml_mati <= jml_bibit
```

## Panen

```php
'penanaman_id' => 'required|exists:penanamen,id',
'tgl_panen' => 'required|date',
'bobot_panen' => 'required|numeric|min:0',
'tanaman_hidup' => 'required|integer|min:0',
'tanaman_mati' => 'required|integer|min:0',
```

Tambahkan validasi custom:

```text
tanaman_hidup + tanaman_mati <= jml_bibit
```

---

# 18. Verification Plan

## 18.1 Migration Test

Jalankan:

```bash
php artisan migrate
```

Pastikan tidak ada error duplicate column.

## 18.2 Flow Test Siswa

1. Login sebagai siswa.
2. Tambah data penanaman.
3. Isi `jml_bibit` dan `target_panen_kg`.
4. Tambah data pemeliharaan.
5. Isi `kondisi_daun` dan `tingkat_hama`.
6. Tambah data panen.
7. Pastikan siswa hanya bisa melihat hasil evaluasi jika guru sudah memproses.

## 18.3 Flow Test Guru

1. Login sebagai guru.
2. Buka data penanaman siswa.
3. Buka detail proyek.
4. Cek checklist kesiapan evaluasi.
5. Klik `Proses Evaluasi Panen`.
6. Pastikan hasil tersimpan ke tabel `evaluasis`.
7. Pastikan halaman detail evaluasi menampilkan:
   * hasil klasifikasi
   * skor
   * persentase hidup
   * persentase hasil
   * faktor utama
   * rekomendasi
   * rincian aturan

## 18.4 Flow Test Admin

1. Login sebagai admin.
2. Buka kelola akun pengguna.
3. Tambah akun siswa/guru.
4. Edit akun.
5. Pastikan admin tidak memiliki tombol proses evaluasi panen.

---

# 19. Decision Tree Test Cases

## Kasus 1: Berhasil

Input:

```text
jml_bibit = 100
tanaman_hidup = 90
tanaman_mati = 10
target_panen_kg = 25
bobot_panen = 22
kondisi_daun_dominan = Sehat
tingkat_hama_dominan = Ringan
```

Output:

```text
Berhasil
```

## Kasus 2: Cukup

Input:

```text
jml_bibit = 100
tanaman_hidup = 70
tanaman_mati = 30
target_panen_kg = 25
bobot_panen = 17
kondisi_daun_dominan = Menguning
tingkat_hama_dominan = Sedang
```

Output:

```text
Cukup
```

## Kasus 3: Gagal karena tanaman hidup rendah

Input:

```text
jml_bibit = 100
tanaman_hidup = 40
tanaman_mati = 60
target_panen_kg = 25
bobot_panen = 20
kondisi_daun_dominan = Sehat
tingkat_hama_dominan = Ringan
```

Output:

```text
Gagal
```

## Kasus 4: Gagal karena hasil panen rendah

Input:

```text
jml_bibit = 100
tanaman_hidup = 90
tanaman_mati = 10
target_panen_kg = 25
bobot_panen = 8
kondisi_daun_dominan = Sehat
tingkat_hama_dominan = Ringan
```

Output:

```text
Gagal
```

## Kasus 5: Gagal karena hama berat

Input:

```text
jml_bibit = 100
tanaman_hidup = 90
tanaman_mati = 10
target_panen_kg = 25
bobot_panen = 22
kondisi_daun_dominan = Sehat
tingkat_hama_dominan = Berat
```

Output:

```text
Gagal
```

---

# 20. Acceptance Criteria

Implementasi dianggap selesai jika:

1. Use case tidak berubah.
2. Siswa dapat menginput data penanaman, pemeliharaan, dan panen.
3. Guru dapat melihat data siswa.
4. Guru dapat memproses evaluasi panen.
5. Decision Tree menghasilkan klasifikasi:
   * Berhasil
   * Cukup
   * Gagal
6. Hasil evaluasi tersimpan di tabel `evaluasis`.
7. Detail evaluasi menampilkan:
   * skor
   * persentase hidup
   * persentase hasil
   * faktor utama
   * rekomendasi
   * rincian aturan
8. Siswa hanya bisa melihat hasil evaluasi.
9. Admin hanya mengelola akun pengguna dan profil.
10. Frontend menampilkan checklist kesiapan evaluasi.
11. Tombol proses evaluasi hanya aktif jika data lengkap.
12. Sistem tetap sesuai dengan judul penelitian.

---

# 21. Catatan untuk Laporan Skripsi

Gunakan penjelasan berikut:

Sistem Si Tanam menerapkan algoritma Decision Tree berbasis aturan untuk mengevaluasi keberhasilan panen. Data yang digunakan berasal dari proses penanaman, pemeliharaan, dan panen. Atribut yang diproses meliputi jumlah bibit, target panen, tanaman hidup, bobot panen, kondisi daun, dan tingkat hama. Hasil evaluasi diklasifikasikan menjadi Berhasil, Cukup, atau Gagal, disertai skor evaluasi, faktor utama, rekomendasi, dan rincian aturan keputusan.

Decision Tree ditempatkan pada use case Melihat Hasil Evaluasi Panen, sehingga sistem tetap sesuai dengan use case diagram yang sudah dibuat.
