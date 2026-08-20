<x-guest-layout>

    <style>
        .register-page {
            height: 100vh;
            width: 100%;
            display: flex;
            overflow: hidden;
            background: #edf2ff;
        }

        .register-left {
            width: 50%;
            height: 100vh;
            overflow: hidden;
        }

        .register-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .register-right {
            width: 50%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .register-card {
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 24px;
            padding: 24px 32px;
            box-sizing: border-box;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .register-logo {
            width: 80px !important;
            height: auto !important;
            display: block;
            margin: 0 auto 8px auto;
        }

        .register-title {
            font-size: 25px;
            line-height: 1.2;
            font-weight: 700;
            text-align: center;
            color: #1f2937;
            margin: 0;
        }

        .register-subtitle {
            font-size: 13px;
            text-align: center;
            color: #6b7280;
            margin: 6px 0 18px 0;
        }

        .register-form {
            display: flex;
            flex-direction: column;
            gap: 11px;
        }

        .register-field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 5px;
        }

        .register-input {
            width: 100% !important;
            height: 40px !important;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 0 12px;
            font-size: 14px;
            outline: none;
            background: white;
        }

        .register-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 1px #2563eb;
        }

        .register-select {
            width: 100%;
            height: 40px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 0 12px;
            font-size: 14px;
            background: white;
            outline: none;
        }

        .register-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 1px #2563eb;
        }

        .register-button {
            width: 100%;
            height: 40px;
            margin-top: 2px;
            border: none;
            border-radius: 10px;
            background: #1d4ed8;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .register-button:hover {
            background: #1e40af;
        }

        .register-login {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 14px;
            margin-bottom: 0;
        }

        .register-login a {
            color: #1d4ed8;
            font-weight: 600;
            text-decoration: none;
        }

        .register-login a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1023px) {
            .register-left {
                display: none;
            }

            .register-right {
                width: 100%;
            }
        }

        @media (max-height: 750px) and (min-width: 1024px) {
            .register-card {
                padding: 18px 28px;
            }

            .register-logo {
                width: 65px !important;
                margin-bottom: 5px;
            }

            .register-subtitle {
                margin-bottom: 12px;
            }

            .register-form {
                gap: 8px;
            }

            .register-input,
            .register-select,
            .register-button {
                height: 36px !important;
            }

            .register-login {
                margin-top: 10px;
            }
        }
    </style>

    <div class="register-page">

        <!-- KIRI -->
        <div class="register-left">
            <img
                src="{{ asset('images/login-bg.jpeg') }}"
                alt="Background STIS">
        </div>

        <!-- KANAN -->
        <div class="register-right">

            <div class="register-card">

                <!-- LOGO -->
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo STIS"
                    class="register-logo">

                <!-- JUDUL -->
                <h1 class="register-title">
                    Daftar Akun
                </h1>

                <p class="register-subtitle">
                    Buat akun untuk mengakses Sistem Informasi STIS
                </p>

                <!-- FORM -->
                <form
                    method="POST"
                    action="{{ route('register') }}"
                    class="register-form">

                    @csrf

                    <!-- NAMA -->
                    <div class="register-field">

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
                            class="register-input" />

                        <x-input-error
                            :messages="$errors->get('name')"
                            class="mt-1" />

                    </div>

                    <!-- EMAIL -->
                    <div class="register-field">

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
                            class="register-input" />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-1" />

                    </div>

                    <!-- ROLE -->
                    <div class="register-field">

                        <label for="role">
                            Role
                        </label>

                        <select
                            id="role"
                            name="role"
                            required
                            class="register-select">

                            <option
                                value=""
                                disabled
                                {{ old('role') ? '' : 'selected' }}>
                                Pilih role
                            </option>

                            <option
                                value="instruktur"
                                {{ old('role') == 'instruktur' ? 'selected' : '' }}>
                                Instruktur
                            </option>

                            <option
                                value="medis"
                                {{ old('role') == 'medis' ? 'selected' : '' }}>
                                Medis
                            </option>

                        </select>

                        <x-input-error
                            :messages="$errors->get('role')"
                            class="mt-1" />

                    </div>

                    <!-- PASSWORD -->
                    <div class="register-field">

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
                            class="register-input" />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-1" />

                    </div>

                    <!-- KONFIRMASI PASSWORD -->
                    <div class="register-field">

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
                            class="register-input" />

                        <x-input-error
                            :messages="$errors->get('password_confirmation')"
                            class="mt-1" />

                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        class="register-button">
                        Daftar
                    </button>

                </form>

                <!-- LOGIN -->
                <p class="register-login">

                    Sudah punya akun?

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                </p>

            </div>

        </div>

    </div>

</x-guest-layout>
