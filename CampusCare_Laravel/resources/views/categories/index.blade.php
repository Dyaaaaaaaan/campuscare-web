@extends('layouts.app')

@section('title', 'Kategori - CampusCare')

@section('content')
    <h1>Daftar Kategori</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Jumlah Laporan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td>{{ $category->reports_count }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="empty">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
@endsection

