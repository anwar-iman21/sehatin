@extends('admin.layouts.app')
@section('title', __('admin.pages'))
@section('page-title', __('admin.pages'))

@section('content')
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-file-alt" style="color:var(--green-600)"></i> {{ __('admin.pages') }}</h3>
    </div>
    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>{{ __('admin.page_title') }}</th>
                    <th>Slug</th>
                    <th>{{ __('admin.created_at') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pages as $page)
                    <tr>
                        <td style="font-weight:600">{{ $page->title }}</td>
                        <td style="font-size:.78rem;color:var(--slate-400);font-family:monospace">/{{ $page->slug }}</td>
                        <td style="font-size:.8rem;color:var(--slate-500)">{{ $page->updated_at->format('d M Y') }}</td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('admin.halaman.edit', $page) }}" class="btn btn-xs btn-outline"><i class="fas fa-edit"></i> {{ __('admin.edit') }}</a>
                                <a href="/{{ $page->slug }}" target="_blank" class="btn btn-xs btn-outline"><i class="fas fa-eye"></i></a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" style="text-align:center;color:var(--slate-400);padding:3rem">{{ __('admin.no_data') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
