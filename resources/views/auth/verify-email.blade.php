<x-guest-layout>

    <style>
        .verify-page {
            height: 100vh;
            width: 100%;
            display: flex;
            overflow: hidden;
            background: #edf2ff;
        }

        .verify-left {
            width: 50%;
            height: 100vh;
            overflow: hidden;
        }

        .verify-left img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .verify-right {
            width: 50%;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .verify-card {
            width: 100%;
            max-width: 440px;
            background: white;
            border-radius: 24px;
            padding: 32px;
            box-sizing: border-box;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }

        .verify-logo {
            width: 80px !important;
            height: auto !important;
            display: block;
            margin: 0 auto 12px auto;
        }

        .verify-title {
            font-size: 25px;
            line-height: 1.2;
            font-weight: 700;
            text-align: center;
            color: #1f2937;
            margin: 0 0 8px 0;
        }

        .verify-text {
            font-size: 13px;
            line-height: 1.7;
            text-align: center;
            color: #6b7280;
            margin: 0 0 18px 0;
        }

        .verify-success {
            font-size: 13px;
            line-height: 1.5;
            text-align: center;
            color: #16a34a;
            background: #f0fdf4;
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 18px;
        }

        .verify-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .verify-button {
            width: 100%;
            height: 42px;
            border: none;
            border-radius: 10px;
            background: #1d4ed8;
            color: white;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
        }

        .verify-button:hover {
            background: #1e40af;
        }

        .verify-logout {
            width: 100%;
            height: 40px;
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 13px;
            cursor: pointer;
        }

        .verify-logout:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        @media (max-width: 1023px) {
            .verify-left {
                display: none;
            }

            .verify-right {
                width: 100%;
            }
        }

        @media (max-height: 750px) and (min-width: 1024px) {
            .verify-card {
                padding: 24px 28px;
            }

            .verify-logo {
                width: 65px !important;
                margin-bottom: 8px;
            }

            .verify-text {
                margin-bottom: 14px;
            }
        }
    </style>

    <div class="verify-page">

        <!-- KIRI -->
        <div class="verify-left">
            <img
                src="{{ asset('images/login-bg.jpeg') }}"
                alt="Background STIS">
        </div>

        <!-- KANAN -->
        <div class="verify-right">

            <div class="verify-card">

                <!-- LOGO -->
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo STIS"
                    class="verify-logo">

                <!-- JUDUL -->
                <h1 class="verify-title">
                    Verifikasi Email
                </h1>

                <!-- INFORMASI -->
                <p class="verify-text">
                    Terima kasih telah mendaftar!
                    Sebelum melanjutkan, silakan verifikasi alamat email Anda
                    dengan mengklik link yang telah kami kirimkan ke email Anda.
                </p>

                <!-- STATUS -->
                @if (session('status') == 'verification-link-sent')

                    <div class="verify-success">
                        Link verifikasi baru telah dikirim ke alamat email
                        yang Anda gunakan saat mendaftar.
                    </div>

                @endif

                <!-- ACTION -->
                <div class="verify-actions">

                    <!-- KIRIM ULANG -->
                    <form
                        method="POST"
                        action="{{ route('verification.send') }}">

                        @csrf

                        <button
                            type="submit"
                            class="verify-button">
                            Kirim Ulang Email Verifikasi
                        </button>

                    </form>

                    <!-- LOGOUT -->
                    <form
                        method="POST"
                        action="{{ route('logout') }}">

                        @csrf

                        <button
                            type="submit"
                            class="verify-logout">
                            Logout
                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</x-guest-layout>
