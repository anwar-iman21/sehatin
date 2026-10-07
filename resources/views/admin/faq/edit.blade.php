@extends('admin.layouts.app')
@section('title', __('admin.edit_faq'))
@section('page-title', __('admin.edit_faq'))

@section('content')
@if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="form-card" style="max-width:680px">
    <form action="{{ route('admin.faq.update', $faq) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">{{ __('admin.faq_question') }} *</label>
            <input type="text" name="question" class="form-control" value="{{ old('question', $faq->question) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">{{ __('admin.faq_answer') }} *</label>
            <textarea name="answer" class="form-control" rows="6" required>{{ old('answer', $faq->answer) }}</textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ __('admin.order') }}</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $faq->order) }}" min="0">
            </div>
            <div class="form-group" style="display:flex;align-items:flex-end;padding-bottom:.2rem">
                <label class="form-check">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $faq->is_active) ? 'checked' : '' }}>
                    {{ __('admin.faq_active') }}
                </label>
            </div>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.faq.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> {{ __('admin.cancel') }}</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('admin.update') }}</button>
        </div>
    </form>
</div>
@endsection
