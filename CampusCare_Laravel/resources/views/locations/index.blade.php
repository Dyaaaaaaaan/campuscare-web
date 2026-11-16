@extends('layouts.app')

@section('title', 'Lokasi - CampusCare')

@section('content')
    <h1>Daftar Lokasi</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Gedung</th>
                <th>Lantai</th>
                <th>Ruangan</th>
                <th>Jumlah Laporan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($locations as $location)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $location->building }}</td>
                    <td>{{ $location->floor ?? '-' }}</td>
                    <td>{{ $location->room ?? '-' }}</td>
                    <td>{{ $location->reports_count }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty">Belum ada lokasi.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection

