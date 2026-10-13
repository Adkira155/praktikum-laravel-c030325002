<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MatakuliahController extends Controller
{
    public function index()
    {
        $matakuliah = Matakuliah::with('dosen')->orderBy('kode_mk')->get();
        return view('matakuliah.index', compact('matakuliah'));
    }

    public function create()
    {
        return 'Form tambah mata kuliah';
    }

    public function store(Request $request)
    {
        return 'Simpan mata kuliah';
    }

    public function show(Matakuliah $matakuliah)
    {
        return view('matakuliah.show', compact('matakuliah'));
    }
}