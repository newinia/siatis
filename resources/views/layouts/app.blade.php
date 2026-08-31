<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIATIS') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,400,0,0"
        rel="stylesheet"
    >

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])
</head>


<body
    x-data="{
        sidebarOpen: true,
        mobileOpen: false,

        dataOpen: {{ request()->routeIs(
            'data',
            'data-detail',
            'data-import',
            'data-pemeriksaan',
            'data-tervalidasi'
        ) ? 'true' : 'false' }},

        instructorOpen: {{ request()->routeIs(
            'asesmen-instruktur',
            'asesmen-instruktur-detail',
            'instruktur-belum-asesmen',
            'instruktur-lolos',
            'instruktur-tidak-lolos',
            'instruktur-pending'
        ) ? 'true' : 'false' }},

        healthInitialOpen: {{ request()->routeIs(
            'asesmen-kesehatan-awal',
            'asesmen-kesehatan-awal-detail',
            'kesehatan-awal-belum-asesmen',
            'kesehatan-awal-lolos',
            'kesehatan-awal-tidak-lolos',
            'kesehatan-awal-pending'
        ) ? 'true' : 'false' }},

        caseConferenceOpen: {{ request()->routeIs(
            'case-conference',
            'case-conference-detail',
            'case-conference-belum',
            'case-conference-sudah'
        ) ? 'true' : 'false' }},

        healthAdvancedOpen: {{ request()->routeIs(
            'asesmen-kesehatan-lanjutan',
            'asesmen-kesehatan-lanjutan-detail',
            'kesehatan-lanjutan-belum-asesmen',
            'kesehatan-lanjutan-lolos',
            'kesehatan-lanjutan-tidak-lolos',
            'kesehatan-lanjutan-pending'
        ) ? 'true' : 'false' }}
    }"
>


    {{-- =====================================================
    SIDEBAR DESKTOP
    ====================================================== --}}

    <aside
        class="app-sidebar"
        :class="{ 'sidebar-closed': !sidebarOpen }"
    >

        {{-- HEADER --}}
        <div class="sidebar-header">

            <div class="sidebar-label">
                MENU UTAMA
            </div>

            <div class="sidebar-divider"></div>

        </div>


        {{-- =====================================================
        MENU
        ====================================================== --}}

        <nav class="sidebar-menu">


            {{-- =================================================
            DASHBOARD
            ================================================== --}}

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



            {{-- =================================================
            DATA
            ================================================== --}}

            <div class="nav-group">

                <button
                    type="button"
                    class="nav-item nav-parent {{
                        request()->routeIs(
                            'data',
                            'data-detail',
                            'data-import',
                            'data-pemeriksaan',
                            'data-tervalidasi'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': dataOpen }"
                    @click="dataOpen = !dataOpen"
                >

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            database
                        </span>

                        <span class="nav-text">
                            Data
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': dataOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="dataOpen"
                    x-transition
                    class="nav-submenu"
                >

                    <a
                        href="{{ route('data-import') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('data-import')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Import Data
                    </a>


                    <a
                        href="{{ route('data-pemeriksaan') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('data-pemeriksaan')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Perlu Pemeriksaan
                    </a>


                    <a
                        href="{{ route('data-tervalidasi') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('data-tervalidasi')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Tervalidasi
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
                            'asesmen-instruktur',
                            'asesmen-instruktur-detail',
                            'instruktur-belum-asesmen',
                            'instruktur-lolos',
                            'instruktur-tidak-lolos',
                            'instruktur-pending'
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
                        href="{{ route('instruktur-belum-asesmen') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('instruktur-belum-asesmen')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Belum Asesmen
                    </a>


                    <a
                        href="{{ route('instruktur-lolos') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('instruktur-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Lolos
                    </a>


                    <a
                        href="{{ route('instruktur-tidak-lolos') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('instruktur-tidak-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Tidak Lolos
                    </a>


                    <a
                        href="{{ route('instruktur-pending') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('instruktur-pending')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Pending
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
                            'asesmen-kesehatan-awal',
                            'asesmen-kesehatan-awal-detail',
                            'kesehatan-awal-belum-asesmen',
                            'kesehatan-awal-lolos',
                            'kesehatan-awal-tidak-lolos',
                            'kesehatan-awal-pending'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': healthInitialOpen }"
                    @click="healthInitialOpen = !healthInitialOpen"
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
                        :class="{ 'rotate': healthInitialOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="healthInitialOpen"
                    x-transition
                    class="nav-submenu"
                >

                    <a
                        href="{{ route('kesehatan-awal-belum-asesmen') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('kesehatan-awal-belum-asesmen')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Belum Asesmen
                    </a>


                    <a
                        href="{{ route('kesehatan-awal-lolos') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('kesehatan-awal-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Lolos
                    </a>


                    <a
                        href="{{ route('kesehatan-awal-tidak-lolos') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('kesehatan-awal-tidak-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Tidak Lolos
                    </a>


                    <a
                        href="{{ route('kesehatan-awal-pending') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('kesehatan-awal-pending')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Pending
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
                            'case-conference',
                            'case-conference-detail',
                            'case-conference-belum',
                            'case-conference-sudah'
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
                        href="{{ route('case-conference-belum') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('case-conference-belum')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Belum
                    </a>


                    <a
                        href="{{ route('case-conference-sudah') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('case-conference-sudah')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Sudah
                    </a>

                </div>

            </div>



            {{-- =================================================
            ASESMEN KESEHATAN LANJUTAN
            ================================================== --}}

            <div class="nav-group">

                <button
                    type="button"
                    class="nav-item nav-parent {{
                        request()->routeIs(
                            'asesmen-kesehatan-lanjutan',
                            'asesmen-kesehatan-lanjutan-detail',
                            'kesehatan-lanjutan-belum-asesmen',
                            'kesehatan-lanjutan-lolos',
                            'kesehatan-lanjutan-tidak-lolos',
                            'kesehatan-lanjutan-pending'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': healthAdvancedOpen }"
                    @click="healthAdvancedOpen = !healthAdvancedOpen"
                >

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            health_and_safety
                        </span>

                        <span class="nav-text">
                            Asesmen Kesehatan Lanjutan
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': healthAdvancedOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="healthAdvancedOpen"
                    x-transition
                    class="nav-submenu"
                >

                    <a
                        href="{{ route('kesehatan-lanjutan-belum-asesmen') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('kesehatan-lanjutan-belum-asesmen')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Belum Asesmen
                    </a>


                    <a
                        href="{{ route('kesehatan-lanjutan-lolos') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('kesehatan-lanjutan-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Lolos
                    </a>


                    <a
                        href="{{ route('kesehatan-lanjutan-tidak-lolos') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('kesehatan-lanjutan-tidak-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Tidak Lolos
                    </a>


                    <a
                        href="{{ route('kesehatan-lanjutan-pending') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('kesehatan-lanjutan-pending')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Pending
                    </a>

                </div>

            </div>



            {{-- =================================================
            PEMANGGILAN PESERTA
            ================================================== --}}

            <a
                href="{{ route('pemanggilan-peserta') }}"
                class="nav-item {{
                    request()->routeIs('pemanggilan-peserta')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="material-symbols-outlined nav-icon">
                    record_voice_over
                </span>

                <span class="nav-text">
                    Pemanggilan Peserta
                </span>

            </a>



            {{-- =================================================
            PESERTA AKTIF
            ================================================== --}}

            <a
                href="{{ route('peserta-aktif') }}"
                class="nav-item {{
                    request()->routeIs('peserta-aktif')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="material-symbols-outlined nav-icon">
                    person_add
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


            {{-- =================================================
            DASHBOARD
            ================================================== --}}

            <a
                href="{{ route('dashboard') }}"
                class="mobile-nav-item {{
                    request()->routeIs('dashboard')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="material-symbols-outlined">
                    dashboard
                </span>

                <span>
                    Dashboard
                </span>

            </a>



            {{-- =================================================
            DATA
            ================================================== --}}

            <div class="mobile-nav-group">

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'data',
                            'data-detail',
                            'data-import',
                            'data-pemeriksaan',
                            'data-tervalidasi'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': dataOpen }"
                    @click="dataOpen = !dataOpen"
                >

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            database
                        </span>

                        <span>
                            Data
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': dataOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="dataOpen"
                    x-transition
                    class="mobile-submenu"
                >

                    <a
                        href="{{ route('data-import') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('data-import')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Import Data
                    </a>


                    <a
                        href="{{ route('data-pemeriksaan') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('data-pemeriksaan')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Perlu Pemeriksaan
                    </a>


                    <a
                        href="{{ route('data-tervalidasi') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('data-tervalidasi')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Tervalidasi
                    </a>

                </div>

            </div>



            {{-- =================================================
            ASESMEN INSTRUKTUR
            ================================================== --}}

            <div class="mobile-nav-group">

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'asesmen-instruktur',
                            'asesmen-instruktur-detail',
                            'instruktur-belum-asesmen',
                            'instruktur-lolos',
                            'instruktur-tidak-lolos',
                            'instruktur-pending'
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
                        href="{{ route('instruktur-belum-asesmen') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('instruktur-belum-asesmen')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Belum Asesmen
                    </a>


                    <a
                        href="{{ route('instruktur-lolos') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('instruktur-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Lolos
                    </a>


                    <a
                        href="{{ route('instruktur-tidak-lolos') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('instruktur-tidak-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Tidak Lolos
                    </a>


                    <a
                        href="{{ route('instruktur-pending') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('instruktur-pending')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Pending
                    </a>

                </div>

            </div>



            {{-- =================================================
            ASESMEN KESEHATAN AWAL
            ================================================== --}}

            <div class="mobile-nav-group">

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'asesmen-kesehatan-awal',
                            'asesmen-kesehatan-awal-detail',
                            'kesehatan-awal-belum-asesmen',
                            'kesehatan-awal-lolos',
                            'kesehatan-awal-tidak-lolos',
                            'kesehatan-awal-pending'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': healthInitialOpen }"
                    @click="healthInitialOpen = !healthInitialOpen"
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
                        :class="{ 'rotate': healthInitialOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="healthInitialOpen"
                    x-transition
                    class="mobile-submenu"
                >

                    <a
                        href="{{ route('kesehatan-awal-belum-asesmen') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('kesehatan-awal-belum-asesmen')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Belum Asesmen
                    </a>


                    <a
                        href="{{ route('kesehatan-awal-lolos') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('kesehatan-awal-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Lolos
                    </a>


                    <a
                        href="{{ route('kesehatan-awal-tidak-lolos') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('kesehatan-awal-tidak-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Tidak Lolos
                    </a>


                    <a
                        href="{{ route('kesehatan-awal-pending') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('kesehatan-awal-pending')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Pending
                    </a>

                </div>

            </div>



            {{-- =================================================
            CASE CONFERENCE
            ================================================== --}}

            <div class="mobile-nav-group">

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'case-conference',
                            'case-conference-detail',
                            'case-conference-belum',
                            'case-conference-sudah'
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
                        href="{{ route('case-conference-belum') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('case-conference-belum')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Belum
                    </a>


                    <a
                        href="{{ route('case-conference-sudah') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('case-conference-sudah')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Sudah
                    </a>

                </div>

            </div>



            {{-- =================================================
            ASESMEN KESEHATAN LANJUTAN
            ================================================== --}}

            <div class="mobile-nav-group">

                <button
                    type="button"
                    class="mobile-nav-parent {{
                        request()->routeIs(
                            'asesmen-kesehatan-lanjutan',
                            'asesmen-kesehatan-lanjutan-detail',
                            'kesehatan-lanjutan-belum-asesmen',
                            'kesehatan-lanjutan-lolos',
                            'kesehatan-lanjutan-tidak-lolos',
                            'kesehatan-lanjutan-pending'
                        ) ? 'active' : ''
                    }}"
                    :class="{ 'menu-open': healthAdvancedOpen }"
                    @click="healthAdvancedOpen = !healthAdvancedOpen"
                >

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            health_and_safety
                        </span>

                        <span>
                            Asesmen Kesehatan Lanjutan
                        </span>

                    </span>

                    <span
                        class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': healthAdvancedOpen }"
                    >
                        expand_more
                    </span>

                </button>


                <div
                    x-show="healthAdvancedOpen"
                    x-transition
                    class="mobile-submenu"
                >

                    <a
                        href="{{ route('kesehatan-lanjutan-belum-asesmen') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('kesehatan-lanjutan-belum-asesmen')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Belum Asesmen
                    </a>


                    <a
                        href="{{ route('kesehatan-lanjutan-lolos') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('kesehatan-lanjutan-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Lolos
                    </a>


                    <a
                        href="{{ route('kesehatan-lanjutan-tidak-lolos') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('kesehatan-lanjutan-tidak-lolos')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Tidak Lolos
                    </a>


                    <a
                        href="{{ route('kesehatan-lanjutan-pending') }}"
                        class="mobile-submenu-item {{
                            request()->routeIs('kesehatan-lanjutan-pending')
                                ? 'active'
                                : ''
                        }}"
                    >
                        Data Pending
                    </a>

                </div>

            </div>



            {{-- =================================================
            PEMANGGILAN PESERTA
            ================================================== --}}

            <a
                href="{{ route('pemanggilan-peserta') }}"
                class="mobile-nav-item {{
                    request()->routeIs('pemanggilan-peserta')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="material-symbols-outlined">
                    record_voice_over
                </span>

                <span>
                    Pemanggilan Peserta
                </span>

            </a>



            {{-- =================================================
            PESERTA AKTIF
            ================================================== --}}

            <a
                href="{{ route('peserta-aktif') }}"
                class="mobile-nav-item {{
                    request()->routeIs('peserta-aktif')
                        ? 'active'
                        : ''
                }}"
            >

                <span class="material-symbols-outlined">
                    person_add
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
