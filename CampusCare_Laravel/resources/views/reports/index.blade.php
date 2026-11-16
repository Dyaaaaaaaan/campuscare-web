@extends('layouts.app')

@section('title', 'Daftar Laporan - CampusCare')

@section('content')
    <div class="page-header">
        <h1>Daftar Laporan (`reports`)</h1>
        <a href="{{ route('reports.create') }}" class="btn btn-primary">+ Tambah Laporan</a>
    </div>

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
                <th>Aksi</th>
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
                    <td>
                        <div class="actions">
                            <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-edit">Edit</a>
                            <form action="{{ route('reports.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="10" class="empty">Belum ada laporan.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection
