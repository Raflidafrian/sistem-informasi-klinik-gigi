<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'DentalCare - Dokter' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-green-50 text-gray-800 antialiased">

<div x-data="{ sidebarOpen: false }" class="min-h-screen">

    {{-- OVERLAY MOBILE --}}
    <div
        x-show="sidebarOpen"
        x-cloak
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-black/50 lg:hidden">
    </div>


    {{-- SIDEBAR --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 flex w-64
               flex-col bg-green-800 text-white
               transition-transform duration-200
               lg:translate-x-0">

        {{-- LOGO --}}
        <div class="flex h-20 shrink-0 items-center gap-3
                    border-b border-green-700 px-5">

            {{-- ICON LOGO --}}
            <div class="flex h-11 w-11 shrink-0 items-center
                        justify-center rounded-xl
                        bg-green-500 text-white shadow-md">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                    class="h-6 w-6">

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M7.5 3C5.57 3 4 4.57 4 6.5c0 1.03.44 1.96 1.14 2.61C5.05 10.1 5 11.14 5 12.2c0 4.2 1.34 8.8 3.2 8.8 1.2 0 1.45-2.05 1.8-4.2.3-1.8.7-3.6 2-3.6s1.7 1.8 2 3.6c.35 2.15.6 4.2 1.8 4.2 1.86 0 3.2-4.6 3.2-8.8 0-1.06-.05-2.1-.14-3.09A3.49 3.49 0 0 0 20 6.5C20 4.57 18.43 3 16.5 3c-1.36 0-2.56.78-3.15 1.92a1.5 1.5 0 0 1-2.7 0A3.51 3.51 0 0 0 7.5 3Z" />

                </svg>

            </div>

            <div>
                <h1 class="text-xl font-bold">
                    DentalCare
                </h1>

                <p class="text-xs text-green-200">
                    Klinik Gigi
                </p>
            </div>

            {{-- CLOSE MOBILE --}}
            <button
                type="button"
                @click="sidebarOpen = false"
                class="ml-auto text-xl lg:hidden"
                aria-label="Tutup menu">

                &times;

            </button>

        </div>


        {{-- MENU --}}
        @php
            $menus = [
                [
                    'label' => 'Dashboard',
                    'route' => 'dokter.dashboard',
                    'active' => 'dokter.dashboard',
                    'icon' => 'home',
                ],
                [
                    'label' => 'Appointment',
                    'route' => 'dokter.appointments.index',
                    'active' => 'dokter.appointments.*',
                    'icon' => 'calendar',
                ],
                [
                    'label' => 'Antrian Pasien',
                    'route' => 'dokter.queue.index',
                    'active' => 'dokter.queue.*',
                    'icon' => 'users',
                ],
                [
                    'label' => 'Rekam Medis',
                    'route' => 'dokter.dental-records.index',
                    'active' => 'dokter.dental-records.*',
                    'icon' => 'clipboard',
                ],
                [
                    'label' => 'Odontogram',
                    'route' => 'dokter.odontogram.index',
                    'active' => 'dokter.odontogram.*',
                    'icon' => 'tooth',
                ],
                [
                    'label' => 'Resep Obat',
                    'route' => 'dokter.prescriptions.index',
                    'active' => 'dokter.prescriptions.*',
                    'icon' => 'pill',
                ],
            ];
        @endphp


        <nav class="min-h-0 flex-1 space-y-1
                    overflow-y-auto px-3 py-5">

            @foreach ($menus as $menu)

                <a
                    href="{{ route($menu['route']) }}"
                    @if (request()->routeIs($menu['active']))
                        aria-current="page"
                    @endif
                    class="flex items-center gap-3 rounded-xl
                           px-4 py-3 text-sm font-medium
                           transition duration-200
                           {{ request()->routeIs($menu['active'])
                               ? 'bg-green-500 text-white shadow-md'
                               : 'text-green-100 hover:bg-green-700 hover:text-white' }}">

                    {{-- DASHBOARD --}}
                    @if ($menu['icon'] === 'home')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6 shrink-0">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m2.25 12 8.954-8.954a1.125 1.125 0 0 1 1.592 0L21.75 12M4.5 9.75V21h15V9.75M9 21v-5.25h6V21" />

                        </svg>


                    {{-- CALENDAR --}}
                    @elseif ($menu['icon'] === 'calendar')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6 shrink-0">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3.75 8.25h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v13.5a1.5 1.5 0 0 1-1.5 1.5H5.25a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5Z" />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 12h.008v.008H8.25V12ZM12 12h.008v.008H12V12ZM15.75 12h.008v.008h-.008V12ZM8.25 15.75h.008v.008H8.25v-.008ZM12 15.75h.008v.008H12v-.008ZM15.75 15.75h.008v.008h-.008v-.008Z" />

                        </svg>


                    {{-- USERS --}}
                    @elseif ($menu['icon'] === 'users')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6 shrink-0">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15 19.125a7.5 7.5 0 0 0-6 0M12 12.75a3.75 3.75 0 1 0 0-7.5 3.75 3.75 0 0 0 0 7.5ZM18.75 11.25a3 3 0 1 0-1.5-5.598M20.25 19.125a6.01 6.01 0 0 0-3.375-5.4" />

                        </svg>


                    {{-- REKAM MEDIS --}}
                    @elseif ($menu['icon'] === 'clipboard')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6 shrink-0">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 3.75h6M9.75 3h4.5a1.5 1.5 0 0 1 1.5 1.5v.75h1.5A1.5 1.5 0 0 1 18.75 6.75v13.5a1.5 1.5 0 0 1-1.5 1.5H6.75a1.5 1.5 0 0 1-1.5-1.5V6.75a1.5 1.5 0 0 1 1.5-1.5h1.5V4.5A1.5 1.5 0 0 1 9.75 3Z" />

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 11.25h7.5M8.25 15h5.25" />

                        </svg>


                    {{-- ODONTOGRAM --}}
                    @elseif ($menu['icon'] === 'tooth')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6 shrink-0">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M7.5 4.5C5.57 4.5 4.125 5.95 4.125 7.875c0 1.4.525 2.475.975 3.375.45.9.9 1.8.9 3.3 0 2.175.825 4.95 2.1 4.95.825 0 1.125-1.275 1.35-2.475.225-1.275.525-2.55 1.65-2.55s1.425 1.275 1.65 2.55c.225 1.2.525 2.475 1.35 2.475 1.275 0 2.1-2.775 2.1-4.95 0-1.5.45-2.4.9-3.3.45-.9.975-1.975.975-3.375C19.125 5.95 17.68 4.5 15.75 4.5c-1.2 0-2.25.525-3 1.425a1 1 0 0 1-1.5 0A4.02 4.02 0 0 0 7.5 4.5Z" />

                        </svg>


                    {{-- RESEP OBAT --}}
                    @elseif ($menu['icon'] === 'pill')

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-6 w-6 shrink-0">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m8.25 15.75 7.5-7.5M6.75 20.25a4.5 4.5 0 0 1 0-6.364l6.136-6.136a4.5 4.5 0 1 1 6.364 6.364l-6.136 6.136a4.5 4.5 0 0 1-6.364 0Z" />

                        </svg>

                    @endif


                    <span>
                        {{ $menu['label'] }}
                    </span>

                </a>

            @endforeach

        </nav>


        {{-- PROFIL DOKTER --}}
        <div class="shrink-0 border-t border-green-700
                    bg-green-900/40 p-4">

            <div class="mb-4 flex items-center gap-3">

                <div class="flex h-11 w-11 shrink-0
                            items-center justify-center
                            rounded-full bg-green-500
                            font-bold text-white">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

                <div class="min-w-0">

                    <p class="truncate text-sm font-semibold">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-green-200">
                        Dokter Gigi
                    </p>

                </div>

            </div>


            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="w-full rounded-xl
                           border border-green-600
                           px-4 py-2.5 text-left text-sm
                           font-medium text-green-100
                           transition
                           hover:border-red-500
                           hover:bg-red-600
                           hover:text-white">

                    <div class="flex items-center gap-3">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-5 w-5">

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6A2.25 2.25 0 0 0 5.25 5.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3 3m0 0-3 3m3-3H3" />

                        </svg>

                        <span>Logout</span>

                    </div>

                </button>

            </form>

        </div>

    </aside>


    {{-- AREA KONTEN --}}
    <div class="min-h-screen lg:ml-64">

        {{-- TOPBAR --}}
        <header
            class="sticky top-0 z-30 flex min-h-20
                   items-center justify-between
                   border-b border-green-100
                   bg-white px-4 shadow-sm
                   sm:px-6 lg:px-8">

            <div class="flex items-center gap-3">

                {{-- MOBILE MENU --}}
                <button
                    type="button"
                    @click="sidebarOpen = true"
                    class="rounded-lg p-2 text-green-800
                           hover:bg-green-50 lg:hidden"
                    aria-label="Buka menu">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="2"
                        stroke="currentColor"
                        class="h-6 w-6">

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />

                    </svg>

                </button>


                <div>

                    <h2 class="text-lg font-bold text-green-900
                               sm:text-xl">

                        {{ $header ?? 'Dashboard Dokter' }}

                    </h2>

                    <p class="hidden text-sm text-gray-500 sm:block">
                        Sistem Manajemen Praktik Dokter Gigi
                    </p>

                </div>

            </div>


            {{-- PROFILE TOPBAR --}}
            <div class="flex items-center gap-3">

                <div class="hidden text-right sm:block">

                    <p class="text-sm font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-green-700">
                        Dokter Gigi
                    </p>

                </div>


                <div
                    class="flex h-10 w-10 items-center
                           justify-center rounded-full
                           bg-green-100 font-bold text-green-800">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            </div>

        </header>


        {{-- KONTEN HALAMAN --}}
        <main class="min-w-0 p-4 sm:p-6 lg:p-8">

            {{ $slot }}

        </main>

    </div>

</div>

</body>
</html>