@if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<form action="{{ $isEdit ? route('admin.panduan.update', $guide) : route('admin.panduan.store') }}" method="POST">
    @csrf
    @if($isEdit) @method('PUT') @endif
    <div class="form-card" style="max-width:1000px">
        <div class="form-row">
            <div class="form-group"><label class="form-label" for="title">Judul *</label><input id="title" name="title" class="form-control" value="{{ old('title', $guide->title ?? '') }}" required maxlength="255"></div>
            <div class="form-group"><label class="form-label" for="category">Kategori *</label><select id="category" name="category" class="form-control" required>@foreach($categories as $category)<option value="{{ $category }}" @selected(old('category', $guide->category ?? '') === $category)>{{ ucfirst($category) }}</option>@endforeach</select></div>
        </div>
        <div class="form-group"><label class="form-label" for="excerpt">Ringkasan</label><textarea id="excerpt" name="excerpt" class="form-control" rows="2">{{ old('excerpt', $guide->excerpt ?? '') }}</textarea></div>
        <div class="form-group">
            @include('admin.artikel._content-editor', [
                'label' => 'Konten Panduan',
                'content' => old('content', $guide->content ?? ''),
            ])
        </div>
        <div class="form-row">
            <div class="form-group"><label class="form-label" for="icon">Ikon Font Awesome</label><input id="icon" name="icon" class="form-control" value="{{ old('icon', $guide->icon ?? 'fas fa-book-medical') }}" placeholder="fas fa-book-medical"></div>
            <div class="form-group"><label class="form-label" for="order">Urutan</label><input id="order" type="number" min="0" name="order" class="form-control" value="{{ old('order', $guide->order ?? 0) }}" required></div>
        </div>
        <div class="form-group"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $guide->is_active ?? true))> Tampilkan di halaman publik</label></div>
        <div class="form-actions"><a href="{{ route('admin.panduan.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a><button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Panduan' }}</button></div>
    </div>
</form>
