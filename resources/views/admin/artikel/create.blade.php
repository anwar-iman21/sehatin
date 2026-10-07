@extends('admin.layouts.app')

@section('title', __('admin.add_article'))
@section('page-title', __('admin.add_article'))

@section('content')

@if($errors->any())
    <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <ul style="margin:0;padding-left:1rem">
            @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="display:grid;grid-template-columns:1fr 320px;gap:1.5rem;align-items:start">

        {{-- MAIN --}}
        <div style="display:flex;flex-direction:column;gap:1.5rem">
            <div class="form-card">
                <div class="form-group">
                    <label class="form-label">{{ __('admin.article_title') }} *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Judul artikel...">
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">{{ __('admin.article_excerpt') }}</label>
                    <textarea name="excerpt" class="form-control" rows="3" placeholder="Ringkasan singkat artikel (muncul di listing)..." style="min-height:80px">{{ old('excerpt') }}</textarea>
                    <p class="form-hint">Maks. 500 karakter. Digunakan di listing artikel dan SEO.</p>
                </div>
            </div>

            <div class="form-card">
                @include('admin.artikel._content-editor', ['content' => old('content', '')])
            </div>
        </div>

        {{-- SIDEBAR --}}
        <div style="display:flex;flex-direction:column;gap:1.25rem">
            <div class="form-card">
                <h4 style="font-size:.875rem;font-weight:700;color:var(--slate-700);margin-bottom:1rem;padding-bottom:.6rem;border-bottom:1px solid var(--slate-100)">
                    <i class="fas fa-cog" style="color:var(--green-600)"></i> Pengaturan
                </h4>
                <div class="form-group">
                    <label class="form-label">{{ __('admin.article_status') }} *</label>
                    <select name="status" class="form-control">
                        <option value="draft" {{ old('status','draft')==='draft' ? 'selected' : '' }}>{{ __('admin.draft') }}</option>
                        <option value="published" {{ old('status')==='published' ? 'selected' : '' }}>{{ __('admin.published') }}</option>
                    </select>
                </div>
                <div class="form-group" style="margin:0">
                    <label class="form-label">{{ __('admin.article_category') }} *</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-card">
                <h4 style="font-size:.875rem;font-weight:700;color:var(--slate-700);margin-bottom:1rem;padding-bottom:.6rem;border-bottom:1px solid var(--slate-100)">
                    <i class="fas fa-image" style="color:var(--green-600)"></i> {{ __('admin.article_thumbnail') }}
                </h4>
                <input type="file" name="thumbnail" accept="image/jpg,image/jpeg,image/png,image/webp"
                    style="width:100%;font-size:.875rem"
                    onchange="previewThumb(this)">
                <div id="thumbPreview" style="margin-top:.75rem;display:none">
                    <img id="thumbImg" src="" style="width:100%;border-radius:.5rem;border:1px solid var(--slate-200)">
                </div>
                <p class="form-hint" style="margin-top:.5rem">JPG, PNG, atau WebP. Maks. 2MB.</p>
            </div>

            <div class="form-card">
                <h4 style="font-size:.875rem;font-weight:700;color:var(--slate-700);margin-bottom:1rem;padding-bottom:.6rem;border-bottom:1px solid var(--slate-100)">
                    <i class="fas fa-search" style="color:var(--green-600)"></i> SEO
                </h4>
                <div class="form-group" style="margin:0">
                    <label class="form-label">{{ __('admin.meta_description') }}</label>
                    <textarea name="meta_description" class="form-control" rows="3" style="min-height:80px" placeholder="Deskripsi untuk mesin pencari...">{{ old('meta_description') }}</textarea>
                    <p class="form-hint">Maks. 160 karakter.</p>
                </div>
            </div>

            <div style="display:flex;gap:.75rem">
                <a href="{{ route('admin.artikel.index') }}" class="btn btn-outline" style="flex:1;justify-content:center">
                    <i class="fas fa-arrow-left"></i> {{ __('admin.cancel') }}
                </a>
                <button type="submit" class="btn btn-primary" style="flex:1;justify-content:center">
                    <i class="fas fa-save"></i> {{ __('admin.save') }}
                </button>
            </div>
        </div>
    </div>
</form>

@push('scripts')
<script>
function previewThumb(input) {
    const preview = document.getElementById('thumbPreview');
    const img = document.getElementById('thumbImg');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { img.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
@push('styles')
<style>@media(max-width:1024px){form>div[style*="grid-template-columns"]{grid-template-columns:1fr!important}}</style>
@endpush
@endsection
