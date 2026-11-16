<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CampusCare - Database Laravel')</title>
    <style>
        body { font-family: system-ui, sans-serif; margin: 0; background: #f4f6f9; color: #222; }
        nav { background: #1d4ed8; padding: 14px 32px; display: flex; gap: 20px; align-items: center; flex-wrap: wrap; }
        nav strong { color: #fff; font-size: 18px; margin-right: 12px; }
        nav a { color: #dbeafe; text-decoration: none; font-size: 14px; font-weight: 500; }
        nav a:hover, nav a.active { color: #fff; text-decoration: underline; }
        main { max-width: 1120px; margin: 32px auto; padding: 0 16px; }
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .alert { background: #d1fae5; color: #065f46; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; font-weight: 500; }
        table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        th, td { padding: 10px 14px; text-align: left; border-bottom: 1px solid #e5e7eb; font-size: 14px; }
        th { background: #eff6ff; font-weight: 600; }
        .badge { padding: 3px 10px; border-radius: 999px; font-size: 12px; font-weight: 600; background: #e5e7eb; display: inline-block; }
        .badge.Menunggu, .badge.Diajukan { background: #fef3c7; color: #92400e; }
        .badge.Diverifikasi { background: #dbeafe; color: #1e40af; }
        .badge.Diproses { background: #ede9fe; color: #5b21b6; }
        .badge.Selesai { background: #d1fae5; color: #065f46; }
        .empty { text-align: center; color: #6b7280; padding: 24px; }
        .thumb { width: 42px; height: 42px; object-fit: cover; border-radius: 6px; border: 1px solid #e5e7eb; }
        .btn { display: inline-block; padding: 8px 14px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
        .btn-primary { background: #1d4ed8; color: #fff; }
        .btn-primary:hover { background: #1e40af; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .btn-secondary:hover { background: #d1d5db; }
        .btn-edit { background: #dbeafe; color: #1e40af; padding: 5px 10px; }
        .btn-delete { background: #fee2e2; color: #b91c1c; padding: 5px 10px; }
        .actions { display: flex; gap: 6px; align-items: center; }
        .card { background: #fff; padding: 24px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.1); max-width: 600px; }
        .form-group { margin-bottom: 16px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 9px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 14px; box-sizing: border-box; font-family: inherit; }
        .form-actions { display: flex; gap: 10px; margin-top: 20px; }
    </style>
</head>
<body>
    <nav>
        <strong>CampusCare (Laravel DB)</strong>
        <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}">Laporan</a>
        <a href="{{ route('categories.index') }}" class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">Kategori</a>
        <a href="{{ route('locations.index') }}" class="{{ request()->routeIs('locations.*') ? 'active' : '' }}">Lokasi</a>
        <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a>
        <a href="{{ route('report-histories.index') }}" class="{{ request()->routeIs('report-histories.*') ? 'active' : '' }}">Riwayat Status</a>
    </nav>
    <main>
        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif
        @yield('content')
    </main>
</body>
</html>
