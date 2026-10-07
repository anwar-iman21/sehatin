@extends('admin.layouts.app')
@section('title', __('admin.edit_category'))
@section('page-title', __('admin.edit_category'))

@section('content')
@if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="form-card" style="max-width:680px">
    <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">{{ __('admin.category_name') }} *</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $kategori->name) }}" required>
        </div>
        <div class="form-group">
            <label class="form-label">{{ __('admin.category_desc') }}</label>
            <textarea name="description" class="form-control" rows="3" style="min-height:80px">{{ old('description', $kategori->description) }}</textarea>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label class="form-label">{{ __('admin.category_icon') }}</label>
                <input type="text" name="icon" class="form-control" value="{{ old('icon', $kategori->icon) }}" placeholder="fas fa-heartbeat">
                <p class="form-hint">Class Font Awesome, contoh: <code>fas fa-heartbeat</code></p>
            </div>
            <div class="form-group">
                <label class="form-label">{{ __('admin.category_order') }}</label>
                <input type="number" name="order" class="form-control" value="{{ old('order', $kategori->order) }}" min="0">
            </div>
        </div>
        <div class="form-group" style="margin-bottom:0">
            <label class="form-check">
                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $kategori->is_featured) ? 'checked' : '' }}>
                {{ __('admin.category_featured') }}
            </label>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> {{ __('admin.cancel') }}</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('admin.update') }}</button>
        </div>
    </form>
</div>
@endsection
