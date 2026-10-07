@extends('admin.layouts.app')
@section('title', __('admin.edit_page') . ' — ' . $halaman->title)
@section('page-title', __('admin.edit_page') . ': ' . $halaman->title)

@section('content')
@if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<div class="form-card" style="max-width:800px">
    <form action="{{ route('admin.halaman.update', $halaman) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group">
            <label class="form-label">{{ __('admin.page_title') }} *</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $halaman->title) }}" required>
        </div>
        <div style="margin-bottom:.75rem;padding:.75rem 1rem;background:var(--slate-50);border-radius:.5rem;font-size:.825rem;color:var(--slate-600)">
            <i class="fas fa-info-circle" style="color:var(--green-600)"></i>
            URL halaman: <code style="font-family:monospace;background:var(--slate-200);padding:.1rem .4rem;border-radius:.3rem">/{{ $halaman->slug }}</code>
        </div>
        <div class="form-group" style="margin:0">
            @include('admin.artikel._content-editor', [
                'label' => __('admin.page_content'),
                'content' => old('content', $halaman->content),
            ])
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.halaman.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> {{ __('admin.cancel') }}</a>
            <a href="/{{ $halaman->slug }}" target="_blank" class="btn btn-outline"><i class="fas fa-eye"></i> Preview</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> {{ __('admin.update') }}</button>
        </div>
    </form>
</div>
@endsection
