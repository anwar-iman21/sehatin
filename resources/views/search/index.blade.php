@extends('layouts.app')

@section('title', __('app.search_all'))

@section('content')
<header class="page-header">
    <h1>{{ __('app.search_all') }}</h1>
    <p>{{ __('app.search_all_subtitle') }}</p>
</header>
<main class="section">
    <div class="section-inner" style="max-width:900px">
        <form action="{{ route('search.index') }}" method="GET" role="search" style="margin-bottom:2rem">
            <label for="integrated-search" class="section-title" style="display:block;margin-bottom:.65rem">{{ __('app.search_all') }}</label>
            <div style="display:flex;gap:.5rem">
                <input id="integrated-search" name="q" value="{{ $query }}" maxlength="200"
                       autocomplete="off" data-search-suggestions="{{ route('search.suggestions') }}"
                       aria-label="{{ __('app.search_placeholder') }}" aria-controls="search-suggestions" aria-autocomplete="list"
                       style="flex:1;min-width:0;padding:.8rem;border:1px solid var(--slate-300);border-radius:.5rem;background:var(--white);color:var(--slate-800)">
                <button type="submit" class="btn btn-primary">{{ __('app.search') }}</button>
            </div>
            <ul id="search-suggestions" role="listbox" aria-label="{{ __('app.search_suggestions') }}" hidden
                style="list-style:none;margin:.25rem 0 0;padding:.3rem;border:1px solid var(--slate-200);border-radius:.5rem"></ul>
        </form>
        @if($query !== '')
            @if($groups->isEmpty())
                <section class="empty-state" aria-live="polite">
                    <i class="fas fa-magnifying-glass" aria-hidden="true"></i>
                    <p>{{ __('app.no_search_results', ['query' => $query]) }}</p>
                    <p style="margin-top:.6rem">{{ __('app.search_try_alternative') }}</p>
                </section>
            @else
                @foreach($groups as $category => $items)
                    <section aria-labelledby="search-category-{{ $loop->index }}" style="margin-bottom:2rem">
                        <h2 id="search-category-{{ $loop->index }}" class="section-title">{{ $category }}</h2>
                        <ul style="list-style:none;margin-top:.75rem">
                            @foreach($items as $item)
                                <li class="card" style="padding:1rem;margin:.6rem 0">
                                    <a href="{{ $item['url'] }}" style="color:var(--green-700);font-weight:700">{{ $item['title'] }}</a>
                                    @if($item['excerpt'])
                                        <p class="card-excerpt" style="margin-top:.3rem">{{ \Illuminate\Support\Str::limit(strip_tags($item['excerpt']), 180) }}</p>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </section>
                @endforeach
            @endif
        @endif
    </div>
</main>
@push('scripts')
<script>
(() => {
    const input = document.getElementById('integrated-search');
    const list = document.getElementById('search-suggestions');
    if (!input || !list) return;
    let timer;
    let controller;
    input.addEventListener('input', () => {
        window.clearTimeout(timer);
        controller?.abort();
        if (input.value.trim().length < 2) {
            list.hidden = true;
            list.replaceChildren();
            return;
        }
        timer = window.setTimeout(async () => {
            controller = new AbortController();
            try {
                const url = new URL(input.dataset.searchSuggestions, window.location.origin);
                url.searchParams.set('q', input.value.trim());
                const response = await fetch(url, { signal: controller.signal, headers: { Accept: 'application/json' } });
                if (!response.ok) throw new Error(`Search suggestions failed (${response.status}).`);
                const { suggestions } = await response.json();
                list.replaceChildren(...suggestions.map(item => {
                    const li = document.createElement('li');
                    const link = document.createElement('a');
                    link.href = item.url;
                    link.setAttribute('role', 'option');
                    link.textContent = item.title;
                    link.style.cssText = 'display:block;padding:.55rem;color:var(--slate-700)';
                    li.append(link);
                    return li;
                }));
                list.hidden = suggestions.length === 0;
            } catch (error) {
                if (error.name !== 'AbortError') console.error('Search suggestions could not be loaded.', error);
            }
        }, 250);
    });
    input.addEventListener('keydown', event => {
        if (event.key === 'Escape') list.hidden = true;
    });
})();
</script>
@endpush
@endsection
