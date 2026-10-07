@extends('admin.layouts.app')

@section('title', __('admin.articles'))
@section('page-title', __('admin.articles'))

@section('content')

<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-newspaper" style="color:var(--green-600)"></i> {{ __('admin.articles') }}
            <span style="background:var(--slate-100);color:var(--slate-500);font-size:.75rem;padding:.2rem .6rem;border-radius:999px;margin-left:.5rem">{{ $articles->total() }}</span>
        </h3>
        <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> {{ __('admin.add_article') }}
        </a>
    </div>

    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th style="width:112px"></th>
                    <th>{{ __('admin.article_title') }}</th>
                    <th>{{ __('admin.article_category') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.created_at') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td>
                            @if($article->thumbnail)
                                <img src="{{ asset('storage/'.$article->thumbnail) }}" class="thumb-preview" alt="">
                            @else
                                <div class="thumb-preview" style="background:var(--green-100);display:flex;align-items:center;justify-content:center">
                                    <i class="fas fa-image" style="color:var(--green-400)"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div style="font-weight:600;color:var(--slate-800);max-width:300px">{{ Str::limit($article->title, 60) }}</div>
                            <div style="font-size:.75rem;color:var(--slate-400);margin-top:.2rem">
                                <i class="fas fa-user"></i> {{ $article->user?->name ?? $article->author ?? 'SEHATIN' }}
                            </div>
                        </td>
                        <td><span class="badge badge-green">{{ $article->category->name }}</span></td>
                        <td>
                            @if($article->status === 'published')
                                <span class="badge badge-green"><i class="fas fa-circle" style="font-size:.45rem"></i> {{ __('admin.published') }}</span>
                            @else
                                <span class="badge badge-gray"><i class="fas fa-circle" style="font-size:.45rem"></i> {{ __('admin.draft') }}</span>
                            @endif
                        </td>
                        <td style="font-size:.8rem;color:var(--slate-500);white-space:nowrap">{{ $article->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('artikel.show', $article) }}" target="_blank" class="btn btn-xs btn-outline" title="Lihat">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.artikel.edit', $article) }}" class="btn btn-xs btn-outline" title="{{ __('admin.edit') }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.artikel.toggle-status', $article) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-xs {{ $article->status==='published' ? 'btn-warning' : 'btn-success' }}" title="{{ $article->status==='published' ? __('admin.unpublish') : __('admin.publish') }}">
                                        <i class="fas {{ $article->status==='published' ? 'fa-eye-slash' : 'fa-paper-plane' }}"></i>
                                    </button>
                                </form>
                                <form action="{{ route('admin.artikel.destroy', $article) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger btn-delete-confirm" title="{{ __('admin.delete') }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="text-align:center;color:var(--slate-400);padding:3rem">{{ __('admin.no_data') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
        <div class="pagination-wrap">{{ $articles->links() }}</div>
    @endif
</div>
@endsection
