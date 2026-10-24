<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QueryBuilderDemoController extends Controller
{
    public function index()
    {
        // 1. Filter Prodi TI, Semester 3-6, Urut Nama A-Z
        $filterMhs = DB::table('mahasiswas')
            ->where('prodi', 'Teknik Informatika')
            ->whereBetween('semester', ['3', '6'])
            ->orderBy('nama', 'asc')
            ->get();

        // 2. Agregasi Jumlah Mahasiswa per Prodi
        $rekapProdi = DB::table('mahasiswas')
            ->select('prodi', DB::raw('count(*) as jumlah'))
            ->groupBy('prodi')
            ->get();

        // 3. Paginasi 10 Data per Halaman
        $mahasiswaPaging = DB::table('mahasiswas')
            ->orderBy('nama')
            ->paginate(10);

        return view('demo.query-builder-tugas', compact('filterMhs', 'rekapProdi', 'mahasiswaPaging'));
    }
}
