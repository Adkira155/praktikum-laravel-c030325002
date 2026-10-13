<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Mata Kuliah</title>
    <style>
        :root {
            --bg: #f5f7fa;
            --surface: #ffffff;
            --ink: #1c2633;
            --muted: #5f6b7a;
            --line: #e3e8ef;
            --accent: #1f4e79;
            --accent-dark: #173c5d;
            --row-hover: #eef4fa;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 2rem 1rem;
            background: var(--bg);
            color: var(--ink);
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            line-height: 1.5;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.25rem;
        }

        h1 {
            margin: 0 0 0.25rem;
            font-size: 1.6rem;
            font-weight: 650;
        }

        .subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 0.95rem;
        }

        .btn {
            display: inline-block;
            padding: 0.55rem 1.1rem;
            background: var(--accent);
            color: #fff;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn:hover { background: var(--accent-dark); }

        .table-wrap {
            overflow-x: auto;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(28, 38, 51, 0.06);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 640px;
        }

        thead th {
            padding: 0.85rem 1rem;
            background: var(--accent);
            color: #fff;
            font-size: 0.9rem;
            font-weight: 600;
            text-align: left;
            white-space: nowrap;
        }

        tbody td {
            padding: 0.8rem 1rem;
            border-bottom: 1px solid var(--line);
        }

        tbody tr:last-child td { border-bottom: none; }
        tbody tr:nth-child(even) { background: #fafbfd; }
        tbody tr:hover { background: var(--row-hover); }

        .kode {
            font-variant-numeric: tabular-nums;
            color: var(--muted);
            white-space: nowrap;
        }

        .center { text-align: center; }

        .empty-dosen { color: var(--muted); }

        .empty {
            padding: 2rem 1rem;
            text-align: center;
            color: var(--muted);
        }

        :focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>Daftar Mata Kuliah</h1>
                <p class="subtitle">Total {{ count($data) }} mata kuliah</p>
            </div>
            <a href="/matakuliah/tambah" class="btn">+ Tambah</a>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th class="center">SKS</th>
                        <th class="center">Semester</th>
                        <th>Dosen Pengampu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $mk)
                        <tr>
                            <td class="kode">{{ $mk->kode_mk }}</td>
                            <td>{{ $mk->nama_mk }}</td>
                            <td class="center">{{ $mk->sks }}</td>
                            <td class="center">{{ $mk->semester }}</td>
                            @if ($mk->dosen)
                                <td>{{ $mk->dosen->name }}</td>
                            @else
                                <td class="empty-dosen">-</td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="empty">Belum ada mata kuliah. Klik "+ Tambah" untuk menambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>