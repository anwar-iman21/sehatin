@extends('layouts.app')

@section('title', __('app.offline_title'))

@section('content')
<main class="section">
    <section class="empty-state" role="status">
        <i class="fas fa-wifi" aria-hidden="true"></i>
        <h1>{{ __('app.offline_title') }}</h1>
        <p>{{ __('app.offline_message') }}</p>
        <a class="btn btn-primary" href="{{ route('home') }}">{{ __('app.back_to_home') }}</a>
    </section>
</main>
@endsection
