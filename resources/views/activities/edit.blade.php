@extends('layouts.app')

@section('content')
    <h1>Ubah Kegiatan: {{ $activity->title }}</h1>

    <form action="{{ route('activities.update', $activity) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="title">Judul</label>
            <input 
                id="title" 
                name="title" 
                value="{{ old('title', $activity->title ?? '') }}"
            >
            @error('title')
                <p style="color: red">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status">Status</label>
            <select name="status" id="status">
                @foreach (['Planned', 'Ongoing', 'Done'] as $status)
                    <option 
                        value="{{ $status }}"
                        @selected(old('status', $activity->status ?? 'Planned') === $status)
                    >
                        {{ $status }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p style="color: red">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="activity_date">Tanggal</label>
            <input type="date" id="activity_date" name="activity_date" value="{{ old('activity_date', $activity->activity_date->format('Y-m-d')) }}">
            @error('activity_date')
                <p style="color: red">{{ $message }}</p>
            @enderror   
        </div>

        <div>
            <label for="category">Kategori</label>
            <input type="text" id="category" name="category" value="{{ old('category', $activity->category) }}">
        </div>

        <button type="submit">Perbarui</button>
    </form>
@endsection