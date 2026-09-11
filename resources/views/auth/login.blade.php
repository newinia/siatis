
<x-guest-layout>

    <div class="login-page">

        {{-- =====================================================
        GAMBAR LOGIN
        ====================================================== --}}
        <div class="login-page__image">

            <img
                src="{{ asset('images/login-bg.jpeg') }}"
                alt="Background Login"
            >

        </div>


        {{-- =====================================================
        CONTENT LOGIN
        ====================================================== --}}
        <div class="login-page__content">

            <div class="login-page__card">

                {{-- =================================================
                LOGO
                ================================================== --}}
                <div class="login-page__logo">

                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo STIS"
                    >

                </div>


                {{-- =================================================
                HEADING
                ================================================== --}}
                <div class="login-page__heading">

                    <h1>
                        Login
                    </h1>

                    <p>
                        Selamat Datang di Sistem Informasi STIS
                    </p>

                </div>


                {{-- =================================================
                SESSION STATUS
                ================================================== --}}
                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')"
                />


                {{-- =================================================
                CEK ERROR LOGIN
                ================================================== --}}
                @php

                    /*
                    |--------------------------------------------------
                    | Error credentials
                    |--------------------------------------------------
                    | Laravel menaruh error email/password salah
                    | pada field email.
                    |
                    | Karena sistem tidak tahu mana yang salah,
                    | email atau password, maka kedua input dibuat
                    | merah.
                    |
                    */

                    $credentialError =
                        $errors->has('email') &&
                        $errors->first('email') === 'Email atau password yang Anda masukkan salah.';

                @endphp


                {{-- =================================================
                FORM LOGIN
                ================================================== --}}
                <form
                    method="POST"
                    action="{{ route('login') }}"
                    class="login-page__form"
                    novalidate
                >

                    @csrf


                    {{-- =================================================
                    EMAIL
                    ================================================== --}}
                    <div class="login-page__field">

                        <label for="email">
                            Email
                        </label>

                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            :value="old('email')"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan email"
                            class="block w-full {{ $errors->has('email') || $credentialError ? 'form-input-error' : '' }}"
                        />


                        {{-- Error Email --}}
                        @if ($errors->has('email'))

                            <div class="form-error">

                                <span class="form-error__icon">
                                    !
                                </span>

                                <span>
                                    {{ $errors->first('email') }}
                                </span>

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                    PASSWORD
                    ================================================== --}}
                    <div class="login-page__field">

                        <label for="password">
                            Password
                        </label>

                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="block w-full {{ $errors->has('password') || $credentialError ? 'form-input-error' : '' }}"
                        />


                        {{-- Error Password --}}
                        @if ($errors->has('password'))

                            <div class="form-error">

                                <span class="form-error__icon">
                                    !
                                </span>

                                <span>
                                    {{ $errors->first('password') }}
                                </span>

                            </div>

                        @endif

                    </div>


                    {{-- =================================================
                    PESAN CREDENTIAL ERROR
                    ================================================== --}}
                    @if ($credentialError)

                        <div class="form-error">

                            <span class="form-error__icon">
                                !
                            </span>

                            <span>
                                Email atau password yang Anda masukkan salah.
                            </span>

                        </div>

                    @endif


                    {{-- =================================================
                    LUPA PASSWORD
                    ================================================== --}}
                    @if (Route::has('password.request'))

                        <div class="login-page__forgot-wrapper">

                            <a
                                href="{{ route('password.request') }}"
                                class="login-page__forgot"
                            >
                                Lupa Password?
                            </a>

                        </div>

                    @endif


                    {{-- =================================================
                    BUTTON LOGIN
                    ================================================== --}}
                    <button
                        type="submit"
                        class="login-page__button"
                    >
                        Login
                    </button>

                </form>


                {{-- =================================================
                REGISTER
                ================================================== --}}
                @if (Route::has('register'))

                    <div class="login-page__register">

                        <span>
                            Belum punya akun?
                        </span>

                        <a href="{{ route('register') }}">
                            Daftar
                        </a>

                    </div>

                @endif

            </div>

        </div>

    </div>

</x-guest-layout>

