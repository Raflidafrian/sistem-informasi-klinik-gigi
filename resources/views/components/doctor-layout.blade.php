<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'DentalCare - Dokter' }}</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>


<body class="bg-gray-100 text-gray-900">

    <div class="min-h-screen flex">

        {{-- ========================================= --}}
        {{-- SIDEBAR DOKTER --}}
        {{-- ========================================= --}}

        <aside class="w-64 bg-slate-900 text-white fixed inset-y-0 left-0">

            {{-- LOGO --}}

            <div class="h-20 flex items-center px-6 border-b border-slate-700">

                <div class="flex items-center gap-3">

                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-xl">
                        🦷
                    </div>

                    <div>

                        <h1 class="font-bold text-lg">
                            DentalCare
                        </h1>

                        <p class="text-xs text-slate-400">
                            Klinik Gigi
                        </p>

                    </div>

                </div>

            </div>


            {{-- ========================================= --}}
            {{-- MENU --}}
            {{-- ========================================= --}}

            <nav class="p-4 space-y-2">


                {{-- Dashboard --}}

                <a
                    href="{{ route('dokter.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                    {{ request()->routeIs('dokter.dashboard')
                        ? 'bg-blue-600 text-white shadow-md'
                        : 'text-slate-300 hover:bg-slate-800' }}"
                >

                    <span>📊</span>

                    <span>
                        Dashboard
                    </span>

                </a>


                {{-- Appointment --}}

                <a
                    href="{{ route('dokter.appointments.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                    {{ request()->routeIs('dokter.appointments.*')
                        ? 'bg-blue-600 text-white shadow-md'
                        : 'text-slate-300 hover:bg-slate-800' }}"
                >

                    <span>📅</span>

                    <span>
                        Appointment
                    </span>

                </a>


                {{-- Antrian Pasien --}}

                <a
                    href="{{ route('dokter.queue.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                    {{ request()->routeIs('dokter.queue.*')
                        ? 'bg-blue-600 text-white shadow-md'
                        : 'text-slate-300 hover:bg-slate-800' }}"
                >

                    <span>👥</span>

                    <span>
                        Antrian Pasien
                    </span>

                </a>


                {{-- Rekam Medis --}}

                <a
                    href="{{ route('dokter.dental-records.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                    {{ request()->routeIs('dokter.dental-records.*')
                        ? 'bg-blue-600 text-white shadow-md'
                        : 'text-slate-300 hover:bg-slate-800' }}"
                >

                    <span>📋</span>

                    <span>
                        Rekam Medis
                    </span>

                </a>


                {{-- Odontogram --}}

                <a
                    href="{{ route('dokter.odontogram.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                    {{ request()->routeIs('dokter.odontogram*')
                        ? 'bg-blue-600 text-white shadow-md'
                        : 'text-slate-300 hover:bg-slate-800' }}"
                >

                    <span>🦷</span>

                    <span>
                        Odontogram
                    </span>

                </a>


                {{-- Resep Obat --}}

                <a
                    href="#"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-200
                    {{ request()->is('dokter/prescriptions*')
                        ? 'bg-blue-600 text-white shadow-md'
                        : 'text-slate-300 hover:bg-slate-800' }}"
                >

                    <span>💊</span>

                    <span>
                        Resep Obat
                    </span>

                </a>

            </nav>


            {{-- ========================================= --}}
            {{-- USER --}}
            {{-- ========================================= --}}

            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-700">

                <div class="flex items-center gap-3 mb-3">

                    <div class="w-10 h-10 bg-slate-700 rounded-full flex items-center justify-center">

                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                    </div>


                    <div class="overflow-hidden">

                        <p class="font-semibold truncate">

                            {{ auth()->user()->name }}

                        </p>

                        <p class="text-xs text-slate-400">

                            Dokter Gigi

                        </p>

                    </div>

                </div>


                {{-- Logout --}}

                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg text-slate-300 hover:bg-red-600 hover:text-white"
                    >

                        🚪 Logout

                    </button>

                </form>

            </div>

        </aside>


        {{-- ========================================= --}}
        {{-- CONTENT --}}
        {{-- ========================================= --}}

        <main class="ml-64 flex-1 min-h-screen">


            {{-- TOPBAR --}}

            <header class="bg-white border-b border-gray-200 h-20 flex items-center justify-between px-8">

                <div>

                    <h2 class="text-xl font-bold">

                        {{ $header ?? 'Dashboard Dokter' }}

                    </h2>

                    <p class="text-sm text-gray-500">

                        Sistem Manajemen Praktik Dokter Gigi

                    </p>

                </div>


                <div class="text-right">

                    <p class="font-semibold">

                        {{ auth()->user()->name }}

                    </p>

                    <p class="text-xs text-gray-500">

                        Dokter Gigi

                    </p>

                </div>

            </header>


            {{-- ========================================= --}}
            {{-- PAGE CONTENT --}}
            {{-- ========================================= --}}

            <section class="p-8">

                {{ $slot }}

            </section>

        </main>

    </div>

</body>

</html>
