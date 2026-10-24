<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SapaController;
use App\Http\Controllers\LatihanController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\HitungTotalSksController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\StatistikMahasiswaController;
use App\Http\Controllers\QueryBuilderDemoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. Rute Dasar & Halaman Statis ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/halo', function () {
    return 'Halo, ini adalah route pertama saya!';
});

Route::get('/tentang', function () {
    return 'Halaman Tentang';
});

Route::get('/tentang-kami', function () {
    return 'Halaman Tentang Kami';
});

Route::get('/kontak', function () {
    return 'Halaman Kontak';
});

Route::get('/profil', function () {
    return view('profil')
        ->with('nama', 'Adinda Ridha Salsabila')
        ->with('nim', 'C030325002')
        ->with('prodi', 'Teknik Informatika');
});


// --- 2. Rute Latihan, View & Controller Sederhana ---
Route::get('/latihan', [LatihanController::class, 'index']);
Route::get('/sapa-controller', [SapaController::class, 'index']);

Route::get('/sapa-view', function () {
    return view('sapa', [
        'nama' => 'Ahmad Fauzi',
        'kontenHtml' => '<strong>Teks Tebal</strong>',
    ]);
});

Route::get('/blade-demo', function () {
    $mahasiswa = \App\Models\Mahasiswa::take(5)->get();
    return view('blade-demo', compact('mahasiswa'));
});
Route::get('/laporan-qb', [QueryBuilderDemoController::class, 'index'])->name('laporan.qb');



// --- 3. Rute Fitur Mahasiswa & Uji Coba ---
Route::get('/form-cari', function () {
    return view('mahasiswa.cari');
});
Route::get('/cari-mahasiswa', [MahasiswaController::class, 'cariMahasiswa']);

Route::get('/mahasiswa-uji', function () {
    return view('mahasiswa.form-uji');
});
Route::post('/mahasiswa-uji', [MahasiswaController::class, 'store']);


// --- 4. Rute Invokable Controller ---
Route::get('/total-sks', HitungTotalSksController::class);
Route::get('/statistik-invokable', StatistikMahasiswaController::class);


// --- 5. Rute API Sandbox / JSON ---
Route::get('/api/mahasiswa-json', [MahasiswaController::class, 'apiIndex']);


// --- 6. Grup Rute: Akademik ---
Route::prefix('akademik')->group(function () {
    Route::get('/statistik-uji', function () {
        return view('akademik.statistik');
    });
    
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('matakuliah', MatakuliahController::class)
        ->only(['index', 'show', 'create', 'store']);
});


// --- 7. Grup Rute: Admin ---
Route::get('/admin/panel', [DashboardController::class, 'index']); // Rute panel lama

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return 'Dashboard Admin';
    })->name('dashboard');

    Route::get('/pengguna', function () {
        return 'Kelola Pengguna';
    })->name('pengguna');
});


// --- 8. Rute Fallback (Paling Bawah) ---
Route::fallback(function () {
    return response('Halaman yang Anda cari tidak ditemukan.', 404);
});
