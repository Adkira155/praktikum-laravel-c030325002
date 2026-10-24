@extends('layouts.app')
@section('judul', 'Laporan & Agregasi Query Builder')
@section('konten')
<h1>Eksperimen Fitur Query Builder (DB::table)</h1>

<h3>1. Filter: Mahasiswa TI (Semester 3-6) Urut A-Z</h3>
<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <tr bgcolor="#f1f5f9">
        <th>No</th><th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th>
    </tr>
    @forelse($filterMhs as $idx => $m)
    <tr style="background-color: {{ $idx % 2 == 1 ? '#f8fafc' : '#ffffff' }}">
        <td>{{ $idx + 1 }}</td>
        <td>{{ $m->nim }}</td>
        <td>{{ $m->nama }}</td>
        <td>{{ $m->prodi }}</td>
        <td>{{ $m->semester }}</td>
    </tr>
    @empty
    <tr><td colspan="5" align="center">Data tidak ditemukan.</td></tr>
    @endforelse
</table>

<br>
<h3>2. Agregasi: Rekap Jumlah Mahasiswa per Program Studi</h3>
<table border="1" cellpadding="6" cellspacing="0" width="60%">
    <tr bgcolor="#f1f5f9">
        <th>No</th><th>Program Studi</th><th>Jumlah Terdaftar</th>
    </tr>
    @foreach($rekapProdi as $i => $r)
    <tr>
        <td>{{ $i + 1 }}</td>
        <td>{{ $r->prodi }}</td>
        <td><strong>{{ $r->jumlah }}</strong> Mahasiswa</td>
    </tr>
    @endforeach
</table>

<br>
<h3>3. Paginasi: Daftar Seluruh Mahasiswa (10 Data per Halaman)</h3>
<table border="1" cellpadding="6" cellspacing="0" width="100%">
    <tr bgcolor="#f1f5f9">
        <th>NIM</th><th>Nama</th><th>Prodi</th><th>Semester</th>
    </tr>
    @foreach($mahasiswaPaging as $mp)
    <tr>
        <td>{{ $mp->nim }}</td>
        <td>{{ $mp->nama }}</td>
        <td>{{ $mp->prodi }}</td>
        <td>{{ $mp->semester }}</td>
    </tr>
    @endforeach
</table>

{{-- <div style="margin-top: 15px;">
    {{ $mahasiswaPaging->links() }}
</div> --}}
<div class="pagination-wrap"  style="margin-top: 15px;">
    {{ $mahasiswaPaging->links() }}
</div>
@endsection
