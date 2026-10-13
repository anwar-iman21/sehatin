@extends('layouts.app')

@section('title', __('app.consultation_title'))

@section('content')
<header class="page-header">
    <h1>{{ __('app.consultation_title') }}</h1>
    <p>{{ __('app.consultation_subtitle') }}</p>
</header>
<main class="section">
    <section class="section-inner consultation-shell" style="max-width:820px">
        <div class="card consultation-card">
            <div data-chat-messages data-last-message-id="{{ $messages->last()?->id ?? 0 }}" role="log" aria-live="polite" aria-relevant="additions" class="consultation-messages" @if($messages->isEmpty()) hidden @endif>
                @foreach($messages as $message)
                    <p data-message-id="{{ $message->id }}" class="consultation-message consultation-message--{{ $message->sender }}">{{ $message->sender === 'admin' ? __('app.consultation_admin_label') : __('app.you') }}: {{ $message->message }}</p>
                @endforeach
            </div>
            <p data-chat-status role="status" aria-live="polite" hidden class="consultation-status"><span aria-hidden="true">● ● ●</span> {{ __('app.ai_typing') }}</p>
            <p data-chat-success role="status" aria-live="polite" hidden class="consultation-status"></p>

            @auth
            <form data-consultation-form data-requires-network
                  data-endpoint="{{ route('consultation.chat') }}"
                  data-messages-endpoint="{{ route('consultation.messages') }}"
                  data-offline-message="{{ __('app.offline_chat') }}"
                  data-error-message="{{ __('app.ai_error') }}"
                  data-success-message="{{ __('app.consultation_sent_to_admin') }}"
                  data-new-reply-message="{{ __('app.consultation_new_reply') }}"
                  data-expiry-message="{{ __('app.consultation_expiry_notice') }}"
                  data-you-label="{{ __('app.you') }}"
                  data-assistant-label="{{ __('app.consultation_admin_label') }}"
                  class="consultation-form">
                <label for="consultation-message" class="sr-only">{{ __('app.consultation_prompt') }}</label>
                <textarea id="consultation-message" name="message" rows="4" maxlength="4000" required placeholder="{{ __('app.consultation_prompt') }}"></textarea>
                <button type="submit" class="btn btn-primary">{{ __('app.send') }}</button>
                <p data-chat-error role="alert" hidden class="consultation-error"></p>
            </form>
            <p class="consultation-retention-notice">{{ __('app.consultation_expiry_notice') }}</p>
            @else
                <p class="disclaimer-box"><a href="{{ route('login') }}">{{ __('app.login') }}</a> {{ __('app.login_to_consult') }}</p>
            @endauth
        </div>
    </section>
</main>
@endsection
