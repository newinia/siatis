<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'SIATIS') }}
    </title>


    {{-- =====================================================
    FONTS
    ====================================================== --}}

    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,400,0,0"
        rel="stylesheet"
    >


    {{-- =====================================================
    VITE
    ====================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


{{-- =====================================================
ALPINE DIPINDAH LANGSUNG KE BODY
STRUKTUR DISAMAKAN DENGAN KODINGAN B
====================================================== --}}

<body
    x-data="{
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
    }"
>


    {{-- =================================================
    SIDEBAR DESKTOP
    ================================================== --}}

    <aside
        class="app-sidebar"
        :class="{ 'sidebar-closed': !sidebarOpen }"
    >

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

                <a
                    href="{{ route('dashboard') }}"
                    class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                >

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

                <a
                    href="{{ route('admin.index') }}"
                    class="nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                >

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

                <button
                    type="button"
                    class="nav-item nav-parent {{
                        request()->routeIs(
                            'ppks.import',
                            'ppks.normal',
                            'ppks.manual',
                            'ppks.normal.create',
                            'ppks.normal.edit',
                            'ppks.perlu-diperiksa'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': ppksOpen }"
                    @click="ppksOpen = !ppksOpen"
                >

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            description
                        </span>

                        <span class="nav-text">
                            Data PPKS
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': ppksOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="ppksOpen"
                    x-transition
                    class="nav-submenu"
                >

                    <a
                        href="{{ route('ppks.import') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.import') ? 'active' : '' }}"
                    >

                        <span>
                            Import Data
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal') ? 'active' : '' }}"
                    >

                        <span>
                            Data Normal
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.manual') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.manual') ||
                            request()->routeIs('ppks.normal.create') ||
                            request()->routeIs('ppks.normal.edit')
                            ? 'active'
                            : ''
                        }}"
                    >

                        <span>
                            Tambah Data
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.perlu-diperiksa') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.perlu-diperiksa') ? 'active' : '' }}"
                    >

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

                <button
                    type="button"
                    class="nav-item nav-parent {{
                        request()->routeIs(
                            'ppks.normal.instruktur',
                            'ppks.normal.asesmen-instruktur.lulus',
                            'ppks.normal.asesmen-instruktur.pending',
                            'ppks.normal.asesmen-instruktur.tidak-lulus'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': instructorOpen }"
                    @click="instructorOpen = !instructorOpen"
                >

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            badge
                        </span>

                        <span class="nav-text">
                            Asesmen Instruktur
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': instructorOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="instructorOpen"
                    x-transition
                    class="nav-submenu"
                >

                    <a
                        href="{{ route('ppks.normal.instruktur') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.instruktur') ? 'active' : '' }}"
                    >

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-instruktur.lulus') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.asesmen-instruktur.lulus') ? 'active' : '' }}"
                    >

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-instruktur.pending') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.asesmen-instruktur.pending') ? 'active' : '' }}"
                    >

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-instruktur.tidak-lulus') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.asesmen-instruktur.tidak-lulus') ? 'active' : '' }}"
                    >

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

                <button
                    type="button"
                    class="nav-item nav-parent {{
                        request()->routeIs(
                            'ppks.normal.kesehatan',
                            'ppks.normal.asesmen-kesehatan.lulus',
                            'ppks.normal.asesmen-kesehatan.pending',
                            'ppks.normal.asesmen-kesehatan.tidak-lulus'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': healthOpen }"
                    @click="healthOpen = !healthOpen"
                >

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            medical_information
                        </span>

                        <span class="nav-text">
                            Asesmen Kesehatan Awal
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': healthOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="healthOpen"
                    x-transition
                    class="nav-submenu"
                >

                    <a
                        href="{{ route('ppks.normal.kesehatan') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.kesehatan') ? 'active' : '' }}"
                    >

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-kesehatan.lulus') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.asesmen-kesehatan.lulus') ? 'active' : '' }}"
                    >

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-kesehatan.pending') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.asesmen-kesehatan.pending') ? 'active' : '' }}"
                    >

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-kesehatan.tidak-lulus') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.asesmen-kesehatan.tidak-lulus') ? 'active' : '' }}"
                    >

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

                <button
                    type="button"
                    class="nav-item nav-parent {{
                        request()->routeIs(
                            'ppks.normal.case-conference.belum',
                            'ppks.normal.case-conference.sudah'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': caseConferenceOpen }"
                    @click="caseConferenceOpen = !caseConferenceOpen"
                >

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            groups
                        </span>

                        <span class="nav-text">
                            Case Conference
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': caseConferenceOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="caseConferenceOpen"
                    x-transition
                    class="nav-submenu"
                >

                    <a
                        href="{{ route('ppks.normal.case-conference.belum') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.case-conference.belum') ? 'active' : '' }}"
                    >

                        <span>
                            Belum Dilakukan
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.case-conference.sudah') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.case-conference.sudah') ? 'active' : '' }}"
                    >

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

                <a
                    href="{{ route('ppks.normal.pemanggilan') }}"
                    class="nav-item {{ request()->routeIs('ppks.normal.pemanggilan') ? 'active' : '' }}"
                >

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

                <button
                    type="button"
                    class="nav-item nav-parent {{
                        request()->routeIs(
                            'ppks.normal.kesehatan-lanjutan',
                            'ppks.normal.kesehatan-lanjutan.lulus',
                            'ppks.normal.kesehatan-lanjutan.pending',
                            'ppks.normal.kesehatan-lanjutan.tidak-lulus',
                            'ppks.normal.kesehatan-lanjutan.detail'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': healthLanjutanOpen }"
                    @click="healthLanjutanOpen = !healthLanjutanOpen"
                >

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            medical_services
                        </span>

                        <span class="nav-text">
                            Kesehatan Lanjutan
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': healthLanjutanOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="healthLanjutanOpen"
                    x-transition
                    class="nav-submenu"
                >

                    <a
                        href="{{ route('ppks.normal.kesehatan-lanjutan') }}"
                        class="nav-submenu-item {{
                            request()->routeIs(
                                'ppks.normal.kesehatan-lanjutan',
                                'ppks.normal.kesehatan-lanjutan.detail'
                            ) ? 'active' : ''
                        }}"
                    >

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.kesehatan-lanjutan.lulus') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.kesehatan-lanjutan.lulus') ? 'active' : '' }}"
                    >

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.kesehatan-lanjutan.pending') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.kesehatan-lanjutan.pending') ? 'active' : '' }}"
                    >

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.kesehatan-lanjutan.tidak-lulus') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal.kesehatan-lanjutan.tidak-lulus') ? 'active' : '' }}"
                    >

                        <span>
                            Data Tidak Lulus
                        </span>

                    </a>

                </div>

            </div>


            {{-- =================================================
            PESERTA AKTIF
            ================================================== --}}

            <a
                href="{{ route('ppks.normal.peserta-aktif') }}"
                class="nav-item {{ request()->routeIs('ppks.normal.peserta-aktif') ? 'active' : '' }}"
            >

                <span class="material-symbols-outlined nav-icon">
                    group
                </span>

                <span class="nav-text">
                    Peserta Aktif
                </span>

            </a>


        </nav>


        {{-- =================================================
        LOGOUT DESKTOP
        ================================================== --}}

        <div class="sidebar-footer">

            @if (Route::has('logout'))

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="logout-button"
                    >

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

    <header
        class="top-navbar"
        :class="{ 'sidebar-closed': !sidebarOpen }"
    >

        <button
            type="button"
            class="navbar-hamburger"
            @click="
                if (window.innerWidth <= 768) {
                    mobileOpen = true;
                } else {
                    sidebarOpen = !sidebarOpen;
                }
            "
            aria-label="Toggle Navigation"
        >

            <span
                class="material-symbols-outlined"
                x-text="
                    window.innerWidth <= 768
                        ? 'menu'
                        : (sidebarOpen ? 'menu_open' : 'menu')
                "
            ></span>

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

    <div
        x-show="mobileOpen"
        x-transition
        class="mobile-navigation"
    >

        <div class="mobile-nav-header">

            <span>
                MENU UTAMA
            </span>

            <button
                type="button"
                class="mobile-close-button"
                @click="mobileOpen = false"
            >

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        <nav class="mobile-nav-menu">


            {{-- DASHBOARD --}}

            @if (Route::has('dashboard'))

                <a
                    href="{{ route('dashboard') }}"
                    class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    @click="mobileOpen = false"
                >

                    <span class="material-symbols-outlined">
                        dashboard
                    </span>

                    <span>
                        Dashboard
                    </span>

                </a>

            @endif


            {{-- DAFTAR ADMIN --}}

            @if (
                Auth::check() &&
                Auth::user()->role === 'super_admin' &&
                Route::has('admin.index')
            )

                <a
                    href="{{ route('admin.index') }}"
                    class="mobile-nav-item {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                    @click="mobileOpen = false"
                >

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

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'ppks.import',
                            'ppks.normal',
                            'ppks.manual',
                            'ppks.normal.create',
                            'ppks.normal.edit',
                            'ppks.perlu-diperiksa'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': ppksOpen }"
                    @click="ppksOpen = !ppksOpen"
                >

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            description
                        </span>

                        <span>
                            Data PPKS
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': ppksOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="ppksOpen"
                    x-transition
                    class="mobile-submenu"
                >

                    <a
                        href="{{ route('ppks.import') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.import') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Import Data
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Data Normal
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.manual') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('ppks.manual') ||
                            request()->routeIs('ppks.normal.create') ||
                            request()->routeIs('ppks.normal.edit')
                            ? 'active'
                            : ''
                        }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Tambah Data
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.perlu-diperiksa') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.perlu-diperiksa') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >

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

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'ppks.normal.instruktur',
                            'ppks.normal.asesmen-instruktur.lulus',
                            'ppks.normal.asesmen-instruktur.pending',
                            'ppks.normal.asesmen-instruktur.tidak-lulus'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': instructorOpen }"
                    @click="instructorOpen = !instructorOpen"
                >

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            badge
                        </span>

                        <span>
                            Asesmen Instruktur
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': instructorOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="instructorOpen"
                    x-transition
                    class="mobile-submenu"
                >

                    <a
                        href="{{ route('ppks.normal.instruktur') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.instruktur') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >


                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-instruktur.lulus') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.asesmen-instruktur.lulus') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-instruktur.pending') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.asesmen-instruktur.pending') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-instruktur.tidak-lulus') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.asesmen-instruktur.tidak-lulus') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >


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

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'ppks.normal.kesehatan',
                            'ppks.normal.asesmen-kesehatan.lulus',
                            'ppks.normal.asesmen-kesehatan.pending',
                            'ppks.normal.asesmen-kesehatan.tidak-lulus'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': healthOpen }"
                    @click="healthOpen = !healthOpen"
                >

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            medical_information
                        </span>

                        <span>
                            Asesmen Kesehatan Awal
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': healthOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="healthOpen"
                    x-transition
                    class="mobile-submenu"
                >

                    <a
                        href="{{ route('ppks.normal.kesehatan') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.kesehatan') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >


                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-kesehatan.lulus') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.asesmen-kesehatan.lulus') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >


                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-kesehatan.pending') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.asesmen-kesehatan.pending') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.asesmen-kesehatan.tidak-lulus') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.asesmen-kesehatan.tidak-lulus') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >


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

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'ppks.normal.case-conference.belum',
                            'ppks.normal.case-conference.sudah'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': caseConferenceOpen }"
                    @click="caseConferenceOpen = !caseConferenceOpen"
                >

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            groups
                        </span>

                        <span>
                            Case Conference
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': caseConferenceOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="caseConferenceOpen"
                    x-transition
                    class="mobile-submenu"
                >

                    <a
                        href="{{ route('ppks.normal.case-conference.belum') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.case-conference.belum') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >



                        <span>
                            Belum Dilakukan
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.case-conference.sudah') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.case-conference.sudah') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >



                        <span>
                            Sudah Dilakukan
                        </span>

                    </a>

                </div>

            </div>


            {{-- PEMANGGILAN PESERTA --}}

            @if (Route::has('ppks.normal.pemanggilan'))

                <a
                    href="{{ route('ppks.normal.pemanggilan') }}"
                    class="mobile-nav-item {{ request()->routeIs('ppks.normal.pemanggilan') ? 'active' : '' }}"
                    @click="mobileOpen = false"
                >

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

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'ppks.normal.kesehatan-lanjutan',
                            'ppks.normal.kesehatan-lanjutan.lulus',
                            'ppks.normal.kesehatan-lanjutan.pending',
                            'ppks.normal.kesehatan-lanjutan.tidak-lulus',
                            'ppks.normal.kesehatan-lanjutan.detail'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': healthLanjutanOpen }"
                    @click="healthLanjutanOpen = !healthLanjutanOpen"
                >

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            medical_services
                        </span>

                        <span>
                            Kesehatan Lanjutan
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': healthLanjutanOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="healthLanjutanOpen"
                    x-transition
                    class="mobile-submenu"
                >

                    <a
                        href="{{ route('ppks.normal.kesehatan-lanjutan') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs(
                                'ppks.normal.kesehatan-lanjutan',
                                'ppks.normal.kesehatan-lanjutan.detail'
                            ) ? 'active' : ''
                        }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Belum Asesmen
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.kesehatan-lanjutan.lulus') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.kesehatan-lanjutan.lulus') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Data Lulus
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.kesehatan-lanjutan.pending') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.kesehatan-lanjutan.pending') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.kesehatan-lanjutan.tidak-lulus') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal.kesehatan-lanjutan.tidak-lulus') ? 'active' : '' }}"
                        @click="mobileOpen = false"
                    >

                        <span>
                            Data Tidak Lulus
                        </span>

                    </a>

                </div>

            </div>


            {{-- PESERTA AKTIF MOBILE --}}

            <a
                href="{{ route('ppks.normal.peserta-aktif') }}"
                class="mobile-nav-item {{ request()->routeIs('ppks.normal.peserta-aktif') ? 'active' : '' }}"
                @click="mobileOpen = false"
            >

                <span class="material-symbols-outlined">
                    group
                </span>

                <span>
                    Peserta Aktif
                </span>

            </a>


        </nav>


        {{-- =================================================
        MOBILE LOGOUT
        ================================================== --}}

        <div class="mobile-logout">

            @if (Route::has('logout'))

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="mobile-logout-button"
                    >

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

    <main
        class="main-content"
        :class="{ 'sidebar-closed': !sidebarOpen }"
    >

        {{ $slot }}

    </main>


</body>

</html>