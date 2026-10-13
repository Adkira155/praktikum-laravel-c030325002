<h1>Demo Blade</h1>

@foreach ($mahasiswa as $m)
    <p>{{ $m->nim }} - {{ $m->nama }} - {{ $m->email ?? '-' }}</p>
@endforeach

<h3>Uji XSS</h3>
@php
    $xss = \App\Models\Mahasiswa::where('nim', '9999999999')->first();
@endphp
@if ($xss)
    <p>Pakai kurung kurawal ganda (aman): {{ $xss->nama }}</p>
    <p>Pakai kurung kurawal tanda seru (raw): {!! $xss->nama !!}</p>
@endif
