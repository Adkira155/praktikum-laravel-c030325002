<?php

use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/halo', function () {
    return 'Halo, ini adalah route pertama saya!';
});

Route::get('/tentang-kami', function () {
    return 'Halaman Tentang Kami';
});

Route::get('/profil', function () {
    return view('profil')
        ->with('nama', 'Adinda Ridha Salsabila')
        ->with('nim', 'C030325002')
        ->with('prodi', 'Teknik Informatika');
});

Route::get('/kontak', function () {
    return 'Halaman Kontak';
});

Route::get('/tentang', function () {
    return 'Halaman Tentang';
});

Route::get('/sapa/{nama?}', function ($nama = 'Tamu') {
    return "Halo, $nama!";
});

Route::get('/sapa-view', function () {
    return view('sapa', [
        'nama' => 'Ahmad Fauzi',
        'kontenHtml' => '<strong>Teks Tebal</strong>',
    ]);
});

Route::get('/statistik-uji', function () {
    return view('akademik.statistik');
});

Route::get('/blade-demo', function () {
    $mahasiswa = \App\Models\Mahasiswa::take(5)->get();
    return view('blade-demo', compact('mahasiswa'));
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return 'Dashboard Admin';
    })->name('dashboard');

    Route::get('/pengguna', function () {
        return 'Kelola Pengguna';
    })->name('pengguna');
});

Route::prefix('akademik')->group(function () {
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('matakuliah', MatakuliahController::class)
        ->only(['index', 'show', 'create', 'store']);
});

Route::fallback(function () {
    return response('Halaman yang Anda cari tidak ditemukan.', 404);
});