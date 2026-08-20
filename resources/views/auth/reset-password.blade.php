<x-guest-layout>

    <style>
        .reset-page {
            height: 100vh;
            width: 100%;
            display: flex;
            overflow: hidden;
            background: #edf2ff;
        }

        .reset-left {
            width: 50%;
            height: 100vh;
            overflow: hidden;
        }

        .reset-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .reset-right {
            width: 50%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .reset-card {
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 24px;
            padding: 28px 32px;
            box-sizing: border-box;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .reset-logo {
            width: 80px !important;
            height: auto !important;
            display: block;
            margin: 0 auto 12px auto;
        }

        .reset-title {
            font-size: 25px;
            line-height: 1.2;
            font-weight: 700;
            text-align: center;
            color: #1f2937;
            margin: 0;
        }

        .reset-subtitle {
            font-size: 13px;
            line-height: 1.6;
            text-align: center;
            color: #6b7280;
            margin: 8px 0 22px 0;
        }

        .reset-form {
            display: flex;
            flex-direction: column;
            gap: 13px;
        }

        .reset-field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 5px;
        }

        .reset-input {
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

        .reset-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 1px #2563eb;
        }

        .reset-button {
            width: 100%;
            height: 40px;
            margin-top: 4px;
            border: none;
            border-radius: 10px;
            background: #1d4ed8;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .reset-button:hover {
            background: #1e40af;
        }

        .reset-login {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 16px;
            margin-bottom: 0;
        }

        .reset-login a {
            color: #1d4ed8;
            font-weight: 600;
            text-decoration: none;
        }

        .reset-login a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1023px) {
            .reset-left {
                display: none;
            }

            .reset-right {
                width: 100%;
            }
        }

        @media (max-height: 750px) and (min-width: 1024px) {
            .reset-card {
                padding: 20px 28px;
            }

            .reset-logo {
                width: 65px !important;
                margin-bottom: 7px;
            }

            .reset-subtitle {
                margin-bottom: 14px;
            }

            .reset-form {
                gap: 9px;
            }

            .reset-input,
            .reset-button {
                height: 36px !important;
            }
        }
    </style>

    <div class="reset-page">

        <!-- KIRI -->
        <div class="reset-left">
            <img
                src="{{ asset('images/login-bg.jpeg') }}"
                alt="Background STIS">
        </div>

        <!-- KANAN -->
        <div class="reset-right">

            <div class="reset-card">

                <!-- LOGO -->
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo STIS"
                    class="reset-logo">

                <!-- JUDUL -->
                <h1 class="reset-title">
                    Reset Password
                </h1>

                <p class="reset-subtitle">
                    Buat password baru untuk akun Anda.
                </p>

                <!-- FORM -->
                <form
                    method="POST"
                    action="{{ route('password.store') }}"
                    class="reset-form">

                    @csrf

                    <!-- TOKEN -->
                    <input
                        type="hidden"
                        name="token"
                        value="{{ $request->route('token') }}">

                    <!-- EMAIL -->
                    <div class="reset-field">

                        <label for="email">
                            Email
                        </label>

                        <x-text-input
                            id="email"
                            name="email"
                            type="email"
                            :value="old('email', $request->email)"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="Masukkan email"
                            class="reset-input" />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-1" />

                    </div>

                    <!-- PASSWORD -->
                    <div class="reset-field">

                        <label for="password">
                            Password Baru
                        </label>

                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="Masukkan password baru"
                            class="reset-input" />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-1" />

                    </div>

                    <!-- KONFIRMASI -->
                    <div class="reset-field">

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
                            class="reset-input" />

                        <x-input-error
                            :messages="$errors->get('password_confirmation')"
                            class="mt-1" />

                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        class="reset-button">
                        Reset Password
                    </button>

                </form>

                <!-- LOGIN -->
                <p class="reset-login">

                    Ingat password?

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                </p>

            </div>

        </div>

    </div>

</x-guest-layout>
