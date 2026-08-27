<nav x-data="{
        open: false,
        sidebarOpen: true,
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


            {{-- DASHBOARD --}}

            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <span class="material-symbols-outlined nav-icon">
                    dashboard
                </span>

                <span class="nav-text">
                    Dashboard
                </span>

            </a>


            {{-- CASE CONFERENCE --}}

            <a href="{{ route('case-conference') }}"
                class="nav-item {{ request()->routeIs('case-conference') ? 'active' : '' }}">

                <span class="material-symbols-outlined nav-icon">
                    groups
                </span>

                <span class="nav-text">
                    Case Conference
                </span>

            </a>


            {{-- DATA --}}

            <a href="#" class="nav-item">

                <span class="material-symbols-outlined nav-icon">
                    description
                </span>

                <span class="nav-text">
                    Data
                </span>

            </a>


            {{-- =================================================
            ASESMEN kesehatan
            ================================================== --}}

            <div class="nav-group">

                <button type="button" class="nav-item nav-parent" :class="{ 'menu-open': instructorOpen }"
                    @click="instructorOpen = !instructorOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            badge
                        </span>

                        <span class="nav-text">
                            Asesmen kesehatan
                        </span>

                    </span>

                    <span class="material-symbols-outlined nav-arrow" :class="{ 'rotate': instructorOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="instructorOpen" x-transition class="nav-submenu">

                    <a href="#" class="nav-submenu-item">
                        Data Lolos
                    </a>

                    <a href="#" class="nav-submenu-item">
                        Data Pending
                    </a>

                    <a href="#" class="nav-submenu-item">
                        Data Tidak Lolos
                    </a>

                </div>

            </div>


            {{-- =================================================
            ASESMEN KESEHATAN
            ================================================== --}}

            <div class="nav-group">

                <button type="button" class="nav-item nav-parent" :class="{ 'menu-open': healthOpen }"
                    @click="healthOpen = !healthOpen">

                    <span class="nav-left">

                        <span class="material-symbols-outlined nav-icon">
                            medical_information
                        </span>

                        <span class="nav-text">
                            Asesmen Kesehatan
                        </span>

                    </span>

                    <span class="material-symbols-outlined nav-arrow" :class="{ 'rotate': healthOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="healthOpen" x-transition class="nav-submenu">

                    <a href="#" class="nav-submenu-item">
                        Data Lolos
                    </a>

                    <a href="#" class="nav-submenu-item">
                        Data Pending
                    </a>

                    <a href="#" class="nav-submenu-item">
                        Data Tidak Lolos
                    </a>

                </div>

            </div>


            {{-- PEMANGGILAN PESERTA --}}

            <a href="#" class="nav-item">

                <span class="material-symbols-outlined nav-icon">
                    record_voice_over
                </span>

                <span class="nav-text">
                    Pemanggilan Peserta
                </span>

            </a>


            {{-- PESERTA AKTIF --}}

            <a href="#" class="nav-item">

                <span class="material-symbols-outlined nav-icon">
                    person_add
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

        </div>

    </aside>



    {{-- =====================================================
    TOP NAVBAR
    ====================================================== --}}

    <header class="top-navbar" :class="{ 'sidebar-closed': !sidebarOpen }">

        {{-- HAMBURGER --}}

        <button type="button" class="navbar-hamburger" @click="
                if (window.innerWidth <= 768) {
                    open = !open;
                } else {
                    sidebarOpen = !sidebarOpen;
                }
            " aria-label="Toggle Navigation">

            <span class="material-symbols-outlined" x-text="
                    window.innerWidth <= 768
                        ? (open ? 'close' : 'menu')
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

    <div x-show="open" x-transition class="mobile-navigation">

        {{-- HEADER MOBILE --}}

        <div class="mobile-nav-header">

            <span>
                MENU UTAMA
            </span>

            <button type="button" @click="open = false" class="mobile-close-button">

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>


        {{-- =================================================
        MENU MOBILE
        ================================================== --}}

        <div class="mobile-nav-menu">


            {{-- DASHBOARD --}}

            <a href="{{ route('dashboard') }}"
                class="mobile-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <span class="material-symbols-outlined">
                    dashboard
                </span>

                <span>
                    Dashboard
                </span>

            </a>


            {{-- CASE CONFERENCE --}}

            <a href="{{ route('case-conference') }}"
                class="mobile-nav-item {{ request()->routeIs('case-conference') ? 'active' : '' }}">

                <span class="material-symbols-outlined">
                    groups
                </span>

                <span>
                    Case Conference
                </span>

            </a>


            {{-- DATA --}}

            <a href="#" class="mobile-nav-item">

                <span class="material-symbols-outlined">
                    description
                </span>

                <span>
                    Data
                </span>

            </a>


            {{-- =================================================
            ASESMEN kesehatan
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button" class="mobile-nav-parent" :class="{ 'menu-open': instructorOpen }"
                    @click="instructorOpen = !instructorOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            badge
                        </span>

                        <span>
                            Asesmen kesehatan
                        </span>

                    </span>


                    <span class="material-symbols-outlined mobile-nav-arrow" :class="{ 'rotate': instructorOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="instructorOpen" x-transition class="mobile-submenu">

                    <a href="#" class="mobile-submenu-item">
                        Data Lolos
                    </a>

                    <a href="#" class="mobile-submenu-item">
                        Data Pending
                    </a>

                    <a href="#" class="mobile-submenu-item">
                        Data Tidak Lolos
                    </a>

                </div>

            </div>


            {{-- =================================================
            ASESMEN KESEHATAN
            ================================================== --}}

            <div class="mobile-nav-group">

                <button type="button" class="mobile-nav-parent" :class="{ 'menu-open': healthOpen }"
                    @click="healthOpen = !healthOpen">

                    <span class="mobile-nav-left">

                        <span class="material-symbols-outlined">
                            medical_information
                        </span>

                        <span>
                            Asesmen Kesehatan
                        </span>

                    </span>


                    <span class="material-symbols-outlined mobile-nav-arrow" :class="{ 'rotate': healthOpen }">
                        expand_more
                    </span>

                </button>


                <div x-show="healthOpen" x-transition class="mobile-submenu">

                    <a href="#" class="mobile-submenu-item">
                        Data Lolos
                    </a>

                    <a href="#" class="mobile-submenu-item">
                        Data Pending
                    </a>

                    <a href="#" class="mobile-submenu-item">
                        Data Tidak Lolos
                    </a>

                </div>

            </div>


            {{-- PEMANGGILAN PESERTA --}}

            <a href="#" class="mobile-nav-item">

                <span class="material-symbols-outlined">
                    record_voice_over
                </span>

                <span>
                    Pemanggilan Peserta
                </span>

            </a>


            {{-- PESERTA AKTIF --}}

            <a href="#" class="mobile-nav-item">

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

        </div>

    </div>

</nav>