@extends('admin.layouts.app')
@section('title', __('admin.categories'))
@section('page-title', __('admin.categories'))

@section('content')
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-tags" style="color:var(--green-600)"></i> {{ __('admin.categories') }}</h3>
        <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> {{ __('admin.add_category') }}</a>
    </div>
    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>{{ __('admin.category_name') }}</th>
                    <th>Ikon</th>
                    <th>Slug</th>
                    <th>Unggulan</th>
                    <th>{{ __('admin.order') }}</th>
                    <th>Artikel</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>
                            <div style="font-weight:600">{{ $cat->name }}</div>
                            @if($cat->description)
                                <div style="font-size:.75rem;color:var(--slate-400)">{{ Str::limit($cat->description,50) }}</div>
                            @endif
                        </td>
                        <td><i class="{{ $cat->icon ?? 'fas fa-folder' }}" style="color:var(--green-600);font-size:1.1rem"></i></td>
                        <td style="font-size:.78rem;color:var(--slate-400);font-family:monospace">{{ $cat->slug }}</td>
                        <td>
                            @if($cat->is_featured)
                                <span class="badge badge-green"><i class="fas fa-star"></i> Ya</span>
                            @else
                                <span class="badge badge-gray">Tidak</span>
                            @endif
                        </td>
                        <td style="text-align:center">{{ $cat->order }}</td>
                        <td style="text-align:center">
                            <span class="badge badge-green">{{ $cat->articles_count }}</span>
                        </td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('admin.kategori.edit', $cat) }}" class="btn btn-xs btn-outline"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('admin.kategori.destroy', $cat) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger btn-delete-confirm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center;color:var(--slate-400);padding:3rem">{{ __('admin.no_data') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
