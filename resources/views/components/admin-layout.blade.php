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
               transition-transform duration-200 lg:translate-x-0">

        {{-- Logo --}}
        <div class="flex h-20 shrink-0 items-center gap-3
                    border-b border-green-700 px-5">

            <div class="flex h-11 w-11 items-center justify-center
                        rounded-xl bg-green-500 text-2xl shadow-md">
                🦷
            </div>

            <div>
                <h1 class="text-xl font-bold">DentalCare</h1>
                <p class="text-xs text-green-200">Klinik Gigi</p>
            </div>

            <button type="button"
                    @click="sidebarOpen = false"
                    class="ml-auto text-xl lg:hidden"
                    aria-label="Tutup menu">
                &times;
            </button>
        </div>

        {{-- MENU ADMIN --}}
        @php
            $menus = [
                [
                    'label' => 'Dashboard',
                    'icon' => '📊',
                    'route' => 'admin.dashboard',
                    'active' => 'admin.dashboard',
                ],
                [
                    'label' => 'Data Dokter',
                    'icon' => '👨‍⚕️',
                    'route' => 'admin.doctors.index',
                    'active' => 'admin.doctors.*',
                ],
                [
                    'label' => 'Data Pasien',
                    'icon' => '👥',
                    'route' => 'admin.patients.index',
                    'active' => 'admin.patients.*',
                ],
                [
                    'label' => 'Jadwal Praktik',
                    'icon' => '🗓️',
                    'route' => 'admin.schedules.index',
                    'active' => 'admin.schedules.*',
                ],
                [
                    'label' => 'Appointment',
                    'icon' => '📅',
                    'route' => 'admin.appointments.index',
                    'active' => 'admin.appointments.*',
                ],
                [
                    'label' => 'Rekam Medis',
                    'icon' => '📋',
                    'route' => 'admin.dental-records.index',
                    'active' => 'admin.dental-records.*',
                ],
                [
                    'label' => 'Tarif Tindakan',
                    'icon' => '💰',
                    'route' => 'admin.treatments.index',
                    'active' => 'admin.treatments.*',
                ],
                [
                    'label' => 'Data Obat',
                    'icon' => '💊',
                    'route' => 'admin.medicines.index',
                    'active' => 'admin.medicines.*',
                ],
                [
                    'label' => 'Tagihan',
                    'icon' => '🧾',
                    'route' => 'admin.billings.index',
                    'active' => 'admin.billings.*',
                ],
                [
                    'label' => 'Pembayaran',
                    'icon' => '💳',
                    'route' => 'admin.payments.index',
                    'active' => 'admin.payments.*',
                ],
                [
                    'label' => 'Riwayat Login',
                    'icon' => '🔐',
                    'route' => 'admin.login-histories.index',
                    'active' => 'admin.login-histories.*',
                ],
            ];
        @endphp

        <nav class="min-h-0 flex-1 space-y-1
                    overflow-y-auto px-3 py-5">

            <p class="mb-3 px-4 text-xs font-semibold
                      uppercase tracking-wider text-green-200">
                Menu Admin
            </p>

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

                    <span class="w-6 text-center text-lg">
                        {{ $menu['icon'] }}
                    </span>

                    <span>{{ $menu['label'] }}</span>
                </a>
            @endforeach

        </nav>

        {{-- Profil administrator --}}
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

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full rounded-xl
                               border border-green-600
                               px-4 py-2.5 text-left text-sm
                               font-medium text-green-100
                               transition
                               hover:border-red-500
                               hover:bg-red-600
                               hover:text-white">
                    🚪 &nbsp; Logout
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

                <button type="button"
                        @click="sidebarOpen = true"
                        class="rounded-lg p-2 text-green-800
                               hover:bg-green-50 lg:hidden"
                        aria-label="Buka menu">
                    ☰
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