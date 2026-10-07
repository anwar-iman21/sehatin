@if ($paginator->hasPages())
    @php
        $currentPage = $paginator->currentPage();
        $lastPage = $paginator->lastPage();
        $startPage = max(1, $currentPage - 1);
        $endPage = min($lastPage, $currentPage + 1);
    @endphp

    <nav class="pagination-nav" role="navigation" aria-label="Navigasi halaman">
        <div class="pagination-controls">
            @if ($paginator->onFirstPage())
                <span class="pagination-link pagination-direction is-disabled" aria-disabled="true">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    <span>Sebelumnya</span>
                </span>
            @else
                <a class="pagination-link pagination-direction" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <i class="fas fa-arrow-left" aria-hidden="true"></i>
                    <span>Sebelumnya</span>
                </a>
            @endif

            @if ($startPage > 1)
                <a class="pagination-link pagination-page" href="{{ $paginator->url(1) }}">1</a>
                @if ($startPage > 2)
                    <span class="pagination-ellipsis" aria-hidden="true">…</span>
                @endif
            @endif

            @for ($page = $startPage; $page <= $endPage; $page++)
                @if ($page === $currentPage)
                    <span class="pagination-link pagination-page is-current" aria-current="page">{{ $page }}</span>
                @else
                    <a class="pagination-link pagination-page" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                @endif
            @endfor

            @if ($endPage < $lastPage)
                @if ($endPage < $lastPage - 1)
                    <span class="pagination-ellipsis" aria-hidden="true">…</span>
                @endif
                <a class="pagination-link pagination-page" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
            @endif

            @if ($paginator->hasMorePages())
                <a class="pagination-link pagination-direction" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <span>Selanjutnya</span>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </a>
            @else
                <span class="pagination-link pagination-direction is-disabled" aria-disabled="true">
                    <span>Selanjutnya</span>
                    <i class="fas fa-arrow-right" aria-hidden="true"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
