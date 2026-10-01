{{-- resources/views/activities/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>{{ $activity->title }}</h1> 
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
@endsection