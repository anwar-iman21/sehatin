@php
    $isRequired = $required ?? true;
    $editorLabel = $label ?? __('admin.article_content');
@endphp

<div class="article-editor" data-article-editor>
    <label class="form-label">{{ $editorLabel }}{{ $isRequired ? ' *' : '' }}</label>
    <div class="article-editor-toolbar" role="toolbar" aria-label="Pemformatan isi artikel">
        <button type="button" data-command="bold" title="Tebal" aria-label="Tebal"><strong>B</strong></button>
        <button type="button" data-command="italic" title="Miring" aria-label="Miring"><em>I</em></button>
        <button type="button" data-command="underline" title="Garis bawah" aria-label="Garis bawah"><u>U</u></button>
        <span class="article-editor-divider" aria-hidden="true"></span>
        <button type="button" data-command="formatBlock" data-value="h2" title="Judul besar" aria-label="Judul besar">H2</button>
        <button type="button" data-command="formatBlock" data-value="h3" title="Subjudul" aria-label="Subjudul">H3</button>
        <button type="button" data-command="formatBlock" data-value="p" title="Paragraf" aria-label="Paragraf">P</button>
        <span class="article-editor-divider" aria-hidden="true"></span>
        <button type="button" data-command="insertUnorderedList" title="Daftar berpoin" aria-label="Daftar berpoin"><i class="fas fa-list-ul"></i></button>
        <button type="button" data-command="insertOrderedList" title="Daftar bernomor" aria-label="Daftar bernomor"><i class="fas fa-list-ol"></i></button>
    </div>
    <div class="article-editor-content" contenteditable="true" role="textbox" aria-multiline="true"
         aria-label="{{ $editorLabel }}" aria-required="{{ $isRequired ? 'true' : 'false' }}"
         data-placeholder="Tulis isi artikel di sini..."></div>
    <textarea name="content" class="article-editor-source" tabindex="-1" aria-hidden="true">{{ $content }}</textarea>
    <p class="form-hint" style="margin-top:.5rem">Klik area untuk menulis. Gunakan tombol di atas untuk mengatur format teks.</p>
</div>

@once
    @push('styles')
        <style>
            .article-editor-toolbar{display:flex;align-items:center;gap:.35rem;padding:.5rem;border:1px solid var(--slate-200);border-bottom:0;border-radius:.55rem .55rem 0 0;background:var(--slate-50)}
            .article-editor-toolbar button{min-width:2.25rem;height:2.1rem;padding:0 .55rem;border:1px solid transparent;border-radius:.35rem;background:transparent;color:var(--slate-700);font:inherit;cursor:pointer}
            .article-editor-toolbar button:hover,.article-editor-toolbar button:focus-visible{border-color:var(--slate-200);background:var(--white);outline:none}
            .article-editor-divider{width:1px;height:1.4rem;margin:0 .25rem;background:var(--slate-200)}
            .article-editor-content{min-height:420px;padding:.85rem .9rem;border:1.5px solid var(--slate-200);border-radius:0 0 .55rem .55rem;background:var(--white);color:var(--slate-800);font:inherit;line-height:1.7;overflow-wrap:anywhere;outline:none}
            .article-editor-content:focus{border-color:var(--green-500)}
            .article-editor-content:empty::before{content:attr(data-placeholder);color:var(--slate-400);pointer-events:none}
            .article-editor-content h2,.article-editor-content h3{margin:.75rem 0 .4rem}
            .article-editor-content p,.article-editor-content ul,.article-editor-content ol{margin:.5rem 0}
            .article-editor-content ul,.article-editor-content ol{padding-left:1.5rem}
            .article-editor-content.is-invalid{border-color:#dc2626}
            .article-editor-source{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
        </style>
    @endpush

    @push('scripts')
        <script>
            document.querySelectorAll('[data-article-editor]').forEach(wrapper => {
                const editor = wrapper.querySelector('.article-editor-content');
                const source = wrapper.querySelector('.article-editor-source');
                const form = wrapper.closest('form');
                const isRequired = editor.getAttribute('aria-required') === 'true';
                const allowedTags = new Set(['P', 'BR', 'H2', 'H3', 'H4', 'UL', 'OL', 'LI', 'STRONG', 'B', 'EM', 'I', 'U', 'BLOCKQUOTE', 'A']);
                const blockedTags = new Set(['SCRIPT', 'STYLE', 'IFRAME', 'OBJECT', 'EMBED', 'SVG', 'MATH']);

                function cleanNode(node) {
                    if (node.nodeType === Node.TEXT_NODE) {
                        return document.createTextNode(node.textContent || '');
                    }
                    if (node.nodeType !== Node.ELEMENT_NODE || blockedTags.has(node.tagName)) {
                        return document.createDocumentFragment();
                    }

                    const children = document.createDocumentFragment();
                    Array.from(node.childNodes).forEach(child => children.append(cleanNode(child)));
                    if (!allowedTags.has(node.tagName)) {
                        return children;
                    }

                    const cleanElement = document.createElement(node.tagName.toLowerCase());
                    cleanElement.append(children);
                    if (node.tagName === 'A') {
                        const href = node.getAttribute('href');
                        if (href && /^(https?:|mailto:|tel:|\/|#)/i.test(href)) {
                            cleanElement.setAttribute('href', href);
                        }
                    }
                    return cleanElement;
                }

                function cleanHtml(html) {
                    const parsed = new DOMParser().parseFromString(html, 'text/html');
                    const cleanContent = document.createDocumentFragment();
                    Array.from(parsed.body.childNodes).forEach(node => cleanContent.append(cleanNode(node)));
                    const container = document.createElement('div');
                    container.append(cleanContent);
                    return container.innerHTML;
                }

                editor.innerHTML = cleanHtml(source.value);

                wrapper.querySelectorAll('[data-command]').forEach(button => {
                    button.addEventListener('mousedown', event => event.preventDefault());
                    button.addEventListener('click', () => {
                        editor.focus();
                        const command = button.dataset.command;
                        document.execCommand(command, false, button.dataset.value || null);
                    });
                });

                editor.addEventListener('input', () => editor.classList.remove('is-invalid'));
                form.addEventListener('submit', event => {
                    source.value = cleanHtml(editor.innerHTML);
                    if (isRequired && !editor.innerText.trim()) {
                        event.preventDefault();
                        editor.classList.add('is-invalid');
                        editor.focus();
                    }
                });
            });
        </script>
    @endpush
@endonce
