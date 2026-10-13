# Panduan Kerja Step-by-Step: Modul 1–3 (Laravel 13 + Git/GitHub)

_Disusun dari panduan-praktikum-lengkap-v3.md. Proyek tunggal bernama `praktikum-laravel`. Kerjakan berurutan dan jangan melompat._

## Cara memakai panduan ini

- Alur besar: **Modul 1** (fondasi Laravel) → **Modul 2** (Git/GitHub, mengunggah hasil Modul 1) → **Modul 3** (routing, view, Blade). Mulai Modul 2-P5, commit dan push setiap selesai satu praktikum.
- Pola tiap praktikum: ikuti **Latihan**, kerjakan **Tugas Mandiri**, ambil screenshot, lalu commit.
- Semua perintah dijalankan di folder `praktikum-laravel` kecuali disebut lain. Di Windows: `type` = `cat`, `ren` = `mv`.
- Simpan screenshot di folder **di luar proyek** (mis. `screenshot-praktikum/m1-p1/`) agar zip dan repo tidak membengkak.
- Tugas berupa penjelasan harus ditulis dengan kalimat sendiri. Bagian _Poin_ di sini hanya kerangka.
- Butir bertanda **(Tambahan)** tidak ada di panduan asli; itu perbaikan kecil supaya langkahnya tidak error.

## 0. Persiapan (sekali di awal)

1. Cek versi tool. PHP harus 8.3 atau lebih:

```bash
php -v
composer -V
node -v
npm -v
```

2. Nyalakan MySQL lewat XAMPP/Laragon.
3. Pasang Laravel Installer (sekali, global):

```bash
composer global require laravel/installer
```

Jika perintah `laravel` tidak dikenali, tambahkan folder `vendor/bin` Composer global ke PATH.

4. Buat folder screenshot di luar proyek.

---

# MODUL 1 — Fondasi Laravel

## M1-P1 Instalasi Laravel 13

1. Buat proyek:

```bash
laravel new praktikum-laravel
```

Pilih Starter kit **None** dan Database **MySQL**; pertanyaan lain boleh default. Alternatif tanpa installer: `composer create-project laravel/laravel praktikum-laravel`.

2. Buat database kosong (atau lewat phpMyAdmin):

```bash
mysql -u root -e "CREATE DATABASE praktikum_laravel;"
```

3. Cek `.env`, pastikan isinya seperti ini (installer biasanya sudah mengisi sebagian):

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=praktikum_laravel
DB_USERNAME=root
DB_PASSWORD=
```

4. Jalankan server, lalu buka http://127.0.0.1:8000 (halaman welcome tampil):

```bash
cd praktikum-laravel
php artisan serve
```

Biarkan terminal ini tetap hidup. Pakai terminal kedua untuk perintah lain.

5. Kenali struktur folder: `app/` (Model, Controller), `routes/web.php` (URL aplikasi), `resources/views/` (file Blade), `database/migrations/` (struktur tabel), `database/seeders/` (data awal), `.env` (konfigurasi), `public/` (entry point `index.php`).

**Tugas Mandiri P1**

- Screenshot welcome page di browser, output `php -v`, dan output `php artisan --version`.
- Rangkum maks. 1 halaman: **3 fitur Laravel** paling bermanfaat + alasannya. _Poin: Eloquent (query aman dan ekspresif), Migration (skema DB terlacak), Blade/Middleware._

## M1-P2 Perintah dasar Artisan

1. Eksplorasi perintah:

```bash
php artisan list
php artisan list make
php artisan help make:controller
```

2. Buat controller, lalu cek file `app/Http/Controllers/MahasiswaController.php`:

```bash
php artisan make:controller MahasiswaControllerphp artisan make:model Mahasiswa -m
```

3. Buat Model + Migration + Resource Controller sekaligus:

```bash
cr
```

Hasilnya `app/Models/Mahasiswa.php` dan `database/migrations/xxxx_create_mahasiswas_table.php`. Pesan "controller already exists" itu **normal** karena sudah dibuat di langkah 2.

4. Coba Tinker (ketik `exit` untuk keluar):

```bash
php artisan tinker
```

```php
echo "Halo dari Artisan Tinker!";
now();
exit
```

5. Lihat semua route: `php artisan route:list`

**Tugas Mandiri P2**

1. Buat Model + Migration + Controller `Artikel` dalam satu perintah. **Jangan edit migration-nya**, diisi di Modul 5:

```bash
php artisan make:model Artikel -mc
```

2. Screenshot `php artisan route:list` **sebelum**, lalu tambahkan route ini di `routes/web.php`, lalu screenshot `route:list` **sesudah**:

```php
Route::get('/tes', function () { return 'tes'; });
```

3. Jelaskan perbedaan `cache:clear` vs `config:clear`. _Poin: `cache:clear` menghapus cache aplikasi (data yang disimpan lewat Cache); `config:clear` menghapus file cache konfigurasi hasil gabungan `config/_`dan`.env`.\*

## M1-P3 Migration

1. Migration mahasiswas sudah ada dari P2, jadi **diedit, jangan dibuat ulang**. Cek dengan `ls database/migrations`.
2. Edit `up()` dan `down()` pada `database/migrations/xxxx_create_mahasiswas_table.php`:

```php
public function up(): void
{
    Schema::create('mahasiswas', function (Blueprint $table) {
        $table->id();
        $table->string('nim', 20)->unique();
        $table->string('nama');
        $table->string('prodi');
        $table->enum('semester', ['1','2','3','4','5','6','7','8']);
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('mahasiswas');
}
```

3. Jalankan dan cek (tabel `artikels` dari tugas P2 ikut terbentuk, itu normal). Verifikasi tabel di phpMyAdmin:

```bash
php artisan migrate
php artisan migrate:status
```

4. Tambah kolom lewat migration baru:

```bash
php artisan make:migration add_email_to_mahasiswas_table --table=mahasiswas
```

```php
public function up(): void
{
    Schema::table('mahasiswas', function (Blueprint $table) {
        $table->string('email')->nullable()->after('nama');
    });
}
public function down(): void
{
    Schema::table('mahasiswas', function (Blueprint $table) {
        $table->dropColumn('email');
    });
}
```

```bash
php artisan migrate
```

5. Latihan rollback:

```bash
php artisan migrate:rollback --step=1   # kolom email hilang
php artisan migrate                     # kolom email kembali
```

**Tugas Mandiri P3**

1. Buat migration `matakuliahs` **dulu** (urutan penting):

```bash
php artisan make:migration create_matakuliahs_table
```

```php
// up()
Schema::create('matakuliahs', function (Blueprint $table) {
    $table->id();
    $table->string('kode_mk', 20)->unique();
    $table->string('nama_mk');
    $table->integer('sks');
    $table->integer('semester');
    $table->timestamps();
});
// down()
Schema::dropIfExists('matakuliahs');
```

2. Baru setelah itu buat migration FK `dosen_id` ke `users` (nullable agar seeder tanpa dosen tetap valid):

```bash
php artisan make:migration add_dosen_id_to_matakuliahs_table --table=matakuliahs
```

```php
// up()
Schema::table('matakuliahs', function (Blueprint $table) {
    $table->foreignId('dosen_id')->nullable()->after('semester')
          ->constrained('users')->nullOnDelete();
});
// down()
Schema::table('matakuliahs', function (Blueprint $table) {
    $table->dropConstrainedForeignId('dosen_id');
});
```

3. Jalankan dan screenshot berurutan: `php artisan migrate`, `php artisan migrate:status`, `php artisan migrate:rollback --step=1`, lalu `php artisan migrate` lagi.

## M1-P4 Model & Eloquent

1. Lengkapi `app/Models/Mahasiswa.php`:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    use HasFactory;
    protected $fillable = ['nim', 'nama', 'email', 'prodi', 'semester'];
}
```

2. Coba CRUD di Tinker:

```bash
php artisan tinker
```

```php
use App\Models\Mahasiswa;
Mahasiswa::create(['nim'=>'2024010001','nama'=>'Ahmad Fauzi','email'=>'ahmad@kampus.ac.id','prodi'=>'Teknik Informatika','semester'=>'3']);
Mahasiswa::all();
Mahasiswa::where('prodi','Teknik Informatika')->get();
```

3. Route sementara di `routes/web.php` (akan dihapus di Modul 3):

```php
use App\Models\Mahasiswa;

Route::get('/mahasiswa', function () {
    $data = Mahasiswa::all();
    return view('mahasiswa.index', compact('data'));
});
```

4. Buat `resources/views/mahasiswa/index.blade.php`:

```blade
<h1>Daftar Mahasiswa</h1>
<table border="1" cellpadding="8">
    <tr><th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th></tr>
    @foreach ($data as $mhs)
    <tr>
        <td>{{ $mhs->nim }}</td><td>{{ $mhs->nama }}</td>
        <td>{{ $mhs->prodi }}</td><td>{{ $mhs->semester }}</td>
    </tr>
    @endforeach
</table>
```

5. Uji di http://127.0.0.1:8000/mahasiswa.

**Tugas Mandiri P4**

1. Buat model `Matakuliah`:

```bash
php artisan make:model Matakuliah
```

Isi model (tambahkan `use Illuminate\Database\Eloquent\Factories\HasFactory;` di atas kalau belum ada, karena factory di P5 butuh trait ini):

```php
use HasFactory;
protected $fillable = ['kode_mk','nama_mk','sks','semester','dosen_id'];
```

2. Tambahkan relasi `belongsTo` ke `User` sebagai dosen pengampu:

```php
public function dosen()
{
    return $this->belongsTo(\App\Models\User::class, 'dosen_id');
}
```

3. Route sementara (daftar + form tambah), **dihapus di Modul 3**:

```php
use App\Models\Matakuliah;
use App\Models\User;
use Illuminate\Http\Request;

Route::get('/matakuliah', function () {
    $data = Matakuliah::with('dosen')->get();
    return view('matakuliah.index', compact('data'));
});
Route::get('/matakuliah/tambah', function () {
    $dosen = User::all();
    return view('matakuliah.tambah', compact('dosen'));
});
Route::post('/matakuliah', function (Request $request) {
    Matakuliah::create($request->only(['kode_mk','nama_mk','sks','semester','dosen_id']));
    return redirect('/matakuliah');
});
```

4. View `resources/views/matakuliah/index.blade.php`:

```blade
<h1>Daftar Mata Kuliah</h1>
<a href="/matakuliah/tambah">+ Tambah</a>
<table border="1" cellpadding="8">
    <tr><th>Kode</th><th>Nama</th><th>SKS</th><th>Semester</th><th>Dosen Pengampu</th></tr>
    @foreach ($data as $mk)
    <tr>
        <td>{{ $mk->kode_mk }}</td><td>{{ $mk->nama_mk }}</td>
        <td>{{ $mk->sks }}</td><td>{{ $mk->semester }}</td>
        <td>{{ $mk->dosen->name ?? '-' }}</td>
    </tr>
    @endforeach
</table>
```

5. View `resources/views/matakuliah/tambah.blade.php` (kalau belum ada user, buat lewat Tinker: `User::factory()->create();`):

```blade
<h1>Tambah Mata Kuliah</h1>
<form action="/matakuliah" method="POST">
    @csrf
    <input type="text" name="kode_mk" placeholder="Kode MK"><br>
    <input type="text" name="nama_mk" placeholder="Nama MK"><br>
    <input type="number" name="sks" placeholder="SKS"><br>
    <input type="number" name="semester" placeholder="Semester"><br>
    <select name="dosen_id">
        <option value="">-- Pilih Dosen --</option>
        @foreach ($dosen as $d)
            <option value="{{ $d->id }}">{{ $d->name }}</option>
        @endforeach
    </select><br>
    <button type="submit">Simpan</button>
</form>
```

6. Screenshot `/mahasiswa`, `/matakuliah`, dan form tambah.

## M1-P5 Seeder & Factory

1. Buat seeder:

```bash
php artisan make:seeder MahasiswaSeeder
```

Isi `run()` dengan 2 data contoh:

```php
use App\Models\Mahasiswa;

Mahasiswa::create(['nim'=>'2024010001','nama'=>'Ahmad Fauzi','email'=>'ahmad@kampus.ac.id','prodi'=>'Teknik Informatika','semester'=>'3']);
Mahasiswa::create(['nim'=>'2024010002','nama'=>'Siti Aminah','email'=>'siti@kampus.ac.id','prodi'=>'Sistem Informasi','semester'=>'1']);
```

2. Daftarkan di `database/seeders/DatabaseSeeder.php`. **Biarkan** baris pembuatan user bawaan, akun itu dipakai login di Modul 5:

```php
$this->call([
    MahasiswaSeeder::class,
]);
```

3. Jalankan seeder. **(Tambahan)** Panduan memakai `php artisan db:seed`, tetapi data Tinker dari P4 (NIM 2024010001) bentrok dengan seeder karena kolom `nim` unik. Pakai ini supaya bersih dari awal:

```bash
php artisan migrate:fresh --seed
```

Lalu cek tabel `mahasiswas`.

4. Buat factory:

```bash
php artisan make:factory MahasiswaFactory --model=Mahasiswa
```

```php
public function definition(): array
{
    return [
        'nim' => fake()->unique()->numerify('2024##0###'),
        'nama' => fake()->name(),
        'email' => fake()->unique()->safeEmail(),
        'prodi' => fake()->randomElement(['Teknik Informatika','Sistem Informasi','Teknik Komputer']),
        'semester' => fake()->numberBetween(1, 8),
    ];
}
```

Ubah `MahasiswaSeeder::run()` menjadi:

```php
\App\Models\Mahasiswa::factory()->count(50)->create();
```

5. Reset dan isi ulang: `php artisan migrate:fresh --seed`
6. Verifikasi di `/mahasiswa`: 50 data tampil.

**Tugas Mandiri P5**

1. Factory mata kuliah:

```bash
php artisan make:factory MatakuliahFactory --model=Matakuliah
```

```php
public function definition(): array
{
    return [
        'kode_mk'  => fake()->unique()->bothify('MK-###'),
        'nama_mk'  => fake()->unique()->words(3, true),
        'sks'      => fake()->numberBetween(1, 4),
        'semester' => fake()->numberBetween(1, 8),
    ];
}
```

2. Seeder 20 data:

```bash
php artisan make:seeder MatakuliahSeeder
```

```php
\App\Models\Matakuliah::factory()->count(20)->create();
```

Daftarkan di `DatabaseSeeder`: `$this->call([MahasiswaSeeder::class, MatakuliahSeeder::class]);`

3. Jalankan `php artisan migrate:fresh --seed`, lalu screenshot terminal dan tabel data (browser/phpMyAdmin).

## Proyek Akhir Modul 1

Syarat minimal: ≥2 tabel berelasi lewat migration · ≥2 model berelasi · ≥1 factory dan seeder (≥20 baris per tabel) · ≥3 perintah `make:` yang di-screenshot · halaman web yang menampilkan data kedua tabel beserta relasinya.

**(Tambahan) Supaya relasi dosen benar-benar terlihat.** Factory `Matakuliah` membiarkan `dosen_id` kosong, jadi kolom dosen di `/matakuliah` akan "-" semua. Perbaikannya:

1. Di `DatabaseSeeder::run()`, tambahkan **sebelum** `$this->call(...)`:

```php
\App\Models\User::factory(5)->create();
```

2. Di `MatakuliahFactory::definition()`, tambahkan satu baris dalam array:

```php
'dosen_id' => \App\Models\User::inRandomOrder()->value('id'),
```

3. (Opsional, memperkuat syarat `hasMany`) di `app/Models/User.php`:

```php
public function matakuliahs()
{
    return $this->hasMany(\App\Models\Matakuliah::class, 'dosen_id');
}
```

4. Jalankan `php artisan migrate:fresh --seed` lagi.

**Checkpoint M1:** `migrate:fresh --seed` sukses tanpa error · `/mahasiswa` menampilkan 50 data · `/matakuliah` menampilkan 20 data dengan nama dosen.

**Pengumpulan:** zip proyek tanpa `vendor/` dan `node_modules/`, `README.md` singkat (nama, NIM, deskripsi, daftar perintah Artisan, cara menjalankan; template lengkap ada di M2-P5), plus screenshot migration, seeding, dan halaman akhir.

---

# MODUL 2 — Git & GitHub

## M2-P1 Konsep version control

1. Diskusikan pengalaman kehilangan versi file, kaitkan dengan manfaat VCS.
2. Pahami alur ini dan jelaskan 4 area dengan kalimat sendiri:

```
Working Directory --git add--> Staging Area --git commit--> Local Repository --git push--> Remote (GitHub)
```

3. Cari 1 proyek open-source di GitHub, amati riwayat commit dan kontributornya.

**Tugas Mandiri P1**

- Jelaskan 3–4 kalimat beda Git vs GitHub + analogi. _Poin: Git = buku catatan pribadi di komputer; GitHub = lemari bersama online tempat buku itu disimpan dan dibagikan._
- Jelaskan 2–3 kalimat mengapa `git add` dipisah dari commit. _Poin: memilih perubahan mana yang masuk satu commit agar commit rapi, fokus, dan bermakna._

## M2-P2 Akun GitHub & instalasi Git

1. Buka https://github.com → **Sign up** → isi email, password, username profesional → selesaikan captcha dan verifikasi email.
2. **Settings → Public profile**: isi foto, nama lengkap, bio (mis. "Mahasiswa Pemrograman Web — belajar Laravel").
3. Pasang Git: Windows pakai installer dari https://git-scm.com/downloads (opsi default); macOS `brew install git`; Ubuntu/Debian `sudo apt update && sudo apt install git`.
4. Verifikasi: `git --version`

**Tugas Mandiri P2**

- Screenshot profil GitHub (foto, nama, bio) beserta URL `github.com/Adkira155`.
- Screenshot `git --version`.
- Jelaskan 2–3 kalimat mengapa perusahaan meminta profil GitHub. _Poin: bukti portofolio nyata; riwayat commit menunjukkan konsistensi, kualitas kode, dan kemampuan kolaborasi._

## M2-P3 Konfigurasi Git & .gitignore

1. Atur identitas dan cek:

```bash
git config --global user.name "Nama Lengkap Kamu"
git config --global user.email "email_kamu@contoh.com"
git config --list
```

2. Masuk proyek: `cd praktikum-laravel`
3. Inisialisasi, **lewati kalau folder `.git` sudah ada** dari `laravel new`:

```bash
git init
```

4. Ambil bukti **sebelum** `.gitignore`:

```bash
mv .gitignore .gitignore.bak       # Windows: ren .gitignore .gitignore.bak
git status                         # banyak file, termasuk vendor/ dan .env
mv .gitignore.bak .gitignore       # WAJIB dikembalikan
```

5. Cek isi `.gitignore` (harus memuat `/vendor`, `/node_modules`, `.env`): `cat .gitignore`
6. Ambil bukti **sesudah** `.gitignore`: jalankan `git status`; `vendor/`, `node_modules/`, dan `.env` tidak muncul.

**Tugas Mandiri P3**

- Screenshot `git config --list` (user.name dan user.email terlihat).
- Screenshot `git status` sebelum dan sesudah `.gitignore`, tunjukkan selisih jumlah file.
- Jelaskan 3–4 kalimat risiko `.env` ter-push ke repo publik. _Poin: kredensial DB dan `APP_KEY` bocor dan bisa disalahgunakan; riwayat Git tetap menyimpannya walau file dihapus belakangan._

## M2-P4 Membuat repository di GitHub

1. GitHub → ikon **+** → **New repository**.
2. Isi: Name `praktikum-laravel`; Description `Proyek praktikum Pemrograman Web menggunakan Laravel 13`; Visibility Public/Private sesuai dosen. **JANGAN centang** README, .gitignore, atau license (supaya push pertama tidak konflik).
3. Klik **Create repository**.
4. Salin URL `https://github.com/Adkira155/praktikum-laravel-c030325002.git` dan catat untuk P5.
5. Jelajahi tab Code, Issues, Pull requests, Settings.

**Tugas Mandiri P4**

- Buat repo `latihan-git` (Public) **dengan** README otomatis **dicentang**.
- Screenshot halaman Quick Setup `praktikum-laravel` yang menampilkan URL.
- Jelaskan 2–3 kalimat kapan Private vs Public. _Poin: Private untuk tugas belum final/rahasia/komersial; Public untuk portofolio, open-source, atau tugas yang boleh dilihat umum._

## M2-P5 Staging, commit, push

1. Buat **Personal Access Token**: GitHub → Settings → Developer settings → Personal access tokens → Tokens (classic) → Generate new token → centang minimal `repo` → salin token (hanya tampil sekali, jangan dibagikan ke siapa pun).
2. Di folder `praktikum-laravel`:

```bash
git add .
git status
git commit -m "Initial commit: proyek awal praktikum Laravel"
git remote add origin https://github.com/Adkira155/praktikum-laravel-c030325002.git
git remote -v
git branch -M main
git push -u origin main
```

Saat diminta login: username GitHub dan **token** (bukan password GitHub).

3. Refresh halaman repo. File tampil, tanpa `vendor/`, `node_modules/`, `.env`.
4. Latihan update: ubah `README.md` sedikit, lalu:

```bash
git add .
git commit -m "Update README dengan deskripsi proyek"
git push
```

**Tugas Mandiri P5**

1. Screenshot halaman repo berisi daftar file hasil push.
2. Buat minimal **2 commit susulan** dengan pesan berbeda, lalu screenshot tab **Commits**.
3. Ganti `README.md` bawaan Laravel dengan README proyekmu. Template (baris perintah memakai indentasi 4 spasi supaya tampil sebagai kode):

```markdown
# Praktikum Laravel — Nama Kamu (NIM)

Proyek praktikum Pemrograman Web menggunakan Laravel 13.

## Teknologi

Laravel 13, PHP 8.3, MySQL, Blade

## Cara menjalankan

Buat database kosong `praktikum_laravel`, lalu jalankan berurutan:

    composer install
    cp .env.example .env
    php artisan key:generate
    # sesuaikan DB_CONNECTION=mysql dan DB_DATABASE=praktikum_laravel di .env
    php artisan migrate:fresh --seed
    php artisan serve
```

Baris komentar tentang `.env` adalah **(Tambahan)**: tanpa itu, orang yang meng-clone repo bisa gagal migrate karena koneksi database belum diatur. Lalu:

```bash
git add .
git commit -m "Lengkapi README"
git push
```

## M2-P6 Update, pull, dan clone

1. Simulasi komputer kedua:

```bash
cd ..
git clone https://github.com/Adkira155/praktikum-laravel-c030325002.git praktikum-laravel-clone
cd praktikum-laravel-clone
```

2. Bandingkan riwayat (harus identik dengan folder asli): `git log --oneline`
3. Di folder **asli**, ubah satu baris `README.md`, lalu `git add .`, `git commit -m "..."`, `git push`.
4. Di folder **clone**: `git pull`. Perubahan masuk otomatis. Screenshot buktinya.
5. Diskusi: bila kedua folder mengubah baris yang sama sebelum saling `pull`, terjadi merge conflict yang harus diselesaikan manual.
6. Setelah semua screenshot terkumpul, hapus folder clone agar tidak tertukar dengan folder asli (`rm -rf praktikum-laravel-clone`; Windows: `rmdir /s /q praktikum-laravel-clone`).

**Tugas Mandiri P6**

- Screenshot `git log --oneline` di folder clone.
- Screenshot bukti sinkron setelah `git pull`.
- Jelaskan 3–4 kalimat pentingnya `git pull` sebelum bekerja. _Poin: memastikan basis kerja terbaru, mencegah konflik dan pekerjaan saling menimpa, memudahkan kolaborasi._

## Proyek Akhir Modul 2

Syaratnya: `.gitignore` benar · ≥5 commit bermakna · terhubung dan ter-push ke GitHub · README informatif · bisa di-clone dan dijalankan ulang · dikumpulkan berupa **link repo** (bukan zip). Syarat ≥5 commit terpenuhi otomatis kalau kamu commit tiap praktikum Modul 3. Verifikasi clone-ulang dilakukan di bagian akhir panduan ini.

**Checkpoint M2:** di GitHub tidak ada `vendor/`, `node_modules/`, atau `.env`.

---

# MODUL 3 — Routing, View & Blade

## Langkah 0 (wajib): bersihkan route sementara Modul 1

Buka `routes/web.php` dan hapus semua route sementara dari Modul 1: `/mahasiswa` (closure), GET `/matakuliah`, GET `/matakuliah/tambah`, POST `/matakuliah`, dan `/tes`. Biarkan route `/` (welcome). Hapus juga baris `use` yang tidak terpakai. **(Tambahan)** file `resources/views/matakuliah/tambah.blade.php` boleh dihapus karena routenya sudah tidak ada. Hasilnya:

```php
<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
```

Cek dengan `php artisan route:list`. Pastikan `php artisan serve` tetap hidup selama Modul 3.

## M3-P1 Routing dasar

1. Tambahkan di `routes/web.php`:

```php
Route::get('/halo', function () {
    return 'Halo, Laravel!';
});
Route::get('/tentang-kami', function () {
    return 'Halaman Tentang Kami';
});
```

2. Uji `/halo` dan `/tentang-kami` di browser.
3. Uji URL yang tidak ada (mis. `/xyz`): muncul halaman **404**.
4. Lihat daftar route dan perhatikan kolom Method, URI, Action: `php artisan route:list`

**Tugas Mandiri P1**

1. Tambah 3 route dengan teks berbeda:

```php
Route::get('/profil', function () { return 'Halaman Profil'; });
Route::get('/kontak', function () { return 'Halaman Kontak'; });
Route::get('/tentang', function () { return 'Halaman Tentang'; });
```

2. Screenshot browser untuk tiap route, plus screenshot `route:list`.
3. Jelaskan 3–5 kalimat alur request → response. _Poin: browser kirim request → `public/index.php` → router mencocokkan URI di `routes/web.php` → closure/controller dijalankan → response dikembalikan ke browser._

**Commit:** `git add .` → `git commit -m "Modul 3 P1: routing dasar"` → `git push`

## M3-P2 Parameter, named route, dan group

1. Isi `app/Http/Controllers/MahasiswaController.php` seperti ini:

```php
<?php

namespace App\Http\Controllers;

class MahasiswaController extends Controller
{
    public function index()
    {
        return 'Daftar Mahasiswa';
    }

    public function show($nim)
    {
        return 'Detail Mahasiswa NIM: ' . $nim;
    }
}
```

2. Tambahkan route ke controller, lengkap dengan nama dan batasan parameter (baris `use` taruh di bagian atas file):

```php
use App\Http\Controllers\MahasiswaController;

Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
Route::get('/mahasiswa/{nim}', [MahasiswaController::class, 'show'])
    ->where('nim', '[0-9]+')
    ->name('mahasiswa.show');
```

3. Uji `/mahasiswa/2024010001` (tampil) dan `/mahasiswa/abc` (404).
4. Tambahkan route parameter opsional:

```php
Route::get('/sapa/{nama?}', function ($nama = 'Tamu') {
    return "Halo, $nama!";
});
```

5. Tambahkan route group admin (sementara pakai closure, diganti controller di Modul 4):

```php
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return 'Dashboard Admin'; })->name('dashboard');
    Route::get('/pengguna', function () { return 'Kelola Pengguna'; })->name('pengguna');
});
```

6. Uji `/admin/dashboard`, `/admin/pengguna`, `/sapa`, `/sapa/Budi`, lalu `php artisan route:list`.

**Tugas Mandiri P2**

1. Buat controller mata kuliah:

```bash
php artisan make:controller MatakuliahController
```

```php
public function index() { return 'Daftar Mata Kuliah'; }
public function show($kode) { return 'Detail MK: ' . $kode; }
```

2. Tambahkan route `matakuliah.index` dan `matakuliah.show` (parameter `{kode}` dibatasi `where`):

```php
use App\Http\Controllers\MatakuliahController;

Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
Route::get('/matakuliah/{kode}', [MatakuliahController::class, 'show'])
    ->where('kode', '[A-Za-z0-9-]+')->name('matakuliah.show');
```

3. Bungkus route `mahasiswa.*` dan `matakuliah.*` dalam satu grup prefix `akademik`. **Jangan** tambahkan `name()` pada grup agar nama route tetap `mahasiswa.index` dst. Hapus semua definisi route lepas (langkah 2 latihan dan langkah 2 tugas) supaya tidak dobel:

```php
Route::prefix('akademik')->group(function () {
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/mahasiswa/{nim}', [MahasiswaController::class, 'show'])->where('nim', '[0-9]+')->name('mahasiswa.show');
    Route::get('/matakuliah', [MatakuliahController::class, 'index'])->name('matakuliah.index');
    Route::get('/matakuliah/{kode}', [MatakuliahController::class, 'show'])->where('kode', '[A-Za-z0-9-]+')->name('matakuliah.show');
});
```

URL kini `/akademik/mahasiswa` dan seterusnya. 4. Screenshot `route:list` dan hasil uji di browser.

**Commit:** `git add .` → `git commit -m "Modul 3 P2: parameter, named route, group"` → `git push`

## M3-P3 Resource, model binding, fallback

1. Di dalam grup `akademik`, ganti dua route mahasiswa menjadi satu resource (route matakuliah dari P2 tetap dulu):

```php
Route::prefix('akademik')->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class);
    // route matakuliah dari P2 tetap dulu
});
```

2. Cek `php artisan route:list --name=mahasiswa`: harus 7 route (index, create, store, show, edit, update, destroy). Dari browser cukup uji yang GET (`index`, `create`, `show`, `edit`); `store`, `update`, `destroy` baru bisa diuji lewat form atau Postman.
3. Ganti seluruh isi `MahasiswaController` (method lama `show($nim)` hilang):

```php
<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()   { return 'index: daftar mahasiswa'; }
    public function create()  { return 'create: form tambah'; }
    public function store(Request $request) { return 'store: simpan data baru'; }
    public function show(Mahasiswa $mahasiswa)
    {
        return 'Mahasiswa: ' . $mahasiswa->nama . ' (' . $mahasiswa->nim . ')';
    }
    public function edit($id)   { return 'edit: form ubah ' . $id; }
    public function update(Request $request, $id) { return 'update: ' . $id; }
    public function destroy($id) { return 'destroy: ' . $id; }
}
```

4. Uji `/akademik/mahasiswa/1` (nama tampil lewat model binding) dan `/akademik/mahasiswa/9999` (404 otomatis). Kalau id 1 pun 404, data belum di-seed: jalankan `php artisan migrate:fresh --seed`.
5. Tambahkan route fallback di **paling bawah** file `routes/web.php`:

```php
Route::fallback(function () {
    return response('Halaman tidak ditemukan.', 404);
});
```

**Tugas Mandiri P3**

1. Di grup `akademik`, hapus 2 route matakuliah lama dari P2, ganti dengan resource terbatas (4 route):

```php
Route::resource('matakuliah', MatakuliahController::class)
    ->only(['index', 'show', 'create', 'store']);
```

2. Ganti seluruh isi `MatakuliahController` dengan model binding:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()  { return 'Daftar Mata Kuliah'; }
    public function create() { return 'Form tambah mata kuliah'; }
    public function store(Request $request) { return 'Simpan mata kuliah'; }
    public function show(Matakuliah $matakuliah)
    {
        return 'Mata kuliah: ' . $matakuliah->nama_mk;
    }
}
```

3. Screenshot `php artisan route:list --name=matakuliah` (hanya 4 route) dan hasil uji `/akademik/matakuliah/1`.
4. Buat tabel perbandingan Route Biasa vs Resource vs Resource terbatas (jumlah route, kapan dipakai). _Poin: manual = kontrol penuh tapi banyak ketik; resource = 7 route CRUD standar sekali tulis; terbatas = hanya aksi yang dibutuhkan._

**Commit:** `git add .` → `git commit -m "Modul 3 P3: resource, model binding, fallback"` → `git push`

## M3-P4 Membuat view

1. Buat `resources/views/sapa.blade.php`:

```blade
<h1>Halo, Dunia!</h1>
<p>Ini view pertamaku.</p>
```

2. Tambahkan route (taruh di atas fallback):

```php
Route::get('/sapa-view', function () {
    return view('sapa');
});
```

3. Ubah route itu untuk mengirim data, lalu di view ganti judulnya menjadi `<h1>Halo, {{ $nama }}!</h1>`:

```php
Route::get('/sapa-view', function () {
    $nama = 'Budi';
    return view('sapa', compact('nama'));
    // alternatif: view('sapa')->with('nama', $nama);
});
```

4. Ubah `MahasiswaController@index` agar memakai view (pastikan `use App\Models\Mahasiswa;` masih ada di atas file dari P3):

```php
public function index()
{
    $mahasiswa = Mahasiswa::all();
    return view('mahasiswa.index', compact('mahasiswa'));
}
```

Timpa isi `resources/views/mahasiswa/index.blade.php` (versi Modul 1 memakai `$data`, jadi harus diganti):

```blade
<h1>Daftar Mahasiswa</h1>
<p>Total: {{ count($mahasiswa) }} mahasiswa</p>
```

5. Cek di Tinker: `view()->exists('mahasiswa.index');` hasilnya `true`.

**Tugas Mandiri P4**

1. Ubah route `/profil` dari P1 (**ganti**, jangan buat route kedua) agar memakai view `profil` dan mengirim 3 data lewat `with()`:

```php
Route::get('/profil', function () {
    return view('profil')
        ->with('nama', 'Nama Kamu')
        ->with('nim', '2024010001')
        ->with('prodi', 'Teknik Informatika');
});
```

Buat `resources/views/profil.blade.php`:

```blade
<h1>Profil</h1>
<p>Nama: {{ $nama }}</p>
<p>NIM: {{ $nim }}</p>
<p>Prodi: {{ $prodi }}</p>
```

2. Buat view bersarang `resources/views/akademik/statistik.blade.php` (isi bebas, mis. `<h1>Statistik Akademik</h1>`), tampilkan lewat route:

```php
Route::get('/statistik-uji', function () {
    return view('akademik.statistik');
});
```

Jelaskan cara memanggil view bersarang. _Poin: titik = pemisah folder (`akademik.statistik` → `views/akademik/statistik.blade.php`), menjaga struktur view rapi._

3. Jelaskan 3–4 kalimat mengapa Controller dan View dipisah. _Poin: Controller fokus ke logika dan data, View fokus ke tampilan; kode rapi, mudah dirawat dan diuji, tim front-end/back-end bisa bekerja terpisah._

**Commit:** `git add .` → `git commit -m "Modul 3 P4: membuat view"` → `git push`

## M3-P5 Blade dasar

1. Perbarui `resources/views/sapa.blade.php`, lalu uji di `/sapa-view`:

```blade
<h1>Halo, {{ $nama }}!</h1>
<p>Waktu: {{ now()->format('d M Y H:i') }}</p>
<p>Hitung: {{ 5 * 3 }}</p>
<p>Default: {{ $kota ?? 'Kota belum diisi' }}</p>
```

2. Uji perbedaan escape vs raw. Tambahkan route (di atas fallback):

```php
Route::get('/uji-escape', function () {
    return view('uji-escape', ['teks' => '<b>Tebal</b> <i>Miring</i>']);
});
```

Buat `resources/views/uji-escape.blade.php`:

```blade
<p>Escaped : {{ $teks }}</p>
<p>Raw     : {!! $teks !!}</p>
```

3. Tambahkan baris ini di view yang sama untuk melihat cara menyembunyikan sintaks Blade (tampil apa adanya sebagai teks):

```blade
<p>Contoh: @{{ nama }}</p>
```

4. Coba komentar Blade dan blok PHP:

```blade
{{-- Komentar Blade: tidak tampil di browser --}}
@php
    $tahunSekarang = date('Y');
@endphp
<p>Tahun: {{ $tahunSekarang }}</p>
```

5. Intip file hasil kompilasi di `storage/framework/views/` (buka salah satu file; `{{ }}` berubah menjadi `<?php echo e(...); ?>`).

**Tugas Mandiri P5**

1. Buat route `/blade-demo` dan view `blade-demo.blade.php` yang menampilkan 5 mahasiswa pertama, dengan `{{ }}` dan `??` untuk email kosong:

```php
Route::get('/blade-demo', function () {
    $mahasiswa = \App\Models\Mahasiswa::take(5)->get();
    return view('blade-demo', compact('mahasiswa'));
});
```

```blade
@foreach ($mahasiswa as $m)
    <p>{{ $m->nim }} - {{ $m->nama }} - {{ $m->email ?? '-' }}</p>
@endforeach
```

2. Uji XSS. **(Tambahan)** `take(5)` hanya mengambil data pertama, jadi data uji yang baru dibuat tidak akan tampil di `/blade-demo`. Pakai route sementara sendiri. Buat data uji di Tinker:

```php
use App\Models\Mahasiswa;
Mahasiswa::create(['nim'=>'9999999999','nama'=>"<script>alert('XSS')</script>",'prodi'=>'Uji XSS','semester'=>'1']);
```

Route sementara:

```php
Route::get('/xss-uji', function () {
    $mahasiswa = \App\Models\Mahasiswa::where('prodi', 'Uji XSS')->get();
    return view('xss-uji', compact('mahasiswa'));
});
```

View `resources/views/xss-uji.blade.php`:

```blade
@foreach ($mahasiswa as $m)
    <p>Aman: {{ $m->nama }}</p>
    <p>Bahaya: {!! $m->nama !!}</p>
@endforeach
```

Buka `/xss-uji`, screenshot tampilan aman dan popup alert dari versi `{!! !!}`. **Setelah screenshot, hapus data ujinya** di Tinker, lalu hapus route dan view sementara:

```php
Mahasiswa::where('prodi', 'Uji XSS')->delete();
```

Jelaskan 2–3 kalimat mengapa `{{ }}` lebih aman sebagai default. _Poin: `{{ }}` otomatis meng-escape HTML sehingga tag `<script>` tampil sebagai teks, bukan dijalankan._

3. Jelaskan 3–4 kalimat kapan `{!! !!}` boleh dipakai. _Poin: hanya untuk HTML tepercaya yang dibuat sendiri atau sudah disanitasi; jangan pernah untuk input pengguna karena celah XSS._

**Commit:** `git add .` → `git commit -m "Modul 3 P5: dasar Blade"` → `git push`

## M3-P6 Controller ke View

1. Di `MahasiswaController`, ganti method `index` dan `show` (method lain biarkan):

```php
public function index()
{
    $mahasiswa = Mahasiswa::orderBy('nama')->get();
    return view('mahasiswa.index', compact('mahasiswa'));
}

public function show(Mahasiswa $mahasiswa)
{
    return view('mahasiswa.show', compact('mahasiswa'));
}
```

2. Timpa `resources/views/mahasiswa/index.blade.php`:

```blade
<h1>Daftar Mahasiswa</h1>
<table border="1" cellpadding="8">
    <tr><th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th><th>Aksi</th></tr>
    @foreach ($mahasiswa as $mhs)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $mhs->nim }}</td>
        <td>{{ $mhs->nama }}</td>
        <td>{{ $mhs->prodi }}</td>
        <td>{{ $mhs->semester }}</td>
        <td><a href="{{ route('mahasiswa.show', $mhs->id) }}">Detail</a></td>
    </tr>
    @endforeach
</table>
```

3. Buat `resources/views/mahasiswa/show.blade.php`:

```blade
<h1>Detail Mahasiswa</h1>
<table cellpadding="6">
    <tr><td>NIM</td><td>: {{ $mahasiswa->nim }}</td></tr>
    <tr><td>Nama</td><td>: {{ $mahasiswa->nama }}</td></tr>
    <tr><td>Email</td><td>: {{ $mahasiswa->email ?? '-' }}</td></tr>
    <tr><td>Prodi</td><td>: {{ $mahasiswa->prodi }}</td></tr>
    <tr><td>Semester</td><td>: {{ $mahasiswa->semester }}</td></tr>
</table>
<a href="{{ route('mahasiswa.index') }}">← Kembali</a>
```

4. Uji `/akademik/mahasiswa`, klik **Detail**, pastikan data yang tampil sesuai.

**Tugas Mandiri P6**

1. Di `MatakuliahController`, ganti method `index` dan `show`:

```php
public function index()
{
    $matakuliah = Matakuliah::with('dosen')->orderBy('kode_mk')->get();
    return view('matakuliah.index', compact('matakuliah'));
}

public function show(Matakuliah $matakuliah)
{
    return view('matakuliah.show', compact('matakuliah'));
}
```

2. Timpa `resources/views/matakuliah/index.blade.php` (versi Modul 1 memakai `$data`, harus diganti):

```blade
<h1>Daftar Mata Kuliah</h1>
<table border="1" cellpadding="8">
    <tr><th>No</th><th>Kode</th><th>Nama</th><th>SKS</th><th>Semester</th><th>Dosen</th><th>Aksi</th></tr>
    @foreach ($matakuliah as $mk)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $mk->kode_mk }}</td>
        <td>{{ $mk->nama_mk }}</td>
        <td>{{ $mk->sks }}</td>
        <td>{{ $mk->semester }}</td>
        <td>{{ $mk->dosen->name ?? '-' }}</td>
        <td><a href="{{ route('matakuliah.show', $mk->id) }}">Detail</a></td>
    </tr>
    @endforeach
</table>
```

Buat `resources/views/matakuliah/show.blade.php`:

```blade
<h1>Detail Mata Kuliah</h1>
<table cellpadding="6">
    <tr><td>Kode</td><td>: {{ $matakuliah->kode_mk }}</td></tr>
    <tr><td>Nama</td><td>: {{ $matakuliah->nama_mk }}</td></tr>
    <tr><td>SKS</td><td>: {{ $matakuliah->sks }}</td></tr>
    <tr><td>Semester</td><td>: {{ $matakuliah->semester }}</td></tr>
    <tr><td>Dosen</td><td>: {{ $matakuliah->dosen->name ?? '-' }}</td></tr>
</table>
<a href="{{ route('matakuliah.index') }}">← Kembali</a>
```

3. Tambahkan tautan navigasi sementara di bagian paling atas **kedua** view index (dipindah ke navbar layout di P8):

```blade
<a href="{{ route('mahasiswa.index') }}">Mahasiswa</a> |
<a href="{{ route('matakuliah.index') }}">Mata Kuliah</a>
```

4. Screenshot halaman daftar dan detail untuk mahasiswa **dan** mata kuliah.

**Commit:** `git add .` → `git commit -m "Modul 3 P6: controller ke view"` → `git push`

## M3-P7 Struktur kontrol Blade

1. Timpa `mahasiswa/index.blade.php` dengan versi `@forelse`, `$loop`, dan `@if` (tautan navigasi sementara dari P6 tetap di baris atas):

```blade
{{-- navigasi sementara, dihapus di P8 --}}
<a href="{{ route('mahasiswa.index') }}">Mahasiswa</a> |
<a href="{{ route('matakuliah.index') }}">Mata Kuliah</a>

<h1>Daftar Mahasiswa</h1>
<table border="1" cellpadding="8">
    <tr><th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th><th>Status</th><th>Aksi</th></tr>
    @forelse ($mahasiswa as $mhs)
    <tr style="background: {{ $loop->even ? '#f2f2f2' : '#fff' }}">
        <td>{{ $loop->iteration }}</td>
        <td>{{ $mhs->nim }}</td>
        <td>{{ $mhs->nama }}</td>
        <td>{{ $mhs->prodi }}</td>
        <td>{{ $mhs->semester }}</td>
        <td>
            @if ($mhs->semester >= 7)
                <b>Tingkat Akhir</b>
            @elseif ($mhs->semester >= 3)
                Aktif
            @else
                Baru
            @endif
        </td>
        <td><a href="{{ route('mahasiswa.show', $mhs->id) }}">Detail</a></td>
    </tr>
    @empty
    <tr><td colspan="7" align="center">Belum ada data mahasiswa.</td></tr>
    @endforelse
</table>
```

2. Uji kondisi kosong: di `MahasiswaController@index` ubah sementara jadi `$mahasiswa = collect();`, pastikan pesan "Belum ada data mahasiswa." muncul, screenshot, lalu **kembalikan** ke `Mahasiswa::orderBy('nama')->get();`.
3. Coba `@switch` berbasis nilai sebagai alternatif kolom Status:

```blade
@switch((int) $mhs->semester)
    @case(1)
    @case(2)
        Mahasiswa Baru
        @break
    @case(7)
    @case(8)
        Tingkat Akhir
        @break
    @default
        Mahasiswa Aktif
@endswitch
```

4. Tampilkan sementara `{{ $loop->first ? 'Pertama' : '' }}`, `$loop->last`, dan `$loop->count` untuk melihat nilainya, lalu hapus lagi.

**Tugas Mandiri P7**

1. Timpa `matakuliah/index.blade.php` dengan `@forelse` + `@empty`, label **SKS Besar** (`@if ($mk->sks > 3)`), dan minimal 2 properti `$loop`:

```blade
{{-- navigasi sementara, dihapus di P8 --}}
<a href="{{ route('mahasiswa.index') }}">Mahasiswa</a> |
<a href="{{ route('matakuliah.index') }}">Mata Kuliah</a>

<h1>Daftar Mata Kuliah</h1>
<table border="1" cellpadding="8">
    <tr><th>No</th><th>Kode</th><th>Nama</th><th>SKS</th><th>Semester</th><th>Dosen</th><th>Aksi</th></tr>
    @forelse ($matakuliah as $mk)
    <tr style="background: {{ $loop->even ? '#f2f2f2' : '#fff' }}">
        <td>{{ $loop->iteration }}</td>
        <td>{{ $mk->kode_mk }}</td>
        <td>{{ $mk->nama_mk }}</td>
        <td>
            {{ $mk->sks }}
            @if ($mk->sks > 3) <b>SKS Besar</b> @endif
        </td>
        <td>{{ $mk->semester }}</td>
        <td>{{ $mk->dosen->name ?? '-' }}</td>
        <td><a href="{{ route('matakuliah.show', $mk->id) }}">Detail</a></td>
    </tr>
    @empty
    <tr><td colspan="7" align="center">Belum ada mata kuliah.</td></tr>
    @endforelse
</table>
```

2. Jelaskan fungsi 2 properti `$loop` yang kamu pakai. _Poin: `iteration` = nomor urut mulai 1; `even`/`odd` = baris genap/ganjil untuk warna selang-seling; `first`/`last`/`count` = penanda posisi dan total._
3. Screenshot tampilan dengan data dan tampilan kosong (pakai trik `collect()` seperti di atas, lalu kembalikan).

**Commit:** `git add .` → `git commit -m "Modul 3 P7: struktur kontrol Blade"` → `git push`

## M3-P8 Layout Blade

1. Buat `resources/views/layouts/app.blade.php`:

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'Praktikum Laravel') — Praktikum Laravel</title>
    <style>
        body { font-family: sans-serif; margin: 0; }
        nav { background: #1e293b; padding: 12px 24px; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        main { padding: 24px; }
        footer { text-align: center; padding: 16px; color: #666; }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
        <a href="{{ route('matakuliah.index') }}">Mata Kuliah</a>
    </nav>
    <main>
        @yield('konten')
    </main>
    <footer>&copy; {{ date('Y') }} Praktikum Pemrograman Web</footer>
</body>
</html>
```

2. Terapkan ke `mahasiswa/index.blade.php`: tambahkan tiga baris ini di **paling atas**, **hapus** tautan navigasi sementara dari P6/P7 (supaya navbar tidak dobel), lalu tutup file dengan `@endsection`:

```blade
@extends('layouts.app')
@section('judul', 'Daftar Mahasiswa')
@section('konten')

    <h1>Daftar Mahasiswa</h1>
    ... tabel dari P7, tanpa tag html/body ...

@endsection
```

3. Terapkan ke `mahasiswa/show.blade.php` dengan pola yang sama:

```blade
@extends('layouts.app')
@section('judul', 'Detail ' . $mahasiswa->nama)
@section('konten')
    ... isi detail ...
@endsection
```

4. Uji: navbar dan footer muncul di semua halaman, judul tab berubah per halaman.

**Tugas Mandiri P8**

1. Terapkan layout pada `matakuliah/index` dan `matakuliah/show` dengan `@section('judul', ...)` yang berbeda (hapus juga navigasi sementara di `matakuliah/index`).
2. Pindahkan navbar ke partial. Buat `resources/views/partials/navbar.blade.php`:

```blade
<nav>
    <a href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
    <a href="{{ route('matakuliah.index') }}">Mata Kuliah</a>
</nav>
```

Lalu di `layouts/app.blade.php` ganti seluruh blok `<nav> ... </nav>` dengan satu baris:

```blade
@include('partials.navbar')
```

3. Screenshot kedua halaman matakuliah dan file partial.
4. Jelaskan 3–4 kalimat keuntungan layout vs view tanpa layout. _Poin: tidak menulis ulang HTML, perubahan navbar/footer cukup sekali, tampilan konsisten, mudah dirawat._

**Commit:** `git add .` → `git commit -m "Modul 3 P8: layout Blade"` → `git push`

## Proyek Akhir Modul 3

Proyek ini hasil gabungan P1–P8, tidak ada materi baru. Pastikan 5 syarat ini terpenuhi:

1. **Dua resource route** (mahasiswa dan matakuliah). Cek `php artisan route:list`.
2. **Index dan show tertaut lewat `route()`**. Klik Detail dan Kembali di tiap modul.
3. **Satu master layout** dipakai semua halaman daftar dan detail.
4. **Halaman daftar** memakai `@forelse`, minimal 1 properti `$loop`, dan minimal 1 `@if`/`@switch`.
5. **Navigasi memakai named route**, bukan URL tulis tangan. Cari `href="/` di `resources/views` (selain `welcome.blade.php`); hasilnya harus kosong.

Kerangka `routes/web.php` di akhir Modul 3 (closure boleh ditulis versi panjang seperti di latihan):

```php
<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

// Demo P1, P2, P4, P5
Route::get('/halo', fn () => 'Halo, Laravel!');
Route::get('/tentang-kami', fn () => 'Halaman Tentang Kami');
Route::get('/kontak', fn () => 'Halaman Kontak');
Route::get('/tentang', fn () => 'Halaman Tentang');
Route::get('/sapa/{nama?}', fn ($nama = 'Tamu') => "Halo, $nama!");
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', fn () => 'Dashboard Admin')->name('dashboard');
    Route::get('/pengguna', fn () => 'Kelola Pengguna')->name('pengguna');
});
// /profil, /sapa-view, /statistik-uji, /uji-escape, /blade-demo (dari P4 dan P5)

// Modul akademik
Route::prefix('akademik')->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('matakuliah', MatakuliahController::class)
        ->only(['index', 'show', 'create', 'store']);
});

// Paling bawah
Route::fallback(fn () => response('Halaman tidak ditemukan.', 404));
```

**Pengumpulan**

- Simpan daftar route: `php artisan route:list > route-list.txt`, lalu tempel isinya ke `README.md` di bagian "Daftar route", bersama nama, NIM, dan cara menjalankan proyek.
- Screenshot semua halaman: daftar dan detail mahasiswa, daftar dan detail mata kuliah, serta tampilan kosong.
- **(Tambahan)** Buat zip tanpa `vendor/`, `node_modules/`, dan `.env`: commit dulu semuanya, lalu `git archive --format=zip -o ../praktikum-laravel.zip HEAD` (hanya berisi file yang ter-commit).

Commit penutup:

```bash
git add .
git commit -m "Modul 3: routing, view, blade"
git push
```

## Verifikasi akhir Proyek Modul 2: clone ulang dan jalankan

Proyek Akhir Modul 2 menilai apakah repo bisa di-clone dan dijalankan hanya dengan mengikuti README. Lakukan setelah push terakhir:

1. Cek `git status` bersih, `git log --oneline` menampilkan ≥5 commit dengan pesan jelas, dan di GitHub tidak ada `vendor/`, `node_modules/`, `.env`.
2. Buat database terpisah (mis. `praktikum_laravel_uji`). **Jangan** pakai database aslimu, karena `migrate:fresh` menghapus semua tabel di dalamnya.
3. Clone ke folder sementara dan ikuti README apa adanya:

```bash
cd ..
git clone https://github.com/Adkira155/praktikum-laravel-c030325002.git uji-clone
cd uji-clone
composer install
cp .env.example .env
php artisan key:generate
```

Edit `.env` (`DB_CONNECTION=mysql`, `DB_DATABASE=praktikum_laravel_uji`), lalu:

```bash
php artisan migrate:fresh --seed
php artisan serve --port=8001
```

4. Buka http://127.0.0.1:8001/akademik/mahasiswa. Kalau tampil, README-mu sudah benar. Kalau ada langkah yang kurang, perbaiki README di proyek asli, commit, push.
5. Hapus folder `uji-clone` dan database ujinya.

## Kalau ada error

| Gejala                                       | Penyebab umum                                               | Solusi                                                                                                                                                                                                |
| -------------------------------------------- | ----------------------------------------------------------- | ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| `Class "Mahasiswa" not found`                | Import model belum ada                                      | Tambahkan `use App\Models\Mahasiswa;` di atas controller                                                                                                                                              |
| `/akademik/mahasiswa/1` 404                  | Data belum di-seed                                          | `php artisan migrate:fresh --seed`                                                                                                                                                                    |
| `Connection refused` (SQLSTATE 2002)         | MySQL belum menyala atau port salah                         | Nyalakan MySQL, cek `DB_HOST` dan `DB_PORT` di `.env`                                                                                                                                                 |
| `Unknown database`                           | Database belum dibuat                                       | `CREATE DATABASE praktikum_laravel;`                                                                                                                                                                  |
| `Duplicate entry` pada `nim`                 | Data Tinker bentrok dengan seeder                           | `php artisan migrate:fresh --seed`                                                                                                                                                                    |
| `Route [mahasiswa.index] not defined`        | Nama route hilang, atau grup `akademik` diberi `name()`     | Cek `php artisan route:list --name=mahasiswa`; jangan beri `name()` pada grup                                                                                                                         |
| `View [...] not found`                       | Salah nama file atau folder view                            | Cek jalur `resources/views/...blade.php`                                                                                                                                                              |
| `Undefined variable $data`                   | View lama memakai nama variabel Modul 1                     | Samakan nama variabel di `compact()` dan di view                                                                                                                                                      |
| Port 8000 terpakai                           | Ada server lain berjalan                                    | `php artisan serve --port=8001`                                                                                                                                                                       |
| `remote origin already exists`               | Remote sudah pernah ditambah                                | `git remote set-url origin <url>`                                                                                                                                                                     |
| `Authentication failed` saat push            | Memakai password, bukan token, atau token tanpa izin `repo` | Buat token baru; di Windows hapus kredensial GitHub lama di Credential Manager                                                                                                                        |
| Push ditolak (`fetch first`)                 | Repo GitHub dibuat dengan README                            | `git pull origin main --allow-unrelated-histories`, selesaikan, lalu push                                                                                                                             |
| `vendor/` atau `.env` muncul di `git status` | `.gitignore` hilang atau masih bernama `.gitignore.bak`     | Kembalikan nama `.gitignore`; jika sudah ter-commit, `git rm -r --cached vendor` dan `git rm --cached .env`, lalu commit (jika `.env` sudah terlanjur di-push, ganti `APP_KEY` dan password database) |
