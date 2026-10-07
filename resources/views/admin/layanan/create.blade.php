@extends('admin.layouts.app')
@section('title', __('admin.add_service'))
@section('page-title', __('admin.add_service'))

@section('content')
@if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
@endif

<form action="{{ route('admin.layanan.store') }}" method="POST">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start">
        <div style="display:flex;flex-direction:column;gap:1.5rem">
            <div class="form-card">
                <div class="form-group">
                    <label class="form-label">{{ __('admin.service_name') }} *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('admin.service_desc') }} *</label>
                    <textarea name="description" class="form-control" rows="3" required style="min-height:80px">{{ old('description') }}</textarea>
                    <p class="form-hint">Deskripsi singkat tampil di listing. Maks. 500 karakter.</p>
                </div>
                <div class="form-group" style="margin:0">
                    @include('admin.artikel._content-editor', [
                        'label' => __('admin.service_content'),
                        'content' => old('content', ''),
                        'required' => false,
                    ])
                </div>
            </div>
        </div>

        <div style="display:flex;flex-direction:column;gap:1.25rem">
            <div class="form-card">
                <h4 style="font-size:.875rem;font-weight:700;color:var(--slate-700);margin-bottom:1rem">Pengaturan</h4>
                <div class="form-group">
                    <label class="form-label">{{ __('admin.service_icon') }}</label>
                    <input type="text" name="icon" class="form-control" value="{{ old('icon', 'fas fa-stethoscope') }}" placeholder="fas fa-stethoscope">
                    <p class="form-hint">Class Font Awesome</p>
                </div>
                <div class="form-group">
                    <label class="form-label">{{ __('admin.order') }}</label>
                    <input type="number" name="order" class="form-control" value="{{ old('order', 0) }}" min="0">
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-check">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
                        {{ __('admin.service_active') }}
                    </label>
                </div>
            </div>

            <div style="display:flex;gap:.75rem">
                <a href="{{ route('admin.layanan.index') }}" class="btn btn-outline" style="flex:1;justify-content:center"><i class="fas fa-arrow-left"></i> {{ __('admin.cancel') }}</a>
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center"><i class="fas fa-save"></i> {{ __('admin.save') }}</button>
            </div>
        </div>
    </div>
</form>

@push('styles')
<style>@media(max-width:1024px){form>div[style*="grid-template-columns"]{grid-template-columns:1fr!important}}</style>
@endpush
@endsection
