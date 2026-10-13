<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" data-language-change-failed="{{ __('app.language_change_failed') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#15803d">
    <link rel="manifest" href="{{ asset('manifest.webmanifest') }}">
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
        html[data-theme="dark"] {
            color-scheme: dark;
            --green-50: #102619;
            --green-100: #183b24;
            --green-200: #285d38;
            --green-400: #4ade80;
            --green-500: #22c55e;
            --green-600: #16a34a;
            --green-700: #4ade80;
            --green-800: #bbf7d0;
            --slate-50: #111827;
            --slate-100: #1f2937;
            --slate-200: #374151;
            --slate-300: #4b5563;
            --slate-400: #9ca3af;
            --slate-500: #cbd5e1;
            --slate-600: #d1d5db;
            --slate-700: #e5e7eb;
            --slate-800: #f3f4f6;
            --slate-900: #f9fafb;
            --white: #111827;
            --shadow-sm: 0 1px 3px rgba(0,0,0,.2), 0 1px 2px rgba(0,0,0,.2);
            --shadow: 0 4px 16px rgba(0,0,0,.25);
            --shadow-lg: 0 8px 32px rgba(0,0,0,.3);
        }
        html[data-font-size="small"] { font-size: 93.75%; }
        html[data-font-size="normal"] { font-size: 100%; }
        html[data-font-size="large"] { font-size: 112.5%; }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--slate-800);
            background: var(--white);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }
        html[data-theme="dark"] body { background: #111827; }
        html[data-theme="dark"] .navbar,
        html[data-theme="dark"] .nav-menu,
        html[data-theme="dark"] .nav-links,
        html[data-theme="dark"] .card,
        html[data-theme="dark"] .faq-q,
        html[data-theme="dark"] .lang-toggle,
        html[data-theme="dark"] .accessibility-menu-panel,
        html[data-theme="dark"] .sidebar-box { background-color: var(--white); }
        html[data-theme="dark"] .hero {
            background:
                radial-gradient(ellipse at 50% 105%, rgba(74,222,128,.12), transparent 48%),
                linear-gradient(135deg, #111827 0%, #111827 52%, #102619 100%);
        }
        html[data-theme="dark"] .hero h1,
        html[data-theme="dark"] .section-title,
        html[data-theme="dark"] .card-title,
        html[data-theme="dark"] .static-content h2,
        html[data-theme="dark"] .static-content h3 { color: var(--slate-900); }
        html[data-theme="dark"] .hero-kicker { background: #1f2937; }
        html[data-theme="dark"] .hero .btn-outline {
            border-color: var(--green-400);
            color: var(--green-400);
            background: rgba(15,23,42,.72);
        }
        html[data-theme="dark"] .hero .btn-outline:hover,
        html[data-theme="dark"] .hero .btn-outline:focus-visible { background: #1f2937; }
        html[data-theme="dark"] .disclaimer-box { background: var(--green-50); color: var(--green-800); }
        html[data-theme="dark"] .accessibility-menu-panel { border-color: var(--slate-200); }
        html[data-data-saver="true"] *,
        html[data-data-saver="true"] *::before,
        html[data-data-saver="true"] *::after {
            animation-duration: .01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: .01ms !important;
            scroll-behavior: auto !important;
        }
        html[data-data-saver="true"] .hero-typed,
        html[data-data-saver="true"] .page-header-typed {
            border-right-color: transparent !important;
            animation: none !important;
        }
        html[data-data-saver="true"] .hero-art { display: none; }
        @view-transition { navigation: auto; }
        ::view-transition-old(root), ::view-transition-new(root) { animation-duration: 180ms; }
        html {
            scrollbar-color: var(--green-600) var(--slate-100);
            scrollbar-width: thin;
        }
        html::-webkit-scrollbar { width: 12px; height: 12px; }
        html::-webkit-scrollbar-track { background: var(--slate-100); }
        html::-webkit-scrollbar-thumb {
            border: 3px solid var(--slate-100);
            border-radius: 999px;
            background: linear-gradient(180deg, var(--green-500), var(--green-700));
        }
        html::-webkit-scrollbar-thumb:hover { background: var(--green-800); }
        html::-webkit-scrollbar-corner { background: var(--slate-100); }
        .page-loader {
            position: fixed; z-index: 1000; inset: 0 auto auto 0; width: 100%; height: 3px;
            background: var(--green-500); transform: scaleX(0); transform-origin: left;
            opacity: 0; transition: transform .2s ease, opacity .15s ease;
        }
        html.is-navigating .page-loader { transform: scaleX(.72); opacity: 1; }
        .sr-only { position:absolute!important;width:1px!important;height:1px!important;padding:0!important;margin:-1px!important;overflow:hidden!important;clip:rect(0,0,0,0)!important;white-space:nowrap!important;border:0!important; }
        .accessibility-menu { position: relative; }
        .accessibility-menu summary { list-style: none; }
        .accessibility-menu summary::-webkit-details-marker { display: none; }
        .user-menu { position: relative; }
        .user-menu summary { list-style: none; }
        .user-menu summary::-webkit-details-marker { display: none; }
        .user-menu-summary { max-width: 16rem; }
        .user-menu-name { min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .user-menu-panel {
            position: absolute; right: 0; top: calc(100% + .5rem); z-index: 120;
            width: min(19rem, calc(100vw - 2rem)); padding: .5rem;
            border: 1px solid var(--slate-200); border-radius: .75rem;
            background: var(--white); box-shadow: var(--shadow);
        }
        .user-menu-panel a {
            display: flex; align-items: center; gap: .6rem; width: 100%;
            padding: .65rem .75rem; border-radius: .5rem; color: var(--slate-700); font-size: .875rem;
        }
        .user-menu-panel a:hover { background: var(--green-50); color: var(--green-700); }
        .user-menu-panel a i { width: 1rem; color: var(--green-600); }
        .user-menu-summary:focus-visible { outline: 3px solid var(--green-600); outline-offset: 3px; }
        .accessibility-menu-panel {
            position: absolute; right: 0; top: calc(100% + .5rem); z-index: 120;
            width: min(19rem, calc(100vw - 2rem)); padding: 1rem;
            border: 1px solid var(--slate-200); border-radius: .75rem;
            background: var(--white); box-shadow: var(--shadow);
        }
        .accessibility-menu-panel h2 { font-size: .95rem; margin: 0 0 .75rem; }
        .accessibility-menu-panel button {
            min-height: 2.5rem; padding: .45rem .65rem; border: 1px solid var(--slate-300);
            border-radius: .45rem; background: var(--white); color: var(--slate-800); cursor: pointer;
            transition: border-color .18s ease, background-color .18s ease, color .18s ease, transform .18s ease, box-shadow .18s ease;
        }
        .accessibility-menu-panel button[aria-pressed="true"] {
            border-color: var(--green-700); background: var(--green-700); color: #fff;
        }
        @media (hover: hover) and (pointer: fine) {
            .accessibility-menu-panel button:hover {
                border-color: var(--green-500);
                background: var(--green-50);
                color: var(--green-800);
                box-shadow: var(--shadow-sm);
                transform: translateY(-1px);
            }
            .accessibility-menu-panel button[aria-pressed="true"]:hover {
                background: var(--green-700);
                color: #fff;
            }
        }
        .font-size-options { display: flex; gap: .35rem; margin: .35rem 0 .8rem; }
        .font-size-options button { flex: 1; }
        .accessibility-menu-panel > button { width: 100%; text-align: left; margin-top: .35rem; }
        .accessibility-menu-panel button:focus-visible,
        .accessibility-menu summary:focus-visible { outline: 3px solid var(--green-600); outline-offset: 3px; }
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
            max-width: 1440px; margin: 0 auto;
            display: flex; align-items: center;
            padding: 0 clamp(1rem, 2vw, 1.5rem); height: 64px;
            gap: 1rem;
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
            display: flex; align-items: center; justify-content: center; gap: .1rem;
            list-style: none; flex: 1; min-width: 0;
        }
        .nav-links a {
            display: block; padding: .5rem .5rem;
            font-size: .82rem; font-weight: 500; text-align: center; white-space: nowrap;
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
            display: flex; align-items: center; gap: .5rem;
            flex-shrink: 0;
        }
        .lang-switcher {
            display: flex; align-items: center; gap: .55rem;
            font-size: .85rem; color: var(--slate-500);
            flex-shrink: 0;
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
            min-width: 2.4rem;
            border-radius: 999px;
            font-size: .72rem;
            font-weight: 700;
            white-space: nowrap;
            color: var(--slate-600);
            transition: color .2s ease, transform .2s ease;
        }
        .lang-option.active { color: var(--white); }
        .lang-option:not(.active):hover { color: var(--green-700); transform: scale(1.08); }
        .lang-toggle:has(.lang-option--id:hover, .lang-option--id:focus-visible)::before { transform: translateX(0); }
        .lang-toggle:has(.lang-option--en:hover, .lang-option--en:focus-visible)::before { transform: translateX(100%); }
        html[data-theme="light"] .lang-toggle:has(.lang-option--id:hover, .lang-option--id:focus-visible) .lang-option--id,
        html[data-theme="light"] .lang-toggle:has(.lang-option--en:hover, .lang-option--en:focus-visible) .lang-option--en { color: var(--white); }
        html[data-theme="light"] .lang-toggle:has(.lang-option--id:hover, .lang-option--id:focus-visible) .lang-option--en.active,
        html[data-theme="light"] .lang-toggle:has(.lang-option--en:hover, .lang-option--en:focus-visible) .lang-option--id.active { color: var(--slate-600); }
        .lang-option:focus-visible {
            outline: 2px solid var(--green-700);
            outline-offset: 3px;
        }
        .btn { display: inline-flex; align-items: center; gap: .4rem; padding: .5rem 1.1rem; border-radius: .55rem; font-size: .875rem; font-weight: 600; transition: all .15s; cursor: pointer; border: none; text-decoration: none; }
        .btn[hidden] { display: none !important; }
        .nav-right > .btn-sm,
        .nav-right > .accessibility-menu > summary { min-height: 2.25rem; justify-content: center; }
        .btn-primary { background: var(--green-600); color: var(--white); }
        .btn-primary:hover { background: var(--green-700); }
        .btn-outline { background: transparent; color: var(--green-700); border: 1.5px solid var(--green-600); }
        .btn-outline:hover { background: var(--green-50); }
        .btn-sm { padding: .35rem .8rem; font-size: .8rem; }
        .btn-danger { background: #dc2626; color: #fff; }
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
            text-align: center;
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

        .filter-select {
            min-height: 2.65rem;
            padding: .65rem 2.5rem .65rem .85rem;
            appearance: none;
            border: 1px solid var(--slate-300);
            border-radius: .65rem;
            color: var(--slate-800);
            background-color: var(--white);
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='none'%3E%3Cpath d='m5 7 5 5 5-5' stroke='%2315803d' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right .8rem center;
            background-size: .8rem;
            font: inherit;
            cursor: pointer;
            transition: border-color .18s ease, box-shadow .18s ease, background-color .18s ease;
        }
        .filter-select:hover { border-color: var(--green-500); }
        .filter-select:focus-visible {
            border-color: var(--green-600);
            outline: 3px solid rgba(34,197,94,.2);
            outline-offset: 1px;
            box-shadow: 0 0 0 1px var(--green-600);
        }
        .filter-select option { color: var(--slate-800); background: var(--white); }
        .filter-select-control { position: relative; display: inline-flex; flex: 0 1 14rem; min-width: 0; max-width: 100%; }
        .filter-select-native {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            white-space: nowrap !important;
            border: 0 !important;
        }
        .filter-select-trigger { width: 100%; min-width: 0; text-align: left; }
        .filter-select-options {
            position: fixed;
            z-index: 1000;
            overflow-y: auto;
            padding: .3rem;
            border: 1px solid var(--slate-200);
            border-radius: .7rem;
            background: var(--white);
            box-shadow: var(--shadow-lg);
        }
        .filter-select-options[hidden] { display: none; }
        .filter-select-option {
            display: block;
            width: 100%;
            min-width: 0;
            padding: .55rem .7rem;
            border: 0;
            border-radius: .45rem;
            color: var(--slate-800);
            background: transparent;
            font: inherit;
            text-align: left;
            overflow-wrap: anywhere;
            cursor: pointer;
        }
        .filter-select-option:hover,
        .filter-select-option:focus-visible,
        .filter-select-option[data-active="true"] { background: var(--green-50); outline: none; }
        .filter-select-option[aria-selected="true"] { color: var(--green-800); font-weight: 700; }
        .community-filters {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: .65rem .75rem;
            margin-bottom: 1.5rem;
            padding: 1rem 1.1rem;
            border: 1px solid var(--slate-200);
            border-radius: var(--radius);
            background: var(--slate-50);
            box-shadow: var(--shadow-sm);
        }
        .community-filters > label {
            color: var(--slate-700);
            font-size: .875rem;
            font-weight: 700;
        }
        .community-filters > .btn { min-height: 3rem; }
        .community-thread {
            position: relative;
            border-color: var(--slate-200);
            transition: border-color .2s ease, box-shadow .2s ease, transform .2s ease, background-color .2s ease;
        }
        .community-thread-link {
            position: absolute;
            inset: 0;
            z-index: 1;
            border-radius: inherit;
            text-decoration: none;
        }
        .community-thread-body {
            position: relative;
            padding: 1.15rem;
        }
        .community-thread:hover,
        .community-thread:focus-within {
            border-color: var(--green-200);
            background-color: var(--green-50);
            box-shadow: 0 10px 28px rgba(21,128,61,.1);
        }
        .community-thread .card-title {
            position: relative;
            z-index: 3;
        }
        .community-thread .card-title a { transition: color .18s ease; }
        .community-thread .card-title a:hover,
        .community-thread .card-title a:focus-visible { color: var(--green-700); }
        .community-thread-meta { margin-top: .75rem; }
        .community-thread-compose {
            margin-bottom: 1.5rem;
            padding: 1rem 1.1rem;
            border: 1px solid var(--slate-200);
            border-radius: var(--radius);
            background: var(--white);
            box-shadow: var(--shadow-sm);
        }
        .community-thread-compose summary {
            list-style: none;
            font-weight: 700;
            cursor: pointer;
            color: var(--slate-800);
        }
        .community-thread-compose summary::-webkit-details-marker { display: none; }
        .community-thread-form {
            display: grid;
            gap: .85rem;
            margin-top: 1rem;
        }
        .form-field { display: grid; gap: .4rem; }
        .form-field label {
            font-size: .82rem;
            font-weight: 700;
            color: var(--slate-700);
        }
        .form-field input,
        .form-field select,
        .form-field textarea,
        .reply-form textarea,
        .report-form select {
            width: 100%;
            min-height: 2.9rem;
            padding: .72rem .85rem;
            border: 1px solid var(--slate-300);
            border-radius: .7rem;
            background: var(--white);
            color: var(--slate-800);
            font: inherit;
            transition: border-color .18s ease, box-shadow .18s ease;
        }
        .form-field .filter-select-control { width: 100%; flex: 1 1 100%; }
        .form-field textarea,
        .reply-form textarea { min-height: 7rem; resize: vertical; }
        .form-field input:focus,
        .form-field select:focus,
        .form-field textarea:focus,
        .reply-form textarea:focus,
        .report-form select:focus {
            border-color: var(--green-600);
            outline: 3px solid rgba(34,197,94,.16);
            outline-offset: 1px;
        }
        .checkbox-field {
            display: inline-flex;
            align-items: center;
            gap: .5rem;
            color: var(--slate-700);
            font-size: .9rem;
        }
        .checkbox-field input { width: 1rem; height: 1rem; margin: 0; }
        .report-form,
        .reply-form {
            display: grid;
            gap: .8rem;
            margin-top: 1rem;
            padding: 1rem;
            border: 1px solid var(--slate-200);
            border-radius: var(--radius);
            background: var(--slate-50);
        }
        .report-form--inline { margin-top: .75rem; }
        .community-report-note { margin-top: .75rem; color: var(--slate-500); font-size: .82rem; }
        .reply-form { margin-top: 1rem; }
        .profile-layout {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .profile-panel {
            position: relative;
            background: var(--white);
            border: 1px solid var(--slate-200);
            border-radius: 1rem;
            padding: 1.25rem;
            box-shadow: var(--shadow-sm);
        }
        .profile-header {
            margin-bottom: 1rem;
        }
        .profile-list {
            display: flex;
            flex-direction: column;
            gap: .75rem;
        }
        .profile-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: .8rem .9rem;
            border: 1px solid var(--slate-200);
            border-radius: .8rem;
            background: var(--slate-50);
        }
        .profile-item + .profile-item {
            border-top: 1px solid var(--slate-200);
        }
        .profile-item img {
            width: 5.5rem;
            height: 4.1rem;
            object-fit: cover;
            border-radius: .45rem;
            flex-shrink: 0;
        }
        .profile-item-copy {
            flex: 1;
            min-width: 0;
        }
        .profile-item-title {
            display: block;
            font-weight: 700;
            color: var(--green-700);
            line-height: 1.5;
        }
        .profile-item-title--plain {
            color: var(--green-700);
        }
        .profile-item--history {
            justify-content: space-between;
        }
        .profile-empty { padding: 2rem 1rem; }
        .drug-filters { display: flex; gap: .75rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
        .drug-search {
            flex: 1;
            min-width: min(220px, 100%);
            min-height: 2.65rem;
            padding: .65rem .9rem;
            border: 1px solid var(--slate-300);
            border-radius: .65rem;
            color: var(--slate-800);
            background: var(--white);
            font: inherit;
            transition: border-color .18s ease, box-shadow .18s ease;
        }
        .drug-search:focus-visible {
            border-color: var(--green-600);
            outline: 3px solid rgba(34,197,94,.2);
            outline-offset: 1px;
        }
        .drug-alphabet {
            display: flex;
            align-items: center;
            gap: .4rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }
        .drug-alphabet .btn { min-width: 2.45rem; justify-content: center; }
        .drug-alphabet .btn:not(.btn-primary):hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 14px rgba(21,128,61,.14);
        }

        /* ── SECTIONS ───────────────────────── */
        .section { padding: 4rem 1.25rem; }
        .section-inner { max-width: 1200px; margin: 0 auto; }
        .section-header { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 2rem; gap: 1rem; }
        .section-title { font-family: 'Merriweather', serif; font-size: 1.6rem; color: var(--slate-800); }
        .section-link { font-size: .875rem; font-weight: 600; color: var(--green-600); white-space: nowrap; }
        button.section-link {
            appearance: none;
            padding: 0;
            border: 0;
            background: transparent;
            font-family: inherit;
            line-height: inherit;
            text-align: left;
            cursor: pointer;
        }
        .section-link:hover { color: var(--green-800); }
        .section-link:focus-visible { outline: 2px solid var(--green-600); outline-offset: 3px; border-radius: .15rem; }
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
            background: var(--green-800);
            color: rgba(255,255,255,.84);
            padding: 3.5rem 1.25rem 2rem;
            border-top: 1px solid rgba(255,255,255,.72);
        }
        html[data-theme="dark"] footer {
            background: var(--slate-50);
            color: var(--slate-600);
            border-top-color: var(--slate-200);
        }
        .footer-inner { max-width: 1200px; margin: 0 auto; }
        .footer-grid { display: grid; grid-template-columns: 2fr 1fr 1fr 1fr; gap: 2.5rem; margin-bottom: 2.5rem; }
        .footer-brand { display: flex; align-items: center; gap: .5rem; font-weight: 700; font-size: 1.25rem; color: #fff; margin-bottom: .75rem; }
        .footer-brand .brand-word { color: #86efac; }
        .footer-brand .brand-word em { font-style: normal; color: #fff; }
        .footer-tagline { font-size: .875rem; line-height: 1.6; max-width: 280px; }
        .footer-col h4 { font-size: .875rem; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 1rem; }
        .footer-links { list-style: none; display: flex; flex-direction: column; gap: .5rem; }
        .footer-links a { color: rgba(255,255,255,.84); font-size: .875rem; transition: color .15s; }
        .footer-links a:hover { color: #fff; }
        .footer-bottom { border-top: 1px solid rgba(255,255,255,.65); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; }
        .footer-disclaimer { font-size: .78rem; line-height: 1.6; max-width: 600px; font-style: italic; }
        .footer-attribution { display: flex; flex-direction: column; align-items: flex-end; gap: .3rem; text-align: right; }
        .footer-copy { font-size: .8rem; white-space: nowrap; }
        .footer-credit { color: rgba(255,255,255,.78); font-size: .75rem; }
        .footer-credit strong { color: #86efac; font-weight: 600; }
        html[data-theme="dark"] .footer-brand,
        html[data-theme="dark"] .footer-brand .brand-word em,
        html[data-theme="dark"] .footer-col h4 { color: var(--slate-800); }
        html[data-theme="dark"] .footer-brand .brand-word { color: var(--green-400); }
        html[data-theme="dark"] .footer-links a { color: var(--slate-600); }
        html[data-theme="dark"] .footer-links a:hover { color: var(--green-700); }
        html[data-theme="dark"] .footer-bottom { border-top-color: var(--slate-200); }
        html[data-theme="dark"] .footer-credit { color: var(--slate-600); }
        html[data-theme="dark"] .footer-credit strong { color: var(--green-700); }

        /* ── BREADCRUMB ─────────────────────── */
        .breadcrumb { padding: .85rem 1.25rem; background: var(--slate-50); border-bottom: 1px solid var(--slate-200); font-size: .825rem; }
        .breadcrumb-inner { max-width: 1200px; margin: 0 auto; display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; color: var(--slate-400); }
        .breadcrumb-inner a { color: var(--green-700); }
        .breadcrumb-inner a:hover { text-decoration: underline; }
        .breadcrumb-inner span.sep { color: var(--slate-300); }

        /* ── ARTICLE DETAIL ─────────────────── */
        .article-page { max-width: 1200px; margin: 0 auto; padding: 2.5rem 1.25rem; display: grid; grid-template-columns: 1fr 320px; gap: 3rem; align-items: start; }
        .article-hero-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: var(--radius); margin-bottom: 2rem; }
        .article-meta { display: flex; align-items: center; gap: .65rem .85rem; flex-wrap: wrap; margin-bottom: 1rem; font-size: .85rem; color: var(--slate-500); }
        .article-meta > span:not(.card-tag) { display: inline-flex; align-items: flex-start; gap: .35rem; line-height: 1.5; }
        .article-title { font-family: 'Merriweather', serif; font-size: clamp(1.5rem, 3vw, 2.25rem); line-height: 1.3; color: var(--slate-900); margin-bottom: 1.6rem; }
        .article-actions { display: flex; align-items: stretch; flex-wrap: wrap; gap: .55rem; margin: 0 0 1.75rem; }
        .article-actions > .btn { min-height: 3rem; align-items: center; justify-content: center; line-height: 1.2; }
        .article-actions .btn[aria-pressed="true"] { background: var(--green-50); border-color: var(--green-600); color: var(--green-800); }
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
            overflow-wrap: anywhere;
        }
        .page-header-typed {
            display: inline-block;
            max-width: 100%;
            text-align: center;
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
        .result-emergency-panel { display: grid; gap: .85rem; margin-top: 1.25rem; }
        .result-emergency-actions { display: flex; flex-wrap: wrap; gap: .75rem; }
        .consultation-shell { width: min(100%, 820px); margin: 0 auto; }
        .consultation-card { padding: clamp(1.1rem, 2vw, 1.75rem); background: var(--white); border: 1px solid var(--slate-200); border-radius: 1rem; box-shadow: var(--shadow-sm); }
        .consultation-messages { min-height: 12rem; max-height: 48vh; overflow-y: auto; display: grid; gap: .75rem; padding: 1rem; border: 1px solid var(--slate-200); border-radius: .8rem; background: var(--slate-50); }
        .consultation-messages[hidden] { display: none; }
        .consultation-message { margin: 0; padding: .8rem .9rem; border-radius: .75rem; line-height: 1.6; }
        .consultation-message--user { background: var(--green-100); color: var(--slate-800); margin-left: auto; max-width: 80%; }
        .consultation-message--admin { background: var(--white); border: 1px solid var(--slate-200); color: var(--slate-800); margin-right: auto; max-width: 80%; }
        .consultation-status { margin: .75rem 0 0; color: var(--slate-600); font-size: .8rem; }
        .consultation-retention-notice { margin-top: .65rem; color: var(--slate-500); font-size: .78rem; }
        .consultation-form { display: flex; flex-wrap: wrap; align-items: flex-start; gap: .7rem; margin-top: 1rem; }
        .consultation-form textarea { flex: 1 1 18rem; min-height: 5.5rem; width: 100%; padding: .8rem .9rem; border: 1px solid var(--slate-300); border-radius: .7rem; background: var(--white); color: var(--slate-800); resize: vertical; font: inherit; }
        .consultation-form textarea:focus { border-color: var(--green-600); outline: 3px solid rgba(34,197,94,.18); outline-offset: 1px; }
        .consultation-form .btn { min-height: 3rem; }
        .consultation-error { width: 100%; margin: 0; color: #b91c1c; font-size: .85rem; }

        /* ── EMPTY STATE ────────────────────── */
        .empty-state { text-align: center; padding: 4rem 1rem; color: var(--slate-400); }
        .empty-state i { font-size: 3rem; margin-bottom: 1rem; color: var(--slate-300); }
        .empty-state p { font-size: 1rem; }

        @media (max-width: 1280px) {
            .nav-inner {
                position: relative;
                flex-wrap: nowrap;
                height: 64px;
                padding: 0 1rem;
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
            .nav-links a { padding: .7rem .85rem; text-align: center; }
            .nav-right {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: .75rem;
                width: 100%;
                padding: .75rem .85rem .25rem;
                border-top: 1px solid var(--slate-200);
            }
            .nav-right .lang-switcher { justify-content: center; width: 100%; }
            .nav-right > .btn-sm,
            .nav-right > form,
            .nav-right > form .btn,
            .nav-right > .accessibility-menu,
            .nav-right > .accessibility-menu > summary {
                width: 100%;
            }
            .user-menu {
                width: 100%;
            }
            .user-menu summary {
                width: 100%;
                max-width: none;
                justify-content: center;
            }
            .user-menu-panel {
                position: static;
                width: 100%;
                margin-top: .5rem;
                box-sizing: border-box;
            }
            .user-menu-panel > a { width: 100%; }
            .accessibility-menu {
                display: flex;
                flex-direction: column;
                align-items: center;
                width: 100%;
            }
            .accessibility-menu-panel {
                position: static;
                width: min(19rem, calc(100vw - 4rem));
                margin: .5rem auto 0;
            }
            .nav-toggle { display: block; flex-shrink: 0; }
        }

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
            .grid-3 { grid-template-columns: 1fr; }
            .grid-2 { grid-template-columns: 1fr; }
            .grid-5 { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr; gap: 1.75rem; }
            .article-page { grid-template-columns: 1fr; }
            .article-actions { margin: .25rem 0 1.75rem; }
            .article-meta { align-items: flex-start; }
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
            .community-filters { align-items: stretch; gap: .45rem .65rem; padding: .9rem; }
            .community-filters > label { flex: 1 0 100%; margin-top: .2rem; }
            .community-filters .filter-select-control { width: 100%; flex-basis: 100%; }
            .community-filters .btn { width: 100%; justify-content: center; }
            .drug-filters .drug-search,
            .drug-filters > .btn { width: 100%; min-width: 0; }
            .drug-filters .filter-select-control { width: 100%; flex-basis: 100%; }
            .article-meta {
                display: grid;
                grid-template-columns: minmax(0, 1fr);
                align-items: start;
                gap: .55rem;
                font-size: .82rem;
            }
            .article-meta > span:not(.card-tag) { min-width: 0; }
            .article-actions { display: grid; align-items: stretch; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: .55rem; }
            .article-actions > .btn { width: 100%; min-width: 0; justify-content: center; text-align: center; }
            .article-title { margin-bottom: 1.5rem; }
            .profile-layout { grid-template-columns: 1fr; }
            .profile-item { border-radius: .7rem; }
            .profile-item--history { flex-direction: column; align-items: flex-start; }
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
            *, *::before, *::after {
                scroll-behavior: auto !important;
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
            }
            ::view-transition-old(root), ::view-transition-new(root) { animation: none !important; }
            .hero *, .hero *::before, .hero *::after {
                animation-duration: .01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: .01ms !important;
                scroll-behavior: auto !important;
            }
            .lang-toggle::before, .lang-option { transition-duration: .01ms !important; }
            .page-header-typed { animation: none !important; border-right-color: transparent; }
            ::view-transition-old(root), ::view-transition-new(root) { animation: none; }
            .page-loader { transition: none; }
        }
    </style>
    @vite('resources/js/app.js')
    @stack('styles')
</head>
<body>
<div class="page-loader" aria-hidden="true"></div>
<p id="network-status" class="disclaimer-box" tabindex="-1" role="status" hidden>{{ __('app.offline_message') }}</p>

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
                <li><a href="{{ route('search.index') }}" class="{{ request()->routeIs('search.*') ? 'active' : '' }}" aria-label="{{ __('app.search_all') }}" title="{{ __('app.search_all') }}">{{ __('app.nav_search_short') }}</a></li>
                <li><a href="{{ route('community.index') }}" class="{{ request()->routeIs('community.*') ? 'active' : '' }}" aria-label="{{ __('app.community_title') }}" title="{{ __('app.community_title') }}">{{ __('app.nav_community_short') }}</a></li>
                <li><a href="{{ route('sdg') }}" class="{{ request()->routeIs('sdg') ? 'active' : '' }}" aria-label="{{ __('app.sdg_title') }}" title="{{ __('app.sdg_title') }}">{{ __('app.nav_sdg_short') }}</a></li>
            </ul>

            <div class="nav-right" id="navRight">
            {{-- Language Switcher --}}
            <div class="lang-switcher" role="group" aria-label="{{ __('app.language') }}">
                <i class="fas fa-globe" aria-hidden="true"></i>
                <div class="lang-toggle" data-locale="{{ app()->getLocale() }}">
                    <a href="#"
                       class="lang-option lang-option--id {{ app()->getLocale() === 'id' ? 'active' : '' }}"
                       data-locale="id" data-locale-update="{{ route('lang.switch', 'id') }}"
                       aria-current="{{ app()->getLocale() === 'id' ? 'true' : 'false' }}">ID</a>
                    <a href="#"
                       class="lang-option lang-option--en {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                       data-locale="en" data-locale-update="{{ route('lang.switch', 'en') }}"
                       aria-current="{{ app()->getLocale() === 'en' ? 'true' : 'false' }}">EN</a>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-outline" data-pwa-install hidden>{{ __('app.install_app') }}</button>

            <details class="accessibility-menu">
                <summary class="btn btn-sm btn-outline" aria-label="{{ __('app.accessibility_settings') }}">
                    <i class="fas fa-universal-access" aria-hidden="true"></i>
                    <span>{{ __('app.accessibility_settings') }}</span>
                </summary>
                <div class="accessibility-menu-panel">
                    <h2>{{ __('app.accessibility_settings') }}</h2>
                    <button type="button" data-theme-toggle data-label="{{ __('app.toggle_dark_mode') }}">
                        <i class="fas fa-moon" aria-hidden="true"></i> {{ __('app.toggle_dark_mode') }}
                    </button>
                    <p style="margin:.8rem 0 .35rem;font-size:.8rem;font-weight:700">{{ __('app.text_size') }}</p>
                    <div class="font-size-options" role="group" aria-label="{{ __('app.text_size') }}">
                        <button type="button" data-font-size="small">{{ __('app.font_small') }}</button>
                        <button type="button" data-font-size="normal">{{ __('app.font_normal') }}</button>
                        <button type="button" data-font-size="large">{{ __('app.font_large') }}</button>
                    </div>
                    <button type="button" data-data-saver-toggle aria-pressed="false">
                        <i class="fas fa-gauge" aria-hidden="true"></i> {{ __('app.data_saver') }}
                    </button>
                </div>
            </details>

            @auth
                <details class="user-menu">
                    <summary class="btn btn-sm btn-outline user-menu-summary" title="{{ auth()->user()->name }}">
                        <i class="fas fa-user-circle" aria-hidden="true"></i> <span class="user-menu-name">{{ auth()->user()->name }}</span>
                    </summary>
                    <div class="user-menu-panel">
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.profile.index') : route('profile.index') }}">
                            <i class="fas fa-user" aria-hidden="true"></i> {{ __('app.my_profile') }}
                        </a>
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-tachometer-alt" aria-hidden="true"></i> {{ __('app.admin_dashboard') }}
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

        <button class="nav-toggle" id="navToggle" type="button" aria-label="{{ __('app.nav_menu') }}" aria-controls="navMenu" aria-expanded="false">
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
                    <li><a href="{{ route('obat.index') }}">{{ __('app.medicine_info') }}</a></li>
                    <li><a href="{{ route('penyakit.index') }}">{{ __('app.disease_info') }}</a></li>
                    <li><a href="{{ route('panduan.index') }}">{{ __('app.health_guides') }}</a></li>
                    <li><a href="{{ route('health-tools.bmi') }}">{{ __('app.bmi_title') }}</a></li>
                    <li><a href="{{ route('health-tools.mental-quiz') }}">{{ __('app.mental_quiz_title') }}</a></li>
                    <li><a href="{{ route('consultation.index') }}">{{ __('app.consultation_title') }}</a></li>
                </ul>
            </div>
            <div>
                <h4>{{ __('app.article_categories') }}</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('artikel.category', 'kesehatan-umum') }}">{{ __('app.article_category_general') }}</a></li>
                    <li><a href="{{ route('artikel.category', 'kesehatan-mental') }}">{{ __('app.article_category_mental') }}</a></li>
                    <li><a href="{{ route('artikel.category', 'diet-dan-nutrisi') }}">{{ __('app.article_category_nutrition') }}</a></li>
                    <li><a href="{{ route('artikel.category', 'kesehatan-anak') }}">{{ __('app.article_category_children') }}</a></li>
                    <li><a href="{{ route('artikel.category', 'gaya-hidup-sehat') }}">{{ __('app.article_category_lifestyle') }}</a></li>
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

@stack('scripts')
</body>
</html>
