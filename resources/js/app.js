import './bootstrap';

const preferenceKey = 'sehatin-accessibility-preferences-v1';
const languageKey = 'sehatin-locale-v1';
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
let searchSuggestionTimer;

function readPreferences() {
    try {
        const saved = JSON.parse(localStorage.getItem(preferenceKey) || '{}');
        return {
            theme: ['system', 'light', 'dark'].includes(saved.theme) ? saved.theme : 'system',
            fontSize: ['small', 'normal', 'large'].includes(saved.fontSize) ? saved.fontSize : 'normal',
            dataSaver: saved.dataSaver === true,
        };
    } catch (error) {
        console.error('Unable to read accessibility preferences.', error);
        return { theme: 'system', fontSize: 'normal', dataSaver: false };
    }
}

function savePreferences(preferences) {
    try {
        localStorage.setItem(preferenceKey, JSON.stringify(preferences));
    } catch (error) {
        console.error('Unable to save accessibility preferences.', error);
    }
}

function applyPreferences() {
    const preferences = readPreferences();
    const systemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const dark = preferences.theme === 'dark' || (preferences.theme === 'system' && systemDark);

    document.documentElement.dataset.theme = dark ? 'dark' : 'light';
    document.documentElement.dataset.fontSize = preferences.fontSize;
    document.documentElement.dataset.dataSaver = String(preferences.dataSaver);
    document.querySelectorAll('img').forEach(image => {
        if (preferences.dataSaver && !image.hasAttribute('loading')) {
            image.loading = 'lazy';
            image.fetchPriority = 'low';
        }
    });

    document.querySelectorAll('[data-theme-toggle]').forEach(button => {
        button.setAttribute('aria-pressed', String(dark));
        button.setAttribute('aria-label', button.dataset.label);
    });
    document.querySelectorAll('[data-data-saver-toggle]').forEach(button => {
        button.setAttribute('aria-pressed', String(preferences.dataSaver));
    });
    document.querySelectorAll('button[data-font-size]').forEach(button => {
        button.setAttribute('aria-pressed', String(button.dataset.fontSize === preferences.fontSize));
    });
}

function initializeLocaleFromStorage() {
    try {
        const locale = localStorage.getItem(languageKey);
        if (locale && ['id', 'en'].includes(locale) && locale !== document.documentElement.lang) {
            switchLanguage(locale, document.querySelector(`a[data-locale="${locale}"]`));
        }
    } catch (error) {
        console.error('Unable to read language preference.', error);
    }
}

async function switchLanguage(locale, link) {
    if (!['id', 'en'].includes(locale) || link?.dataset.switching === 'true') return;

    if (link) {
        link.dataset.switching = 'true';
        link.setAttribute('aria-busy', 'true');
    }

    try {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        const updateResponse = await fetch(link?.dataset.localeUpdate || `/lang/${locale}`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': token || '',
            },
            body: '{}',
            credentials: 'same-origin',
        });

        if (!updateResponse.ok) {
            throw new Error(`Language preference could not be saved (${updateResponse.status}).`);
        }

        const pageResponse = await fetch(window.location.href, {
            cache: 'no-store',
            credentials: 'same-origin',
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });
        if (!pageResponse.ok) {
            throw new Error(`The translated page could not be loaded (${pageResponse.status}).`);
        }

        const nextPage = new DOMParser().parseFromString(await pageResponse.text(), 'text/html');
        const scripts = [...nextPage.body.querySelectorAll('script:not([src])')];
        nextPage.body.querySelectorAll('script').forEach(script => script.remove());
        document.body.replaceChildren(...[...nextPage.body.childNodes].map(node => document.importNode(node, true)));
        document.documentElement.lang = locale;
        document.documentElement.dataset.languageChangeFailed =
            nextPage.documentElement.dataset.languageChangeFailed || document.documentElement.dataset.languageChangeFailed;
        document.title = nextPage.title;
        const themeColor = nextPage.querySelector('meta[name="theme-color"]')?.content;
        const currentThemeColor = document.querySelector('meta[name="theme-color"]');
        if (themeColor && currentThemeColor) currentThemeColor.content = themeColor;

        const nextDescription = nextPage.querySelector('meta[name="description"]')?.content;
        const currentDescription = document.querySelector('meta[name="description"]');
        if (nextDescription && currentDescription) currentDescription.content = nextDescription;

        scripts.forEach(source => {
            const script = document.createElement('script');
            [...source.attributes].forEach(attribute => script.setAttribute(attribute.name, attribute.value));
            script.textContent = source.textContent;
            document.body.append(script);
        });

        localStorage.setItem(languageKey, locale);
        window.dispatchEvent(new Event('sehatin:page-updated'));
    } catch (error) {
        console.error('Unable to change language.', error);
        window.alert(document.documentElement.dataset.languageChangeFailed || error.message);
    } finally {
        if (link) {
            delete link.dataset.switching;
            link.removeAttribute('aria-busy');
        }
    }
}

function initializePageHeaderAnimation() {
    if (reducedMotion.matches) return;

    document.querySelectorAll('.page-header p').forEach(subtitle => {
        if (subtitle.dataset.animated) return;
        subtitle.classList.add('page-header-typed');

        const text = Array.from(subtitle.textContent.trim());
        if (text.length === 0) return;
        subtitle.setAttribute('aria-label', text.join(''));
        subtitle.setAttribute('aria-live', 'off');
        if (readPreferences().dataSaver) return;

        subtitle.dataset.animated = 'true';
        let characterIndex = 0;
        let deleting = false;
        subtitle.textContent = '';
        const typeNextCharacter = () => {
            if (!subtitle.isConnected) return;
            if (readPreferences().dataSaver) {
                window.setTimeout(typeNextCharacter, 120);
                return;
            }

            characterIndex += deleting ? -1 : 1;
            subtitle.textContent = text.slice(0, characterIndex).join('');
            let delay = deleting ? 22 : 34;
            if (characterIndex === text.length) {
                deleting = true;
                delay = 1200;
            } else if (characterIndex === 0) {
                deleting = false;
                delay = 450;
            }
            window.setTimeout(typeNextCharacter, delay);
        };
        window.setTimeout(typeNextCharacter, 320);
    });
}

function initializeAccessibilityHover() {
    const hoverDevices = window.matchMedia('(hover: hover) and (pointer: fine)');
    document.querySelectorAll('.accessibility-menu, .user-menu').forEach(menu => {
        if (menu.dataset.hoverInitialized) return;
        menu.dataset.hoverInitialized = 'true';
        if (!hoverDevices.matches) return;

        menu.addEventListener('pointerenter', event => {
            if (event.pointerType !== 'touch') menu.open = true;
        });
        menu.addEventListener('pointerleave', () => {
            if (!menu.contains(document.activeElement)) menu.open = false;
        });
        menu.addEventListener('focusin', () => { menu.open = true; });
        menu.addEventListener('focusout', () => {
            window.setTimeout(() => {
                if (!menu.contains(document.activeElement) && !menu.matches(':hover')) menu.open = false;
            }, 0);
        });
        menu.querySelector('summary')?.addEventListener('click', event => {
            event.preventDefault();
            menu.open = true;
        });
    });
}

function initializeFilterSelects() {
    document.querySelectorAll('select.filter-select').forEach((select, selectIndex) => {
        if (select.dataset.customized === 'true') return;

        const selectId = select.id || `filter-select-${selectIndex + 1}`;
        const control = document.createElement('div');
        control.className = 'filter-select-control';
        control.dataset.open = 'false';
        select.parentNode.insertBefore(control, select);
        control.append(select);

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'filter-select filter-select-trigger';
        trigger.id = `${selectId}-trigger`;
        trigger.setAttribute('role', 'combobox');
        trigger.setAttribute('aria-haspopup', 'listbox');
        trigger.setAttribute('aria-expanded', 'false');
        trigger.setAttribute('aria-controls', `${selectId}-options`);
        trigger.setAttribute('aria-label', select.getAttribute('aria-label') || [...select.labels].map(label => label.textContent.trim()).join(' ') || 'Pilihan');

        const options = document.createElement('div');
        options.className = 'filter-select-options';
        options.id = `${selectId}-options`;
        options.setAttribute('role', 'listbox');
        options.hidden = true;
        control.dataset.optionsId = options.id;

        select.classList.remove('filter-select');
        select.classList.add('filter-select-native');
        select.dataset.customized = 'true';
        select.tabIndex = -1;
        select.setAttribute('aria-hidden', 'true');
        control.append(trigger);
        document.body.append(options);

        [...select.labels].forEach(label => {
            if (label.htmlFor === select.id) label.htmlFor = trigger.id;
        });

        const items = [...select.options].map((option, optionIndex) => {
            const item = document.createElement('div');
            item.className = 'filter-select-option';
            item.id = `${selectId}-option-${optionIndex}`;
            item.setAttribute('role', 'option');
            item.setAttribute('aria-selected', String(option.selected));
            item.setAttribute('aria-disabled', String(option.disabled));
            item.textContent = option.textContent.trim();
            item.addEventListener('click', () => {
                if (option.disabled) return;
                select.selectedIndex = optionIndex;
                select.dispatchEvent(new Event('input', { bubbles: true }));
                select.dispatchEvent(new Event('change', { bubbles: true }));
                closeMenu();
                trigger.focus();
            });
            options.append(item);
            return item;
        });

        let activeIndex = Math.max(0, select.selectedIndex);
        const syncSelection = () => {
            const selected = select.options[select.selectedIndex];
            trigger.textContent = selected?.textContent.trim() || '';
            trigger.setAttribute('aria-valuetext', trigger.textContent);
            items.forEach((item, index) => item.setAttribute('aria-selected', String(index === select.selectedIndex)));
        };
        const setActive = index => {
            const enabledIndices = items
                .map((item, itemIndex) => item.getAttribute('aria-disabled') !== 'true' ? itemIndex : -1)
                .filter(itemIndex => itemIndex !== -1);
            if (!enabledIndices.length) return;
            let nextIndex = index;
            while (!enabledIndices.includes(nextIndex)) {
                nextIndex = (nextIndex + (index >= activeIndex ? 1 : -1) + items.length) % items.length;
            }
            activeIndex = nextIndex;
            trigger.setAttribute('aria-activedescendant', items[activeIndex].id);
            items.forEach((item, itemIndex) => item.dataset.active = String(itemIndex === activeIndex));
            items[activeIndex].scrollIntoView({ block: 'nearest' });
        };
        const closeMenu = () => {
            options.hidden = true;
            control.dataset.open = 'false';
            trigger.setAttribute('aria-expanded', 'false');
            trigger.removeAttribute('aria-activedescendant');
        };
        const openMenu = () => {
            document.querySelectorAll('.filter-select-control[data-open="true"]').forEach(openControl => {
                if (openControl !== control) {
                    const openOptions = document.getElementById(openControl.dataset.optionsId);
                    if (openOptions) openOptions.hidden = true;
                    openControl.dataset.open = 'false';
                    openControl.querySelector('.filter-select-trigger').setAttribute('aria-expanded', 'false');
                }
            });
            options.hidden = false;
            control.dataset.open = 'true';
            trigger.setAttribute('aria-expanded', 'true');
            activeIndex = Math.max(0, select.selectedIndex);

            const rect = trigger.getBoundingClientRect();
            const menuWidth = Math.min(rect.width, Math.max(0, window.innerWidth - 24));
            const left = Math.min(Math.max(12, rect.left), window.innerWidth - menuWidth - 12);
            const below = window.innerHeight - rect.bottom - 12;
            const above = rect.top - 12;
            const placeAbove = below < 180 && above > below;
            const availableHeight = Math.max(0, placeAbove ? above : below);
            const menuHeight = Math.min(256, availableHeight);

            options.style.left = `${left}px`;
            options.style.width = `${menuWidth}px`;
            options.style.maxHeight = `${menuHeight}px`;
            options.style.top = `${placeAbove ? Math.max(12, rect.top - menuHeight - 4) : rect.bottom + 4}px`;
            setActive(activeIndex);
        };

        trigger.addEventListener('click', () => {
            if (options.hidden) openMenu();
            else closeMenu();
        });
        trigger.addEventListener('keydown', event => {
            if (event.key === 'Escape') {
                if (!options.hidden) {
                    event.preventDefault();
                    closeMenu();
                }
                return;
            }
            if (event.key === 'Tab') {
                closeMenu();
                return;
            }
            if (['ArrowDown', 'ArrowUp', 'Home', 'End', 'Enter', ' '].includes(event.key)) {
                event.preventDefault();
                const wasOpen = !options.hidden;
                if (options.hidden) openMenu();
                if (event.key === 'ArrowDown') setActive((activeIndex + 1) % items.length);
                else if (event.key === 'ArrowUp') setActive((activeIndex - 1 + items.length) % items.length);
                else if (event.key === 'Home') setActive(0);
                else if (event.key === 'End') setActive(items.length - 1);
                else if ((event.key === 'Enter' || event.key === ' ') && wasOpen) {
                    const activeItem = items[activeIndex];
                    if (activeItem && activeItem.getAttribute('aria-disabled') !== 'true') activeItem.click();
                }
            }
        });
        select.addEventListener('change', syncSelection);
        syncSelection();
    });
}

function initializePageInteractions() {
    applyPreferences();
    initializePageHeaderAnimation();
    initializeAccessibilityHover();
    initializeFilterSelects();
    initializeConsultationPolling();

    const cookieConsent = document.getElementById('cookie-consent');
    if (cookieConsent) {
        try {
            const saved = localStorage.getItem('sehatin-cookie-consent-v1');
            if (!saved) cookieConsent.hidden = false;
            else {
                const consent = JSON.parse(saved);
                if (consent.version !== 1 || typeof consent.optional !== 'boolean') cookieConsent.hidden = false;
            }
        } catch (error) {
            console.error('Unable to read cookie preferences.', error);
            cookieConsent.hidden = false;
        }
    }

}

document.addEventListener('click', event => {
    if (event.target.closest('.filter-select-control, .filter-select-options')) return;
    document.querySelectorAll('.filter-select-control[data-open="true"]').forEach(control => {
        const options = document.getElementById(control.dataset.optionsId);
        if (options) options.hidden = true;
        control.dataset.open = 'false';
        control.querySelector('.filter-select-trigger').setAttribute('aria-expanded', 'false');
    });
});

document.addEventListener('click', event => {
    const menu = document.getElementById('navMenu');
    const navToggle = document.getElementById('navToggle');
    if (event.target.closest('#navToggle') && menu && navToggle) {
        const open = menu.classList.toggle('open');
        navToggle.setAttribute('aria-expanded', String(open));
        return;
    }
    if (menu?.classList.contains('open') && !menu.contains(event.target) && !navToggle?.contains(event.target)) {
        menu.classList.remove('open');
        navToggle?.setAttribute('aria-expanded', 'false');
    }

    const languageLink = event.target.closest('[data-locale]');
    if (languageLink) {
        event.preventDefault();
        switchLanguage(languageLink.dataset.locale, languageLink);
        return;
    }
    if (event.target.closest('#navMenu a')) {
        menu?.classList.remove('open');
        navToggle?.setAttribute('aria-expanded', 'false');
    }

    const faqButton = event.target.closest('.faq-q');
    if (faqButton) {
        const answer = faqButton.nextElementSibling;
        const open = faqButton.getAttribute('aria-expanded') === 'true';
        document.querySelectorAll('.faq-q').forEach(item => {
            item.setAttribute('aria-expanded', 'false');
            item.nextElementSibling?.classList.remove('open');
        });
        if (!open) {
            faqButton.setAttribute('aria-expanded', 'true');
            answer?.classList.add('open');
        }
        return;
    }

    const cookieButton = event.target.closest('[data-cookie-choice]');
    if (cookieButton) {
        try {
            localStorage.setItem('sehatin-cookie-consent-v1', JSON.stringify({
                version: 1,
                essential: true,
                optional: cookieButton.dataset.cookieChoice === 'all',
                savedAt: new Date().toISOString(),
            }));
            document.getElementById('cookie-consent').hidden = true;
        } catch (error) {
            console.error('Unable to save cookie preferences.', error);
        }
        return;
    }

    if (event.target.closest('[data-cookie-settings]')) {
        const consent = document.getElementById('cookie-consent');
        if (consent) {
            consent.hidden = false;
            consent.querySelector('[data-cookie-choice="all"]')?.focus();
        }
        return;
    }

    const themeButton = event.target.closest('[data-theme-toggle]');
    if (themeButton) {
        const preferences = readPreferences();
        preferences.theme = document.documentElement.dataset.theme === 'dark' ? 'light' : 'dark';
        savePreferences(preferences);
        applyPreferences();
        return;
    }

    const fontButton = event.target.closest('button[data-font-size]');
    if (fontButton) {
        const preferences = readPreferences();
        preferences.fontSize = fontButton.dataset.fontSize;
        savePreferences(preferences);
        applyPreferences();
        return;
    }

    const dataButton = event.target.closest('[data-data-saver-toggle]');
    if (dataButton) {
        const preferences = readPreferences();
        preferences.dataSaver = !preferences.dataSaver;
        savePreferences(preferences);
        applyPreferences();
        initializePageHeaderAnimation();
        return;
    }

    const bookmarkButton = event.target.closest('[data-bookmark-article]');
    if (bookmarkButton) {
        if (!bookmarkButton.dataset.bookmarkUrl) {
            window.location.href = bookmarkButton.dataset.loginUrl;
            return;
        }
        bookmarkButton.disabled = true;
        fetch(bookmarkButton.dataset.bookmarkUrl, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
        }).then(async response => {
            if (!response.ok) throw new Error(`Bookmark update failed (${response.status}).`);
            const data = await response.json();
            bookmarkButton.dataset.bookmarked = String(data.bookmarked);
            bookmarkButton.setAttribute('aria-pressed', String(data.bookmarked));
            bookmarkButton.querySelector('span').textContent = data.bookmarked
                ? bookmarkButton.dataset.savedLabel
                : bookmarkButton.dataset.saveLabel;
        }).catch(error => {
            console.error('Unable to update saved article.', error);
            window.alert(bookmarkButton.dataset.errorMessage);
        }).finally(() => { bookmarkButton.disabled = false; });
        return;
    }

    const listenButton = event.target.closest('[data-speak-article]');
    if (listenButton && 'speechSynthesis' in window) {
        if (listenButton.getAttribute('aria-pressed') === 'true') {
            window.speechSynthesis.cancel();
            listenButton.setAttribute('aria-pressed', 'false');
            return;
        }
        const article = document.querySelector('.article-body');
        if (!article) return;
        window.speechSynthesis.cancel();
        const utterance = new SpeechSynthesisUtterance(article.innerText);
        utterance.lang = document.documentElement.lang === 'en' ? 'en-US' : 'id-ID';
        utterance.onend = () => {
            listenButton.setAttribute('aria-pressed', 'false');
        };
        utterance.onerror = () => {
            listenButton.setAttribute('aria-pressed', 'false');
        };
        window.speechSynthesis.speak(utterance);
        listenButton.setAttribute('aria-pressed', 'true');
        return;
    }

    const stopButton = event.target.closest('[data-stop-article]');
    if (stopButton && 'speechSynthesis' in window) {
        window.speechSynthesis.cancel();
        const listeningButton = document.querySelector('[data-speak-article]');
        if (listeningButton) {
            listeningButton.setAttribute('aria-pressed', 'false');
        }
        return;
    }

    const quizOption = event.target.closest('[data-quiz-option]');
    if (quizOption) {
        const quiz = document.querySelector('[data-mental-quiz]');
        if (!quiz) return;
        const total = Number(quiz.dataset.questionCount);
        const question = Number(quiz.dataset.currentQuestion);
        const answers = JSON.parse(quiz.dataset.answers || '[]');
        answers[question] = Number(quizOption.dataset.quizOption);
        quiz.dataset.answers = JSON.stringify(answers);
        quiz.querySelectorAll('[data-quiz-error]').forEach(error => { error.hidden = true; });
        if (question + 1 < total) {
            quiz.dataset.currentQuestion = String(question + 1);
            renderQuizQuestion(quiz);
        } else {
            renderQuizResult(quiz, answers);
        }
    }

    if (event.target.closest('[data-quiz-restart]')) {
        const quiz = document.querySelector('[data-mental-quiz]');
        if (quiz) {
            quiz.dataset.currentQuestion = '0';
            quiz.dataset.answers = '[]';
            renderQuizQuestion(quiz);
        }
    }

});

function renderQuizQuestion(quiz) {
    const questions = JSON.parse(quiz.dataset.questions);
    const index = Number(quiz.dataset.currentQuestion);
    const question = questions[index];
    const progress = quiz.querySelector('[data-quiz-progress]');
    const content = quiz.querySelector('[data-quiz-content]');
    if (progress) {
        progress.value = index + 1;
        progress.max = questions.length;
        progress.setAttribute('aria-valuetext', `${index + 1}/${questions.length}`);
    }
    if (!content) return;
    content.replaceChildren();
    const title = document.createElement('h2');
    title.textContent = question.question;
    content.append(title);
    question.answers.forEach((answer, score) => {
        const button = document.createElement('button');
        button.type = 'button';
        button.className = 'btn btn-outline';
        button.dataset.quizOption = String(score);
        button.style.cssText = 'display:flex;width:100%;text-align:left;margin:.6rem 0';
        button.textContent = answer;
        content.append(button);
    });
}

function renderQuizResult(quiz, answers) {
    const questions = JSON.parse(quiz.dataset.questions);
    const total = answers.reduce((sum, answer) => sum + answer, 0);
    const max = questions.length * (questions[0].answers.length - 1);
    const risk = total / max;
    const level = risk < .34 ? 'low' : risk < .67 ? 'moderate' : 'high';
    const result = quiz.querySelector('[data-quiz-result]');
    const form = quiz.querySelector('[data-quiz-content]');
    if (!result || !form) return;
    form.hidden = true;
    result.hidden = false;
    const labelKey = level[0].toUpperCase() + level.slice(1);
    result.querySelector('[data-quiz-score]').textContent = `${total}/${max}`;
    result.querySelector('[data-quiz-category]').textContent = quiz.dataset[`label${labelKey}`];
    result.querySelector('[data-quiz-explanation]').textContent = quiz.dataset[`description${labelKey}`];
    result.querySelector('[data-quiz-next]').textContent = quiz.dataset[`next${labelKey}`];
    result.querySelector('[data-quiz-emergency]').hidden = level !== 'high';
    const progress = quiz.querySelector('[data-quiz-progress]');
    if (progress) {
        progress.value = progress.max;
        progress.setAttribute('aria-valuetext', String(progress.max));
    }
}

async function submitConsultation(form) {
    if (!navigator.onLine) {
        const error = form.querySelector('[data-chat-error]');
        error.hidden = false;
        error.textContent = form.dataset.offlineMessage;
        return;
    }
    const input = form.querySelector('[name="message"]');
    const status = form.closest('.consultation-card')?.querySelector('[data-chat-status]') || form.querySelector('[data-chat-status]');
    const error = form.querySelector('[data-chat-error]');
    let messages = form.closest('.consultation-card')?.querySelector('[data-chat-messages]') || form.querySelector('[data-chat-messages]');
    const send = form.querySelector('[type="submit"]');
    const success = form.closest('.consultation-card')?.querySelector('[data-chat-success]');
    const text = input.value.trim();
    if (!text) return;

    if (!messages) {
        const card = form.closest('.consultation-card');
        messages = document.createElement('div');
        messages.dataset.chatMessages = 'true';
        messages.className = 'consultation-messages';
        messages.hidden = true;
        if (card) {
            card.insertBefore(messages, form);
        } else {
            form.insertBefore(messages, form.querySelector('button[type="submit"]'));
        }
    }

    messages.hidden = false;
    const userMessage = document.createElement('p');
    userMessage.className = 'consultation-message consultation-message--user';
    userMessage.textContent = `${form.dataset.youLabel}: ${text}`;
    messages.append(userMessage);
    input.value = '';
    status.hidden = false;
    error.hidden = true;
    if (success) success.hidden = true;
    send.disabled = true;

    try {
        const response = await fetch(form.dataset.endpoint, {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
            },
            body: JSON.stringify({ message: text }),
        });
        const data = await response.json();
        if (!response.ok) throw new Error(data.message || `${form.dataset.errorMessage} (${response.status})`);
        if (!data.message?.id) throw new Error(form.dataset.errorMessage);
        userMessage.dataset.messageId = String(data.message.id);
        messages.dataset.lastMessageId = String(Math.max(Number(messages.dataset.lastMessageId || 0), Number(data.message.id)));
        if (success) {
            success.textContent = form.dataset.successMessage;
            success.hidden = false;
        }
    } catch (reason) {
        userMessage.remove();
        if (!input.value) input.value = text;
        error.textContent = reason.message || form.dataset.errorMessage;
        error.hidden = false;
    } finally {
        status.hidden = true;
        send.disabled = false;
        input.focus();
    }
}

function initializeConsultationPolling() {
    const form = document.querySelector('[data-consultation-form]');
    const messages = document.querySelector('[data-chat-messages]');
    if (!form || !messages || messages.dataset.pollInitialized) return;

    messages.dataset.pollInitialized = 'true';
    window.setInterval(async () => {
        if (document.visibilityState !== 'visible') return;
        const after = Number(messages.dataset.lastMessageId || 0);

        try {
            const response = await fetch(`${form.dataset.messagesEndpoint}?after=${after}`, {
                headers: { Accept: 'application/json' },
                cache: 'no-store',
            });
            if (!response.ok) return;
            const data = await response.json();
            if (data.reset) {
                messages.replaceChildren();
                messages.dataset.lastMessageId = '0';
                messages.hidden = (data.messages || []).length === 0;
                const success = form.closest('.consultation-card')?.querySelector('[data-chat-success]');
                if (success) {
                    success.textContent = form.dataset.expiryMessage;
                    success.hidden = false;
                }
            }
            for (const message of data.messages || []) {
                const messageId = Number(message.id);
                if (messageId <= Number(messages.dataset.lastMessageId || 0)) continue;
                const reply = document.createElement('p');
                const isAdmin = message.sender === 'admin';
                reply.className = `consultation-message consultation-message--${isAdmin ? 'admin' : 'user'}`;
                reply.dataset.messageId = String(messageId);
                reply.textContent = `${isAdmin ? form.dataset.assistantLabel : form.dataset.youLabel}: ${message.message}`;
                messages.append(reply);
                messages.dataset.lastMessageId = String(messageId);
                messages.hidden = false;

                const success = form.closest('.consultation-card')?.querySelector('[data-chat-success]');
                if (success && isAdmin) {
                    success.textContent = form.dataset.newReplyMessage;
                    success.hidden = false;
                }
            }
            messages.scrollTop = messages.scrollHeight;
        } catch (error) {
            console.error('Unable to check consultation replies.', error);
        }
    }, 1000);
}

document.addEventListener('keydown', event => {
    const menu = document.getElementById('navMenu');
    if (event.key === 'Escape' && menu?.classList.contains('open')) {
        menu.classList.remove('open');
        const toggle = document.getElementById('navToggle');
        toggle?.setAttribute('aria-expanded', 'false');
        toggle?.focus();
    }
});

document.addEventListener('submit', event => {
    const form = event.target.closest('[data-consultation-form]');
    if (!form) {
        if (event.target.matches('[data-requires-network]') && !navigator.onLine) {
            event.preventDefault();
            const status = document.getElementById('network-status');
            if (status) {
                status.hidden = false;
                status.focus();
            }
        }
        return;
    }
    event.preventDefault();
    submitConsultation(form);
});

document.addEventListener('click', event => {
    const link = event.target.closest('a[href]');
    if (link && !link.matches('[data-locale]') && link.origin === window.location.origin && link.pathname !== window.location.pathname) {
        document.documentElement.classList.add('is-navigating');
    }
});

window.addEventListener('online', updateNetworkStatus);
window.addEventListener('offline', updateNetworkStatus);
window.addEventListener('sehatin:page-updated', updateNetworkStatus);

function updateNetworkStatus() {
    const status = document.getElementById('network-status');
    if (status) status.hidden = navigator.onLine;
}

function registerServiceWorker() {
    if ('serviceWorker' in navigator && location.protocol !== 'file:') {
        navigator.serviceWorker.register('/sw.js').catch(error => {
            console.error('The offline service worker could not be registered.', error);
        });
    }
}

let installPrompt;
window.addEventListener('beforeinstallprompt', event => {
    event.preventDefault();
    installPrompt = event;
    document.querySelectorAll('[data-pwa-install]').forEach(button => { button.hidden = false; });
});
document.addEventListener('click', async event => {
    const button = event.target.closest('[data-pwa-install]');
    if (!button || !installPrompt) return;
    await installPrompt.prompt();
    await installPrompt.userChoice;
    installPrompt = null;
    button.hidden = true;
});

document.addEventListener('submit', event => {
    if (event.target.matches('[data-requires-network]') && !navigator.onLine) {
        event.preventDefault();
        const status = document.getElementById('network-status');
        if (status) {
            status.hidden = false;
            status.focus();
        }
    }
});

window.addEventListener('pageshow', () => document.documentElement.classList.remove('is-navigating'));
window.addEventListener('sehatin:page-updated', initializePageInteractions);
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
    if (readPreferences().theme === 'system') applyPreferences();
});

document.addEventListener('DOMContentLoaded', () => {
    initializePageInteractions();
    initializeLocaleFromStorage();
    updateNetworkStatus();
    registerServiceWorker();
});
