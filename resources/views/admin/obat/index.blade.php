@extends('admin.layouts.app')
@section('title', 'Info Obat')
@section('page-title', 'Info Obat')

@section('content')
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-pills" style="color:var(--green-600)"></i> Data Obat</h3>
        <a href="{{ route('admin.obat.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah Obat</a>
    </div>
    <div style="overflow-x:auto">
        <table>
            <thead><tr><th>Nama Obat</th><th>Kategori</th><th>Bentuk</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse($drugs as $drug)
                    <tr>
                        <td><strong>{{ $drug->name }}</strong><div style="font-size:.75rem;color:var(--slate-400)">{{ $drug->generic_name }}</div></td>
                        <td>{{ str_replace('_', ' ', ucfirst($drug->category)) }}</td>
                        <td>{{ ucfirst($drug->form) }}</td>
                        <td><span class="badge {{ $drug->is_active ? 'badge-green' : 'badge-gray' }}">{{ $drug->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
                        <td><div class="td-actions">
                            @if($drug->is_active)<a href="{{ route('obat.show', $drug) }}" target="_blank" class="btn btn-xs btn-outline" aria-label="Lihat {{ $drug->name }}"><i class="fas fa-eye"></i></a>@endif
                            <a href="{{ route('admin.obat.edit', $drug) }}" class="btn btn-xs btn-outline" aria-label="Edit {{ $drug->name }}"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.obat.toggle', $drug) }}" method="POST">@csrf<button class="btn btn-xs {{ $drug->is_active ? 'btn-warning' : 'btn-success' }}" type="submit">{{ $drug->is_active ? 'Nonaktifkan' : 'Aktifkan' }}</button></form>
                            <form action="{{ route('admin.obat.destroy', $drug) }}" method="POST">@csrf @method('DELETE')<button class="btn btn-xs btn-danger btn-delete-confirm" type="submit" aria-label="Hapus {{ $drug->name }}"><i class="fas fa-trash"></i></button></form>
                        </div></td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--slate-400);padding:3rem">Belum ada data obat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="pagination-wrap">{{ $drugs->links() }}</div>
</div>
@endsection
