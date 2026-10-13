@extends('layouts.app')

@section('title', __('app.mental_quiz_title'))

@section('content')
<header class="page-header">
    <h1>{{ __('app.mental_quiz_title') }}</h1>
    <p>{{ __('app.mental_quiz_subtitle') }}</p>
</header>
<main class="section">
    <div class="section-inner" style="max-width:760px">
        <p class="disclaimer-box">{{ __('app.mental_quiz_disclaimer') }}</p>
        <label for="quiz-type" style="display:block;font-weight:700;margin:1rem 0 .4rem">{{ __('app.quiz_choose_topic') }}</label>
        <select id="quiz-type" style="padding:.7rem;border:1px solid var(--slate-300);border-radius:.5rem;background:var(--white);color:var(--slate-800)">
            <option value="stress">{{ __('app.quiz_stress') }}</option>
            <option value="anxiety">{{ __('app.quiz_anxiety') }}</option>
            <option value="sleep">{{ __('app.quiz_sleep') }}</option>
        </select>
        <section class="card" data-mental-quiz data-question-count="5" data-current-question="0" data-answers="[]"
                 data-questions="{{ json_encode(__('app.quiz_questions.stress'), JSON_HEX_APOS | JSON_HEX_QUOT) }}"
                 data-label-low="{{ __('app.risk_low') }}" data-label-moderate="{{ __('app.risk_moderate') }}" data-label-high="{{ __('app.risk_high') }}"
                 data-description-low="{{ __('app.quiz_result_low') }}" data-description-moderate="{{ __('app.quiz_result_moderate') }}" data-description-high="{{ __('app.quiz_result_high') }}"
                 data-next-low="{{ __('app.quiz_next_low') }}" data-next-moderate="{{ __('app.quiz_next_moderate') }}" data-next-high="{{ __('app.quiz_next_high') }}"
                 style="padding:clamp(1.25rem,4vw,2rem);margin-top:1rem">
            <label for="quiz-progress">{{ __('app.quiz_progress') }}</label>
            <progress id="quiz-progress" data-quiz-progress value="1" max="5" style="width:100%;height:.8rem" aria-valuetext="1/5"></progress>
            <div data-quiz-content style="margin-top:1rem"></div>
            <section data-quiz-result aria-live="polite" hidden style="margin-top:1.5rem">
                <h2 class="section-title">{{ __('app.quiz_result') }}</h2>
                <p style="margin:.7rem 0"><strong>{{ __('app.quiz_score') }}:</strong> <span data-quiz-score></span></p>
                <p><strong>{{ __('app.quiz_category') }}:</strong> <span data-quiz-category></span></p>
                <p data-quiz-explanation style="margin-top:.5rem"></p>
                <p data-quiz-next style="margin-top:.5rem"></p>
                <div data-quiz-emergency hidden class="disclaimer-box result-emergency-panel" role="alert">
                    <strong>{{ __('app.quiz_emergency') }}</strong>
                    <p>{{ __('app.quiz_emergency_info') }}</p>
                    <div class="result-emergency-actions">
                        <a href="tel:119" class="btn btn-danger">{{ __('app.emergency_call') }} 119</a>
                        <a href="https://www.intothelightid.org/layanan/" target="_blank" rel="noopener noreferrer" class="btn btn-outline">{{ __('app.mental_support') }}</a>
                    </div>
                </div>
                <button type="button" data-quiz-restart class="btn btn-outline" style="margin-top:1rem">{{ __('app.quiz_restart') }}</button>
            </section>
        </section>
    </div>
</main>
@push('scripts')
<script data-page-script>
(() => {
    const quiz = document.querySelector('[data-mental-quiz]');
    const selector = document.getElementById('quiz-type');
    if (!quiz || !selector) return;
    const questions = @json(__('app.quiz_questions'));
    selector.addEventListener('change', () => {
        quiz.dataset.questions = JSON.stringify(questions[selector.value]);
        quiz.dataset.currentQuestion = '0';
        quiz.dataset.answers = '[]';
        quiz.querySelector('[data-quiz-content]').hidden = false;
        quiz.querySelector('[data-quiz-result]').hidden = true;
        render();
    });
    const render = () => {
        const qs = JSON.parse(quiz.dataset.questions);
        const index = Number(quiz.dataset.currentQuestion);
        const progress = quiz.querySelector('[data-quiz-progress]');
        progress.value = index + 1;
        progress.max = qs.length;
        progress.setAttribute('aria-valuetext', `${index + 1}/${qs.length}`);
        const content = quiz.querySelector('[data-quiz-content]');
        content.replaceChildren();
        const heading = document.createElement('h2');
        heading.textContent = qs[index].question;
        content.append(heading);
        qs[index].answers.forEach((answer, score) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'btn btn-outline';
            button.dataset.quizOption = String(score);
            button.style.cssText = 'display:flex;width:100%;text-align:left;margin:.6rem 0';
            button.textContent = answer;
            content.append(button);
        });
    };
    render();
})();
</script>
@endpush
@endsection
