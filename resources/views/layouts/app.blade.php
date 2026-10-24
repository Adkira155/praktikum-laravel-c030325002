<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul', 'Aplikasi Akademik') — Praktikum Laravel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: sans-serif; margin: 0; }
        nav { background: #191b29; padding: 12px 24px; }
        nav a { color: #fff; margin-right: 16px; text-decoration: none; }
        main { padding: 24px; }
        footer { text-align: center; padding: 16px; color: #666; }
        nav svg { width: 20px; height: 20px; }
        nav[role="navigation"] a, nav[role="navigation"] span { padding: 4px 8px; }
    .pagination-wrap {
        margin-top: 15px;
        padding: 10px;
        background: #ffffff;
    }
    .pagination-wrap .page-link {
        color: #0d6efd;
        background-color: #ffffff;
        border: 1px solid #dee2e6;
    }
    .pagination-wrap .page-item.active .page-link {
        color: #ffffff;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .pagination-wrap .page-item.disabled .page-link {
        color: #6c757d;
    }
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