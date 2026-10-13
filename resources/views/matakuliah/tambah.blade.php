<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Mata Kuliah</title>
    <style>
        :root {
            --bg: #f5f7fa;
            --surface: #ffffff;
            --ink: #1c2633;
            --muted: #5f6b7a;
            --line: #e3e8ef;
            --accent: #1f4e79;
            --accent-dark: #173c5d;
            --danger: #b3261e;
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
            max-width: 560px;
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

        .card {
            padding: 1.5rem;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 10px;
            box-shadow: 0 1px 3px rgba(28, 38, 51, 0.06);
        }

        .field { margin-bottom: 1.1rem; }

        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        label {
            display: block;
            margin-bottom: 0.3rem;
            font-size: 0.9rem;
            font-weight: 600;
        }

        input,
        select {
            width: 100%;
            padding: 0.6rem 0.75rem;
            background: #fff;
            border: 1px solid #c9d2dd;
            border-radius: 8px;
            color: var(--ink);
            font: inherit;
        }

        input:focus,
        select:focus {
            outline: 2px solid var(--accent);
            outline-offset: 1px;
            border-color: var(--accent);
        }

        .invalid { border-color: var(--danger); }

        .error {
            margin: 0.3rem 0 0;
            color: var(--danger);
            font-size: 0.85rem;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn {
            padding: 0.6rem 1.3rem;
            background: var(--accent);
            border: none;
            border-radius: 8px;
            color: #fff;
            font: inherit;
            font-weight: 600;
            cursor: pointer;
        }

        .btn:hover { background: var(--accent-dark); }

        .cancel {
            color: var(--muted);
            text-decoration: none;
        }

        .cancel:hover { color: var(--ink); text-decoration: underline; }

        @media (max-width: 480px) {
            .row { grid-template-columns: 1fr; gap: 0; }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Mata Kuliah</h1>
        <p class="subtitle">Isi data mata kuliah baru, lalu simpan.</p>

        <form action="/matakuliah" method="POST" class="card">
            @csrf

            <div class="field">
                <label for="kode_mk">Kode MK</label>
                <input type="text" id="kode_mk" name="kode_mk" value="{{ old('kode_mk') }}"
                       class="@error('kode_mk') invalid @enderror" placeholder="Contoh: IF101">
                @error('kode_mk') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="field">
                <label for="nama_mk">Nama MK</label>
                <input type="text" id="nama_mk" name="nama_mk" value="{{ old('nama_mk') }}"
                       class="@error('nama_mk') invalid @enderror" placeholder="Contoh: Pemrograman Web">
                @error('nama_mk') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="row">
                <div class="field">
                    <label for="sks">SKS</label>
                    <input type="number" id="sks" name="sks" min="1" value="{{ old('sks') }}"
                           class="@error('sks') invalid @enderror">
                    @error('sks') <p class="error">{{ $message }}</p> @enderror
                </div>

                <div class="field">
                    <label for="semester">Semester</label>
                    <input type="number" id="semester" name="semester" min="1" value="{{ old('semester') }}"
                           class="@error('semester') invalid @enderror">
                    @error('semester') <p class="error">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="field">
                <label for="dosen_id">Dosen Pengampu</label>
                <select id="dosen_id" name="dosen_id" class="@error('dosen_id') invalid @enderror">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id }}" @selected(old('dosen_id') == $d->id)>{{ $d->name }}</option>
                    @endforeach
                </select>
                @error('dosen_id') <p class="error">{{ $message }}</p> @enderror
            </div>

            <div class="actions">
                <button type="submit" class="btn">Simpan</button>
                <a href="/matakuliah" class="cancel">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>