<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'Aplikasi Akademik') — Praktikum Laravel</title>
    <style>
        body { font-family: sans-serif; margin: 0; }
        nav { background: #1e293b; padding: 12px 24px; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        main { padding: 24px; }
        footer { text-align: center; padding: 16px; color: #666; }
    </style>
</head>
<body>
  @include('partials.navbar')

    <main>
        @yield('konten')
    </main>

    <footer>&copy; {{ date('Y') }} Praktikum Pemrograman Web</footer>
</body>
</html>