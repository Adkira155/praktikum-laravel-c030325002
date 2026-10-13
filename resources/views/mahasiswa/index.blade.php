<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Mahasiswa</title>
    <style>
        :root {
            --bg: #f5f7fa;
            --surface: #ffffff;
            --ink: #1c2633;
            --muted: #5f6b7a;
            --line: #e3e8ef;
            --accent: #1f4e79;
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

        h1 {
            margin: 0 0 0.25rem;
            font-size: 1.6rem;
            font-weight: 650;
        }

        .subtitle {
            margin: 0 0 1.25rem;
            color: var(--muted);
            font-size: 0.95rem;
        }

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
            min-width: 560px;
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

        .nim {
            font-variant-numeric: tabular-nums;
            color: var(--muted);
        }

        .center { text-align: center; }

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
        <h1>Daftar Mahasiswa</h1>
        <p class="subtitle">Total {{ count($data) }} mahasiswa</p>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th class="center">Semester</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $mhs)
                        <tr>
                            <td class="nim">{{ $mhs->nim }}</td>
                            <td>{{ $mhs->nama }}</td>
                            <td>{{ $mhs->prodi }}</td>
                            <td class="center">{{ $mhs->semester }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty">Belum ada data mahasiswa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>