@extends('layouts.app')

@section('title', __('app.bmi_title'))

@section('content')
<header class="page-header">
    <h1>{{ __('app.bmi_title') }}</h1>
    <p>{{ __('app.bmi_subtitle') }}</p>
</header>
<main class="section" aria-labelledby="bmi-heading">
    <div class="section-inner" style="max-width:760px">
        <section class="card" style="padding:clamp(1.25rem,4vw,2.5rem)">
            <h2 id="bmi-heading" class="section-title">{{ __('app.bmi_calculate') }}</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-top:1.5rem">
                <div>
                    <label for="bmi-weight" style="display:block;font-weight:600;margin-bottom:.35rem">{{ __('app.weight_kg') }}</label>
                    <input id="bmi-weight" type="number" min="2" max="500" step="0.1" inputmode="decimal" required
                           aria-describedby="bmi-weight-help bmi-error"
                           style="width:100%;padding:.8rem;border:1px solid var(--slate-300);border-radius:.5rem;background:var(--white);color:var(--slate-800)">
                    <small id="bmi-weight-help">{{ __('app.weight_help') }}</small>
                </div>
                <div>
                    <label for="bmi-height" style="display:block;font-weight:600;margin-bottom:.35rem">{{ __('app.height_cm') }}</label>
                    <input id="bmi-height" type="number" min="50" max="250" step="0.1" inputmode="decimal" required
                           aria-describedby="bmi-height-help bmi-error"
                           style="width:100%;padding:.8rem;border:1px solid var(--slate-300);border-radius:.5rem;background:var(--white);color:var(--slate-800)">
                    <small id="bmi-height-help">{{ __('app.height_help') }}</small>
                </div>
            </div>
            <p id="bmi-error" role="alert" style="color:#b91c1c;margin-top:.75rem" hidden>{{ __('app.bmi_invalid') }}</p>
            <button id="bmi-calculate" type="button" class="btn btn-primary" style="margin-top:1rem">{{ __('app.bmi_calculate') }}</button>
            <section id="bmi-result" aria-live="polite" aria-atomic="true" hidden style="margin-top:2rem;padding:1.2rem;border-radius:.75rem;background:var(--slate-50)">
                <p>{{ __('app.bmi_result') }}</p>
                <p><strong id="bmi-value" style="font-size:2.3rem;color:var(--green-700)"></strong> <span id="bmi-category" style="font-weight:700"></span></p>
                <div role="img" aria-label="{{ __('app.bmi_scale') }}" style="position:relative;height:1rem;margin:1rem 0 .35rem;border-radius:999px;background:linear-gradient(to right,#3b82f6 0 28.33%,#22c55e 28.33% 50%,#f59e0b 50% 66.67%,#ef4444 66.67% 100%)">
                    <span id="bmi-indicator" style="position:absolute;top:50%;width:1rem;height:1.5rem;transform:translate(-50%,-50%);background:white;border:3px solid #111827;border-radius:.3rem"></span>
                </div>
                <p id="bmi-tip" style="margin-top:.7rem"></p>
                <p style="margin-top:1rem;font-size:.85rem;color:var(--slate-600)">{{ __('app.bmi_disclaimer') }}</p>
            </section>
        </section>
    </div>
</main>
@push('scripts')
<script>
(() => {
    const weight = document.getElementById('bmi-weight');
    const height = document.getElementById('bmi-height');
    const error = document.getElementById('bmi-error');
    const result = document.getElementById('bmi-result');
    const labels = @json(__('app.bmi_categories'));
    const tips = @json(__('app.bmi_tips'));
    document.getElementById('bmi-calculate').addEventListener('click', () => {
        const kg = Number(weight.value);
        const metres = Number(height.value) / 100;
        const valid = weight.value !== '' && height.value !== '' &&
            Number.isFinite(kg) && Number.isFinite(metres) &&
            kg >= 2 && kg <= 500 && metres >= .5 && metres <= 2.5;
        error.hidden = valid;
        result.hidden = !valid;
        weight.setAttribute('aria-invalid', String(!valid));
        height.setAttribute('aria-invalid', String(!valid));
        if (!valid) return;

        const bmi = kg / (metres * metres);
        const category = bmi < 18.5 ? 0 : bmi < 25 ? 1 : bmi < 30 ? 2 : 3;
        document.getElementById('bmi-value').textContent = bmi.toFixed(1);
        document.getElementById('bmi-category').textContent = labels[category];
        document.getElementById('bmi-tip').textContent = tips[category];
        document.getElementById('bmi-indicator').style.left = `${Math.max(2, Math.min(98, ((bmi - 10) / 30) * 100))}%`;
    });
})();
</script>
@endpush
@endsection
