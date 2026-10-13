@extends('admin.layouts.app')

@section('title', __('app.community_moderation'))

@section('content')
<section class="moderation-page">
    <header class="moderation-header">
        <div>
            <h1>{{ __('app.community_moderation') }}</h1>
            <p>{{ __('app.community_moderation_intro') }}</p>
        </div>
        <span class="moderation-count">{{ $reports->total() }} {{ __('app.pending_reports') }}</span>
    </header>
    <section aria-labelledby="pending-reports-heading">
        <h2 id="pending-reports-heading" class="moderation-section-title">{{ __('app.pending_reports') }}</h2>
    @forelse($reports as $report)
        <article class="moderation-report">
            <header class="moderation-report-header">
                <div class="moderation-report-tags">
                    <span class="moderation-type">{{ class_basename($report->reportable) === 'CommunityReply' ? __('app.reported_reply') : __('app.reported_thread') }}</span>
                    <span class="moderation-reason">{{ __('app.report_reasons.'.$report->reason) }}</span>
                </div>
                <time>{{ $report->created_at->diffForHumans() }}</time>
            </header>
            @if($report->reportable)
                <div class="moderation-content">
                    <strong>{{ __('app.reported_content') }}</strong>
                    @if(class_basename($report->reportable) === 'CommunityThread')
                        <h3>{{ $report->reportable->title }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($report->reportable->body, 500) }}</p>
                    @else
                        <p>{{ \Illuminate\Support\Str::limit($report->reportable->body, 500) }}</p>
                        @if($report->reportable->thread)
                            <a class="moderation-context-link" href="{{ route('community.show', $report->reportable->thread) }}">{{ __('app.view_thread') }}: {{ $report->reportable->thread->title }}</a>
                        @endif
                    @endif
                </div>
            @else
                <p class="moderation-content-unavailable">{{ __('app.reported_content_unavailable') }}</p>
            @endif
            @if($report->details)
                <p class="moderation-details"><strong>{{ __('app.report') }}:</strong> {{ $report->details }}</p>
            @endif
            <footer class="moderation-report-footer">
                <p class="moderation-reporter"><strong>{{ __('app.reported_by') }}:</strong> {{ $report->reporter->name }} <span>{{ $report->reporter->email }}</span></p>
                <div class="moderation-actions">
                    @if($report->reportable)
                        <form method="POST" action="{{ route('admin.community.reports.destroy-content', $report) }}">
                            @csrf
                            <button class="btn btn-danger btn-delete-confirm" data-confirm="{{ __('app.delete_reported_content_confirm') }}" type="submit">
                                <i class="fas fa-trash" aria-hidden="true"></i> {{ __('app.delete_reported_content') }}
                            </button>
                        </form>
                    @endif
                    <form method="POST" action="{{ route('admin.community.reports.resolve', $report) }}">
                        @csrf
                        <button class="btn btn-outline" type="submit">{{ __('app.mark_reviewed') }}</button>
                    </form>
                </div>
            </footer>
        </article>
    @empty
        <p class="moderation-empty">{{ __('app.no_pending_reports') }}</p>
    @endforelse
    {{ $reports->links() }}
    </section>

    <section class="moderation-doctors" aria-labelledby="verify-doctors-heading">
    <h2 id="verify-doctors-heading" class="moderation-section-title">{{ __('app.verify_doctors') }}</h2>
    @forelse($unverifiedDoctors as $candidate)
        <article class="moderation-doctor">
            <span><strong>{{ $candidate->name }}</strong><small>{{ $candidate->email }}</small></span>
            <form method="POST" action="{{ route('admin.community.doctors.verify', $candidate) }}">
                @csrf
                <button class="btn btn-outline" type="submit">{{ __('app.verify_doctor') }}</button>
            </form>
        </article>
    @empty
        <p>{{ __('app.no_doctors_to_verify') }}</p>
    @endforelse
    </section>
</section>
@endsection
