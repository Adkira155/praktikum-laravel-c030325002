@extends('layouts.app')
@section('judul', 'Pencarian Mahasiswa')
@section('konten')
<h2>Pencarian Mahasiswa</h2>
<form action="/cari-mahasiswa" method="GET">
    <input type="text" name="nama" placeholder="Ketik nama mahasiswa..." required>
    <button type="submit">Cari Data</button>
</form>
@endsection