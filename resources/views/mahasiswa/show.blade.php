@extends('layouts.app')
@section('judul', 'Detail ' . $mahasiswa->nama)
@section('konten')

<h1>Detail Mahasiswa</h1>

<p><strong>NIM:</strong> {{ $mahasiswa->nim }}</p>
<p><strong>Nama:</strong> {{ $mahasiswa->nama }}</p>
<p><strong>Email:</strong> {{ $mahasiswa->email ?? '-' }}</p>
<p><strong>Program Studi:</strong> {{ $mahasiswa->prodi }}</p>
<p><strong>Semester:</strong> {{ $mahasiswa->semester }}</p>

<a href="{{ route('mahasiswa.index') }}">&laquo; Kembali ke Daftar</a>

<hr>
<h3>Daftar Nilai Akademik:</h3>
<ul>
    @forelse ($mahasiswa->nilai as $n)
        <li>{{ $n->matakuliah->nama_mk ?? '-' }} ({{ $n->matakuliah->kode_mk ?? '' }}): <strong>{{ $n->nilai }}</strong></li>
    @empty
        <li><em>Belum ada catatan nilai.</em></li>
    @endforelse
</ul>


  @endsection