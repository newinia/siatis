<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        {{ config('app.name', 'SIATIS') }}
    </title>


    {{-- GOOGLE FONTS --}}

    <link
        rel="preconnect"
        href="https://fonts.bunny.net"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >


    {{-- MATERIAL SYMBOLS --}}

    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,400,0,0"
    >


    {{-- POPPINS --}}

    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet"
    >


    {{-- VITE --}}

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body
    x-data="{
        open: false,
        sidebarOpen: true,
        ppksOpen: true,
        instructorOpen: false,
        healthOpen: false
    }"

    class="min-h-screen bg-[#f5f6fa] overflow-x-hidden"
>


    {{-- =========================================================
         SIDEBAR + NAVBAR
    ========================================================== --}}

    @include('layouts.navigation')



    {{-- =========================================================
         MAIN CONTENT
    ========================================================== --}}

    <main
        class="
            min-h-screen
            pt-[88px]
            overflow-x-hidden
            transition-all
            duration-300
        "

        :class="
            sidebarOpen
                ? 'ml-[273px] w-[calc(100%-273px)]'
                : 'ml-0 w-full'
        "
    >

        {{-- JANGAN PAKAI max-w-7xl / mx-auto DI SINI --}}

        <div class="dashboard-wrapper">

            {{ $slot }}

        </div>

    </main>


    {{-- =========================================================
         LAYOUT FIX
    ========================================================== --}}

    <style>

        html,
        body {

            width: 100%;

            max-width: 100%;

            margin: 0;

            padding: 0;

            overflow-x: hidden !important;

        }


        *,
        *::before,
        *::after {

            box-sizing: border-box;

        }


        .dashboard-wrapper {

            width: 100%;

            max-width: none !important;

            min-width: 0;

            margin: 0 !important;

            padding: 0 18px 24px 18px;

            overflow-x: hidden;

        }


        @media (max-width: 900px) {

            .dashboard-wrapper {

                padding-left: 12px;

                padding-right: 12px;

            }

        }

    </style>


</body>

</html>
