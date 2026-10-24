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