@if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif

<form action="{{ $isEdit ? route('admin.obat.update', $drug) : route('admin.obat.store') }}" method="POST">
    @csrf
    @if($isEdit) @method('PUT') @endif
    <div class="form-card" style="max-width:1000px">
        <div class="form-row">
            <div class="form-group"><label class="form-label" for="name">Nama obat *</label><input id="name" name="name" class="form-control" value="{{ old('name', $drug->name ?? '') }}" required maxlength="255"></div>
            <div class="form-group"><label class="form-label" for="generic_name">Nama generik / kandungan</label><input id="generic_name" name="generic_name" class="form-control" value="{{ old('generic_name', $drug->generic_name ?? '') }}"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label class="form-label" for="category">Kategori *</label><select id="category" name="category" class="form-control" required>@foreach($categories as $category)<option value="{{ $category }}" @selected(old('category', $drug->category ?? '') === $category)>{{ str_replace('_', ' ', ucfirst($category)) }}</option>@endforeach</select></div>
            <div class="form-group"><label class="form-label" for="form">Bentuk sediaan *</label><select id="form" name="form" class="form-control" required>@foreach($forms as $form)<option value="{{ $form }}" @selected(old('form', $drug->form ?? '') === $form)>{{ ucfirst($form) }}</option>@endforeach</select></div>
        </div>
        <div class="form-group"><label class="form-label" for="manufacturer">Produsen</label><input id="manufacturer" name="manufacturer" class="form-control" value="{{ old('manufacturer', $drug->manufacturer ?? '') }}"></div>
        <div class="form-group"><label class="form-label" for="content">Kandungan / informasi umum *</label><textarea id="content" name="content" class="form-control" rows="3" required>{{ old('content', $drug->content ?? '') }}</textarea></div>
        @foreach(['indication' => 'Indikasi', 'dosage' => 'Dosis', 'how_to_use' => 'Cara penggunaan', 'side_effects' => 'Efek samping', 'contraindication' => 'Kontraindikasi', 'warning' => 'Peringatan'] as $field => $label)
            <div class="form-group"><label class="form-label" for="{{ $field }}">{{ $label }}</label><textarea id="{{ $field }}" name="{{ $field }}" class="form-control" rows="3">{{ old($field, $drug->$field ?? '') }}</textarea></div>
        @endforeach
        <div class="form-row">
            <div class="form-group"><label class="form-label" for="price_range">Kisaran harga</label><input id="price_range" name="price_range" class="form-control" value="{{ old('price_range', $drug->price_range ?? '') }}"></div>
            <div class="form-group" style="display:flex;align-items:flex-end"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $drug->is_active ?? true))> Tampilkan di halaman publik</label></div>
        </div>
        <div class="form-actions">
            <a href="{{ route('admin.obat.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a>
            <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Obat' }}</button>
        </div>
    </div>
</form>
