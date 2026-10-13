@extends('layouts.app')
@section('judul', 'Detail ' . $matakuliah->nama_mk)
@section('konten')

<h1>Detail Mata Kuliah</h1>

<p><strong>Kode:</strong> {{ $matakuliah->kode_mk }}</p>
<p><strong>Nama:</strong> {{ $matakuliah->nama_mk }}</p>
<p><strong>SKS:</strong> {{ $matakuliah->sks }}</p>
<p><strong>Semester:</strong> {{ $matakuliah->semester }}</p>
<p><strong>Dosen Pengampu:</strong> {{ $matakuliah->dosen->name ?? '-' }}</p>

<a href="{{ route('matakuliah.index') }}">&laquo; Kembali ke Daftar</a>

  @endsection