@extends('layouts.app')

@section('title', 'Tambah Laporan - CampusCare')

@section('content')
    <h1>Tambah Laporan Baru</h1>

    <div class="card">
        <form action="{{ route('reports.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="title">Judul Laporan</label>
                <input type="text" id="title" name="title" placeholder="Contoh: AC Rusak di Ruang 301" required>
            </div>

            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="location_id">Lokasi</label>
                <select id="location_id" name="location_id" required>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}">
                            {{ $location->building }}{{ $location->floor ? ', ' . $location->floor : '' }}{{ $location->room ? ', ' . $location->room : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="user_id">Pelapor</label>
                <select id="user_id" name="user_id" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="reported_at">Tanggal Laporan</label>
                <input type="date" id="reported_at" name="reported_at" value="{{ date('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    @foreach (['Menunggu', 'Diajukan', 'Diverifikasi', 'Diproses', 'Selesai'] as $status)
                        <option value="{{ $status }}">{{ $status }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Masalah</label>
                <textarea id="description" name="description" rows="4" placeholder="Jelaskan detail kerusakan..."></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

