<nav x-data="{
    open: false,
    sidebarOpen: true,
    ppksOpen: true,
    instructorOpen: false,
    healthOpen: false
}" class="app-navigation">

    {{-- =====================================================
    SIDEBAR DESKTOP
    ====================================================== --}}

    <aside class="app-sidebar" :class="{ 'sidebar-closed': !sidebarOpen }">

        {{-- HEADER --}}
        <div class="sidebar-header">

            <div class="sidebar-label">
                MENU UTAMA
            </div>

            <div class="sidebar-divider"></div>

        </div>


        {{-- =================================================
        MENU
        ================================================== --}}

        <div class="sidebar-menu">

            {{-- =================================================
            DASHBOARD
            ================================================== --}}

            <a href="{{ route('dashboard') }}"
                class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <span class="material-symbols-outlined nav-icon">
                    dashboard
                </span>

                <span class="nav-text">
                    Dashboard
                </span>

            </a>


            {{-- =================================================
            DATA PPKS
            ================================================== --}}

            <div class="nav-group">

                <button type="button"
                    class="nav-item nav-parent"
                    :class="{ 'menu-open': ppksOpen }"
                    @click="ppksOpen = !ppksOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            description
                        </span>

                        <span class="nav-text">
                            Data PPKS
                        </span>

                    </span>

                    <span class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': ppksOpen }">
                        expand_more
                    </span>

                </button>


                {{-- SUBMENU DATA PPKS --}}

                <div x-show="ppksOpen"
                    x-transition
                    class="nav-submenu">


                    {{-- IMPORT DATA --}}

                    <a href="{{ route('ppks.import') }}"
                        class="nav-submenu-item
                        {{ request()->routeIs('ppks.import') ? 'active' : '' }}">

                        <span class="material-symbols-outlined nav-icon">
                            upload_file
                        </span>

                        <span>
                            Import Data
                        </span>

                    </a>


                    {{-- DATA NORMAL --}}

                    <a href="{{ route('ppks.normal') }}"
                        class="nav-submenu-item
                        {{ request()->routeIs('ppks.normal') ? 'active' : '' }}">

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Normal
                        </span>

                    </a>


                    {{-- PERLU PEMERIKSAAN --}}

                    <a href="{{ route('ppks.perlu-diperiksa') }}"
                        class="nav-submenu-item
                        {{ request()->routeIs('ppks.perlu-diperiksa') ? 'active' : '' }}">

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
            CASE CONFERENCE
            ================================================== --}}

            <a href="#"
                class="nav-item">

                <span class="material-symbols-outlined nav-icon">
                    groups
                </span>

                <span class="nav-text">
                    Case Conference
                </span>

            </a>


            {{-- =================================================
            ASESMEN INSTRUKTUR
            ================================================== --}}

            <div class="nav-group">

                <button type="button"
                    class="nav-item nav-parent"
                    :class="{ 'menu-open': instructorOpen }"
                    @click="instructorOpen = !instructorOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            badge
                        </span>

                        <span class="nav-text">
                            Asesmen Instruktur
                        </span>

                    </span>

                    <span class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': instructorOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="instructorOpen"
                    x-transition
                    class="nav-submenu">


                    {{-- DATA LOLOS --}}

                    <a href="#"
                        class="nav-submenu-item">

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    {{-- DATA PENDING --}}

                    <a href="#"
                        class="nav-submenu-item">

                        <span class="material-symbols-outlined nav-icon">
                            pending
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    {{-- DATA TIDAK LOLOS --}}

                    <a href="#"
                        class="nav-submenu-item">

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
            ASESMEN KESEHATAN
            ================================================== --}}

            <div class="nav-group">

                <button type="button"
                    class="nav-item nav-parent"
                    :class="{ 'menu-open': healthOpen }"
                    @click="healthOpen = !healthOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            medical_information
                        </span>

                        <span class="nav-text">
                            Asesmen Kesehatan
                        </span>

                    </span>

                    <span class="material-symbols-outlined nav-arrow"
                        :class="{ 'rotate': healthOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="healthOpen"
                    x-transition
                    class="nav-submenu">


                    {{-- DATA LOLOS --}}

                    <a href="#"
                        class="nav-submenu-item">

                        <span class="material-symbols-outlined nav-icon">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    {{-- DATA PENDING --}}

                    <a href="#"
                        class="nav-submenu-item">

                        <span class="material-symbols-outlined nav-icon">
                            pending
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    {{-- DATA TIDAK LOLOS --}}

                    <a href="#"
                        class="nav-submenu-item">

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
            PEMANGGILAN PESERTA
            ================================================== --}}

            <a href="#"
                class="nav-item">

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

            <a href="#"
                class="nav-item">

                <span class="material-symbols-outlined nav-icon">
                    person_add
                </span>

                <span class="nav-text">
                    Peserta Aktif
                </span>

            </a>

        </div>


        {{-- =====================================================
        LOGOUT DESKTOP
        ====================================================== --}}

        <div class="sidebar-footer">

            <form method="POST"
                action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                    class="logout-button">

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

    <header class="top-navbar"
        :class="{ 'sidebar-closed': !sidebarOpen }">


        {{-- HAMBURGER --}}

        <button type="button"
            class="navbar-hamburger"
            @click="
                if (window.innerWidth <= 768) {
                    open = !open;
                } else {
                    sidebarOpen = !sidebarOpen;
                }
            "
            aria-label="Toggle Navigation">

            <span class="material-symbols-outlined"
                x-text="
                    window.innerWidth <= 768
                        ? (open ? 'close' : 'menu')
                        : (sidebarOpen ? 'menu_open' : 'menu')
                ">
            </span>

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

    <div x-show="open"
        x-transition
        class="mobile-navigation">


        {{-- MOBILE HEADER --}}

        <div class="mobile-nav-header">

            <span>
                MENU UTAMA
            </span>

            <button type="button"
                @click="open = false"
                class="mobile-close-button">

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        {{-- MOBILE MENU --}}

        <div class="mobile-nav-menu">


            {{-- DASHBOARD --}}

            <a href="{{ route('dashboard') }}"
                class="mobile-nav-item
                {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <span class="material-symbols-outlined">
                    dashboard
                </span>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- =================================================
            DATA PPKS
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button"
                    class="mobile-nav-parent"
                    :class="{ 'menu-open': ppksOpen }"
                    @click="ppksOpen = !ppksOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            description
                        </span>

                        <span>
                            Data PPKS
                        </span>

                    </span>

                    <span class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': ppksOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="ppksOpen"
                    x-transition
                    class="mobile-submenu">


                    {{-- IMPORT DATA --}}

                    <a href="{{ route('ppks.import') }}"
                        class="mobile-submenu-item
                        {{ request()->routeIs('ppks.import') ? 'active' : '' }}">

                        <span class="material-symbols-outlined">
                            upload_file
                        </span>

                        <span>
                            Import Data
                        </span>

                    </a>


                    {{-- DATA NORMAL --}}

                    <a href="{{ route('ppks.normal') }}"
                        class="mobile-submenu-item
                        {{ request()->routeIs('ppks.normal') ? 'active' : '' }}">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Normal
                        </span>

                    </a>


                    {{-- PERLU PEMERIKSAAN --}}

                    <a href="{{ route('ppks.perlu-diperiksa') }}"
                        class="mobile-submenu-item
                        {{ request()->routeIs('ppks.perlu-diperiksa') ? 'active' : '' }}">

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
            CASE CONFERENCE
            ================================================== --}}

            <a href="#"
                class="mobile-nav-item">

                <span class="material-symbols-outlined">
                    groups
                </span>

                <span>
                    Case Conference
                </span>

            </a>


            {{-- =================================================
            ASESMEN INSTRUKTUR
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button"
                    class="mobile-nav-parent"
                    :class="{ 'menu-open': instructorOpen }"
                    @click="instructorOpen = !instructorOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            badge
                        </span>

                        <span>
                            Asesmen Instruktur
                        </span>

                    </span>

                    <span class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': instructorOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="instructorOpen"
                    x-transition
                    class="mobile-submenu">


                    {{-- DATA LOLOS --}}

                    <a href="#"
                        class="mobile-submenu-item">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    {{-- DATA PENDING --}}

                    <a href="#"
                        class="mobile-submenu-item">

                        <span class="material-symbols-outlined">
                            pending
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    {{-- DATA TIDAK LOLOS --}}

                    <a href="#"
                        class="mobile-submenu-item">

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
            ASESMEN KESEHATAN
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button"
                    class="mobile-nav-parent"
                    :class="{ 'menu-open': healthOpen }"
                    @click="healthOpen = !healthOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            medical_information
                        </span>

                        <span>
                            Asesmen Kesehatan
                        </span>

                    </span>

                    <span class="material-symbols-outlined mobile-nav-arrow"
                        :class="{ 'rotate': healthOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="healthOpen"
                    x-transition
                    class="mobile-submenu">


                    {{-- DATA LOLOS --}}

                    <a href="#"
                        class="mobile-submenu-item">

                        <span class="material-symbols-outlined">
                            check_circle
                        </span>

                        <span>
                            Data Lolos
                        </span>

                    </a>


                    {{-- DATA PENDING --}}

                    <a href="#"
                        class="mobile-submenu-item">

                        <span class="material-symbols-outlined">
                            pending
                        </span>

                        <span>
                            Data Pending
                        </span>

                    </a>


                    {{-- DATA TIDAK LOLOS --}}

                    <a href="#"
                        class="mobile-submenu-item">

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
            PEMANGGILAN PESERTA
            ================================================== --}}

            <a href="#"
                class="mobile-nav-item">

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

            <a href="#"
                class="mobile-nav-item">

                <span class="material-symbols-outlined">
                    person_add
                </span>

                <span>
                    Peserta Aktif
                </span>

            </a>

        </div>


        {{-- =====================================================
        LOGOUT MOBILE
        ====================================================== --}}

        <div class="mobile-logout">

            <form method="POST"
                action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                    class="mobile-logout-button">

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

</nav>
