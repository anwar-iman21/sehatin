@extends('admin.layouts.app')
@section('title', 'Panduan Kesehatan')
@section('page-title', 'Panduan Kesehatan')
@section('content')
<div class="table-card">
    <div class="table-header"><h3><i class="fas fa-book-medical" style="color:var(--green-600)"></i> Data Panduan</h3><a href="{{ route('admin.panduan.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Panduan</a></div>
    <div style="overflow-x:auto"><table>
        <thead><tr><th>Judul Panduan</th><th>Kategori</th><th>Urutan</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
            @forelse($guides as $guide)
                <tr>
                    <td><strong>{{ $guide->title }}</strong><div style="font-size:.75rem;color:var(--slate-400)">{{ Str::limit($guide->excerpt, 90) }}</div></td>
                    <td>{{ ucfirst($guide->category) }}</td><td>{{ $guide->order }}</td>
                    <td><span class="badge {{ $guide->is_active ? 'badge-green' : 'badge-gray' }}">{{ $guide->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                    <td><div class="td-actions">
                        @if($guide->is_active)<a href="{{ route('panduan.show', $guide) }}" target="_blank" class="btn btn-xs btn-outline" aria-label="Lihat {{ $guide->title }}"><i class="fas fa-eye"></i></a>@endif
                        <a href="{{ route('admin.panduan.edit', $guide) }}" class="btn btn-xs btn-outline" aria-label="Edit {{ $guide->title }}"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.panduan.toggle', $guide) }}" method="POST">@csrf<button class="btn btn-xs {{ $guide->is_active ? 'btn-warning' : 'btn-success' }}" type="submit">{{ $guide->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                        <form action="{{ route('admin.panduan.destroy', $guide) }}" method="POST">@csrf @method('DELETE')<button class="btn btn-xs btn-danger btn-delete-confirm" type="submit" aria-label="Hapus {{ $guide->title }}"><i class="fas fa-trash"></i></button></form>
                    </div></td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align:center;color:var(--slate-400);padding:3rem">Belum ada panduan kesehatan.</td></tr>
            @endforelse
        </tbody>
    </table></div>
    <div class="pagination-wrap">{{ $guides->links() }}</div>
</div>
@endsection
