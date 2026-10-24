<?php

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