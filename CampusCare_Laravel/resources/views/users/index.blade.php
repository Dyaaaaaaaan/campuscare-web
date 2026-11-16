@extends('layouts.app')

@section('title', 'Daftar Users - CampusCare')

@section('content')
    <h1>Daftar Pengguna (`users`)</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Jumlah Laporan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td><span class="badge">{{ $user->role }}</span></td>
                    <td>{{ $user->reports_count }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">Belum ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection

