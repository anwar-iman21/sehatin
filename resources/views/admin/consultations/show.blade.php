@extends('admin.layouts.app')

@section('title', $user->name)
@section('page-title', __('app.consultation_inbox'))

@section('content')
<section class="admin-chat">
    <a class="btn btn-outline" href="{{ route('admin.consultations.index') }}"><i class="fas fa-arrow-left" aria-hidden="true"></i> {{ __('app.consultation_inbox') }}</a>
    <form method="POST" action="{{ route('admin.consultations.destroy', $user) }}" class="admin-chat-delete">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger btn-delete-confirm" data-confirm="{{ __('app.consultation_delete_confirm') }}">
            <i class="fas fa-trash" aria-hidden="true"></i> {{ __('admin.delete') }}
        </button>
    </form>
    <header class="admin-chat-header">
        <h1>{{ $user->name }}</h1>
        <p>{{ $user->email }}</p>
    </header>
        <div class="admin-chat-log" role="log" aria-live="polite"
            data-admin-chat-log
            data-messages-url="{{ route('admin.consultations.messages', $user) }}"
            data-last-message-id="{{ $messages->last()?->id ?? 0 }}"
            data-user-name="{{ $user->name }}"
            data-admin-name="{{ auth()->user()->name }}"
            data-empty-label="{{ __('app.consultation_no_messages') }}">
        @forelse($messages as $message)
            <article class="admin-chat-message admin-chat-message--{{ $message->sender }}">
                <p class="admin-chat-sender">{{ $message->sender === 'admin' ? ($message->admin?->name ?? __('app.consultation_admin_label')) : $user->name }}</p>
                <p class="admin-chat-body">{{ $message->message }}</p>
                <time>{{ $message->created_at->format('d M Y, H:i') }}</time>
            </article>
        @empty
            <p>{{ __('app.consultation_no_messages') }}</p>
        @endforelse
    </div>
    @if($errors->any())
        <div class="alert alert-error">{{ $errors->first('message') }}</div>
    @endif
    <form method="POST" action="{{ route('admin.consultations.reply', $user) }}" class="admin-chat-reply">
        @csrf
        <label class="form-label" for="consultation-reply">{{ __('app.consultation_reply') }}</label>
        <textarea id="consultation-reply" class="form-control" name="message" rows="4" maxlength="4000" required>{{ old('message') }}</textarea>
        <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane" aria-hidden="true"></i> {{ __('app.consultation_send_reply') }}</button>
    </form>
</section>
@endsection