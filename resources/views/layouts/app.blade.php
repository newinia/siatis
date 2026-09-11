<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'SIATIS') }}
    </title>


    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,400,0,0"
        rel="stylesheet">


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body x-data="{
        sidebarOpen: true,
        mobileOpen: false,

        ppksOpen: {{ request()->routeIs(
    'ppks.import',
    'ppks.normal',
    'ppks.manual',
    'ppks.normal.create',
    'ppks.normal.edit',
    'ppks.perlu-diperiksa'
) ? 'true' : 'false' }},

        instructorOpen: {{ request()->routeIs(
    'ppks.normal.instruktur',
    'ppks.normal.asesmen-instruktur.lulus',
    'ppks.normal.asesmen-instruktur.pending',
    'ppks.normal.asesmen-instruktur.tidak-lulus'
) ? 'true' : 'false' }},

        healthOpen: {{ request()->routeIs(
    'ppks.normal.kesehatan',
    'ppks.normal.asesmen-kesehatan.lulus',
    'ppks.normal.asesmen-kesehatan.pending',
    'ppks.normal.asesmen-kesehatan.tidak-lulus'
) ? 'true' : 'false' }},

        caseConferenceOpen: {{ request()->routeIs(
    'ppks.normal.case-conference.belum',
    'ppks.normal.case-conference.sudah'
) ? 'true' : 'false' }},

        healthLanjutanOpen: {{ request()->routeIs(
    'ppks.normal.kesehatan-lanjutan',
    'ppks.normal.kesehatan-lanjutan.lulus',
    'ppks.normal.kesehatan-lanjutan.pending',
    'ppks.normal.kesehatan-lanjutan.tidak-lulus',
    'ppks.normal.kesehatan-lanjutan.detail'
) ? 'true' : 'false' }}
    }">


    {{-- =====================================================
    SIDEBAR DESKTOP
    ====================================================== --}}

    <aside class="app-sidebar" :class="{ 'sidebar-closed': !sidebarOpen }">

        {{-- HEADER SIDEBAR --}}

        <div class="sidebar-header">

            <div class="sidebar-label">
                MENU UTAMA
            </div>

            <div class="sidebar-divider"></div>

        </div>


        <nav class="sidebar-menu">


            {{-- =================================================
            DASHBOARD
            ================================================== --}}

            @if (Route::has('dashboard'))

                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                    <span class="material-symbols-outlined nav-icon">
                        dashboard
                    </span>

                    <span class="nav-text">
                        Dashboard
                    </span>

                </a>

            @endif



            {{-- =================================================
            DAFTAR ADMIN
            ================================================== --}}

            @if (
                    Auth::check() &&
                    Auth::user()->role === 'super_admin' &&
                    Route::has('admin.index')
                )

                <a href="{{ route('admin.index') }}" class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}">

                    <span class="material-symbols-outlined nav-icon">
                        manage_accounts
                    </span>

                    <span class="nav-text">
                        Daftar Admin
                    </span>

                </a>

            @endif



            {{-- =================================================
            DATA PPKS
            ================================================== --}}

            <div class="nav-group">

                <button type="button" class="nav-item nav-parent {{
    request()->routeIs(
        'ppks.import',
        'ppks.normal',
        'ppks.manual',
        'ppks.normal.create',
        'ppks.normal.edit',
        'ppks.perlu-diperiksa'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': ppksOpen }" @click="ppksOpen = !ppksOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            description
                        </span>

                        <span class="nav-text">
                            Data PPKS
                        </span>

                    </span>


                    <span class="material-symbols-outlined nav-arrow" :class="{ 'rotate': ppksOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="ppksOpen" x-transition class="nav-submenu">

                    <a href="{{ route('ppks.import') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.import')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            upload_file
                        </span>

                        <span>
                            Import Data
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Normal
                        </span>

                    </a>


                    <a href="{{ route('ppks.manual') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.manual') ||
    request()->routeIs('ppks.normal.create') ||
    request()->routeIs('ppks.normal.edit')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            person_add
                        </span>

                        <span>
                            Tambah Data
                        </span>

                    </a>


                    <a href="{{ route('ppks.perlu-diperiksa') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.perlu-diperiksa')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            find_in_page
                        </span>

                        <span>
                            Perlu Pemeriksaan
                        </span>

                    </a>

                </div>

            </div>



            {{-- =================================================
            ASESMEN INSTRUKTUR
            ================================================== --}}

            <div class="nav-group">

                <button type="button" class="nav-item nav-parent {{
    request()->routeIs(
        'ppks.normal.instruktur',
        'ppks.normal.asesmen-instruktur.lulus',
        'ppks.normal.asesmen-instruktur.pending',
        'ppks.normal.asesmen-instruktur.tidak-lulus'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': instructorOpen }" @click="instructorOpen = !instructorOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            badge
                        </span>

                        <span class="nav-text">
                            Asesmen Instruktur
                        </span>

                    </span>


                    <span class="material-symbols-outlined nav-arrow" :class="{ 'rotate': instructorOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="instructorOpen" x-transition class="nav-submenu">

                    <a href="{{ route('ppks.normal.instruktur') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.instruktur')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            assignment
                        </span>

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-instruktur.lulus') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-instruktur.lulus')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-instruktur.pending') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-instruktur.pending')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-instruktur.tidak-lulus') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-instruktur.tidak-lulus')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lulus
                        </span>

                    </a>

                </div>

            </div>



            {{-- =================================================
            ASESMEN KESEHATAN AWAL
            ================================================== --}}

            <div class="nav-group">

                <button type="button" class="nav-item nav-parent {{
    request()->routeIs(
        'ppks.normal.kesehatan',
        'ppks.normal.asesmen-kesehatan.lulus',
        'ppks.normal.asesmen-kesehatan.pending',
        'ppks.normal.asesmen-kesehatan.tidak-lulus'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': healthOpen }" @click="healthOpen = !healthOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            medical_information
                        </span>

                        <span class="nav-text">
                            Asesmen Kesehatan Awal
                        </span>

                    </span>


                    <span class="material-symbols-outlined nav-arrow" :class="{ 'rotate': healthOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="healthOpen" x-transition class="nav-submenu">

                    <a href="{{ route('ppks.normal.kesehatan') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.kesehatan')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            assignment
                        </span>

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-kesehatan.lulus') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-kesehatan.lulus')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-kesehatan.pending') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-kesehatan.pending')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-kesehatan.tidak-lulus') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-kesehatan.tidak-lulus')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lulus
                        </span>

                    </a>

                </div>

            </div>



            {{-- =================================================
            CASE CONFERENCE
            ================================================== --}}

            <div class="nav-group">

                <button type="button" class="nav-item nav-parent {{
    request()->routeIs(
        'ppks.normal.case-conference.belum',
        'ppks.normal.case-conference.sudah'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': caseConferenceOpen }" @click="caseConferenceOpen = !caseConferenceOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            groups
                        </span>

                        <span class="nav-text">
                            Case Conference
                        </span>

                    </span>


                    <span class="material-symbols-outlined nav-arrow" :class="{ 'rotate': caseConferenceOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="caseConferenceOpen" x-transition class="nav-submenu">

                    <a href="{{ route('ppks.normal.case-conference.belum') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.case-conference.belum')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            assignment
                        </span>

                        <span>
                            Belum Dilakukan
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.case-conference.sudah') }}" class="nav-submenu-item {{
    request()->routeIs('ppks.normal.case-conference.sudah')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            task_alt
                        </span>

                        <span>  
                            Sudah Dilakukan
                        </span>

                    </a>

                </div>

            </div>


            {{-- =================================================
            PEMANGGILAN PESERTA
            ================================================== --}}

            @if (Route::has('ppks.normal.pemanggilan'))

                    <a href="{{ route('ppks.normal.pemanggilan') }}" class="nav-item {{
                request()->routeIs('ppks.normal.pemanggilan')
                ? 'active'
                : ''
                            }}">

                        <span class="material-symbols-outlined nav-icon">
                            record_voice_over
                        </span>

                        <span class="nav-text">
                            Pemanggilan Peserta
                        </span>

                    </a>

            @endif



            {{-- =================================================
            KESEHATAN LANJUTAN
            ================================================== --}}

            <div class="nav-group">

                <button type="button" class="nav-item nav-parent {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan',
        'ppks.normal.kesehatan-lanjutan.lulus',
        'ppks.normal.kesehatan-lanjutan.pending',
        'ppks.normal.kesehatan-lanjutan.tidak-lulus',
        'ppks.normal.kesehatan-lanjutan.detail'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': healthLanjutanOpen }" @click="healthLanjutanOpen = !healthLanjutanOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            medical_services
                        </span>

                        <span class="nav-text">
                            Kesehatan Lanjutan
                        </span>

                    </span>


                    <span class="material-symbols-outlined nav-arrow" :class="{ 'rotate': healthLanjutanOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="healthLanjutanOpen" x-transition class="nav-submenu">

                    {{-- BELUM ASESMEN --}}
                    <a href="{{ route('ppks.normal.kesehatan-lanjutan') }}" class="nav-submenu-item {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan',
        'ppks.normal.kesehatan-lanjutan.detail'
    )
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            assignment
                        </span>

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    {{-- DATA LULUS --}}
                    <a href="{{ route('ppks.normal.kesehatan-lanjutan.lulus') }}" class="nav-submenu-item {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan.lulus'
    )
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    {{-- DATA PENDING --}}
                    <a href="{{ route('ppks.normal.kesehatan-lanjutan.pending') }}" class="nav-submenu-item {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan.pending'
    )
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    {{-- DATA TIDAK LULUS --}}
                    <a href="{{ route('ppks.normal.kesehatan-lanjutan.tidak-lulus') }}" class="nav-submenu-item {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan.tidak-lulus'
    )
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined nav-icon">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lulus
                        </span>

                    </a>

                </div>

            </div>



            {{-- =================================================
            PESERTA AKTIF
            ================================================== --}}

            <a href="{{ route('ppks.normal.peserta-aktif') }}" class="nav-item">

                <span class="material-symbols-outlined nav-icon">
                    group
                </span>

                <span class="nav-text">
                    Peserta Aktif
                </span>

            </a>


        </nav>



        {{-- =====================================================
        LOGOUT
        ====================================================== --}}

        <div class="sidebar-footer">

            @if (Route::has('logout'))

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit" class="logout-button">

                        <span class="material-symbols-outlined nav-icon">
                            logout
                        </span>

                        <span>
                            Keluar
                        </span>

                    </button>

                </form>

            @endif

        </div>

    </aside>



    {{-- =====================================================
    TOP NAVBAR
    ====================================================== --}}

    <header class="top-navbar" :class="{ 'sidebar-closed': !sidebarOpen }">

        <button type="button" class="navbar-hamburger" @click="
                if (window.innerWidth <= 768) {
                    mobileOpen = true;
                } else {
                    sidebarOpen = !sidebarOpen;
                }
            " aria-label="Toggle Navigation">

            <span class="material-symbols-outlined" x-text="
                    window.innerWidth <= 768
                        ? 'menu'
                        : (sidebarOpen ? 'menu_open' : 'menu')
                "></span>

        </button>



        {{-- USER --}}

        <div class="navbar-user">

            <div class="navbar-user-info">

                <div class="navbar-user-name">
                    {{ Auth::user()->name }}
                </div>

                <div class="navbar-user-role">
                    {{ Auth::user()->role ?? 'Super Admin' }}
                </div>

            </div>


            <div class="navbar-avatar">

                <span class="material-symbols-outlined">
                    person
                </span>

            </div>

        </div>

    </header>



    {{-- =====================================================
    MOBILE NAVIGATION
    ====================================================== --}}

    <div x-show="mobileOpen" x-transition class="mobile-navigation">

        <div class="mobile-nav-header">

            <span>
                MENU UTAMA
            </span>


            <button type="button" class="mobile-close-button" @click="mobileOpen = false">

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        <nav class="mobile-nav-menu">


            {{-- =================================================
            DASHBOARD
            ================================================== --}}

            @if (Route::has('dashboard'))

                    <a href="{{ route('dashboard') }}" class="mobile-nav-item {{
                request()->routeIs('dashboard')
                ? 'active'
                : ''
                            }}">

                        <span class="material-symbols-outlined">
                            dashboard
                        </span>

                        <span>
                            Dashboard
                        </span>

                    </a>

            @endif



            {{-- =================================================
            DAFTAR ADMIN
            ================================================== --}}

            @if (
                        Auth::check() &&
                        Auth::user()->role === 'super_admin' &&
                        Route::has('admin.index')
                    )

                    <a href="{{ route('admin.index') }}" class="mobile-nav-item {{
                request()->routeIs('admin.*')
                ? 'active'
                : ''
                            }}">

                        <span class="material-symbols-outlined">
                            manage_accounts
                        </span>

                        <span>
                            Daftar Admin
                        </span>

                    </a>

            @endif



            {{-- =================================================
            DATA PPKS MOBILE
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button" class="mobile-nav-parent {{
    request()->routeIs(
        'ppks.import',
        'ppks.normal',
        'ppks.manual',
        'ppks.normal.create',
        'ppks.normal.edit',
        'ppks.perlu-diperiksa'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': ppksOpen }" @click="ppksOpen = !ppksOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            description
                        </span>

                        <span>
                            Data PPKS
                        </span>

                    </span>


                    <span class="material-symbols-outlined mobile-nav-arrow" :class="{ 'rotate': ppksOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="ppksOpen" x-transition class="mobile-submenu">

                    <a href="{{ route('ppks.import') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.import')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            upload_file
                        </span>

                        <span>
                            Import Data
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Normal
                        </span>

                    </a>


                    <a href="{{ route('ppks.manual') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.manual') ||
    request()->routeIs('ppks.normal.create') ||
    request()->routeIs('ppks.normal.edit')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            person_add
                        </span>

                        <span>
                            Tambah Data
                        </span>

                    </a>


                    <a href="{{ route('ppks.perlu-diperiksa') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.perlu-diperiksa')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            find_in_page
                        </span>

                        <span>
                            Perlu Pemeriksaan
                        </span>

                    </a>

                </div>

            </div>



            {{-- =================================================
            ASESMEN INSTRUKTUR MOBILE
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button" class="mobile-nav-parent {{
    request()->routeIs(
        'ppks.normal.instruktur',
        'ppks.normal.asesmen-instruktur.lulus',
        'ppks.normal.asesmen-instruktur.pending',
        'ppks.normal.asesmen-instruktur.tidak-lulus'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': instructorOpen }" @click="instructorOpen = !instructorOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            badge
                        </span>

                        <span>
                            Asesmen Instruktur
                        </span>

                    </span>


                    <span class="material-symbols-outlined mobile-nav-arrow" :class="{ 'rotate': instructorOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="instructorOpen" x-transition class="mobile-submenu">

                    <a href="{{ route('ppks.normal.instruktur') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.instruktur')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            assignment
                        </span>

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-instruktur.lulus') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-instruktur.lulus')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-instruktur.pending') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-instruktur.pending')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-instruktur.tidak-lulus') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-instruktur.tidak-lulus')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lulus
                        </span>

                    </a>

                </div>

            </div>



            {{-- =================================================
            ASESMEN KESEHATAN AWAL MOBILE
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button" class="mobile-nav-parent {{
    request()->routeIs(
        'ppks.normal.kesehatan',
        'ppks.normal.asesmen-kesehatan.lulus',
        'ppks.normal.asesmen-kesehatan.pending',
        'ppks.normal.asesmen-kesehatan.tidak-lulus'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': healthOpen }" @click="healthOpen = !healthOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            medical_information
                        </span>

                        <span>
                            Asesmen Kesehatan Awal
                        </span>

                    </span>


                    <span class="material-symbols-outlined mobile-nav-arrow" :class="{ 'rotate': healthOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="healthOpen" x-transition class="mobile-submenu">

                    <a href="{{ route('ppks.normal.kesehatan') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.kesehatan')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            assignment
                        </span>

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-kesehatan.lulus') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-kesehatan.lulus')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-kesehatan.pending') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-kesehatan.pending')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.asesmen-kesehatan.tidak-lulus') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.asesmen-kesehatan.tidak-lulus')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lulus
                        </span>

                    </a>

                </div>

            </div>



            {{-- =================================================
            CASE CONFERENCE MOBILE
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button" class="mobile-nav-parent {{
    request()->routeIs(
        'ppks.normal.case-conference.belum',
        'ppks.normal.case-conference.sudah'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': caseConferenceOpen }" @click="caseConferenceOpen = !caseConferenceOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            groups
                        </span>

                        <span>
                            Case Conference
                        </span>

                    </span>


                    <span class="material-symbols-outlined mobile-nav-arrow" :class="{ 'rotate': caseConferenceOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="caseConferenceOpen" x-transition class="mobile-submenu">

                    <a href="{{ route('ppks.normal.case-conference.belum') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.case-conference.belum')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            assignment
                        </span>

                        <span>
                            Belum Dilakukan
                        </span>

                    </a>


                    <a href="{{ route('ppks.normal.case-conference.sudah') }}" class="mobile-submenu-item {{
    request()->routeIs('ppks.normal.case-conference.sudah')
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            task_alt
                        </span>

                        <span>
                            Sudah Dilakukan
                        </span>

                    </a>

                </div>

            </div>



            {{-- =================================================
            DATA DITERIMA MOBILE
            ================================================== --}}

            @if (Route::has('ppks.diterima'))

                    <a href="{{ route('ppks.diterima') }}" class="mobile-nav-item {{
                request()->routeIs('ppks.diterima')
                ? 'active'
                : ''
                            }}">

                        <span class="material-symbols-outlined">
                            verified
                        </span>

                        <span>
                            Data Diterima
                        </span>

                    </a>

            @endif



            {{-- =================================================
            DATA TIDAK DITERIMA MOBILE
            ================================================== --}}

            @if (Route::has('ppks.tidak-diterima'))

                    <a href="{{ route('ppks.tidak-diterima') }}" class="mobile-nav-item {{
                request()->routeIs('ppks.tidak-diterima')
                ? 'active'
                : ''
                            }}">

                        <span class="material-symbols-outlined">
                            block
                        </span>

                        <span>
                            Data Tidak Diterima
                        </span>

                    </a>

            @endif



            {{-- =================================================
            PEMANGGILAN PESERTA MOBILE
            ================================================== --}}

            @if (Route::has('ppks.normal.pemanggilan'))

                    <a href="{{ route('ppks.normal.pemanggilan') }}" class="mobile-nav-item {{
                request()->routeIs('ppks.normal.pemanggilan')
                ? 'active'
                : ''
                            }}">

                        <span class="material-symbols-outlined">
                            record_voice_over
                        </span>

                        <span>
                            Pemanggilan Peserta
                        </span>

                    </a>

            @endif



            {{-- =================================================
            KESEHATAN LANJUTAN MOBILE
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button" class="mobile-nav-parent {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan',
        'ppks.normal.kesehatan-lanjutan.lulus',
        'ppks.normal.kesehatan-lanjutan.pending',
        'ppks.normal.kesehatan-lanjutan.tidak-lulus',
        'ppks.normal.kesehatan-lanjutan.detail'
    ) ? 'active' : ''
                    }}" :class="{ 'menu-open': healthLanjutanOpen }" @click="healthLanjutanOpen = !healthLanjutanOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            medical_services
                        </span>

                        <span>
                            Kesehatan Lanjutan
                        </span>

                    </span>


                    <span class="material-symbols-outlined mobile-nav-arrow" :class="{ 'rotate': healthLanjutanOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="healthLanjutanOpen" x-transition class="mobile-submenu">

                    {{-- BELUM ASESMEN --}}
                    <a href="{{ route('ppks.normal.kesehatan-lanjutan') }}" class="mobile-submenu-item {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan',
        'ppks.normal.kesehatan-lanjutan.detail'
    )
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            assignment
                        </span>

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    {{-- DATA LULUS --}}
                    <a href="{{ route('ppks.normal.kesehatan-lanjutan.lulus') }}" class="mobile-submenu-item {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan.lulus'
    )
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    {{-- DATA PENDING --}}
                    <a href="{{ route('ppks.normal.kesehatan-lanjutan.pending') }}" class="mobile-submenu-item {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan.pending'
    )
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    {{-- DATA TIDAK LULUS --}}
                    <a href="{{ route('ppks.normal.kesehatan-lanjutan.tidak-lulus') }}" class="mobile-submenu-item {{
    request()->routeIs(
        'ppks.normal.kesehatan-lanjutan.tidak-lulus'
    )
    ? 'active'
    : ''
                        }}">

                        <span class="material-symbols-outlined">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lulus
                        </span>

                    </a>

                </div>

            </div>



            {{-- =================================================
            PESERTA AKTIF MOBILE
            ================================================== --}}

            <a href="#" class="mobile-nav-item">

                <span class="material-symbols-outlined">
                    group
                </span>

                <span>
                    Peserta Aktif
                </span>

            </a>


        </nav>



        {{-- =====================================================
        MOBILE LOGOUT
        ====================================================== --}}

        <div class="mobile-logout">

            @if (Route::has('logout'))

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit" class="mobile-logout-button">

                        <span class="material-symbols-outlined">
                            logout
                        </span>

                        <span>
                            Keluar
                        </span>

                    </button>

                </form>

            @endif

        </div>

    </div>



    {{-- =====================================================
    MAIN CONTENT
    ====================================================== --}}

    <main class="main-content" :class="{ 'sidebar-closed': !sidebarOpen }">

        {{ $slot }}

    </main>

</body>

</html>