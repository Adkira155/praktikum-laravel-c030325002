{{-- Ini komentar Blade, tidak akan tampil di browser --}}
<h1>Halo, {{ $nama }}!</h1>

@php
    $tahunSekarang = date('Y');
@endphp

<p>Tahun sekarang: {{ $tahunSekarang }}</p>
<p>Waktu: {{ now()->format('d M Y H:i') }}</p>
<p>Hitung: {{ 5 * 3 }}</p>
<p>Julukan: {{ $julukan ?? 'Belum ada julukan' }}</p>
<p>Contoh sintaks yang dibiarkan apa adanya: @{{ nama }}</p>

<p>Escaped: {{ $kontenHtml }}</p>
<p>Tidak di-escape: {!! $kontenHtml !!}</p>
