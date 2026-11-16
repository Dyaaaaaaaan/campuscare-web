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
        nav .spacer { flex: 1; }
        nav .btn-app { background: #fff; color: #1d4ed8; padding: 6px 14px; border-radius: 999px; font-weight: 600; text-decoration: none; }
        nav .btn-app:hover { background: #eff6ff; text-decoration: none; }
        main { max-width: 1080px; margin: 32px auto; padding: 0 16px; }
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
        @yield('content')
    </main>
</body>
</html>
