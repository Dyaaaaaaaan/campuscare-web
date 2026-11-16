@extends('layouts.app')

@section('title', 'Edit Laporan - CampusCare')

@section('content')
    <h1>Edit Laporan #{{ $report->id }}</h1>

    <div class="card">
        <form action="{{ route('reports.update', $report->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Judul Laporan</label>
                <input type="text" id="title" name="title" value="{{ $report->title }}" required>
            </div>

            <div class="form-group">
                <label for="category_id">Kategori</label>
                <select id="category_id" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $report->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="location_id">Lokasi</label>
                <select id="location_id" name="location_id" required>
                    @foreach ($locations as $location)
                        <option value="{{ $location->id }}" {{ $report->location_id == $location->id ? 'selected' : '' }}>
                            {{ $location->building }}{{ $location->floor ? ', ' . $location->floor : '' }}{{ $location->room ? ', ' . $location->room : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="user_id">Pelapor</label>
                <select id="user_id" name="user_id" required>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ $report->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->role }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="reported_at">Tanggal Laporan</label>
                <input type="date" id="reported_at" name="reported_at" value="{{ $report->reported_at->format('Y-m-d') }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status">
                    @foreach (['Menunggu', 'Diajukan', 'Diverifikasi', 'Diproses', 'Selesai'] as $status)
                        <option value="{{ $status }}" {{ $report->status === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi Masalah</label>
                <textarea id="description" name="description" rows="4">{{ $report->description }}</textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Perbarui Laporan</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

