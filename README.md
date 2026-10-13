# Sistem Informasi Akademik

Proyek akhir Praktikum Routing, View, dan Blade Templating Engine pada Laravel 13.

## Identitas

|                    |                             |
| ------------------ | --------------------------- |
| **Nama**           | Adinda Ridha Salsabila      |
| **NIM**            | C030325002                  |
| **Mata Kuliah**    | Desain Web                  |
| **Kelas**          | 3C                          |
| **Dosen Pengajar** | Arifin Noor Asyikin, ST, MT |

## Deskripsi Singkat

Mini aplikasi Sistem Informasi Akademik dengan dua modul data, yaitu **Mahasiswa** dan **Mata Kuliah**. Setiap modul memiliki halaman daftar (index) dan detail (show) yang terhubung melalui named route, serta memakai satu master layout Blade (`layouts/app.blade.php`).

## Daftar Route

Hasil dari `php artisan route:list`:

|  No | Method    | URI                                   | Nama Route             | Action                                       |
| --: | --------- | ------------------------------------- | ---------------------- | -------------------------------------------- |
|   1 | GET/HEAD  | `/`                                   | -                      | Closure (`routes/web.php:7`)                 |
|   2 | GET/HEAD  | `admin/dashboard`                     | `admin.dashboard`      | Closure (`routes/web.php:55`)                |
|   3 | GET/HEAD  | `admin/pengguna`                      | `admin.pengguna`       | Closure (`routes/web.php:59`)                |
|   4 | GET/HEAD  | `akademik/mahasiswa`                  | `mahasiswa.index`      | `MahasiswaController@index`                  |
|   5 | POST      | `akademik/mahasiswa`                  | `mahasiswa.store`      | `MahasiswaController@store`                  |
|   6 | GET/HEAD  | `akademik/mahasiswa/create`           | `mahasiswa.create`     | `MahasiswaController@create`                 |
|   7 | GET/HEAD  | `akademik/mahasiswa/{mahasiswa}`      | `mahasiswa.show`       | `MahasiswaController@show`                   |
|   8 | PUT/PATCH | `akademik/mahasiswa/{mahasiswa}`      | `mahasiswa.update`     | `MahasiswaController@update`                 |
|   9 | DELETE    | `akademik/mahasiswa/{mahasiswa}`      | `mahasiswa.destroy`    | `MahasiswaController@destroy`                |
|  10 | GET/HEAD  | `akademik/mahasiswa/{mahasiswa}/edit` | `mahasiswa.edit`       | `MahasiswaController@edit`                   |
|  11 | GET/HEAD  | `akademik/matakuliah`                 | `matakuliah.index`     | `MatakuliahController@index`                 |
|  12 | POST      | `akademik/matakuliah`                 | `matakuliah.store`     | `MatakuliahController@store`                 |
|  13 | GET/HEAD  | `akademik/matakuliah/create`          | `matakuliah.create`    | `MatakuliahController@create`                |
|  14 | GET/HEAD  | `akademik/matakuliah/{matakuliah}`    | `matakuliah.show`      | `MatakuliahController@show`                  |
|  15 | GET/HEAD  | `blade-demo`                          | -                      | Closure (`routes/web.php:49`)                |
|  16 | GET/HEAD  | `halo`                                | -                      | Closure (`routes/web.php:11`)                |
|  17 | GET/HEAD  | `kontak`                              | -                      | Closure (`routes/web.php:26`)                |
|  18 | GET/HEAD  | `profil`                              | -                      | Closure (`routes/web.php:19`)                |
|  19 | GET/HEAD  | `sapa-view`                           | -                      | Closure (`routes/web.php:38`)                |
|  20 | GET/HEAD  | `sapa/{nama?}`                        | -                      | Closure (`routes/web.php:34`)                |
|  21 | GET/HEAD  | `statistik-uji`                       | -                      | Closure (`routes/web.php:45`)                |
|  22 | GET/HEAD  | `storage/{path}`                      | `storage.local`        | Bawaan Laravel (`FilesystemServiceProvider`) |
|  23 | PUT       | `storage/{path}`                      | `storage.local.upload` | Bawaan Laravel (`FilesystemServiceProvider`) |
|  24 | GET/HEAD  | `tentang`                             | -                      | Closure (`routes/web.php:30`)                |
|  25 | GET/HEAD  | `tentang-kami`                        | -                      | Closure (`routes/web.php:15`)                |
|  26 | GET/HEAD  | `up`                                  | -                      | Bawaan Laravel (`ApplicationBuilder`)        |
|  27 | GET/HEAD  | `{fallbackPlaceholder}`               | -                      | Closure fallback (`routes/web.php:70`)       |

Keterangan: route `akademik/mahasiswa/*` dibuat dengan `Route::resource` (7 route), sedangkan `akademik/matakuliah/*` memakai `Route::resource(...)->only(['index', 'show', 'create', 'store'])` (4 route). Route `storage/{path}` dan `up` adalah bawaan Laravel.

## Cara Menjalankan

```bash
composer install
cp .env.example .env
php artisan key:generate
# atur koneksi database di file .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)
php artisan migrate:fresh --seed
php artisan serve
```

Buka http://127.0.0.1:8000/akademik/mahasiswa

## Daftar Route (hasil `php artisan route:list`)

````text
EOF
COLUMNS=200 php artisan route:list --except-vendor --no-ansi >> README.md
echo '```' >> README.md
````

Cek hasilnya:

```bash
cat README.md
```

Pastikan daftar route muncul rapi di dalam blok `text`. Kalau hasilnya terpotong atau berantakan, jalankan ulang perintah di atas, atau salin manual keluaran `php artisan route:list` ke bagian "Daftar Route".

> Pakai **Git Bash** untuk perintah ini. Di PowerShell versi lama, tanda `>` menghasilkan file berkode UTF-16 yang tampil rusak di GitHub.

---

# Push ke GitHub

**1. Pastikan remote benar** (ingat typo sebelumnya):

```bash
git remote -v
```

URL harus sesuai repo-mu, misalnya `https://github.com/Adkira155/praktikum-laravel-c030325002.git`. Kalau salah:

```bash
git remote set-url origin https://github.com/USERNAME-ANDA/NAMA-REPO.git
```

**2. Pastikan `.env` dan `vendor/` tidak ikut:**

```bash
git status
```

`.env`, `vendor/`, dan `node_modules/` **tidak boleh** muncul di daftar. Kalau muncul, periksa `.gitignore` (Modul 2 Praktikum 3).

**3. Commit dan push:**

```bash
git add .
git commit -m "Modul 3: routing, view, blade"
git push -u origin main
```

Saat diminta login: username GitHub dan **Personal Access Token** (bukan password akun). Kalau push sebelumnya sudah berhasil dengan `-u`, cukup `git push`.

**4. Verifikasi:** buka repo di GitHub, lalu cek `README.md` tampil dengan daftar route, folder `resources/views/` berisi `layouts/`, `partials/`, `mahasiswa/`, `matakuliah/`, dan tab **Commits** menampilkan commit "Modul 3". 📸 Screenshot halaman repo dan tab Commits.

**Opsional: commit per praktikum** (riwayat lebih rapi). Setelah selesai tiap praktikum:

```bash
git add .
git commit -m "Modul 3 P1: routing dasar"
```

**Opsional: buat `.zip`** sesuai format pengumpulan. Perintah ini hanya mengemas file yang ter-commit (otomatis tanpa `vendor/`, `node_modules/`, dan `.env`), dan menyimpannya di folder induk:

```bash
git archive --format=zip --output=../praktikum-laravel-modul3.zip HEAD
```

---

# Checklist Pengumpulan

- [✔] Folder proyek (`.zip` tanpa `vendor/` dan `node_modules/`) dan/atau link repo GitHub
- [✔] `README.md` berisi nama, NIM, daftar route, dan cara menjalankan
- [✔] 📸 P1: `/profil`, `/kontak`, `/tentang`, `route:list`
- [✔] 📸 P2: `route:list` dengan nama route, `/akademik/mahasiswa`, `/akademik/matakuliah`
- [✔] 📸 P3: `route:list --name=matakuliah` (4 route), `/akademik/matakuliah/1`
- [✔] 📸 P4: `/profil`, `/statistik-uji`
- [✔] 📸 P5: `/blade-demo`, perbandingan `{{ }}` vs `{!! !!}`
- [✔] 📸 P6: daftar dan detail Mahasiswa serta Mata Kuliah
- [✔] 📸 P7: tampilan data dan tampilan kosong
- [✔] 📸 P8: judul tab berbeda per halaman, file `partials/navbar.blade.php`
- [✔] 📸 Repo GitHub dan tab Commits
- [✔] Jawaban tertulis: alur request (P1), nested view dan Controller vs View (P4), `{{ }}` vs `{!! !!}` (P5), `$loop` (P7), manfaat layout (P8), perbandingan route (P3)

---

# Troubleshooting Cepat

| Error                                     | Penyebab & solusi                                                                                                              |
| ----------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------ |
| `Route [matakuliah.index] not defined`    | Layout/view dipakai sebelum route resource matakuliah dibuat (P3 Tugas Mandiri). Cek `route:list`.                             |
| `View [mahasiswa.index] not found`        | Nama file/folder view salah. Harus `resources/views/mahasiswa/index.blade.php`.                                                |
| `Undefined variable $mahasiswa`           | Controller belum mengirim `compact('mahasiswa')`, atau view dibuka lewat route lain.                                           |
| `Class "App\Models\Matakuliah" not found` | Model dari Modul 1 belum ada. Buat dengan `php artisan make:model Matakuliah`, lalu lengkapi `$fillable` dan relasi `dosen()`. |
| `Attempt to read property "name" on null` | Data tanpa dosen. Pakai `{{ $mk->dosen->name ?? '-' }}`.                                                                       |
| Halaman 404 pada `/mahasiswa`             | URL sekarang `/akademik/mahasiswa` (ada prefix `akademik`).                                                                    |
| Perubahan route tidak terbaca             | Jalankan `php artisan route:clear` lalu `php artisan view:clear`.                                                              |
| `Repository not found` saat push          | URL remote salah atau repo belum dibuat. Perbaiki dengan `git remote set-url origin ...`.                                      |
