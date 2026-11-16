@extends('layouts.app')

@section('title', 'Riwayat Status Laporan - CampusCare')

@section('content')
    <h1>Riwayat Status Laporan (`report_histories`)</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Laporan</th>
                <th>Diubah Oleh</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Waktu</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($histories as $history)
                <tr>
                    <td>{{ $history->id }}</td>
                    <td>#{{ $history->report_id }} - {{ $history->report->title ?? '-' }}</td>
                    <td>{{ $history->user->name ?? '-' }}</td>
                    <td><span class="badge {{ $history->status }}">{{ $history->status }}</span></td>
                    <td>{{ $history->note ?? '-' }}</td>
                    <td>{{ $history->created_at?->format('d-m-Y H:i:s') }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty">Belum ada riwayat status.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection

