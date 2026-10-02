<!DOCTYPE html>
<html>
<head><title>Trash Kegiatan</title></head>
<body>
    <h1>Tong Sampah Kegiatan</h1>
    <a href="{{ url('/activities') }}" style="color: blue;">&larr; Kembali ke Daftar Aktif</a>
    <hr>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @forelse($activities as $activity)
        <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 10px;">
            <h3>{{ $activity->title }} ({{ $activity->code }})</h3>
            <p>Kategori: {{ $activity->category ? $activity->category->name : 'Tanpa Kategori' }}</p>
            <p style="color: red;">Dihapus pada: {{ $activity->deleted_at }}</p>
            
            <form action="{{ route('activities.restore', $activity->id) }}" method="POST">
                @csrf
                <button type="submit" style="background-color: green; color: white; padding: 5px 10px;">Restore Data</button>
            </form>
        </div>
    @empty
        <p>Tong sampah kosong, tidak ada data yang terhapus.</p>
    @endforelse

    <div style="margin-top: 20px;">
        {{ $activities->links() }}
    </div>
</body>
</html>