{{-- resources/views/activities/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>{{ $activity->title }}</h1>
    @if($activity->poster_path)
        <div style="margin-bottom: 15px;">
            <img src="{{ asset('storage/' . $activity->poster_path) }}" alt="Poster Kegiatan" style="max-width: 300px;">
        </div>
    @endif
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kategori: {{ $activity->category->name}}</p>
    <p>Kode Kegiatan: {{ $activity->code}}</p>
    <p>Status: {{ $activity->status }}</p>
    <p>Deskripsi: {{ $activity->description }}</p>

    {{-- Tombol untuk menghapus data --}}
    <form action="{{ route('activities.destroy', $activity) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?')">Hapus</button>
    </form>

    <a href="{{ route('activities.index') }}">Kembali ke Daftar</a>

    <hr>
    <h3>Form Pendaftaran Peserta</h3>

    <!-- Menampilkan pesan sukses atau error -->
    @if(session('success'))
        <p style="color: green; font-weight: bold;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red; font-weight: bold;">{{ session('error') }}</p>
    @endif

    <!-- Form input data -->
    <form action="{{ route('registrations.store', $activity->id) }}" method="POST">
        @csrf
        <div style="margin-bottom: 10px;">
            <label for="participant_name">Nama Lengkap:</label><br>
            <input type="text" id="participant_name" name="participant_name" required>
        </div>
        
        <div style="margin-bottom: 10px;">
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" required>
        </div>
        
        <button type="submit" style="background-color: blue; color: white; padding: 5px 10px;">Daftar Sekarang</button>
    </form>

    <p>Jumlah Pendaftar Saat Ini: {{ $activity->registered_count ?? 0 }} / {{ $activity->capacity ?? 500 }}</p>
    
@endsection