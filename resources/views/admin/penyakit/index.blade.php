@extends('admin.layouts.app')
@section('title', 'Info Penyakit')
@section('page-title', 'Info Penyakit')
@section('content')
<div class="table-card">
    <div class="table-header"><h3><i class="fas fa-virus" style="color:var(--green-600)"></i> Data Penyakit</h3><a href="{{ route('admin.penyakit.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Penyakit</a></div>
    <div style="overflow-x:auto"><table>
        <thead><tr><th>Nama Penyakit</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($diseases as $disease)
                <tr>
                    <td><strong>{{ $disease->name }}</strong><div style="font-size:.75rem;color:var(--slate-400)">{{ Str::limit($disease->overview, 90) }}</div></td>
                    <td>{{ $disease->category ? str_replace('-', ' ', ucfirst($disease->category)) : '—' }}</td>
                    <td><span class="badge {{ $disease->is_active ? 'badge-green' : 'badge-gray' }}">{{ $disease->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td><div class="td-actions">
                        @if($disease->is_active)<a href="{{ route('penyakit.show', $disease) }}" target="_blank" class="btn btn-xs btn-outline" aria-label="Lihat {{ $disease->name }}"><i class="fas fa-eye"></i></a>@endif
                        <a href="{{ route('admin.penyakit.edit', $disease) }}" class="btn btn-xs btn-outline" aria-label="Edit {{ $disease->name }}"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.penyakit.toggle', $disease) }}" method="POST">@csrf<button class="btn btn-xs {{ $disease->is_active ? 'btn-warning' : 'btn-success' }}" type="submit">{{ $disease->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                        <form action="{{ route('admin.penyakit.destroy', $disease) }}" method="POST">@csrf @method('DELETE')<button class="btn btn-xs btn-danger btn-delete-confirm" type="submit" aria-label="Hapus {{ $disease->name }}"><i class="fas fa-trash"></i></button></form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="4" style="text-align:center;color:var(--slate-400);padding:3rem">Belum ada data penyakit.</td></tr>
            @endforelse
        </tbody>
    </table></div>
    <div class="pagination-wrap">{{ $diseases->links() }}</div>
</div>
@endsection
