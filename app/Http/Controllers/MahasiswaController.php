<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::orderBy('nama')->get();
        return view('mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        return 'create: form tambah mahasiswa';
    }

    // public function store(Request $request)
    // {
    //     return 'store: simpan data baru';
    // }

    public function store(Request $request)
    {
        $nama = $request->input('nama');
        $nim  = $request->input('nim');
        return "Data yang diterima -> NIM: {$nim}, Nama: {$nama}";
    }

    public function cariMahasiswa(Request $request)
    {
        $keyword = $request->query('nama');
        if (!$keyword) {
            return "Silakan masukkan kata kunci nama pada form pencarian.";
        }
        return "Konfirmasi: Anda sedang mencari data mahasiswa dengan kata kunci: <strong>{$keyword}</strong>";
    }


    public function show(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.show', compact('mahasiswa'));
    }

    public function edit($id)
    {
        return 'edit: form ubah mahasiswa id ' . $id;
    }

    public function update(Request $request, $id)
    {
        return 'update: perbarui data id ' . $id;
    }

    public function destroy($id)
    {
        return 'destroy: hapus data id ' . $id;
    }

    public function apiIndex()
    {
        return response()->json([
            'status' => 'sukses',
            'pesan' => 'Ini contoh response JSON dari Controller',
            'penulis' => 'Adinda Ridha Salsabila',
        ]);
    }
}