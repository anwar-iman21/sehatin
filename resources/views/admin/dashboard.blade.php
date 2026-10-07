@extends('admin.layouts.app')

@section('title', __('admin.dashboard'))
@section('page-title', __('admin.dashboard'))

@section('content')

{{-- STAT CARDS --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7">
            <i class="fas fa-newspaper" style="color:#16a34a"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['articles'] }}</div>
            <div class="stat-label">{{ __('admin.total_articles') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dbeafe">
            <i class="fas fa-check-circle" style="color:#2563eb"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['published'] }}</div>
            <div class="stat-label">{{ __('admin.published_articles') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fef9c3">
            <i class="fas fa-edit" style="color:#ca8a04"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['drafts'] }}</div>
            <div class="stat-label">{{ __('admin.draft_articles') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#fce7f3">
            <i class="fas fa-tags" style="color:#db2777"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['categories'] }}</div>
            <div class="stat-label">{{ __('admin.total_categories') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ede9fe">
            <i class="fas fa-stethoscope" style="color:#7c3aed"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['services'] }}</div>
            <div class="stat-label">{{ __('admin.total_services') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#ffedd5">
            <i class="fas fa-question-circle" style="color:#ea580c"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['faqs'] }}</div>
            <div class="stat-label">{{ __('admin.total_faqs') }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#dcfce7">
            <i class="fas fa-users" style="color:#16a34a"></i>
        </div>
        <div>
            <div class="stat-value">{{ $stats['users'] }}</div>
            <div class="stat-label">{{ __('admin.total_users') }}</div>
        </div>
    </div>
</div>

{{-- RECENT ARTICLES --}}
<div class="table-card">
    <div class="table-header">
        <h3><i class="fas fa-clock" style="color:var(--green-600)"></i> {{ __('admin.recent_articles') }}</h3>
        <a href="{{ route('admin.artikel.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> {{ __('admin.add_article') }}
        </a>
    </div>
    <div style="overflow-x:auto">
        <table>
            <thead>
                <tr>
                    <th>{{ __('admin.article_title') }}</th>
                    <th>{{ __('admin.article_category') }}</th>
                    <th>{{ __('admin.status') }}</th>
                    <th>{{ __('admin.created_at') }}</th>
                    <th>{{ __('admin.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentArticles as $article)
                    <tr>
                        <td>
                            <div style="font-weight:600;color:var(--slate-800);max-width:280px">{{ Str::limit($article->title, 50) }}</div>
                            <div style="font-size:.75rem;color:var(--slate-400)">{{ $article->user?->name ?? $article->author ?? 'SEHATIN' }}</div>
                        </td>
                        <td><span class="badge badge-green">{{ $article->category->name }}</span></td>
                        <td>
                            @if($article->status === 'published')
                                <span class="badge badge-green"><i class="fas fa-circle" style="font-size:.5rem"></i> {{ __('admin.published') }}</span>
                            @else
                                <span class="badge badge-gray"><i class="fas fa-circle" style="font-size:.5rem"></i> {{ __('admin.draft') }}</span>
                            @endif
                        </td>
                        <td style="font-size:.8rem;color:var(--slate-500)">{{ $article->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="td-actions">
                                <a href="{{ route('admin.artikel.edit', $article) }}" class="btn btn-xs btn-outline">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('artikel.show', $article) }}" target="_blank" class="btn btn-xs btn-outline">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:var(--slate-400);padding:2rem">{{ __('admin.no_data') }}</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($recentArticles->count())
        <div class="pagination-wrap">
            <a href="{{ route('admin.artikel.index') }}" class="btn btn-sm btn-outline">Lihat Semua Artikel →</a>
        </div>
    @endif
</div>
@endsection
