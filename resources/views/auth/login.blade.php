<x-guest-layout>
    <div class="min-h-screen flex bg-[#EDF2FF]">

        <!-- Kiri -->
        <div class="hidden lg:block w-1/2 h-screen">
            <img
                src="{{ asset('images/login-bg.jpeg') }}"
                alt="Background"
                class="w-full h-full object-cover">
        </div>

        <!-- Kanan -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-10">

            <div class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-10">

                <!-- Logo -->
                <div class="flex justify-center mb-6">
                    <img
                        src="{{ asset('images/logo.png') }}"
                        alt="Logo STIS"
                        class="w-36">
                </div>

                <!-- Judul -->
                <h1 class="text-3xl font-bold text-center text-gray-800">
                    Login
                </h1>

                <p class="text-center text-gray-500 mt-2 mb-8">
                    Selamat Datang di Sistem Informasi STIS
                </p>

                <!-- Session -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
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
                            class="block w-full rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600" />

                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Password
                        </label>

                        <x-text-input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="Masukkan password"
                            class="block w-full rounded-xl border-gray-300 focus:border-blue-600 focus:ring-blue-600" />

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center justify-between">

                        <label class="flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">

                            <span class="ml-2 text-sm text-gray-600">
                                Ingat saya
                            </span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                                class="text-sm text-blue-600 hover:underline">
                                Lupa Password?
                            </a>
                        @endif

                    </div>

                    <!-- Button -->
                    <button
                        type="submit"
                        class="w-full py-3 rounded-xl bg-blue-700 hover:bg-blue-800 text-white font-semibold transition duration-300">

                        Login

                    </button>

                </form>

                <p class="text-center text-sm text-gray-500 mt-8">
                    Belum punya akun?

                    <a href="{{ route('register') }}"
                        class="text-blue-700 font-semibold hover:underline">

                        Daftar

                    </a>
                </p>

            </div>

        </div>

    </div>
</x-guest-layout>
