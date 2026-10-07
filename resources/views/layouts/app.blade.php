<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEHATIN</title>
    <meta name="description" content="@yield('meta_description', __('app.description'))">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    @yield('og')

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Merriweather:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --green-50:  #f0fdf4;
            --green-100: #dcfce7;
            --green-200: #bbf7d0;
            --green-400: #4ade80;
            --green-500: #22c55e;
            --green-600: #16a34a;
            --green-700: #15803d;
            --green-800: #166534;
            --slate-50:  #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --slate-400: #94a3b8;
            --slate-500: #64748b;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
            --white:     #ffffff;
            --radius:    0.75rem;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow:    0 4px 16px rgba(0,0,0,.08);
            --shadow-lg: 0 8px 32px rgba(0,0,0,.10);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--slate-800);
            background: var(--white);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        img { max-width: 100%; height: auto; display: block; }
        a { color: inherit; text-decoration: none; }

        /* ── NAVBAR ─────────────────────────── */
        .navbar {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--slate-200);
        }
        .nav-inner {
            max-width: 1200px; margin: 0 auto;
            display: flex; align-items: center;
            padding: 0 1.25rem; height: 64px;
            gap: 2rem;
        }
        .nav-brand {
            display: flex; align-items: center; gap: .5rem;
            font-weight: 700; font-size: 1.35rem;
            color: var(--green-700);
            flex-shrink: 0;
        }
        .nav-brand .brand-word { color: var(--green-700); }
        .nav-brand .brand-word em { font-style: normal; color: var(--slate-800); }
        .nav-links {
            display: flex; align-items: center; gap: .25rem;
            list-style: none; flex: 1;
        }
        .nav-links a {
            display: block; padding: .5rem .85rem;
            font-size: .9rem; font-weight: 500;
            color: var(--slate-600);
            border-radius: .5rem;
            transition: color .15s, background .15s;
        }
        .nav-links a:hover, .nav-links a.active {
            color: var(--green-700);
            background: var(--green-50);
        }
        .nav-menu { display: contents; }
        .nav-right {
            display: flex; align-items: center; gap: .75rem;
            flex-shrink: 0;
        }
        .lang-switcher {
            display: flex; align-items: center; gap: .55rem;
            font-size: .85rem; color: var(--slate-500);
        }
        .lang-toggle {
            position: relative;
            display: grid;
            grid-template-columns: repeat(2, 2.4rem);
            padding: 3px;
            border: 1px solid var(--slate-200);
            border-radius: 999px;
            background: var(--slate-100);
            box-shadow: inset 0 1px 2px rgba(15,23,42,.08);
        }
        .lang-toggle::before {
            content: "";
            position: absolute;
            top: 3px;
            bottom: 3px;
            left: 3px;
            width: calc((100% - 6px) / 2);
            border-radius: 999px;
            background: var(--green-600);
            box-shadow: 0 2px 6px rgba(21,128,61,.25);
            transition: transform .25s cubic-bezier(.2,.8,.2,1), background-color .2s ease;
            pointer-events: none;
        }
        .lang-toggle[data-locale="en"]::before { transform: translateX(100%); }
        .lang-option {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 1.65rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            color: var(--slate-600);
            transition: color .2s ease, transform .2s ease;
        }
        .lang-option.active { color: var(--white); }
        .lang-option:not(.active):hover { color: var(--green-700); transform: scale(1.08); }
        .lang-toggle:has(.lang-option--id:hover, .lang-option--id:focus-visible)::before { transform: translateX(0); }
        .lang-toggle:has(.lang-option--en:hover, .lang-option--en:focus-visible)::before { transform: translateX(100%); }
        .lang-option:focus-visible {
            outline: 2px solid var(--green-700);
            outline-offset: 3px;
        }
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .5rem 1.1rem; border-radius: .55rem; font-size: .875rem; font-weight: 600; transition: all .15s; cursor: pointer; border: none; text-decoration: none; }
        .btn-primary { background: var(--green-600); color: var(--white); }
        .btn-primary:hover { background: var(--green-700); }
        .btn-outline { background: transparent; color: var(--green-700); border: 1.5px solid var(--green-600); }
        .btn-outline:hover { background: var(--green-50); }
        .btn-sm { padding: .35rem .8rem; font-size: .8rem; }
        .btn-danger { background: #dc2626; color: var(--white); }
        .btn-danger:hover { background: #b91c1c; }

        /* Hamburger */
        .nav-toggle { display: none; background: none; border: none; cursor: pointer; padding: .4rem; }
        .nav-toggle span { display: block; width: 22px; height: 2px; background: var(--slate-700); margin: 5px 0; border-radius: 2px; transition: all .25s; }

        /* ── HERO ───────────────────────────── */
        .hero {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            min-height: 510px;
            display: flex;
            align-items: center;
            background:
                radial-gradient(ellipse at 50% 105%, rgba(74,222,128,.22), transparent 48%),
                linear-gradient(135deg, #f8fffb 0%, #ffffff 52%, #f0fdf4 100%);
            color: var(--slate-800);
            padding: 5.5rem 1.25rem;
            text-align: center;
        }
        .hero::before {
            content: "";
            position: absolute;
            z-index: -1;
            inset: 0;
            opacity: .42;
            background-image: radial-gradient(rgba(21,128,61,.19) 1px, transparent 1px);
            background-size: 34px 34px;
            mask-image: linear-gradient(to bottom, transparent, #000 18%, #000 82%, transparent);
        }
        .hero-inner { position: relative; z-index: 2; max-width: 800px; margin: 0 auto; }
        .hero-kicker {
            display: inline-flex;
            align-items: center;
            gap: .55rem;
            padding: .45rem .9rem;
            margin-bottom: 1.25rem;
            border: 1px solid var(--green-200);
            border-radius: 999px;
            background: rgba(255,255,255,.78);
            color: var(--green-700);
            font-size: .8rem;
            font-weight: 700;
            letter-spacing: .04em;
            animation: hero-rise .7s both;
            scale: 1;
            translate: 0 0;
            transition: scale .22s ease, translate .22s ease, box-shadow .22s ease, border-color .22s ease, background-color .22s ease;
        }
        .hero-kicker:hover {
            scale: 1.045;
            translate: 0 -2px;
            border-color: var(--green-400);
            background-color: var(--white);
            box-shadow: 0 8px 22px rgba(21,128,61,.14);
        }
        .hero-kicker i { color: var(--green-600); transition: transform .3s ease; }
        .hero-kicker:hover i { transform: rotate(-12deg) scale(1.12); }
        .hero h1 {
            max-width: 780px;
            margin: 0 auto 1rem;
            color: var(--slate-900);
            font-family: 'Merriweather', serif;
            font-size: clamp(2.25rem, 5.2vw, 4.1rem);
            line-height: 1.16;
            letter-spacing: -.045em;
            animation: hero-rise .8s .08s both;
        }
        .hero p { max-width: 620px; margin: 0 auto 1.15rem; color: var(--slate-600); font-size: clamp(1rem, 2vw, 1.15rem); line-height: 1.75; animation: hero-rise .8s .18s both; }
        .hero-typed-line {
            min-height: 1.8em;
            margin: 0 auto 2rem;
            color: var(--green-700);
            font-size: clamp(.95rem, 2vw, 1.1rem);
            font-weight: 700;
            animation: hero-rise .8s .28s both;
        }
        .hero-typed {
            display: inline-block;
            text-align: left;
            border-right: 2px solid var(--green-600);
            padding-right: .15rem;
            animation: caret-blink .8s steps(2, start) infinite;
        }
        .hero-btns { animation: hero-rise .8s .38s both; }
        .hero .btn-primary {
            background: linear-gradient(110deg, var(--green-700), var(--green-500));
            color: var(--white);
            box-shadow: 0 10px 24px rgba(21,128,61,.2);
            transform-origin: center;
            transition: transform .22s cubic-bezier(.2,.8,.2,1), box-shadow .22s ease, background-position .22s ease;
        }
        .hero .btn-primary:hover, .hero .btn-primary:focus-visible {
            background: linear-gradient(110deg, var(--green-700), var(--green-500));
            transform: translateY(-2px) scale(1.06);
            box-shadow: 0 14px 30px rgba(21,128,61,.3);
        }
        .hero .btn-primary:active { transform: translateY(0) scale(1.02); }
        .hero .btn-outline {
            border-color: var(--green-600);
            color: var(--green-700);
            background: rgba(255,255,255,.7);
            transform-origin: center;
            transition: transform .22s cubic-bezier(.2,.8,.2,1), box-shadow .22s ease, background-color .22s ease;
        }
        .hero .btn-outline:hover, .hero .btn-outline:focus-visible {
            background: var(--green-50);
            transform: translateY(-2px) scale(1.06);
            box-shadow: 0 14px 30px rgba(21,128,61,.18);
        }
        .hero .btn-outline:active { transform: translateY(0) scale(1.02); }
        .hero-art { position: absolute; z-index: 1; inset: 0; overflow: hidden; pointer-events: none; }
        .hero-orb {
            position: absolute;
            width: clamp(180px, 28vw, 360px);
            aspect-ratio: 1;
            border-radius: 50%;
            background: radial-gradient(circle at 35% 35%, rgba(74,222,128,.2), rgba(34,197,94,.06) 55%, transparent 72%);
            filter: blur(2px);
            animation: hero-drift 13s ease-in-out infinite alternate;
        }
        .hero-orb--left { left: -8%; top: 8%; }
        .hero-orb--right { right: -7%; bottom: -18%; animation-delay: -6s; }
        .hero-ring {
            position: absolute;
            width: clamp(250px, 35vw, 450px);
            aspect-ratio: 1;
            border: 1px solid rgba(21,128,61,.12);
            border-radius: 50%;
            left: -10%;
            bottom: -62%;
            animation: hero-ring-drift 20s linear infinite;
        }
        .hero-ring::before, .hero-ring::after {
            content: "";
            position: absolute;
            width: 10px;
            height: 10px;
            border: 2px solid rgba(21,128,61,.42);
            border-radius: 50%;
            background: white;
            box-shadow: 0 0 18px rgba(34,197,94,.35);
        }
        .hero-ring::before { left: 18%; top: 16%; }
        .hero-ring::after { right: 12%; bottom: 28%; width: 7px; height: 7px; }
        .hero-silhouette {
            position: absolute;
            width: clamp(62px, 8vw, 108px);
            height: auto;
            color: rgba(21,128,61,.16);
            filter: drop-shadow(0 8px 15px rgba(21,128,61,.08));
            animation: hero-float 7s ease-in-out infinite;
        }
        .hero-silhouette--leaf { left: 13%; top: 21%; transform: rotate(-18deg); }
        .hero-silhouette--heart { right: 13%; top: 19%; width: clamp(55px, 6vw, 82px); animation-delay: -2.5s; }
        .hero-silhouette--plus { right: 21%; bottom: 13%; width: clamp(40px, 5vw, 64px); animation-delay: -4s; }
        .hero-silhouette--pulse { left: 19%; bottom: 15%; width: clamp(78px, 10vw, 132px); animation-delay: -1s; }
        @keyframes hero-rise {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes caret-blink { to { border-color: transparent; } }
        @keyframes hero-float {
            0%, 100% { translate: 0 0; }
            50% { translate: 0 -16px; }
        }
        @keyframes hero-drift {
            from { transform: translate3d(-12px, 4px, 0) scale(.94); }
            to { transform: translate3d(22px, -18px, 0) scale(1.08); }
        }
        @keyframes hero-ring-drift { to { rotate: 360deg; } }
        .hero-btns { display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; }

        /* ── SECTIONS ───────────────────────── */
        .section { padding: 4rem 1.25rem; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-header { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 2rem; gap: 1rem; }
        .section-title { font-family: 'Merriweather', serif; font-size: 1.6rem; color: var(--slate-800); }
        .section-link { font-size: .875rem; font-weight: 600; color: var(--green-600); white-space: nowrap; }
        .section-link:hover { color: var(--green-800); }
        .section-alt { background: var(--slate-50); }

        /* ── CARDS ──────────────────────────── */
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem; }
        .grid-5 { display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem; }
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }

        .card {
            background: var(--white);
            border: 1px solid var(--slate-200);
            border-radius: var(--radius);
            overflow: hidden;
            transition: box-shadow .2s, transform .2s;
        }
        .card:hover { box-shadow: var(--shadow); transform: translateY(-2px); }
        .card-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; }
        .card-body { padding: 1.25rem; }
        .card-meta { display: flex; align-items: center; gap: .5rem; font-size: .78rem; color: var(--slate-400); margin-bottom: .6rem; flex-wrap: wrap; }
        .card-tag { background: var(--green-50); color: var(--green-700); padding: .2rem .6rem; border-radius: 999px; font-weight: 600; font-size: .75rem; }
        .card-title { font-family: 'Merriweather', serif; font-size: 1rem; font-weight: 700; line-height: 1.4; color: var(--slate-800); margin-bottom: .5rem; }
        .card-excerpt { font-size: .875rem; color: var(--slate-500); line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
        .card-footer { padding: .75rem 1.25rem; border-top: 1px solid var(--slate-100); display: flex; justify-content: flex-end; }

        /* Category card */
        .cat-card { display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem 1rem; gap: .75rem; cursor: pointer; }
        .cat-icon { width: 56px; height: 56px; border-radius: 50%; background: var(--green-100); display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: var(--green-700); flex-shrink: 0; }
        .cat-name { font-weight: 600; font-size: .9rem; color: var(--slate-700); }
        .cat-count { font-size: .78rem; color: var(--slate-400); }

        /* Service card */
        .svc-card { padding: 1.75rem; display: flex; flex-direction: column; gap: .75rem; }
        .svc-icon { font-size: 1.75rem; color: var(--green-600); }
        .svc-name { font-weight: 700; font-size: 1rem; color: var(--slate-800); }
        .svc-desc { font-size: .875rem; color: var(--slate-500); line-height: 1.6; }

        /* ── FAQ ─────────────────────────────── */
        .faq-list { display: flex; flex-direction: column; gap: .75rem; max-width: 800px; margin: 0 auto; }
        .faq-item { border: 1px solid var(--slate-200); border-radius: var(--radius); overflow: hidden; }
        .faq-q { width: 100%; background: var(--white); border: none; padding: 1.1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; text-align: left; cursor: pointer; font-size: .95rem; font-weight: 600; color: var(--slate-800); transition: background .15s; }
        .faq-q:hover { background: var(--green-50); }
        .faq-q .faq-icon { font-size: .85rem; color: var(--green-600); flex-shrink: 0; transition: transform .2s; }
        .faq-q[aria-expanded="true"] .faq-icon { transform: rotate(45deg); }
        .faq-a { display: grid; grid-template-rows: 0fr; font-size: .9rem; color: var(--slate-600); line-height: 1.7; transition: grid-template-rows .32s cubic-bezier(.2,.8,.2,1); }
        .faq-a > div { min-height: 0; overflow: hidden; padding: 0 1.5rem; opacity: 0; transform: translateY(-.35rem); transition: padding .32s cubic-bezier(.2,.8,.2,1), opacity .22s ease, transform .32s cubic-bezier(.2,.8,.2,1); }
        .faq-a.open { grid-template-rows: 1fr; }
        .faq-a.open > div { padding-bottom: 1.1rem; opacity: 1; transform: translateY(0); }
        @media (prefers-reduced-motion: reduce) {
            .faq-a, .faq-a > div { transition: none; }
        }

        /* ── FOOTER ─────────────────────────── */
        footer {
            background: var(--slate-900);
            color: var(--slate-400);
            padding: 3.5rem 1.25rem 2rem;
        }
        .footer-inner { max-width: 1200px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 2.5rem; margin-bottom: 2.5rem; }
        .footer-brand { display: flex; align-items: center; gap: .5rem; font-weight: 700; font-size: 1.25rem; color: var(--white); margin-bottom: .75rem; }
        .footer-brand .brand-word { color: var(--green-400); }
        .footer-brand .brand-word em { font-style: normal; color: var(--white); }
        .footer-tagline { font-size: .875rem; line-height: 1.6; max-width: 280px; }
        .footer-col h4 { font-size: .875rem; font-weight: 700; color: var(--white); text-transform: uppercase; letter-spacing: .05em; margin-bottom: 1rem; }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: .5rem; }
        .footer-links a { font-size: .875rem; transition: color .15s; }
        .footer-links a:hover { color: var(--green-400); }
        .footer-bottom { border-top: 1px solid var(--slate-800); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; }
        .footer-disclaimer { font-size: .78rem; line-height: 1.6; max-width: 600px; font-style: italic; }
        .footer-attribution { display: flex; flex-direction: column; align-items: flex-end; gap: .3rem; text-align: right; }
        .footer-copy { font-size: .8rem; white-space: nowrap; }
        .footer-credit { color: var(--slate-400); font-size: .75rem; }
        .footer-credit strong { color: var(--green-400); font-weight: 600; }

        /* ── BREADCRUMB ─────────────────────── */
        .breadcrumb { padding: .85rem 1.25rem; background: var(--slate-50); border-bottom: 1px solid var(--slate-200); font-size: .825rem; }
        .breadcrumb-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; color: var(--slate-400); }
        .breadcrumb-inner a { color: var(--green-700); }
        .breadcrumb-inner a:hover { text-decoration: underline; }
        .breadcrumb-inner span.sep { color: var(--slate-300); }

        /* ── ARTICLE DETAIL ─────────────────── */
        .article-page { max-width: 1200px; margin: 0 auto; padding: 2.5rem 1.25rem; display: grid; grid-template-columns: 1fr 320px; gap: 3rem; align-items: start; }
        .article-hero-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius); margin-bottom: 2rem; }
        .article-meta { display: flex; align-items: center; gap: .75rem; flex-wrap: wrap; margin-bottom: 1rem; font-size: .85rem; color: var(--slate-500); }
        .article-title { font-family: 'Merriweather', serif; font-size: clamp(1.5rem, 3vw, 2.25rem); line-height: 1.3; color: var(--slate-900); margin-bottom: 1.25rem; }
        .article-body { font-size: 1rem; line-height: 1.85; color: var(--slate-700); font-family: 'Merriweather', serif; }
        .article-body h2, .article-body h3 { font-family: 'Plus Jakarta Sans', sans-serif; margin: 1.75rem 0 .75rem; color: var(--slate-900); }
        .article-body p { margin-bottom: 1.25rem; }
        .article-body ul, .article-body ol { margin: 0 0 1.25rem 1.5rem; }
        .article-body li { margin-bottom: .4rem; }
        .sidebar { position: sticky; top: 80px; }
        .sidebar-box { background: var(--white); border: 1px solid var(--slate-200); border-radius: var(--radius); padding: 1.25rem; margin-bottom: 1.25rem; }
        .sidebar-title { font-weight: 700; font-size: .9rem; color: var(--slate-700); margin-bottom: 1rem; padding-bottom: .6rem; border-bottom: 2px solid var(--green-100); }

        /* ── ALERTS ─────────────────────────── */
        .alert { padding: .85rem 1.1rem; border-radius: .6rem; font-size: .875rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: .6rem; }
        .alert-success { background: var(--green-50); color: var(--green-800); border: 1px solid var(--green-200); }
        .alert-error   { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
        .alert-warning { background: #fffbeb; color: #92400e; border: 1px solid #fde68a; }

        /* ── PAGINATION ─────────────────────── */
        .pagination-wrap { margin-top: 2rem; display: flex; justify-content: center; }
        .pagination-nav { width: 100%; display: flex; justify-content: center; }
        .pagination-controls { display: flex; align-items: center; justify-content: center; gap: .5rem; flex-wrap: wrap; }
        .pagination-link {
            min-width: 2.65rem;
            min-height: 2.65rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .55rem .8rem;
            border: 1px solid var(--slate-200);
            border-radius: .65rem;
            background: var(--white);
            color: var(--slate-600);
            font-size: .875rem;
            font-weight: 600;
            transition: color .15s, background-color .15s, border-color .15s, box-shadow .15s;
        }
        .pagination-direction { padding-right: 1rem; padding-left: 1rem; }
        .pagination-link:not(.is-disabled):not(.is-current):hover {
            background: var(--green-50);
            border-color: var(--green-400);
            color: var(--green-700);
        }
        .pagination-link:focus-visible { outline: 2px solid var(--green-600); outline-offset: 2px; }
        .pagination-link.is-current {
            border-color: var(--green-600);
            background: var(--green-600);
            color: var(--white);
            box-shadow: 0 2px 6px rgba(22,163,74,.2);
        }
        .pagination-link.is-disabled { background: var(--slate-50); color: var(--slate-400); cursor: not-allowed; }
        .pagination-ellipsis { padding: 0 .15rem; color: var(--slate-400); }
        @media (max-width: 480px) {
            .pagination-controls { gap: .35rem; }
            .pagination-link { min-width: 2.4rem; min-height: 2.4rem; padding: .45rem .65rem; }
            .pagination-direction { padding-right: .7rem; padding-left: .7rem; }
        }

        /* ── PAGE HEADER ────────────────────── */
        .page-header { background: linear-gradient(135deg, var(--green-700), var(--green-500)); color: var(--white); padding: 3rem 1.25rem; text-align: center; }
        .page-header h1 { font-family: 'Merriweather', serif; font-size: clamp(1.6rem, 3vw, 2.25rem); margin-bottom: .5rem; }
        .page-header p {
            color: rgba(255,255,255,.92);
            font-size: 1rem;
            line-height: 1.7;
        }
        .page-header-typed {
            display: inline-block;
            max-width: 100%;
            text-align: left;
            border-right: 2px solid rgba(187,247,208,.95);
            padding-right: .15rem;
            animation: caret-blink .8s steps(2, start) infinite;
        }

        /* ── STATIC PAGE ────────────────────── */
        .static-content { max-width: 800px; margin: 3rem auto; padding: 0 1.25rem; }
        .static-content h2 { font-family: 'Merriweather', serif; font-size: 1.5rem; margin: 2rem 0 .75rem; color: var(--slate-900); }
        .static-content h3 { font-size: 1.1rem; font-weight: 700; margin: 1.5rem 0 .5rem; color: var(--slate-800); }
        .static-content p { margin-bottom: 1rem; color: var(--slate-700); line-height: 1.8; }
        .static-content ul, .static-content ol { margin: 0 0 1rem 1.5rem; color: var(--slate-700); }
        .static-content li { margin-bottom: .4rem; }
        .disclaimer-box { background: var(--green-50); border: 1px solid var(--green-200); border-radius: .6rem; padding: 1rem 1.25rem; margin: 1.5rem 0; font-size: .875rem; color: var(--green-800); line-height: 1.6; }

        /* ── EMPTY STATE ────────────────────── */
        .empty-state { text-align: center; padding: 4rem 1rem; color: var(--slate-400); }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; color: var(--slate-300); }
        .empty-state p { font-size: 1rem; }

        /* ── MOBILE ─────────────────────────── */
        @media (max-width: 1024px) {
            .grid-4 { grid-template-columns: repeat(2, 1fr); }
            .grid-5 { grid-template-columns: repeat(3, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 768px) {
            .hero { min-height: 470px; padding: 4rem 1.25rem; }
            .hero-silhouette--leaf { left: 2%; top: 12%; }
            .hero-silhouette--heart { right: 2%; top: 12%; }
            .hero-silhouette--pulse { left: 4%; bottom: 6%; }
            .hero-silhouette--plus { right: 6%; bottom: 8%; }
            .nav-inner {
                position: relative;
                flex-wrap: nowrap;
                height: 64px;
                padding: 0 1rem;
                gap: 1rem;
            }
            .nav-brand { margin-right: auto; }
            .nav-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                max-height: calc(100vh - 64px);
                overflow-y: auto;
                padding: .5rem 1rem 1rem;
                background: var(--white);
                border-top: 1px solid var(--slate-200);
                border-bottom: 1px solid var(--slate-200);
                box-shadow: var(--shadow);
            }
            .nav-menu.open { display: block; }
            .nav-links {
                display: flex;
                flex-direction: column;
                align-items: stretch;
                gap: .15rem;
                width: 100%;
                padding: 0 0 .5rem;
                background: var(--white);
            }
            .nav-links a { padding: .7rem .85rem; }
            .nav-right {
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                gap: .75rem;
                width: 100%;
                padding: .75rem .85rem .25rem;
                border-top: 1px solid var(--slate-200);
            }
            .nav-toggle { display: block; flex-shrink: 0; }
            .grid-3 { grid-template-columns: 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
            .grid-5 { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr; gap: 1.75rem; }
            .article-page { grid-template-columns: 1fr; }
            .sidebar { position: static; }
            .footer-bottom { flex-direction: column; align-items: flex-start; }
            .footer-attribution { align-items: flex-start; text-align: left; }
        }
        @media (max-width: 480px) {
            .hero { min-height: 440px; padding: 3.25rem 1rem; }
            .hero-kicker { font-size: .7rem; }
            .hero-silhouette--pulse, .hero-silhouette--plus { display: none; }
            .grid-4 { grid-template-columns: 1fr; }
            .grid-5 { grid-template-columns: 1fr 1fr; }
        }
        .cookie-consent {
            position: fixed;
            z-index: 120;
            right: 1rem;
            bottom: 1rem;
            width: min(100% - 2rem, 560px);
            padding: 1.25rem;
            border: 1px solid var(--slate-200);
            border-radius: 1rem;
            background: var(--white);
            box-shadow: 0 16px 48px rgba(15, 23, 42, .2);
        }
        .cookie-consent[hidden] { display: none; }
        .cookie-consent h2 { margin: 0 0 .4rem; font-size: 1.05rem; color: var(--slate-900); }
        .cookie-consent p { margin: 0; color: var(--slate-600); font-size: .875rem; }
        .cookie-consent a { color: var(--green-700); text-decoration: underline; text-underline-offset: 2px; }
        .cookie-consent-actions { display: flex; flex-wrap: wrap; gap: .6rem; margin-top: 1rem; }
        .cookie-consent-actions button {
            min-height: 2.6rem;
            padding: .6rem .9rem;
            border: 1px solid var(--green-700);
            border-radius: .6rem;
            font: inherit;
            font-size: .85rem;
            font-weight: 700;
            cursor: pointer;
        }
        .cookie-consent-accept { color: var(--white); background: var(--green-700); }
        .cookie-consent-essential { color: var(--green-700); background: var(--white); }
        .cookie-consent-actions button:focus-visible,
        .cookie-settings-button:focus-visible { outline: 3px solid var(--green-400); outline-offset: 2px; }
        .cookie-settings-button {
            padding: 0;
            border: 0;
            color: inherit;
            background: transparent;
            font: inherit;
            cursor: pointer;
        }
        @media (max-width: 520px) {
            .cookie-consent { right: .65rem; bottom: .65rem; width: calc(100% - 1.3rem); padding: 1rem; }
            .cookie-consent-actions { flex-direction: column; }
            .cookie-consent-actions button { width: 100%; }
        }
        @media (prefers-reduced-motion: reduce) {
            .hero *, .hero *::before, .hero *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
            .lang-toggle::before, .lang-option { transition-duration: .01ms !important; }
            .page-header-typed { animation: none !important; border-right-color: transparent; }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- NAVBAR --}}
<nav class="navbar">
    <div class="nav-inner">
        <a href="{{ route('home') }}" class="nav-brand">
            <i class="fas fa-leaf"></i>
            <span class="brand-word">SEHAT<em>IN</em></span>
        </a>

        <div class="nav-menu" id="navMenu">
            <ul class="nav-links" id="navLinks">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">{{ __('app.home') }}</a></li>
                <li><a href="{{ route('artikel.index') }}" class="{{ request()->routeIs('artikel.*') ? 'active' : '' }}">{{ __('app.articles') }}</a></li>
                <li><a href="{{ route('layanan.index') }}" class="{{ request()->routeIs('layanan.*', 'obat.*', 'penyakit.*', 'panduan.*') ? 'active' : '' }}">{{ __('app.services') }}</a></li>
                <li><a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'active' : '' }}">{{ __('app.faq') }}</a></li>
                <li><a href="{{ route('tentang') }}" class="{{ request()->routeIs('tentang') ? 'active' : '' }}">{{ __('app.about') }}</a></li>
            </ul>

            <div class="nav-right" id="navRight">
            {{-- Language Switcher --}}
            <div class="lang-switcher" role="group" aria-label="{{ __('app.language') }}">
                <i class="fas fa-globe"></i>
                <div class="lang-toggle" data-locale="{{ app()->getLocale() }}">
                    <a href="{{ route('lang.switch', 'id') }}"
                       class="lang-option lang-option--id {{ app()->getLocale() === 'id' ? 'active' : '' }}"
                       aria-current="{{ app()->getLocale() === 'id' ? 'true' : 'false' }}">ID</a>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="lang-option lang-option--en {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                       aria-current="{{ app()->getLocale() === 'en' ? 'true' : 'false' }}">EN</a>
                </div>
            </div>

            @auth
                <details style="position:relative">
                    <summary class="btn btn-sm btn-outline" style="list-style:none;cursor:pointer;min-height:2rem;justify-content:center">
                        <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                    </summary>
                    <div style="position:absolute;right:0;top:calc(100% + .5rem);z-index:110;min-width:200px;padding:.5rem;background:var(--white);border:1px solid var(--slate-200);border-radius:.75rem;box-shadow:var(--shadow)">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.profile.index') : route('profile.index') }}" style="display:flex;align-items:center;gap:.6rem;padding:.65rem .75rem;border-radius:.5rem;color:var(--slate-700);font-size:.875rem">
                            <i class="fas fa-user" style="width:1rem;color:var(--green-600)"></i> Profil Saya
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:.6rem;padding:.65rem .75rem;border-radius:.5rem;color:var(--slate-700);font-size:.875rem">
                                <i class="fas fa-tachometer-alt" style="width:1rem;color:var(--green-600)"></i> Dashboard Admin
                            </a>
                        @endif
                    </div>
                </details>
                <form action="{{ route('logout') }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" style="min-height:2rem;justify-content:center">
                        <i class="fas fa-sign-out-alt"></i> {{ __('app.logout') }}
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-sm btn-outline">{{ __('app.login') }}</a>
                <a href="{{ route('register') }}" class="btn btn-sm btn-primary">{{ __('app.register') }}</a>
            @endauth
            </div>
        </div>

        <button class="nav-toggle" id="navToggle" type="button" aria-label="Menu" aria-controls="navMenu" aria-expanded="false">
            <span></span><span></span><span></span>
        </button>
    </div>
</nav>

{{-- FLASH MESSAGES --}}
@if(session('success'))
    <div class="alert alert-success" style="max-width:1200px;margin:1rem auto;padding:.85rem 1.25rem;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-error" style="max-width:1200px;margin:1rem auto;padding:.85rem 1.25rem;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
@endif

@yield('content')

{{-- FOOTER --}}
<footer>
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <div class="footer-brand"><i class="fas fa-leaf"></i> <span class="brand-word">SEHAT<em>IN</em></span></div>
                <p class="footer-tagline">{{ __('app.description') }}</p>
            </div>
            <div>
                <h4>{{ __('app.closer_links') }}</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('tentang') }}">{{ __('app.about') }}</a></li>
                    <li><a href="{{ route('kebijakan-privasi') }}">{{ __('app.privacy') }}</a></li>
                    <li><a href="{{ route('syarat-ketentuan') }}">{{ __('app.terms') }}</a></li>
                    <li><a href="{{ route('faq') }}">{{ __('app.faq') }}</a></li>
                    <li><button type="button" class="cookie-settings-button" data-cookie-settings>{{ __('app.cookie_settings') }}</button></li>
                </ul>
            </div>
            <div>
                <h4>{{ __('app.services') }}</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('obat.index') }}">Info Obat</a></li>
                    <li><a href="{{ route('penyakit.index') }}">Info Penyakit</a></li>
                    <li><a href="{{ route('panduan.index') }}">Panduan Kesehatan</a></li>
                </ul>
            </div>
            <div>
                <h4>{{ __('app.article_categories') }}</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('artikel.category', 'kesehatan-umum') }}">Kesehatan Umum</a></li>
                    <li><a href="{{ route('artikel.category', 'kesehatan-mental') }}">Kesehatan Mental</a></li>
                    <li><a href="{{ route('artikel.category', 'diet-dan-nutrisi') }}">Diet dan Nutrisi</a></li>
                    <li><a href="{{ route('artikel.category', 'kesehatan-anak') }}">Kesehatan Anak</a></li>
                    <li><a href="{{ route('artikel.category', 'gaya-hidup-sehat') }}">Gaya Hidup Sehat</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p class="footer-disclaimer"><i class="fas fa-info-circle"></i> {{ __('app.disclaimer') }}</p>
            <div class="footer-attribution">
                <p class="footer-copy">{{ __('app.copyright', ['year' => date('Y')]) }}</p>
                <p class="footer-credit">{{ __('app.created_by') }} <strong>Hello, World!</strong></p>
            </div>
        </div>
    </div>
</footer>

<section id="cookie-consent" class="cookie-consent" role="region" aria-labelledby="cookie-consent-title" aria-describedby="cookie-consent-message" hidden>
    <h2 id="cookie-consent-title">{{ __('app.cookie_consent_title') }}</h2>
    <p id="cookie-consent-message">
        {{ __('app.cookie_consent_message') }}
        <a href="{{ route('kebijakan-privasi') }}">{{ __('app.cookie_consent_privacy') }}</a>
    </p>
    <div class="cookie-consent-actions">
        <button type="button" class="cookie-consent-accept" data-cookie-choice="all">{{ __('app.cookie_accept_all') }}</button>
        <button type="button" class="cookie-consent-essential" data-cookie-choice="essential">{{ __('app.cookie_essential_only') }}</button>
    </div>
</section>

<script>
    // Mobile nav toggle
    const toggle = document.getElementById('navToggle');
    const menu = document.getElementById('navMenu');
    if (toggle && menu) {
        const closeMenu = () => {
            menu.classList.remove('open');
            toggle.setAttribute('aria-expanded', 'false');
        };

        toggle.addEventListener('click', () => {
            const isOpen = menu.classList.toggle('open');
            toggle.setAttribute('aria-expanded', String(isOpen));
        });

        menu.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));

        document.addEventListener('click', event => {
            if (!menu.contains(event.target) && !toggle.contains(event.target)) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape' && menu.classList.contains('open')) {
                closeMenu();
                toggle.focus();
            }
        });

        window.matchMedia('(min-width: 769px)').addEventListener('change', closeMenu);
    }

    const cookieConsent = document.getElementById('cookie-consent');
    const cookieConsentKey = 'sehatin-cookie-consent-v1';
    if (cookieConsent) {
        try {
            const savedConsent = localStorage.getItem(cookieConsentKey);
            if (!savedConsent) {
                cookieConsent.hidden = false;
            } else {
                const consent = JSON.parse(savedConsent);
                if (consent.version !== 1 || typeof consent.optional !== 'boolean') {
                    cookieConsent.hidden = false;
                }
            }
        } catch (error) {
            console.error('Unable to read cookie preferences.', error);
            cookieConsent.hidden = false;
        }

        cookieConsent.querySelectorAll('[data-cookie-choice]').forEach(button => {
            button.addEventListener('click', () => {
                const consent = {
                    version: 1,
                    essential: true,
                    optional: button.dataset.cookieChoice === 'all',
                    savedAt: new Date().toISOString(),
                };

                try {
                    localStorage.setItem(cookieConsentKey, JSON.stringify(consent));
                    cookieConsent.hidden = true;
                } catch (error) {
                    console.error('Unable to save cookie preferences.', error);
                }
            });
        });

        document.querySelectorAll('[data-cookie-settings]').forEach(button => {
            button.addEventListener('click', () => {
                cookieConsent.hidden = false;
                cookieConsent.querySelector('[data-cookie-choice="all"]').focus();
            });
        });
    }

    // FAQ Accordion
    document.querySelectorAll('.faq-q').forEach(btn => {
        btn.addEventListener('click', () => {
            const answer = btn.nextElementSibling;
            const isOpen = btn.getAttribute('aria-expanded') === 'true';
            document.querySelectorAll('.faq-q').forEach(b => {
                b.setAttribute('aria-expanded', 'false');
                b.nextElementSibling.classList.remove('open');
            });
            if(!isOpen) {
                btn.setAttribute('aria-expanded', 'true');
                answer.classList.add('open');
            }
        });
    });

    const pageHeaderSubtitle = document.querySelector('[data-page-header-typed]');
    if (pageHeaderSubtitle && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        const text = Array.from(pageHeaderSubtitle.textContent.trim());
        pageHeaderSubtitle.setAttribute('aria-label', text.join(''));
        pageHeaderSubtitle.setAttribute('aria-live', 'off');

        let characterIndex = 0;
        let deleting = false;
        pageHeaderSubtitle.textContent = '';
        const typeNextCharacter = () => {
            let delay = deleting ? 22 : 34;
            if (deleting) {
                characterIndex--;
                if (characterIndex === 0) {
                    deleting = false;
                    delay = 450;
                }
            } else {
                characterIndex++;
                if (characterIndex === text.length) {
                    deleting = true;
                    delay = 1200;
                }
            }

            pageHeaderSubtitle.textContent = text.slice(0, characterIndex).join('');
            window.setTimeout(typeNextCharacter, delay);
        };

        window.setTimeout(typeNextCharacter, 320);
    }
</script>
@stack('scripts')
</body>
</html>
