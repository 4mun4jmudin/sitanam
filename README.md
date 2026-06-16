<p align="center">
  <img src="public/favicon.svg" width="120" alt="HawariFarm Logo">
</p>

<h1 align="center">🌱 HawariFarm - Sistem Informasi Pendataan Panen</h1>

<p align="center">
  <strong>Sistem Manajemen Budidaya Pertanian Cerdas Berbasis Web untuk SMK IT Al-Hawari.</strong>
  <br>
  <em>Dilengkapi dengan Evaluasi Rule-Based Decision Tree untuk Klasifikasi Keberhasilan Panen.</em>
</p>

<p align="center">
  <a href="#-deskripsi-sistem">Deskripsi</a> •
  <a href="#-fitur-utama">Fitur Utama</a> •
  <a href="#-alur-kerja-workflow">Alur Kerja</a> •
  <a href="#-hak-akses-role">Hak Akses</a> •
  <a href="#%EF%B8%8F-panduan-instalasi">Instalasi</a>
</p>

<hr>

## 📖 Deskripsi Sistem

**HawariFarm (SI Tanam)** adalah platform manajemen budidaya pertanian digital yang dirancang khusus untuk memonitor, mendata, dan mengevaluasi seluruh siklus tanam. Sistem ini mendukung berbagai jenis tanaman (sayuran daun, buah, umbi, herbal) dengan pengukuran target hasil panen yang fleksibel (Kilogram, Ikat, Buah, dll).

Keunggulan utama dari sistem ini adalah fitur **Evaluasi Cerdas menggunakan Rule-Based Decision Tree**, yang dapat mengklasifikasikan keberhasilan proses tanam (Berhasil, Cukup, atau Gagal) berdasarkan metrik yang akurat seperti persentase tanaman hidup, pencapaian hasil panen, serangan hama, dan kondisi pertumbuhan.

## ✨ Fitur Utama

- 📊 **Dashboard Premium & Responsif:** Tampilan antar muka elegan bergaya glassmorphism dan modern berbasis Tailwind CSS.
- 🚀 **Navigasi Super Cepat (SPA-like):** Menggunakan Hotwire Turbo Drive untuk perpindahan halaman tanpa *full-reload*, lengkap dengan *progress bar*.
- 🌿 **Manajemen Master Tanaman:** Database komoditas yang dinamis dengan fleksibilitas pengaturan target satuan hasil panen.
- 📝 **Log Pemeliharaan Berkala:** Pencatatan komprehensif terhadap tingkat hama, kondisi daun, tinggi tanaman, hingga risiko gagal panen.
- 🧠 **Evaluasi Decision Tree:** Penilaian otomatis yang memproduksi keputusan objektif, faktor penentu, serta rekomendasi tindak lanjut bagi petani/siswa.

## 🔄 Alur Kerja (Workflow)

Sistem dirancang mengikuti siklus budidaya pertanian yang realistis:

1. **🌱 Penanaman:** Input data populasi awal, lokasi lahan, dan target hasil panen.
2. **💧 Pemeliharaan:** Update mingguan terkait pertumbuhan, kondisi daun, tingkat hama, dan jumlah tanaman yang mati.
3. **🧺 Panen:** Pencatatan bobot atau jumlah hasil akhir panen sesungguhnya setelah masa tanam selesai.
4. **📈 Evaluasi Guru:** Guru akan memproses evaluasi (*Generate Evaluasi*) dari data yang telah diselesaikan. Sistem akan menjalankan Decision Tree untuk memberi skor akhir.

## 👥 Hak Akses (Role)

Sistem ini membagi akses menjadi 3 peran utama (Role-Based Access Control):

- 👨‍🎓 **Siswa:** Menginput pendataan siklus tanam (Penanaman -> Pemeliharaan -> Panen) dan melihat hasil evaluasi pribadi.
- 👨‍🏫 **Guru Praktik:** Memantau seluruh pendataan siswa, mengatur jenis tanaman, dan mengeksekusi perhitungan Evaluasi Akhir.
- 👨‍💻 **Admin Utama:** Memiliki akses ke manajemen pengguna (kelola akun Guru/Siswa) serta master data secara keseluruhan.

## 🛠️ Teknologi yang Digunakan

Sistem ini dibangun dengan stack teknologi modern:
- **Backend:** [Laravel](https://laravel.com/) (PHP)
- **Frontend & Styling:** [Tailwind CSS](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/)
- **Performa Navigasi:** [Hotwire Turbo Drive](https://turbo.hotwired.dev/)
- **Database:** MySQL / MariaDB

---

## ⚙️ Panduan Instalasi

Ikuti langkah-langkah di bawah ini untuk mengunduh (*clone*) dan menjalankan sistem HawariFarm di komputer lokal Anda.

### 📋 Prasyarat
Pastikan komputer Anda sudah terinstal:
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL / MariaDB (contoh: XAMPP, Laragon, dsb.)
- Git

### 🚀 Langkah Instalasi

**1. Clone Repositori**
```bash
git clone https://github.com/4mun4jmudin/sitanam.git
cd sitanam
```

**2. Instal Dependensi PHP (Composer)**
```bash
composer install
```

**3. Instal Dependensi Frontend (NPM)**
```bash
npm install
```

**4. Konfigurasi Environment**
Gandakan file `.env.example` menjadi `.env`
```bash
cp .env.example .env
```
Buka file `.env` dan atur kredensial database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_sitanam  # Pastikan Anda membuat database ini di MySQL
DB_USERNAME=root
DB_PASSWORD=
```

**5. Generate Application Key**
```bash
php artisan key:generate
```

**6. Jalankan Migrasi & Seeder Database**
Langkah ini sangat penting untuk membuat tabel dan mengisi akun dummy / master data tanaman awal.
```bash
php artisan migrate --seed
```

**7. Compile Aset Frontend**
```bash
npm run build
```
*(Atau biarkan `npm run dev` berjalan di terminal terpisah jika Anda ingin mengembangkan tampilan).*

**8. Jalankan Local Server**
```bash
php artisan serve
```
Akses aplikasi melalui browser di: **[http://localhost:8000](http://localhost:8000)**

---

## 🔑 Akun Prototype (Default Testing)

Jika Anda telah menjalankan perintah *seeder* (`php artisan migrate --seed`), gunakan akun berikut untuk masuk ke dalam sistem:

| Role | Email | Password |
| :--- | :--- | :--- |
| **Admin** | `admin@sitanam.com` | `password` |
| **Guru** | `guru@sitanam.com` | `password` |
| **Siswa** | `siswa@sitanam.com` | `password` |

---
<p align="center">
  Dibuat dengan ❤️ untuk kemajuan pendidikan agrikultur digital. &copy; 2026 SMK IT Al-Hawari.
</p>
