<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'DentalCare - Admin' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-green-50 text-gray-800 antialiased">

<div x-data="{ sidebarOpen: false }" class="min-h-screen">

    {{-- Overlay pada layar HP --}}
    <div x-show="sidebarOpen"
         x-cloak
         @click="sidebarOpen = false"
         class="fixed inset-0 z-40 bg-black/50 lg:hidden">
    </div>


    {{-- SIDEBAR ADMIN --}}
    <aside
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col
               bg-green-800 text-white
               transition-transform duration-200
               lg:translate-x-0">


        {{-- LOGO DENTALCARE --}}
        <div class="flex h-20 shrink-0 items-center gap-3
                    border-b border-green-700 px-5">

            {{-- Icon Gigi --}}
            <div class="flex h-11 w-11 items-center justify-center
                        rounded-xl bg-green-500 shadow-md">

                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.8"
                     class="h-7 w-7 text-white">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M9.5 3.5c-1.7 0-2.8.8-3.7 1.5C5 6 4 6.5 3.5 8c-.7 2.2.2 4.2 1.1 6.2.7 1.6 1.4 3.3 1.8 5 .2.9.8 1.8 1.8 1.8 1.1 0 1.4-1.1 1.7-2.3.3-1.3.6-2.7 1.5-2.7s1.2 1.4 1.5 2.7c.3 1.2.6 2.3 1.7 2.3 1 0 1.6-.9 1.8-1.8.4-1.7 1.1-3.4 1.8-5 .9-2 1.8-4 1.1-6.2-.5-1.5-1.5-2-2.3-3-.9-.7-2-1.5-3.7-1.5-1 0-1.7.3-2.3.6-.6-.3-1.3-.6-2.3-.6Z"/>

                    <path stroke-linecap="round"
                          d="M8 8.5c.9-.5 2-.7 4-.7s3.1.2 4 .7"/>
                </svg>
            </div>

            <div>
                <h1 class="text-xl font-bold">DentalCare</h1>
                <p class="text-xs text-green-200">Klinik Gigi</p>
            </div>

            {{-- Tombol tutup sidebar HP --}}
            <button type="button"
                    @click="sidebarOpen = false"
                    class="ml-auto rounded-lg p-1
                           text-green-200
                           transition hover:bg-green-700
                           hover:text-white lg:hidden"
                    aria-label="Tutup menu">

                <svg xmlns="http://www.w3.org/2000/svg"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke-width="2"
                     stroke="currentColor"
                     class="h-6 w-6">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M6 18 18 6M6 6l12 12"/>
                </svg>

            </button>
        </div>


        {{-- MENU --}}
        @php
            $menus = [
                [
                    'label' => 'Dashboard',
                    'icon' => 'dashboard',
                    'route' => 'admin.dashboard',
                    'active' => 'admin.dashboard',
                ],
                [
                    'label' => 'Data Dokter',
                    'icon' => 'doctor',
                    'route' => 'admin.doctors.index',
                    'active' => 'admin.doctors.*',
                ],
                [
                    'label' => 'Data Pasien',
                    'icon' => 'patients',
                    'route' => 'admin.patients.index',
                    'active' => 'admin.patients.*',
                ],
                [
                    'label' => 'Jadwal Praktik',
                    'icon' => 'calendar',
                    'route' => 'admin.schedules.index',
                    'active' => 'admin.schedules.*',
                ],
                [
                    'label' => 'Appointment',
                    'icon' => 'appointment',
                    'route' => 'admin.appointments.index',
                    'active' => 'admin.appointments.*',
                ],
                [
                    'label' => 'Rekam Medis',
                    'icon' => 'medical',
                    'route' => 'admin.dental-records.index',
                    'active' => 'admin.dental-records.*',
                ],
                [
                    'label' => 'Tarif Tindakan',
                    'icon' => 'treatment',
                    'route' => 'admin.treatments.index',
                    'active' => 'admin.treatments.*',
                ],
                [
                    'label' => 'Data Obat',
                    'icon' => 'medicine',
                    'route' => 'admin.medicines.index',
                    'active' => 'admin.medicines.*',
                ],
                [
                    'label' => 'Tagihan',
                    'icon' => 'billing',
                    'route' => 'admin.billings.index',
                    'active' => 'admin.billings.*',
                ],
                [
                    'label' => 'Pembayaran',
                    'icon' => 'payment',
                    'route' => 'admin.payments.index',
                    'active' => 'admin.payments.*',
                ],
                [
                    'label' => 'Riwayat Login',
                    'icon' => 'history',
                    'route' => 'admin.login-histories.index',
                    'active' => 'admin.login-histories.*',
                ],
            ];
        @endphp


        <nav class="min-h-0 flex-1 space-y-1
                    overflow-y-auto px-3 py-5">

            {{-- TIDAK ADA LAGI TULISAN MENU ADMIN --}}

            @foreach ($menus as $menu)

                <a href="{{ route($menu['route']) }}"
                   @if (request()->routeIs($menu['active']))
                       aria-current="page"
                   @endif
                   class="flex items-center gap-3 rounded-xl
                          px-4 py-3 text-sm font-medium
                          transition duration-200
                          {{ request()->routeIs($menu['active'])
                              ? 'bg-green-500 text-white shadow-md'
                              : 'text-green-100 hover:bg-green-700 hover:text-white' }}">

                    {{-- =========================
                         ICON MENU
                    ========================== --}}

                    <span class="flex h-6 w-6 shrink-0
                                 items-center justify-center">

                        {{-- DASHBOARD --}}
                        @if ($menu['icon'] === 'dashboard')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="m2.25 12 9.204-8.01a.75.75 0 0 1 .992 0L21.75 12M4.5 10.5v8.25a.75.75 0 0 0 .75.75h4.5v-5.25h4.5v5.25h4.5a.75.75 0 0 0 .75-.75V10.5"/>

                            </svg>


                        {{-- DOKTER --}}
                        @elseif ($menu['icon'] === 'doctor')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0Z"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M4.5 21a7.5 7.5 0 0 1 15 0"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M12 11.25v4.5m-2.25-2.25h4.5"/>

                            </svg>


                        {{-- PASIEN --}}
                        @elseif ($menu['icon'] === 'patients')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M15 19.5a7.5 7.5 0 0 0-15 0"/>

                                <circle cx="7.5"
                                        cy="7.5"
                                        r="3.75"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M16.5 11.25a3 3 0 1 0 0-6"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M18 19.5a6 6 0 0 0-3.75-5.55"/>

                            </svg>


                        {{-- JADWAL --}}
                        @elseif ($menu['icon'] === 'calendar')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <rect x="3"
                                      y="4.5"
                                      width="18"
                                      height="17"
                                      rx="2"/>

                                <path stroke-linecap="round"
                                      d="M16 2.5v4M8 2.5v4M3 9h18"/>

                                <path stroke-linecap="round"
                                      d="M7 13h.01M12 13h.01M17 13h.01M7 17h.01M12 17h.01M17 17h.01"/>

                            </svg>


                        {{-- APPOINTMENT --}}
                        @elseif ($menu['icon'] === 'appointment')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <rect x="3"
                                      y="4.5"
                                      width="18"
                                      height="17"
                                      rx="2"/>

                                <path stroke-linecap="round"
                                      d="M16 2.5v4M8 2.5v4M3 9h18"/>

                                <circle cx="16.5"
                                        cy="16"
                                        r="3"/>

                                <path stroke-linecap="round"
                                      d="M16.5 14.5v1.5l1 1"/>

                            </svg>


                        {{-- REKAM MEDIS --}}
                        @elseif ($menu['icon'] === 'medical')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6 3.75h9l3 3V20.25a.75.75 0 0 1-.75.75H6a.75.75 0 0 1-.75-.75V4.5A.75.75 0 0 1 6 3.75Z"/>

                                <path stroke-linecap="round"
                                      d="M15 3.75v3h3"/>

                                <path stroke-linecap="round"
                                      d="M12 9v6M9 12h6"/>

                                <path stroke-linecap="round"
                                      d="M9 18h6"/>

                            </svg>


                        {{-- TARIF TINDAKAN --}}
                        @elseif ($menu['icon'] === 'treatment')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M7.5 3.75h9a1.5 1.5 0 0 1 1.5 1.5v15a1.5 1.5 0 0 1-1.5 1.5h-9a1.5 1.5 0 0 1-1.5-1.5v-15a1.5 1.5 0 0 1 1.5-1.5Z"/>

                                <path stroke-linecap="round"
                                      d="M9 3.75v-1.5h6v1.5"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M9.5 14.5c1.5-1 3.5-1 5 0M10 11.5h.01M14 11.5h.01"/>

                            </svg>


                        {{-- OBAT --}}
                        @elseif ($menu['icon'] === 'medicine')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M7.5 16.5 16.5 7.5a4.24 4.24 0 0 1 6 6l-9 9a4.24 4.24 0 0 1-6-6Z"
                                      transform="translate(-3 -3) scale(1.05)"/>

                                <path stroke-linecap="round"
                                      d="m9 9 6 6"/>

                            </svg>


                        {{-- TAGIHAN --}}
                        @elseif ($menu['icon'] === 'billing')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M6 3.75h12v16.5l-3-1.75-3 1.75-3-1.75-3 1.75V3.75Z"/>

                                <path stroke-linecap="round"
                                      d="M9 8h6M9 11.5h6M9 15h3"/>

                            </svg>


                        {{-- PEMBAYARAN --}}
                        @elseif ($menu['icon'] === 'payment')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <rect x="2.75"
                                      y="5"
                                      width="18.5"
                                      height="14"
                                      rx="2"/>

                                <path stroke-linecap="round"
                                      d="M3 9h18"/>

                                <path stroke-linecap="round"
                                      d="M7 14h4"/>

                            </svg>


                        {{-- RIWAYAT LOGIN --}}
                        @elseif ($menu['icon'] === 'history')

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke-width="1.8"
                                 stroke="currentColor"
                                 class="h-6 w-6">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3 12a9 9 0 1 0 3-6.7"/>

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      d="M3 4.5v5h5"/>

                                <path stroke-linecap="round"
                                      d="M12 7.5V12l3 2"/>

                            </svg>

                        @endif

                    </span>


                    {{-- NAMA MENU --}}
                    <span>{{ $menu['label'] }}</span>

                </a>

            @endforeach

        </nav>


        {{-- PROFIL ADMINISTRATOR --}}
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
                        Administrator
                    </p>

                </div>

            </div>


            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="flex w-full items-center gap-3
                               rounded-xl border border-green-600
                               px-4 py-2.5 text-left text-sm
                               font-medium text-green-100
                               transition
                               hover:border-red-500
                               hover:bg-red-600
                               hover:text-white">

                    {{-- Logout Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="1.8"
                         stroke="currentColor"
                         class="h-5 w-5">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-7A2.25 2.25 0 0 0 4.25 5.25v13.5A2.25 2.25 0 0 0 6.5 21h7a2.25 2.25 0 0 0 2.25-2.25V15"/>

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M18 8.25 21.75 12 18 15.75M21.75 12H9.75"/>

                    </svg>

                    <span>Logout</span>

                </button>
            </form>

        </div>

    </aside>


    {{-- KONTEN UTAMA --}}
    <div class="min-h-screen lg:ml-64">


        {{-- TOPBAR --}}
        <header class="sticky top-0 z-30
                       flex min-h-20 items-center justify-between
                       border-b border-green-100
                       bg-white px-4 shadow-sm
                       sm:px-6 lg:px-8">

            <div class="flex items-center gap-3">


                {{-- Tombol menu HP --}}
                <button type="button"
                        @click="sidebarOpen = true"
                        class="rounded-lg p-2 text-green-800
                               hover:bg-green-50 lg:hidden"
                        aria-label="Buka menu">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke-width="2"
                         stroke="currentColor"
                         class="h-6 w-6">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M4 6h16M4 12h16M4 18h16"/>

                    </svg>

                </button>


                <div>

                    <h2 class="text-lg font-bold text-green-900
                               sm:text-xl">

                        {{ $header ?? 'Dashboard Admin' }}

                    </h2>

                    <p class="hidden text-sm text-gray-500 sm:block">
                        Sistem Manajemen Praktik Dokter Gigi
                    </p>

                </div>

            </div>


            {{-- USER TOPBAR --}}
            <div class="flex items-center gap-3">

                <div class="hidden text-right sm:block">

                    <p class="text-sm font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-green-700">
                        Administrator
                    </p>

                </div>


                <div class="flex h-10 w-10
                            items-center justify-center
                            rounded-full bg-green-100
                            font-bold text-green-800">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            </div>

        </header>


        {{-- ISI HALAMAN --}}
        <main class="min-w-0 p-4 sm:p-6 lg:p-8">

            {{ $slot }}

        </main>

    </div>

</div>

</body>
</html>