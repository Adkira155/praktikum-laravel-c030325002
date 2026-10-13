<?php

use Illuminate\Support\Facades\Route;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;
use App\Models\User;
use Illuminate\Http\Request;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/tes', function () { return 'tes'; });

Route::get('/mahasiswa', function () {
    $data = Mahasiswa::all();
    return view('mahasiswa.index', compact('data'));
});

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