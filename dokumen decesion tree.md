Bro, supaya  **Si Tanam layak disebut menggunakan algoritma Decision Tree** , sistemnya jangan cuma CRUD penanaman–panen. Harus ada **proses pengambilan keputusan otomatis** dari data pertanian menjadi  **kategori evaluasi** .

Intinya begini:

> Sistem layak menggunakan Decision Tree kalau punya  **data input** , punya  **label/hasil keputusan** , dan ada **aturan/pola bercabang** untuk menentukan hasil seperti  **Berhasil, Cukup, atau Gagal** .

Decision Tree memang cocok untuk  **klasifikasi multi-kelas** , misalnya kelas `Berhasil`, `Cukup`, dan `Gagal`. Dalam dokumentasi scikit-learn, `DecisionTreeClassifier` menerima data fitur `X` dan label target `y`, lalu setelah dilatih dapat digunakan untuk memprediksi kelas data baru.

---

## 1. Syarat Utama agar Si Tanam Layak Pakai Decision Tree

### A. Masalahnya harus berbentuk klasifikasi

Decision Tree cocok kalau output akhirnya berupa kategori, bukan cuma angka biasa.

Untuk Si Tanam:

| Data Masuk                                                     | Hasil Akhir              |
| -------------------------------------------------------------- | ------------------------ |
| jumlah bibit, tanaman hidup, hama, tinggi tanaman, bobot panen | Berhasil / Cukup / Gagal |

Jadi ini  **layak** , karena sistem tidak hanya menyimpan data, tapi menentukan  **kelas hasil panen** .

Contoh hasil klasifikasi:

<pre class="overflow-visible! px-0!" data-start="1243" data-end="1346"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Proyek Tanam Kangkung A → Berhasil</span><br/><span>Proyek Tanam Cabai B → Cukup</span><br/><span>Proyek Tanam Sawi C → Gagal</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

---

### B. Harus ada variabel penentu/fitur

Decision Tree butuh kolom-kolom yang menjadi dasar keputusan. Dalam machine learning, ini disebut  **features** .

Untuk Si Tanam, fitur yang masuk akal:

| Fitur                | Contoh Nilai         | Pengaruh                            |
| -------------------- | -------------------- | ----------------------------------- |
| `jumlah_bibit`     | 100                  | dasar menghitung keberhasilan hidup |
| `tanaman_hidup`    | 85                   | semakin tinggi semakin baik         |
| `persentase_hidup` | 85%                  | indikator utama keberhasilan        |
| `bobot_panen_kg`   | 30 kg                | hasil akhir panen                   |
| `target_panen_kg`  | 35 kg                | pembanding hasil panen              |
| `persentase_hasil` | 85.7%                | menentukan tercapai/tidak target    |
| `status_hama`      | ringan/sedang/berat  | faktor penyebab gagal               |
| `status_daun`      | sehat/menguning/layu | indikator kesehatan tanaman         |
| `tinggi_rata_rata` | 25 cm                | indikator pertumbuhan               |
| `rutin_perawatan`  | ya/tidak             | pengaruh pemeliharaan               |

Kalau sistem hanya punya data seperti `nama siswa`, `kelas`, `tanggal tanam`, itu **belum cukup kuat** untuk Decision Tree. Itu baru pendataan biasa.

---

### C. Harus ada label hasil

Ini bagian paling penting.

Decision Tree butuh target/label seperti:

<pre class="overflow-visible! px-0!" data-start="2451" data-end="2483"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Berhasil</span><br/><span>Cukup</span><br/><span>Gagal</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Label ini bisa dibuat dari dua cara:

### Cara 1 — Label dari guru/pakar

Guru menentukan hasil panen siswa:

<pre class="overflow-visible! px-0!" data-start="2595" data-end="2660"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Proyek A = Berhasil</span><br/><span>Proyek B = Cukup</span><br/><span>Proyek C = Gagal</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Lalu data itu dipakai sebagai  **data latih** .

Ini lebih cocok kalau ingin benar-benar disebut  **machine learning** .

---

### Cara 2 — Label dari aturan awal

Misalnya:

| Kondisi                                 | Label    |
| --------------------------------------- | -------- |
| hidup ≥ 80% dan hasil ≥ 80% target    | Berhasil |
| hidup 50–79% atau hasil 50–79% target | Cukup    |
| hidup < 50% atau hasil < 50% target     | Gagal    |

Ini masih bisa disebut  **Decision Tree berbasis aturan** , tapi belum sekuat Decision Tree machine learning karena belum belajar dari dataset historis.

Kalau untuk skripsi, lebih bagus begini:

> Label awal ditentukan oleh guru/pakar pertanian, kemudian data tersebut digunakan untuk proses training dan testing algoritma Decision Tree.

---

## 2. Bentuk Decision Tree yang Layak untuk Si Tanam

Pohon keputusannya kira-kira seperti ini:

<pre class="overflow-visible! px-0!" data-start="3452" data-end="3800"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Apakah persentase tanaman hidup >= 80%?</span><br/><span>├── Ya</span><br/><span>│   ├── Apakah hasil panen >= 80% dari target?</span><br/><span>│   │   ├── Ya  → Berhasil</span><br/><span>│   │   └── Tidak → Cukup</span><br/><span>│</span><br/><span>└── Tidak</span><br/><span>    ├── Apakah tanaman hidup < 50%?</span><br/><span>    │   ├── Ya  → Gagal</span><br/><span>    │   └── Tidak</span><br/><span>    │       ├── Apakah hama berat?</span><br/><span>    │       │   ├── Ya → Gagal</span><br/><span>    │       │   └── Tidak → Cukup</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Nah, bentuk seperti ini sudah masuk akal untuk Decision Tree karena ada:

<pre class="overflow-visible! px-0!" data-start="3876" data-end="3922"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>kondisi → cabang → keputusan akhir</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

---

## 3. Dataset Minimal yang Harus Ada

Contoh dataset Si Tanam:

| Bibit | Hidup % | Hama      | Daun      | Panen % | Label    |
| ----- | ------- | --------- | --------- | ------- | -------- |
| 100   | 90      | Ringan    | Sehat     | 95      | Berhasil |
| 100   | 75      | Sedang    | Menguning | 70      | Cukup    |
| 100   | 40      | Berat     | Layu      | 30      | Gagal    |
| 80    | 85      | Tidak Ada | Sehat     | 90      | Berhasil |
| 80    | 60      | Ringan    | Menguning | 55      | Cukup    |
| 80    | 25      | Berat     | Layu      | 20      | Gagal    |

Struktur data Decision Tree secara umum adalah:

<pre class="overflow-visible! px-0!" data-start="4392" data-end="4435"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>X = fitur/input</span><br/><span>y = label/hasil</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Contoh:

<pre class="overflow-visible! px-0!" data-start="4446" data-end="4555"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>X = [persentase_hidup, persentase_hasil, status_hama, status_daun]</span><br/><span>y = [Berhasil / Cukup / Gagal]</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Dalam praktik machine learning, data biasanya dibagi menjadi **data latih** dan **data uji** agar performa model bisa diuji pada data yang belum pernah dilihat. Fungsi `train_test_split` di scikit-learn memang digunakan untuk membagi array atau matriks menjadi subset training dan testing.

---

## 4. Syarat agar Hasilnya Bisa Dipertanggungjawabkan

Untuk skripsi atau laporan, jangan hanya bilang “menggunakan Decision Tree”. Harus ada bukti hasilnya.

Minimal ada:

| Komponen         | Keterangan                                    |
| ---------------- | --------------------------------------------- |
| Dataset          | data hasil tanam/panen siswa                  |
| Fitur            | bibit, tanaman hidup, hama, daun, bobot panen |
| Label            | Berhasil, Cukup, Gagal                        |
| Training         | proses membentuk pohon keputusan              |
| Testing          | pengujian model                               |
| Akurasi          | persentase prediksi benar                     |
| Confusion Matrix | tabel perbandingan prediksi dan data asli     |
| Kesimpulan       | model layak/tidak berdasarkan hasil uji       |

Confusion matrix digunakan untuk mengevaluasi akurasi klasifikasi dengan membandingkan label sebenarnya dan label hasil prediksi.  Scikit-learn juga menyediakan berbagai metrik untuk mengukur performa klasifikasi, seperti accuracy, precision, recall, dan metrik lain yang relevan.

---

## 5. Contoh Hasil yang Diharapkan dari Sistem

Misalnya siswa mengisi data panen:

<pre class="overflow-visible! px-0!" data-start="5923" data-end="6127"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Jumlah bibit        : 100</span><br/><span>Tanaman hidup       : 72</span><br/><span>Tanaman mati        : 28</span><br/><span>Bobot panen         : 18 kg</span><br/><span>Target panen        : 25 kg</span><br/><span>Status hama         : Sedang</span><br/><span>Status daun         : Menguning</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Sistem menghitung:

<pre class="overflow-visible! px-0!" data-start="6149" data-end="6206"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Persentase hidup = 72%</span><br/><span>Persentase hasil = 72%</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Output Decision Tree:

<pre class="overflow-visible! px-0!" data-start="6231" data-end="6430"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Kategori Evaluasi : Cukup</span><br/><span>Skor              : 72</span><br/><span>Faktor utama      : Hasil panen belum mencapai target maksimal</span><br/><span>Rekomendasi       : Tingkatkan pemupukan, penyiraman, dan pengendalian hama</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Jadi hasilnya bukan cuma:

<pre class="overflow-visible! px-0!" data-start="6459" data-end="6476"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Cukup</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Tapi idealnya lengkap:

<pre class="overflow-visible! px-0!" data-start="6502" data-end="6555"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Kategori</span><br/><span>Skor</span><br/><span>Faktor penyebab</span><br/><span>Rekomendasi</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Ini yang bikin sistem terlihat “bernilai”, bukan cuma tempelan AI pajangan.

---

## 6. Kapan Sistem Belum Layak Disebut Decision Tree?

Si Tanam **belum layak** disebut menggunakan Decision Tree kalau hanya seperti ini:

<pre class="overflow-visible! px-0!" data-start="6779" data-end="6863"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Admin input data tanam</span><br/><span>Siswa input monitoring</span><br/><span>Guru lihat laporan</span><br/><span>Selesai</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Itu masih sistem informasi biasa.

Belum layak juga kalau hasilnya ditentukan manual oleh admin tanpa proses algoritma:

<pre class="overflow-visible! px-0!" data-start="6986" data-end="7031"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Admin pilih: Berhasil/Cukup/Gagal</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Kalau seperti itu, Decision Tree-nya belum bekerja. Ibaratnya AI cuma numpang nama di spanduk.

---

## 7. Kapan Sistem Sudah Layak?

Si Tanam sudah layak disebut menggunakan Decision Tree kalau alurnya begini:

<pre class="overflow-visible! px-0!" data-start="7245" data-end="7630"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>Siswa input data penanaman</span><br/><span>        ↓</span><br/><span>Siswa/guru input monitoring mingguan</span><br/><span>        ↓</span><br/><span>Guru input data panen</span><br/><span>        ↓</span><br/><span>Sistem menghitung fitur:</span><br/><span>- persentase hidup</span><br/><span>- persentase hasil panen</span><br/><span>- status hama</span><br/><span>- status daun</span><br/><span>- tinggi rata-rata</span><br/><span>        ↓</span><br/><span>Decision Tree melakukan klasifikasi</span><br/><span>        ↓</span><br/><span>Sistem menampilkan:</span><br/><span>- Berhasil / Cukup / Gagal</span><br/><span>- Skor</span><br/><span>- Faktor penyebab</span><br/><span>- Rekomendasi</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Nah, ini baru kuat.

---

## 8. Catatan Penting: Hindari Overfitting

Decision Tree bisa terlalu “hafal” data latih kalau pohonnya terlalu dalam. Ini disebut  **overfitting** . Dokumentasi scikit-learn menyebutkan bahwa pohon keputusan bisa menjadi terlalu kompleks dan tidak mampu melakukan generalisasi dengan baik, sehingga perlu mekanisme seperti pembatasan kedalaman pohon atau jumlah minimum sampel pada leaf node.

Dalam sistem Si Tanam, solusinya:

<pre class="overflow-visible! px-0!" data-start="8125" data-end="8215"><div class="relative w-full mt-4 mb-1"><div class=""><div class="contents"><div class="relative"><div class="h-full min-h-0 min-w-0"><div class="h-full min-h-0 min-w-0"><div class="border border-token-border-light border-radius-3xl corner-superellipse/1.1 rounded-3xl"><div class="h-full w-full border-radius-3xl bg-token-bg-elevated-secondary corner-superellipse/1.1 overflow-clip rounded-3xl lxnfua_clipPathFallback"><div class="pointer-events-none absolute end-1.5 top-1 z-2 md:end-2 md:top-1"></div><div class="relative"><div class="pe-11 pt-3"><div class="relative z-0 flex max-w-full"><div id="code-block-viewer" dir="ltr" class="q9tKkq_viewer cm-editor z-10 light:cm-light dark:cm-light flex h-full w-full flex-col items-stretch ͼd ͼr"><div class="cm-scroller"><pre class="cm-content q9tKkq_readonly m-0"><code><span>max_depth = 3 atau 4</span><br/><span>min_samples_leaf = 2 atau 5</span><br/><span>criterion = gini atau entropy</span></code></pre></div></div></div></div></div></div></div></div></div><div class=""><div class=""></div></div></div></div></div></div></pre>

Parameter `criterion` pada `DecisionTreeClassifier` dapat menggunakan `gini`, `entropy`, atau `log_loss`, sedangkan `max_depth` membatasi kedalaman maksimum pohon.

---

## 9. Versi Kalimat untuk Proposal/Skripsi

Bro bisa pakai kalimat ini:

> Sistem Si Tanam layak menggunakan algoritma Decision Tree karena permasalahan yang diselesaikan berbentuk klasifikasi, yaitu menentukan kategori hasil panen siswa menjadi Berhasil, Cukup, atau Gagal berdasarkan sejumlah atribut penentu seperti persentase tanaman hidup, bobot panen, target panen, kondisi daun, tingkat serangan hama, dan rata-rata pertumbuhan tanaman. Algoritma Decision Tree digunakan karena mampu menghasilkan aturan keputusan yang mudah dipahami dalam bentuk percabangan, sehingga hasil evaluasi tidak hanya berupa kategori, tetapi juga dapat menjelaskan faktor utama yang memengaruhi keputusan.

Kalimat lanjutannya:

> Kelayakan penerapan algoritma Decision Tree dibuktikan melalui proses pengumpulan dataset hasil praktik pertanian siswa, pembentukan data latih dan data uji, pelatihan model, serta evaluasi performa menggunakan confusion matrix dan nilai akurasi. Dengan demikian, sistem tidak hanya berfungsi sebagai media pendataan, tetapi juga sebagai alat bantu evaluasi dan pengambilan keputusan berbasis data.

---

## Kesimpulan Paling Jelas

**Si Tanam layak menggunakan Decision Tree kalau memenuhi 5 syarat ini:**

| No | Syarat                      | Status di Si Tanam                              |
| -- | --------------------------- | ----------------------------------------------- |
| 1  | Ada masalah klasifikasi     | Ada: Berhasil/Cukup/Gagal                       |
| 2  | Ada fitur penentu           | Ada: hidup, panen, hama, daun                   |
| 3  | Ada label hasil             | Harus dibuat dari guru/pakar atau data historis |
| 4  | Ada proses training/testing | Harus disiapkan untuk versi machine learning    |
| 5  | Ada hasil evaluasi          | Akurasi, confusion matrix, rekomendasi          |

Jadi rekomendasi saya:

 **gunakan Decision Tree Classification berbasis data panen siswa** , dengan output  **Berhasil, Cukup, Gagal** , lalu tampilkan  **skor, faktor penyebab, dan rekomendasi perbaikan** . Itu sudah kuat untuk sistem, laporan, maupun skripsi.
