<h1>Demo Blade</h1>

@foreach ($mahasiswa as $m)
    <p>{{ $m->nim }} - {{ $m->nama }} - {{ $m->email ?? '-' }}</p>
@endforeach
