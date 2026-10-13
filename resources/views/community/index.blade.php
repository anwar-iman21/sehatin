@extends('layouts.app')

@section('title', __('app.community_title'))

@section('content')
<header class="page-header">
    <h1>{{ __('app.community_title') }}</h1>
    <p>{{ __('app.community_subtitle') }}</p>
</header>
<main class="section">
    <div class="section-inner" style="max-width:900px">
        <form method="GET" action="{{ route('community.index') }}" class="community-filters">
            <label for="community-category">{{ __('app.category') }}</label>
            <select id="community-category" name="category" class="filter-select">
                <option value="">{{ __('app.all_categories') }}</option>
                @foreach($categories as $category)
                    <option value="{{ $category }}" @selected(request('category') === $category)>{{ __('app.community_categories.'.$category, [], app()->getLocale()) !== 'app.community_categories.'.$category ? __('app.community_categories.'.$category) : $category }}</option>
                @endforeach
            </select>
            <label for="community-sort">{{ __('app.sort_by') }}</label>
            <select id="community-sort" name="sort" class="filter-select">
                <option value="recent" @selected(request('sort') !== 'popular')>{{ __('app.sort_recent') }}</option>
                <option value="popular" @selected(request('sort') === 'popular')>{{ __('app.sort_popular') }}</option>
            </select>
            <button class="btn btn-outline" type="submit">{{ __('app.filter') }}</button>
        </form>

        @auth
            <details class="community-thread-compose">
                <summary>{{ __('app.create_thread') }}</summary>
                <form method="POST" action="{{ route('community.store') }}" data-requires-network class="community-thread-form">
                    @csrf
                    <div class="form-field">
                        <label for="thread-category">{{ __('app.category') }}</label>
                        <select id="thread-category" name="category" class="filter-select" required>
                            @foreach(__('app.community_categories') as $slug => $label)
                                <option value="{{ $slug }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="thread-title">{{ __('app.thread_title') }}</label>
                        <input id="thread-title" name="title" maxlength="200" minlength="8" required>
                    </div>
                    <div class="form-field">
                        <label for="thread-body">{{ __('app.thread_body') }}</label>
                        <textarea id="thread-body" name="body" rows="5" maxlength="10000" minlength="10" required></textarea>
                    </div>
                    <label class="checkbox-field"><input type="checkbox" name="is_question" value="1"> {{ __('app.is_question') }}</label>
                    <button type="submit" class="btn btn-primary">{{ __('app.post_thread') }}</button>
                </form>
            </details>
        @else
            <p class="disclaimer-box"><a href="{{ route('login') }}">{{ __('app.login') }}</a> {{ __('app.login_to_post') }}</p>
        @endauth

        @forelse($threads as $thread)
            <article class="card community-thread" aria-label="{{ $thread->title }}">
                <a class="community-thread-link" href="{{ route('community.show', $thread) }}" aria-label="{{ __('app.view_thread') }}: {{ $thread->title }}"></a>
                <div class="community-thread-body">
                    <p class="card-meta"><span class="card-tag">{{ __('app.community_categories.'.$thread->category, [], app()->getLocale()) !== 'app.community_categories.'.$thread->category ? __('app.community_categories.'.$thread->category) : $thread->category }}</span><span>{{ $thread->user->name }}</span><span>{{ $thread->created_at->diffForHumans() }}</span></p>
                    <h2 class="card-title"><a href="{{ route('community.show', $thread) }}">{{ $thread->title }}</a></h2>
                    <p class="card-excerpt">{{ \Illuminate\Support\Str::limit($thread->body, 240) }}</p>
                    <p class="card-meta community-thread-meta">{{ __('app.reply_count', ['count' => $thread->replies_count]) }} · {{ __('app.view_count', ['count' => $thread->views]) }}</p>
                </div>
            </article>
        @empty
            <section class="empty-state"><i class="fas fa-comments" aria-hidden="true"></i><p>{{ __('app.community_empty') }}</p></section>
        @endforelse
        {{ $threads->links() }}
    </div>
</main>
@endsection
