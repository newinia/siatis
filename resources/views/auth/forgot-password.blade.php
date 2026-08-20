<x-guest-layout>

    <style>
        .forgot-page {
            height: 100vh;
            width: 100%;
            display: flex;
            overflow: hidden;
            background: #edf2ff;
        }

        .forgot-left {
            width: 50%;
            height: 100vh;
            overflow: hidden;
        }

        .forgot-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .forgot-right {
            width: 50%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .forgot-card {
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 24px;
            padding: 32px;
            box-sizing: border-box;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .forgot-logo {
            width: 80px !important;
            height: auto !important;
            display: block;
            margin: 0 auto 12px auto;
        }

        .forgot-title {
            font-size: 25px;
            line-height: 1.2;
            font-weight: 700;
            text-align: center;
            color: #1f2937;
            margin: 0;
        }

        .forgot-subtitle {
            font-size: 13px;
            line-height: 1.6;
            text-align: center;
            color: #6b7280;
            margin: 8px 0 24px 0;
        }

        .forgot-field label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #374151;
            margin-bottom: 6px;
        }

        .forgot-input {
            width: 100% !important;
            height: 42px !important;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 0 12px;
            font-size: 14px;
            outline: none;
            background: white;
        }

        .forgot-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 1px #2563eb;
        }

        .forgot-button {
            width: 100%;
            height: 42px;
            margin-top: 18px;
            border: none;
            border-radius: 10px;
            background: #1d4ed8;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .forgot-button:hover {
            background: #1e40af;
        }

        .forgot-login {
            text-align: center;
            font-size: 13px;
            color: #6b7280;
            margin-top: 18px;
            margin-bottom: 0;
        }

        .forgot-login a {
            color: #1d4ed8;
            font-weight: 600;
            text-decoration: none;
        }

        .forgot-login a:hover {
            text-decoration: underline;
        }

        @media (max-width: 1023px) {
            .forgot-left {
                display: none;
            }

            .forgot-right {
                width: 100%;
            }
        }
    </style>

    <div class="forgot-page">

        <!-- KIRI -->
        <div class="forgot-left">
            <img
                src="{{ asset('images/login-bg.jpeg') }}"
                alt="Background STIS">
        </div>

        <!-- KANAN -->
        <div class="forgot-right">

            <div class="forgot-card">

                <!-- LOGO -->
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo STIS"
                    class="forgot-logo">

                <!-- JUDUL -->
                <h1 class="forgot-title">
                    Lupa Password
                </h1>

                <p class="forgot-subtitle">
                    Masukkan email yang terdaftar dan kami akan
                    mengirimkan link untuk mengatur ulang password Anda.
                </p>

                <!-- STATUS -->
                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')" />

                <!-- FORM -->
                <form
                    method="POST"
                    action="{{ route('password.email') }}">

                    @csrf

                    <!-- EMAIL -->
                    <div class="forgot-field">

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
                            autocomplete="email"
                            placeholder="Masukkan email"
                            class="forgot-input" />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-1" />

                    </div>

                    <!-- BUTTON -->
                    <button
                        type="submit"
                        class="forgot-button">
                        Kirim Link Reset Password
                    </button>

                </form>

                <!-- KEMBALI LOGIN -->
                <p class="forgot-login">

                    Ingat password?

                    <a href="{{ route('login') }}">
                        Login
                    </a>

                </p>

            </div>

        </div>

    </div>

</x-guest-layout>
