{{-- resources/views/activities/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>{{ $activity->title }}</h1>
    <p>Tanggal: {{ $activity->activity_date->format('d M Y') }}</p>
    <p>Kategori: {{ $activity->category }}</p>
    <p>Status: {{ $activity->status }}</p>
    <p>Deskripsi: {{ $activity->description }}</p>

    <a href="{{ route('activities.index') }}">Kembali ke Daftar</a>
@endsection