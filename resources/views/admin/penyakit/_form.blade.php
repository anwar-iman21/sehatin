@if($errors->any())
    <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i><ul style="margin:0;padding-left:1rem">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
@endif
<form action="{{ $isEdit ? route('admin.penyakit.update', $disease) : route('admin.penyakit.store') }}" method="POST">
    @csrf
    @if($isEdit) @method('PUT') @endif
    <div class="form-card" style="max-width:1000px">
        <div class="form-row">
            <div class="form-group"><label class="form-label" for="name">Nama penyakit *</label><input id="name" name="name" class="form-control" value="{{ old('name', $disease->name ?? '') }}" required maxlength="255"></div>
            <div class="form-group"><label class="form-label" for="category">Kategori (opsional)</label><input id="category" name="category" class="form-control" value="{{ old('category', $disease->category ?? '') }}" placeholder="Contoh: kesehatan-umum"></div>
        </div>
        <div class="form-group"><label class="form-label" for="overview">Gambaran umum *</label><textarea id="overview" name="overview" class="form-control" rows="4" required>{{ old('overview', $disease->overview ?? '') }}</textarea></div>
        @foreach(['symptoms' => 'Gejala', 'causes' => 'Penyebab', 'risk_factors' => 'Faktor risiko', 'diagnosis' => 'Diagnosis', 'treatment' => 'Pengobatan', 'prevention' => 'Pencegahan', 'when_to_see_doctor' => 'Kapan harus ke dokter'] as $field => $label)
            <div class="form-group"><label class="form-label" for="{{ $field }}">{{ $label }}</label><textarea id="{{ $field }}" name="{{ $field }}" class="form-control" rows="3">{{ old($field, $disease->$field ?? '') }}</textarea></div>
        @endforeach
        <div class="form-group"><label class="form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $disease->is_active ?? true))> Tampilkan di halaman publik</label></div>
        <div class="form-actions"><a href="{{ route('admin.penyakit.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Batal</a><button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> {{ $isEdit ? 'Simpan Perubahan' : 'Simpan Penyakit' }}</button></div>
    </div>
</form>
