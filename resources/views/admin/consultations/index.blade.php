@extends('admin.layouts.app')

@section('title', __('app.consultation_inbox'))
@section('page-title', __('app.consultation_inbox'))

@section('content')
<section class="admin-inbox">
    <h1 class="page-title">{{ __('app.consultation_inbox') }}</h1>
    <div data-admin-inbox
         data-updates-url="{{ route('admin.consultations.updates') }}"
         data-last-message-id="{{ $latestMessageId }}"
         data-delete-label="{{ __('admin.delete') }}"
         data-delete-confirm="{{ __('app.consultation_delete_confirm') }}"
         data-csrf="{{ csrf_token() }}">
        @forelse($latestMessages as $latestMessage)
            <div class="admin-conversation-row" data-user-id="{{ $latestMessage->user->id }}">
                <a class="admin-conversation-item" href="{{ route('admin.consultations.show', $latestMessage->user) }}">
                    <span class="admin-conversation-copy">
                        <strong>{{ $latestMessage->user->name }}</strong>
                        <span>{{ $latestMessage->user->email }}</span>
                        <span class="admin-conversation-preview">{{ \Illuminate\Support\Str::limit($latestMessage->message, 140) }}</span>
                    </span>
                    <span class="admin-conversation-meta">
                        <time>{{ $latestMessage->created_at->diffForHumans() }}</time>
                        @if($latestMessage->sender === 'user')
                            <span class="badge badge-red">{{ __('app.consultation_unanswered') }}</span>
                        @endif
                    </span>
                </a>
                <form method="POST" action="{{ route('admin.consultations.destroy', $latestMessage->user) }}" class="admin-conversation-delete">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger btn-delete-confirm" data-confirm="{{ __('app.consultation_delete_confirm') }}" aria-label="{{ __('admin.delete') }} {{ $latestMessage->user->name }}">
                        <i class="fas fa-trash" aria-hidden="true"></i><span>{{ __('admin.delete') }}</span>
                    </button>
                </form>
            </div>
        @empty
            <section class="admin-inbox-empty" data-inbox-empty aria-labelledby="consultation-empty-title">
                <span class="admin-inbox-empty-icon"><i class="fas fa-comments" aria-hidden="true"></i></span>
                <h2 id="consultation-empty-title">{{ __('app.consultation_empty_inbox') }}</h2>
                <p>{{ __('app.consultation_empty_inbox_hint') }}</p>
            </section>
        @endforelse
    </div>
    {{ $latestMessages->links() }}
</section>
@endsection