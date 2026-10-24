# Panduan Kerja Terpadu Step-by-Step: Modul 4
## Controller, Query Builder & Eloquent ORM pada Laravel 13

*Disusun khusus untuk Adinda Ridha Salsabila (NIM: C030325002) — Kelas TI-3C, Jurusan Teknik Elektro, Politeknik Negeri Banjarmasin.*
*Proyek: `D:\kuliah\Sem3\Desain Web\Laravel\praktikum-laravel-c030325002`*

---

### 💡 Petunjuk Penggunaan Panduan:
1. Kerjakan langkah demi langkah secara berurutan dari **Tahap 0** sampai **Tahap 4** tanpa melompat.
2. Tanda kamera 📸 menandakan **langkah yang wajib diambil screenshot-nya** untuk dimasukkan ke laporan Word (`.docx`).
3. Buat folder khusus penyimpanan screenshot di luar proyek agar tidak mengotori repositori, misalnya:
   `D:\kuliah\Sem3\Desain Web\screenshot-modul4\`

---

## ⚙️ TAHAP 0: PERSIAPAN LINGKUNGAN KERJA

1. Buka aplikasi **Laragon** / **XAMPP**, pastikan service **Apache** dan **MySQL** sudah berstatus *Running*.
2. Buka terminal (VS Code Terminal / PowerShell) pada folder proyek:
   ```bash
   cd "D:\kuliah\Sem3\Desain Web\Laravel\praktikum-laravel-c030325002"
   ```
3. Pastikan database `praktikum_laravel_c030325002` terkoneksi dengan baik di file `.env`.
4. Jalankan server lokal Laravel:
   ```bash
   php artisan serve
   ```
   *(Biarkan terminal ini tetap hidup. Buka tab/jendela terminal kedua untuk menjalankan perintah-perintah Artisan selanjutnya).*

---

# 🏛️ BAGIAN I — CONTROLLER

---

## 📌 LANGKAH 1: PRAKTIKUM 1 (KONSEP DASAR CONTROLLER)

### 1.1 Membuat Controller Dasar Pertama
Jalankan perintah berikut di terminal:
```bash
php artisan make:controller SapaController
```
Buka berkas `app/Http/Controllers/SapaController.php`, lalu lengkapi method `index()`:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SapaController extends Controller
{
    public function index()
    {
        $nama = 'Adinda Ridha Salsabila';
        return "Halo, {$nama}! Ini ditulis di dalam Controller.";
    }
}
```

### 1.2 Mendaftarkan Rute & Uji Coba
Buka berkas `routes/web.php`, tambahkan rute berikut:
```php
use App\Http\Controllers\SapaController;

Route::get('/sapa-controller', [SapaController::class, 'index']);
```
* **Uji di Browser:** Buka alamat `http://127.0.0.1:8000/sapa-controller`.
* 📸 **Screenshot 1.1:** Tampilan browser yang memuat teks *"Halo, Adinda Ridha Salsabila! Ini ditulis di dalam Controller."*

---

### 1.3 Tugas Mandiri Praktikum 1

#### a. Membuat `LatihanController`
Jalankan di terminal:
```bash
php artisan make:controller LatihanController
```
Buka `app/Http/Controllers/LatihanController.php`, isi dengan identitas lengkap Anda:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LatihanController extends Controller
{
    public function index()
    {
        return "Halo, perkenalkan nama saya Adinda Ridha Salsabila, NIM C030325002 dari Program Studi Teknik Informatika Kelas 3C.";
    }
}
```
Daftarkan rutenya di `routes/web.php`:
```php
use App\Http\Controllers\LatihanController;

Route::get('/latihan', [LatihanController::class, 'index']);
```
* **Uji di Browser:** Buka `http://127.0.0.1:8000/latihan`.
* 📸 **Screenshot 1.2:** Tampilan browser rute `/latihan`.

#### b. Diagram Alur Request MVC (Untuk Laporan)
```
[ Browser / Client ]
        │ (1) Request URL: /latihan
        ▼
[ public/index.php & Router (routes/web.php) ]
        │ (2) Memetakan ke Controller
        ▼
[ CONTROLLER (LatihanController@index) ] ◄── (Pusat Logika Bisnis)
        │ (3) Mengolah Data & Memilih Respon
        ▼
[ Browser / Tampilan Respon Teks ]
```

#### c. Jawaban Teori Tugas Mandiri 1
> **Perbedaan Mendasar Route, Controller, dan Model:**
> * **Route:** Sebagai peta alamat (URL dispatcher) yang mencocokkan pola permintaan HTTP dari pengguna menuju Controller atau fungsi penanganan yang tepat.
> * **Controller:** Sebagai pusat kendali logika aplikasi yang menerima input request, meminta data ke Model, memproses logika bisnis, dan menentukan tampilan (View) yang akan disajikan.
> * **Model:** Sebagai representasi entitas data berbasis objek (ORM) yang bertanggung jawab murni atas struktur dan interaksi langsung dengan tabel database (MySQL).

---

## 📌 LANGKAH 2: PRAKTIKUM 2 (PENULISAN CONTROLLER & INPUT REQUEST)

### 2.1 Menangani Input Form POST & Proteksi `@csrf`
1. Buka `app/Http/Controllers/MahasiswaController.php`, pastikan memiliki method `store()` penerima request:
   ```php
   use Illuminate\Http\Request;

   public function store(Request $request)
   {
       $nama = $request->input('nama');
       $nim  = $request->input('nim');

       return "Data yang diterima -> NIM: {$nim}, Nama: {$nama}";
   }
   ```
2. Buat file view form pengujian di `resources/views/mahasiswa/form-uji.blade.php`:
   ```blade
   @extends('layouts.app')
   @section('judul', 'Uji Form Input Request')
   @section('konten')
   <h2>Form Uji Request Controller</h2>
   <form action="/mahasiswa-uji" method="POST">
       @csrf
       <p><input type="text" name="nim" placeholder="Masukkan NIM" required></p>
       <p><input type="text" name="nama" placeholder="Masukkan Nama" required></p>
       <button type="submit">Kirim Data</button>
   </form>
   @endsection
   ```
3. Daftarkan rute di `routes/web.php`:
   ```php
   Route::get('/mahasiswa-uji', function () {
       return view('mahasiswa.form-uji');
   });
   Route::post('/mahasiswa-uji', [MahasiswaController::class, 'store']);
   ```

### 2.2 Mengembalikan Respon Berformat JSON
Buka `app/Http/Controllers/MahasiswaController.php`, tambahkan method `apiIndex()`:
```php
public function apiIndex()
{
    return response()->json([
        'status' => 'sukses',
        'pesan' => 'Ini contoh response JSON dari Controller',
        'penulis' => 'Adinda Ridha Salsabila',
    ]);
}
```
Daftarkan di `routes/web.php`:
```php
Route::get('/api/mahasiswa-json', [MahasiswaController::class, 'apiIndex']);
```
* **Uji di Browser:**
  1. Buka `http://127.0.0.1:8000/mahasiswa-uji`, ketik NIM dan Nama, klik "Kirim Data".
  2. Buka `http://127.0.0.1:8000/api/mahasiswa-json`.
* 📸 **Screenshot 2.1:** Hasil teks setelah mengirim form `/mahasiswa-uji` dan tampilan JSON pada `/api/mahasiswa-json`.

---

### 2.3 Tugas Mandiri Praktikum 2

#### a. Method `cariMahasiswa()` dan Form Pencarian
1. Di `app/Http/Controllers/MahasiswaController.php`, tambahkan method berikut:
   ```php
   public function cariMahasiswa(Request $request)
   {
       $keyword = $request->query('nama');
       if (!$keyword) {
           return "Silakan masukkan kata kunci nama pada form pencarian.";
       }
       return "Konfirmasi: Anda sedang mencari data mahasiswa dengan kata kunci: <strong>{$keyword}</strong>";
   }
   ```
2. Buat file view `resources/views/mahasiswa/cari.blade.php`:
   ```blade
   @extends('layouts.app')
   @section('judul', 'Pencarian Mahasiswa')
   @section('konten')
   <h2>Pencarian Mahasiswa</h2>
   <form action="/cari-mahasiswa" method="GET">
       <input type="text" name="nama" placeholder="Ketik nama mahasiswa..." required>
       <button type="submit">Cari Data</button>
   </form>
   @endsection
   ```
3. Daftarkan di `routes/web.php`:
   ```php
   Route::get('/form-cari', function () {
       return view('mahasiswa.cari');
   });
   Route::get('/cari-mahasiswa', [MahasiswaController::class, 'cariMahasiswa']);
   ```
* **Uji di Browser:** Buka `http://127.0.0.1:8000/form-cari`, isi nama "Adinda", klik tombol "Cari Data".
* 📸 **Screenshot 2.2:** Form pencarian dan hasil teks konfirmasi pencariannya.

#### b. Jawaban Teori Tugas Mandiri 2 (Pentingnya `@csrf`)
> Directive `@csrf` wajib disertakan pada form HTML bermethod POST, PUT, atau DELETE untuk menghasilkan token rahasia (*CSRF Token*). Token ini memvalidasi ke server bahwa permintaan berasal dari form resmi aplikasi kita sendiri, bukan rekayasa berbahaya dari situs web luar (*Cross-Site Request Forgery*). Tanpa `@csrf`, Laravel otomatis menolak request dengan status *419 Page Expired*.

---

## 📌 LANGKAH 3: PRAKTIKUM 3 (PEMBUATAN CONTROLLER VIA ARTISAN)

### 3.1 Single Action Controller (Invokable) & Nested Controller
1. **Buat Controller Statistik (Invokable):**
   ```bash
   php artisan make:controller StatistikMahasiswaController --invokable
   ```
   Buka `app/Http/Controllers/StatistikMahasiswaController.php`, lengkapi method `__invoke()`:
   ```php
   namespace App\Http\Controllers;

   use App\Models\Mahasiswa;

   class StatistikMahasiswaController extends Controller
   {
       public function __invoke()
       {
           $total = Mahasiswa::count();
           return "Statistik Singkat: Total mahasiswa terdaftar di database saat ini adalah {$total} orang.";
       }
   }
   ```
   Daftarkan di `routes/web.php`:
   ```php
   use App\Http\Controllers\StatistikMahasiswaController;

   Route::get('/statistik-invokable', StatistikMahasiswaController::class);
   ```

2. **Buat Nested Controller di Sub-folder Admin:**
   ```bash
   php artisan make:controller Admin/DashboardController
   ```
   Buka `app/Http/Controllers/Admin/DashboardController.php`:
   ```php
   namespace App\Http\Controllers\Admin;

   use App\Http\Controllers\Controller;

   class DashboardController extends Controller
   {
       public function index()
       {
           return "Halaman Dashboard Admin (Dikelola oleh Admin\\DashboardController di sub-folder Admin)";
       }
   }
   ```
   Daftarkan di `routes/web.php`:
   ```php
   use App\Http\Controllers\Admin\DashboardController;

   Route::get('/admin/panel', [DashboardController::class, 'index']);
   ```
* 📸 **Screenshot 3.1:** Akses browser `/statistik-invokable` dan `/admin/panel`.

---

### 3.2 Tugas Mandiri Praktikum 3

#### a. Resource Controller `MatakuliahController`
Jalankan perintah ini di terminal:
```bash
php artisan make:controller MatakuliahController --resource --model=Matakuliah --force
```

#### b. Single Action Controller `HitungTotalSksController`
```bash
php artisan make:controller HitungTotalSksController --invokable
```
Buka `app/Http/Controllers/HitungTotalSksController.php`:
```php
<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;

class HitungTotalSksController extends Controller
{
    public function __invoke()
    {
        $totalSks = Matakuliah::sum('sks');
        return "Hasil Hitung: Total beban SKS dari seluruh mata kuliah adalah <strong>{$totalSks} SKS</strong>.";
    }
}
```
Daftarkan di `routes/web.php`:
```php
use App\Http\Controllers\HitungTotalSksController;

Route::get('/total-sks', HitungTotalSksController::class);
```
* **Uji di Browser:** Buka `http://127.0.0.1:8000/total-sks`.
* 📸 **Screenshot 3.2:** Tampilan browser `/total-sks`.

#### c. Controller di dalam Sub-folder `Laporan/`
```bash
php artisan make:controller Laporan/RekapController
```
Buka `app/Http/Controllers/Laporan/RekapController.php`:
```php
<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;

class RekapController extends Controller
{
    public function index()
    {
        return "Laporan Rekapitulasi Data Akademik.";
    }
}
```
* 📸 **Screenshot 3.3:** Struktur file di VS Code Explorer yang memperlihatkan file `app/Http/Controllers/Laporan/RekapController.php`.

#### d. Jawaban Teori Tugas Mandiri 3 (Keuntungan Sub-folder)
> Mengelompokkan controller ke dalam sub-folder (seperti `Admin/`, `Laporan/`, atau `Api/`) membuat arsitektur aplikasi berskala besar menjadi modular, rapi, dan memisahkan hak akses secara terisolasi. Hal ini mencegah terjadinya penumpukan puluhan file controller dalam satu direktori tunggal serta mempermudah kolaborasi banyak pengembang.

---

# 🗄️ BAGIAN II — QUERY BUILDER

---

## 📌 LANGKAH 4: PRAKTIKUM 4 (KONSEP INTERAKSI DATABASE)

### 4.1 Eksperimen 3 Pendekatan di Artisan Tinker
Buka terminal dan masuk ke mode interaktif Tinker:
```bash
php artisan tinker
```
Jalankan 3 perintah ini:
```php
// 1. Raw SQL
DB::select('SELECT * FROM mahasiswas LIMIT 2');

// 2. Query Builder
DB::table('mahasiswas')->limit(2)->get();

// 3. Eloquent ORM
\App\Models\Mahasiswa::limit(2)->get();
```

### 4.2 Melihat Log SQL dengan `DB::enableQueryLog()`
Masih di Tinker:
```php
DB::enableQueryLog();
DB::table('mahasiswas')->where('semester', 3)->get();
DB::getQueryLog();
```
* 📸 **Screenshot 4.1:** Output terminal Tinker yang menampilkan array log SQL asli dan waktu eksekusinya.

---

### 4.3 Tugas Mandiri Praktikum 4

#### a. Filter Prodi Teknik Informatika (3 Pendekatan)
Jalankan di Tinker:
```php
// 1. Raw SQL
DB::select("SELECT * FROM mahasiswas WHERE prodi = 'Teknik Informatika' LIMIT 3");

// 2. Query Builder
DB::table('mahasiswas')->where('prodi', 'Teknik Informatika')->limit(3)->get();

// 3. Eloquent ORM
\App\Models\Mahasiswa::where('prodi', 'Teknik Informatika')->limit(3)->get();
```
* 📸 **Screenshot 4.2:** Output terminal Tinker dari ketiga query di atas.

#### b. Query Log Eloquent dengan `where()` dan `orderBy()`
Jalankan di Tinker:
```php
DB::flushQueryLog();
DB::enableQueryLog();
\App\Models\Mahasiswa::where('prodi', 'Teknik Informatika')->orderBy('nama')->get();
DB::getQueryLog();
```
* 📸 **Screenshot 4.3:** Output `DB::getQueryLog()` pada Tinker.
Ketik `exit` untuk keluar dari Tinker.

#### c. Jawaban Teori Tugas Mandiri 4 (Parameter Binding)
> Query Builder dan Eloquent jauh lebih aman dibandingkan penggabungan string manual karena secara otomatis menerapkan teknik *PDO Parameter Binding (Prepared Statements)*. Nilai masukan pengguna dikirim secara terpisah dari sintaks query dan dinetralkan oleh database engine, sehingga mencegah penyusupan perintah jahat (*SQL Injection*).

---

## 📌 LANGKAH 5: PRAKTIKUM 5 (OPERASI CRUD, AGREGASI & PAGINASI QUERY BUILDER)

### 5.1 Membuat Controller Query Builder Terpadu
Jalankan di terminal:
```bash
php artisan make:controller QueryBuilderDemoController
```
Buka `app/Http/Controllers/QueryBuilderDemoController.php`, ganti seluruh isinya dengan kode berikut:
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderDemoController extends Controller
{
    public function index()
    {
        // Tugas 1: Filter Prodi TI, Semester 3-6, Urut Nama A-Z
        $filterMhs = DB::table('mahasiswas')
            ->where('prodi', 'Teknik Informatika')
            ->whereBetween('semester', ['3', '6'])
            ->orderBy('nama', 'asc')
            ->get();

        // Tugas 2: Agregasi Rekap Jumlah Mahasiswa per Prodi
        $rekapProdi = DB::table('mahasiswas')
            ->select('prodi', DB::raw('count(*) as jumlah'))
            ->groupBy('prodi')
            ->get();

        // Tugas 3: Paginasi 10 Data per Halaman
        $mahasiswaPaging = DB::table('mahasiswas')
            ->orderBy('nama')
            ->paginate(10);

        return view('demo.query-builder-tugas', compact('filterMhs', 'rekapProdi', 'mahasiswaPaging'));
    }
}
```

### 5.2 Membuat View Hasil Query Builder
Buat file `resources/views/demo/query-builder-tugas.blade.php`:
```blade
@extends('layouts.app')
@section('judul', 'Laporan & Agregasi Query Builder')
@section('konten')
<h1>Eksperimen Fitur Query Builder (DB::table)</h1>

<h3>1. Filter: Mahasiswa TI (Semester 3–6) Urut A–Z</h3>
<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <tr bgcolor="#f1f5f9">
        <th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th>
    </tr>
    @forelse($filterMhs as $idx => $m)
    <tr style="background-color: {{ $idx % 2 == 1 ? '#f8fafc' : '#ffffff' }}">
        <td>{{ $idx + 1 }}</td>
        <td>{{ $m->nim }}</td>
        <td>{{ $m->nama }}</td>
        <td>{{ $m->prodi }}</td>
        <td>{{ $m->semester }}</td>
    </tr>
    @empty
    <tr><td colspan="5" align="center">Data tidak ditemukan.</td></tr>
    @endforelse
</table>

<br>
<h3>2. Agregasi: Rekap Jumlah Mahasiswa per Program Studi</h3>
<table border="1" cellpadding="6" cellspacing="0" width="60%">
    <tr bgcolor="#f1f5f9">
        <th>No</th><th>Program Studi</th><th>Jumlah Terdaftar</th>
    </tr>
    @foreach($rekapProdi as $i => $r)
    <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $r->prodi }}</td>
        <td><strong>{{ $r->jumlah }}</strong> Mahasiswa</td>
    </tr>
    @endforeach
</table>

<br>
<h3>3. Paginasi: Daftar Seluruh Mahasiswa (10 Data per Halaman)</h3>
<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <tr bgcolor="#f1f5f9">
        <th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th>
    </tr>
    @foreach($mahasiswaPaging as $mp)
    <tr>
        <td>{{ $mp->nim }}</td>
        <td>{{ $mp->nama }}</td>
        <td>{{ $mp->prodi }}</td>
        <td>{{ $mp->semester }}</td>
    </tr>
    @endforeach
</table>

<div style="margin-top: 15px;">
    {{ $mahasiswaPaging->links() }}
</div>
@endsection
```

### 5.3 Mendaftarkan Rute & Uji Coba
Buka `routes/web.php`, tambahkan rute berikut:
```php
use App\Http\Controllers\QueryBuilderDemoController;

Route::get('/laporan-qb', [QueryBuilderDemoController::class, 'index'])->name('laporan.qb');
```
* **Uji di Browser:** Buka `http://127.0.0.1:8000/laporan-qb`.
* 📸 **Screenshot 5.1:** Tampilan browser halaman `/laporan-qb` yang memuat tabel filter, tabel agregasi jumlah prodi, dan tombol navigasi paginasi.

---

# ⚡ BAGIAN III — ELOQUENT ORM

---

## 📌 LANGKAH 6: PRAKTIKUM 6 (KONSEP ELOQUENT VS QUERY BUILDER)

### 6.1 Uji Tipe Objek di Tinker (`get_class`)
Masuk ke Tinker:
```bash
php artisan tinker
```
Jalankan perintah berikut:
```php
$qb = DB::table('mahasiswas')->where('prodi', 'Sistem Informasi')->first();
$el = \App\Models\Mahasiswa::where('prodi', 'Sistem Informasi')->first();

get_class($qb);
// Hasilnya: "stdClass"

get_class($el);
// Hasilnya: "App\Models\Mahasiswa"
```
* 📸 **Screenshot 6.1:** Output terminal Tinker yang menunjukkan perbedaan tipe objek `stdClass` vs `App\Models\Mahasiswa`.
Ketik `exit` untuk keluar dari Tinker.

### 6.2 Jawaban Teori Tugas Mandiri 6

#### a. Tabel Perbandingan Query Builder vs Eloquent
| Aspek | Query Builder (`DB::table`) | Eloquent ORM (`Model`) |
| :--- | :--- | :--- |
| **Bentuk Hasil** | Objek PHP generik (*stdClass*). | Objek Model representasi tabel (*App\Models\...*). |
| **Relasi Antar Tabel** | Ditulis manual menggunakan *Join* (`->join(...)`). | Didefinisikan sekali di Model (`belongsTo`, `hasMany`) dan diakses layaknya properti biasa. |
| **Kelebihan Fitur** | Ringan dan efisien untuk laporan analitik/agregasi kompleks. | Sangat ekspresif, memiliki fitur *Accessor*, *Mutator*, *Events*, dan *Eager Loading*. |

#### b. Mengapa Eloquent "Dibangun di Atas" Query Builder
> Karena setiap pemanggilan method pada Model Eloquent (seperti `Mahasiswa::where(...)`) secara internal memanggil Query Builder Laravel untuk merangkai string SQL dan mengeksekusinya ke database. Setelah data mentah didapat, Eloquent mengubahnya menjadi objek model yang aktif. Jadi, Eloquent bukanlah pengganti, melainkan lapisan abstraksi tingkat tinggi di atas Query Builder.

---

## 📌 LANGKAH 7: PRAKTIKUM 7 (CRUD ELOQUENT, RELASI & EAGER LOADING)

### 7.1 Membuat Tabel Relasi `nilai_matakuliahs`
1. Jalankan di terminal:
   ```bash
   php artisan make:model NilaiMatakuliah -m
   ```
2. Buka berkas migration yang baru dibuat di `database/migrations/..._create_nilai_matakuliahs_table.php`, lengkapi method `up()`:
   ```php
   public function up(): void
   {
       Schema::create('nilai_matakuliahs', function (Blueprint $table) {
           $table->id();
           $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
           $table->foreignId('matakuliah_id')->constrained('matakuliahs')->cascadeOnDelete();
           $table->string('nilai', 5); // Contoh: A, B+, C
           $table->timestamps();
       });
   }
   ```
3. Jalankan migration ke database:
   ```bash
   php artisan migrate
   ```

### 7.2 Mendefinisikan Relasi Antar-Model
1. Buka `app/Models/NilaiMatakuliah.php`, tambahkan fillable dan relasi:
   ```php
   <?php

   namespace App\Models;

   use Illuminate\Database\Eloquent\Model;

   class NilaiMatakuliah extends Model
   {
       protected $fillable = ['mahasiswa_id', 'matakuliah_id', 'nilai'];

       public function mahasiswa()
       {
           return $this->belongsTo(Mahasiswa::class);
       }

       public function matakuliah()
       {
           return $this->belongsTo(Matakuliah::class);
       }
   }
   ```
2. Buka `app/Models/Mahasiswa.php`, tambahkan method relasi:
   ```php
   public function nilai()
   {
       return $this->hasMany(NilaiMatakuliah::class);
   }
   ```
3. Buka `app/Models/Matakuliah.php`, tambahkan method relasi:
   ```php
   public function nilai()
   {
       return $this->hasMany(NilaiMatakuliah::class);
   }
   ```
4. **Isi Contoh Data Nilai melalui Tinker:**
   Buka `php artisan tinker`:
   ```php
   \App\Models\NilaiMatakuliah::create(['mahasiswa_id' => 1, 'matakuliah_id' => 1, 'nilai' => 'A']);
   \App\Models\NilaiMatakuliah::create(['mahasiswa_id' => 1, 'matakuliah_id' => 2, 'nilai' => 'B+']);
   \App\Models\NilaiMatakuliah::create(['mahasiswa_id' => 2, 'matakuliah_id' => 1, 'nilai' => 'A-']);
   exit
   ```

### 7.3 CRUD Lengkap Mahasiswa & Mata Kuliah (Eloquent)
1. Buka `app/Http/Controllers/MahasiswaController.php`, pastikan method `store`, `update`, `destroy` terisi:
   ```php
   public function store(Request $request)
   {
       Mahasiswa::create($request->only(['nim', 'nama', 'email', 'prodi', 'semester']));
       return redirect()->route('mahasiswa.index')->with('pesan', 'Mahasiswa berhasil ditambahkan.');
   }

   public function update(Request $request, Mahasiswa $mahasiswa)
   {
       $mahasiswa->update($request->only(['nim', 'nama', 'email', 'prodi', 'semester']));
       return redirect()->route('mahasiswa.index')->with('pesan', 'Mahasiswa berhasil diperbarui.');
   }

   public function destroy(Mahasiswa $mahasiswa)
   {
       $mahasiswa->delete();
       return redirect()->route('mahasiswa.index')->with('pesan', 'Mahasiswa berhasil dihapus.');
   }
   ```

2. Buka `app/Http/Controllers/MatakuliahController.php`, lengkapi juga methodnya:
   ```php
   public function store(Request $request)
   {
       Matakuliah::create($request->only(['kode_mk', 'nama_mk', 'sks', 'semester', 'dosen_id']));
       return redirect()->route('matakuliah.index')->with('pesan', 'Mata kuliah berhasil ditambahkan.');
   }

   public function update(Request $request, Matakuliah $matakuliah)
   {
       $matakuliah->update($request->only(['kode_mk', 'nama_mk', 'sks', 'semester', 'dosen_id']));
       return redirect()->route('matakuliah.index')->with('pesan', 'Mata kuliah berhasil diperbarui.');
   }

   public function destroy(Matakuliah $matakuliah)
   {
       $matakuliah->delete();
       return redirect()->route('matakuliah.index')->with('pesan', 'Mata kuliah berhasil dihapus.');
   }
   ```

### 7.4 Menampilkan Relasi Nilai pada Detail Mahasiswa
Buka `resources/views/mahasiswa/show.blade.php`, tambahkan blok nilai di bawah biodata:
```blade
<hr>
<h3>Daftar Nilai Akademik:</h3>
<ul>
    @forelse ($mahasiswa->nilai as $n)
        <li>{{ $n->matakuliah->nama_mk ?? '-' }} ({{ $n->matakuliah->kode_mk ?? '' }}): <strong>{{ $n->nilai }}</strong></li>
    @empty
        <li><em>Belum ada catatan nilai.</em></li>
    @endforelse
</ul>
```
* **Uji di Browser:** Buka `http://127.0.0.1:8000/akademik/mahasiswa/1`.
* 📸 **Screenshot 7.1:** Halaman detail mahasiswa yang menampilkan data relasi nilai akademik.

---

### 7.5 Eksperimen Pembuktian N+1 Problem vs Eager Loading
Buka terminal Tinker:
```bash
php artisan tinker
```
1. **Uji Kasus N+1 Query Problem (Tanpa Eager Loading):**
   ```php
   DB::flushQueryLog();
   DB::enableQueryLog();
   $data = \App\Models\Matakuliah::take(5)->get();
   foreach ($data as $d) {
       $d->dosen?->name;
   }
   count(DB::getQueryLog()); // Menghasilkan 6 query! (1 query matakuliah + 5 query dosen per baris)
   ```
2. **Uji Solusi Eager Loading (`with()`):**
   ```php
   DB::flushQueryLog();
   $data = \App\Models\Matakuliah::with('dosen')->take(5)->get();
   foreach ($data as $d) {
       $d->dosen?->name;
   }
   count(DB::getQueryLog()); // Menghasilkan HANYA 2 query total!
   ```
* 📸 **Screenshot 7.2:** Terminal Tinker yang menampilkan perbedaan jumlah hit query (`count(DB::getQueryLog())`).
Ketik `exit` untuk keluar dari Tinker.

#### Jawaban Teori Tugas Mandiri 7
> Eager Loading dengan method `with()` mengoptimalkan performa aplikasi dengan mencegah masalah *N+1 Query Problem*. Alih-alih mengeksekusi query database berulang-ulang di setiap baris data (N kali), Laravel hanya mengeksekusi 2 query terpadu dengan klausa `WHERE id IN (...)`. Hal ini menghemat penggunaan memori dan mempercepat waktu muat halaman aplikasi secara drastis.

---

# 🏆 PROYEK AKHIR (INTEGRASI MODUL 4)

1. Buka berkas navbar di `resources/views/partials/navbar.blade.php`, tambahkan tautan menu Laporan Query Builder:
   ```blade
   <nav>
       <a href="{{ route('mahasiswa.index') }}">Mahasiswa</a>
       <a href="{{ route('matakuliah.index') }}">Mata Kuliah</a>
       <a href="{{ route('laporan.qb') }}">Laporan & Statistik</a>
   </nav>
   ```
2. Pastikan rute di `routes/web.php` untuk resource mahasiswa dan matakuliah aktif:
   ```php
   Route::prefix('akademik')->group(function () {
       Route::resource('mahasiswa', MahasiswaController::class);
       Route::resource('matakuliah', MatakuliahController::class);
   });
   ```
* 📸 **Screenshot Proyek Akhir:** Tampilan navbar terpadu dan navigasi ke halaman laporan Query Builder.

---

## 📸 CHECKLIST SCREENSHOT UNTUK LAPORAN WORD

Pastikan seluruh 12 screenshot berikut sudah tersimpan dengan rapi sebelum menyusun laporan:

| No | Kode Screenshot | Keterangan Tampilan |
| :-: | :--- | :--- |
| 1 | 📸 **SS 1.1** | Tampilan peramban rute `/sapa-controller` |
| 2 | 📸 **SS 1.2** | Tampilan peramban rute `/latihan` (LatihanController identitas Adinda) |
| 3 | 📸 **SS 2.1** | Teks respon form `/mahasiswa-uji` dan JSON `/api/mahasiswa-json` |
| 4 | 📸 **SS 2.2** | Form pencarian `/form-cari` dan hasil teks pencarian `/cari-mahasiswa` |
| 5 | 📸 **SS 3.1** | Akses peramban `/statistik-invokable` dan `/admin/panel` |
| 6 | 📸 **SS 3.2** | Akses peramban `/total-sks` (HitungTotalSksController) |
| 7 | 📸 **SS 3.3** | Struktur file `Laporan/RekapController.php` di VS Code Explorer |
| 8 | 📸 **SS 4.1 & 4.2** | Hasil eksekusi 3 cara query filter TI di terminal Tinker |
| 9 | 📸 **SS 4.3** | Output `DB::getQueryLog()` di Tinker |
| 10 | 📸 **SS 5.1** | Tampilan halaman `/laporan-qb` (Filter TI, Rekap Prodi, Paginasi) |
| 11 | 📸 **SS 6.1** | Output Tinker `get_class()` (`stdClass` vs Model) |
| 12 | 📸 **SS 7.1** | Halaman detail mahasiswa dengan relasi nilai akademik |
| 13 | 📸 **SS 7.2** | Bukti perbedaan jumlah hit query Eager Loading di Tinker |
| 14 | 📸 **SS Akhir** | Tampilan navbar terpadu mini aplikasi Sistem Informasi Akademik |
