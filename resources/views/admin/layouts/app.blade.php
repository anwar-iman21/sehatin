<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SEHATIN</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --green-50:#f0fdf4;--green-100:#dcfce7;--green-200:#bbf7d0;
            --green-500:#22c55e;--green-600:#16a34a;--green-700:#15803d;
            --slate-50:#f8fafc;--slate-100:#f1f5f9;--slate-200:#e2e8f0;
            --slate-300:#cbd5e1;--slate-400:#94a3b8;--slate-500:#64748b;
            --slate-600:#475569;--slate-700:#334155;--slate-800:#1e293b;--slate-900:#0f172a;
            --white:#ffffff;--radius:.75rem;
            --sidebar:240px;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--slate-100);color:var(--slate-800);min-height:100vh;display:flex}
        a{text-decoration:none;color:inherit}
        img{max-width:100%;display:block}

        /* ── SIDEBAR ── */
        .sidebar{
            width:var(--sidebar);flex-shrink:0;
            background:var(--slate-900);
            display:flex;flex-direction:column;
            position:fixed;top:0;left:0;height:100vh;
            overflow-y:auto;z-index:50;
            transition:transform .25s;
            scrollbar-width:thin;scrollbar-color:rgba(148,163,184,.48) transparent;
        }
        .sidebar::-webkit-scrollbar{width:8px}
        .sidebar::-webkit-scrollbar-track{background:transparent}
        .sidebar::-webkit-scrollbar-thumb{background:rgba(148,163,184,.4);border:2px solid transparent;border-radius:999px;background-clip:content-box}
        .sidebar::-webkit-scrollbar-thumb:hover{background:rgba(74,222,128,.8);border:2px solid transparent;background-clip:content-box}
        .sidebar-logo{
            padding:1.25rem 1.5rem;
            display:flex;align-items:center;gap:.6rem;
            font-weight:700;font-size:1.25rem;color:var(--white);
            border-bottom:1px solid rgba(255,255,255,.08);
        }
        .sidebar-logo .brand-word{color:var(--green-400)}
        .sidebar-logo em{font-style:normal;color:var(--white)}
        .sidebar-nav{flex:1;padding:1rem 0}
        .nav-section-label{
            padding:.5rem 1.5rem;
            font-size:.7rem;font-weight:700;letter-spacing:.1em;
            color:var(--slate-500);text-transform:uppercase;margin-top:.75rem;
        }
        .nav-item{
            display:flex;align-items:center;gap:.75rem;
            padding:.65rem 1.5rem;
            font-size:.875rem;font-weight:500;
            color:var(--slate-400);
            transition:all .15s;
            border-left:3px solid transparent;
        }
        .nav-item:hover{color:var(--white);background:rgba(255,255,255,.05)}
        .nav-item.active{color:var(--white);background:rgba(255,255,255,.08);border-left-color:var(--green-500)}
        .nav-item i{width:18px;text-align:center;font-size:.9rem;flex-shrink:0}
        .sidebar-footer{
            padding:1rem 1.5rem;
            border-top:1px solid rgba(255,255,255,.08);
            font-size:.8rem;color:var(--slate-500);
        }

        /* ── MAIN ── */
        .admin-main{
            margin-left:var(--sidebar);
            flex:1;display:flex;flex-direction:column;
            min-height:100vh;
        }

        /* ── TOPBAR ── */
        .topbar{
            background:var(--white);
            border-bottom:1px solid var(--slate-200);
            padding:.9rem 2rem;
            display:flex;align-items:center;justify-content:space-between;
            position:sticky;top:0;z-index:40;
            gap:1rem;
        }
        .topbar-title{font-size:1.1rem;font-weight:700;color:var(--slate-800)}
        .topbar-right{display:flex;align-items:center;gap:1rem}
        .lang-switcher{
            display:flex;align-items:center;gap:.55rem;
            font-size:.85rem;color:var(--slate-500);
        }
        .lang-toggle{
            position:relative;
            display:grid;
            grid-template-columns:repeat(2,2.4rem);
            padding:3px;
            border:1px solid var(--slate-200);
            border-radius:999px;
            background:var(--slate-100);
            box-shadow:inset 0 1px 2px rgba(15,23,42,.08);
        }
        .lang-toggle::before{
            content:"";
            position:absolute;
            top:3px;
            bottom:3px;
            left:3px;
            width:calc((100% - 6px) / 2);
            border-radius:999px;
            background:var(--green-600);
            box-shadow:0 2px 6px rgba(21,128,61,.25);
            transition:transform .25s cubic-bezier(.2,.8,.2,1),background-color .2s ease;
            pointer-events:none;
        }
        .lang-toggle[data-locale="en"]::before{transform:translateX(100%)}
        .lang-option{
            position:relative;
            z-index:1;
            display:flex;
            align-items:center;
            justify-content:center;
            min-height:1.65rem;
            border-radius:999px;
            font-size:.72rem;
            font-weight:700;
            color:var(--slate-600);
            transition:color .2s ease,transform .2s ease;
        }
        .lang-option.active{color:var(--white)}
        .lang-option:not(.active):hover{color:var(--green-700);transform:scale(1.08)}
        .lang-toggle:has(.lang-option--id:hover,.lang-option--id:focus-visible)::before{transform:translateX(0)}
        .lang-toggle:has(.lang-option--en:hover,.lang-option--en:focus-visible)::before{transform:translateX(100%)}
        .lang-toggle:has(.lang-option--id:hover,.lang-option--id:focus-visible) .lang-option--id,
        .lang-toggle:has(.lang-option--en:hover,.lang-option--en:focus-visible) .lang-option--en{color:#fff}
        .lang-toggle:has(.lang-option--id:hover,.lang-option--id:focus-visible) .lang-option--en.active,
        .lang-toggle:has(.lang-option--en:hover,.lang-option--en:focus-visible) .lang-option--id.active{color:var(--slate-600)}
        .lang-option:focus-visible{outline:2px solid var(--green-700);outline-offset:3px}
        .admin-avatar{
            width:36px;height:36px;border-radius:50%;
            background:var(--green-600);color:white;
            display:flex;align-items:center;justify-content:center;
            font-weight:700;font-size:.875rem;object-fit:cover;flex-shrink:0;
        }
        .topbar-user{font-size:.875rem;color:var(--slate-600);font-weight:500}
        .topbar-toggle{display:none;background:none;border:none;cursor:pointer;padding:.25rem;color:var(--slate-700)}

        /* ── CONTENT ── */
        .admin-content{padding:2rem;flex:1}
        .page-title{font-size:1.35rem;font-weight:700;color:var(--slate-800);margin-bottom:1.5rem}

        /* ── CARDS / WIDGETS ── */
        .stat-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem;margin-bottom:2rem}
        .stat-card{
            background:var(--white);border-radius:var(--radius);
            padding:1.5rem;display:flex;align-items:center;gap:1rem;
            border:1px solid var(--slate-200);
        }
        .stat-icon{
            width:48px;height:48px;border-radius:.75rem;
            display:flex;align-items:center;justify-content:center;
            font-size:1.25rem;flex-shrink:0;
        }
        .stat-value{font-size:1.75rem;font-weight:700;color:var(--slate-900);line-height:1}
        .stat-label{font-size:.8rem;color:var(--slate-500);margin-top:.3rem}

        /* ── TABLE ── */
        .table-card{background:var(--white);border-radius:var(--radius);border:1px solid var(--slate-200);overflow:hidden}
        .admin-inbox{max-width:1000px;margin:0 auto}
        .admin-inbox-empty{min-height:17rem;display:grid;justify-items:center;align-content:center;gap:.65rem;margin:1.25rem 0;padding:2rem 1.25rem;text-align:center;background:var(--white);border:1px dashed var(--slate-300);border-radius:.75rem}
        .admin-inbox-empty-icon{width:3.25rem;height:3.25rem;display:grid;place-items:center;border-radius:50%;background:var(--green-50);color:var(--green-700);font-size:1.2rem}
        .admin-inbox-empty h2{font-size:1rem;color:var(--slate-800)}
        .admin-inbox-empty p{max-width:26rem;color:var(--slate-500);font-size:.85rem;line-height:1.6}
        .admin-conversation-item{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:1rem 1.15rem;margin:.65rem 0;background:var(--white);border:1px solid var(--slate-200);border-radius:.65rem;transition:border-color .15s,background .15s}
        .admin-conversation-item:hover{border-color:var(--green-500);background:var(--green-50)}
        .admin-conversation-copy,.admin-conversation-meta{display:grid;gap:.2rem;min-width:0}
        .admin-conversation-copy strong{color:var(--slate-800)}
        .admin-conversation-copy>span,.admin-conversation-meta{font-size:.8rem;color:var(--slate-500)}
        .admin-conversation-preview{overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:min(65vw,650px)}
        .admin-conversation-meta{justify-items:end;flex-shrink:0}
        .admin-conversation-row{display:grid;grid-template-columns:minmax(0,1fr) auto;align-items:center;gap:.7rem;margin:.65rem 0}
        .admin-conversation-row .admin-conversation-item{margin:0}
        .admin-conversation-delete{flex-shrink:0}
        .admin-chat{max-width:900px;margin:0 auto}
        .admin-chat-header{margin:1.25rem 0 .75rem}
        .admin-chat-header h1{font-size:1.2rem}
        .admin-chat-header p{color:var(--slate-500);font-size:.85rem}
        .admin-chat-delete{float:right}
        .admin-chat-log{display:grid;gap:.75rem;max-height:60vh;overflow-y:auto;padding:1rem;background:var(--white);border:1px solid var(--slate-200);border-radius:var(--radius)}
        .admin-chat-message{max-width:min(82%,640px);padding:.8rem .95rem;border:1px solid var(--slate-200);border-radius:.7rem;background:var(--slate-50)}
        .admin-chat-message--admin{justify-self:end;background:var(--green-50);border-color:var(--green-200)}
        .admin-chat-sender,.admin-chat-message time{font-size:.75rem;color:var(--slate-500)}
        .admin-chat-body{margin:.25rem 0;white-space:pre-wrap;overflow-wrap:anywhere}
        .admin-chat-reply{display:grid;gap:.6rem;margin-top:1rem}
        .admin-chat-reply textarea{min-height:7rem;resize:vertical}
        .moderation-page{max-width:1100px;margin:0 auto}
        .moderation-header{display:flex;align-items:flex-end;justify-content:space-between;gap:1rem;margin-bottom:2rem}
        .moderation-header h1{font-size:1.65rem;color:var(--slate-800)}
        .moderation-header p{margin-top:.35rem;color:var(--slate-500);font-size:.9rem}
        .moderation-count{padding:.4rem .7rem;border-radius:999px;background:var(--white);border:1px solid var(--slate-200);font-size:.8rem;color:var(--slate-600);white-space:nowrap}
        .moderation-section-title{margin:1.25rem 0 .8rem;font-size:1.15rem;color:var(--slate-800)}
        .moderation-report{margin:.75rem 0;padding:1.1rem 1.2rem;background:var(--white);border:1px solid var(--slate-200);border-radius:.7rem;box-shadow:0 2px 8px rgba(15,23,42,.035)}
        .moderation-report-header,.moderation-report-tags,.moderation-report-footer,.moderation-actions{display:flex;align-items:center;justify-content:space-between;gap:.75rem;flex-wrap:wrap}
        .moderation-report-header{margin-bottom:.9rem}
        .moderation-report-header time,.moderation-reporter span{font-size:.78rem;color:var(--slate-500)}
        .moderation-type,.moderation-reason{display:inline-flex;padding:.25rem .6rem;border-radius:999px;background:var(--slate-100);color:var(--slate-700);font-size:.75rem;font-weight:700}
        .moderation-reason{background:#fff7ed;color:#9a3412}
        .moderation-content{padding:.85rem 1rem;border-left:3px solid var(--green-500);background:var(--slate-50);border-radius:0 .5rem .5rem 0}
        .moderation-content>strong{display:block;margin-bottom:.35rem;color:var(--slate-500);font-size:.72rem;text-transform:uppercase}
        .moderation-content h3{margin:0 0 .35rem;font-size:1rem;color:var(--slate-800)}
        .moderation-content p,.moderation-details{color:var(--slate-600);font-size:.875rem;line-height:1.6;overflow-wrap:anywhere}
        .moderation-context-link{display:inline-block;margin-top:.4rem;color:var(--green-700);font-size:.82rem;font-weight:700}
        .moderation-content-unavailable{padding:.85rem 1rem;background:var(--slate-50);color:var(--slate-500);border-radius:.5rem;font-size:.85rem}
        .moderation-details{margin-top:.8rem}
        .moderation-report-footer{margin-top:1rem;padding-top:.85rem;border-top:1px solid var(--slate-100)}
        .moderation-reporter{display:grid;gap:.12rem;font-size:.82rem;color:var(--slate-700)}
        .moderation-actions{justify-content:flex-end}
        .moderation-doctors{margin-top:2.25rem;padding-top:1.25rem;border-top:1px solid var(--slate-200)}
        .moderation-doctor{display:flex;align-items:center;justify-content:space-between;gap:1rem;padding:.85rem 1rem;margin:.5rem 0;background:var(--white);border:1px solid var(--slate-200);border-radius:.6rem}
        .moderation-doctor span{display:grid;gap:.15rem;min-width:0}
        .moderation-doctor small{color:var(--slate-500);overflow-wrap:anywhere}
        .moderation-empty{padding:1.2rem;background:var(--white);border:1px dashed var(--slate-300);border-radius:.6rem;color:var(--slate-500)}
        .table-header{
            display:flex;align-items:center;justify-content:space-between;
            padding:1.25rem 1.5rem;border-bottom:1px solid var(--slate-200);gap:1rem;flex-wrap:wrap;
        }
        .table-header h3{font-size:1rem;font-weight:700;color:var(--slate-800)}
        table{width:100%;border-collapse:collapse}
        th{padding:.75rem 1rem;text-align:left;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;color:var(--slate-500);background:var(--slate-50);border-bottom:1px solid var(--slate-200)}
        td{padding:.85rem 1rem;font-size:.875rem;color:var(--slate-700);border-bottom:1px solid var(--slate-100);vertical-align:middle}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:var(--slate-50)}
        .td-actions{display:flex;align-items:center;gap:.4rem;flex-wrap:nowrap;white-space:nowrap}
        .td-actions form{flex-shrink:0}

        /* ── FORM ── */
        .form-card{background:var(--white);border-radius:var(--radius);border:1px solid var(--slate-200);padding:2rem}
        .form-group{margin-bottom:1.25rem}
        .form-label{display:block;font-size:.875rem;font-weight:600;color:var(--slate-700);margin-bottom:.4rem}
        .form-hint{font-size:.78rem;color:var(--slate-400);margin-top:.3rem}
        .form-control{
            width:100%;padding:.65rem .9rem;
            border:1.5px solid var(--slate-200);border-radius:.55rem;
            font-size:.9rem;font-family:inherit;outline:none;
            transition:border .15s;background:var(--white);color:var(--slate-800);
        }
        .form-control:focus{border-color:var(--green-500)}
        textarea.form-control{resize:vertical;min-height:140px}
        select.form-control{cursor:pointer}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:1.25rem}
        .form-check{display:flex;align-items:center;gap:.5rem;cursor:pointer;font-size:.875rem;color:var(--slate-700)}
        .form-check input{accent-color:var(--green-600);width:16px;height:16px}
        .form-actions{display:flex;align-items:center;gap:.75rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--slate-200)}

        /* ── BUTTONS ── */
        .btn{display:inline-flex;align-items:center;gap:.4rem;padding:.5rem 1.1rem;border-radius:.55rem;font-size:.875rem;font-weight:600;transition:all .15s;cursor:pointer;border:none;font-family:inherit}
        .btn-primary{background:var(--green-600);color:var(--white)}
        .btn-primary:hover{background:var(--green-700)}
        .btn-secondary{background:var(--slate-600);color:var(--white)}
        .btn-secondary:hover{background:var(--slate-700)}
        .btn-outline{background:transparent;color:var(--slate-700);border:1.5px solid var(--slate-300)}
        .btn-outline:hover{background:var(--slate-50)}
        .btn-danger{background:#dc2626;color:var(--white)}
        .btn-danger:hover{background:#b91c1c}
        .btn-warning{background:#d97706;color:var(--white)}
        .btn-warning:hover{background:#b45309}
        .btn-success{background:var(--green-600);color:var(--white)}
        .btn-sm{padding:.35rem .75rem;font-size:.8rem}
        .btn-xs{padding:.25rem .55rem;font-size:.75rem}

        /* ── BADGES ── */
        .badge{display:inline-flex;align-items:center;gap:.3rem;padding:.25rem .65rem;border-radius:999px;font-size:.75rem;font-weight:600}
        .badge-green{background:var(--green-100);color:var(--green-700)}
        .badge-gray{background:var(--slate-100);color:var(--slate-600)}
        .badge-red{background:#fee2e2;color:#991b1b}

        /* ── ALERTS ── */
        .alert{padding:.85rem 1.1rem;border-radius:.6rem;font-size:.875rem;margin-bottom:1.25rem;display:flex;align-items:flex-start;gap:.6rem}
        .alert-success{background:var(--green-50);color:#166534;border:1px solid var(--green-200)}
        .alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}

        /* ── THUMBNAIL PREVIEW ── */
        .thumb-preview{width:80px;height:60px;border-radius:.4rem;object-fit:cover;border:1px solid var(--slate-200)}

        /* ── PAGINATION ── */
        .pagination-wrap{padding:1rem 1.5rem;border-top:1px solid var(--slate-200);display:flex;justify-content:flex-end}

        /* ── MOBILE ── */
        @media(max-width:1024px){.stat-grid{grid-template-columns:repeat(2,1fr)}}
        @media(max-width:768px){
            .sidebar{transform:translateX(-100%)}
            .sidebar.open{transform:translateX(0)}
            .admin-main{margin-left:0}
            .topbar-toggle{display:block}
            .stat-grid{grid-template-columns:1fr 1fr}
            .form-row{grid-template-columns:1fr}
            .admin-content{padding:1.25rem}
            .admin-conversation-preview{max-width:55vw}
            .admin-chat-message{max-width:95%}
            .moderation-header{align-items:flex-start;flex-direction:column}
            .moderation-report-footer{align-items:flex-start;flex-direction:column}
            .moderation-actions,.moderation-actions form,.moderation-actions .btn{width:100%}
            .moderation-doctor{align-items:flex-start;flex-direction:column}
            .moderation-doctor .btn{width:100%;justify-content:center}
            .admin-conversation-row{grid-template-columns:minmax(0,1fr);}
            .admin-conversation-delete .btn{width:100%;justify-content:center}
        }
        @media(max-width:480px){.stat-grid{grid-template-columns:1fr}}
        @media(prefers-reduced-motion:reduce){
            .lang-toggle::before,.lang-option{transition-duration:.01ms!important}
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- SIDEBAR --}}
<aside class="sidebar" id="adminSidebar">
    <div class="sidebar-logo">
        <i class="fas fa-leaf" style="color:var(--green-400)"></i>
        <span class="brand-word">SEHAT<em>IN</em></span>
        <span style="font-size:.7rem;background:rgba(255,255,255,.12);padding:.2rem .5rem;border-radius:.3rem;margin-left:auto;color:var(--slate-400)">Admin</span>
    </div>

    <nav class="sidebar-nav">
        <p class="nav-section-label">Utama</p>
        <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> {{ __('admin.dashboard') }}
        </a>

        <p class="nav-section-label">Konten</p>
        <a href="{{ route('admin.artikel.index') }}" class="nav-item {{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i> {{ __('admin.articles') }}
        </a>
        <a href="{{ route('admin.kategori.index') }}" class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
            <i class="fas fa-tags"></i> {{ __('admin.categories') }}
        </a>
        <a href="{{ route('admin.layanan.index') }}" class="nav-item {{ request()->routeIs('admin.layanan.*') ? 'active' : '' }}">
            <i class="fas fa-stethoscope"></i> {{ __('admin.services') }}
        </a>
        <a href="{{ route('admin.faq.index') }}" class="nav-item {{ request()->routeIs('admin.faq.*') ? 'active' : '' }}">
            <i class="fas fa-question-circle"></i> {{ __('admin.faqs') }}
        </a>
        <a href="{{ route('admin.halaman.index') }}" class="nav-item {{ request()->routeIs('admin.halaman.*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> {{ __('admin.pages') }}
        </a>
        <a href="{{ route('admin.obat.index') }}" class="nav-item {{ request()->routeIs('admin.obat.*') ? 'active' : '' }}">
            <i class="fas fa-pills"></i> Info Obat
        </a>
        <a href="{{ route('admin.penyakit.index') }}" class="nav-item {{ request()->routeIs('admin.penyakit.*') ? 'active' : '' }}">
            <i class="fas fa-virus"></i> Info Penyakit
        </a>
        <a href="{{ route('admin.panduan.index') }}" class="nav-item {{ request()->routeIs('admin.panduan.*') ? 'active' : '' }}">
            <i class="fas fa-book-medical"></i> Panduan Kesehatan
        </a>

        <p class="nav-section-label">Layanan pengguna</p>
        <a href="{{ route('admin.community.moderation') }}" class="nav-item {{ request()->routeIs('admin.community.*') ? 'active' : '' }}">
            <i class="fas fa-flag"></i> {{ __('app.community_moderation') }}
        </a>
        <a href="{{ route('admin.consultations.index') }}" class="nav-item {{ request()->routeIs('admin.consultations.*') ? 'active' : '' }}">
            <i class="fas fa-comments"></i> {{ __('app.consultation_inbox') }}
        </a>

        <p class="nav-section-label">Lainnya</p>
        <a href="{{ route('admin.profile.index') }}" class="nav-item {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
            <i class="fas fa-user"></i> Profil Saya
        </a>
        <a href="{{ route('home') }}" target="_blank" class="nav-item">
            <i class="fas fa-external-link-alt"></i> Lihat Website
        </a>
    </nav>

    <div class="sidebar-footer">
        <p style="color:var(--slate-400);font-size:.78rem">Login sebagai</p>
        <p style="color:var(--white);font-weight:600;font-size:.875rem;margin-top:.2rem">{{ auth()->user()->name }}</p>
        <form action="{{ route('logout') }}" method="POST" style="margin-top:.75rem">
            @csrf
            <button type="submit" class="btn btn-sm btn-danger" style="width:100%;justify-content:center">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </button>
        </form>
    </div>
</aside>

{{-- MAIN --}}
<div class="admin-main">
    <header class="topbar">
        <div style="display:flex;align-items:center;gap:1rem">
            <button class="topbar-toggle" id="sidebarToggle"><i class="fas fa-bars"></i></button>
            <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
        </div>
        <div class="topbar-right">
            <div class="lang-switcher" role="group" aria-label="{{ __('app.language') }}">
                <i class="fas fa-globe"></i>
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
            @if(auth()->user()->avatar)
                <img
                    class="admin-avatar"
                    src="{{ \Illuminate\Support\Str::startsWith(auth()->user()->avatar, ['http://', 'https://']) ? auth()->user()->avatar : asset('storage/'.auth()->user()->avatar) }}"
                    alt="Avatar {{ auth()->user()->name }}"
                >
            @else
                <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            @endif
            <span class="topbar-user">{{ auth()->user()->name }}</span>
        </div>
    </header>

    <main class="admin-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    const toggle  = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    if(toggle) toggle.addEventListener('click', () => sidebar.classList.toggle('open'));

    document.addEventListener('click', event => {
        const button = event.target.closest('.btn-delete-confirm');
        if (button && !window.confirm(button.dataset.confirm || '{{ __('admin.confirm_delete') }}')) {
            event.preventDefault();
        }
    });

    document.querySelectorAll('a[data-locale-update]').forEach(link => {
        link.addEventListener('click', async event => {
            event.preventDefault();
            const token = document.querySelector('meta[name="csrf-token"]')?.content || '';
            const response = await fetch(link.dataset.localeUpdate, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token,
                },
                body: '{}',
                credentials: 'same-origin',
            });
            if (response.ok) window.location.reload();
        });
    });

    const consultationLog = document.querySelector('[data-admin-chat-log]');
    if (consultationLog) {
        window.setInterval(async () => {
            if (document.visibilityState !== 'visible') return;
            const after = Number(consultationLog.dataset.lastMessageId || 0);
            try {
                const response = await fetch(`${consultationLog.dataset.messagesUrl}?after=${after}`, {
                    headers: { Accept: 'application/json' },
                    cache: 'no-store',
                });
                if (!response.ok) return;
                const data = await response.json();
                if (data.reset) {
                    consultationLog.replaceChildren();
                    consultationLog.dataset.lastMessageId = '0';
                }
                if (!data.messages?.length && data.reset) {
                    const empty = document.createElement('p');
                    empty.textContent = consultationLog.dataset.emptyLabel;
                    consultationLog.append(empty);
                }
                for (const message of data.messages || []) {
                    const article = document.createElement('article');
                    article.className = `admin-chat-message admin-chat-message--${message.sender}`;
                    article.dataset.messageId = String(message.id);
                    const sender = document.createElement('p');
                    sender.className = 'admin-chat-sender';
                    sender.textContent = message.sender_name;
                    const body = document.createElement('p');
                    body.className = 'admin-chat-body';
                    body.textContent = message.message;
                    article.append(sender, body);
                    consultationLog.append(article);
                    consultationLog.dataset.lastMessageId = String(message.id);
                }
                consultationLog.scrollTop = consultationLog.scrollHeight;
            } catch (error) {
                console.error('Unable to check consultation messages.', error);
            }
        }, 1000);
    }

    const consultationInbox = document.querySelector('[data-admin-inbox]');
    if (consultationInbox) {
        window.setInterval(async () => {
            if (document.visibilityState !== 'visible') return;
            const after = Number(consultationInbox.dataset.lastMessageId || 0);
            try {
                const response = await fetch(`${consultationInbox.dataset.updatesUrl}?after=${after}`, {
                    headers: { Accept: 'application/json' },
                    cache: 'no-store',
                });
                if (!response.ok) return;
                const data = await response.json();
                for (const message of data.messages || []) {
                    const userId = String(message.user.id);
                    let row = consultationInbox.querySelector(`[data-user-id="${userId}"]`);
                    if (!row) {
                        row = document.createElement('div');
                        row.className = 'admin-conversation-row';
                        row.dataset.userId = userId;
                    }

                    const link = document.createElement('a');
                    link.className = 'admin-conversation-item';
                    link.href = message.show_url;
                    const copy = document.createElement('span');
                    copy.className = 'admin-conversation-copy';
                    const name = document.createElement('strong');
                    name.textContent = message.user.name;
                    const email = document.createElement('span');
                    email.textContent = message.user.email;
                    const preview = document.createElement('span');
                    preview.className = 'admin-conversation-preview';
                    preview.textContent = message.message;
                    copy.append(name, email, preview);
                    const meta = document.createElement('span');
                    meta.className = 'admin-conversation-meta';
                    const time = document.createElement('time');
                    time.textContent = message.created_at;
                    meta.append(time);
                    if (message.awaiting_reply) {
                        const badge = document.createElement('span');
                        badge.className = 'badge badge-red';
                        badge.textContent = '{{ __('app.consultation_unanswered') }}';
                        meta.append(badge);
                    }
                    link.append(copy, meta);

                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = message.delete_url;
                    form.className = 'admin-conversation-delete';
                    const token = document.createElement('input');
                    token.type = 'hidden';
                    token.name = '_token';
                    token.value = consultationInbox.dataset.csrf;
                    const method = document.createElement('input');
                    method.type = 'hidden';
                    method.name = '_method';
                    method.value = 'DELETE';
                    const remove = document.createElement('button');
                    remove.type = 'submit';
                    remove.className = 'btn btn-sm btn-danger btn-delete-confirm';
                    remove.dataset.confirm = consultationInbox.dataset.deleteConfirm;
                    remove.setAttribute('aria-label', `${consultationInbox.dataset.deleteLabel} ${message.user.name}`);
                    const icon = document.createElement('i');
                    icon.className = 'fas fa-trash';
                    icon.setAttribute('aria-hidden', 'true');
                    const label = document.createElement('span');
                    label.textContent = consultationInbox.dataset.deleteLabel;
                    remove.append(icon, label);
                    form.append(token, method, remove);
                    row.replaceChildren(link, form);
                    consultationInbox.querySelector('[data-inbox-empty]')?.remove();
                    consultationInbox.prepend(row);
                }
                consultationInbox.dataset.lastMessageId = String(Math.max(after, Number(data.latest_message_id || 0)));
            } catch (error) {
                console.error('Unable to refresh consultation inbox.', error);
            }
        }, 2000);
    }
</script>
@stack('scripts')
</body>
</html>
