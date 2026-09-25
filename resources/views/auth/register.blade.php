
<x-guest-layout>

    {{-- =====================================================
    REGISTER PAGE
    ====================================================== --}}
    <div class="register-page">


        {{-- =================================================
        GAMBAR
        ================================================== --}}
        <div class="register-page__image">

            <img
                src="{{ asset('images/login-bg.jpeg') }}"
                alt="Background Register"
            >

        </div>


        {{-- =================================================
        CONTENT
        ================================================== --}}
        <div class="register-page__content">

            <div class="register-page__card">


                {{-- =================================================
                LOGO
                ================================================== --}}
                <div class="register-page__logo">

                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo STIS"
                    >

                </div>


                {{-- =================================================
                HEADING
                ================================================== --}}
                <div class="register-page__heading">

                    <h1>
                        Daftar Akun
                    </h1>

                    <p>
                        Buat akun untuk mengakses Sistem Informasi STIS
                    </p>

                </div>


                {{-- =================================================
                FORM
                ================================================== --}}
                <form
                    method="POST"
                    action="{{ route('register') }}"
                    class="register-page__form"
                    novalidate
                >

                    @csrf


                    {{-- =================================================
                    NAMA
                    ================================================== --}}
                    <div class="register-page__field">

                        <label for="name">
                            Nama
                        </label>

                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            :value="old('name')"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="Masukkan nama"
                            class="block w-full {{ $errors->has('name') ? 'form-input-error' : '' }}"
                        />

                        @error('name')

                            <div class="form-error">

                                <span class="form-error__icon">
                                    !
                                </span>

                                <span>
                                    {{ $message }}
                                </span>

                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                    EMAIL
                    ================================================== --}}
                    <div class="register-page__field">

                        <label for="email">
                            Email
                        </label>

                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            :value="old('email')"
                            required
                            autocomplete="username"
                            placeholder="Masukkan email"
                            class="block w-full {{ $errors->has('email') ? 'form-input-error' : '' }}"
                        />

                        @error('email')

                            <div class="form-error">

                                <span class="form-error__icon">
                                    !
                                </span>

                                <span>
                                    {{ $message }}
                                </span>

                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                    ROLE
                    ================================================== --}}
                    <div class="register-page__field">

                        <label for="role">
                            Role
                        </label>

                        <select
                            id="role"
                            name="role"
                            required
                            class="register-page__select {{ $errors->has('role') ? 'form-input-error' : '' }}"
                        >

                            <option
                                value=""
                                disabled
                                {{ old('role') ? '' : 'selected' }}
                            >
                                Pilih role
                            </option>

                            <option
                                value="instruktur"
                                {{ old('role') === 'instruktur' ? 'selected' : '' }}
                            >
                                Instruktur
                            </option>

                            <option
                                value="medis"
                                {{ old('role') === 'medis' ? 'selected' : '' }}
                            >
                                Medis
                            </option>

                        </select>


                        @error('role')

                            <div class="form-error">

                                <span class="form-error__icon">
                                    !
                                </span>

                                <span>
                                    {{ $message }}
                                </span>

                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                    PASSWORD
                    ================================================== --}}
                    <div class="register-page__field">

                        <label for="password">
                            Password
                        </label>

                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="Masukkan password"
                            class="block w-full {{ $errors->has('password') ? 'form-input-error' : '' }}"
                        />

                        @error('password')

                            <div class="form-error">

                                <span class="form-error__icon">
                                    !
                                </span>

                                <span>
                                    {{ $message }}
                                </span>

                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                    KONFIRMASI PASSWORD
                    ================================================== --}}
                    <div class="register-page__field">

                        <label for="password_confirmation">
                            Konfirmasi Password
                        </label>

                        <x-text-input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="Masukkan ulang password"
                            class="block w-full {{ $errors->has('password_confirmation') ? 'form-input-error' : '' }}"
                        />

                        @error('password_confirmation')

                            <div class="form-error">

                                <span class="form-error__icon">
                                    !
                                </span>

                                <span>
                                    {{ $message }}
                                </span>

                            </div>

                        @enderror

                    </div>


                    {{-- =================================================
                    BUTTON
                    ================================================== --}}
                    <button
                        type="submit"
                        class="register-page__button"
                    >
                        Daftar
                    </button>

                </form>


                {{-- =================================================
                LOGIN
                ================================================== --}}
                <div class="register-page__login">

                    <span>
                        Sudah punya akun?
                    </span>

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>
