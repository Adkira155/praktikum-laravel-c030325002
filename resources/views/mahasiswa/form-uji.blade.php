@extends('layouts.app')
@section('judul', 'Uji Form Input')
@section('konten')
<h2>Form Uji Request Controller</h2>
<form action="/mahasiswa-uji" method="POST">
    @csrf
    <p><input type="text" name="nim" placeholder="NIM"></p>
    <p><input type="text" name="nama" placeholder="Nama Mahasiswa"></p>
    <button type="submit">Kirim Data</button>
</form>
@endsection