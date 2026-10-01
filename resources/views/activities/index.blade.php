{{-- resources/views/activities/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <h1>Daftar Kegiatan</h1>
    @forelse ($activities as $activity)
        <article class="card">
            <h2>
                <a href="{{ route('activities.show', $activity) }}">
                    {{ $activity->title }}
                </a>
            </h2>
            <p>{{ $activity->activity_date->format('d M Y') }}</p>
            <p>Status: {{ $activity->status }}</p>
        </article>
    @empty
        <form action="{{ url('/activities') }}" method="GET" style="margin-bottom: 20px;">
        <!-- Pertahankan status jika sedang difilter -->
        @if(request('status'))
            <input type="hidden" name="status" value="{{ request('status') }}">
        @endif
        
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Cari kode atau judul..."
        >
        <button type="submit">Cari</button>
    </form>
        <p>Belum ada kegiatan.</p>
    @endforelse
@endsection