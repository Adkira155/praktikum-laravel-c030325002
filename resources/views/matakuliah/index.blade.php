@extends('layouts.app')
@section('judul', 'Daftar Mata Kuliah')
@section('konten')

<h1>Daftar Mata Kuliah</h1>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Nama</th>
            <th>SKS</th>
            <th>Semester</th>
            <th>Dosen</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($matakuliah as $mk)
        <tr style="background-color: {{ $loop->even ? '#f2f2f2' : '#ffffff' }}">
            <td>{{ $loop->iteration }}</td>
            <td>{{ $mk->kode_mk }}</td>
            <td>{{ $mk->nama_mk }}</td>
            <td>
                {{ $mk->sks }}
                @if ($mk->sks > 3)
                    <b>SKS Besar</b>
                @endif
            </td>
            <td>{{ $mk->semester }}</td>
            <td>{{ $mk->dosen->name ?? '-' }}</td>
            <td><a href="{{ route('matakuliah.show', $mk->id) }}">Detail</a></td>
        </tr>
        @empty
        <tr>
            <td colspan="7" align="center">Belum ada data mata kuliah.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection