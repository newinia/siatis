<nav
    x-data="{
        open: false,
        sidebarOpen: true,
        ppksOpen: true,
        instructorOpen: false,
        healthOpen: false,
        caseConferenceOpen: false
    }"
    class="app-navigation"
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


        <div class="sidebar-menu">

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
                    class="nav-item nav-parent"
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

                    {{-- IMPORT DATA --}}

                    <a
                        href="{{ route('ppks.import') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.import') ? 'active' : '' }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            upload_file
                        </span>

                        <span>
                            Import Data
                        </span>

                    </a>


                    {{-- DATA NORMAL --}}

                    <a
                        href="{{ route('ppks.normal') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.normal') ? 'active' : '' }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Normal
                        </span>

                    </a>


                    {{-- TAMBAH DATA --}}

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

                        <span class="material-symbols-outlined nav-icon">
                            person_add
                        </span>

                        <span>
                            Tambah Data
                        </span>

                    </a>


                    {{-- PERLU PEMERIKSAAN --}}

                    <a
                        href="{{ route('ppks.perlu-diperiksa') }}"
                        class="nav-submenu-item {{ request()->routeIs('ppks.perlu-diperiksa') ? 'active' : '' }}"
                    >

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

                <button
                    type="button"
                    class="nav-item nav-parent"
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

                    {{-- SEMUA DATA ASESMEN INSTRUKTUR --}}

                    <a
                        href="{{ route('ppks.normal.instruktur') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.instruktur') &&
                            !request()->has('status')
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            assignment
                        </span>

                        <span>
                            Data Asesmen
                        </span>

                    </a>


                    {{-- DATA LOLOS --}}

                    <a
                        href="{{ route('ppks.normal.instruktur', ['status' => 'lulus']) }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.instruktur') &&
                            request('status') === 'lulus'
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    {{-- DATA PENDING --}}

                    <a
                        href="{{ route('ppks.normal.instruktur', ['status' => 'pending']) }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.instruktur') &&
                            request('status') === 'pending'
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    {{-- DATA TIDAK LOLOS --}}

                    <a
                        href="{{ route('ppks.normal.instruktur', ['status' => 'tidak_lulus']) }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.instruktur') &&
                            request('status') === 'tidak_lulus'
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lolos
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
                    class="nav-item nav-parent"
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

                    {{-- SEMUA DATA KESEHATAN --}}

                    <a
                        href="{{ route('ppks.normal.kesehatan') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.kesehatan') &&
                            !request()->has('status')
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            assignment
                        </span>

                        <span>
                            Data Asesmen
                        </span>

                    </a>


                    {{-- DATA LOLOS --}}

                    <a
                        href="{{ route('ppks.normal.kesehatan', ['status' => 'lulus']) }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.kesehatan') &&
                            request('status') === 'lulus'
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    {{-- DATA PENDING --}}

                    <a
                        href="{{ route('ppks.normal.kesehatan', ['status' => 'pending']) }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.kesehatan') &&
                            request('status') === 'pending'
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    {{-- DATA TIDAK LOLOS --}}

                    <a
                        href="{{ route('ppks.normal.kesehatan', ['status' => 'tidak_lulus']) }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.kesehatan') &&
                            request('status') === 'tidak_lulus'
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lolos
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
                    class="nav-item nav-parent"
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

                    {{-- SEMUA DATA CASE CONFERENCE --}}

                    <a
                        href="{{ route('ppks.normal.case-conference') }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.case-conference') &&
                            !request()->has('status')
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            assignment
                        </span>

                        <span>
                            Data Case Conference
                        </span>

                    </a>


                    {{-- DATA LOLOS --}}

                    <a
                        href="{{ route('ppks.normal.case-conference', ['status' => 'lulus']) }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.case-conference') &&
                            request('status') === 'lulus'
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    {{-- DATA PENDING --}}

                    <a
                        href="{{ route('ppks.normal.case-conference', ['status' => 'pending']) }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.case-conference') &&
                            request('status') === 'pending'
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    {{-- DATA TIDAK LOLOS --}}

                    <a
                        href="{{ route('ppks.normal.case-conference', ['status' => 'tidak_lulus']) }}"
                        class="nav-submenu-item {{
                            request()->routeIs('ppks.normal.case-conference') &&
                            request('status') === 'tidak_lulus'
                                ? 'active'
                                : ''
                        }}"
                    >

                        <span class="material-symbols-outlined nav-icon">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lolos
                        </span>

                    </a>

                </div>

            </div>


            {{-- =================================================
            DATA DITERIMA
            ================================================== --}}

            <a
                href="{{ route('ppks.diterima') }}"
                class="nav-item {{ request()->routeIs('ppks.diterima') ? 'active' : '' }}"
            >

                <span class="material-symbols-outlined nav-icon">
                    verified
                </span>

                <span class="nav-text">
                    Data Diterima
                </span>

            </a>


            {{-- =================================================
            DATA TIDAK DITERIMA
            ================================================== --}}

            <a
                href="{{ route('ppks.tidak-diterima') }}"
                class="nav-item {{ request()->routeIs('ppks.tidak-diterima') ? 'active' : '' }}"
            >

                <span class="material-symbols-outlined nav-icon">
                    block
                </span>

                <span class="nav-text">
                    Data Tidak Diterima
                </span>

            </a>


            {{-- =================================================
            PEMANGGILAN PESERTA
            ================================================== --}}

            <a
                href="#"
                class="nav-item"
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
                href="#"
                class="nav-item"
            >

                <span class="material-symbols-outlined nav-icon">
                    group
                </span>

                <span class="nav-text">
                    Peserta Aktif
                </span>

            </a>

        </div>


        {{-- =====================================================
        LOGOUT
        ====================================================== --}}

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
                    open = !open;
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
                        ? (open ? 'close' : 'menu')
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
        x-show="open"
        x-transition
        class="mobile-navigation"
    >

        <div class="mobile-nav-header">

            <span>
                MENU UTAMA
            </span>

            <button
                type="button"
                @click="open = false"
                class="mobile-close-button"
            >

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        <div class="mobile-nav-menu">

            {{-- DASHBOARD --}}

            @if (Route::has('dashboard'))

                <a
                    href="{{ route('dashboard') }}"
                    class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
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
                    class="mobile-nav-parent"
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
                    >

                        <span class="material-symbols-outlined">
                            upload_file
                        </span>

                        <span>
                            Import Data
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.normal') ? 'active' : '' }}"
                    >

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

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
                    >

                        <span class="material-symbols-outlined">
                            person_add
                        </span>

                        <span>
                            Tambah Data
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.perlu-diperiksa') }}"
                        class="mobile-submenu-item {{ request()->routeIs('ppks.perlu-diperiksa') ? 'active' : '' }}"
                    >

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

                <button
                    type="button"
                    class="mobile-nav-parent"
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
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            assignment
                        </span>

                        <span>
                            Data Asesmen
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.instruktur', ['status' => 'lulus']) }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.instruktur', ['status' => 'pending']) }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.instruktur', ['status' => 'tidak_lulus']) }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lolos
                        </span>

                    </a>

                </div>

            </div>


            {{-- =================================================
            ASESMEN KESEHATAN MOBILE
            ================================================== --}}

            <div class="mobile-nav-group">

                <button
                    type="button"
                    class="mobile-nav-parent"
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
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            assignment
                        </span>

                        <span>
                            Data Asesmen
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.kesehatan', ['status' => 'lulus']) }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.kesehatan', ['status' => 'pending']) }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.kesehatan', ['status' => 'tidak_lulus']) }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lolos
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
                    class="mobile-nav-parent"
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
                        href="{{ route('ppks.normal.case-conference') }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            assignment
                        </span>

                        <span>
                            Data Case Conference
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.case-conference', ['status' => 'lulus']) }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.case-conference', ['status' => 'pending']) }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            schedule
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    <a
                        href="{{ route('ppks.normal.case-conference', ['status' => 'tidak_lulus']) }}"
                        class="mobile-submenu-item"
                    >

                        <span class="material-symbols-outlined">
                            cancel
                        </span>

                        <span>
                            Data Tidak Lolos
                        </span>

                    </a>

                </div>

            </div>


            {{-- =================================================
            DATA DITERIMA
            ================================================== --}}

            <a
                href="{{ route('ppks.diterima') }}"
                class="mobile-nav-item {{ request()->routeIs('ppks.diterima') ? 'active' : '' }}"
            >

                <span class="material-symbols-outlined">
                    verified
                </span>

                <span>
                    Data Diterima
                </span>

            </a>


            {{-- DATA TIDAK DITERIMA --}}

            <a
                href="{{ route('ppks.tidak-diterima') }}"
                class="mobile-nav-item {{ request()->routeIs('ppks.tidak-diterima') ? 'active' : '' }}"
            >

                <span class="material-symbols-outlined">
                    block
                </span>

                <span>
                    Data Tidak Diterima
                </span>

            </a>


            {{-- PEMANGGILAN PESERTA --}}

            <a
                href="#"
                class="mobile-nav-item"
            >

                <span class="material-symbols-outlined">
                    record_voice_over
                </span>

                <span>
                    Pemanggilan Peserta
                </span>

            </a>


            {{-- PESERTA AKTIF --}}

            <a
                href="#"
                class="mobile-nav-item"
            >

                <span class="material-symbols-outlined">
                    group
                </span>

                <span>
                    Peserta Aktif
                </span>

            </a>

        </div>


        {{-- LOGOUT MOBILE --}}

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

</nav>
