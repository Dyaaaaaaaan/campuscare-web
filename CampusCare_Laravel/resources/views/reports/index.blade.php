@extends('layouts.app')

@section('title', 'Daftar Laporan - CampusCare')

@section('content')
    <h1>Daftar Laporan (`reports`)</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Foto</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                <th>Pelapor</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>
                        @if ($report->image)
                            <img src="{{ $report->image }}" alt="Bukti" class="thumb">
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $report->title }}</td>
                    <td>{{ $report->description ?: '-' }}</td>
                    <td>{{ $report->category->name }}</td>
                    <td>
                        {{ $report->location->building }}
                        {{ $report->location->floor ? ', ' . $report->location->floor : '' }}
                        {{ $report->location->room ? ', ' . $report->location->room : '' }}
                    </td>
                    <td>{{ $report->user->name }}</td>
                    <td>{{ $report->reported_at->format('d-m-Y') }}</td>
                    <td><span class="badge {{ $report->status }}">{{ $report->status }}</span></td>
                </tr>
            @empty
                <tr><td colspan="9" class="empty">Belum ada laporan.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
