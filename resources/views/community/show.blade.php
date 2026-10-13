@extends('layouts.app')

@section('title', $thread->title)

@section('content')
<main class="section">
    <article class="section-inner" style="max-width:850px">
        <a class="section-link" href="{{ route('community.index') }}">← {{ __('app.community_title') }}</a>
        <section class="card" style="padding:1.5rem;margin-top:1rem">
            <p class="card-meta"><span class="card-tag">{{ __('app.community_categories.'.$thread->category, [], app()->getLocale()) !== 'app.community_categories.'.$thread->category ? __('app.community_categories.'.$thread->category) : $thread->category }}</span><span>{{ $thread->user->name }}</span><span>{{ $thread->created_at->diffForHumans() }}</span></p>
            <h1 class="section-title">{{ $thread->title }}</h1>
            <div style="white-space:pre-wrap;margin-top:1rem">{{ $thread->body }}</div>
            @auth
                @if(auth()->id() !== $thread->user_id)
                <form method="POST" action="{{ route('community.report') }}" data-requires-network class="report-form">
                    @csrf
                    <input type="hidden" name="type" value="thread"><input type="hidden" name="id" value="{{ $thread->id }}">
                    <div class="form-field">
                        <label for="report-thread">{{ __('app.report_reason') }}</label>
                        <select id="report-thread" name="reason" class="filter-select" required>
                            @foreach(__('app.report_reasons') as $reason => $label)<option value="{{ $reason }}">{{ $label }}</option>@endforeach
                        </select>
                    </div>
                    <button class="btn btn-sm btn-danger" type="submit">{{ __('app.report') }}</button>
                </form>
                @else
                    <p class="community-report-note">{{ __('app.cannot_report_own_content') }}</p>
                @endif
            @endauth
        </section>
        <section aria-labelledby="replies-heading" style="margin-top:2rem">
            <h2 id="replies-heading" class="section-title">{{ __('app.replies') }} ({{ $thread->replies->count() }})</h2>
            @foreach($thread->replies as $reply)
                <article class="card" style="padding:1rem;margin:.8rem 0">
                    <p class="card-meta">
                        <span>{{ $reply->user->name }}</span>
                        @if($reply->doctor_verified && $reply->user->is_verified_doctor)
                            <span class="card-tag"><i class="fas fa-user-doctor" aria-hidden="true"></i> {{ __('app.verified_doctor') }}</span>
                        @endif
                        <span>{{ $reply->created_at->diffForHumans() }}</span>
                    </p>
                    <p style="white-space:pre-wrap">{{ $reply->body }}</p>
                    @auth
                        @if(auth()->id() !== $reply->user_id)
                        <form method="POST" action="{{ route('community.report') }}" data-requires-network class="report-form report-form--inline">
                            @csrf
                            <input type="hidden" name="type" value="reply"><input type="hidden" name="id" value="{{ $reply->id }}">
                            <div class="form-field">
                                <label for="report-reply-{{ $reply->id }}">{{ __('app.report_reason') }}</label>
                                <select id="report-reply-{{ $reply->id }}" name="reason" class="filter-select" required>
                                    @foreach(__('app.report_reasons') as $reason => $label)<option value="{{ $reason }}">{{ $label }}</option>@endforeach
                                </select>
                            </div>
                            <button class="btn btn-sm btn-danger" type="submit">{{ __('app.report') }}</button>
                        </form>
                        @else
                            <p class="community-report-note">{{ __('app.cannot_report_own_content') }}</p>
                        @endif
                    @endauth
                </article>
            @endforeach
            @auth
                <form method="POST" action="{{ route('community.reply', $thread) }}" data-requires-network class="reply-form card">
                    @csrf
                    <div class="form-field">
                        <label for="reply-body">{{ __('app.write_reply') }}</label>
                        <textarea id="reply-body" name="body" rows="4" maxlength="5000" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('app.post_reply') }}</button>
                </form>
            @else
                <p class="disclaimer-box"><a href="{{ route('login') }}">{{ __('app.login') }}</a> {{ __('app.login_to_post') }}</p>
            @endauth
        </section>
    </article>
</main>
@endsection
